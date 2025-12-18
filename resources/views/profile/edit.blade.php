@extends('layouts.app')

@section('content')
<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

    <div class="page-header min-height-300 border-radius-xl mt-4"
         style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
    </div>

    <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <div class="w-100 h-100 bg-gradient-info rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                        <h3 class="text-white mb-0">{{ substr($user->name, 0, 1) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{ $user->name }}
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                        {{ ucfirst($user->role) }} Finance
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">

            <div class="col-12 col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Informasi Profil</h6>
                    </div>
                    <div class="card-body p-3">
                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success text-white text-xs mb-3">Profil berhasil diperbarui.</div>
                        @endif

                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                @error('name') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                @error('email') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn bg-gradient-dark btn-sm mb-0">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Ganti Password</h6>
                    </div>
                    <div class="card-body p-3">
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success text-white text-xs mb-3">Password berhasil diubah.</div>
                        @endif

                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control">
                                @error('current_password') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control">
                                @error('password') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn bg-gradient-dark btn-sm mb-0">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4 mb-4">
                <div class="card h-100 bg-gradient-danger">
                    <div class="card-header bg-transparent pb-0 p-3">
                        <h6 class="text-white mb-0">Zona Berbahaya</h6>
                    </div>
                    <div class="card-body p-3 text-white">
                        <p class="text-sm opacity-8">
                            Menghapus akun Anda bersifat permanen. Semua data dan riwayat transaksi yang terkait dengan akun ini mungkin terpengaruh.
                        </p>

                        <button type="button" class="btn btn-white text-danger btn-sm mb-0 w-100"
                                onclick="confirmDeletion()">
                            Hapus Akun Saya
                        </button>

                        <form id="delete-account-form" method="post" action="{{ route('profile.destroy') }}" class="d-none">
                            @csrf
                            @method('delete')
                            <input type="password" name="password" id="delete-password" required>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function confirmDeletion() {
        let password = prompt("Masukkan password Anda untuk mengonfirmasi penghapusan akun:");
        if (password) {
            document.getElementById('delete-password').value = password;
            document.getElementById('delete-account-form').submit();
        }
    }
</script>
@endsection
