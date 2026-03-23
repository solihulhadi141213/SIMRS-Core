<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "FungsiFAQ.php";
    $url=urlService('List FAQ');
    if(empty($_POST['id_web_faq'])){
        echo "ID FAQ Tidak Boleh Kosong!";
    }else{
        $id_web_faq=$_POST['id_web_faq'];
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
                        $IdWebFaw=$value['id_web_faq'];
                        if($id_web_faq==$IdWebFaw){
                            $web_pertanyaan=$value['web_pertanyaan'];
                            $web_jawaban=$value['web_jawaban'];
?>
                        <input type="hidden" name="id_web_faq" id="id_web_faq" class="form-control" value="<?php echo $IdWebFaw;?>">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="web_pertanyaan">Pertanyaan</label>
                                <input type="text" name="web_pertanyaan" id="web_pertanyaan" class="form-control" value="<?php echo $web_pertanyaan;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="web_jawaban">Jawaban</label>
                                <textarea name="web_jawaban" id="web_jawaban" id="" cols="30" rows="3" class="form-control"><?php echo $web_jawaban;?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3" id="NotifikasiEditFAQ">
                                <span class="text-primary">
                                    Pastikan data FAQ sudah benar.
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