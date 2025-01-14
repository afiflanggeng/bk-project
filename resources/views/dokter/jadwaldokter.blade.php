@include('dokter.navdokter')  
<div class="container">  
    <h2>Input Jadwal Dokter</h2>  
    
    <form method="POST" action="{{ route('dokter.simpanjadwal') }}">  
        {{ csrf_field() }}  
        <div class="form-group">  
            <label for="hari">Pilih Hari:</label>  
            <select id="hari" name="hari" class="form-control">  
                <option value="">-- Pilih Hari --</option>  
                <option value="senin">Senin</option>  
                <option value="selasa">Selasa</option>  
                <option value="rabu">Rabu</option>  
                <option value="kamis">Kamis</option>  
                <option value="jumat">Jumat</option>  
            </select>  
        </div>  
        <div class="form-group">  
            <label for="jam_mulai">Jam Mulai:</label>  
            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>  
        </div>  
        <div class="form-group">  
            <label for="jam_selesai">Jam Selesai:</label>  
            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>  
        </div>  
        
        <div class="form-group">  
            <label for="aktif">Aktif:</label>  
            <input type="checkbox" id="aktif" name="aktif" checked>  
        </div>  
        <button type="submit" class="btn btn-primary">Simpan</button>  
    </form>  
</div>  
