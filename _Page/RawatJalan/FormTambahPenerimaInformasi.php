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
                Tambahkan data pihak keluarga, penanggung jawab atau pihak lain yang berhak memperoleh informasi pasien.
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Nama Lengkap</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nama" id="nama" class="form-control">
                <small>Sesuai KTP</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">NIK</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nik" id="nik" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Kontak</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="kontak" id="kontak" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Alamat</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="alamat" id="alamat" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Hubungan Dengan Pasien</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="hubungan" id="hubungan" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">Keterangan</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="keterangan" id="keterangan" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahPenerimaInformasi">
                <span class="text-primary">Pastikan data pihak penerima informasi pasien ini terisi dengan benar dan lengkap!</span>
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