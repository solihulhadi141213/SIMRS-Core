<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('List Medsos');
    if(empty($_POST['id_web_medsos'])){
        echo "ID Medsos Tidak Boleh Kosong!";
    }else{
        $id_web_medsos=$_POST['id_web_medsos'];
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
                        $id_web_medsos_list=$value['id_web_medsos'];
                        if($id_web_medsos==$id_web_medsos_list){
                            $IdWebMedsos=$value['id_web_medsos'];
                            $nama_medsos=$value['nama_medsos'];
                            $url_medsos=$value['url_medsos'];
                            $img_medsos=$value['img_medsos'];
                            $icon_medsos=$value['icon_medsos'];
                            $last_update=$value['last_update'];
?>
                        <input type="hidden" name="id_web_medsos" id="id_web_medsos" class="form-control" value="<?php echo $IdWebMedsos;?>">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="nama_medsos">Nama Medsos</label>
                                <input type="text" name="nama_medsos" id="nama_medsos" class="form-control" value="<?php echo $nama_medsos;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="url_medsos">URL Medsos</label>
                                <input type="text" name="url_medsos" id="url_medsos" class="form-control" value="<?php echo $url_medsos;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="img_medsos">Image/Icon Medsos</label>
                                <input type="file" name="img_medsos" id="img_medsos" class="form-control" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3" id="NotifikasiEditMedsos">
                                <span class="text-primary">
                                    Pastikan data Medsos sudah benar.
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