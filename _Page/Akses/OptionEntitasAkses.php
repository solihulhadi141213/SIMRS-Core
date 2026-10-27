<?php
include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "AksesHelper.php";

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo '<option value="">Sesi berakhir</option>';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<option value="">Metode request tidak valid</option>';
    exit;
}

$stmt = $Conn->prepare('SELECT id_akses_entitas, akses FROM akses_entitas ORDER BY akses ASC');
if (!$stmt || !$stmt->execute()) {
    if ($stmt) {
        $stmt->close();
    }
    error_log('Akses: gagal memuat daftar entitas.');
    http_response_code(500);
    echo '<option value="">Daftar entitas gagal dimuat</option>';
    exit;
}

echo '<option value="">Pilih</option>';
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . aksesEscapeHtml($row['id_akses_entitas']) . '">'
        . aksesEscapeHtml($row['akses'])
        . '</option>';
}
$stmt->close();
