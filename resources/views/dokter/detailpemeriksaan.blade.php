@include('dokter.navdokter')
<div class="container">
    <p class="text-center" style="font-size: 35px"><b>Detail Pemeriksaan</b></p>
    <p>Nama : {{ $datapoli[0]->pasien->nama }} </p>
    <p>Nomor Telepon : {{ $datapoli[0]->pasien->no_hp }} </p>
    <hr>
    <form method="POST" action="{{ route('dokter.simpanpemeriksaan') }}">
        {{ csrf_field() }}
        <input type="hidden" value="{{ request()->get('id') }}" name="idperiksa">
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Biaya Pemeriksaan</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="inputPassword" placeholder="Nominal Pemeriksaan"
                    name="nominal" required>
            </div>
        </div>
        <p style="font-size: 20px"><b>List Obat</b></p>
        <div id="pembungkusobat">
            <div class="form-group row">
                <div class="col-sm-12">
                    <select class="form-control" name="namaobat[]" required>
                        <?= $dataobat ?>
                    </select>
                </div>
            </div>
        </div>
        <div style="width:100%;display:flex;justify-content:center">
            <button type="button" class="btn btn-primary" onclick="tambahobat()">+</button>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Catatan Medis</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="catatan" required></textarea>
        </div>
        <div style="width:100%;display:flex;justify-content:center">
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>
<script>
    function tambahobat() {
        var elembaru = document.createElement("div")
        elembaru.setAttribute("class", "form-group row")
        elembaru.innerHTML = `<div class="col-sm-10">
                    <select class="form-control" name="namaobat[]">
                        <?= $dataobat ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-danger" onclick="delobat(event)">-</button>
                </div>`
        document.getElementById("pembungkusobat").append(elembaru)
    }

    function delobat(e) {
        console.log(e.target.parentNode.parentNode.remove())
    }
</script>
</body>

</html>
