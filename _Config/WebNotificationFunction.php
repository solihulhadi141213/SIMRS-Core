<?php
    function urlServiceNotification($putNameService){
        include "Connection.php";
        $QryService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='$putNameService'")or die(mysqli_error($Conn));
        $DataService = mysqli_fetch_array($QryService);
        if(!empty($DataService['url_service'])){
            $ServiceUrl= $DataService['url_service'];
        }else{
            $ServiceUrl="";
        }
        return $ServiceUrl;
    }
    function GetResponseApisNotification($url,$KirimData,$Metode){
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 3); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "$Metode");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!empty($err)){
            $Response="";
        }else{
            $Response =json_decode($content, true);
        }
       
        return $Response;
    }
?>