<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if(empty($SessionIdAkses)){
        echo json_encode([
            "results" => []
        ]);
        exit;
    }

    // Keyword pencarian
    $search = "";
    if(!empty($_GET['term'])){
        $search = validateAndSanitizeInput($_GET['term']);
    }

    // Paging
    $page = 1;
    if(!empty($_GET['page'])){
        $page = (int) $_GET['page'];
    }

    $limit = 20;
    $offset = ($page - 1) * $limit;

    // Query
    if(!empty($search)){

        // Prepared Statement: cari dan paginasi praktisi.
        $likeSearch = "%$search%";
        $stmt = mysqli_prepare($Conn, "
            SELECT 
                *
            FROM praktisi
            WHERE 
                nama_praktisi LIKE ?
                OR profesi_praktisi LIKE ?
                OR nik_praktisi LIKE ?
            ORDER BY id_praktisi DESC
            LIMIT ?, ?
        ");
        mysqli_stmt_bind_param($stmt, "sssii", $likeSearch, $likeSearch, $likeSearch, $offset, $limit);
        mysqli_stmt_execute($stmt);
        $query = mysqli_stmt_get_result($stmt);

        // Prepared Statement: hitung hasil pencarian praktisi.
        $stmtCount = mysqli_prepare($Conn, "
            SELECT COUNT(*) AS total
            FROM praktisi
            WHERE 
                nama_praktisi LIKE ?
                OR profesi_praktisi LIKE ?
                OR nik_praktisi LIKE ?
        ");
        mysqli_stmt_bind_param($stmtCount, "sss", $likeSearch, $likeSearch, $likeSearch);
        mysqli_stmt_execute($stmtCount);
        $count = (int) (mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'] ?? 0);
    }else{

        // Prepared Statement: ambil halaman seluruh praktisi.
        $stmt = mysqli_prepare($Conn, "
            SELECT *
            FROM praktisi
            ORDER BY id_praktisi DESC
            LIMIT ?, ?
        ");
        mysqli_stmt_bind_param($stmt, "ii", $offset, $limit);
        mysqli_stmt_execute($stmt);
        $query = mysqli_stmt_get_result($stmt);

        // Prepared Statement: hitung seluruh praktisi.
        $stmtCount = mysqli_prepare($Conn, "SELECT COUNT(*) AS total FROM praktisi");
        mysqli_stmt_execute($stmtCount);
        $count = (int) (mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'] ?? 0);
    }

    $data_arr = [];

    while($data = mysqli_fetch_array($query)){

        $sub = [];

        $sub['id'] = $data['id_praktisi'];

        $sub['text'] = $data['nama_praktisi'].' - '.$data['profesi_praktisi'];

        // Custom data
        $sub['nama'] = $data['nama_praktisi'];
        $sub['nik'] = $data['nik_praktisi'];
        $sub['ihs'] = $data['id_practitioner'];
        $sub['profesi'] = $data['profesi_praktisi'];

        $data_arr[] = $sub;
    }

    $more = false;

    if(($offset + $limit) < $count){
        $more = true;
    }

    echo json_encode([
        "results" => $data_arr,
        "pagination" => [
            "more" => $more
        ]
    ]);
?>