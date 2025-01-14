@include('dokter.navdokter')  
<div class="container mt-4">  
    <h2 class="text-center mb-4">Jadwal Dokter</h2>  
    @if(session('success'))  
        <div class="alert alert-success">  
            {{ session('success') }}  
        </div>  
    @endif  
    <table class="table table-striped table-bordered">  
        <thead class="thead-dark">  
            <tr>  
                <th>Hari</th>  
                <th>Jam Mulai</th>  
                <th>Jam Selesai</th>  
                <th>Status</th>  
                <th>Aksi</th>  
            </tr>  
        </thead>  
        <tbody>  
            @foreach($jadwal as $item)  
            <tr>  
                <td>{{ ucfirst($item->hari) }}</td>  
                <td>{{ $item->jam_mulai }}</td>  
                <td>{{ $item->jam_selesai }}</td>  
                <td>  
                    <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-danger' }}">  
                        {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}  
                    </span>  
                </td>  
                <td>  
                    <form method="POST" action="{{ route('dokter.updateJadwal', $item->id) }}" style="display:inline;">  
                        @csrf  
                        @method('PUT')  
                        <input type="hidden" name="aktif" value="{{ $item->aktif ? 0 : 1 }}">  
                        <button type="submit" class="btn btn-warning btn-sm">  
                            {{ $item->aktif ? 'Nonaktifkan' : 'Aktifkan' }}  
                        </button>  
                    </form>  
                    <form method="POST" action="{{ route('dokter.deleteJadwal', $item->id) }}" style="display:inline;" class="delete-form">  
                        @csrf  
                        @method('DELETE')  
                        <button type="button" class="btn btn-danger btn-sm delete-btn">Hapus</button>  
                    </form>  
                </td>  
            </tr>  
            @endforeach  
        </tbody>  
    </table>  
</div>  
  
<!-- SweetAlert Script -->  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
<script>  
    document.querySelectorAll('.delete-btn').forEach(button => {  
        button.addEventListener('click', function() {  
            const form = this.closest('.delete-form');  
            Swal.fire({  
                title: 'Apakah Anda yakin?',  
                text: "Jadwal ini akan dihapus!",  
                icon: 'warning',  
                showCancelButton: true,  
                confirmButtonColor: '#3085d6',  
                cancelButtonColor: '#d33',  
                confirmButtonText: 'Ya, hapus!',  
                cancelButtonText: 'Batal'  
            }).then((result) => {  
                if (result.isConfirmed) {  
                    form.submit();  
                }  
            });  
        });  
    });  
</script>  
