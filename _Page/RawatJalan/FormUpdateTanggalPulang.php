<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap sep
    if(empty($_POST['sep'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data No Kartu BPJS Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $sep=$_POST['sep'];
?>
<form action="javascript:void(0);" id="ProsesUpdateStatusPulang">
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-6">
                <label for="noSep"><dt>No.SEP</dt></label>
                <input type="text" name="noSep" id="noSep" class="form-control" value="<?php echo "$sep";?>" required>
            </div>
            <div class="col-md-6">
                <label for="statusPulang"><dt>Status Pulang</dt></label>
                <select name="statusPulang" id="statusPulang" class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Atas Persetujuan Dokter</option>
                    <option value="3">Atas Permintaan Sendiri</option>
                    <option value="4">Meninggal</option>
                    <option value="5">Lain-lain</option>
                </select>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-6">
                <label for="tglMeninggal"><dt>Tanggal Meninggal</dt></label>
                <input type="date" name="tglMeninggal" id="tglMeninggal" class="form-control">
                <small>Diisi apabila status meninggal</small>
            </div>
            <div class="col-md-6">
                <label for="tglPulang"><dt>Tanggal Pulang</dt></label>
                <input type="date" name="tglPulang" id="tglPulang" class="form-control">
                <small>Diisi apabila status pulang</small>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12">
                <label for="noSep"><dt>No.LP Manual</dt></label>
                <input type="text" name="noLPManual" id="noLPManual" class="form-control">
                <small>diisi jika SEPnya adalah KLL</small>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12">
                <label for="noSep"><dt>No.Surat Meninggal</dt></label>
                <input type="text" name="noSuratMeninggal" id="noSuratMeninggal" class="form-control">
                <small>Diisi Jika Pasien Meninggal</small>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12">
                <label for="user"><dt>Petugas</dt></label>
                <input type="text" name="user" id="user" class="form-control" value="<?php echo "$SessionNama"; ?>" required>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12" id="NotifikasiUpdateStatusPulang">
                <span class="text-info">
                    <dt>Keterangan :</dt>
                    Pastikan data pengajuan approval yang anda isi sudah sesuai.
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12 mb-3">
                <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                    <i class="ti-check-box"></i> Simpan
                </button>
                <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</form>
<?php } ?>