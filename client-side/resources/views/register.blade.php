<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/x-icon" href="/img/logo.png">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style_login.css">
</head>

<body>

    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="img/draw2.webp" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <h1 class="mb-4">Register</h1>
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" name="name"
                                class="form-control form-control-lg"
                                placeholder="Masukkan Nama" required>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" name="email"
                                class="form-control form-control-lg"
                                placeholder="Masukkan Email" required>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-3">
                            <input type="password" name="password"
                                class="form-control form-control-lg"
                                placeholder="Masukkan Password" required>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-3">
                            <input type="number" name="phone"
                                class="form-control form-control-lg"
                                placeholder="Masukkan Nomor Telepon" required>
                        </div>

                        <p>Apakah kamu sudah punya akun? <a href="{{ route('login') }}">Masuk Disini</a></p>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" name="login" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
