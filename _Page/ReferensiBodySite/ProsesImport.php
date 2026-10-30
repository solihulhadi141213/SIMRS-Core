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
    if (empty($_FILES['file_body_site']['name'])) {
        $response["message"] = "File excel tidak boleh kosong";
        echo json_encode($response);
        exit;
    }

    $fileName = $_FILES['file_body_site']['name'];
    $fileTmp  = $_FILES['file_body_site']['tmp_name'];
    $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExt, ['xlsx', 'xls'])) {
        $response["message"] = "Format file harus excel (.xlsx / .xls)";
        echo json_encode($response);
        exit;
    }

    // Ambil enum kategori dari database
    $allowed_kategori = [];
    $qEnum = mysqli_query($Conn, "SHOW COLUMNS FROM body_site WHERE Field = 'body_site_category'");
    if ($qEnum) {
        $rEnum = mysqli_fetch_assoc($qEnum);
        $type = $rEnum['Type'] ?? '';
        if (preg_match("/^enum\((.*)\)$/i", $type, $matches)) {
            $values = str_getcsv($matches[1], ',', "'", '');
            foreach ($values as $value) {
                $value = trim($value, " '");
                if ($value !== '') {
                    $allowed_kategori[] = $value;
                }
            }
        }
    }

    // Author
    $author_id   = (int)($SessionIdAkses ?? 0);
    $author_name = validateAndSanitizeInput($SessionNama ?? 'Unknown');

    // Datetime UTC
    $datetime_now = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

    // Counter
    $berhasil = 0;
    $gagal    = 0;

    try {

        $spreadsheet = IOFactory::load($fileTmp);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        // Loop data mulai row ke-2 (index 1)
        foreach ($sheet as $key => $row) {

            // Skip header
            if ($key == 0) {
                continue;
            }

            // Kolom: 0 No, 1 Kategori, 2 Nama Body Site, 3 Display, 4 Code, 5 System
            $kategori = trim($row[1] ?? '');
            $nama     = trim($row[2] ?? '');
            $display  = trim($row[3] ?? '');
            $code     = trim($row[4] ?? '');
            $system   = trim($row[5] ?? '');

            // Sanitasi
            if (function_exists('validateAndSanitizeInput')) {
                $kategori = validateAndSanitizeInput($kategori);
                $nama     = validateAndSanitizeInput($nama);
                $display  = validateAndSanitizeInput($display);
                $code     = validateAndSanitizeInput($code);
                $system   = validateAndSanitizeInput($system);
            }

            // Skip kosong
            if ($kategori === '' || $nama === '') {
                $gagal++;
                continue;
            }

            // Validasi kategori
            if (!in_array($kategori, $allowed_kategori, true)) {
                $gagal++;
                continue;
            }

            // Fallback display
            if ($display === '') {
                $display = $nama;
            }

            // Cek duplikat nama
            $query_check = "SELECT id_body_site FROM body_site WHERE body_site_nama = ? LIMIT 1";
            $stmt_check = mysqli_prepare($Conn, $query_check);

            if (!$stmt_check) {
                $gagal++;
                continue;
            }

            mysqli_stmt_bind_param($stmt_check, "s", $nama);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);

            if (mysqli_num_rows($result_check) > 0) {
                mysqli_stmt_close($stmt_check);
                $gagal++;
                continue;
            }

            mysqli_stmt_close($stmt_check);

            // Cek duplikat code (jika ada)
            if ($code !== '') {
                $query_code = "SELECT id_body_site FROM body_site WHERE body_site_code = ? LIMIT 1";
                $stmt_code = mysqli_prepare($Conn, $query_code);
                if ($stmt_code) {
                    mysqli_stmt_bind_param($stmt_code, "s", $code);
                    mysqli_stmt_execute($stmt_code);
                    $result_code = mysqli_stmt_get_result($stmt_code);
                    if (mysqli_num_rows($result_code) > 0) {
                        mysqli_stmt_close($stmt_code);
                        $gagal++;
                        continue;
                    }
                    mysqli_stmt_close($stmt_code);
                }
            }

            // Insert prepare
            $query_insert = "
                INSERT INTO body_site (
                    body_site_category,
                    body_site_nama,
                    body_site_display,
                    body_site_code,
                    body_site_system,
                    datetime_creat,
                    datetime_update,
                    author_id,
                    author_name
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt_insert = mysqli_prepare($Conn, $query_insert);

            if (!$stmt_insert) {
                $gagal++;
                continue;
            }

            mysqli_stmt_bind_param(
                $stmt_insert,
                'sssssssis',
                $kategori,
                $nama,
                $display,
                $code,
                $system,
                $datetime_now,
                $datetime_now,
                $author_id,
                $author_name
            );

            if (mysqli_stmt_execute($stmt_insert)) {
                $berhasil++;
            } else {
                $gagal++;
            }

            mysqli_stmt_close($stmt_insert);
        }

        $response["status"]  = "success";
        $response["message"] = "Import selesai. Berhasil: " . $berhasil . ", Gagal: " . $gagal;

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;

    } catch (Throwable $e) {

        $response["message"] = "Gagal membaca file excel";

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
?>

