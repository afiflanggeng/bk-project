@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #b3e5fc;">
        <div class="card shadow-lg border-0" style="width: 100%; max-width: 400px;">
            <div class="card-header text-center" style="background-color: #0288d1; color: white;">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('login_pasien.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name_or_nr_medis" class="form-label">Name</label>
                        <input type="text" name="name_or_nr_medis" id="name_or_nr_medis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn w-100 text-white" style="background-color: #a40000; border: none;">
                        Login
                    </button>

                    <a href="{{ route('welcome') }}" class="btn btn-warning">Kembali</a>
                </form>
                @if (session('error'))
                    <div class="mt-3 alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
