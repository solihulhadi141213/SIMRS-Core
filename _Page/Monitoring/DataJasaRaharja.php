<script>
    //Proses Pencarian
    $('#ProsesCariJasaRaharja').click(function(){
        var JenisPelayanan = $('#JenisPelayanan').val();
        var Tgl1 = $('#Tgl1').val();
        var Tgl2 = $('#Tgl2').val();
        $('#HasilPencarianJasaRaharja').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Monitoring/ProsesCariJasaRaharja.php',
            data 	    :  {JenisPelayanan: JenisPelayanan, Tgl1: Tgl1, Tgl2: Tgl2},
            success     : function(data){
                $('#HasilPencarianJasaRaharja').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-3 mt-3">
        <select name="JenisPelayanan" id="JenisPelayanan" class="form-control">
            <option value="1">Rawat Inap</option>
            <option value="2">Rawat Jalan</option>
        </select>
        <small for="JenisPelayanan"><dt>Jenis Pelayanan</dt></small>
    </div>
    <div class="col-md-3 mt-3">
        <input type="date" name="Tgl1" id="Tgl1" class="form-control">
        <small for="Tgl1"><dt>Tgl.Mulai Pencarian</dt></small>
    </div>
    <div class="col-md-3 mt-3">
        <input type="date" name="Tgl2" id="Tgl2" class="form-control">
        <small for="Tgl2"><dt>Tgl.Akhir Pencarian</dt></small>
    </div>
    <div class="col-md-3 mt-3">
        <button type="submit" class="btn btn-md btn-outline-primary" id="ProsesCariJasaRaharja">
            Mulai Cari
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mt-3">
        <div class="table table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center"><dt>No</dt></th>
                        <th class="text-center"><dt>No.SEP</dt></th>
                        <th class="text-center"><dt>No.Register</dt></th>
                        <th class="text-center"><dt>Tanggal Kejadian</dt></th>
                        <th class="text-center"><dt>Tgl.SEP</dt></th>
                    </tr>
                </thead>
                <tbody id="HasilPencarianJasaRaharja">
                    <tr>
                        <td colspan="5">Belum Ada Data Yang Bisa Ditampilkan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>