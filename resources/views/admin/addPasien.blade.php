@extends('layouts.main')

@section('navbar')
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0288d1;">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">KlinikApp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.poli') }}">Poli</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dokter') }}">Dokter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.pasien') }}">Pasien</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.obat') }}">Obat</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
@endsection

@section('content')
    <div class="container mt-5" style="background-color: #b3e5fc; padding: 20px; border-radius: 10px;">
        <h2>Tambah Pasien</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pasien.add') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="no_ktp">No KTP</label>
                <input type="text" class="form-control" id="no_ktp" name="no_ktp" required>
            </div>

            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
            </div>

            <button type="submit" class="btn" style="background-color: blue; color: white;">Tambah</button>
            <a href="{{ route('admin.poli') }}" class="btn" style="background-color: red; color: white;">Batal</a>
        </form>
    </div>
@endsection
