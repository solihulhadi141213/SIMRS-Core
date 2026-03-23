<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap no_bpjs
    if(empty($_POST['no_bpjs'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data No Kartu BPJS Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $no_bpjs=$_POST['no_bpjs'];
?>
<form action="javascript:void(0);" id="ProsesInputApproval">
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-6">
                <label for="noKartu"><dt>No.BPJS</dt></label>
                <input type="text" name="noKartu" id="noKartu" class="form-control" value="<?php echo "$no_bpjs";?>" required>
            </div>
            <div class="col-md-6">
                <label for="tglSep"><dt>Tanggal SEP</dt></label>
                <input type="date" name="tglSep" id="tglSep" class="form-control" required>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-6">
                <label for="jnsPelayanan"><dt>Jenis Pelayanan</dt></label>
                <select name="jnsPelayanan" id="jnsPelayanan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Rawat Inap</option>
                    <option value="2">Rawat Jalan</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="jnsPengajuan"><dt>Jenis Pengajuan</dt></label>
                <select name="jnsPengajuan" id="jnsPengajuan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Pengajuan Backdate</option>
                    <option value="2">Pengajuan Finger Print</option>
                </select>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12">
                <label for="keterangan"><dt>Keterangan</dt></label>
                <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="3"></textarea>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12">
                <label for="user"><dt>Petugas</dt></label>
                <input type="text" name="user" id="user" class="form-control" value="<?php echo "$SessionNama"; ?>" required>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12" id="NotifikasiPengajuanApproval">
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