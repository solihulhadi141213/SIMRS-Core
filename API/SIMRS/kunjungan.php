<?php
    date_default_timezone_set('UTC');

    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";

    $now = date('Y-m-d H:i:s');
    $service_name = "List Kunjungan";

    // ============================
    // VALIDASI METHOD
    // ============================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            "response" => ["message" => "Metode request tidak diizinkan", "code" => 405],
            "metadata" => []
        ]);
        exit;
    }

    // ============================
    // VALIDASI TOKEN
    // ============================
    $headers = getallheaders();
    if (empty($headers['token'])) {
        http_response_code(400);
        echo json_encode([
            "response" => ["message" => "Token Tidak Boleh Kosong", "code" => 400],
            "metadata" => []
        ]);
        exit;
    }

    $token = validateAndSanitizeInput($headers['token']);

    $stmt = $Conn->prepare("SELECT * FROM api_token WHERE token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $tokenData = $stmt->get_result()->fetch_assoc();

    if (!$tokenData || $tokenData['datetime_expired'] < $now) {
        http_response_code(401);
        echo json_encode([
            "response" => ["message" => "Token Tidak Valid / Expired", "code" => 401],
            "metadata" => []
        ]);
        exit;
    }

    $id_api_access = $tokenData['id_api_access'];

    // ============================
    // PARAMETER REQUEST
    // ============================
    $body = json_decode(file_get_contents("php://input"), true);

    $page       = max(1, (int)($body['page'] ?? 1));
    $limit      = min(100, (int)($body['limit'] ?? 20));
    $keyword    = trim($body['keyword'] ?? "");
    $keyword_by = trim($body['keyword_by'] ?? "");
    $order_by  = trim($body['order_by'] ?? "id_kunjungan");
    $short_by  = strtoupper($body['short_by'] ?? "DESC");

    $posisi = ($page - 1) * $limit;

    // ============================
    // WHITELIST KOLOM
    // ============================
    $allowed_columns = [
        "id_kunjungan","id_pasien","nama","nik","no_bpjs","tanggal",
        "tujuan","dokter","poliklinik","pembayaran","sep","status",
        "tempat_lahir","tanggal_lahir","gender","kontak","pekerjaan"
    ];

    if (!in_array($order_by, $allowed_columns)) {
        $order_by = "id_kunjungan";
    }
    if (!in_array($short_by, ["ASC","DESC"])) {
        $short_by = "DESC";
    }

    // ============================
    // QUERY DASAR
    // ============================
    $baseFrom = "
    FROM kunjungan_utama k
    LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
    ";

    $where = "";
    $params = [];
    $types = "";

    if ($keyword !== "") {
        $where = "WHERE (
            k.id_kunjungan LIKE ? OR
            k.id_pasien LIKE ? OR
            k.nama LIKE ? OR
            k.nik LIKE ? OR
            k.no_bpjs LIKE ? OR
            k.tujuan LIKE ? OR
            k.dokter LIKE ? OR
            p.tempat_lahir LIKE ? OR
            p.gender LIKE ? OR
            p.pekerjaan LIKE ?
        )";

        for ($i=0; $i<10; $i++) {
            $params[] = "%$keyword%";
            $types .= "s";
        }
    }

    // ============================
    // HITUNG TOTAL DATA
    // ============================
    $sqlCount = "SELECT COUNT(*) total $baseFrom $where";
    $stmtCount = $Conn->prepare($sqlCount);
    if ($types) $stmtCount->bind_param($types, ...$params);
    $stmtCount->execute();
    $total = $stmtCount->get_result()->fetch_assoc()['total'];

    $jumlah_halaman = ceil($total / $limit);

    // ============================
    // QUERY DATA
    // ============================
    $sqlData = "
    SELECT
        k.*,
        p.id_ihs,
        p.tempat_lahir,
        p.tanggal_lahir,
        p.gender,
        p.kontak,
        p.kontak_darurat,
        p.penanggungjawab,
        p.golongan_darah,
        p.perkawinan,
        p.pekerjaan,
        p.gambar,
        p.status AS status_pasien
    $baseFrom
    $where
    ORDER BY k.$order_by $short_by
    LIMIT ?, ?
    ";

    $params[] = $posisi;
    $params[] = $limit;
    $types .= "ii";

    $stmtData = $Conn->prepare($sqlData);
    $stmtData->bind_param($types, ...$params);
    $stmtData->execute();
    $result = $stmtData->get_result();

    // ============================
    // BUILD RESPONSE
    // ============================
    $list_kunjungan = [];
    $no = $posisi + 1;

    while ($d = $result->fetch_assoc()) {
        if(empty($d['id_dokter'])){
            $id_dokter           = "";
            $id_ihs_practitioner = "";
            $dokter              = "";
        }else{
            $id_dokter           = $d['id_dokter'];
            $id_ihs_practitioner = getDataDetail($Conn,' dokter','id_dokter',$id_dokter,'id_ihs_practitioner');
            $dokter              = $d['dokter'];
        }
        $list_kunjungan[] = [
            "no_urut"      => $no++,
            "id_kunjungan" => $d['id_kunjungan'],
            "id_ihs"       => $d['id_ihs'],
            "id_pasien"    => $d['id_pasien'],
            "id_encounter" => $d['id_encounter'],
            "nama"         => $d['nama'],
            "alamat"       => [
                "propinsi"  => $d['propinsi'],
                "kabupaten" => $d['kabupaten'],
                "kecamatan" => $d['kecamatan'],
                "desa"      => $d['desa'],
                "alamat"    => $d['alamat']
            ],
            "nik"                 => $d['nik'],
            "no_bpjs"             => $d['no_bpjs'],
            "tanggal"             => $d['tanggal'],
            "tanggal_keluar"      => $d['tanggal_keluar'],
            "sep"                 => $d['sep'],
            "tujuan"              => $d['tujuan'],
            "id_dokter"           => $id_dokter,
            "id_ihs_practitioner" => $id_ihs_practitioner,
            "dokter"              => $dokter,
            "kelas"               => $d['kelas'],
            "ruangan"             => $d['ruangan'],
            "id_poliklinik"       => $d['id_poliklinik'],
            "poliklinik"          => $d['poliklinik'],
            "pembayaran"          => $d['pembayaran'],
            "status"              => $d['status'],

              // DATA PASIEN
            "tempat_lahir"     => $d['tempat_lahir'],
            "tanggal_lahir"    => $d['tanggal_lahir'],
            "gender"           => $d['gender'],
            "kontak"           => $d['kontak'],
            "kontak_darurat"   => $d['kontak_darurat'],
            "penanggung_jawab" => $d['penanggungjawab'],
            "golongan_darah"   => $d['golongan_darah'],
            "perkawinan"       => $d['perkawinan'],
            "pekerjaan"        => $d['pekerjaan'],
            "gambar_pasien"    => $d['gambar'],
            "status_pasien"    => $d['status_pasien']
        ];
    }

    // ============================
    // RESPONSE FINAL
    // ============================
    http_response_code(200);
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time()+600));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, token");

    echo json_encode([
        "response"=>["message"=>"success","code"=>200],
        "metadata"=>[
            "jumlah_total_data"=>$total,
            "jumlah_halaman"=>$jumlah_halaman,
            "curent_page"=>$page,
            "list_kunjungan"=>$list_kunjungan
        ]
    ]);
    exit;
?>
