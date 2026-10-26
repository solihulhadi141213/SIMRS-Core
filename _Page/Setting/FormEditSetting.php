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
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    };
    $selectedEnvironment = (string) $data['setting_name'];
    $formStatus = (int) $data['status'] === 1 ? 'checked' : '';
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

    echo '
        <input type="hidden" name="id_setting" value="' . $id_setting . '">
        <div class="row mb-3">
            <div class="col-12">
                <label for="setting_name_edit"><small>Lingkungan Pengaturan</small></label>
                <select name="setting_name" id="setting_name_edit" class="form-select" required>';
    foreach (['Development', 'Staging', 'Production'] as $environment) {
        $selected = $selectedEnvironment === $environment ? ' selected' : '';
        echo '<option value="' . $environment . '"' . $selected . '>' . $environment . '</option>';
    }
    echo '
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="base_url_edit"><small>Base URL</small></label>
                <input type="url" name="base_url" id="base_url_edit" class="form-control" required maxlength="255" value="' . $escape($data['base_url']) . '">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_name_edit"><small>Nama Faskes</small></label>
                <input type="text" name="hospital_name" id="hospital_name_edit" class="form-control" required maxlength="255" value="' . $escape($data['hospital_name']) . '">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_address_edit"><small>Alamat</small></label>
                <textarea name="hospital_address" id="hospital_address_edit" class="form-control" required maxlength="255">' . $escape($data['hospital_address']) . '</textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_contact_edit"><small>No. Kontak</small></label>
                <input type="text" name="hospital_contact" id="hospital_contact_edit" class="form-control" required maxlength="255" value="' . $escape($data['hospital_contact']) . '">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_email_edit"><small>Email</small></label>
                <input type="email" name="hospital_email" id="hospital_email_edit" class="form-control" required maxlength="255" value="' . $escape($data['hospital_email']) . '">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_code_edit"><small>Kode Faskes (Kemenkes)</small></label>
                <input type="text" name="hospital_code" id="hospital_code_edit" class="form-control" maxlength="255" value="' . $escape($data['hospital_code']) . '">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_manager_edit"><small>Nama Manajer / Direktur</small></label>
                <input type="text" name="hospital_manager" id="hospital_manager_edit" class="form-control" maxlength="255" value="' . $escape($data['hospital_manager']) . '">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="logo_edit"><small>Logo Faskes</small></label>
                <input type="file" name="logo" id="logo_edit" class="form-control" accept=".png,.jpg,.jpeg,.gif,.ico">
                <img src="' . $escape($logoPath) . '" alt="Logo Faskes saat ini" class="img-thumbnail mb-2" width="96">
                <small class="text-muted d-block">Maksimal 1 MB. Logo baru disimpan pada assets/img/logo/.</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="aktivasi_setting_edit" name="aktivasi_setting" value="1" ' . $formStatus . '>
                    <label class="form-check-label" for="aktivasi_setting_edit">Aktifkan Pengaturan Ini</label>
                </div>
            </div>
        </div>
    ';
?>
