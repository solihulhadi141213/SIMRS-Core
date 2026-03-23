<?php
    if(empty($_POST['id_permintaan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Permintaan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_permintaan=$_POST['id_permintaan'];
?>
    <input type="hidden" name="id_permintaan" id="id_permintaan" value="<?php echo $id_permintaan; ?>">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="status_permintaan">Status Permintaan</label>
            <select name="status_permintaan" id="status_permintaan" class="form-control">
                <option value="">Pilih</option>
                <option value="Diterima">Diterima</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
    </div>
    <div id="LanjutanKonfirmasiPermintaan">
        
    </div>
    <div class="row">
        <div class="col-md-12" id="NotifikasiKonfirmasiPermintaan">
            <span class="text-primary">Pastikan Data Konfirmasi terisi dengan benar!</span>
        </div>
    </div>
<?php } ?>