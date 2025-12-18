<x-guest-layout>
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Gabung Bersama Kami</h3>
                                <p class="mb-0">Isi data di bawah untuk membuat akun baru.</p>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger text-white text-xs mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form role="form" method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <label>Nama Lengkap</label>
                                    <div class="mb-3">
                                        <input type="text" name="name" class="form-control" placeholder="Nama Anda" aria-label="Name" aria-describedby="name-addon" required autofocus>
                                    </div>

                                    <label>Email</label>
                                    <div class="mb-3">
                                        <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" required>
                                    </div>

                                    <label>Password</label>
                                    <div class="mb-3">
                                        <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon" required>
                                    </div>

                                    <label>Konfirmasi Password</label>
                                    <div class="mb-3">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" aria-label="Password" aria-describedby="password-addon" required>
                                    </div>

                                    <div class="form-check form-check-info text-left">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Saya setuju dengan <a href="javascript:;" class="text-dark font-weight-bolder">Syarat & Ketentuan</a>
                                        </label>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Daftar Sekarang</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}" class="text-info text-gradient font-weight-bold">Masuk (Sign In)</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                 style="background-image:url('{{ asset('assets/img/curved-images/pelindo1.jpeg') }}')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
