<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "FungsiMetatag.php";
    $url=urlService('Detail Meta Tag');
    if(empty($_POST['id_web_metatag'])){
        echo "ID Meta Tag Tidak Boleh Kosong!";
    }else{
        $id_web_metatag=$_POST['id_web_metatag'];
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_metatag' => $id_web_metatag
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
                if(!empty($JsonData['response']['id_web_metatag'])){
                    $id_web_metatag=$JsonData['response']['id_web_metatag'];
                    $forPage=$JsonData['response']['forPage'];
                    $forSub=$JsonData['response']['forSub'];
                    $metatag_title=$JsonData['response']['metatag_title'];
                    $metatag_description=$JsonData['response']['metatag_description'];
                    $metatag_keywords=$JsonData['response']['metatag_keywords'];
                    $metatag_author=$JsonData['response']['metatag_author'];
                
?>
    <input type="hidden" name="id_web_metatag" id="id_web_metatag" value="<?php echo "$id_web_metatag"; ?>">
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="Halaman">Parameter (Page)</label>
            <input type="text" name="Halaman" id="Halaman" class="form-control" value="<?php echo "$forPage"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="SubHalaman">Parameter (Sub)</label>
            <input type="text" name="SubHalaman" id="SubHalaman" class="form-control" value="<?php echo "$forSub"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="Author">Author</label>
            <input type="text" name="Author" id="Author" class="form-control" value="<?php echo "$metatag_author"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="JudulHalaman">Judul</label>
            <input type="text" name="JudulHalaman" id="JudulHalaman" class="form-control" value="<?php echo "$metatag_title"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="KataKunci">Keyword</label>
            <input type="text" name="KataKunci" id="KataKunci" class="form-control" value="<?php echo "$metatag_keywords"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="Deskripsi">Deskripsi</label>
            <textarea name="Deskripsi" id="" cols="30" rows="3" class="form-control"><?php echo "$metatag_description"; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3" id="NotifikasiEditMetaTag">
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