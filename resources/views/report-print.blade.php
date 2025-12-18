<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - {{ date('d M Y') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <style>
        /* Reset & Base Style untuk Cetak */
        body {
            font-family: 'Open Sans', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            color: #2d3748;
        }
        .header p {
            margin: 5px 0 0;
            color: #718096;
        }

        /* Tabel Style */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }
        th {
            background-color: #f7fafc;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            color: #4a5568;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Warna Status */
        .text-success { color: #38a169; font-weight: bold; }
        .text-danger { color: #e53e3e; font-weight: bold; }
        .text-right { text-align: right; }

        /* Footer Tanda Tangan */
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            width: 200px;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #333;
        }

        /* Tombol (Hilang saat diprint) */
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #fff;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 12px;
        }
        .btn-print { background-color: #3182ce; color: white; }
        .btn-back { background-color: #718096; color: white; }

        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.history.back()" class="btn btn-back">⬅ Kembali</button>
        <button onclick="window.print()" class="btn btn-print">🖨 Cetak PDF</button>
    </div>

    <div class="header">
        <h1>Laporan Arus Kas Internal</h1>
        <p>Finance Department System</p>
        <p style="font-size: 11px; margin-top: 5px;">
            Periode: <strong>{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }}</strong>
            s/d
            <strong>{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}</strong>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 15%">No Bukti</th>
                <th style="width: 10%">Kas</th>
                <th style="width: 30%">Keterangan</th>
                <th style="width: 10%">Jenis</th>
                <th class="text-right" style="width: 20%">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalMasuk = 0; $totalKeluar = 0; @endphp
            @forelse($transactions as $trx)
            <tr>
                <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y') }}</td>
                <td>{{ $trx->no_bukti }}</td>
                <td>{{ ucfirst($trx->wallet_type) }}</td>
                <td>{{ $trx->description }}</td>
                <td>
                    <span class="{{ $trx->type == 'in' ? 'text-success' : 'text-danger' }}">
                        {{ $trx->type == 'in' ? 'Pemasukan' : 'Pengeluaran' }}
                    </span>
                </td>
                <td class="text-right">{{ number_format($trx->amount, 0, ',', '.') }}</td>
            </tr>
            @php
                if($trx->type == 'in') $totalMasuk += $trx->amount;
                else $totalKeluar += $trx->amount;
            @endphp
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>

        @if(count($transactions) > 0)
        <tfoot>
            <tr style="background-color: #edf2f7;">
                <td colspan="5" class="text-right"><strong>TOTAL PEMASUKAN</strong></td>
                <td class="text-right text-success"><strong>Rp {{ number_format($totalMasuk, 0, ',', '.') }}</strong></td>
            </tr>
            <tr style="background-color: #edf2f7;">
                <td colspan="5" class="text-right"><strong>TOTAL PENGELUARAN</strong></td>
                <td class="text-right text-danger"><strong>Rp {{ number_format($totalKeluar, 0, ',', '.') }}</strong></td>
            </tr>
            <tr style="background-color: #2d3748; color: white;">
                <td colspan="5" class="text-right"><strong>SISA SALDO (NET)</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <p>Dicetak pada: {{ date('d F Y') }}</p>
            <br>
            <p>Mengetahui,</p>
            <div class="signature-line"></div>
            <p><strong>Manajer Keuangan</strong></p>
        </div>
    </div>

</body>
</html>
