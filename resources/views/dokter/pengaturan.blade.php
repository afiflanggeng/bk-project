@include('dokter.navdokter')
<div class="container">
    <p class="text-center" style="font-size: 35px"><b>Pengaturan Akun Dokter</b></p>
    <form method="POST" action="{{ route('dokter.updateAkun') }}">
        @csrf
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $dokter->nama }}">
        </div>
        <div class="form-group">
            <label for="id_poli">Poli</label>
            <select class="form-control" id="id_poli" name="id_poli">
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id }}"
                        {{ old('poli', $dokter->id_poli ?? '') == $poli->id ? 'selected' : '' }}>{{ $poli->nama_poli }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ $user->password }}">
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-danger">Kembali</a>
    </form>
</div>
