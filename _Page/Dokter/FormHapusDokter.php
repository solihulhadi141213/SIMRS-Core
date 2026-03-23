<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_dokter
    if(empty($_POST['id_dokter'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3">';
        echo '          ID Dokter Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        $kode=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kode');
        if(empty($kode)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Dokter Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'nama');
?>
    <input type="hidden" name="id_dokter" value="<?php echo "$id_dokter"; ?>">
    <div class="row mt-2 mb-2"> 
        <div class="col-md-12 text-center">
            <img src="assets/images/question.gif" alt="" width="70%">
        </div>
    </div>
    <div class="row mt-2 mb-2"> 
        <div class="col-md-12 text-center">
            Konfirmasi hapus data dokter atas nama <dt><?php echo "$nama"; ?></dt>
        </div>
    </div>
<?php }} ?>