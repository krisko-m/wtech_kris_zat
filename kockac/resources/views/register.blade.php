<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kockac</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="icon" type="image/x-icon" href="/assets/kocka-tab.png">
  <link rel="stylesheet" type="text/css" href="/css/styles.css" />
  <link rel="stylesheet" type="text/css" href="/css/login.css">
</head>
<body>
    <main>
        <!--Logo at the top-->
        <a href="/index">
            <div class="text-center mt-4">
                <img src="/assets/kockac-logo-rec.png" alt="Kockáč" height="70">
            </div>
        </a>
        <!--Login Card-->
        <div class="d-flex justify-content-center p-4">
            <div class="login-card">
                <h2 class="login-title">Register</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/register">
                    @csrf

                    <!--First & Last Name-->
                    <div class="row gy-3 mb-3">
                        <!--First Name input-->
                        <div class="col-md-6">
                            <input name="first_name" id="first-name" type="text" class="form-control login-input w-100"
                                   placeholder="First Name">
                        </div>

                        <!--Last Name input-->
                        <div class="col-md-6">
                            <input name="last_name" id="last-name" type="text" class="form-control login-input w-100"
                                   placeholder="Last Name">
                        </div>
                    </div>

                    <!--Username input-->
                    <div class="mb-3">
                        <input name="username" id="username" type="text" class="form-control login-input w-100" placeholder="Username">
                    </div>

                    <!--Email input-->
                    <div class="mb-3">
                        <input name="email" id="email" type="text" class="form-control login-input w-100" placeholder="Email">
                    </div>

                    <!--Password input-->
                    <div class="mb-3">
                        <input name="password" type="password" class="form-control login-input w-100" placeholder="Password">
                    </div>

                    <!--Confirmation input-->
                    <div class="mb-3">
                        <input name="password_confirmation" type="password" class="form-control login-input w-100" placeholder="Confirm Password">
                    </div>

                    <!--SignUp Button-->
                    <div class="d-grid gap-2">
                        <button type="submit" class="login-button">SIGN UP</button>
                    </div>
                </form>

                <!--Login link-->
                <div class="text-center mt-3">
                    <a href="/login" class="login-signup">LOG IN</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Back button -->
    <div class="login-back">
        <button onclick="location.href='/index'" class="back-button">Back to Shop</button>
    </div>

    <!--Footer-->
    <footer class="py-4 px-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <a href="/index">
                <img src="/assets/kockac-logo-rec.png" alt="Kockáč" height="50">
            </a>
            <div class="footer-links d-flex gap-4">
                <a href="#">Terms &amp; Conditions</a>
                <a href="#">Privacy Policy</a>
            </div>
            <div class="footer-copy">© 2026 Kockac.com · All rights reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
