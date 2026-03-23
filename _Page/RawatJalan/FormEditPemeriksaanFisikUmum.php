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
        if(empty($_POST['kategori'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Kategori Tidak Boleh Kosong!';
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
            $kategori=$_POST['kategori'];
            //Buka Detail Anamnesis
            $pemeriksaan_fisik=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'pemeriksaan_fisik');
            //Decode Json
            $JsonPemeriksaanFisik =json_decode($pemeriksaan_fisik, true);
            if(!empty($JsonPemeriksaanFisik)){
                if(!empty($JsonPemeriksaanFisik[$kategori])){
                    $PemeriksaanFisikUmum=$JsonPemeriksaanFisik[$kategori];
                }else{
                    $PemeriksaanFisikUmum="";
                }
            }else{
                $PemeriksaanFisikUmum="";
            }
?>
    <input type="hidden" name="IdKunjunganPemeriksaanFisikUmum" id="IdKunjunganPemeriksaanFisikUmum" value="<?php echo $id_kunjungan; ?>">
    <input type="hidden" name="KategoriPemeriksaanFisikUmum" id="KategoriPemeriksaanFisikUmum" value="<?php echo $kategori; ?>">
    <div class="modal-body">
        <div class="row mb-2">
            <div class="col-md-12">
                <label for="PemeriksaanFisikUmum">Penjelasan Pemeriksaan Fisik <?php echo "($kategori)"; ?></label>
                <textarea name="PemeriksaanFisikUmum" id="PemeriksaanFisikUmum" class="form-control"><?php echo "$PemeriksaanFisikUmum"; ?></textarea>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiEditPemeriksaanFisikUmum">
                <span>Pastikan informasi pemeriksaan fisik yang anda tulis sudah sesuai.</span>
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
<?php }} ?>