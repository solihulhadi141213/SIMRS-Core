<?php
// API Select2 untuk pencarian berhalaman pada modal tambah observasi.
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function observasiJson(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function observasiPrepare(mysqli $Conn, string $sql, string $types, array $values): mysqli_stmt
{
    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        error_log('Observasi Select2: gagal menyiapkan query: ' . mysqli_error($Conn));
        observasiJson(['results' => [], 'pagination' => ['more' => false], 'error' => 'Gagal mengambil data.'], 500);
    }
    if ($types !== '') {
        $bind = [$stmt, $types];
        foreach ($values as $index => $value) {
            $values[$index] = $value;
            $bind[] = &$values[$index];
        }
        call_user_func_array('mysqli_stmt_bind_param', $bind);
    }
    if (!mysqli_stmt_execute($stmt)) {
        error_log('Observasi Select2: gagal menjalankan query: ' . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        observasiJson(['results' => [], 'pagination' => ['more' => false], 'error' => 'Gagal mengambil data.'], 500);
    }
    return $stmt;
}

if (empty($SessionIdAkses)) {
    observasiJson(['results' => [], 'pagination' => ['more' => false], 'error' => 'Sesi berakhir. Silakan login kembali.'], 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observasiJson(['results' => [], 'pagination' => ['more' => false], 'error' => 'Metode request tidak valid.'], 405);
}

$action = trim((string) ($_POST['action'] ?? ''));
$search = trim((string) ($_POST['search'] ?? ''));
$like = '%' . $search . '%';
$page = max(1, (int) ($_POST['page'] ?? 1));
$limit = 20;
$offset = ($page - 1) * $limit;
$categoryName = trim((string) ($_POST['category_name'] ?? ''));

switch ($action) {
    case 'pasien':
        $countSql = "SELECT COUNT(*) AS total FROM pasien
                     WHERE status = 'Active' AND (? = '' OR CAST(id_pasien AS CHAR) LIKE ? OR nama LIKE ?)";
        $countTypes = 'sss';
        $countValues = [$search, $like, $like];
        $dataSql = "SELECT id_pasien, nama FROM pasien
                    WHERE status = 'Active' AND (? = '' OR CAST(id_pasien AS CHAR) LIKE ? OR nama LIKE ?)
                    ORDER BY nama ASC, id_pasien ASC LIMIT ? OFFSET ?";
        $dataTypes = 'sssii';
        $dataValues = [$search, $like, $like, $limit, $offset];
        break;

    case 'kunjungan':
        $idPasien = (int) ($_POST['id_pasien'] ?? 0);
        if ($idPasien < 1) {
            observasiJson(['results' => [], 'pagination' => ['more' => false]]);
        }
        $visitFilter = "id_pasien = ? AND status <> 'Batal'
                        AND (? = '' OR CAST(id_kunjungan AS CHAR) LIKE ?
                             OR DATE_FORMAT(datetime_daftar, '%d-%m-%Y %H:%i') LIKE ?
                             OR jenis_kunjungan LIKE ?)";
        $countSql = "SELECT COUNT(*) AS total FROM kunjungan WHERE $visitFilter";
        $countTypes = 'issss';
        $countValues = [$idPasien, $search, $like, $like, $like];
        $dataSql = "SELECT id_kunjungan, jenis_kunjungan, datetime_daftar FROM kunjungan
                    WHERE $visitFilter
                    ORDER BY datetime_daftar DESC, id_kunjungan DESC LIMIT ? OFFSET ?";
        $dataTypes = 'issssii';
        $dataValues = [$idPasien, $search, $like, $like, $like, $limit, $offset];
        break;

    case 'praktisi':
        $practitionerFilter = "(? = '' OR nama_praktisi LIKE ? OR profesi_praktisi LIKE ? OR nik_praktisi LIKE ?)";
        $countSql = "SELECT COUNT(*) AS total FROM praktisi WHERE $practitionerFilter";
        $countTypes = 'ssss';
        $countValues = [$search, $like, $like, $like];
        $dataSql = "SELECT id_praktisi, nama_praktisi, profesi_praktisi FROM praktisi
                    WHERE $practitionerFilter
                    ORDER BY nama_praktisi ASC, id_praktisi ASC LIMIT ? OFFSET ?";
        $dataTypes = 'ssssii';
        $dataValues = [$search, $like, $like, $like, $limit, $offset];
        break;

    case 'kategori':
        $countSql = "SELECT COUNT(DISTINCT category_name) AS total FROM observation_reference
                     WHERE (? = '' OR category_name LIKE ?)";
        $countTypes = 'ss';
        $countValues = [$search, $like];
        $dataSql = "SELECT DISTINCT category_name FROM observation_reference
                    WHERE (? = '' OR category_name LIKE ?)
                    ORDER BY category_name ASC LIMIT ? OFFSET ?";
        $dataTypes = 'ssii';
        $dataValues = [$search, $like, $limit, $offset];
        break;

    case 'referensi':
        if ($categoryName === '') {
            observasiJson(['results' => [], 'pagination' => ['more' => false]]);
        }
        $referenceFilter = "category_name = ? AND (? = '' OR observation_name LIKE ?
                            OR observation_code LIKE ? OR unit_name LIKE ?)";
        $countSql = "SELECT COUNT(*) AS total FROM observation_reference WHERE $referenceFilter";
        $countTypes = 'sssss';
        $countValues = [$categoryName, $search, $like, $like, $like];
        $dataSql = "SELECT id_observation_reference, observation_name, observation_code,
                           unit_name, result_type, result_coded
                    FROM observation_reference WHERE $referenceFilter
                    ORDER BY observation_name ASC, id_observation_reference ASC LIMIT ? OFFSET ?";
        $dataTypes = 'sssssii';
        $dataValues = [$categoryName, $search, $like, $like, $like, $limit, $offset];
        break;

    default:
        observasiJson(['results' => [], 'pagination' => ['more' => false], 'error' => 'Jenis pencarian tidak dikenal.'], 400);
}

$countStmt = observasiPrepare($Conn, $countSql, $countTypes, $countValues);
$countResult = mysqli_stmt_get_result($countStmt);
$total = (int) (mysqli_fetch_assoc($countResult)['total'] ?? 0);
mysqli_stmt_close($countStmt);

$stmt = observasiPrepare($Conn, $dataSql, $dataTypes, $dataValues);
$result = mysqli_stmt_get_result($stmt);
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    switch ($action) {
        case 'pasien':
            $items[] = [
                'id' => (int) $row['id_pasien'],
                'text' => $row['nama'],
                'nama' => $row['nama'],
                'id_pasien' => (string) $row['id_pasien'],
            ];
            break;
        case 'kunjungan':
            $visitDate = date('d-m-Y H:i', strtotime($row['datetime_daftar']));
            $items[] = [
                'id' => (int) $row['id_kunjungan'],
                'text' => $visitDate . ' | ' . $row['jenis_kunjungan'],
                'tanggal_kunjungan' => $visitDate,
                'jenis_kunjungan' => $row['jenis_kunjungan'],
            ];
            break;
        case 'praktisi':
            $items[] = [
                'id' => (int) $row['id_praktisi'],
                'text' => $row['nama_praktisi'],
                'nama_praktisi' => $row['nama_praktisi'],
                'profesi_praktisi' => $row['profesi_praktisi'],
            ];
            break;
        case 'kategori':
            $items[] = ['id' => $row['category_name'], 'text' => $row['category_name']];
            break;
        case 'referensi':
            $items[] = [
                'id' => (int) $row['id_observation_reference'],
                'text' => $row['observation_name'] . ' (' . $row['unit_name'] . ')',
                'observation_name' => $row['observation_name'],
                'observation_code' => $row['observation_code'],
                'unit_name' => $row['unit_name'],
                'result_type' => $row['result_type'],
                'result_coded' => $row['result_coded'],
            ];
            break;
    }
}
mysqli_stmt_close($stmt);

observasiJson([
    'results' => $items,
    'pagination' => ['more' => ($offset + count($items)) < $total],
]);
?>
