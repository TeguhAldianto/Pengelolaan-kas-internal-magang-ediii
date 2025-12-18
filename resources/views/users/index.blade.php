@extends('layouts.app')

@section('content')
<div x-data="{ showUserModal: false }">

    <div class="row">
        <div class="col-12">

            @if(session('success'))
                <div class="alert alert-success text-white text-sm opacity-8 mb-3 border-0 shadow-sm">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger text-white text-sm opacity-8 mb-3 border-0 shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white border-bottom">
                    <div>
                        <h6 class="mb-0 font-weight-bolder">Daftar Pengguna Sistem</h6>
                        <p class="text-sm mb-0 text-secondary">Kelola akses untuk Admin dan Manager.</p>
                    </div>
                    <button @click="showUserModal = true" class="btn bg-gradient-dark btn-sm mb-0 shadow-md hover-scale">
                        <i class="fas fa-plus me-2"></i> Tambah User
                    </button>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengguna</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role (Jabatan)</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Gabung</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <div class="avatar avatar-sm me-3 bg-gradient-{{ $user->role == 'admin' ? 'primary' : 'info' }} rounded-circle d-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm {{ $user->role == 'admin' ? 'bg-gradient-dark' : 'bg-gradient-secondary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="align-middle text-end pe-4">
                                        @if(auth()->id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="tooltip" title="Hapus User">
                                                <i class="far fa-trash-alt me-2"></i>Hapus
                                            </button>
                                        </form>
                                        @else
                                            <span class="badge bg-light text-dark text-xxs">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer py-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="showUserModal"
             style="display: none; position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center;"
             x-transition.opacity>

            <div class="position-absolute w-100 h-100"
                 style="background-color: rgba(0,0,0,0.5); backdrop-filter: blur(2px);"
                 @click="showUserModal = false"></div>

            <div class="card z-index-2 w-100 m-3 shadow-lg" style="max-width: 500px; border-radius: 1rem;">
                <div class="card-header pb-0 text-left bg-transparent border-bottom">
                    <h5 class="font-weight-bolder text-dark text-gradient mb-1">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pengguna
                    </h5>
                    <p class="text-xs text-secondary mb-0">Buat akun baru untuk Admin atau Manager.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Cth: Budi Santoso" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@perusahaan.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 5 karakter" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs font-weight-bold">Role (Hak Akses)</label>
                            <select name="role" class="form-control">
                                <option value="admin">Admin (Akses Penuh: Input & Kelola User)</option>
                                <option value="manager">Manager (Hanya Lihat Dashboard & Laporan)</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" @click="showUserModal = false" class="btn btn-light me-2 mb-0">Batal</button>
                            <button type="submit" class="btn bg-gradient-dark mb-0">Simpan User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
</style>
@endsection
