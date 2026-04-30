<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    // Ambil input
    $regency  = $_POST['regency'] ?? '';
    $province = $_POST['province'] ?? '';

    $regency  = trim($regency);
    $province = trim($province);

    // Validasi
    if (empty($regency) || empty($province)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Kabupaten atau Provinsi kosong",
            "kode"    => ""
        ]);
        exit;
    }

    // =======================
    // 1. EXACT MATCH DULU
    // =======================
    $queryExact = "
        SELECT kode_mendagri_2 AS kode
        FROM wilayah
        WHERE LOWER(regency) = LOWER(?)
        AND LOWER(province) = LOWER(?)
        LIMIT 1
    ";

    $stmt = $Conn->prepare($queryExact);
    $stmt->bind_param("ss", $regency, $province);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $kode = trim($row['kode'] ?? '');

        if (!empty($kode)) {
            echo json_encode([
                "status" => "success",
                "kode"   => $kode
            ]);
            exit;
        }
        // kalau kode kosong → lanjut fallback
    }

    // =======================
    // 2. FALLBACK LIKE
    // =======================
    $queryLike = "
        SELECT kode_mendagri_2 AS kode
        FROM wilayah
        WHERE regency LIKE ?
        AND province = ?
        ORDER BY regency ASC
        LIMIT 1
    ";

    $search = "%$regency%";
    $stmt = $Conn->prepare($queryLike);
    $stmt->bind_param("ss", $search, $province);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $kode = trim($row['kode'] ?? '');

        if (!empty($kode)) {
            echo json_encode([
                "status"  => "warning",
                "kode"    => $kode,
                "message" => "Hasil mendekati"
            ]);
        } else {
            echo json_encode([
                "status"  => "invalid",
                "message" => "Data ditemukan tapi kode kosong",
                "kode"    => ""
            ]);
        }

    } else {

        echo json_encode([
            "status"  => "not_found",
            "message" => "Kode tidak ditemukan",
            "kode"    => ""
        ]);
    }