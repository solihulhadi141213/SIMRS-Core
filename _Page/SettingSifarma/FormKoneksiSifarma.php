<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
        exit;
    }

    if (empty($_POST['id_setting_sifarma'])) {
        echo '<div class="alert alert-danger">ID Setting Sifarma tidak boleh kosong.</div>';
        exit;
    }

    $id_setting_sifarma = (int) $_POST['id_setting_sifarma'];

    $query = "SELECT * FROM setting_sifarma WHERE id_setting_sifarma = ?";
    $stmt  = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<div class="alert alert-danger">Gagal prepare query.</div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_setting_sifarma);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-warning">Data Setting Sifarma tidak ditemukan.</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    $setting_name = $data['setting_name'] ?? '';
    $base_url     = $data['base_url'] ?? '';
    $username     = $data['username'] ?? '';
    $password     = $data['password'] ?? '';
    $token_db     = !empty($data['token']) ? $data['token'] : '-';
    $creat_at_db  = !empty($data['creat_at']) ? $data['creat_at'] : '-';
    $expired_at_db = !empty($data['expired_at']) ? $data['expired_at'] : '-';
    $status_badge = ($data['status'] == 1)
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Tidak Aktif</span>';
?>
    <div class="row mb-2">
        <div class="col-4"><small>Profil Pengaturan</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($setting_name); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>URL (Endpoint)</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted"><?php echo htmlspecialchars($base_url); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Username</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo htmlspecialchars($username); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Password</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo htmlspecialchars($password); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Token</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text text-muted" style="word-break: break-all;"><?php echo htmlspecialchars($token_db); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Creat At</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <small class="text text-muted" style="word-break: break-all;">
                <?php echo htmlspecialchars($creat_at_db); ?>
            </small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small><i>Expired At</i></small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <small class="text text-muted" style="word-break: break-all;">
                <?php echo htmlspecialchars($expired_at_db); ?>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4"><small>Status</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><?php echo $status_badge; ?></div>
    </div>
<?php
    $base_url = rtrim($base_url, '/');
    $url_request = $base_url . '/_API/GenerateToken.php';

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
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($curl_error) {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-danger">
                <small>Gagal menghubungi API!<br>Error: '.htmlspecialchars($curl_error).'</small>
            </div>
        ';
        exit;
    }

    $response_array = json_decode($response, true);

    if (!is_array($response_array)) {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-danger">
                <small>Response API tidak valid!<br>HTTP Code: '.(int) $http_code.'</small>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <small><b>Raw Response:</b></small>
                    <pre>'.htmlspecialchars((string) $response).'</pre>
                </div>
            </div>
        ';
        exit;
    }

    echo '
        <div class="row mb-3">
            <div class="col-12">
                <small><b>Response API:</b></small>
                <pre>'.htmlspecialchars(json_encode($response_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)).'</pre>
            </div>
        </div>
    ';

    if (($response_array['status'] ?? '') !== 'success') {
        $message = $response_array['message'] ?? 'Tidak ada pesan error dari API.';
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-danger">
                <small>Gagal membuat token!<br>Pesan: '.htmlspecialchars($message).'</small>
            </div>
        ';
        exit;
    }

    $token = trim((string) ($response_array['token'] ?? ''));
    $created_at_raw = $response_array['created_at'] ?? '';
    $expired_at_raw = $response_array['token_expired_at'] ?? '';

    if (empty($token) || empty($created_at_raw) || empty($expired_at_raw)) {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-danger">
                <small>Response sukses, tetapi data token tidak lengkap.</small>
            </div>
        ';
        exit;
    }

    $created_at = date('Y-m-d H:i:s', strtotime($created_at_raw));
    $expired_at = date('Y-m-d H:i:s', strtotime($expired_at_raw));

    if ($created_at === '1970-01-01 00:00:00' || $expired_at === '1970-01-01 00:00:00') {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-danger">
                <small>Format tanggal token dari API tidak valid.</small>
            </div>
        ';
        exit;
    }

    mysqli_begin_transaction($Conn);

    try {
        $stmtUpdate = mysqli_prepare(
            $Conn,
            "UPDATE setting_sifarma
             SET token = ?, creat_at = ?, expired_at = ?
             WHERE id_setting_sifarma = ?"
        );

        if (!$stmtUpdate) {
            throw new Exception('Gagal menyiapkan update token.');
        }

        mysqli_stmt_bind_param(
            $stmtUpdate,
            "sssi",
            $token,
            $created_at,
            $expired_at,
            $id_setting_sifarma
        );

        if (!mysqli_stmt_execute($stmtUpdate)) {
            mysqli_stmt_close($stmtUpdate);
            throw new Exception('Gagal menyimpan token ke database.');
        }

        mysqli_stmt_close($stmtUpdate);
        mysqli_commit($Conn);

        echo '
            <div class="alert alert-success text-center">
                <small>Token berhasil dibuat dan disimpan ke database.</small>
            </div>
        ';
    } catch (Exception $e) {
        mysqli_rollback($Conn);
        echo '
            <div class="alert alert-danger">
                <small>'.htmlspecialchars($e->getMessage()).'</small>
            </div>
        ';
    }

    mysqli_stmt_close($stmt);
?>
