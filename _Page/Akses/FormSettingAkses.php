<?php
    //Zona waktu dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
?>
<div class="modal-header bg-primary">
    <b cass="text-light">Setting Izin Akses</b> 
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body p-0">
    <div class="card-body border-0 pb-0">
        <div class="row">
            <div class="col col-md-12 mt-3 text-info">
                1. Pilih Salah Satu Group Setting Akses
            </div>
        </div>
        <div class="row">
            <div class="col col-md-4 mb-3 mt-3">
                <?php
                    echo '<select class="form-control" name="SelecAksesGroup" id="SelecAksesGroup" required>';
                    echo '<option value="">Pilih..</option>';
                    //Buka data akses group akses
                    $query = mysqli_query($Conn, "SELECT DISTINCT akses FROM akses");
                    while ($data = mysqli_fetch_array($query)) {
                        $NamaAkses= $data['akses'];
                        echo '<option value="'.$NamaAkses.'">'.$NamaAkses.'</option>';
                    }
                    echo '</select>';
                ?>
            </div>
        </div>
        <form action="javascript:void(0);" id="ProsesSettingAkses">
            <div id="FormSettingAkses2">
                <!---FormSettingAkses2 ---->
            </div>
            <div class="row">
                <div class="col col-md-12 mb-3 mt-3">
                    <button type="submit" class="btn btn-md btn-info">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-md btn-secondary">
                        <i class="ti-reload"></i> Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>