<?php
// ============================================================================
// FUNGSI UMUM
// Helper, akses dan utilitas yang digunakan secara umum.
// ============================================================================

    //Generate UID dengan sparator
    function GenerateRandomeToken($length) {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Menghindari karakter ambigu
        $captcha = '';
        for ($i = 0; $i < $length; $i++) {
            $captcha .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $captcha;
    }

    function simrsQuoteSqlIdentifier($identifier) {
        if (!is_string($identifier) || !preg_match('/\A[A-Za-z_][A-Za-z0-9_]*\z/', $identifier)) {
            throw new InvalidArgumentException('Identifier database tidak valid.');
        }

        return '`' . $identifier . '`';
    }

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

        $query = "
            INSERT INTO captcha (
                id_captcha,
                feature_name,
                code_captcha,
                creat_at,
                expired_at
            ) VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = mysqli_prepare($Conn, $query);
        if (!$stmt) {
            error_log('Prepare GenerateCaptcha gagal: ' . mysqli_error($Conn));
            return false;
        }

        mysqli_stmt_bind_param($stmt, 'sssss', $id_captcha, $feature_name, $captcha_hash, $created_at, $expired_at);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

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

        $stmt = mysqli_prepare($Conn, 'DELETE FROM captcha WHERE expired_at < ?');
        if (!$stmt) {
            error_log('Prepare DeleteExpiredCaptcha gagal: ' . mysqli_error($Conn));
            return false;
        }

        mysqli_stmt_bind_param($stmt, 's', $current_utc);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            error_log('Execute DeleteExpiredCaptcha gagal: ' . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);

        return (bool)$result;
    }

    // Menampilkan List Kolom
    function getColomList($Conn,$NamaKolom){
        $ListKolom = array();
        $stmt = mysqli_prepare(
            $Conn,
            'SELECT COLUMN_NAME
             FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?
             ORDER BY ORDINAL_POSITION'
        );
        if (!$stmt) {
            throw new RuntimeException('Gagal menyiapkan daftar kolom: ' . mysqli_error($Conn));
        }

        mysqli_stmt_bind_param($stmt, 's', $NamaKolom);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            throw new RuntimeException('Gagal membaca daftar kolom: ' . $error);
        }

        $result = mysqli_stmt_get_result($stmt);
        while ($RowList = mysqli_fetch_assoc($result)) {
            $ListKolom[] = ['nama_kolom' => $RowList['COLUMN_NAME']];
        }
        mysqli_stmt_close($stmt);

        return $ListKolom;
    }

    // =========================================================
    // FUNCTION CEK HAK AKSES FITUR
    // =========================================================
    function GetStatusAccess($Conn, $id_akses, $kode_fitur){

        // Validasi Parameter
        if (empty($id_akses) || empty($kode_fitur)) {
            return false;
        }

        // Query Join Sekaligus
        $query = "
            SELECT akses_acc.id_akses_acc
            FROM akses_acc
            INNER JOIN akses_fitur 
                ON akses_acc.id_akses_fitur = akses_fitur.id_akses_fitur
            WHERE akses_acc.id_akses = ?
            AND akses_fitur.kode = ?
            LIMIT 1
        ";

        $stmt = mysqli_prepare($Conn, $query);

        // Debug Prepare
        if (!$stmt) {
            error_log('Prepare Failed : '.mysqli_error($Conn));
            return false;
        }

        mysqli_stmt_bind_param($stmt, "is", $id_akses, $kode_fitur);

        // Execute
        if (!mysqli_stmt_execute($stmt)) {
            error_log('Execute Failed : '.mysqli_stmt_error($stmt));
            return false;
        }

        $result = mysqli_stmt_get_result($stmt);

        // Jika Ada Akses
        if (mysqli_num_rows($result) > 0) {
            mysqli_stmt_close($stmt);
            return true;
        }

        mysqli_stmt_close($stmt);

        return false;
    }

    //Memanggil Detail Data
    function getDataDetail($Conn,$NamaDb,$NamaParam,$IdParam,$Kolom){
        $table = simrsQuoteSqlIdentifier($NamaDb);
        $parameter = simrsQuoteSqlIdentifier($NamaParam);
        $column = simrsQuoteSqlIdentifier($Kolom);
        $stmt = $Conn->prepare("SELECT $column FROM $table WHERE $parameter = ?");
        if (!$stmt) {
            throw new RuntimeException('Gagal menyiapkan detail data: ' . $Conn->error);
        }
        $stmt->bind_param('s', $IdParam);
        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            throw new RuntimeException('Gagal membaca detail data: ' . $error);
        }
        $DataParam = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (empty($DataParam) || empty($DataParam[$Kolom])) {
            $Response="";
        }else{
            $Response=$DataParam[$Kolom];
        }
        return $Response;
    }

    //Memanggil Detail Data Versi Baru
    function getDataDetail_v2($Conn, $NamaDb, $NamaParam, $IdParam, $Kolom) {
        $table = simrsQuoteSqlIdentifier($NamaDb);
        $parameter = simrsQuoteSqlIdentifier($NamaParam);
        $column = simrsQuoteSqlIdentifier($Kolom);
        $stmt = $Conn->prepare("SELECT $column FROM $table WHERE $parameter = ?");
        if (!$stmt) {
            throw new RuntimeException('Gagal menyiapkan detail data: ' . $Conn->error);
        }
        $stmt->bind_param('s', $IdParam);
        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            throw new RuntimeException('Gagal membaca detail data: ' . $error);
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row[$Kolom] ?? null;
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

    
    function getNamaBulan($GetTahun, $GetBulan){
        $namaBulan = date("F", mktime(0, 0, 0, $GetBulan, 1, $GetTahun));
        return $namaBulan;
    }
    function getEmailSetting($Conn,$NamaKolom){
        $stmt = $Conn->prepare("SELECT * FROM setting_email_gateway WHERE status = ?");
        if (!$stmt) {
            throw new RuntimeException('Gagal menyiapkan pengaturan email: ' . $Conn->error);
        }
        $status = 'Active';
        $stmt->bind_param('s', $status);
        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            throw new RuntimeException('Gagal membaca pengaturan email: ' . $error);
        }
        $DataEmail = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (empty($DataEmail) || empty($DataEmail[$NamaKolom])) {
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
        $check = $Conn->prepare('SELECT 1 FROM akses_acc WHERE id_akses = ? AND id_akses_ref = ? LIMIT 1');
        if (!$check) {
            error_log('Prepare saveAccData check gagal: ' . $Conn->error);
            return 'Check Gagal';
        }
        $check->bind_param('ss', $id_akses, $id_akses_ref);
        if (!$check->execute()) {
            error_log('Execute saveAccData check gagal: ' . $check->error);
            $check->close();
            return 'Check Gagal';
        }
        $exists = $check->get_result()->num_rows > 0;
        $check->close();

        if (!$exists) {
            $stmt = $Conn->prepare('INSERT INTO akses_acc (id_akses, id_akses_ref, status) VALUES (?, ?, ?)');
            if (!$stmt) {
                error_log('Prepare saveAccData insert gagal: ' . $Conn->error);
                return 'Insert Gagal';
            }
            $stmt->bind_param('sss', $id_akses, $id_akses_ref, $status);
            $success = $stmt->execute();
            if (!$success) {
                error_log('Execute saveAccData insert gagal: ' . $stmt->error);
            }
            $stmt->close();
            return $success ? 'Berhasil' : 'Insert Gagal';
        }

        $stmt = $Conn->prepare(
            'UPDATE akses_acc SET status = ? WHERE id_akses = ? AND id_akses_ref = ?'
        );
        if (!$stmt) {
            error_log('Prepare saveAccData update gagal: ' . $Conn->error);
            return 'Update Gagal';
        }
        $stmt->bind_param('sss', $status, $id_akses, $id_akses_ref);
        $success = $stmt->execute();
        if (!$success) {
            error_log('Execute saveAccData update gagal: ' . $stmt->error);
        }
        $stmt->close();

        return $success ? 'Berhasil' : 'Update Gagal';
    }


    function DateFormatDinamis($tanggal,$format){
        $strtotime=strtotime($tanggal);
        $response=date(''.$format.'',$strtotime);
        return $response;
    }
    
    
    // Generate Token Dinamis
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

    // Mencari Nama Hari Berdasarkan Tanggal
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


    // Kirim Email
    function SendEmail($Conn, $id_setting_email_gateway, $subjek, $email_tujuan, $nama_tujuan, $pesan){
        // Buka Data Dengan Prepared Statment
        $sql  = "SELECT * FROM  setting_email_gateway WHERE id_setting_email_gateway = ?";
        $stmt = $Conn->prepare($sql);

        // Bind parameter (tipe data integer "i")
        $stmt->bind_param("i", $id_setting_email_gateway);

        // Eksekusi statement
        $stmt->execute();

        // Ambil hasil query
        $result = $stmt->get_result();
        $SettingEmail = $result->fetch_assoc();

        // Simpan hasil ke variabel
        $email_gateway    = $SettingEmail['email_gateway'] ?? null;
        $password_gateway = $SettingEmail['password_gateway'] ?? null;
        $url_provider     = $SettingEmail['url_provider'] ?? null;
        $port_gateway     = $SettingEmail['port_gateway'] ?? null;
        $nama_pengirim    = $SettingEmail['nama_pengirim'] ?? null;
        $url_service      = $SettingEmail['url_service'] ?? null;
        $status           = $SettingEmail['status'] ?? null;
        
        //Kirim email
        $ch = curl_init();
        $headers = array(
            'Content-Type: Application/JSON',          
            'Accept: Application/JSON'     
        );

        // Payload
        $payload = array(
            "subjek"              => "$subjek",
            "email_asal"          => "$email_gateway",
            "password_email_asal" => "$password_gateway",
            "url_provider"        => "$url_provider",
            "nama_pengirim"       => "$nama_pengirim",
            "email_tujuan"        => "$email_tujuan",
            "nama_tujuan"         => "$nama_tujuan",
            "pesan"               => "$pesan",
            "port"                => "$port_gateway"
        );


        $json = json_encode($payload);
        curl_setopt($ch, CURLOPT_URL, "$url_service/index.php");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        $get =json_decode($content, true);
        return $content;
    }

    function hitungUsia($tanggal_lahir, $tanggal_pembanding = null){
        if (empty($tanggal_lahir)) {
            return null;
        }

        try {
            $lahir = new DateTime($tanggal_lahir);

            // Jika tanggal pembanding kosong gunakan sekarang
            $compare = !empty($tanggal_pembanding)
                ? new DateTime($tanggal_pembanding)
                : new DateTime();

            // Validasi jika tanggal lahir lebih besar
            if ($lahir > $compare) {
                return null;
            }

            $diff = $lahir->diff($compare);

            // ==================================================
            // LOGIKA FORMAT USIA
            // ==================================================

            // Kurang dari 1 bulan => hari
            if ($diff->y == 0 && $diff->m == 0) {
                return $diff->d . ' Hari';
            }

            // Kurang dari 1 tahun => bulan
            if ($diff->y == 0) {
                return $diff->m . ' Bulan';
            }

            // 1 tahun ke atas => tahun
            return $diff->y . ' Tahun';

        } catch (Exception $e) {
            return null;
        }
    }
    // =========================================================
    // FUNGSI MENYIMPAN LOG (STRUKTUR TABEL log)
    // =========================================================
    function SaveLog($Conn, $id_akses, $nama_petugas, $title_log, $category_log, $metadata = []) {
        $datetime_log = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

        $metadataJson = null;
        if (!empty($metadata) && is_array($metadata)) {
            $encoded = json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            if ($encoded !== false) {
                $metadataJson = $encoded;
            }
        }

        $stmt = mysqli_prepare(
            $Conn,
            "INSERT INTO log (id_akses, datetime_log, nama_petugas, title_log, category_log, metadata_log)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param(
            $stmt,
            "isssss",
            $id_akses,
            $datetime_log,
            $nama_petugas,
            $title_log,
            $category_log,
            $metadataJson
        );

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return (bool)$result;
    }
// ============================================================================
// BRIDGING SATUSEHAT
// Autentikasi dan komunikasi resource FHIR SATUSEHAT.
// ============================================================================



    // =========================================
    // Fungsi Untuk Generate Token Satu Sehat
    // =========================================
    function generateTokenSatuSehat($Conn) {

        // =====================================================
        // TIMEZONE
        // =====================================================
        date_default_timezone_set('Asia/Jakarta');

        // =====================================================
        // VALIDASI KONEKSI DATABASE
        // =====================================================
        if (!$Conn || $Conn->connect_error) {
            return [
                'status'  => 'error',
                'message' => 'Koneksi database tidak valid!'
            ];
        }

        // =====================================================
        // AMBIL KONFIGURASI SATUSEHAT
        // =====================================================
        $Qry = $Conn->prepare("
            SELECT 
                id_setting_satusehat,
                nama_setting_satusehat,
                url_satusehat,
                client_key,
                secret_key,
                token,
                datetime_expired
            FROM setting_satusehat
            WHERE status_setting_satusehat = 1
            LIMIT 1
        ");

        if (!$Qry->execute()) {
            return [
                'status'  => 'error',
                'message' => 'Error Database: ' . $Conn->error
            ];
        }

        $Result = $Qry->get_result();
        $Data   = $Result->fetch_assoc();
        $Qry->close();

        if (!$Data) {
            return [
                'status'  => 'error',
                'message' => 'Tidak ada koneksi SATUSEHAT yang aktif!'
            ];
        }

        // =====================================================
        // MAPPING DATA
        // =====================================================
        $id_setting_satusehat = $Data['id_setting_satusehat'];
        $url_satusehat        = rtrim($Data['url_satusehat'], '/');
        $client_key           = trim($Data['client_key']);
        $secret_key           = trim($Data['secret_key']);
        $token_db             = trim($Data['token']);
        $expired_db           = trim($Data['datetime_expired']);

        // =====================================================
        // VALIDASI KONFIGURASI
        // =====================================================
        if (
            empty($client_key) ||
            empty($secret_key) ||
            empty($url_satusehat)
        ) {
            return [
                'status'  => 'error',
                'message' => 'Konfigurasi SATUSEHAT tidak lengkap!'
            ];
        }

        // =====================================================
        // VALIDASI TOKEN CACHE
        // =====================================================
        if (!empty($token_db) && !empty($expired_db)) {

            $expired_time = strtotime($expired_db);
            $current_time = time();

            // DEBUG
            /*
            echo "<pre>";
            echo "Expired DB : ".$expired_db."\n";
            echo "Expired TS : ".$expired_time."\n";
            echo "Current TS : ".$current_time."\n";
            echo "</pre>";
            */

            // =================================================
            // TOKEN MASIH VALID
            // =================================================
            if ($expired_time > $current_time) {

                return [
                    'status'  => 'success',
                    'message' => 'Token masih valid (cache)',
                    'token'   => $token_db
                ];
            }
        }

        // =====================================================
        // REQUEST TOKEN BARU
        // =====================================================
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url_satusehat . '/oauth2/v1/accesstoken?grant_type=client_credentials',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,

            CURLOPT_POSTFIELDS => http_build_query([
                'client_id'     => $client_key,
                'client_secret' => $secret_key
            ]),

            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ],

            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 20,

            // DEVELOPMENT ONLY
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $response   = curl_exec($ch);
        $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);


        // =====================================================
        // CURL ERROR
        // =====================================================
        if ($response === false) {

            return [
                'status'  => 'error',
                'message' => 'Gagal menghubungi API SATUSEHAT: ' . $curl_error
            ];
        }

        // =====================================================
        // HTTP ERROR
        // =====================================================
        if ($http_code !== 200) {

            return [
                'status'  => 'error',
                'message' => 'HTTP Error '.$http_code.' | '.substr($response, 0, 300)
            ];
        }

        // =====================================================
        // PARSE JSON
        // =====================================================
        $result = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {

            return [
                'status'  => 'error',
                'message' => 'JSON Error: ' . json_last_error_msg()
            ];
        }

        // =====================================================
        // API ERROR
        // =====================================================
        if (isset($result['error'])) {

            return [
                'status'  => 'error',
                'message' => 'API Error: ' . $result['error']
            ];
        }

        // =====================================================
        // VALIDASI TOKEN RESPONSE
        // =====================================================
        if (empty($result['access_token'])) {

            return [
                'status'  => 'error',
                'message' => 'Access token tidak ditemukan'
            ];
        }

        // =====================================================
        // MAPPING TOKEN
        // =====================================================
        $access_token = $result['access_token'];

        $expires_in = !empty($result['expires_in'])
            ? intval($result['expires_in'])
            : 3600;

        // =====================================================
        // DATETIME EXPIRED
        // =====================================================
        $expired_timestamp = time() + $expires_in;

        $datetime_expired = date(
            'Y-m-d H:i:s',
            $expired_timestamp
        );

        // =====================================================
        // UPDATE DATABASE
        // =====================================================
        $Update = $Conn->prepare("
            UPDATE setting_satusehat 
            SET 
                token = ?,
                datetime_expired = ?
            WHERE id_setting_satusehat = ?
        ");

        $Update->bind_param(
            "ssi",
            $access_token,
            $datetime_expired,
            $id_setting_satusehat
        );

        if (!$Update->execute()) {

            return [
                'status'  => 'error',
                'message' => 'Gagal menyimpan token: ' . $Conn->error
            ];
        }

        $Update->close();

        // =====================================================
        // SUCCESS
        // =====================================================
        return [
            'status'           => 'success',
            'message'          => 'Token baru berhasil dibuat',
            'token'            => $access_token,
            'datetime_expired' => $datetime_expired
        ];
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
        return $response;
    }
    function CreatCondition($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Condition',
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
        return $response;
    }
    function EditCondition($baseurl_satusehat,$Json,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Condition/'.$id.'',
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
        return $response;
    }
    function ConditionById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Condition/'.$id.'',
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
        return $response;
    }
    function CreatObservation($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Observation',
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
        return $response;
    }
    function EditObservation($baseurl_satusehat,$Json,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Observation/'.$id.'',
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
        return $response;
    }
    function ObservationById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Observation/'.$id.'',
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
        return $response;
    }
    function CreatComposition($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Composition',
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
        return $response;
    }
    function UpdateComposition($baseurl_satusehat,$Json,$Token,$Id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Composition/'.$Id.'',
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
        return $response;
    }
    function CompositionById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Composition/'.$id.'',
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
        return $response;
    }
    function CreatProcedur($baseurl_satusehat,$Json,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Procedure',
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
        return $response;
    }
    function ProcedurByEncounter($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Procedure?encounter='.$id.'',
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
        return $response;
    }
    function ProcedureById($baseurl_satusehat,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Procedure/'.$id.'',
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
        return $response;
    }
    function EditProcedur($baseurl_satusehat,$Json,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_satusehat.'/fhir-r4/v1/Procedure/'.$id.'',
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
        return $response;
    }
    /**
     * CREATE EPISODE OF CARE SATUSEHAT
     */
    
    function CreatEpisodeOfCare($baseurl_satusehat, $Json, $Token){
        $url = rtrim($baseurl_satusehat, '/') . '/fhir-r4/v1/EpisodeOfCare';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $Json,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $Token,
                'Content-Type: application/json'
            ]
        ]);
        $response = curl_exec($curl);
        $curlError = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $effectiveUrl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        return [
            'success' => ($response !== false),
            'http_code' => $httpCode,
            'curl_error' => $curlError,
            'body' => ($response !== false) ? $response : '',
            'request_url' => $effectiveUrl,
            'content_type' => $contentType
        ];
    }

    /**
     * Mengambil detail EpisodeOfCare langsung dari Server SATUSEHAT (GET Request)
     * 
     * @param mysqli $Conn Koneksi database aktif
     * @param string $IdEpisodeOfCare UUID EpisodeOfCare SATUSEHAT
     * @return array Mengembalikan array associative ['status' => 'success'/'error', 'message' => '...', 'data' => [...]]
     */
    function GetDetailEpisodeOfCareSatuSehat($Conn, $IdEpisodeOfCare) {
        if (empty($IdEpisodeOfCare)) {
            return [
                'status'  => 'error',
                'message' => 'ID EpisodeOfCare SATUSEHAT tidak boleh kosong.'
            ];
        }

        // 1. Baca Pengaturan Koneksi SATUSEHAT dari Database
        $status_setting_satusehat = 1;
        $stmtSet = $Conn->prepare("SELECT * FROM setting_satusehat WHERE status_setting_satusehat = ? LIMIT 1");
        if (!$stmtSet) {
            return [
                'status'  => 'error',
                'message' => 'Gagal menyiapkan query pengaturan SATUSEHAT.'
            ];
        }

        $stmtSet->bind_param("i", $status_setting_satusehat);
        $stmtSet->execute();
        $resultSet = $stmtSet->get_result();
        $setting = $resultSet->fetch_assoc();
        $stmtSet->close();

        if (empty($setting)) {
            return [
                'status'  => 'error',
                'message' => 'Setting Koneksi SATUSEHAT tidak ditemukan di database.'
            ];
        }

        $baseurl_satusehat = rtrim($setting['url_satusehat'] ?? '', '/');
        if (empty($baseurl_satusehat)) {
            return [
                'status'  => 'error',
                'message' => 'URL SATUSEHAT tidak terkonfigurasi dengan benar.'
            ];
        }

        // 2. Validasi & Generate Token SATUSEHAT jika Expired
        $token = $setting['token'] ?? '';
        $datetime_expired = $setting['datetime_expired'] ?? '';

        if (empty($token) || empty($datetime_expired) || strtotime($datetime_expired) <= time()) {
            $tokenResult = generateTokenSatuSehat($Conn);
            if (($tokenResult['status'] ?? '') !== 'success') {
                return [
                    'status'  => 'error',
                    'message' => 'Generate Token SATUSEHAT Gagal: ' . ($tokenResult['message'] ?? '')
                ];
            }
            $token = $tokenResult['token'] ?? '';
        }

        if (empty($token)) {
            return [
                'status'  => 'error',
                'message' => 'Token SATUSEHAT tidak tersedia.'
            ];
        }

        // 3. Susun Endpoint GET dengan benar (Mencegah duplikasi path fhir-r4/v1)
        // Jika $baseurl_satusehat sudah mencakup '/fhir-r4/v1', kita cukup append '/EpisodeOfCare/{id}'
        if (strpos($baseurl_satusehat, 'fhir-r4') === false) {
            $endpoint = $baseurl_satusehat . "/fhir-r4/v1/EpisodeOfCare/" . urlencode($IdEpisodeOfCare);
        } else {
            $endpoint = $baseurl_satusehat . "/EpisodeOfCare/" . urlencode($IdEpisodeOfCare);
        }

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $token,
            "Content-Type: application/json"
        ]);

        $responseBody = curl_exec($ch);
        $curlError    = curl_error($ch);
        $httpCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($curlError) {
            return [
                'status'  => 'error',
                'message' => 'cURL Error: ' . $curlError
            ];
        }

        $responseData = json_decode($responseBody, true);

        if ($httpCode != 200 || empty($responseData) || ($responseData['resourceType'] ?? '') === 'OperationOutcome') {
            $errorMsg = $responseData['issue'][0]['diagnostics'] ?? $responseData['issue'][0]['details']['text'] ?? 'Gagal mengambil data dari server SATUSEHAT.';
            return [
                'status'  => 'error',
                'message' => 'HTTP Code ' . $httpCode . ': ' . $errorMsg
            ];
        }

        return [
            'status'  => 'success',
            'message' => 'Berhasil mengambil detail EpisodeOfCare dari SATUSEHAT',
            'data'    => $responseData
        ];
    }

    /**
     * Memperbarui resource EpisodeOfCare SATUSEHAT berdasarkan data lokal.
     *
     * @param mysqli $Conn Koneksi database aktif
     * @param int $id_episode_perawatan ID Episode Perawatan lokal
     * @param string $IdEpisodeOfCare ID resource EpisodeOfCare SATUSEHAT
     * @return array Status dan pesan hasil pembaruan
     */
    function UpdateEpisodeOfCareSatuSehat($Conn, $id_episode_perawatan, $IdEpisodeOfCare) {
        $id_episode_perawatan = filter_var($id_episode_perawatan, FILTER_VALIDATE_INT);
        $IdEpisodeOfCare = trim((string)$IdEpisodeOfCare);

        if (!$id_episode_perawatan || $id_episode_perawatan < 1 || $IdEpisodeOfCare === '') {
            return [
                'status' => 'error',
                'message' => 'ID Episode Perawatan atau ID EpisodeOfCare SATUSEHAT tidak valid.'
            ];
        }

        $sql = "
            SELECT
                ep.IdEpisodeOfCare,
                ep.status,
                ep.episode_system,
                ep.episode_code,
                ep.episode_display,
                ep.date_start,
                ep.date_end,
                p.id_ihs,
                p.nama AS nama_pasien,
                d.id_ihs_practitioner,
                d.nama AS nama_dokter,
                dg.id_condition,
                dg.icd_deskripsi
            FROM episode_perawatan ep
            LEFT JOIN pasien p ON p.id_pasien = ep.id_pasien
            LEFT JOIN dokter d ON d.id_dokter = ep.id_dokter
            LEFT JOIN diagnosis dg ON dg.id_diagnosis = ep.id_diagnosis
            WHERE ep.id_episode_perawatan = ?
            LIMIT 1
        ";
        $stmt = mysqli_prepare($Conn, $sql);

        if (!$stmt) {
            error_log('Prepare EpisodeOfCare Update Data Error: ' . mysqli_error($Conn));
            return [
                'status' => 'error',
                'message' => 'Gagal menyiapkan data EpisodeOfCare untuk update.'
            ];
        }

        mysqli_stmt_bind_param($stmt, 'i', $id_episode_perawatan);

        if (!mysqli_stmt_execute($stmt)) {
            error_log('Execute EpisodeOfCare Update Data Error: ' . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            return [
                'status' => 'error',
                'message' => 'Gagal mengambil data EpisodeOfCare dari database.'
            ];
        }

        $result = mysqli_stmt_get_result($stmt);
        $episode = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$episode || (string)$episode['IdEpisodeOfCare'] !== $IdEpisodeOfCare) {
            return [
                'status' => 'error',
                'message' => 'ID EpisodeOfCare SATUSEHAT tidak cocok dengan data lokal.'
            ];
        }

        $requiredFields = [
            'id_ihs' => 'Patient IHS',
            'nama_pasien' => 'Nama pasien',
            'id_ihs_practitioner' => 'Practitioner IHS',
            'nama_dokter' => 'Nama dokter',
            'id_condition' => 'ID Condition SATUSEHAT',
            'icd_deskripsi' => 'Deskripsi diagnosis',
            'episode_system' => 'Episode system',
            'episode_code' => 'Episode code',
            'episode_display' => 'Episode display'
        ];

        foreach ($requiredFields as $field => $label) {
            if (empty($episode[$field])) {
                return [
                    'status' => 'error',
                    'message' => $label . ' belum tersedia untuk update SATUSEHAT.'
                ];
            }
        }

        $detailResult = GetDetailEpisodeOfCareSatuSehat($Conn, $IdEpisodeOfCare);
        if (($detailResult['status'] ?? '') !== 'success') {
            return [
                'status' => 'error',
                'message' => 'Gagal mengambil resource SATUSEHAT: ' .
                    ($detailResult['message'] ?? 'Kesalahan tidak diketahui.')
            ];
        }

        $resource = $detailResult['data'];
        if (($resource['id'] ?? '') !== $IdEpisodeOfCare) {
            return [
                'status' => 'error',
                'message' => 'ID resource SATUSEHAT yang diterima tidak sesuai.'
            ];
        }

        $stmtSetting = mysqli_prepare(
            $Conn,
            "SELECT url_satusehat, organization_id, nama_setting_satusehat
             FROM setting_satusehat
             WHERE status_setting_satusehat = 1
             LIMIT 1"
        );

        if (!$stmtSetting || !mysqli_stmt_execute($stmtSetting)) {
            if ($stmtSetting) {
                error_log('Execute EpisodeOfCare Setting Error: ' . mysqli_stmt_error($stmtSetting));
                mysqli_stmt_close($stmtSetting);
            } else {
                error_log('Prepare EpisodeOfCare Setting Error: ' . mysqli_error($Conn));
            }
            return [
                'status' => 'error',
                'message' => 'Gagal membaca pengaturan SATUSEHAT.'
            ];
        }

        $resultSetting = mysqli_stmt_get_result($stmtSetting);
        $setting = mysqli_fetch_assoc($resultSetting);
        mysqli_stmt_close($stmtSetting);

        if (empty($setting['url_satusehat']) || empty($setting['organization_id'])) {
            return [
                'status' => 'error',
                'message' => 'URL atau Organization SATUSEHAT belum dikonfigurasi.'
            ];
        }

        $tokenResult = generateTokenSatuSehat($Conn);
        if (($tokenResult['status'] ?? '') !== 'success' || empty($tokenResult['token'])) {
            return [
                'status' => 'error',
                'message' => 'Token SATUSEHAT gagal diperoleh: ' .
                    ($tokenResult['message'] ?? 'Token tidak tersedia.')
            ];
        }

        $timestampStart = strtotime($episode['date_start']);
        if ($timestampStart === false) {
            return [
                'status' => 'error',
                'message' => 'Tanggal mulai tidak valid untuk SATUSEHAT.'
            ];
        }

        $resource['status'] = $episode['status'];
        $resource['type'] = $resource['type'] ?? [];
        $resource['type'][0]['coding'] = $resource['type'][0]['coding'] ?? [];
        $resource['type'][0]['coding'][0] = [
            'system' => $episode['episode_system'],
            'code' => $episode['episode_code'],
            'display' => $episode['episode_display']
        ];
        $resource['diagnosis'] = $resource['diagnosis'] ?? [];
        $resource['diagnosis'][0]['condition'] = [
            'reference' => 'Condition/' . $episode['id_condition'],
            'display' => $episode['icd_deskripsi']
        ];
        $resource['patient'] = [
            'reference' => 'Patient/' . $episode['id_ihs'],
            'display' => $episode['nama_pasien']
        ];
        $resource['managingOrganization'] = [
            'reference' => 'Organization/' . $setting['organization_id'],
            'display' => $setting['nama_setting_satusehat']
        ];
        $resource['careManager'] = [
            'reference' => 'Practitioner/' . $episode['id_ihs_practitioner'],
            'display' => $episode['nama_dokter']
        ];
        $resource['period'] = $resource['period'] ?? [];
        $resource['period']['start'] = date('Y-m-d\TH:i:sP', $timestampStart);

        if (empty($episode['date_end'])) {
            unset($resource['period']['end']);
        } else {
            $timestampEnd = strtotime($episode['date_end']);
            if ($timestampEnd === false || $timestampEnd < $timestampStart) {
                return [
                    'status' => 'error',
                    'message' => 'Tanggal selesai tidak valid untuk SATUSEHAT.'
                ];
            }
            $resource['period']['end'] = date('Y-m-d\TH:i:sP', $timestampEnd);
        }

        $jsonResource = json_encode(
            $resource,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        if ($jsonResource === false) {
            return [
                'status' => 'error',
                'message' => 'Gagal membuat payload SATUSEHAT: ' . json_last_error_msg()
            ];
        }

        $baseUrl = rtrim($setting['url_satusehat'], '/');
        if (strpos($baseUrl, 'fhir-r4') === false) {
            $baseUrl .= '/fhir-r4/v1';
        }
        $url = $baseUrl . '/EpisodeOfCare/' . rawurlencode($IdEpisodeOfCare);
        $curl = curl_init($url);

        if ($curl === false) {
            return [
                'status' => 'error',
                'message' => 'Koneksi update SATUSEHAT gagal disiapkan.'
            ];
        }

        curl_setopt_array($curl, [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $jsonResource,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $tokenResult['token'],
                'Content-Type: application/json'
            ]
        ]);

        $responseBody = curl_exec($curl);
        $curlError = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($responseBody === false) {
            return [
                'status' => 'error',
                'message' => 'Update SATUSEHAT gagal: ' . $curlError
            ];
        }

        $responseData = json_decode($responseBody, true);
        if (
            json_last_error() !== JSON_ERROR_NONE ||
            ($responseData['resourceType'] ?? '') === 'OperationOutcome' ||
            $httpCode < 200 ||
            $httpCode >= 300
        ) {
            $apiMessage = $responseData['issue'][0]['diagnostics'] ??
                $responseData['issue'][0]['details']['text'] ??
                'HTTP Code ' . $httpCode;
            if (!is_string($apiMessage)) {
                $apiMessage = 'HTTP Code ' . $httpCode;
            }

            if (
                stripos($apiMessage, 'consent') !== false ||
                stripos($apiMessage, 'privacy') !== false
            ) {
                $apiMessage = 'SATUSEHAT menolak pembaruan karena aturan consent atau privasi. ' .
                    'Periksa persetujuan pasien dan kebijakan akses yang berlaku sebelum mencoba kembali.';
            }

            return [
                'status' => 'error',
                'message' => 'Update SATUSEHAT gagal: ' . $apiMessage
            ];
        }

        return [
            'status' => 'success',
            'message' => 'EpisodeOfCare berhasil diperbarui di SATUSEHAT.',
            'data' => $responseData
        ];
    }

    function GetConsent($baseurl,$Token,$id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl.'/consent/v1/Consent?patient_id='.$id.'',
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
        return $response;
    }
    function UpdateConsent($baseurl_consent_satusehat,$JsonEncode,$Token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_consent_satusehat.'/consent/v1/Consent',
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
        
        return $response;
    }
    function DetailConsent($baseurl_consent_satusehat,$Token,$id_consent){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$baseurl_consent_satusehat.'/consent/v1/Consent?id='.$id_consent.'',
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
        
        return $response;
    }
// ============================================================================
// BRIDGING BPJS
// VClaim, Aplicare, Antrean, iCare, dan utilitas payload BPJS.
// ============================================================================


    
    //FUNGSI ENCRYPT DAN DECRYPT BRIDGING BPJS
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
    function decompress($string){
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
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
        return $content;
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
        
        return $response;
    }
// ============================================================================
// SIRS ONLINE
// Belum ada function SIRS Online yang didefinisikan di file ini.
// ============================================================================
