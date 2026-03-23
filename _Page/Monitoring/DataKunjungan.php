<script>
    //Proses Pencarian
    $('#ProsesCariKunjungan').click(function(){
        var TanggalSep = $('#TanggalSep').val();
        var JenisPelayanan = $('#JenisPelayanan').val();
        $('#HasilPencarianKunjungan').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Monitoring/ProsesCariKunjungan.php',
            data 	    :  {TanggalSep: TanggalSep, JenisPelayanan: JenisPelayanan},
            success     : function(data){
                $('#HasilPencarianKunjungan').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-4 mt-3">
        <input type="date" name="TanggalSep" id="TanggalSep" class="form-control">
        <small for="TanggalSep"><dt>Tanggal SEP</dt></small>
    </div>
    <div class="col-md-4 mt-3">
        <select name="JenisPelayanan" id="JenisPelayanan" class="form-control">
            <option value="1">Rawat Inap</option>
            <option value="2">Rawat Jalan</option>
        </select>
        <small for="JenisPelayanan"><dt>Jenis Pelayanan</dt></small>
    </div>
    <div class="col-md-4 mt-3">
        <button type="submit" class="btn btn-md btn-outline-primary" id="ProsesCariKunjungan">
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
                        <th class="text-center"><dt>No.Sep</dt></th>
                        <th class="text-center"><dt>Tgl.Sep</dt></th>
                        <th class="text-center"><dt>Tgl.Pulang</dt></th>
                    </tr>
                </thead>
                <tbody id="HasilPencarianKunjungan">
                    <tr>
                        <td colspan="4">Belum Ada Data Yang Bisa Ditampilkan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>