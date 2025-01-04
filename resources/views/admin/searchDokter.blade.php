@extends('layouts.main')

@section('content')
    <div class="container mt-5" style="background-color: #b3e5fc; padding: 20px; border-radius: 10px;">
        <h1>Pencarian Dokter</h1>

        <form action="{{ route('admin.dokter.search') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cari Dokter"
                       value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        @if($dokter->isEmpty())
            <p class="text-center">Tidak ada dokter yang ditemukan.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Dokter</th>
                        <th>Nama Dokter</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Nama Poli</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dokter as $d)
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->alamat }}</td>
                            <td>{{ $d->no_hp }}</td>
                            <td>{{ $d->poli->nama_poli ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.dokter.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.dokter.hapus', $d->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <a href="{{ route('admin.dokter') }}" class="btn btn-primary">Kembali ke Daftar Dokter</a>
    </div>
@endsection
