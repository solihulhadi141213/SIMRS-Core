<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    $province = $_POST['province'] ?? '';
    $province = trim($province);

    if (empty($province)) {
        echo json_encode([
            "status" => "error",
            "message" => "Provinsi kosong",
            "kode" => ""
        ]);
        exit;
    }

    // =======================
    // 1. EXACT MATCH DULU
    // =======================
    $queryExact = "
        SELECT kode_mendagri_1 AS kode
        FROM wilayah
        WHERE LOWER(province) = LOWER(?)
        LIMIT 1
    ";

    $stmt = $Conn->prepare($queryExact);
    $stmt->bind_param("s", $province);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $kode = trim($row['kode'] ?? '');

        if (!empty($kode)) {
            // ✅ hanya kalau ada kode
            echo json_encode([
                "status" => "success",
                "kode"   => $kode
            ]);
            exit;
        }
        // ❌ kalau kosong → lanjut ke fallback
    }

    // =======================
    // 2. FALLBACK LIKE
    // =======================
    $queryLike = "
        SELECT kode_mendagri_1 AS kode
        FROM wilayah
        WHERE province LIKE ?
        ORDER BY province ASC
        LIMIT 1
    ";

    $search = "%$province%";
    $stmt = $Conn->prepare($queryLike);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $kode = trim($row['kode'] ?? '');

        if (!empty($kode)) {
            echo json_encode([
                "status" => "warning", // hasil mendekati
                "kode"   => $kode,
                "message"=> "Hasil mendekati"
            ]);
        } else {
            // 🔥 data ada tapi kode kosong
            echo json_encode([
                "status" => "invalid",
                "message"=> "Data ditemukan tapi kode Mendagri kosong",
                "kode"   => ""
            ]);
        }

    } else {

        echo json_encode([
            "status" => "not_found",
            "message"=> "Kode tidak ditemukan",
            "kode"   => ""
        ]);
    }