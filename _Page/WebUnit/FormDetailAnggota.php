<?php
    if(empty($_POST['id_web_unit_karyawan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Anggota Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_web_unit_karyawan=$_POST['id_web_unit_karyawan'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Anggota');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_unit_karyawan' => $id_web_unit_karyawan
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!empty($err)){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <span class="text-danger">'.$err.'</span>';
            echo '  </div>';
            echo '</div>';
        }else{
            $JsonData =json_decode($content, true);
            if(!empty($JsonData['metadata']['massage'])){
                $massage=$JsonData['metadata']['massage'];
            }else{
                $massage="";
            }
            if(!empty($JsonData['metadata']['code'])){
                $code=$JsonData['metadata']['code'];
            }else{
                $code="";
            }
            if($code!==200){
                echo '<div class="row">';
                echo '  <div class="col-md-12">';
                echo '      <span class="text-danger">'.$massage.'</span>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_web_unit_karyawan=$JsonData['response']['id_web_unit_karyawan'];
                $id_unit_instalasi=$JsonData['response']['id_unit_instalasi'];
                $nama_karyawan=$JsonData['response']['nama_karyawan'];
                $posisi_jabatan=$JsonData['response']['posisi_jabatan'];
                $sk_jabatan=$JsonData['response']['sk_jabatan'];
                $updatetime=$JsonData['response']['updatetime'];
                $url_foto=$JsonData['response']['url_foto'];
?>
    
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="<?php echo $url_foto;?>" width="100%" alt="Foto Anggota Unit">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table table-responsive pre-scrollable">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    <dt>Nama Anggota Unit:</dt>
                                    <?php echo "$nama_karyawan"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Posisi Jabatan:</dt>
                                    <?php echo "$posisi_jabatan"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>SK Jabatan:</dt>
                                    <?php echo "$sk_jabatan"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Update Time:</dt>
                                    <?php echo "$updatetime"; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php }}} ?>