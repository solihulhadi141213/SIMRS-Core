<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Resep Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_resep=$_POST['id_resep'];
?>
    <input type="hidden" name="id_resep" id="id_resep" class="form-control" value="<?php echo "$id_resep"; ?>">
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            Silahkan lakukan pengaturan mode cetak yang anda inginkan.
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            Format Cetak?<br>
            <input type="radio" id="FormatCetakPdf" name="FormatCetak" value="PDF">
            <label for="FormatCetakPdf"><small>PDF</small></label>
            <input type="radio" id="FormatCetakHtml" name="FormatCetak" value="HTML">
            <label for="FormatCetakHtml"><small>HTML</small></label>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            Tamplikan Header?<br>
            <input type="radio" id="TampilkanHeaderYa" name="TampilkanHeader" value="Ya">
            <label for="TampilkanHeaderYa"><small>Ya, Tampilkan</small></label>
            <input type="radio" id="TampilkanHeaderTidak" name="TampilkanHeader" value="Tidak">
            <label for="TampilkanHeaderTidak"><small>Tidak</small></label>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            Tamplikan Pengkajian Resep?<br>
            <input type="radio" id="TampilkanPengkajianYa" name="TampilkanPengkajian" value="Ya">
            <label for="TampilkanPengkajianYa"><small>Ya, Tampilkan</small></label>
            <input type="radio" id="TampilkanPengkajianTidak" name="TampilkanPengkajian" value="Tidak">
            <label for="TampilkanPengkajianTidak"><small>Tidak</small></label>
        </div>
    </div>
<?php } ?>