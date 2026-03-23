<?php
    /**
     * API Detail Kunjungan - Optimized Version
     * Script ini mengambil data detail kunjungan beserta data pasien terkait
     * dengan optimasi query database menggunakan JOIN untuk performa yang lebih baik
     */

    // ============================
    // KONFIGURASI AWAL
    // ============================
    date_default_timezone_set('UTC');

    // Include file konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";

    // Waktu saat ini untuk logging dan validasi
    $now          = date('Y-m-d H:i:s');
    $service_name = "Detail Kunjungan";

    // ============================
    // VALIDASI METODE REQUEST
    // ============================
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode([
            "response" => ["message" => "Metode request tidak diizinkan", "code" => 405],
            "metadata" => []
        ]);
        exit;
    }

    // ============================
    // VALIDASI DAN PEMBACAAN TOKEN
    // ============================
    $headers = getallheaders();
    
    // Validasi keberadaan token
    if (empty($headers['token'])) {
        http_response_code(400);
        echo json_encode([
            "response" => ["message" => "Token Tidak Boleh Kosong", "code" => 400],
            "metadata" => []
        ]);
        exit;
    }

    // Sanitasi token input
    $token = validateAndSanitizeInput($headers['token']);

    // Query untuk validasi token dengan prepared statement
    $stmt = $Conn->prepare("SELECT id_api_token, id_api_access, client_id, datetime_expired 
                           FROM api_token 
                           WHERE token = ?");
    
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            "response" => ["message" => "Error pada saat validasi token: " . $Conn->error, "code" => 500],
            "metadata" => []
        ]);
        exit;
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $tokenResult = $stmt->get_result();
    $tokenData = $tokenResult->fetch_assoc();

    // Validasi token: harus ada dan belum expired
    if (!$tokenData) {
        http_response_code(401);
        echo json_encode([
            "response" => ["message" => "Token Tidak Valid", "code" => 401],
            "metadata" => []
        ]);
        exit;
    }

    if ($tokenData['datetime_expired'] < $now) {
        http_response_code(401);
        echo json_encode([
            "response" => ["message" => "Token Sudah Expired", "code" => 401],
            "metadata" => []
        ]);
        exit;
    }

    $id_api_access = $tokenData['id_api_access'];
    $stmt->close();

    // ============================
    // VALIDASI PARAMETER ID KUNJUNGAN
    // ============================
    if (empty($_GET['id'])) {
        http_response_code(400);
        echo json_encode([
            "response" => ["message" => "ID Kunjungan Tidak Boleh Kosong", "code" => 400],
            "metadata" => []
        ]);
        exit;
    }

    // Sanitasi input ID kunjungan
    $id_kunjungan = validateAndSanitizeInput($_GET['id']);

    // ============================
    // QUERY OPTIMASI: JOIN TABEL KUNJUNGAN DAN PASIEN
    // ============================
    /**
     * OPTIMASI YANG DILAKUKAN:
     * 1. Menggunakan single JOIN query daripada 2 query terpisah
     * 2. Mengurangi round-trip ke database dari 2 menjadi 1
     * 3. Menggunakan SELECT hanya kolom yang diperlukan
     * 4. Menggunakan mysqli_prepare untuk keamanan SQL injection
     */
    
    // Query dengan JOIN antara kunjungan_utama dan pasien
    $sql = "SELECT 
                -- Kolom dari tabel kunjungan_utama
                k.id_kunjungan,
                k.id_encounter,
                k.id_pasien,
                k.no_antrian,
                k.sep,
                k.noRujukan,
                k.skdp,
                k.tanggal,
                k.keluhan,
                k.tujuan,
                k.id_dokter,
                k.dokter,
                k.id_poliklinik,
                k.poliklinik,
                k.kelas,
                k.ruangan,
                k.id_kasur,
                k.DiagAwal,
                k.rujukan_dari,
                k.rujukan_ke,
                k.pembayaran,
                k.cara_keluar,
                k.tanggal_keluar,
                k.status AS status_kunjungan,
                k.id_akses,
                k.nama_petugas AS petugas_kunjungan,
                k.updatetime AS updatetime_kunjungan,
                
                -- Kolom dari tabel pasien
                p.id_ihs,
                p.tanggal_daftar,
                p.nama AS nama_pasien,
                p.gender,
                p.tempat_lahir,
                p.tanggal_lahir,
                p.kontak,
                p.kontak_darurat,
                p.penanggungjawab,
                p.nik,
                p.no_bpjs AS no_bpjs,
                p.propinsi AS propinsi_pasien,
                p.kabupaten AS kabupaten_pasien,
                p.kecamatan AS kecamatan_pasien,
                p.desa AS desa_pasien,
                p.alamat AS alamat_pasien,
                p.perkawinan,
                p.pekerjaan,
                p.status AS status_pasien,
                p.nama_petugas AS petugas_pasien,
                p.updatetime AS updatetime_pasien
            FROM kunjungan_utama k
            LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
            WHERE k.id_kunjungan = ?";
    
    // Prepare statement untuk keamanan dan performa
    $stmt = mysqli_prepare($Conn, $sql);
    
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            "response" => ["message" => 'Terjadi kesalahan pada saat mempersiapkan query database. Keterangan: ' . mysqli_error($Conn), "code" => 500],
            "metadata" => []
        ]);
        exit;
    }

    // Bind parameter ID kunjungan
    mysqli_stmt_bind_param($stmt, "s", $id_kunjungan);
    
    // Eksekusi query
    if (!mysqli_stmt_execute($stmt)) {
        http_response_code(500);
        echo json_encode([
            "response" => ["message" => 'Terjadi kesalahan pada saat mengeksekusi query. Keterangan: ' . mysqli_error($Conn), "code" => 500],
            "metadata" => []
        ]);
        exit;
    }

    // Ambil hasil query
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode([
            "response" => ["message" => 'Terjadi kesalahan pada saat mengambil data. Keterangan: ' . mysqli_error($Conn), "code" => 500],
            "metadata" => []
        ]);
        exit;
    }

    // Fetch data hasil query
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    // Validasi apakah data ditemukan
    if (!$data) {
        http_response_code(404);
        echo json_encode([
            "response" => ["message" => 'Data Kunjungan Tidak Ditemukan', "code" => 404],
            "metadata" => []
        ]);
        exit;
    }

    // ============================
    // FORMAT DATA PASIEN
    // ============================
    /**
     * Struktur data pasien dipisah untuk mempertahankan struktur response asli
     * namun datanya sudah diambil dari single query JOIN
     */
    $pasien = [
        "id_pasien"       => $data['id_pasien'] ?? '',
        "id_ihs"          => $data['id_ihs'] ?? '',
        "tanggal_daftar"  => $data['tanggal_daftar'] ?? '',
        "nama"            => $data['nama_pasien'] ?? '',
        "gender"          => $data['gender'] ?? '',
        "tempat_lahir"    => $data['tempat_lahir'] ?? '',
        "tanggal_lahir"   => $data['tanggal_lahir'] ?? '',
        "kontak"          => $data['kontak'] ?? '',
        "kontak_darurat"  => $data['kontak_darurat'] ?? '',
        "penanggungjawab" => $data['penanggungjawab'] ?? '',
        "nik"             => $data['nik'] ?? '',
        "no_bpjs"         => $data['no_bpjs'] ?? '',
        "propinsi"        => $data['propinsi_pasien'] ?? '',
        "kabupaten"       => $data['kabupaten_pasien'] ?? '',
        "kecamatan"       => $data['kecamatan_pasien'] ?? '',
        "desa"            => $data['desa_pasien'] ?? '',
        "alamat"          => $data['alamat_pasien'] ?? '',
        "perkawinan"      => $data['perkawinan'] ?? '',
        "pekerjaan"       => $data['pekerjaan'] ?? '',
        "status"          => $data['status_pasien'] ?? '',
        "nama_petugas"    => $data['petugas_pasien'] ?? '',
        "updatetime"      => $data['updatetime_pasien'] ?? '',
    ];

    // ============================
    // FORMAT METADATA RESPONSE
    // ============================
    /**
     * Struktur metadata dipertahankan sesuai dengan original script
     * untuk menjaga kompatibilitas dengan sistem yang sudah ada
     */
    $metadata = [
        "id_kunjungan"   => $data['id_kunjungan'] ?? '',
        "id_encounter"   => $data['id_encounter'] ?? '',
        "pasien"         => $pasien,
        "no_antrian"     => $data['no_antrian'] ?? '',
        "sep"            => $data['sep'] ?? '',
        "noRujukan"      => $data['noRujukan'] ?? '',
        "skdp"           => $data['skdp'] ?? '',
        "tanggal"        => $data['tanggal'] ?? '',
        "keluhan"        => $data['keluhan'] ?? '',
        "tujuan"         => $data['tujuan'] ?? '',
        "id_dokter"      => $data['id_dokter'] ?? '',
        "dokter"         => $data['dokter'] ?? '',
        "id_poliklinik"  => $data['id_poliklinik'] ?? '',
        "poliklinik"     => $data['poliklinik'] ?? '',
        "kelas"          => $data['kelas'] ?? '',
        "ruangan"        => $data['ruangan'] ?? '',
        "id_kasur"       => $data['id_kasur'] ?? '',
        "DiagAwal"       => $data['DiagAwal'] ?? '',
        "rujukan_dari"   => $data['rujukan_dari'] ?? '',
        "rujukan_ke"     => $data['rujukan_ke'] ?? '',
        "pembayaran"     => $data['pembayaran'] ?? '',
        "cara_keluar"    => $data['cara_keluar'] ?? '',
        "tanggal_keluar" => $data['tanggal_keluar'] ?? '',
        "status"         => $data['status_kunjungan'] ?? '',
        "id_akses"       => $data['id_akses'] ?? '',
        "nama_petugas"   => $data['petugas_kunjungan'] ?? '',
        "updatetime"     => $data['updatetime_kunjungan'] ?? ''
    ];

    // ============================
    // LOGGING API REQUEST (Optional)
    // ============================
    /**
     * Logging bisa diaktifkan jika diperlukan untuk tracking
     */
    $logQuery = "INSERT INTO api_log 
                (id_api_access, datetime_log, service_name, response_code, response_message) 
                VALUES (?, ?, ?, ?, ?)";
    
    $logStmt = $Conn->prepare($logQuery);
    if ($logStmt) {
        $response_message = "success";
        $response_code = 200;
        $logStmt->bind_param("sssis", $id_api_access, $now, $service_name, $response_code, $response_message);
        $logStmt->execute();
        $logStmt->close();
    }

    // ============================
    // KIRIM RESPONSE
    // ============================
    http_response_code(200);
    
    // Set headers untuk cache control dan CORS
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + 600));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-Type: application/json; charset=utf-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, token, x-token");

    // Kirim response JSON
    echo json_encode([
        "response" => [
            "message" => "success",
            "code"    => 200
        ],
        "metadata" => $metadata
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
    // ============================
    // CLEANUP RESOURCE
    // ============================
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    
    if (isset($Conn)) {
        mysqli_close($Conn);
    }
    
    exit;
?>