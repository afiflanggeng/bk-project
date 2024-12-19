<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - KlinikApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #b3e5fc;">
        <div class="card shadow-lg border-0" style="width: 100%; max-width: 500px;">
            <div class="card-header text-center" style="background-color: #0288d1; color: white;">
                <h3>Register</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ktp_number" class="form-label">KTP Number</label>
                        <input type="text" name="no_ktp" id="no_ktp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" required>
                    </div>
                    <button type="submit" class="btn w-100 text-white"
                        style="background-color: #a40000; border: none;">
                        Register
                    </button>
                </form>
                @if (session('error'))
                    <div class="mt-3 alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mt-3 text-center">
                    <a href="{{ route('login_pasien') }}" class="btn btn-link">Go to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>