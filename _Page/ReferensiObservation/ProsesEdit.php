<?php
header('Content-Type: application/json');

// =====================================================
// CONNECTION, FUNCTION & SESSION
// =====================================================
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

// =====================================================
// VALIDASI SESSION
// =====================================================
if (empty($SessionIdAkses)) {
    echo json_encode([
        "status"  => "error",
        "message" => "Sesi akses sudah berakhir. Silahkan login ulang."
    ]);
    exit;
}

// =====================================================
// VALIDASI ID
// =====================================================
if (empty($_POST['id_observation_reference'])) {
    echo json_encode([
        "status"  => "error",
        "message" => "ID Referensi Observation tidak boleh kosong."
    ]);
    exit;
}

// =====================================================
// AMBIL DATA
// =====================================================
$id_observation_reference = validateAndSanitizeInput($_POST['id_observation_reference']);

$category_name       = validateAndSanitizeInput($_POST['category_name'] ?? '');
$category_code       = validateAndSanitizeInput($_POST['category_code'] ?? '');
$category_display    = validateAndSanitizeInput($_POST['category_display'] ?? '');
$category_system     = validateAndSanitizeInput($_POST['category_system'] ?? '');

$observation_name    = validateAndSanitizeInput($_POST['observation_name'] ?? '');
$observation_code    = validateAndSanitizeInput($_POST['observation_code'] ?? '');
$observation_display = validateAndSanitizeInput($_POST['observation_display'] ?? '');
$observation_system  = validateAndSanitizeInput($_POST['observation_system'] ?? '');

$result_type         = validateAndSanitizeInput($_POST['result_type'] ?? '');

$unit_name           = validateAndSanitizeInput($_POST['unit_name'] ?? '');
$unit_code           = validateAndSanitizeInput($_POST['unit_code'] ?? '');
$unit_display        = validateAndSanitizeInput($_POST['unit_display'] ?? '');
$unit_system         = validateAndSanitizeInput($_POST['unit_system'] ?? '');

// =====================================================
// VALIDASI MANDATORY
// =====================================================
if (empty($category_name)) {
    echo json_encode([
        "status"  => "error",
        "message" => "Kategori observasi tidak boleh kosong."
    ]);
    exit;
}

if (empty($observation_name)) {
    echo json_encode([
        "status"  => "error",
        "message" => "Nama observasi tidak boleh kosong."
    ]);
    exit;
}

if (empty($result_type)) {
    echo json_encode([
        "status"  => "error",
        "message" => "Result type tidak boleh kosong."
    ]);
    exit;
}

// =====================================================
// HANDLE UNIT
// =====================================================
if (
    $result_type != "Numeric" &&
    $result_type != "Decimal"
) {
    $unit_name    = "";
    $unit_code    = "";
    $unit_display = "";
    $unit_system  = "";
}

// =====================================================
// HANDLE RESULT CODED
// =====================================================
$result_coded = null;

if ($result_type == "Coded") {

    $labels = $_POST['label'] ?? [];
    $values = $_POST['value'] ?? [];

    $coded_array = [];

    if (!empty($labels)) {

        foreach ($labels as $key => $label) {

            $label = trim($label);
            $value = trim($values[$key] ?? '');

            if ($label == '' || $value == '') {
                continue;
            }

            $coded_array[] = [
                "label" => $label,
                "value" => $value
            ];
        }
    }

    if (empty($coded_array)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Minimal harus ada 1 alternatif jawaban untuk tipe Coded."
        ]);
        exit;
    }

    $result_coded = json_encode(
        $coded_array,
        JSON_UNESCAPED_UNICODE
    );
}

// =====================================================
// VALIDASI DATA ADA
// =====================================================
$sql = "SELECT id_observation_reference
        FROM observation_reference
        WHERE id_observation_reference=?";

$stmt = $Conn->prepare($sql);
$stmt->bind_param(
    "i",
    $id_observation_reference
);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {

    echo json_encode([
        "status"  => "error",
        "message" => "Data referensi observation tidak ditemukan."
    ]);
    exit;
}

$stmt->close();

// =====================================================
// UPDATE DATA
// =====================================================
$sql = "
    UPDATE observation_reference SET
        category_name=?,
        category_code=?,
        category_display=?,
        category_system=?,

        observation_name=?,
        observation_code=?,
        observation_display=?,
        observation_system=?,

        unit_name=?,
        unit_code=?,
        unit_display=?,
        unit_system=?,

        result_type=?,
        result_coded=?

    WHERE id_observation_reference=?
";

$stmt = $Conn->prepare($sql);

$stmt->bind_param(
    "ssssssssssssssi",

    $category_name,
    $category_code,
    $category_display,
    $category_system,

    $observation_name,
    $observation_code,
    $observation_display,
    $observation_system,

    $unit_name,
    $unit_code,
    $unit_display,
    $unit_system,

    $result_type,
    $result_coded,

    $id_observation_reference
);

if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Referensi observation berhasil diperbarui."
    ]);

} else {

    echo json_encode([
        "status"  => "error",
        "message" => "Gagal memperbarui data. ".$stmt->error
    ]);
}

$stmt->close();
$Conn->close();