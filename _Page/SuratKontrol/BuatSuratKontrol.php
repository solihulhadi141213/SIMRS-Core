<?php
    //Koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

?>
<div class="card">
    <form action="javascript:void(0);" id="ProsesInsertRencanaKontrol">
        <div class="card-header border-info">
            <h4 class="text-primary">
                <dt><i class="icofont-clip-board"></i> Form Membuat Surat Kontrol</dt>
            </h4>
        </div>
        <div class="card-body">
            <div class="row mt-2 mb-2"> 
                <div class="col-md-4 mt-3">
                    <label for="JenisKontrol"><dt>Jenis Kontrol</dt></label>
                    <select name="JenisKontrol" id="JenisKontrol" class="form-control">
                        <option value="1">SPRI</option>
                        <option value="2">Rencana Kontrol</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3" id="NoIdentitas">
                    <label for="noKartu"><dt>No.Kartu</dt></label>
                    <input type="text" name="noKartu" id="noKartu" class="form-control" data-toggle="modal" data-target="#ModalCariSep" required>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="poliKontrol"><dt>Poliklinik</dt></label>
                    <input type="text" name="poliKontrol" id="poliKontrol" class="form-control" data-toggle="modal" data-target="#ModalCariPoli" required>
                </div>
            </div>
            <div class="row mt-2 mb-2"> 
                <div class="col-md-4 mt-3">
                    <label for="kodeDokter"><dt>Dokter</dt></label>
                    <input type="text" name="kodeDokter" id="kodeDokter" class="form-control" data-toggle="modal" data-target="#ModalCariDokter" required>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="tglRencanaKontrol"><dt>Tanggal Kontrol</dt></label>
                    <input type="date" name="tglRencanaKontrol" id="tglRencanaKontrol" class="form-control" value="<?php echo date('Y-m-d');?>" required>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="user"><dt>Petugas</dt></label>
                    <input type="text" name="user" id="user" class="form-control" value="<?php echo "$SessionNama"; ?>" required>
                </div>
            </div>
            <div class="row mt-2 mb-2"> 
                <div class="col-md-12" id="NotifikasiInsertRencanaKontrol">
                    <span class="text-info">
                        <dt>Keterangan :</dt>
                        Pastikan data rencana kontrol yang anda isi sudah sesuai.
                    </span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row mt-2 mb-2"> 
                <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                        <i class="ti-check-box"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-md btn-secondary mt-2 ml-2">
                        <i class="ti ti-reload"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>