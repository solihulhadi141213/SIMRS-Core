<?php
// ===============================
// KONFIGURASI AWAL
// ===============================
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/FungsiSirsOnline.php";
include "../../_Config/Session.php";

// ===============================
// VALIDASI SESSION
// ===============================
if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger text-center"><small>Sesi Akses Berakhir! Silahkan Login Ulang!</small></div>';
    exit;
}

// ===============================
// VALIDASI REQUEST
// ===============================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
    exit;
}

if (empty($_POST['id_setting_sirs_online'])) {
    echo '<div class="alert alert-danger">ID tidak boleh kosong.</div>';
    exit;
}

$id_setting_sirs_online = (int) $_POST['id_setting_sirs_online'];

// ===============================
// AMBIL DATA DB (PREPARED)
// ===============================
$stmt = mysqli_prepare($Conn, "SELECT * FROM setting_sirs_online WHERE id_setting_sirs_online = ?");
if (!$stmt) {
    echo '<div class="alert alert-danger">Gagal prepare query.</div>';
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id_setting_sirs_online);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
    exit;
}

$data = mysqli_fetch_assoc($result);

// ===============================
// SET VARIABEL
// ===============================
$nama   = $data['nama_setting_sirs_online'];
$url    = $data['url_sirs_online'];
$id_rs  = $data['id_rs'];
$pass   = $data['password_sirs_online'];
$status = $data['status'];

// Badge status
$status_badge = $status == 1
    ? '<span class="badge bg-success">Aktif</span>'
    : '<span class="badge bg-secondary">Tidak Aktif</span>';

// ===============================
// PROSES CURL + ERROR HANDLING
// ===============================
$metode = "GET";
$response_raw = null;
$error_curl   = null;
$http_code    = null;
$time_total   = null;

$start = microtime(true);

// Manual CURL (lebih fleksibel dari function lama)
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $url . '/fo/index.php/Fasyankes',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => $metode,
    CURLOPT_HTTPHEADER => [
        'X-rs-id: ' . $id_rs,
        'X-Timestamp: ' . time(),
        'X-pass: ' . $pass
    ],
    CURLOPT_TIMEOUT => 20,
    CURLOPT_SSL_VERIFYPEER => false
]);

$response_raw = curl_exec($curl);

if (curl_errno($curl)) {
    $error_curl = curl_error($curl);
}

$http_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$time_total = curl_getinfo($curl, CURLINFO_TOTAL_TIME);

curl_close($curl);

$end = microtime(true);
$duration = round(($end - $start), 3);

// ===============================
// FORMAT RESPONSE JSON
// ===============================
$pretty = '';
$is_json = false;

if (!empty($response_raw)) {
    $decoded = json_decode($response_raw, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        $is_json = true;
        $pretty = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } else {
        $pretty = $response_raw;
    }
} else {
    $pretty = "Tidak ada response dari server.";
}

// ===============================
// STATUS KONEKSI
// ===============================
if ($error_curl) {
    $status_koneksi = '<div class="alert alert-danger">❌ CURL Error: ' . htmlspecialchars($error_curl) . '</div>';
} elseif ($http_code != 200) {
    $status_koneksi = '<div class="alert alert-warning">⚠️ HTTP Status: ' . $http_code . '</div>';
} else {
    $status_koneksi = '<div class="alert alert-success">✅ Koneksi Berhasil</div>';
}
?>

<!-- ===============================
     INFORMASI SETTING
=============================== -->
<div class="row mb-2">
    <div class="col-4"><small>ID</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><small><?php echo $data['id_setting_sirs_online']; ?></small></div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Profil</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><small><?php echo htmlspecialchars($nama); ?></small></div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>URL</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><small><?php echo htmlspecialchars($url); ?></small></div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>ID RS</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><small><?php echo htmlspecialchars($id_rs); ?></small></div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Password</small></div>
    <div class="col-1">:</div>
    <div class="col-7">
        <small>************</small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1">:</div>
    <div class="col-7"><?php echo $status_badge; ?></div>
</div>

<!-- ===============================
     STATUS KONEKSI
=============================== -->
<?php echo $status_koneksi; ?>

<div class="mb-2">
    <small class="text-muted">
        HTTP Code: <?php echo $http_code ?? '-'; ?> |
        Response Time: <?php echo $time_total ?? $duration; ?> sec
    </small>
</div>

<!-- ===============================
     RESPONSE VIEWER
=============================== -->
<div style="background:#0d1117;color:#c9d1d9;padding:10px;border-radius:6px;">
    <pre style="max-height:400px;overflow:auto;margin:0;"><?php echo htmlspecialchars($pretty); ?></pre>
</div>

<?php mysqli_stmt_close($stmt); ?>