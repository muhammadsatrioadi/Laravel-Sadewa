@extends('layouts.app')

@section('loginContent')
<div id="app">
    <section class="section" style="background-image: url('{{ asset('assets/img/bg.login.jpg') }}'); background-size: cover; background-position: center; height: 94vh; margin: 100; padding: 5;">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
					<br>
					<br>
<div class="text-center mb-4">
    <h3 class="custom-title">RSKIA SADEWA</h3>
    <p class="custom-subtitle">Sistem Aset</p>
</div>

<style>
    .custom-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 3.5rem;
        color: #AFEEEE; /* Hijau Muda */
        text-shadow: 2px 2px 3px #000000, -2px -2px 3px #000000; /* Garis hitam di dalam huruf */
        margin-bottom: 9px;
        white-space: nowrap; /* Pastikan teks tetap dalam satu baris */
    }

    .custom-subtitle {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 1.50rem;
        color: #AFEEEE; /* Hijau Muda */
        text-shadow: 2px 2px 3px #000000, -2px -2px 3px #000000; /* Garis hitam di dalam huruf */
    }
</style>


                    <div class="card card-primary shadow">
                        <div class="card-header"><h4>Silakan login untuk melanjutkan</h4></div>

                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                @csrf

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                        </div>
                                        <input id="email" type="email" class="form-control" name="email"
                                            placeholder="Masukkan Email" required autofocus>
                                        <div class="invalid-feedback">
                                            Silakan masukkan email yang valid.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="d-block">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            placeholder="Masukkan Password" required>
                                        <div class="invalid-feedback">
                                            Silakan masukkan password.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Ingat Saya</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        Login
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="simple-footer text-center mt-3 text-white">
                        &copy; {{ date('Y') }} Aplikasi Inventaris
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
