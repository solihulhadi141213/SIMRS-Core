<script>
    //Proses Pencarian
    $('#ProsesCariKlaim').click(function(){
        var TanggalPulang = $('#TanggalPulang').val();
        var JenisPelayanan = $('#JenisPelayanan').val();
        var StatusKliam = $('#StatusKliam').val();
        $('#HasilPencarianKlaim').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Monitoring/ProsesCariKlaim.php',
            data 	    :  {TanggalPulang: TanggalPulang, JenisPelayanan: JenisPelayanan, StatusKliam: StatusKliam},
            success     : function(data){
                $('#HasilPencarianKlaim').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-3 mt-3">
        <input type="date" name="TanggalPulang" id="TanggalPulang" class="form-control">
        <small for="TanggalPulang"><dt>Tanggal Pulang</dt></small>
    </div>
    <div class="col-md-3 mt-3">
        <select name="JenisPelayanan" id="JenisPelayanan" class="form-control">
            <option value="1">Rawat Inap</option>
            <option value="2">Rawat Jalan</option>
        </select>
        <small for="JenisPelayanan"><dt>Jenis Pelayanan</dt></small>
    </div>
    <div class="col-md-3 mt-3">
        <select name="StatusKliam" id="StatusKliam" class="form-control">
            <option value="1">Proses Verifikasi</option>
            <option value="2">Pending Verifikasi</option>
            <option value="3">Klaim</option>
        </select>
        <small for="StatusKliam"><dt>Jenis Klaim</dt></small>
    </div>
    <div class="col-md-3 mt-3">
        <button type="submit" class="btn btn-md btn-outline-primary" id="ProsesCariKlaim">
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
                        <th class="text-center"><dt>Inacbg</dt></th>
                        <th class="text-center"><dt>Biaya</dt></th>
                        <th class="text-center"><dt>Kelas Rawat</dt></th>
                    </tr>
                </thead>
                <tbody id="HasilPencarianKlaim">
                    <tr>
                        <td colspan="4">Belum Ada Data Yang Bisa Ditampilkan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>