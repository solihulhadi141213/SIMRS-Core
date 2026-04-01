<?php
    // Generate Captcha
    function GenerateCaptcha($Conn, $feature_name, $id_captcha){
        // Zona Waktu UTC
        $utc = new DateTime('now', new DateTimeZone('UTC'));

        // Menentukan Waktu Sekarang ($created_at)
        $created_at = $utc->format('Y-m-d H:i:s');

        // Expired AT adalah waktu 10 menit setelah $created_at
        $expired = clone $utc;
        $expired->modify('+10 minutes');
        $expired_at = $expired->format('Y-m-d H:i:s');

        // Karakter yang tidak membingungkan
        $allowed_chars = '234578ACDEFHJKMNPQRTUVWXYZabcdefghjkmnpqrtuvwxyz';

        // Generate captcha asli 6 karakter
        $captcha_plain = '';
        $max_index = strlen($allowed_chars) - 1;

        for($i = 0; $i < 6; $i++){
            $captcha_plain .= $allowed_chars[random_int(0, $max_index)];
        }

        // Hash captcha
        $captcha_hash = password_hash($captcha_plain, PASSWORD_DEFAULT);

        // Generate UID 32 karakter
         // 32 char

        // Escape input
        $feature_name = mysqli_real_escape_string($Conn, $feature_name);
        $id_captcha   = mysqli_real_escape_string($Conn, $id_captcha);
        $captcha_hash = mysqli_real_escape_string($Conn, $captcha_hash);

        // Simpan ke database
        $query = "
            INSERT INTO captcha (
                id_captcha,
                feature_name,
                code_captcha,
                creat_at,
                expired_at
            ) VALUES (
                '$id_captcha',
                '$feature_name',
                '$captcha_hash',
                '$created_at',
                '$expired_at'
            )
        ";

        $result = mysqli_query($Conn, $query);

        if(!$result){
            return false;
        }

        // Return data penting
        return [
            'id_captcha' => $id_captcha,
            'captcha'    => $captcha_plain,
            'created_at' => $created_at,
            'expired_at' => $expired_at
        ];
    }

    // Menghapus Captcha Yang Sudah Expired
    function DeleteExpiredCaptcha($Conn){
        // Waktu sekarang UTC
        $utc = new DateTime('now', new DateTimeZone('UTC'));
        $current_utc = $utc->format('Y-m-d H:i:s');

        // Query hapus captcha expired
        $query = "
            DELETE FROM captcha
            WHERE expired_at < '$current_utc'
        ";

        $result = mysqli_query($Conn, $query);

        // Hanya cek query berhasil atau gagal
        if($result){
            return true;
        }else{
            return false;
        }
    }

    // Menampilkan List Kolom
    function getColomList($Conn,$NamaKolom){
        $ListKolom = array();
        $QryKolom ="SHOW COLUMNS FROM $NamaKolom";
        $HasilQryKolom = mysqli_query($Conn,$QryKolom);
        while($RowList = mysqli_fetch_array($HasilQryKolom)){
            $NamaKolom=$RowList['Field'];
            $h['nama_kolom'] =$NamaKolom;
            array_push($ListKolom, $h);
        }
        return $ListKolom;
    }

    // Fungsi Referensi Akses
    function GetStatusAccess($Conn,$id_akses,$kode_fitur){
        //Cari id_akses_ref
        $QryRef= mysqli_query($Conn,"SELECT * FROM akses_ref WHERE kode='$kode_fitur'")or die(mysqli_error($Conn));
        $DataRef = mysqli_fetch_array($QryRef);
        if(empty($DataRef['id_akses_ref'])){
            $Response="";
        }else{
            $id_akses_ref=$DataRef['id_akses_ref'];
            //Buka Akses ACC
            $QryAcc= mysqli_query($Conn,"SELECT * FROM akses_acc WHERE id_akses_ref='$id_akses_ref' AND id_akses='$id_akses'")or die(mysqli_error($Conn));
            $DataAcc = mysqli_fetch_array($QryAcc);
            if(empty($DataAcc['status'])){
                $Response="";
            }else{
                $Response=$DataAcc['status'];
            }
        }
        return $Response;
    }

    //Memanggil Detail Data
    function getDataDetail($Conn,$NamaDb,$NamaParam,$IdParam,$Kolom){
        $QryParam = mysqli_query($Conn,"SELECT * FROM $NamaDb WHERE $NamaParam='$IdParam'")or die(mysqli_error($Conn));
        $DataParam = mysqli_fetch_array($QryParam);
        if(empty($DataParam[$Kolom])){
            $Response="";
        }else{
            $Response=$DataParam[$Kolom];
        }
        return $Response;
    }

    //Memanggil Detail Data Versi Baru
    function getDataDetail_v2($Conn, $NamaDb, $NamaParam, $IdParam, $Kolom) {
        // Sanitize input parameters to prevent injection or other issues
        $NamaDb    = mysqli_real_escape_string($Conn, $NamaDb);
        $NamaParam = mysqli_real_escape_string($Conn, $NamaParam);
        $IdParam   = mysqli_real_escape_string($Conn, $IdParam);
        $Kolom     = mysqli_real_escape_string($Conn, $Kolom);
    
        // Prepare the SQL query using a prepared statement
        $stmt = $Conn->prepare("SELECT $Kolom FROM $NamaDb WHERE $NamaParam = ?");
        $stmt->bind_param("s", $IdParam);  // "s" for string parameter (adjust type if needed)
    
        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Check if a result was returned
        if ($result && $row = $result->fetch_assoc()) {
            return $row[$Kolom] ?? null;  // Return the column value or null if not found
        } else {
            return null;  // Return null if no result was found
        }
    
        // Close the statement
        $stmt->close();
    }
    
    function getDataDetail2($Conn2,$NamaDb,$NamaParam,$IdParam,$Kolom){
        $Response="$IdParam";
        return $Response;
    }

    //Membersihkan Dan Sanitasi Variabel
    function validateAndSanitizeInput($input) {
        // Menghapus karakter yang tidak diinginkan
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        $input = addslashes($input);
        return $input;
    }
    //Fungsi Untuk Menyimpan Log
    function getSaveLog($Conn,$waktu,$nama,$nama_log,$kategori,$id_akses,$JsonUrl){
        date_default_timezone_set('Asia/Jakarta');
        $strtotime=strtotime($waktu);
        $Tanggal=date('Y-m-d H:i:s',$strtotime);
        $EntryLog="INSERT INTO log (
            waktu,
            nama,
            nama_log,
            kategori,
            id_akses
        )VALUES (
            '$Tanggal',
            '$nama',
            '$nama_log',
            '$kategori',
            '$id_akses'
        )";
        $SaveLog=mysqli_query($Conn, $EntryLog);
        if($SaveLog){
            $metadata= array();
            for ( $i=0; $i<=23; $i++ ){
                if($i==0){
                    $Time ="00";
                    $Jam="00:00";
                }else{
                    $Time = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $Jam = "$Time:00";
                }
                $KeywordTanggal="$Tanggal $Time";
                //Jumlah Aktivitas
                $JumlahAktivitas = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE waktu like '%$KeywordTanggal%'"));
                $h['x'] = $Jam;
                $h['y'] = $JumlahAktivitas;
                array_push($metadata, $h);
            }
            $JsonData = json_encode($metadata);
            file_put_contents($JsonUrl, $JsonData);
            $Response="Berhasil";
        }else{
            $Response="Terjadi Kesalahan Saat Menyimpan Log";
        }
        return $Response;
    }

    
    function formatSizeUnits($bytes){
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }
        return $bytes;
    }
     //Memanggil Setting Dinamis
    function getDinamicSetting($Conn,$IdAkses,$FiturName,$SettingName){
        $QryParam = mysqli_query($Conn,"SELECT * FROM setting_dinamis WHERE id_akses='$IdAkses' AND nama_fitur='$FiturName' AND nama_setting='$SettingName'")or die(mysqli_error($Conn));
        $DataParam = mysqli_fetch_array($QryParam);
        if(empty($DataParam['value_setting'])){
            $value_setting="";
        }else{
            $value_setting=$DataParam['value_setting'];
        }
        return $value_setting;
    }
    function saveSettingDinamis($Conn,$IdAkses,$FiturName,$SettingName,$ValueSetting){
        //Cek apakah data sudah ada?
        $CekData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_dinamis WHERE id_akses='$IdAkses' AND nama_fitur='$FiturName' AND nama_setting='$SettingName'"));
        if(empty($CekData)){
            $entry="INSERT INTO setting_dinamis (
                id_akses,
                nama_fitur,
                nama_setting,
                value_setting
            )VALUES (
                '$IdAkses',
                '$FiturName',
                '$SettingName',
                '$ValueSetting'
            )";
            $hasil=mysqli_query($Conn, $entry);
            if($hasil){
                $response=$ValueSetting;
            }else{
                $response="Gagal";
            }
        }else{
            $Update= mysqli_query($Conn,"UPDATE setting_dinamis SET 
                value_setting='$ValueSetting'
            WHERE id_akses='$IdAkses' AND nama_fitur='$FiturName' AND nama_setting='$SettingName'") or die(mysqli_error($Conn));
            if($Update){
                $response=$ValueSetting;
            }else{
                $response="Gagal";
            }
        }
        return $response;
    }
    function getNamaBulan($GetTahun, $GetBulan){
        $namaBulan = date("F", mktime(0, 0, 0, $GetBulan, 1, $GetTahun));
        return $namaBulan;
    }
    function getEmailSetting($Conn,$NamaKolom){
        $QrySettingEmail = mysqli_query($Conn,"SELECT * FROM setting_email_gateway WHERE status='Active'")or die(mysqli_error($Conn));
        $DataEmail = mysqli_fetch_array($QrySettingEmail);
        if(empty($DataEmail[$NamaKolom])){
            $Response="";
        }else{
            $Response=$DataEmail[$NamaKolom];
        }
        return $Response;
    }
    function generateStrongCode($length) {
        $characters = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function saveAccData($Conn,$id_akses,$id_akses_ref,$status){
        //Cek apakah data sudah ada?
        $CekData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_acc WHERE id_akses='$id_akses' AND id_akses_ref='$id_akses_ref'"));
        if(empty($CekData)){
            $entry="INSERT INTO akses_acc (
                id_akses,
                id_akses_ref,
                status
            )VALUES (
                '$id_akses',
                '$id_akses_ref',
                '$status'
            )";
            $hasil=mysqli_query($Conn, $entry);
            if($hasil){
                $response="Berhasil";
            }else{
                $response="Insert Gagal";
            }
        }else{
            $Update= mysqli_query($Conn,"UPDATE akses_acc SET 
                status='$status'
            WHERE id_akses='$id_akses' AND id_akses_ref='$id_akses_ref'") or die(mysqli_error($Conn));
            if($Update){
                $response="Berhasil";
            }else{
                $response="Update Gagal";
            }
        }
        return $response;
    }
    function tipeDisplay($tipe){
        if($tipe=="prov"){
            $response="Healthcare Provider";
        }else{
            if($tipe=="dept"){
                $response="Hospital Department";
            }else{
                if($tipe=="team"){
                    $response="Organizational team";
                }else{
                    if($tipe=="govt"){
                        $response="Government";
                    }else{
                        if($tipe=="ins"){
                            $response="Insurance Company";
                        }else{
                            if($tipe=="pay"){
                                $response="Payer";
                            }else{
                                if($tipe=="edu"){
                                    $response="Educational Institute";
                                }else{
                                    if($tipe=="reli"){
                                        $response="Religious Institution";
                                    }else{
                                        if($tipe=="crs"){
                                            $response="Clinical Research Sponsor";
                                        }else{
                                            if($tipe=="cg"){
                                                $response="Community Group";
                                            }else{
                                                if($tipe=="bus"){
                                                    $response="Non-Healthcare Business or Corporation";
                                                }else{
                                                    if($tipe=="other"){
                                                        $response="Other";
                                                    }else{
                                                        $response="";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $response;
    }
    function GenerateTokenSatuSehat($Conn){
        $QrySettingSatuSehat = mysqli_query($Conn,"SELECT * FROM setting_satusehat WHERE status='Active'")or die(mysqli_error($Conn));
        $DataSettingSatuSehat = mysqli_fetch_array($QrySettingSatuSehat);
        if(empty($DataSettingSatuSehat['id_setting_satusehat'])){
            $response="";
        }else{
            $oauth_baseurl=$DataSettingSatuSehat['oauth_baseurl'];
            $organization_id=$DataSettingSatuSehat['organization_id'];
            $client_key=$DataSettingSatuSehat['client_key'];
            $secret_key=$DataSettingSatuSehat['secret_key'];
            //Kirim CURL
            $UrlKirim="$oauth_baseurl/accesstoken?grant_type=client_credentials";
            //Start CURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$UrlKirim.'',
            //For New Version
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id='.$client_key.'&client_secret='.$secret_key.'',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
            ));
            $GetResponse = curl_exec($curl);
            curl_close($curl);
            //Ekstract Token
            $JsonData =json_decode($GetResponse, true);
            if(empty($JsonData['status'])){
                $response=$GetResponse;
            }else{
                $response=$JsonData['access_token'];
            }
        }
        return $response;
    }
    function GenerateTokenSatuSehat2($Conn){
        $QrySettingSatuSehat = mysqli_query($Conn,"SELECT * FROM setting_satusehat WHERE status='Active'")or die(mysqli_error($Conn));
        $DataSettingSatuSehat = mysqli_fetch_array($QrySettingSatuSehat);
        if(empty($DataSettingSatuSehat['id_setting_satusehat'])){
            $response="";
        }else{
            $oauth_baseurl=$DataSettingSatuSehat['oauth_baseurl'];
            $organization_id=$DataSettingSatuSehat['organization_id'];
            $client_key=$DataSettingSatuSehat['client_key'];
            $secret_key=$DataSettingSatuSehat['secret_key'];
            //Kirim CURL
            $UrlKirim="$oauth_baseurl/accesstoken?grant_type=client_credentials";
            //Start CURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$UrlKirim.'',
            //For New Version
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id='.$client_key.'&client_secret='.$secret_key.'',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
            ));
            $GetResponse = curl_exec($curl);
            curl_close($curl);
            //Ekstract Token
            $JsonData =json_decode($GetResponse, true);
            if(empty($JsonData['status'])){
                $response=$GetResponse;
            }else{
                $response=$JsonData['access_token'];
            }
        }
        return $response;
    }
    function CreatOrganization($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Organization',
            //For New Version
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function UpdateOrganization($baseurl_satusehat,$ID_Org,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Organization/'.$ID_Org.'',
           //For New Version
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function organizationById($baseurl_satusehat,$Token,$ID_Org){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Organization/'.$ID_Org.'',
        //For Version 7.4 New
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

        //For Version 7.3 Old
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function organizationSearchBy($baseurl_satusehat,$Token,$SearchBy,$KywordOrganization){
        $KywordOrganization = str_replace(" ", "%20", $KywordOrganization);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Organization?'.$SearchBy.'='.$KywordOrganization.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PatchOrganization($baseurl_satusehat,$ID_Org,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Organization/'.$ID_Org.'',
            //For New Version
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json-patch+json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function referensiAplicare($url_aplicare,$kode_ppk,$consid,$secret_key,$user_key){
        $url ="$url_aplicare/rest/bed/read/$kode_ppk/0/100";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'
        );
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $data =json_decode($content, true);
        return $content;
    }
    function referensiProvinsi($url_vclaim,$kode_ppk,$consid,$secret_key,$user_key){
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        //Membuat header
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type:Application/x-www-form-urlencoded'         
        ); 
        //Membuat URL
        $TanggalSekarang=date('Y-m-d');
        $URLUtama=$url_vclaim;
        $URLKatalog="referensi/propinsi";
        $url="$URLUtama$URLKatalog";
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $ambil_json =json_decode($content, true);
        return $content;
    }
    function referensiDokterPcare($url_vclaim,$kode_ppk,$consid,$secret_key,$user_key){
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        //Membuat header
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type:Application/x-www-form-urlencoded'         
        ); 
        //Membuat URL
        $TanggalSekarang=date('Y-m-d');
        $URLUtama=$url_vclaim;
        $URLKatalog="dokter/1/10";
        $url="$URLUtama/$URLKatalog";
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $ambil_json =json_decode($content, true);
        if(empty($content)){
            return $err;
        }else{
            return $content;
        }
        
    }
    function referensiDiagnosaVclaim($url_vclaim,$consid,$secret_key,$user_key,$Parameter){
        $url ="$url_vclaim/referensi/diagnosa/$Parameter";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $data =json_decode($content, true);
        return $content;
    }
    function referensiProcedurVclaim($url_vclaim,$consid,$secret_key,$user_key,$Parameter){
        $url ="$url_vclaim/referensi/procedure/$Parameter";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $data =json_decode($content, true);
        return $content;
    }
    function PesertaByNoKa($url_vclaim,$consid,$secret_key,$user_key,$no_bpjs){
        $TanggalSekarang=date('Y-m-d');
        $url ="$url_vclaim/Peserta/nokartu/$no_bpjs/tglSEP/$TanggalSekarang";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if(empty(curl_exec($ch))){
            $content=curl_error($ch);
        }else{
            $content=curl_exec($ch);
        }
        curl_close($ch);
        return $content;
    }
    function PesertaByNik($url_vclaim,$consid,$secret_key,$user_key,$nik){
        $TanggalSekarang=date('Y-m-d');
        $url ="$url_vclaim/Peserta/nik/$nik/tglSEP/$TanggalSekarang";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if(empty(curl_exec($ch))){
            $content=curl_error($ch);
        }else{
            $content=curl_exec($ch);
        }
        curl_close($ch);
        return $content;
    }
    function RujukanByKartu($url_vclaim,$consid,$secret_key,$user_key,$nomorkartu,$TipeRujukan){
        //Tipe Rujukan
        // 1. Rujukan FKTP
        // 2. Rujukan Internal
        // 3. Kontrol
        // 4. Rujukan Antar RS
        if($TipeRujukan=="1"){
            $url ="$url_vclaim/Rujukan/List/Peserta/$nomorkartu";
        }else{
            if($TipeRujukan=="4"){
                $url ="$url_vclaim/Rujukan/RS/List/Peserta/$nomorkartu";
            }else{
                $url="";
            }
        }
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function RujukanByNomorRujukan($url_vclaim,$consid,$secret_key,$user_key,$NoRujukan){
        $url ="$url_vclaim/Rujukan/$NoRujukan";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function SuratKontrolByKartu($url_vclaim,$consid,$secret_key,$user_key,$nomorkartu,$Bulan,$Tahun){
        $url ="$url_vclaim/RencanaKontrol/ListRencanaKontrol/Bulan/$Bulan/Tahun/$Tahun/Nokartu/$nomorkartu/filter/2";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function DetailReferensi($url_vclaim,$consid,$secret_key,$user_key,$url,$nomorreferensi){
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function BridgingServiceGet($consid,$secret_key,$user_key,$url){
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function BridgingServiceGetUrlencoded($consid,$secret_key,$user_key,$url){
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/x-www-form-urlencoded',          
            'Accept: Application/x-www-form-urlencoded'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function PencarianPpk($url_vclaim,$consid,$secret_key,$user_key,$url){
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function PencarianSep($url_vclaim,$consid,$secret_key,$user_key,$url){
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function DetailSep($url_vclaim,$consid,$secret_key,$user_key,$base_url,$sep){
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        $url="$base_url/SEP/$sep";
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function AntrianByTanggal($url_antrol,$consid,$secret_key,$user_key,$TanggalAntrianPencarian){
        $url ="$url_antrol/antrean/pendaftaran/tanggal/$TanggalAntrianPencarian";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function AntrianByKodeBooking($url_antrol,$consid,$secret_key,$user_key,$PencarianKodeBooking){
        $url ="$url_antrol/antrean/pendaftaran/kodebooking/$PencarianKodeBooking";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function AntrianByPoli($url_antrol,$consid,$secret_key,$user_key,$KodePoli,$KodeDokter,$Hari,$JamPraktek){
        $url ="$url_antrol/antrean/pendaftaran/kodepoli/$KodePoli/kodedokter/$KodeDokter/hari/$Hari/jampraktek/$JamPraktek";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function TaskIdByKodeBooking($url_antrol,$consid,$secret_key,$user_key,$KodeBooking){
        $url ="$url_antrol/antrean/getlisttask";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        $KirimData = array(
            'kodebooking' => $KodeBooking
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function AntrianBelumDilayani($url_antrol,$consid,$secret_key,$user_key){
        $url ="$url_antrol/antrean/pendaftaran/aktif";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function BatalkanAntrian($url_antrol,$consid,$secret_key,$user_key,$kodebooking,$keterangan_pembatalan){
        $url ="$url_antrol/antrean/batal";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        $KirimData = array(
            'kodebooking' => $kodebooking,
            'keterangan' => "$keterangan_pembatalan"
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function UpdateWaktuTaskId($url_antrol,$consid,$secret_key,$user_key,$kodebooking,$taskid,$jenisresep){
        $url ="$url_antrol/antrean/updatewaktu";
        //KONFIGURASI
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Generate Waktu Checkin
        $datetime = date('Y-m-d H:i:s');
        $milisecond=strtotime(''.$datetime.'');
        $milisecond=$milisecond*1000;
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $ch=curl_init();
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        ); 
        if($taskid==5){
            $KirimData = array(
                'kodebooking' => $kodebooking,
                'taskid' => $taskid,
                'waktu' => $milisecond,
                'jenisresep' => "$jenisresep"
            );
        }else{
            $KirimData = array(
                'kodebooking' => $kodebooking,
                'taskid' => $taskid,
                'waktu' => $milisecond
            );
        }
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $content;
    }
    function stringDecrypt($key, $string){
        $encrypt_method = 'AES-256-CBC';
        // hash
        $key_hash = hex2bin(hash('sha256', $key));
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return $output;
    }
    // function lzstring decompress 
    // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
    function decompress($string){
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }
    function CreatLocation($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Location',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function UpdateLocation($baseurl_satusehat,$Json,$Token,$id_location){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Location/'.$id_location.'',
            //For New Version
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function locationSearchByName($baseurl_satusehat,$Token,$KeywordLocation){
        $KeywordLocation = str_replace(" ", "%20", $KeywordLocation);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Location?name='.$KeywordLocation.'',
       //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function locationById($baseurl_satusehat,$Token,$KeywordLocation){
        $KeywordLocation = str_replace(" ", "%20", $KeywordLocation);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Location/'.$KeywordLocation.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function organizationLocation($baseurl_satusehat,$Token,$ID_Org){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Location?organization='.$ID_Org.'',
       //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PatchLocation($baseurl_satusehat,$id_location,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Location/'.$id_location.'',
            //For New Version
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json-patch+json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PractitionerById($baseurl_satusehat,$Token,$id_practitioner){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Practitioner/'.$id_practitioner.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PractitionerByNik($baseurl_satusehat,$Token,$nik){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|'.$nik.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PractitionerByIdentitas($baseurl_satusehat,$Token,$nama,$tanggal_lahir,$gender){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Practitioner?name='.$nama.'&gender='.$gender.'&birthdate='.$tanggal_lahir.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PatientByNik($baseurl_satusehat,$Token,$nik){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Patient?identifier=https://fhir.kemkes.go.id/id/nik|'.$nik.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PatientById($baseurl_satusehat,$Token,$IdPasien){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Patient/'.$IdPasien.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //Pencarian id ihas pakai titik dua
    function PatientByIhs($baseurl_satusehat,$Token,$IdPasien){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Patient:'.$IdPasien.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PatientByName($baseurl_satusehat,$Token,$nama_pasien,$tanggal_lahir,$nik_pasien){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Patient?name='.$nama_pasien.'&birthdate='.$tanggal_lahir.'&identifier=https://fhir.kemkes.go.id/id/nik|'.$nik_pasien.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function PatientByNikIbu($baseurl_satusehat,$Token,$nik_ibu){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Patient?identifier=https://fhir.kemkes.go.id/id/nik-ibu|'.$nik_ibu.'',
        //For New Version
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function CreatPatient($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Patient',
            //For New Version 7.4
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function EncounterById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Encounter/'.$id.'',
        
        //For New Version 7.4
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function EncounterBySubject($baseurl_satusehat,$Token,$id_subject){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Encounter?subject='.$id_subject.'',
       //For New Version 7.4
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function CreatEncounter($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Encounter',
            //For New Version 7.4
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function UpdateEncounter($baseurl_satusehat,$Json,$Token,$id_encounter){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Encounter/'.$id_encounter.'',
           //For New Version 7.4
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function CreatCondition($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Condition',
            //For New Version 7.4
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function EditCondition($baseurl_satusehat,$Json,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Condition/'.$id.'',
            //For New Version 7.4
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function ConditionById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Condition/'.$id.'',
        //For New Version 7.4
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function CreatObservation($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Observation',
           //For New Version 7.4
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function EditObservation($baseurl_satusehat,$Json,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Observation/'.$id.'',
            //For New Version 7.4
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function ObservationById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Observation/'.$id.'',
        //For New Version 7.4
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function CreatComposition($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Composition',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function UpdateComposition($baseurl_satusehat,$Json,$Token,$Id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Composition/'.$Id.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function CompositionById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Composition/'.$id.'',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function CreatProcedur($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Procedure',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function ProcedurByEncounter($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Procedure?encounter='.$id.'',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function ProcedureById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/Procedure/'.$id.'',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        //For Old Version 7.3
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$Token.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function EditProcedur($baseurl_satusehat,$Json,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Procedure/'.$id.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function DateFormatDinamis($tanggal,$format){
        $strtotime=strtotime($tanggal);
        $response=date(''.$format.'',$strtotime);
        return $response;
    }
    function ProsesiCare($url_icare,$timestamp,$consid,$secret_key,$user_key,$nomor_kartu,$kode_dokter){
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $KirimData = array(
            'param' => "$nomor_kartu",
            'kodedokter' => $kode_dokter
        );
        $json = json_encode($KirimData);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_icare.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$json.'',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json; charset=utf-8',
                "X-signature: $encodedSignature",
                'X-timestamp: '.$timestamp.'' ,
                'X-cons-id: '.$consid .'',
                'user_key: '.$user_key.''
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetConsent($baseurl,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl.'/Consent?patient_id='.$id.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function UpdateConsent($baseurl_consent_satusehat,$JsonEncode,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_consent_satusehat.'/Consent',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$JsonEncode.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function CreatMedication($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Medication',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function EditMedication($baseurl_satusehat,$Json,$Token,$id_medication){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Medication/'.$id_medication.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function AllergyIntoleranceById($baseurl_satusehat,$Token,$id_allergy){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/AllergyIntolerance/'.$id_allergy.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function CreatAllergyIntolerance($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/AllergyIntolerance',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function AllergyIntoleranceByIdIhs($baseurl_satusehat,$Token,$id_ihs){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/AllergyIntolerance?patient='.$id_ihs.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function EditAllergyIntolerance($baseurl_satusehat,$Json,$Token,$id_allergy){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/AllergyIntolerance/'.$id_allergy.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$Json.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetAllKfa($kfa_url,$Token,$page,$size,$product_type,$keyword){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$kfa_url.'/products/all?page='.$page.'&size='.$size.'&product_type='.$product_type.'&keyword='.$keyword.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetDetailKfa($kfa_url,$Token,$kfa_code){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$kfa_url/products?identifier=kfa&code=$kfa_code",
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetHargaKfa($kfa_url,$Token,$kfa_code,$page,$limit){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$kfa_url/farmalkes-price-jkn?page=$page&limit=$limit&kfa_code=$kfa_code",
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetMasterWilayahProvinsi($masterdata_url,$Token,$current_page,$next,$prev,$codes){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$masterdata_url/provinces?current_page=$current_page&next=$next&prev",
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetMasterWilayahKabupaten($masterdata_url,$Token,$current_page,$code_provinsi){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$masterdata_url/cities?current_page=$current_page&province_codes=$code_provinsi",
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetMasterWilayahKecamatan($masterdata_url,$Token,$current_page,$code_kabupaten){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$masterdata_url/districts?current_page=$current_page&city_codes=$code_kabupaten",
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetMasterWilayahDesa($masterdata_url,$Token,$current_page,$code_kecamatan){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$masterdata_url/sub-districts?current_page=$current_page&district_codes=$code_kecamatan",
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetAllMsi($masterdata_url,$Token,$page,$limit,$jenis_sarana,$kode_provinsi,$kode_kabkota,$kode_kecamatan){
        if(empty($kode_provinsi)){
            $kueri1="";
        }else{
            $kueri1="&kode_provinsi=$kode_provinsi";
        }
        if(empty($kode_kabkota)){
            $kueri2="";
        }else{
            $kueri2="&kode_kabkota=$kode_kabkota";
        }
        if(empty($kode_kecamatan)){
            $kueri3="";
        }else{
            $kueri3="&kode_kecamatan=$kode_kecamatan";
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$masterdata_url.'/mastersaranaindex/mastersarana?limit='.$limit.'&page='.$page.'&jenis_sarana='.$jenis_sarana.''.$kueri1.''.$kueri2.''.$kueri3.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetDetailMsi($masterdata_url,$Token,$kode_sarana){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$masterdata_url.'/mastersaranaindex/mastersarana?limit=10&page=1&kode_sarana='.$kode_sarana.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function GetDetailMedication($baseurl_satusehat,$Token,$id_medication){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/Medication/'.$id_medication.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function CreatMedicationRequest($baseurl_satusehat,$JsonEncode,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/MedicationRequest',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$JsonEncode.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function UpdateMedicationRequest($baseurl_satusehat,$JsonEncode,$Token,$id_medication_req){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/MedicationRequest/'.$id_medication_req.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$JsonEncode.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function CreatMedicationDispense($baseurl_satusehat,$JsonEncode,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/MedicationDispense',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$JsonEncode.'',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function iCare($url,$JsonEncode,$signature,$timestamp,$cons,$user_key){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$JsonEncode.'',
            CURLOPT_HTTPHEADER => array(
                'X-signature: '.$signature.'',
                'X-timestamp: '.$timestamp.'',
                'X-cons-id: '.$cons.'',
                'user_key: '.$user_key.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
    function MedicationRequestById($baseurl_satusehat,$Token,$id_item_resep){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/MedicationRequest/'.$id_item_resep.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function MedicationDispenseById($baseurl_satusehat,$Token,$id_medication_dis){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/MedicationDispense/'.$id_medication_dis.'',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            //For Old Version 7.3
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$Token.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function GenerateToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited
        
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }
        return $token;
    }
    function calculateExpirationTimeFromDateTime($dateTime, $milliseconds) {
        // Membuat objek DateTime dari string input
        $date = new DateTime($dateTime);
    
        // Mengonversi milidetik ke detik dan mikrodetik
        $seconds = floor($milliseconds / 1000);
        $microseconds = ($milliseconds % 1000) * 1000;
    
        // Menambahkan detik dan mikrodetik ke objek DateTime
        $date->add(new DateInterval("PT{$seconds}S"));
        // Menambahkan mikrodetik menggunakan metode modify
        $date->modify("+{$microseconds} microseconds");
    
        // Mengembalikan waktu kedaluwarsa dalam format YYYY-mm-dd HH:ii:ss.uuu
        return $date->format('Y-m-d H:i:s');
    }
    function NamaHariJadwal($tanggal) {
        if(empty($tanggal)){
            $tanggal=date('Y-m-d');
        }
       // Mengubah tanggal menjadi objek DateTime
        $datetime = new DateTime($tanggal);
        // Array nama hari dalam Bahasa Indonesia
        $nama_hari = array(
            "Sunday" => "Minggu",
            "Monday" => "Senin",
            "Tuesday" => "Selasa",
            "Wednesday" => "Rabu",
            "Thursday" => "Kamis",
            "Friday" => "Jumat",
            "Saturday" => "Sabtu"
        );
        // Mendapatkan nama hari dalam bahasa Inggris terlebih dahulu
        $hari_english = $datetime->format('l');
        // Mengambil nama hari dalam Bahasa Indonesia
        $nama_hari_indonesia = $nama_hari[$hari_english];
        // Menampilkan nama hari
        return $nama_hari_indonesia; // Output: Sabtu
    }

    // Mencari Data Pasien Berdasarkan Kolom
    function getDataPasien($SearchBy,$Keyword){
        include "Connection.php";
        if(empty($SearchBy)){
            $response="";
        }else{
            if(empty($Keyword)){
                $response="";
            }else{
                //Membuka Membuka Data Pasien
                $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE $SearchBy='$Keyword'")or die(mysqli_error($Conn));
                $response = mysqli_fetch_array($QryPasien);
                return $response;
            }
        }
    }
?>