<?php
    //keyword
    if(empty($_POST['sep'])){
        echo "SEP Tidak Ditangkap";
    }else{
        $sep=$_POST['sep'];
?>
    <form action="javascript:void(0);" id="ProsesHapusSepInternal">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="noSep"><dt>No.SEP</dt></label>
                    <input type="text" name="noSep" id="noSep" class="form-control" value="<?php echo "$sep"; ?>">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="noSurat"><dt>No.Surat</dt></label>
                    <input type="text" name="noSurat" id="noSurat" class="form-control" value="">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="tglRujukanInternal"><dt>Tgl.Rujukan</dt></label>
                    <input type="date" name="tglRujukanInternal" id="tglRujukanInternal" class="form-control">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="kdPoliTuj"><dt>Kode Poli Tujuan</dt></label>
                    <input type="text" name="kdPoliTuj" id="kdPoliTuj" class="form-control" value="">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="user"><dt>User</dt></label>
                    <input type="text" name="user" id="user" class="form-control" value="Solihul Hadi">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3" id="NotifikasiHapusSep">
                    <dt>Keterangan:</dt>
                    Pastikan data yang anda gunakan sudah benar
                </div>
            </div>
        </div>
        <div class="modal-footer bg-info">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-danger mt-2 mr-2">
                        <i class="ti-close"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-md btn-light mt-2 mr-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php }?>