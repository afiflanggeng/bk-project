@include('dokter.navdokter')    
<div class="container">    
    <p class="text-center" style="font-size: 35px"><b>Detail Pemeriksaan</b></p>    
      
    <hr>    
      
    <form method="POST" action="{{ route('dokter.simpanpemeriksaan') }}">    
        {{ csrf_field() }}    
        <input type="hidden" value="{{ request()->get('id') }}" name="idperiksa">    
          
        <div class="form-group row">    
            <label for="biayaJasaDokter" class="col-sm-2 col-form-label">Biaya Jasa Dokter</label>    
            <div class="col-sm-10">    
                <input type="text" class="form-control" id="biayaJasaDokter" value="150000" readonly>    
            </div>    
        </div>    
  
        <div class="form-group row">    
            <label for="totalBiayaObat" class="col-sm-2 col-form-label">Total Biaya Obat</label>    
            <div class="col-sm-10">    
                <input type="text" class="form-control" id="totalBiayaObat" value="0" readonly>    
            </div>    
        </div>    
  
        <div class="form-group row">    
            <label for="totalBiayaPemeriksaan" class="col-sm-2 col-form-label">Total Biaya Pemeriksaan</label>    
            <div class="col-sm-10">    
                <input type="text" class="form-control" id="totalBiayaPemeriksaan" value="150000" readonly>    
            </div>    
        </div>    
  
        <p style="font-size: 20px"><b>List Obat</b></p>    
        <div id="pembungkusobat">    
            <div class="form-group row">    
                <div class="col-sm-12">    
                    <select class="form-control" name="namaobat[]" onchange="updateTotalBiaya()" required>    
                        <option value="">-- Pilih Obat --</option>    
                        <?= $dataobat ?>    
                    </select>    
                </div>    
            </div>    
        </div>    
          
        <div style="width:100%;display:flex;justify-content:center">    
            <button type="button" class="btn btn-primary" onclick="tambahobat()">+</button>    
        </div>    
          
        <div class="form-group">    
            <label for="catatanMedis">Catatan Medis</label>    
            <textarea class="form-control" id="catatanMedis" rows="3" name="catatan" required></textarea>    
        </div>    
          
        <div style="width:100%;display:flex;justify-content:center">    
            <button type="submit" class="btn btn-success">Simpan</button>    
        </div>    
    </form>    
</div>    
  
<script>  
    function tambahobat() {  
        var pembungkus = document.getElementById("pembungkusobat");  
        var elembaru = document.createElement("div");  
        elembaru.className = "form-group row";  
        elembaru.innerHTML = `<div class="col-sm-12">  
                                <select class="form-control" name="namaobat[]" onchange="updateTotalBiaya()">  
                                    <option value="">-- Pilih Obat --</option>  
                                    <?= $dataobat ?>  
                                </select>  
                              </div>  
                              <div class="col-sm-2">  
                                <button type="button" class="btn btn-danger" onclick="delobat(this)">-</button>  
                              </div>`;  
        pembungkus.appendChild(elembaru);  
    }  
  
    function delobat(button) {  
        button.parentElement.parentElement.remove();  
        updateTotalBiaya(); // Update total biaya setelah menghapus obat  
    }  
  
    function updateTotalBiaya() {  
        var totalBiayaObat = 0;  
        var selects = document.querySelectorAll('select[name="namaobat[]"]');  
  
        selects.forEach(function(select) {  
            var harga = parseFloat(select.options[select.selectedIndex].getAttribute('data-harga')) || 0;  
            totalBiayaObat += harga;  
        });  
  
        document.getElementById("totalBiayaObat").value = totalBiayaObat;  
        document.getElementById("totalBiayaPemeriksaan").value = totalBiayaObat + 150000; // Total biaya pemeriksaan  
    }  
</script>  