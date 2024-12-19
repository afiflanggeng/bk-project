@include('dokter.navdokter')
<div class="container">
    <p style="font-size: 30px" class="text-center">List Pemeriksaan</p>
    <table class="table table-striped" style="border:2px solid #dee6ed">
        <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Keluhan</th>
                <th scope="col">Pilih Tanggal</th>
                <th scope="col">No Antrian</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cntr = 0;
            ?>
            @foreach ($listpasien as $item)
                <?php
                
                if ($datadokter[$cntr] == $getdokter->id && (is_null($item->periksa) || $item->periksa->catatan == "")){
                ?>
                <tr>
                    <td>{{ $item->pasien->nama }}</td>
                    <td>{{ $item->keluhan }}</td>
                    <td>
                        <?php
                        if(is_null($item->periksa)){
                            ?>
                        <form method="POST" action="{{ route('dokter.submittanggal') }}">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $item->id }}" name="id_daftar_poli">
                            <input type="date" name="tgl_periksa">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                        <?php
                        }else{
                            ?>
                        <p>{{ $item->periksa->tgl_periksa }}</p>
                        <?php
                        }
                        $cntr++;
                        ?>
                    </td>
                    <td>{{ $item->no_antrian }}</td>
                    <td><a href="{{ route('dokter.detailpemeriksaaan', ['id' => $item->id]) }}"><img
                                src="https://static.thenounproject.com/png/171127-200.png" width="25"
                                style="cursor: pointer"></a></td>
                </tr>
                <?php
                }
                ?>
            @endforeach
        </tbody>
    </table>
</div>
</body>

</html>
