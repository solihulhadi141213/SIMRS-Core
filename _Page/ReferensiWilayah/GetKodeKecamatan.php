<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    // Ambil input
    $province    = $_POST['province'] ?? '';
    $regency     = $_POST['regency'] ?? '';
    $subdistrict = $_POST['subdistrict'] ?? '';

    $province    = trim($province);
    $regency     = trim($regency);
    $subdistrict = trim($subdistrict);

    // Validasi
    if (empty($province) || empty($regency) || empty($subdistrict)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Provinsi, Kabupaten, atau Kecamatan kosong",
            "kode"    => ""
        ]);
        exit;
    }

    // =======================
    // 1. EXACT MATCH DULU
    // =======================
    $queryExact = "
        SELECT kode_mendagri_3 AS kode
        FROM wilayah
        WHERE LOWER(province) = LOWER(?)
        AND LOWER(regency) = LOWER(?)
        AND LOWER(subdistrict) = LOWER(?)
        LIMIT 1
    ";

    $stmt = $Conn->prepare($queryExact);
    $stmt->bind_param("sss", $province, $regency, $subdistrict);
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
        SELECT kode_mendagri_3 AS kode
        FROM wilayah
        WHERE province = ?
        AND regency = ?
        AND subdistrict LIKE ?
        ORDER BY subdistrict ASC
        LIMIT 1
    ";

    $search = "%$subdistrict%";
    $stmt = $Conn->prepare($queryLike);
    $stmt->bind_param("sss", $province, $regency, $search);
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
                "message" => "Data ditemukan tapi kode Mendagri kosong",
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