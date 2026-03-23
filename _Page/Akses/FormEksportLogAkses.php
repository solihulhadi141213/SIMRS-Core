<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses
    if(empty($_POST['id_akses'])){
        echo '<div class="row">';
        echo '  <div class="col-md-6 mb-3">';
        echo '      ID Akses Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_akses=$_POST['id_akses'];
?>
    <input type="hidden" name="id_akses" value="<?php echo "$id_akses"; ?>">
    <div class="row">
        <div class="col col-md-12 mb-3">
            <label for="periode_awal">Periode Awal</label>
            <input type="date" name="periode_awal" id="periode_awal" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 mb-3">
            <label for="periode_akhir">Periode Akhir</label>
            <input type="date" name="periode_akhir" id="periode_akhir" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 mb-3">
            <label for="format_data">Format</label>
            <select name="format_data" id="format_data" class="form-control">
                <option value="">Pilih</option>
                <option value="HTML">HTML</option>
                <option value="Excel">Excel</option>
                <option value="PDF">PDF</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 mb-3">
            <input type="checkbox" checked name="tampilkan_kop_faskes" id="tampilkan_kop_faskes" value="Ya">
            <label for="tampilkan_kop_faskes">Tampilkan Kop Faskes</label>
        </div>
    </div>
<?php } ?>