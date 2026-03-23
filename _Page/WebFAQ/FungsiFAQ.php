<?php
    function urlService($putNameService){
        include "../../_Config/Connection.php";
        $QryService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='$putNameService'")or die(mysqli_error($Conn));
        $DataService = mysqli_fetch_array($QryService);
        if(!empty($DataService['url_service'])){
            $ServiceUrl= $DataService['url_service'];
        }else{
            $ServiceUrl="";
        }
        return $ServiceUrl;
    }
    function urlServiceInline($putNameService){
        include "_Config/Connection.php";
        $QryService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='$putNameService'")or die(mysqli_error($Conn));
        $DataService = mysqli_fetch_array($QryService);
        if(!empty($DataService['url_service'])){
            $ServiceUrl= $DataService['url_service'];
        }else{
            $ServiceUrl="";
        }
        return $ServiceUrl;
    }
    function jumlahData($api_key,$url_info_meta_tag,$keyword_by,$keyword){
        include "../../_Config/Connection.php";
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'keyword_by' => $keyword_by,
            'keyword' => $keyword,
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url_info_meta_tag");
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
            $jumlah_metatag="0";
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
                if(!empty($JsonData['response']['jumlah_metatag'])){
                    $jumlah_metatag=$JsonData['response']['jumlah_metatag'];
                }else{
                    $jumlah_metatag="0";
                }
            }
        }
        return $jumlah_metatag;
    }
    