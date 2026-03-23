<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap kfa_code
    if(empty($_POST['kfa_code'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Kode KFA Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $kfa_code=$_POST['kfa_code'];
        //Setting
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $kfa_url=getDataDetail($Conn,'setting_satusehat','status','Active','kfa_url');
        $Token=GenerateTokenSatuSehat($Conn);
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak ada setting satu sehat yang aktiv';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Generate Token Gagal!';
                echo '  </div>';
                echo '</div>';
            }else{
                $page="1";
                $limit="100";
                $GetHargaKfa=GetHargaKfa($kfa_url,$Token,$kfa_code,$page,$limit);
                if(empty($GetHargaKfa)){
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          Tidak ada response dari satu sehat';
                    echo '      </div>';
                    echo '  </div>';
                }else{
                    $data = json_decode($GetHargaKfa, true);
                    //Json prety
                    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
?>
    <div class="row mb-3">
        <div class="col-md-12">
            <?php echo $newJsonString;?>
        </div>
    </div>
</div>
<?php }}}} ?>