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

    function esc($Conn, $value)
    {
        if ($value === null) {
            return "NULL";
        }

        return "'" . mysqli_real_escape_string($Conn, $value) . "'";
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

            $checkPasien = mysqli_query($Conn, "
                SELECT id_pasien
                FROM pasien
                WHERE id_pasien='" . mysqli_real_escape_string($Conn, $id_pasien) . "'
            ");

            if ($checkPasien && mysqli_num_rows($checkPasien) > 0) {
                $isUpdate = true;
            }
        }

        // =====================================================
        // VALIDASI DUPLIKAT
        // =====================================================
        if (!$isUpdate) {

            $duplicateWhere = [];

            if (!empty($nik)) {
                $duplicateWhere[] = "nik='" . mysqli_real_escape_string($Conn, $nik) . "'";
            }

            if (!empty($no_bpjs)) {
                $duplicateWhere[] = "no_bpjs='" . mysqli_real_escape_string($Conn, $no_bpjs) . "'";
            }

            if (!empty($duplicateWhere)) {

                $duplicateSql = implode(' OR ', $duplicateWhere);

                $checkDuplicate = mysqli_query($Conn, "
                    SELECT id_pasien
                    FROM pasien
                    WHERE $duplicateSql
                ");

                if ($checkDuplicate && mysqli_num_rows($checkDuplicate) > 0) {

                    $failed++;

                    $detail[] = [
                        'no'         => $excelRow,
                        'id_pasien'  => $id_pasien,
                        'nama'       => $nama,
                        'status'     => 'GAGAL',
                        'keterangan' => 'Duplikat NIK / No BPJS'
                    ];

                    continue;
                }
            }
        }

        // =====================================================
        // QUERY UPDATE
        // =====================================================
        if ($isUpdate) {

            $query = "
                UPDATE pasien SET
                    id_ihs              = " . esc($Conn, $id_ihs) . ",
                    nik                 = " . esc($Conn, $nik) . ",
                    no_bpjs             = " . esc($Conn, $no_bpjs) . ",
                    nama                = " . esc($Conn, $nama) . ",
                    gender              = " . esc($Conn, $gender) . ",
                    tempat_lahir        = " . esc($Conn, $tempat_lahir) . ",
                    tanggal_lahir       = " . esc($Conn, $tanggal_lahir) . ",
                    province            = " . esc($Conn, $province) . ",
                    regency             = " . esc($Conn, $regency) . ",
                    subdistrict         = " . esc($Conn, $subdistrict) . ",
                    village             = " . esc($Conn, $village) . ",
                    street              = " . esc($Conn, $street) . ",
                    postal_code         = " . esc($Conn, $postal_code) . ",
                    kontak              = " . esc($Conn, $kontak) . ",
                    golongan_darah      = " . esc($Conn, $golongan_darah) . ",
                    pernikahan          = " . esc($Conn, $pernikahan) . ",
                    pekerjaan           = " . esc($Conn, $pekerjaan) . ",
                    photo_file_name     = " . esc($Conn, $photo_file_name) . ",
                    status              = " . esc($Conn, $status) . ",
                    id_pasien_relasi    = " . esc($Conn, $id_pasien_relasi) . ",
                    status_relasi       = " . esc($Conn, $status_relasi) . ",
                    id_akses            = " . esc($Conn, $id_akses) . ",
                    petugas_pendaftaran = " . esc($Conn, $petugas_pendaftaran) . ",
                    updated_at          = " . esc($Conn, $updated_at) . "
                WHERE id_pasien='" . mysqli_real_escape_string($Conn, $id_pasien) . "'
            ";

        } else {

            // =================================================
            // QUERY INSERT
            // =================================================
            $query = "
                INSERT INTO pasien (

                    id_ihs,
                    nik,
                    no_bpjs,
                    nama,
                    gender,
                    tempat_lahir,
                    tanggal_lahir,
                    province,
                    regency,
                    subdistrict,
                    village,
                    street,
                    postal_code,
                    kontak,
                    golongan_darah,
                    pernikahan,
                    pekerjaan,
                    photo_file_name,
                    status,
                    id_pasien_relasi,
                    status_relasi,
                    id_akses,
                    petugas_pendaftaran,
                    registered_at,
                    updated_at

                ) VALUES (

                    " . esc($Conn, $id_ihs) . ",
                    " . esc($Conn, $nik) . ",
                    " . esc($Conn, $no_bpjs) . ",
                    " . esc($Conn, $nama) . ",
                    " . esc($Conn, $gender) . ",
                    " . esc($Conn, $tempat_lahir) . ",
                    " . esc($Conn, $tanggal_lahir) . ",
                    " . esc($Conn, $province) . ",
                    " . esc($Conn, $regency) . ",
                    " . esc($Conn, $subdistrict) . ",
                    " . esc($Conn, $village) . ",
                    " . esc($Conn, $street) . ",
                    " . esc($Conn, $postal_code) . ",
                    " . esc($Conn, $kontak) . ",
                    " . esc($Conn, $golongan_darah) . ",
                    " . esc($Conn, $pernikahan) . ",
                    " . esc($Conn, $pekerjaan) . ",
                    " . esc($Conn, $photo_file_name) . ",
                    " . esc($Conn, $status) . ",
                    " . esc($Conn, $id_pasien_relasi) . ",
                    " . esc($Conn, $status_relasi) . ",
                    " . esc($Conn, $id_akses) . ",
                    " . esc($Conn, $petugas_pendaftaran) . ",
                    " . esc($Conn, $registered_at) . ",
                    " . esc($Conn, $updated_at) . "

                )
            ";
        }

        // =====================================================
        // EXECUTE
        // =====================================================
        $execute = mysqli_query($Conn, $query);

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
    sendResponse([
        'status'  => 'success',
        'message' => "
            Insert : $inserted |
            Update : $updated |
            Gagal : $failed
        ",
        'detail' => $detail
    ]);