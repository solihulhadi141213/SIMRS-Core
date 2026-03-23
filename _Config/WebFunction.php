<?php
    //Menampilkan setting 
    function getSettingConnection($Parameter){
        include "_Config/Connection.php";
        //Membuka Setting API Key
        $QryApiKey = mysqli_query($Conn,"SELECT * FROM setting_web ORDER BY id_setting_web DESC")or die(mysqli_error($Conn));
        $DataApiKey = mysqli_fetch_array($QryApiKey);
        $WebSetting= $DataApiKey[$Parameter];
        return $WebSetting;
    }
    //Fungsi Menampilkan URL servcie berdasarkan nama service
    function getServiceUrl($putNameService){
        include "_Config/Connection.php";
        $QryService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='$putNameService'")or die(mysqli_error($Conn));
        $DataService = mysqli_fetch_array($QryService);
        if(!empty($DataService['url_service'])){
            $ServiceUrl= $DataService['url_service'];
        }else{
            $ServiceUrl="";
        }
        $putNameService="";
        return $ServiceUrl;
    }
    function getServiceUrl2($putNameService){
        include "../../_Config/Connection.php";
        $QryService = mysqli_query($Conn,"SELECT * FROM setting_service WHERE service_name='$putNameService'")or die(mysqli_error($Conn));
        $DataService = mysqli_fetch_array($QryService);
        if(!empty($DataService['url_service'])){
            $ServiceUrl= $DataService['url_service'];
        }else{
            $ServiceUrl="";
        }
        $putNameService="";
        return $ServiceUrl;
    }
    //Menampilkan Web Info berdasarkan url, nama paameter
    function getWebInfo($Url,$ApiKey,$Info){
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => "$ApiKey"
        );
        $json = json_encode($KirimData);
        $url_web_info=$Url;
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url_web_info");
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
            $ResponseInfo="Koneksi Error";
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
                $ResponseInfo=$massage;
            }else{
                $ResponseInfo=$JsonData['response'][$Info];
            }
        }
        return $ResponseInfo;
    }
    function urlService($putNameService){
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
    function urlServiceOutline($putNameService){
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
    function jumlahData($api_key,$url,$keyword_by,$keyword,$parameter){
        include "_Config/Connection.php";
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'keyword_by' => $keyword_by,
            'keyword' => $keyword,
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
                if(!empty($JsonData['response'][$parameter])){
                    $jumlah_metatag=$JsonData['response'][$parameter];
                }else{
                    $jumlah_metatag="0";
                }
            }
        }
        return $jumlah_metatag;
    }
    function jumlahDataOutline($api_key,$url,$keyword_by,$keyword,$parameter){
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
                if(!empty($JsonData['response'][$parameter])){
                    $jumlah_metatag=$JsonData['response'][$parameter];
                }else{
                    $jumlah_metatag="0";
                }
            }
        }
        return $jumlah_metatag;
    }
    function jumlahDataCount($api_key,$url,$keyword_by,$keyword,$short_by,$order_by){
        include "_Config/Connection.php";
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'page' => "1",
            'limit' => "100",
            'short_by' => $short_by,
            'order_by' => $order_by,
            'keyword_by' => $keyword_by,
            'keyword' => $keyword,
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
            $JumlahList="0";
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
                $list=$JsonData['response']['list'];
                $JumlahList=count($list);
            }else{
                $JumlahList=$content;
            }
        }
        return $JumlahList;
    }
    function GetListInline($api_key,$url,$keyword_by,$keyword,$short_by,$order_by){
        include "Connection.php";
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'page' => "1",
            'limit' => "100",
            'short_by' => $short_by,
            'order_by' => $order_by,
            'keyword_by' => $keyword_by,
            'keyword' => $keyword,
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
            $JumlahList="0";
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
                $list=$JsonData['response']['list'];
            }else{
                $list="";
            }
        }
        return $list;
    }
    function GetJadwalByDokter($api_key,$url,$id_dokter){
        include "Connection.php";
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'id_dokter' => $id_dokter,
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
            $JumlahList="0";
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
                $list=$JsonData['response']['list'];
            }else{
                $list="";
            }
        }
        return $list;
    }
    function GetInfoRuangRawat($api_key,$url,$parameter){
        include "Connection.php";
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
        if(!empty($err)){
            $Respon="0";
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
                $Respon=$JsonData['response'][$parameter];
            }else{
                $Respon="";
            }
        }
        return $Respon;
    }
    function HapusSemuaRuang($api_key,$url){
        include "Connection.php";
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
        if(!empty($err)){
            $code="404";
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
        }
        return $code;
    }
    function GetResponseApis($url,$KirimData,$Metode){
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
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
    function GetAksesPasien($api_key,$url,$id_web_pasien){
        //Akses Data Dari Server Website
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_pasien' => $id_web_pasien
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
            $Response="";
        }else{
            $Response =$content;
        }
        return $Response;
    }
?>


