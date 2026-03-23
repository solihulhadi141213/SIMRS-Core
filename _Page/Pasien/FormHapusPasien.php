<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Pasien Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Validasi Apakah id_pasien Tersebut Ada
        $id_pasien_validasi=getDataDetail_v2($Conn, 'pasien', 'id_pasien', $id_pasien, 'id_pasien');
        if(empty($id_pasien_validasi)){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Pasien Tidak Valid!';
            echo '      </div>';
            echo '  </div>';
        }else{

?>
    <input type="hidden" name="id_pasien" value="<?php echo "$id_pasien"; ?>">
    <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-danger">
                Apakah anda yakin akan menghapus data pasien ini?
            </div>
        </div>
<?php 
        } 
    } 
?>