@include('dokter.navdokter')
<div class="container">
    <form method="POST" action="{{route('dokter.simpanjadwal')}}">
        {{ csrf_field() }}
        <div class="form-group">
            <fieldset>
                <legend>Senin:</legend>
                <?php
                if (isset($datajadwal[0])){
                ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[0]->jam_mulai ?>">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[0]->jam_selesai ?>">
                    <?php
                }else{
                    ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Selasa:</legend>
                <?php
                if (isset($datajadwal[1])){
                ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[1]->jam_mulai ?>">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[1]->jam_selesai ?>">
                    <?php
                }else{
                    ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Rabu:</legend>
                <?php
                if (isset($datajadwal[2])){
                ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[2]->jam_mulai ?>">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[2]->jam_selesai ?>">
                    <?php
                }else{
                    ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Kamis:</legend>
                <?php
                if (isset($datajadwal[3])){
                ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[3]->jam_mulai ?>">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[3]->jam_selesai ?>">
                    <?php
                }else{
                    ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Jumat:</legend>
                <?php
                if (isset($datajadwal[4])){
                ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[4]->jam_mulai ?>">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]" value="<?= $datajadwal[4]->jam_selesai ?>">
                    <?php
                }else{
                    ?>
                    <label for="exampleInputEmail1">Jam Mulai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <label for="exampleInputEmail1">Jam Selesai</label>
                    <input type="time" class="form-control" id="exampleInputEmail1" name="jam[]">
                    <?php
                }
                ?>
            </fieldset>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
