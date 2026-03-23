<?php
    if(empty($_POST['id_dokter'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Dokter Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Dokter');
        $KirimData = array(
            'api_key' => $api_key,
            'id_dokter' => $id_dokter
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
                $kode=$JsonData['response']['kode'];
                $nama=$JsonData['response']['nama'];
                $spesialis=$JsonData['response']['spesialis'];
                $alamat=$JsonData['response']['alamat'];
                $kontak=$JsonData['response']['kontak'];
                $email=$JsonData['response']['email'];
                $status=$JsonData['response']['status'];
                $foto=$JsonData['response']['foto'];
                $last_update=$JsonData['response']['last_update'];
?>
    <input type="hidden" name="id_dokter" id="id_dokter" value="<?php echo $id_dokter;?>">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kode">Kode Dokter</label>
            <input type="text" name="kode" id="kode" class="form-control" value="<?php echo $kode;?>">
        </div>
        <div class="col-md-12 mb-3">
            <label for="spesialis">Spesialis</label>
            <input type="text" name="spesialis" id="spesialis" class="form-control" value="<?php echo $spesialis;?>">
        </div>
        <div class="col-md-12 mb-3">
            <label for="nama">Nama Dokter</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kontak">Kontak</label>
            <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo $kontak;?>">
        </div>
        <div class="col-md-12 mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $email;?>">
        </div>
        <div class="col-md-12 mb-3">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $alamat;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option <?php if($status=="Aktif"){echo "selected";} ?> value="Aktif">Aktif</option>
                <option <?php if($status=="Cuti"){echo "selected";} ?> value="Cuti">Cuti</option>
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 mb-3" id="NotifikasiEditDokter">
            <span class="text-primary">Pastikan semua data dokter sudah terisi dengan benar</span>
        </div>
    </div>
<?php }}} ?>