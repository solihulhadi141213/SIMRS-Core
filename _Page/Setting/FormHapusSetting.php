<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger text-center"><small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small></div>';
        exit;
    }

    $id_setting = filter_input(INPUT_POST, 'id_setting', FILTER_VALIDATE_INT);
    if (!$id_setting || $id_setting < 1) {
        echo '<div class="alert alert-danger text-center"><small>ID Pengaturan Tidak Valid!</small></div>';
        exit;
    }

    $stmt = $Conn->prepare("
        SELECT setting_name, base_url, hospital_name, status
        FROM setting
        WHERE id_setting = ?
    ");
    $stmt->bind_param("i", $id_setting);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if (!$data) {
        echo '<div class="alert alert-danger text-center"><small>Data Pengaturan Tidak Ditemukan!</small></div>';
        exit;
    }

    $escape = static function ($value): string {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    };
    $warning = (int) $data['status'] === 1
        ? 'Pengaturan aktif yang dihapus akan menyebabkan aplikasi tidak memiliki pengaturan aktif.'
        : 'Data pengaturan ini akan dihapus secara permanen.';

    echo '
        <input type="hidden" name="id_setting" value="' . $id_setting . '">
        <div class="row mb-2">
            <div class="col-4"><small>Lingkungan Pengaturan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . $escape($data['setting_name']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Faskes</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . $escape($data['hospital_name']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Base URL</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . $escape($data['base_url']) . '</small></div>
        </div>
        <div class="alert alert-warning text-center mt-3">
            <b>PENTING!</b><br>
            ' . $escape($warning) . '<br>
            <b>Apakah Anda yakin ingin menghapus data ini?</b>
        </div>
    ';
?>
