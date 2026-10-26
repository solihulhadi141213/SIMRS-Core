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
        SELECT setting_name, base_url, hospital_name, hospital_address, hospital_contact,
               hospital_email, hospital_code, hospital_manager, logo, status
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
        return htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');
    };
    $status = (int) $data['status'] === 1 ? 'Aktif' : 'Tidak Aktif';

    $logoName = basename((string) $data['logo']);
    $logoPath = 'assets/img/logo/no-image.jpg';
    if ($logoName !== '') {
        if (is_file(__DIR__ . '/../../assets/img/logo/' . $logoName)) {
            $logoPath = 'assets/img/logo/' . rawurlencode($logoName);
        } elseif (is_file(__DIR__ . '/../../assets/images/' . $logoName)) {
            $logoPath = 'assets/images/' . rawurlencode($logoName);
        } elseif (is_file(__DIR__ . '/../../_File/Setting/' . $logoName)) {
            $logoPath = '_File/Setting/' . rawurlencode($logoName);
        }
    }

    foreach ([
        'Lingkungan Pengaturan' => $data['setting_name'],
        'Base URL' => $data['base_url'],
        'Nama Faskes' => $data['hospital_name'],
        'Alamat' => $data['hospital_address'],
        'Nomor Kontak' => $data['hospital_contact'],
        'Email' => $data['hospital_email'],
        'Kode Faskes' => $data['hospital_code'],
        'Manajer / Direktur' => $data['hospital_manager'],
        'Status' => $status
    ] as $label => $value) {
        echo '
            <div class="row mb-2">
                <div class="col-4"><small>' . $escape($label) . '</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text-muted">' . $escape($value) . '</small></div>
            </div>
        ';
    }
    echo '
        <div class="row mb-2 align-items-center">
            <div class="col-4"><small>Logo</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><img src="' . htmlspecialchars($logoPath, ENT_QUOTES, 'UTF-8') . '" alt="Logo Faskes" class="img-thumbnail" width="96"></div>
        </div>
    ';
?>
