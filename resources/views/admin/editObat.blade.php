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
        <h2>Edit Data Obat</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" class="form-control" id="nama_obat" name="nama_obat"
                    value="{{ old('nama_obat', $obat->nama_obat) }}" required>
            </div>

            <div class="form-group">
                <label for="kemasan">Kemasan</label>
                <input type="text" class="form-control" id="kemasan" name="kemasan"
                    value="{{ old('alamat', $obat->kemasan) }}" required>
            </div>

            <div class="form-group">
                <label for="no_hp">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga"
                    value="{{ old('harga', $obat->harga) }}" required>
            </div>

            <button type="submit" class="btn" style="background-color: #a40000; color: white;">Edit</button>
            <a href="{{ route('admin.dokter') }}" class="btn" style="background-color: #0277bd; color: white;">Batal</a>
        </form>
    </div>
@endsection
