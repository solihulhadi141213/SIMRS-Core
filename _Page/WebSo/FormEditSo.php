<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Detail So');
    if(empty($_POST['id_struktur_organisasi'])){
        echo "ID Struktur Organiasai Tidak Boleh Kosong!";
    }else{
        $id_struktur_organisasi=$_POST['id_struktur_organisasi'];
        $KirimData = array(
            'api_key' => $api_key,
            'id_struktur_organisasi' => $id_struktur_organisasi
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
            echo "$err";
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
                echo "$massage";
            }else{
                if(!empty($JsonData['response']['id_struktur_organisasi'])){
                    $id_struktur_organisasi=$JsonData['response']['id_struktur_organisasi'];
                    $key_struktur_organisasi=$JsonData['response']['key_struktur_organisasi'];
                    $boss=$JsonData['response']['boss'];
                    $nama=$JsonData['response']['nama'];
                    $job_title=$JsonData['response']['job_title'];
                    $NIP=$JsonData['response']['NIP'];
                    $updatetime=$JsonData['response']['updatetime'];
                    $foto=$JsonData['response']['foto'];
                
?>
    <input type="hidden" name="id_struktur_organisasi" id="id_struktur_organisasi" value="<?php echo "$id_struktur_organisasi"; ?>">
    <input type="hidden" name="key_struktur_organisasi" id="key_struktur_organisasi" value="<?php echo "$key_struktur_organisasi"; ?>">
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="boss">Key Boss</label>
            <input type="text" name="boss" id="boss" class="form-control" value="<?php echo "$boss"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="boss">Key Boss</label>
            <input type="text" name="boss" id="boss" class="form-control" value="<?php echo "$boss"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="job_title">Job Title</label>
            <input type="text" name="job_title" id="job_title" class="form-control" value="<?php echo "$job_title"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="NIP">NIP</label>
            <input type="text" name="NIP" id="NIP" class="form-control" value="<?php echo "$NIP"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3" id="NotifikasiEditSo">
            <span class="text-primary">
                Pastikan data meta tag sudah benar.
            </span>
        </div>
    </div>
<?php
                }
            }
        }
    }
?>