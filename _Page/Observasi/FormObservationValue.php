<?php
// Menghasilkan kontrol nilai observasi berdasarkan referensi yang dipilih.
header('Content-Type: text/html; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function observationValueMessage(string $message, int $status = 200): void
{
    http_response_code($status);
    echo '<small class="text-muted">' . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</small>';
    exit;
}

if (empty($SessionIdAkses)) {
    observationValueMessage('Sesi berakhir. Silakan login kembali.', 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observationValueMessage('Metode request tidak valid.', 405);
}

$idObservationReference = filter_var(
    $_POST['id_observation_reference'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
if (!$idObservationReference) {
    observationValueMessage('Pilih jenis observasi terlebih dahulu.');
}

$stmt = mysqli_prepare(
    $Conn,
    'SELECT result_type, result_coded FROM observation_reference WHERE id_observation_reference = ? LIMIT 1'
);
if (!$stmt) {
    error_log('Observasi: gagal menyiapkan query nilai referensi: ' . mysqli_error($Conn));
    observationValueMessage('Gagal mengambil tipe hasil observasi.', 500);
}
mysqli_stmt_bind_param($stmt, 'i', $idObservationReference);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Observasi: gagal mengambil nilai referensi: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    observationValueMessage('Gagal mengambil tipe hasil observasi.', 500);
}
$result = mysqli_stmt_get_result($stmt);
$reference = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$reference) {
    observationValueMessage('Referensi observasi tidak ditemukan.', 404);
}

$escape = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
};
$observationValue = $_POST['observation_value'] ?? '';
if (!is_scalar($observationValue)) {
    $observationValue = '';
}
$observationValue = (string) $observationValue;
$inputId = (($_POST['form_prefix'] ?? '') === 'edit' ? 'edit_' : '') . 'observation_value';

switch ($reference['result_type']) {
    case 'Numeric':
        echo '<input type="number" step="1" required name="observation_value" id="' . $inputId . '" class="form-control" autocomplete="off" value="' . $escape($observationValue) . '">';
        break;

    case 'Decimal':
        echo '<input type="number" step="0.001" inputmode="decimal" required name="observation_value" id="' . $inputId . '" class="form-control" autocomplete="off" value="' . $escape($observationValue) . '">';
        break;

    case 'Coded':
        echo '<select required name="observation_value" id="' . $inputId . '" class="form-control">';
        echo '<option value="">Pilih hasil</option>';
        $codedOptions = json_decode((string) ($reference['result_coded'] ?? ''), true);
        if (is_array($codedOptions)) {
            foreach ($codedOptions as $option) {
                if (!is_array($option) || !array_key_exists('value', $option) || !array_key_exists('label', $option)) {
                    continue;
                }
                $selected = (string) $option['value'] === $observationValue ? ' selected' : '';
                echo '<option value="' . $escape($option['value']) . '"' . $selected . '>' . $escape($option['label']) . '</option>';
            }
        }
        echo '</select>';
        break;

    case 'Boolean':
        echo '<div class="d-flex gap-3">';
        echo '<div class="form-check form-check-inline">'
            . '<input type="radio" required name="observation_value" id="' . $inputId . '" value="1" class="form-check-input"' . ($observationValue === '1' ? ' checked' : '') . '>'
            . '<label for="' . $inputId . '" class="form-check-label">1</label>'
            . '</div>';
        echo '<div class="form-check form-check-inline">'
            . '<input type="radio" required name="observation_value" id="' . $inputId . '_0" value="0" class="form-check-input"' . ($observationValue === '0' ? ' checked' : '') . '>'
            . '<label for="' . $inputId . '_0" class="form-check-label">0</label>'
            . '</div>';
        echo '</div>';
        break;

    case 'Text':
        echo '<input type="text" required name="observation_value" id="' . $inputId . '" class="form-control" autocomplete="off" value="' . $escape($observationValue) . '">';
        break;

    default:
        observationValueMessage('Tipe hasil observasi tidak dikenali.');
}
?>
