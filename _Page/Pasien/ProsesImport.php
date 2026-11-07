<?php
    // =========================================================
    // IMPORT DATA PASIEN
    // =========================================================

    // =========================================================
    // RESPONSE JSON
    // =========================================================
    header('Content-Type: application/json; charset=utf-8');

    // =========================================================
    // BUFFER
    // =========================================================
    ob_start();

    // =========================================================
    // ERROR REPORT
    // =========================================================
    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    // =========================================================
    // CONNECTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // PHPSPREADSHEET
    // =========================================================
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Shared\Date;

    // =========================================================
    // FUNCTION RESPONSE JSON
    // =========================================================
    function sendResponse($data)
    {
        // Bersihkan buffer
        while (ob_get_level()) {
            ob_end_clean();
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {

        sendResponse([
            'status'  => 'error',
            'message' => 'Sesi akses sudah berakhir!'
        ]);
    }

    // =========================================================
    // VALIDASI AKSES
    // =========================================================
    $ijin_akses = GetStatusAccess($Conn, $SessionIdAkses, 'wrA8sp3Y4r');

    if ($ijin_akses !== true) {

        sendResponse([
            'status'  => 'error',
            'message' => 'Anda tidak memiliki ijin import data pasien!'
        ]);
    }

    // =========================================================
    // VALIDASI FILE
    // =========================================================
    if (empty($_FILES['file_pasien']['tmp_name'])) {

        sendResponse([
            'status'  => 'error',
            'message' => 'File excel tidak ditemukan!'
        ]);
    }

    // =========================================================
    // FILE INFO
    // =========================================================
    $fileTmp  = $_FILES['file_pasien']['tmp_name'];
    $fileName = $_FILES['file_pasien']['name'];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // =========================================================
    // VALIDASI EXTENSION
    // =========================================================
    if (!in_array($extension, ['xlsx', 'xls'])) {

        sendResponse([
            'status'  => 'error',
            'message' => 'Format file harus xlsx atau xls!'
        ]);
    }

    // =========================================================
    // LOAD EXCEL
    // =========================================================
    try {

        $spreadsheet = IOFactory::load($fileTmp);

        $sheet = $spreadsheet->getActiveSheet();

        $rows = $sheet->toArray(null, true, true, false);

    } catch (Exception $e) {

        sendResponse([
            'status'  => 'error',
            'message' => 'Gagal membaca file excel!',
            'debug'   => $e->getMessage()
        ]);
    }

    // =========================================================
    // VALIDASI ROW
    // =========================================================
    if (count($rows) <= 1) {

        sendResponse([
            'status'  => 'error',
            'message' => 'Data excel kosong!'
        ]);
    }

    // =========================================================
    // HELPER
    // =========================================================
    function normalizeValue($value)
    {
        $value = trim((string)$value);

        if ($value == '' || $value == '-') {
            return null;
        }

        return $value;
    }

    function excelDate($value)
    {
        if (empty($value) || $value == '-') {
            return null;
        }

        try {

            if (is_numeric($value)) {
                return date('Y-m-d', Date::excelToTimestamp($value));
            }

            return date('Y-m-d', strtotime($value));

        } catch (Exception $e) {

            return null;
        }
    }

    function excelDatetime($value)
    {
        if (empty($value) || $value == '-') {
            return date('Y-m-d H:i:s');
        }

        try {

            if (is_numeric($value)) {
                return date('Y-m-d H:i:s', Date::excelToTimestamp($value));
            }

            return date('Y-m-d H:i:s', strtotime($value));

        } catch (Exception $e) {

            return date('Y-m-d H:i:s');
        }
    }

    // =========================================================
    // COUNTER
    // =========================================================
    $inserted = 0;
    $updated  = 0;
    $failed   = 0;

    // =========================================================
    // DETAIL RESULT
    // =========================================================
    $detail = [];

    // =========================================================
    // LOOP DATA
    // =========================================================
    for ($i = 1; $i < count($rows); $i++) {

        $row = $rows[$i];

        $excelRow = $i + 1;

        // =====================================================
        // MAPPING DATA
        // =====================================================
        $id_pasien            = normalizeValue($row[0]  ?? null);
        $id_ihs               = normalizeValue($row[1]  ?? null);
        $nik                  = normalizeValue($row[2]  ?? null);
        $no_bpjs              = normalizeValue($row[3]  ?? null);
        $nama                 = normalizeValue($row[4]  ?? null);
        $gender               = normalizeValue($row[5]  ?? null);
        $tempat_lahir         = normalizeValue($row[6]  ?? null);
        $tanggal_lahir        = excelDate($row[7]  ?? null);
        $province             = normalizeValue($row[8]  ?? null);
        $regency              = normalizeValue($row[9]  ?? null);
        $subdistrict          = normalizeValue($row[10] ?? null);
        $village              = normalizeValue($row[11] ?? null);
        $street               = normalizeValue($row[12] ?? null);
        $postal_code          = normalizeValue($row[13] ?? null);
        $kontak               = normalizeValue($row[14] ?? null);
        $golongan_darah       = normalizeValue($row[15] ?? null);
        $pernikahan           = normalizeValue($row[16] ?? null);
        $pekerjaan            = normalizeValue($row[17] ?? null);
        $photo_file_name      = normalizeValue($row[18] ?? null);
        $status               = normalizeValue($row[19] ?? 'Active');
        $id_pasien_relasi     = normalizeValue($row[20] ?? null);
        $status_relasi        = normalizeValue($row[21] ?? null);
        $id_akses             = normalizeValue($row[22] ?? null);
        $petugas_pendaftaran  = normalizeValue($row[23] ?? $SessionNama);
        $registered_at        = excelDatetime($row[24] ?? null);
        $updated_at           = date('Y-m-d H:i:s');

        // =====================================================
        // VALIDASI NAMA
        // =====================================================
        if (empty($nama)) {

            $failed++;

            $detail[] = [
                'no'         => $excelRow,
                'id_pasien'  => $id_pasien,
                'nama'       => '-',
                'status'     => 'GAGAL',
                'keterangan' => 'Nama pasien kosong'
            ];

            continue;
        }

        // =====================================================
        // CEK UPDATE
        // =====================================================
        $isUpdate = false;

        if (!empty($id_pasien)) {

            // Prepared Statement: periksa apakah ID pasien sudah ada.
            $stmtPasien = mysqli_prepare($Conn, "
                SELECT id_pasien
                FROM pasien
                WHERE id_pasien=?
            ");
            mysqli_stmt_bind_param($stmtPasien, "s", $id_pasien);
            mysqli_stmt_execute($stmtPasien);
            $checkPasien = mysqli_stmt_get_result($stmtPasien);

            if ($checkPasien && mysqli_num_rows($checkPasien) > 0) {
                $isUpdate = true;
            }
            mysqli_stmt_close($stmtPasien);
        }

        // =====================================================
        // VALIDASI DUPLIKAT
        // =====================================================
        if (!$isUpdate) {

            $duplicateWhere = [];
            $duplicateValues = [];

            if (!empty($nik)) {
                $duplicateWhere[] = "nik=?";
                $duplicateValues[] = $nik;
            }

            if (!empty($no_bpjs)) {
                $duplicateWhere[] = "no_bpjs=?";
                $duplicateValues[] = $no_bpjs;
            }

            if (!empty($duplicateWhere)) {

                // Prepared Statement: periksa NIK dan nomor BPJS duplikat.
                $checkDuplicateStmt = mysqli_prepare($Conn, "
                    SELECT id_pasien
                    FROM pasien
                    WHERE " . implode(' OR ', $duplicateWhere) . "
                ");
                $duplicateBind = [$checkDuplicateStmt, str_repeat('s', count($duplicateValues))];
                foreach ($duplicateValues as $key => $value) {
                    $duplicateBind[] = &$duplicateValues[$key];
                }
                call_user_func_array('mysqli_stmt_bind_param', $duplicateBind);
                mysqli_stmt_execute($checkDuplicateStmt);
                $checkDuplicate = mysqli_stmt_get_result($checkDuplicateStmt);

                if ($checkDuplicate && mysqli_num_rows($checkDuplicate) > 0) {

                    $failed++;

                    $detail[] = [
                        'no'         => $excelRow,
                        'id_pasien'  => $id_pasien,
                        'nama'       => $nama,
                        'status'     => 'GAGAL',
                        'keterangan' => 'Duplikat NIK / No BPJS'
                    ];

                    mysqli_stmt_close($checkDuplicateStmt);
                    continue;
                }
                mysqli_stmt_close($checkDuplicateStmt);
            }
        }

        $fields = [
            'id_ihs', 'nik', 'no_bpjs', 'nama', 'gender', 'tempat_lahir',
            'tanggal_lahir', 'province', 'regency', 'subdistrict', 'village',
            'street', 'postal_code', 'kontak', 'golongan_darah', 'pernikahan',
            'pekerjaan', 'photo_file_name', 'status', 'id_pasien_relasi',
            'status_relasi', 'id_akses', 'petugas_pendaftaran', 'registered_at',
            'updated_at'
        ];
        $values = [
            $id_ihs, $nik, $no_bpjs, $nama, $gender, $tempat_lahir,
            $tanggal_lahir, $province, $regency, $subdistrict, $village,
            $street, $postal_code, $kontak, $golongan_darah, $pernikahan,
            $pekerjaan, $photo_file_name, $status, $id_pasien_relasi,
            $status_relasi, $id_akses, $petugas_pendaftaran, $registered_at,
            $updated_at
        ];

        if ($isUpdate) {
            $updateFields = array_merge(array_slice($fields, 0, 23), ['updated_at']);
            $updateValues = array_merge(array_slice($values, 0, 23), [$updated_at, $id_pasien]);
            $query = "UPDATE pasien SET " . implode(' = ?, ', $updateFields) . " = ? WHERE id_pasien = ?";
            $executeValues = $updateValues;
        } else {
            $query = "INSERT INTO pasien (" . implode(', ', $fields) . ") VALUES (" . implode(', ', array_fill(0, count($fields), '?')) . ")";
            $executeValues = $values;
        }

        // Prepared Statement: simpan perubahan data pasien menggunakan nilai terikat.
        $stmt = mysqli_prepare($Conn, $query);
        $executeBind = [$stmt, str_repeat('s', count($executeValues))];
        foreach ($executeValues as $key => $value) {
            $executeBind[] = &$executeValues[$key];
        }
        call_user_func_array('mysqli_stmt_bind_param', $executeBind);
        $execute = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // =====================================================
        // RESULT
        // =====================================================
        if ($execute) {

            if ($isUpdate) {

                $updated++;

                $detail[] = [
                    'no'         => $excelRow,
                    'id_pasien'  => $id_pasien,
                    'nama'       => $nama,
                    'status'     => 'UPDATE',
                    'keterangan' => 'Berhasil update data'
                ];

            } else {

                $lastId = mysqli_insert_id($Conn);

                $inserted++;

                $detail[] = [
                    'no'         => $excelRow,
                    'id_pasien'  => $lastId,
                    'nama'       => $nama,
                    'status'     => 'INSERT',
                    'keterangan' => 'Berhasil insert data'
                ];
            }

        } else {

            $failed++;

            $detail[] = [
                'no'         => $excelRow,
                'id_pasien'  => $id_pasien,
                'nama'       => $nama,
                'status'     => 'GAGAL',
                'keterangan' => mysqli_error($Conn)
            ];
        }
    }

    // =========================================================
    // RESPONSE
    // =========================================================
    // =========================================================
    // SIMPAN LOG
    // =========================================================
    $category_log = 'Pasien';
    $title_log    = 'Import Data Pasien';
    SaveLog($Conn, $SessionIdAkses, $SessionNama, $title_log, $category_log, [
        'file_name' => $fileName,
        'inserted'  => $inserted,
        'updated'   => $updated,
        'failed'    => $failed
    ]);

    sendResponse([
        'status'  => 'success',
        'message' => "
            Insert : $inserted |
            Update : $updated |
            Gagal : $failed
        ",
        'detail' => $detail
    ]);