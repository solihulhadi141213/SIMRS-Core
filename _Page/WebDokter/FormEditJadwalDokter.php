<?php
    if(empty($_POST['id_jadwal'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Jadwal Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_jadwal=$_POST['id_jadwal'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail jadwal');
        $KirimData = array(
            'api_key' => $api_key,
            'id_jadwal' => $id_jadwal
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
                $id_dokter=$JsonData['response']['id_dokter'];
                $IdPoliklinik=$JsonData['response']['id_poliklinik'];
                $hari=$JsonData['response']['hari'];
                $jam=$JsonData['response']['jam'];
                $kuota_non_jkn=$JsonData['response']['kuota_non_jkn'];
                $kuota_jkn=$JsonData['response']['kuota_jkn'];
                $time_max=$JsonData['response']['time_max'];
                $last_update=$JsonData['response']['last_update'];
                //Explode jam
                $ExplodeJam = explode("-" , $jam);
                $jam1=$ExplodeJam[0];
                $jam2=$ExplodeJam[1];
?>
    <input type="hidden" name="id_jadwal" id="id_jadwal" value="<?php echo $id_jadwal;?>">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="id_poliklinik">Pilih Poliklinik</label>
            <select name="id_poliklinik" id="id_poliklinik" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $UrlPoli=urlService("List Poliklinik");
                    $keyword_by="";
                    $keyword="";
                    $short_by="ASC";
                    $order_by="nama";
                    $ListPoliklinik=GetListInline($api_key,$UrlPoli,$keyword_by,$keyword,$short_by,$order_by);
                    $JumlahPoli=count($ListPoliklinik);
                    if(empty($JumlahPoli)){
                        echo '<option>Data Poliklinik Belum Ada</option>';
                    }else{
                        $no=1;
                        foreach($ListPoliklinik as $value){
                            $id_poliklinik=$value['id_poliklinik'];
                            $nama=$value['nama'];
                            if($IdPoliklinik==$id_poliklinik){
                                echo '<option selected value="'.$id_poliklinik.'">'.$nama.'</option>';
                            }else{
                                echo '<option value="'.$id_poliklinik.'">'.$nama.'</option>';
                            }
                        }
                    }
                ?>
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <label for="hari">Nama Hari</label>
            <select name="hari" id="hari" class="form-control">
                <option <?php if($hari=="Senin"){echo "selected";} ?> value="Senin">Senin</option>
                <option <?php if($hari=="Selasa"){echo "selected";} ?> value="Selasa">Selasa</option>
                <option <?php if($hari=="Rabu"){echo "selected";} ?> value="Rabu">Rabu</option>
                <option <?php if($hari=="Kamis"){echo "selected";} ?> value="Kamis">Kamis</option>
                <option <?php if($hari=="Jumat"){echo "selected";} ?> value="Jumat">Jumat</option>
                <option <?php if($hari=="Sabtu"){echo "selected";} ?> value="Sabtu">Sabtu</option>
                <option <?php if($hari=="Minggu"){echo "selected";} ?> value="Minggu">Minggu</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="jam1">Jam Mulai</label>
            <input type="time" name="jam1" id="jam1" class="form-control" value="<?php echo "$jam1"; ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="jam2">Jam Selesai</label>
            <input type="time" name="jam2" id="jam2" class="form-control" value="<?php echo "$jam2"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="kuota_non_jkn">Kuota Non JKN</label>
            <input type="number" min="1" name="kuota_non_jkn" id="kuota_non_jkn" class="form-control" value="<?php echo "$kuota_non_jkn"; ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="kuota_jkn">Kuota JKN</label>
            <input type="number" min="1" name="kuota_jkn" id="kuota_jkn" class="form-control" value="<?php echo "$kuota_jkn"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="time_max">Waktu Maksimal Kedatangan</label>
            <input type="number" min="0" name="time_max" id="time_max" class="form-control" value="<?php echo "$time_max"; ?>">
            <small>Menit</small>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 mb-3" id="NotifikasiEditJadwalDokter">
            <span class="text-primary">Pastikan semua data jadwal sudah terisi dengan benar</span>
        </div>
    </div>
<?php }}} ?>