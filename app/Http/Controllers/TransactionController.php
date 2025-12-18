<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Menampilkan Dashboard & List & Grafik
    public function index()
    {
        // 1. Hitung Saldo Real-time
        $saldoBesar = Transaction::where('wallet_type', 'besar')->where('type', 'in')->sum('amount')
                    - Transaction::where('wallet_type', 'besar')->where('type', 'out')->sum('amount');

        $saldoKecil = Transaction::where('wallet_type', 'kecil')->where('type', 'in')->sum('amount')
                    - Transaction::where('wallet_type', 'kecil')->where('type', 'out')->sum('amount');

        // 2. Ambil Riwayat Transaksi (Tabel)
        $transactions = Transaction::latest()->paginate(10);

        // 3. --- LOGIKA GRAFIK (7 Hari Terakhir) ---
        $chartLabels = [];
        $chartIncome = [];
        $chartExpense = [];

        // Loop 7 hari ke belakang
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->format('Y-m-d');

            // Label Tanggal (Cth: 17 Dec)
            $chartLabels[] = $date->format('d M');

            // Total Pemasukan Hari Itu
            $income = Transaction::whereDate('transaction_date', $formattedDate)
                        ->where('type', 'in')
                        ->sum('amount');
            $chartIncome[] = $income;

            // Total Pengeluaran Hari Itu
            $expense = Transaction::whereDate('transaction_date', $formattedDate)
                        ->where('type', 'out')
                        ->sum('amount');
            $chartExpense[] = $expense;
        }

        return view('dashboard', compact(
            'saldoBesar',
            'saldoKecil',
            'transactions',
            'chartLabels',
            'chartIncome',
            'chartExpense'
        ));
    }

    // Fungsi Simpan Transaksi
    public function store(Request $request)
    {
        $request->validate([
            'wallet_type' => 'required|in:besar,kecil',
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:1000',
            'description' => 'required|string',
            'transaction_date' => 'required|date',
            'proof_image' => 'required|image|max:2048',
        ]);

        // LOGIKA LIMIT KAS KECIL
        if ($request->wallet_type == 'kecil' && $request->type == 'out') {
            $todayExpense = Transaction::where('wallet_type', 'kecil')
                            ->where('type', 'out')
                            ->whereDate('transaction_date', $request->transaction_date)
                            ->sum('amount');

            if (($todayExpense + $request->amount) > 500000) {
                return back()->withErrors(['amount' => 'Gagal! Limit pengeluaran Kas Kecil max Rp 500.000 per hari. Sisa limit: Rp ' . number_format(500000 - $todayExpense)]);
            }
        }

        $path = $request->file('proof_image')->store('proofs', 'public');

        Transaction::create([
            'user_id' => Auth::id(),
            'no_bukti' => 'TRX-' . time(),
            'wallet_type' => $request->wallet_type,
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'proof_image' => $path,
            'transaction_date' => $request->transaction_date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan!');
    }

    // Fungsi Transfer
    public function transfer(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Uang Keluar dari Kas Besar
            Transaction::create([
                'user_id' => Auth::id(),
                'no_bukti' => 'TRF-OUT-' . time(),
                'wallet_type' => 'besar',
                'type' => 'out',
                'amount' => $request->amount,
                'description' => 'Transfer ke Kas Kecil: ' . $request->description,
                'transaction_date' => now(),
                'proof_image' => null,
            ]);

            // 2. Uang Masuk ke Kas Kecil
            Transaction::create([
                'user_id' => Auth::id(),
                'no_bukti' => 'TRF-IN-' . time(),
                'wallet_type' => 'kecil',
                'type' => 'in',
                'amount' => $request->amount,
                'description' => 'Terima dari Kas Besar: ' . $request->description,
                'transaction_date' => now(),
                'proof_image' => null,
            ]);
        });

        return back()->with('success', 'Transfer dana berhasil!');
    }

    // Print Laporan
    public function printReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $transactions = Transaction::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                            return $query->whereBetween('transaction_date', [$startDate, $endDate]);
                        })
                        ->orderBy('transaction_date', 'asc')
                        ->get();

        return view('report-print', compact('transactions', 'startDate', 'endDate'));
    }
    // --- UPDATE TRANSAKSI (EDIT) ---
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'required|string',
            'transaction_date' => 'required|date',
            'proof_image' => 'nullable|image|max:2048',
        ]);

        // Cek jika user upload foto baru
        if ($request->hasFile('proof_image')) {
            // Hapus foto lama agar server tidak penuh
            if ($transaction->proof_image) {
                Storage::disk('public')->delete($transaction->proof_image);
            }
            // Simpan foto baru
            $path = $request->file('proof_image')->store('proofs', 'public');
            $transaction->proof_image = $path;
        }

        // Update Data Database
        $transaction->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diperbarui!');
    }

    // --- HAPUS TRANSAKSI ---
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Hapus file fisik foto bukti
        if ($transaction->proof_image) {
            Storage::disk('public')->delete($transaction->proof_image);
        }

        $transaction->delete();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus.');
    }
}
