<?php
    //sep
    if(!empty($_POST['noKartu'])){
        $noKartu=$_POST['noKartu'];
    }else{
        $noKartu="";
    }
?>
<div class="modal-body">
    <form action="javascript:void(0);" method="POST" id="ProsesPencarianSupplesi">
        <input type="hidden" name="noKartu" id="noKartu" value="<?php echo "$noKartu"; ?>">
        <div class="row">
            <div class="col-md-8">
                <input type="date" name="tanggal" id="tanggal" class="form-control">
                <small>Tanggal Pelayanan</small>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-block btn-grd-info">
                    Cari Data
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3" id="HasilPencarianSuplesi">
                
            </div>
        </div>
    </form>
</div>
<div class="modal-footer bg-info">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-light mt-2 mr-2" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
    </div>
</div>