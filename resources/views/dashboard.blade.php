@extends('layouts.app')

@section('content')
<div x-data="{
    showTransactionModal: false,
    showTransferModal: false,
    showEditModal: false,

    // Variabel untuk Edit
    editFormAction: '',
    editAmount: '',
    editDate: '',
    editDesc: '',

    // Fungsi Mengisi Data Edit
    editData(trx) {
        this.editFormAction = '{{ url('/transaction') }}/' + trx.id;
        this.editAmount = trx.amount;
        this.editDate = trx.transaction_date.split('T')[0];
        this.editDesc = trx.description;
        this.showEditModal = true;
    }
}">

    <div class="row mb-4">
        <div class="col-12">
            <h4 class="font-weight-bolder text-white mb-0">Overview Keuangan</h4>
            <p class="text-sm text-white opacity-8">Pantau arus kas perusahaan secara real-time.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card bg-gradient-dark shadow-lg">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold text-white opacity-7">Saldo Kas Besar</p>
                                <h4 class="font-weight-bolder text-white mb-0 mt-1">
                                    Rp {{ number_format($saldoBesar, 0, ',', '.') }}
                                </h4>
                                <span class="badge badge-sm bg-success mt-2">Unlimited Access</span>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                <i class="ni ni-building text-dark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden border-radius-xl" style="pointer-events: none;">
                    <span class="mask bg-gradient-dark opacity-1"></span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Saldo Kas Kecil</p>
                                <h4 class="font-weight-bolder text-dark mb-0 mt-1">
                                    Rp {{ number_format($saldoKecil, 0, ',', '.') }}
                                </h4>
                                <span class="text-xs font-weight-bold text-danger mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i> Limit: 500rb/hari
                                </span>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="col-xl-4 col-sm-12">
            <div class="row">
                <div class="col-6">
                    <div class="card h-100 card-plain border border-dashed border-secondary cursor-pointer hover-scale"
                         @click="showTransactionModal = true">
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <i class="ni ni-fat-add text-secondary text-3xl mb-2"></i>
                            <span class="text-xs font-weight-bold text-uppercase text-secondary">Input Transaksi</span>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card h-100 card-plain border border-dashed border-secondary cursor-pointer hover-scale"
                         @click="showTransferModal = true">
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <i class="ni ni-curved-next text-secondary text-3xl mb-2"></i>
                            <span class="text-xs font-weight-bold text-uppercase text-secondary">Transfer Kas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->role === 'manager')
        <div class="col-xl-4 col-sm-12">
            <div class="card h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <form action="{{ route('report.print') }}" method="GET" class="w-100">
                        <h6 class="text-xs font-weight-bold text-uppercase text-secondary mb-2">Download Laporan</h6>
                        <div class="d-flex gap-2">
                            <input type="date" name="start_date" class="form-control form-control-sm">
                            <input type="date" name="end_date" class="form-control form-control-sm">
                        </div>
                        <button type="submit" class="btn btn-sm bg-gradient-primary w-100 mt-2 mb-0">
                            <i class="fas fa-print me-1"></i> Cetak PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row mt-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success text-white text-sm opacity-8 mb-3 border-0 shadow-sm">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger text-white text-sm opacity-8 mb-3 border-0 shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="col-lg-12">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Statistik Arus Kas <span class="text-xs text-secondary">(7 Hari Terakhir)</span></h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-bars" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Riwayat Transaksi Terbaru</h6>
                    <span class="badge bg-gradient-light text-dark">Real-time Data</span>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Detail Transaksi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dompet</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nominal</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="avatar avatar-sm me-3 {{ $trx->type == 'in' ? 'bg-gradient-success' : 'bg-gradient-danger' }} rounded-circle shadow-sm d-flex align-items-center justify-content-center">
                                                <i class="fas {{ $trx->type == 'in' ? 'fa-arrow-down' : 'fa-arrow-up' }} text-white text-xs"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ Str::limit($trx->description, 35) }}</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }} • <span class="font-mono">{{ $trx->no_bukti }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm {{ $trx->wallet_type == 'besar' ? 'bg-gradient-dark' : 'bg-gradient-secondary' }}">
                                            {{ ucfirst($trx->wallet_type) }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-sm font-weight-bold {{ $trx->type == 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ $trx->type == 'in' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($trx->proof_image)
                                            <a href="{{ asset('storage/' . $trx->proof_image) }}" target="_blank"
                                               class="btn btn-link text-secondary mb-0 p-1" data-bs-toggle="tooltip" title="Lihat Bukti">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                        @endif

                                        @if(auth()->user()->role === 'admin')
                                            <button type="button" @click="editData({{ $trx }})"
                                                    class="btn btn-link text-dark mb-0 p-1" title="Edit Data">
                                                <i class="fas fa-pencil-alt text-xs"></i>
                                            </button>

                                            <form action="{{ route('transaction.destroy', $trx->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus transaksi ini? Saldo akan terkoreksi otomatis.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger mb-0 p-1" title="Hapus Permanen">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-secondary">Belum ada data transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-3">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="showTransactionModal" style="display: none; position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center;" x-transition.opacity>
            <div class="position-absolute w-100 h-100" style="background-color: rgba(0,0,0,0.4); backdrop-filter: blur(4px);" @click="showTransactionModal = false"></div>
            <div class="card z-index-2 w-100 max-w-500 m-3 shadow-lg" style="max-width: 500px; border-radius: 1rem;">
                <div class="card-header pb-0 text-left bg-transparent border-bottom">
                    <h5 class="font-weight-bolder text-info text-gradient mb-1"><i class="fas fa-plus-circle me-2"></i>Input Transaksi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label text-xs font-weight-bold">Dompet</label>
                                <select name="wallet_type" class="form-control">
                                    <option value="besar">Kas Besar</option>
                                    <option value="kecil">Kas Kecil</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-xs font-weight-bold">Jenis</label>
                                <select name="type" class="form-control">
                                    <option value="out">🔴 Pengeluaran</option>
                                    <option value="in">🟢 Pemasukan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Nominal (Rp)</label>
                            <input type="number" name="amount" class="form-control" placeholder="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Tanggal</label>
                            <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Keterangan</label>
                            <textarea name="description" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Bukti Foto</label>
                            <input type="file" name="proof_image" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" @click="showTransactionModal = false" class="btn btn-light me-2 mb-0">Batal</button>
                            <button type="submit" class="btn bg-gradient-info mb-0">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="showTransferModal" style="display: none; position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center;" x-transition.opacity>
            <div class="position-absolute w-100 h-100" style="background-color: rgba(0,0,0,0.4); backdrop-filter: blur(4px);" @click="showTransferModal = false"></div>
            <div class="card z-index-2 w-100 m-3 shadow-lg" style="max-width: 500px; border-radius: 1rem;">
                <div class="card-header pb-0 text-left bg-transparent border-bottom">
                    <h5 class="font-weight-bolder text-dark text-gradient mb-1"><i class="fas fa-exchange-alt me-2"></i>Transfer Kas</h5>
                    <p class="text-xs text-secondary mb-0">Pindahkan dana dari Kas Besar ke Kas Kecil.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaction.transfer') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Nominal Transfer (Rp)</label>
                            <input type="number" name="amount" class="form-control" placeholder="1000000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Catatan</label>
                            <input type="text" name="description" class="form-control" placeholder="Topup operasional mingguan" required>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" @click="showTransferModal = false" class="btn btn-light me-2 mb-0">Batal</button>
                            <button type="submit" class="btn bg-gradient-dark mb-0">Proses Transfer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="showEditModal" style="display: none; position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center;" x-transition.opacity>
            <div class="position-absolute w-100 h-100" style="background-color: rgba(0,0,0,0.4); backdrop-filter: blur(4px);" @click="showEditModal = false"></div>
            <div class="card z-index-2 w-100 m-3 shadow-lg" style="max-width: 500px; border-radius: 1rem;">
                <div class="card-header pb-0 text-left bg-transparent border-bottom">
                    <h5 class="font-weight-bolder text-warning text-gradient mb-1"><i class="fas fa-pencil-alt me-2"></i>Edit Transaksi</h5>
                    <p class="text-xs text-secondary mb-0">Perbaiki kesalahan input nominal atau keterangan.</p>
                </div>
                <div class="card-body">
                    <form :action="editFormAction" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Nominal (Rp)</label>
                            <input type="number" name="amount" class="form-control" x-model="editAmount" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Tanggal</label>
                            <input type="date" name="transaction_date" class="form-control" x-model="editDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Keterangan</label>
                            <textarea name="description" class="form-control" rows="2" x-model="editDesc" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Ganti Bukti Foto (Opsional)</label>
                            <input type="file" name="proof_image" class="form-control">
                            <small class="text-xxs text-secondary">*Biarkan kosong jika tidak ingin mengganti foto.</small>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" @click="showEditModal = false" class="btn btn-light me-2 mb-0">Batal</button>
                            <button type="submit" class="btn bg-gradient-warning mb-0">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.03); }
    .form-label { margin-bottom: 0.3rem; color: #344767; }
</style>
@endsection

@push('dashboard-scripts')
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
    var ctx = document.getElementById("chart-bars").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                { label: "Pemasukan", tension: 0.4, borderWidth: 0, borderRadius: 4, borderSkipped: false, backgroundColor: "#3A416F", data: {!! json_encode($chartIncome) !!}, maxBarThickness: 10 },
                { label: "Pengeluaran", tension: 0.4, borderWidth: 0, borderRadius: 4, borderSkipped: false, backgroundColor: "#cb0c9f", data: {!! json_encode($chartExpense) !!}, maxBarThickness: 10 },
            ],
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: true, position: 'top', align: 'end', labels: { usePointStyle: true, pointStyle: 'circle' } } },
            interaction: { intersect: false, mode: 'index' },
            scales: {
                y: { grid: { drawBorder: false, display: true, drawOnChartArea: true, drawTicks: false, borderDash: [5, 5] }, ticks: { suggestedMin: 0, beginAtZero: true, padding: 10, font: { size: 11, family: "Open Sans", style: 'normal', lineHeight: 2 }, color: "#9ca2b7" } },
                x: { grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false }, ticks: { display: true, color: '#9ca2b7' } },
            },
        },
    });
</script>
@endpush
