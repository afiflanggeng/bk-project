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
        <h3>Edit Pasien</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama"
                    value="{{ old('nama', $pasien->nama) }}" required>
            </div>

            <div class="form-group">
                <label for="no_ktp">No. KTP</label>
                <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                    value="{{ old('no_ktp', $pasien->no_ktp) }}" required>
            </div>

            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp"
                    value="{{ old('no_hp', $pasien->no_hp) }}" required>
            </div>

            <div class="form-group">
                <label for="no_rm">No. Rekam Medis</label>
                <input type="text" class="form-control" id="no_rm" name="no_rm"
                    value="{{ old('no_rm', $pasien->no_rm) }}" required>
            </div>

            <button type="submit" class="btn" style="background-color: #a40000; color: white;">Edit</button>
            <a href="{{ route('admin.pasien') }}" class="btn" style="background-color: #0277bd; color: white;">Batal</a>
        </form>
    </div>
@endsection
