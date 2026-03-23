<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
        echo '<small>Kata Kunci</small>';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal_testimoni"){
            echo '<input type="date" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
            echo '<small>Kata Kunci</small>';
        }else{
            if($keyword_by=="nama_testimoni"||$keyword_by=="email"){
                echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                echo '<small>Kata Kunci</small>';
            }else{
                if($keyword_by=="status_testimoni"){
                    echo '<select name="keyword" id="keyword" class="form-control">';
                        $url=urlService('Info Testimoni');
                        $KirimData = array(
                            'api_key' => $api_key,
                            'keyword_by' => "",
                            'keyword' => "",
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
                            echo '<option value="">'.$err.'</option>';
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
                            if($code==200){
                                $JumlahStatus=count($JsonData['response']['list_status']);
                                if(!empty($JumlahStatus)){
                                    echo '<option value="">Pilih</option>';
                                    $ListStatus=$JsonData['response']['list_status'];
                                    foreach ($ListStatus as $value){
                                        $status=$value['status_testimoni'];
                                        echo '<option value="'.$status.'">'.$status.'</option>';
                                    }
                                }
                            }else{
                                echo '<option value="">'.$massage.'</option>';
                            }
                        }
                    echo '</select>';
                    echo '<small>Kata Kunci</small>';
                }else{
                    echo '<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">';
                    echo '<small>Kata Kunci</small>';
                }
            }
        }
    }
?>