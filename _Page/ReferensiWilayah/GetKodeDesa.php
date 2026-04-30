<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    // Ambil input
    $province    = $_POST['province'] ?? '';
    $regency     = $_POST['regency'] ?? '';
    $subdistrict = $_POST['subdistrict'] ?? '';
    $village     = $_POST['village'] ?? '';

    $province    = trim($province);
    $regency     = trim($regency);
    $subdistrict = trim($subdistrict);
    $village     = trim($village);

    // Validasi
    if (empty($province) || empty($regency) || empty($subdistrict) || empty($village)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Data wilayah belum lengkap",
            "kode"    => ""
        ]);
        exit;
    }

    // =======================
    // 1. EXACT MATCH DULU
    // =======================
    $queryExact = "
        SELECT kode_mendagri_4 AS kode
        FROM wilayah
        WHERE LOWER(province) = LOWER(?)
        AND LOWER(regency) = LOWER(?)
        AND LOWER(subdistrict) = LOWER(?)
        AND LOWER(village) = LOWER(?)
        LIMIT 1
    ";

    $stmt = $Conn->prepare($queryExact);
    $stmt->bind_param("ssss", $province, $regency, $subdistrict, $village);
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
        SELECT kode_mendagri_4 AS kode
        FROM wilayah
        WHERE province = ?
        AND regency = ?
        AND subdistrict = ?
        AND village LIKE ?
        ORDER BY village ASC
        LIMIT 1
    ";

    $search = "%$village%";
    $stmt = $Conn->prepare($queryLike);
    $stmt->bind_param("ssss", $province, $regency, $subdistrict, $search);
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
?>