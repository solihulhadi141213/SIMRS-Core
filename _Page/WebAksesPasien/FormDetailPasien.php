<?php
    if(empty($_POST['id_web_pasien'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center">';
        echo '          <span class="text-danger">ID Pasien Tidak Boleh Kosong!</span>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-info">';
        echo '  <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_web_pasien=$_POST['id_web_pasien'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Pasien');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_pasien' => $id_web_pasien
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
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center">';
            echo '          <span class="text-danger">'.$err.'</span>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-info">';
            echo '  <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </button>';
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
                echo '<div class="modal-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-center">';
                echo '          <span class="text-danger">'.$massage.'</span>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                echo '<div class="modal-footer bg-info">';
                echo '  <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">';
                echo '      <i class="ti ti-close"></i> Tutup';
                echo '  </button>';
                echo '</div>';
            }else{
                $id_web_pasien=$JsonData['response']['id_web_pasien'];
                $tanggal_daftar=$JsonData['response']['tanggal_daftar'];
                if(empty($JsonData['response']['id_pasien'])){
                    $id_pasien="Tidak Ada";
                }else{
                    $id_pasien=$JsonData['response']['id_pasien'];
                }
                if(empty($JsonData['response']['nik'])){
                    $nik="Tidak Ada";
                }else{
                    $nik=$JsonData['response']['nik'];
                }
                if(empty($JsonData['response']['bpjs'])){
                    $bpjs="Tidak Ada";
                }else{
                    $bpjs=$JsonData['response']['bpjs'];
                }
                $nama=$JsonData['response']['nama'];
                //Format tanggal
                $strtotime=strtotime($tanggal_daftar);
                $Tanggal=date('d/m/Y H:i',$strtotime);
                if(empty($JsonData['response']['propinsi'])){
                    $propinsi="Tidak Ada";
                }else{
                    $propinsi=$JsonData['response']['propinsi'];
                }
                if(empty($JsonData['response']['kabupaten'])){
                    $kabupaten="Tidak Ada";
                }else{
                    $kabupaten=$JsonData['response']['kabupaten'];
                }
                if(empty($JsonData['response']['kecamatan'])){
                    $kecamatan="Tidak Ada";
                }else{
                    $kecamatan=$JsonData['response']['kecamatan'];
                }
                if(empty($JsonData['response']['desa'])){
                    $desa="Tidak Ada";
                }else{
                    $desa=$JsonData['response']['desa'];
                }
                if(empty($JsonData['response']['alamat'])){
                    $alamat="Tidak Ada";
                }else{
                    $alamat=$JsonData['response']['alamat'];
                }
                if(empty($JsonData['response']['tepat_lahir'])){
                    $tepat_lahir="Tidak Ada";
                }else{
                    $tepat_lahir=$JsonData['response']['tepat_lahir'];
                }
                if(empty($JsonData['response']['tanggal_lahir'])){
                    $tanggal_lahir="Tidak Ada";
                }else{
                    $tanggal_lahir=$JsonData['response']['tanggal_lahir'];
                }
                if(empty($JsonData['response']['kontak'])){
                    $kontak="Tidak Ada";
                }else{
                    $kontak=$JsonData['response']['kontak'];
                }
                if(empty($JsonData['response']['email'])){
                    $email="Tidak Ada";
                }else{
                    $email=$JsonData['response']['email'];
                }
                if(empty($JsonData['response']['gol_darah'])){
                    $gol_darah="Tidak Ada";
                }else{
                    $gol_darah=$JsonData['response']['gol_darah'];
                }
                if(empty($JsonData['response']['sex'])){
                    $sex="Tidak Ada";
                }else{
                    $sex=$JsonData['response']['sex'];
                }
                if(empty($JsonData['response']['pekerjaan'])){
                    $pekerjaan="Tidak Ada";
                }else{
                    $pekerjaan=$JsonData['response']['pekerjaan'];
                }
                if(empty($JsonData['response']['perkawinan'])){
                    $perkawinan="Tidak Ada";
                }else{
                    $perkawinan=$JsonData['response']['perkawinan'];
                }
                if(empty($JsonData['response']['token'])){
                    $token="Tidak Ada";
                }else{
                    $token=$JsonData['response']['token'];
                }
                if(empty($JsonData['response']['status'])){
                    $status="Tidak Ada";
                }else{
                    $status=$JsonData['response']['status'];
                }
                if(empty($JsonData['response']['updatetime'])){
                    $updatetime="Tidak Ada";
                }else{
                    $updatetime=$JsonData['response']['updatetime'];
                    $strtotime2=strtotime($updatetime);
                    $updatetime=date('d/m/Y H:i',$strtotime2);
                }
                $foto_profile=$JsonData['response']['foto_profile'];
?>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <?php if(!empty($foto_profile)){ ?>
                    <div class="row">
                        <div class="col-md-12 text-center mb-3">
                            <img src="<?php echo "$base_url_service/assets/img/Pasien/$foto_profile";?>" class="img img-circle" width="200px" height="200px">
                        </div>
                    </div>
                <?php } ?>
                <div class="table table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td><dt>ID. Web Pasien</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$id_web_pasien"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>No.RM</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$id_pasien"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>NIK</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$nik"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>BPJS</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$bpjs"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Tanggal Daftar</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$Tanggal"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Nama Pasien</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$nama"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Propinsi</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$propinsi"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Kabupaten</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$kabupaten"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Kecamatan</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$kecamatan"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Desa</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$desa"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Alamat</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$alamat"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>TTL</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$tepat_lahir, $tanggal_lahir"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Kontak</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$kontak"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Email</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$email"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Golongan Darah</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$gol_darah"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Jenis Kelamin</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$sex"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Status Perkawinan</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$perkawinan"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Pekerjaan</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$pekerjaan"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Token</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$token"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Status</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$status"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><dt>Updatetime</dt></td>
                                <td><dt>:</dt></td>
                                <td>
                                    <?php echo "$updatetime"; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <div class="row">
            <div class="col-md-12 mb-3">
                <a href="index.php?Page=WebAksesPasien&Sub=DetailPasien&id=<?php echo $id_web_pasien;?>" class="btn btn-md btn-primary">
                    Selengkapnya <i class="ti ti-more-alt"></i>
                </a>
                <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
    
<?php }}} ?>