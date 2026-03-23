<?php
    function jumlahDataSo($api_key,$url,$boss){
        include "_Config/Connection.php";
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'boss' => $boss
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
            $JumlahData="0";
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
                if(!empty($JsonData['response']['list'])){
                    $list=$JsonData['response']['list'];
                    $JumlahData=$list;
                }else{
                    $JumlahData="0";
                }
            }
        }
        return $JumlahData;
    }
    function listSo($api_key,$url,$boss){
        include "../../_Config/Connection.php";
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'boss' => $boss
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
            $list="";
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
                if(!empty($JsonData['response']['list'])){
                    $list=$JsonData['response']['list'];
                }else{
                    $list="";
                }
            }
        }
        return $JumlahData;
    }