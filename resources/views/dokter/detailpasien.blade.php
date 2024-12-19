@include('dokter.navdokter')
<div class="container">
    <p class="text-center" style="font-size: 35px"><b>Detail Pasien</b></p>
    <p>Nama : {{ $data['namapasien'] }} </p>
    <p>Nomor Telepon : {{ $data['no_hp'] }}
    <p>
        <hr>
    <p style="font-size: 20px"><b>Riwayat Pemeriksaan</b></p>
    <table class="table table-striped" style="border:2px solid #dee6ed">
        <thead>
            <tr>
                <th scope="col">Catatan</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Obat</th>
                <th scope="col">Biaya Periksa</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data['riwayat'] as $item)
                <tr>
                    <td>{{ $item['catatan'] }}</td>
                    <td>{{ $item['tanggal'] }}</td>
                    <td><?= implode('<br>', $item['obat']) ?></td>
                    <td>Rp {{ $item['biaya'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>

</html>
