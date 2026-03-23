<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_bantuan
    if(empty($_POST['id_bantuan'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Poliklinik Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_bantuan=$_POST['id_bantuan'];
?>
    <input type="hidden" name="id_bantuan" value="<?php echo "$id_bantuan"; ?>">
    <div class="row mt-2 mb-2"> 
        <div class="col-md-12 text-center">
            <img src="assets/images/question.gif" alt="" width="70%">
        </div>
    </div>
<?php } ?>