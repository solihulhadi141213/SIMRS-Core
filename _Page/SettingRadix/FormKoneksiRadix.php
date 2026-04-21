<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
        exit;
    }

    // Validasi ID
    if (empty($_POST['id_setting_radix'])) {
        echo '<div class="alert alert-danger">ID Setting Radix tidak boleh kosong.</div>';
        exit;
    }

    $id_setting_radix = (int) $_POST['id_setting_radix'];

    // Ambil data detail
    $query = "SELECT * FROM setting_radix WHERE id_setting_radix = ?";
    $stmt  = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<div class="alert alert-danger">Gagal prepare query.</div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_setting_radix);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-warning">Data Setting Radix tidak ditemukan.</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    // Status badge
    $status_badge = ($data['status'] == 1)
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Tidak Aktif</span>';
    
    // Buat Variabel
    $setting_name = $data['setting_name'] ?? '';
    $base_url     = $data['base_url'] ?? '';
    $username     = $data['username'] ?? '';
    $password     = $data['password'] ?? '';
    $token        = $data['token'] ?? '-';
    $creat_at     = $data['creat_at'] ?? '-';
    $expired_at   = $data['expired_at'] ?? '-';

?>
    <div class="row mb-2">
        <div class="col-4"><small>Profil Pengaturan</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo $setting_name; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>URL (Endpoint)</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo $base_url; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Username</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo htmlspecialchars($data['username']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Password</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo htmlspecialchars($data['password']); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Token</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo $token; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Creat At</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <small class="text text-muted" style="word-break: break-all;">
                <?php echo $creat_at; ?>
            </small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Expired At</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <small class="text text-muted" style="word-break: break-all;">
                <?php echo $expired_at; ?>
            </small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Status</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><?php echo $status_badge; ?></div>
    </div>
<?php
    // Uji Coba Konneksi
    $url_request = "$base_url/_API/get_token.php";

    // CURL REQUEST
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url_request,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query([
            'username' => $username,
            'password' => $password
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded'
        ],
    ));

    $response = curl_exec($curl);
    $curl_error = curl_error($curl);
    curl_close($curl);

    // Validasi CURL Error
    if ($curl_error) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal menghubungi API!<br>Error: '.$curl_error.'</small>
            </div>
        ';
        exit;
    }

    // Decode JSON
    $response_array = json_decode($response, true);

    // Validasi JSON Response
    if (!$response_array) {
        echo '
            <div class="alert alert-danger">
                <small>Response API tidak valid!<br>Raw Response: '.$response.'</small>
            </div>
        ';
        exit;
    }

    // Echo Response API (Debug UI)
    echo '
    <div class="row mb-3">
        <div class="col-12">
            <small><b>Response API:</b></small>
            <pre>'.json_encode($response_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'</pre>
        </div>
    </div>
    ';

    // Validasi status sukses
    if ($response_array['status'] !== 'success') {
        echo '
            <div class="alert alert-danger">
                <small>Gagal membuat token!<br>Pesan: '.$response_array['message'].'</small>
            </div>
        ';
        exit;
    }

    // Ambil data token
    $token      = $response_array['token'];
    $created_at = date('Y-m-d H:i:s', strtotime($response_array['created_at']));
    $expired_at = date('Y-m-d H:i:s', strtotime($response_array['token_expired_at']));

    // UPDATE DATABASE
    $Update = $Conn->prepare("
        UPDATE setting_radix 
        SET token = ?, creat_at = ?, expired_at = ?, status = 1
        WHERE id_setting_radix = ?
    ");

    $Update->bind_param("sssi", $token, $created_at, $expired_at, $id_setting_radix);

    if (!$Update->execute()) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal menyimpan token ke database!<br>Error: '.$Conn->error.'</small>
            </div>
        ';
        exit;
    }

    $Update->close();

    // SUCCESS OUTPUT
    echo '
        <div class="alert alert-success text-center">
            <small>Token berhasil dibuat & disimpan ke database.</small>
        </div>
    ';
    mysqli_stmt_close($stmt);
?>