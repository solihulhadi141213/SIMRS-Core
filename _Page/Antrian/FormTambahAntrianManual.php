<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
?>
<script type="text/javascript" >
    $(document).ready(function(){
        
    });
</script>
<div class="modal-body">   
    <form action="javascript:void(0);" id="ProsesPencarianPasien" autocomplete="off">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="No.Rm/NIK/No.kartu/Nama">
                    <button type="submit" class="btn btn-sm btn-inverse">
                        <i class="ti ti-search"></i> Cari Pasien
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12 mt-4" id="HasilPencarianPasien">
        </div>
    </div>
</div>
<div class="modal-footer bg-primary">
    <div class="row">
        <div class="col col-md col-12 text-center">
            <button type="button" class="btn btn-sm btn-light mt-2 mr-2" data-dismiss="modal">
                <i class="fa fa-times"></i> Tutup
            </button>
        </div>
    </div>
</div>