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

        $query = mysqli_query($Conn, "
            SELECT 
                *
            FROM praktisi
            WHERE 
                nama_praktisi LIKE '%$search%'
                OR profesi_praktisi LIKE '%$search%'
                OR nik_praktisi LIKE '%$search%'
            ORDER BY id_praktisi DESC
            LIMIT $offset, $limit
        ");

        $count = mysqli_num_rows(mysqli_query($Conn, "
            SELECT id_praktisi 
            FROM praktisi
            WHERE 
                nama_praktisi LIKE '%$search%'
                OR profesi_praktisi LIKE '%$search%'
                OR nik_praktisi LIKE '%$search%'
        "));
    }else{

        $query = mysqli_query($Conn, "
            SELECT *
            FROM praktisi
            ORDER BY id_praktisi DESC
            LIMIT $offset, $limit
        ");

        $count = mysqli_num_rows(mysqli_query($Conn, "
            SELECT id_praktisi 
            FROM praktisi
        "));
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