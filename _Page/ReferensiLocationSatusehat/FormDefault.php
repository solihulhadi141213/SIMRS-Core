<?php
    header('Content-Type: application/json; charset=utf-8');

    // Load koneksi, helper SATUSEHAT, dan sesi pengguna.
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Kirim response JSON dengan HTTP status yang sesuai.
    $sendResponse = static function ($status, $message, $FormDefaultHtml = '', $httpStatus = 200) {
        http_response_code($httpStatus);
        echo json_encode(
            array_merge([
                'status' => $status,
                'message' => $message
            ], [
                'FormDefaultHtml' => $FormDefaultHtml
            ]),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
        exit;
    };

    // Pastikan pengguna memiliki sesi aktif.
    if (empty($SessionIdAkses)) {
        $sendResponse('error', 'Sesi akses sudah berakhir. Silakan login ulang.', '', 401);
    }

    // Hanya terima request POST.
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        $sendResponse('error', 'Metode request tidak valid.', '', 405);
    }

    // Ambil dan validasi ID Location dari request.
    $idLocationInput = $_POST['id_location'] ?? '';
    if (!is_scalar($idLocationInput)) {
        $sendResponse('error', 'ID Location tidak valid.', '', 400);
    }
    $idLocation = trim((string)$idLocationInput);
    if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $idLocation)) {
        $sendResponse('error', 'ID Location tidak valid.', '', 400);
    }

    // Escape nilai dinamis sebelum ditampilkan sebagai HTML.
    $escape = static function ($value) {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    };

    // Cek apakah location ini sudah menjadi default_location_id pada setting_satusehat aktif.
    $currentDefault = getDataDetail(
        $Conn,
        'setting_satusehat',
        'status_setting_satusehat',
        1,
        'default_location_id'
    );
    $isAlreadyDefault = ($currentDefault === $idLocation);

    // Susun HTML form konfirmasi default location dengan radio button.
    $formHtml = '';
    $formHtml .= '<input type="hidden" name="id_location" value="' . $escape($idLocation) . '">';

    $formHtml .= '<div class="row mb-3">';
    $formHtml .= '<div class="col-12">';
    $formHtml .= '<small class="text-muted"><b>ID Location:</b> ' . $escape($idLocation) . '</small>';
    $formHtml .= '</div>';
    $formHtml .= '</div>';

    $formHtml .= '<div class="row mb-3">';
    $formHtml .= '<div class="col-12">';
    $formHtml .= '<small class="text-muted">Pilih opsi verifikasi di bawah ini:</small>';
    $formHtml .= '</div>';
    $formHtml .= '</div>';

    // Opsi 1: Set sebagai default
    $checkedYes = $isAlreadyDefault ? '' : ' checked';
    $formHtml .= '<div class="row mb-3">';
    $formHtml .= '<div class="col-12">';
    $formHtml .= '<div class="form-check">';
    $formHtml .= '<input class="form-check-input" type="radio" name="set_default" id="set_default_yes" value="1"' . $checkedYes . '>';
    $formHtml .= '<label class="form-check-label" for="set_default_yes">';
    $formHtml .= 'Ya, set sebagai default_location_id';
    $formHtml .= '</label>';
    $formHtml .= '</div>';
    $formHtml .= '</div>';
    $formHtml .= '</div>';

    // Opsi 2: Batalkan default
    $checkedNo = $isAlreadyDefault ? ' checked' : '';
    $formHtml .= '<div class="row mb-3">';
    $formHtml .= '<div class="col-12">';
    $formHtml .= '<div class="form-check">';
    $formHtml .= '<input class="form-check-input" type="radio" name="set_default" id="set_default_no" value="0"' . $checkedNo . '>';
    $formHtml .= '<label class="form-check-label" for="set_default_no">';
    $formHtml .= 'Tidak, batalkan default_location_id';
    $formHtml .= '</label>';
    $formHtml .= '</div>';
    $formHtml .= '</div>';
    $formHtml .= '</div>';

    // Keterangan status saat ini
    if ($isAlreadyDefault) {
        $formHtml .= '<div class="alert alert-info mb-0"><small>Status saat ini: Location ini <b>sudah</b> ditetapkan sebagai default_location_id.</small></div>';
    } else {
        $formHtml .= '<div class="alert alert-info mb-0"><small>Status saat ini: Location ini <b>belum</b> ditetapkan sebagai default_location_id.</small></div>';
    }

    $sendResponse('success', 'Form default location berhasil dimuat.', $formHtml);
?>
