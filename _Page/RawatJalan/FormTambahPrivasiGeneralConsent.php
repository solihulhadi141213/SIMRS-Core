<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
?>
    <div class="modal-body">
        <input type="hidden" name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                Tambahkan data pengunjung yang diperbolehkan/dilarang untuk menjenguk pasin yang bersangkutan.
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Nama Pengunjung</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nama_pengunjung" id="nama_pengunjung" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">NIK</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nik_pengunjung" id="nik_pengunjung" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Kontak</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="kontak_pengunjung" id="kontak_pengunjung" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Alamat</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="alamat_pengunjung" id="alamat_pengunjung" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Status Pengunjung</div>
            <div class="col-md-8 mb-2">
                <select name="status_pengunjung" id="status_pengunjung" class="form-control">
                    <option value="Diizinkan">Diizinkan</option>
                    <option value="Tidak Diizinkan">Tidak Diizinkan</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Keterangan</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="keterangan_pengunjung" id="keterangan_pengunjung" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahPrivasiGeneralConsent">
                <span class="text-primary">Pastikan data privasi ini terisi dengan benar dan lengkap!</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>