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
        <h1>Dokter</h1>

        <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary mb-3">Tambah Dokter</a>
        <a href="{{ route('admin.dokter.search') }}" class="btn btn-info mb-3">Cari Dokter</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID Dokter</th>
                    <th scope="col">Nama Dokter</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No HP</th>
                    <th scope="col">Nama Poli</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dokter as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td>{{ $d->no_hp }}</td>
                        <td>{{ $d->poli->nama_poli }}</td>
                        <td>
                            <a href="{{ route('admin.dokter.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form id="delete-form-{{ $d->id }}" action="{{ route('admin.dokter.hapus', $d->id) }}" method="POST"
    style="display:none;">
    @csrf
    @method('DELETE')
</form>
<button onclick="confirmDelete('{{ $d->id }}')" class="btn btn-danger btn-sm">Hapus</button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    @endsection
