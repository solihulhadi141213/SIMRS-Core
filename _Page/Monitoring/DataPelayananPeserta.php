<script>
    //Proses Pencarian
    $('#ProsesCariPelayanan').click(function(){
        var NoKartu = $('#NoKartu').val();
        var Tgl1 = $('#Tgl1').val();
        var Tgl2 = $('#Tgl2').val();
        $('#HasilPencarianKlaim').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Monitoring/ProsesCariPelayanan.php',
            data 	    :  {NoKartu: NoKartu, Tgl1: Tgl1, Tgl2: Tgl2},
            success     : function(data){
                $('#HasilPencarianKlaim').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-3 mt-3">
        <input type="text" name="NoKartu" id="NoKartu" class="form-control">
        <small for="NoKartu"><dt>No.Kartu</dt></small>
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
        <button type="submit" class="btn btn-md btn-outline-primary" id="ProsesCariPelayanan">
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
                        <th class="text-center"><dt>No.Kartu</dt></th>
                        <th class="text-center"><dt>Nama Peserta</dt></th>
                        <th class="text-center"><dt>Tanggal</dt></th>
                    </tr>
                </thead>
                <tbody id="HasilPencarianKlaim">
                    <tr>
                        <td colspan="5">Belum Ada Data Yang Bisa Ditampilkan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>