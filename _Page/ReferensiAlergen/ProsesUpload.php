<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;

    ob_start();

    error_reporting(0);
    ini_set('display_errors', 0);

    header('Content-Type: application/json; charset=utf-8');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    require '../../vendor/autoload.php';

    // Response default
    $response = [
        "status"  => "error",
        "message" => "Terjadi kesalahan"
    ];

    // Validasi session
    if (empty($SessionIdAkses)) {
        $response["message"] = "Sesi akses sudah berakhir";
        echo json_encode($response);
        exit;
    }

    // Validasi file
    if (empty($_FILES['file_alergen']['name'])) {
        $response["message"] = "File excel tidak boleh kosong";
        echo json_encode($response);
        exit;
    }

    // File
    $fileName = $_FILES['file_alergen']['name'];
    $fileTmp  = $_FILES['file_alergen']['tmp_name'];
    $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validasi extensi
    if (!in_array($fileExt, ['xlsx', 'xls'])) {
        $response["message"] = "Format file harus excel (.xlsx / .xls)";
        echo json_encode($response);
        exit;
    }

    try {

        // Load spreadsheet
        $spreadsheet = IOFactory::load($fileTmp);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        // Mapping kategori
        $allowed_kategori = [
            'food',
            'medication',
            'environment',
            'biologic'
        ];

        // Author
        $author_id   = $SessionIdAkses ?? 0;
        $author_name = $SessionNama ?? 'Unknown';

        // Datetime
        date_default_timezone_set('Asia/Jakarta');
        $datetime_creat = date('Y-m-d H:i:s');

        // Counter
        $berhasil = 0;
        $gagal    = 0;

        // Loop data mulai row ke-2
        foreach ($sheet as $key => $row) {

            // Skip header
            if ($key == 0) {
                continue;
            }

            // Ambil data
            $kategori_alergen = trim(strtolower($row[1] ?? ''));
            $nama_alergen     = trim($row[2] ?? '');
            $code_alergen     = trim($row[3] ?? '');
            $display_alergen  = trim($row[4] ?? '');
            $system_alergen   = trim($row[5] ?? '');

            // Sanitasi
            if (function_exists('validateAndSanitizeInput')) {

                $kategori_alergen = validateAndSanitizeInput($kategori_alergen);
                $nama_alergen     = validateAndSanitizeInput($nama_alergen);
                $code_alergen     = validateAndSanitizeInput($code_alergen);
                $display_alergen  = validateAndSanitizeInput($display_alergen);
                $system_alergen   = validateAndSanitizeInput($system_alergen);
            }

            // Skip kosong
            if (empty($kategori_alergen) || empty($nama_alergen)) {
                $gagal++;
                continue;
            }

            // Validasi kategori
            if (!in_array($kategori_alergen, $allowed_kategori)) {
                $gagal++;
                continue;
            }

            // Cek duplikat
            $query_check = "
                SELECT id_alergi_alergen 
                FROM alergi_alergen 
                WHERE nama_alergen = ?
                LIMIT 1
            ";

            $stmt_check = mysqli_prepare($Conn, $query_check);

            if (!$stmt_check) {
                $gagal++;
                continue;
            }

            mysqli_stmt_bind_param($stmt_check, "s", $nama_alergen);
            mysqli_stmt_execute($stmt_check);

            $result_check = mysqli_stmt_get_result($stmt_check);

            // Skip jika sudah ada
            if (mysqli_num_rows($result_check) > 0) {
                mysqli_stmt_close($stmt_check);
                $gagal++;
                continue;
            }

            mysqli_stmt_close($stmt_check);

            // Insert
            $query_insert = "
                INSERT INTO alergi_alergen (
                    kategori_alergen,
                    nama_alergen,
                    code_alergen,
                    display_alergen,
                    system_alergen,
                    author_id,
                    author_name,
                    datetime_creat,
                    status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt_insert = mysqli_prepare($Conn, $query_insert);

            if (!$stmt_insert) {
                $gagal++;
                continue;
            }

            $status = 1;

            mysqli_stmt_bind_param(
                $stmt_insert,
                "sssssissi",
                $kategori_alergen,
                $nama_alergen,
                $code_alergen,
                $display_alergen,
                $system_alergen,
                $author_id,
                $author_name,
                $datetime_creat,
                $status
            );

            // Execute
            if (mysqli_stmt_execute($stmt_insert)) {
                $berhasil++;
            } else {
                $gagal++;
            }

            mysqli_stmt_close($stmt_insert);
        }

        // Success
        $response["status"] = "success";
        $response["message"] = "Import selesai. Berhasil: ".$berhasil.", Gagal: ".$gagal;

        echo json_encode(
            $response,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        exit;

    } catch (Throwable $e) {

        $response["message"] = "Gagal membaca file excel";

        echo json_encode(
            $response,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        exit;
    }
?>