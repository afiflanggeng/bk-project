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
        <h2>Edit Data Dokter</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama Dokter</label>
                <input type="text" class="form-control" id="nama" name="nama"
                    value="{{ old('nama', $dokter->nama) }}" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat"
                    value="{{ old('alamat', $dokter->alamat) }}" required>
            </div>

            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp"
                    value="{{ old('no_hp', $dokter->no_hp) }}" required>
            </div>

            <div class="form-group">
                <label for="poli_id">Poli</label>
                <select class="form-control" id="poli_id" name="poli_id" required>
                    <option value="">Pilih Poli</option>
                    @foreach ($polis as $poli)
                        <option value="{{ $poli->id }}"
                            {{ old('poli_id', $dokter->poli_id) == $poli->id ? 'selected' : '' }}>
                            {{ $poli->nama_poli }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn" style="background-color: #a40000; color: white;">Edit</button>
            <a href="{{ route('admin.dokter') }}" class="btn" style="background-color: #0277bd; color: white;">Batal</a>
        </form>
    </div>
@endsection
