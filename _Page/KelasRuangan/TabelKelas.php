<script>
    $('#MenampilkanDataKelas').html('<div class="col-md-12 text-center">Loading..</div>');
    $('#MenampilkanDataKelas').load("_Page/KelasRuangan/DataKelas.php");
    $('#PencarianKelas').submit(function(){
        var PencarianKelas = $('#PencarianKelas').serialize();
        $('#MenampilkanDataKelas').html('<div class="col-md-12 text-center">Loading..</div>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan/DataKelas.php',
            data 	    :  PencarianKelas,
            success     : function(data){
                $('#MenampilkanDataKelas').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <form action="javascript:void(0);" id="PencarianKelas">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                            <small>Pencarian</small>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="ti-search"></i> Go</button>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="btn btn-md btn-inverse" data-toggle="modal" data-target="#ModalTambahKelas">
                                <i class="ti-plus"></i> Tambah Kelas
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row" id="MenampilkanDataKelas">

</div>

