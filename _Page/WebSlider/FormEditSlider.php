<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "FungsiSlider.php";
    $url=urlService('List Slider');
    if(empty($_POST['id_web_hero'])){
        echo "ID Slider Tidak Boleh Kosong!";
    }else{
        $id_web_hero=$_POST['id_web_hero'];
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key
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
        if(empty($err)){
            $JsonData =json_decode($content, true);
            if(!empty($JsonData['metadata']['massage'])){
                $massage=$JsonData['metadata']['massage'];
            }else{
                $massage="Tidak Ada Pesan Response";
            }
            if(!empty($JsonData['metadata']['code'])){
                $code=$JsonData['metadata']['code'];
            }else{
                $code="Kode Tidak Diketahui";
            }
            if($code==200){
                $JumlahBaris=count($JsonData['response']['list']);
                if(empty($JumlahBaris)){
                    echo '      Tidak Ada Data Yang Ditampilkan';
                }else{
                    $list_data=$JsonData['response']['list'];
                    foreach($list_data as $value){
                        $idWebHero=$value['id_web_hero'];
                        if($id_web_hero==$idWebHero){
                            $idWebHero=$value['id_web_hero'];
                            $hero_title=$value['hero_title'];
                            $hero_deskripsi=$value['hero_deskripsi'];
                            $hero_button=$value['hero_button'];
                            $hero_url=$value['hero_url'];
                            $hero_img=$value['hero_img'];
                
?>
                        <input type="hidden" name="id_web_hero" id="id_web_hero" class="form-control" value="<?php echo $idWebHero;?>">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="hero_title">Judul Slider</label>
                                <input type="text" name="hero_title" id="hero_title" class="form-control" value="<?php echo $hero_title;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="hero_button">Text Tombol</label>
                                <input type="text" name="hero_button" id="hero_button" class="form-control" value="<?php echo $hero_button;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="hero_url">URL Tombol</label>
                                <input type="text" name="hero_url" id="hero_url" class="form-control" value="<?php echo $hero_url;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="hero_img">Image File</label>
                                <input type="file" name="hero_img" id="hero_img" class="form-control" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="hero_deskripsi">Deskripsi</label>
                                <textarea name="hero_deskripsi" id="" cols="30" rows="3" class="form-control"><?php echo $hero_deskripsi;?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3" id="NotifikasiEditSlider">
                                <span class="text-primary">
                                    Pastikan data Slider/Hero sudah benar.
                                </span>
                            </div>
                        </div>
<?php
                        }
                    }
                }
            }
        }
    }
?>