<?php
    //sep
    if(!empty($_POST['sep'])){
        $sep=$_POST['sep'];
    }else{
        $sep="";
    }
    if(!empty($_POST['id_kunjungan'])){
        $id_kunjungan=$_POST['id_kunjungan'];
    }else{
        $id_kunjungan="1";
    }
?>
<div class="modal-body">
    <form action="javascript:void(0);" method="POST" id="ProsesPencarianSpri">
        <div class="row">
            <div class="col-md-4">
                <input type="date" name="tanggal1" id="tanggal1" class="form-control">
                <small>Tanggal Awal</small>
            </div>
            <div class="col-md-4">
                <input type="date" name="tanggal2" id="tanggal2" class="form-control">
                <small>Tanggal Ahir</small>
            </div>
            <div class="col-md-4">
                <select name="FormatFilter" id="FormatFilter" class="form-control">
                    <option value="1">Tanggal Entry</option>
                    <option value="2">Tanggal Rencana Kontrol</option>
                </select>
                <small>format Filter</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-block btn-grd-info">
                    Cari Data
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3 pre-scrollable" id="HasilPencarianSpri">
                
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