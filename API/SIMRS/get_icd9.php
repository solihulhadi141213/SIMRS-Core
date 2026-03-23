<?php
    // ======================================================
    // HEADER RESPONSE (CORS + JSON)
    // ======================================================
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, token");

    // ======================================================
    // ZONA WAKTU, KONEKSI, FUNCTION
    // ======================================================
    date_default_timezone_set('UTC');

    include "../../_Config/Connection.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";

    $now          = date('Y-m-d H:i:s');
    $service_name = "List ICD 10";

    // ======================================================
    // VALIDASI METODE
    // ======================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode([
            "response" => [
                "message" => "Metode request tidak diizinkan",
                "code"    => 405
            ],
            "metadata" => []
        ]);
        exit;
    }

    // ======================================================
    // VALIDASI TOKEN
    // ======================================================
    $headers = getallheaders();

    if (empty($headers['token'])) {
        http_response_code(401);
        echo json_encode([
            "response" => [
                "message" => "Token tidak boleh kosong",
                "code"    => 401
            ],
            "metadata" => []
        ]);
        exit;
    }

    $token = validateAndSanitizeInput($headers['token']);

    $stmt = $Conn->prepare("
        SELECT id_api_token, id_api_access, client_id, datetime_expired
        FROM api_token
        WHERE token = ?
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $dataToken = $stmt->get_result()->fetch_assoc();

    if (!$dataToken) {
        http_response_code(401);
        echo json_encode([
            "response" => [
                "message" => "Token tidak valid",
                "code"    => 401
            ],
            "metadata" => []
        ]);
        exit;
    }

    if ($dataToken['datetime_expired'] < $now) {
        http_response_code(401);
        echo json_encode([
            "response" => [
                "message" => "Token sudah expired",
                "code"    => 401
            ],
            "metadata" => []
        ]);
        exit;
    }

    // ======================================================
    // PARAMETER & DEFAULT VALUE
    // ======================================================
    $limit      = isset($_GET['limit']) ? (int) $_GET['limit'] : 100;
    $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $order_by  = $_GET['order_by']  ?? 'id_diagnosa';
    $short_by  = strtoupper($_GET['short_by'] ?? 'DESC');
    $keyword_by= $_GET['keyword_by'] ?? '';
    $keyword   = $_GET['keyword'] ?? '';

    $limit = ($limit <= 0) ? 100 : $limit;
    $page  = ($page <= 0) ? 1 : $page;

    $offset = ($page - 1) * $limit;

    // ======================================================
    // WHITELIST KOLOM (ANTI SQL INJECTION)
    // ======================================================
    $allowed_columns = [
        'id_diagnosa',
        'kode',
        'long_des',
        'short_des'
    ];

    if (!in_array($order_by, $allowed_columns)) {
        $order_by = 'id_diagnosa';
    }

    if (!in_array($keyword_by, $allowed_columns)) {
        $keyword_by = '';
    }

    if (!in_array($short_by, ['ASC', 'DESC'])) {
        $short_by = 'DESC';
    }

    // ======================================================
    // QUERY COUNT DATA
    // ======================================================
    $where = "WHERE versi = 'ICD9'";
    $params = [];
    $types  = "";

    if (!empty($keyword)) {
        if (!empty($keyword_by)) {
            // Jika keyword_by ditentukan, cari di kolom tertentu saja
            $where .= " AND $keyword_by LIKE ?";
            $params[] = "%$keyword%";
            $types   .= "s";
        } else {
            // Jika keyword_by kosong, cari di semua kolom: kode, long_des, short_des
            $where .= " AND (kode LIKE ? OR long_des LIKE ? OR short_des LIKE ?)";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
            $types   .= "sss";
        }
    }

    $stmtCount = $Conn->prepare("SELECT COUNT(*) AS total FROM diagnosa $where");
    if ($params) {
        $stmtCount->bind_param($types, ...$params);
    }
    $stmtCount->execute();
    $totalData = $stmtCount->get_result()->fetch_assoc()['total'];

    $page_count = ceil($totalData / $limit);

    // ======================================================
    // QUERY DATA ICD9
    // ======================================================
    $sql = "
        SELECT id_diagnosa, kode, long_des, short_des
        FROM diagnosa
        $where
        ORDER BY $order_by $short_by
        LIMIT ? OFFSET ?
    ";

    $stmt = $Conn->prepare($sql);

    if ($params) {
        $typesData = $types . "ii";
        $params[] = $limit;
        $params[] = $offset;
        $stmt->bind_param($typesData, ...$params);
    } else {
        $stmt->bind_param("ii", $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $list = [];
    while ($row = $result->fetch_assoc()) {
        $list[] = $row;
    }

    // ======================================================
    // RESPONSE
    // ======================================================
    http_response_code(200);
    echo json_encode([
        "response" => [
            "message" => "Data ICD-9 berhasil ditampilkan",
            "code"    => 200
        ],
        "metadata" => [
            "data_count" => (int) $totalData,
            "page_count" => (int) $page_count,
            "limit"      => $limit,
            "page"       => $page,
            "order_by"   => $order_by,
            "short_by"   => $short_by,
            "keyword_by" => $keyword_by,
            "keyword"    => $keyword,
            "search_mode" => empty($keyword_by) ? "multi_column_search" : "single_column_search",
            "list"       => $list
        ]
    ]);
    exit;

?>