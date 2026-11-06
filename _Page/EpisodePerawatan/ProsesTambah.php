<?php
    header("Content-Type: application/json; charset=utf-8");

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    /**
     * RESPONSE JSON
     */
    function ResponseEpisodePerawatan($status, $message, $data = null)
    {
        echo json_encode([
            "status"  => $status,
            "message" => $message,
            "data"    => $data
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * VALIDASI SESSION
     */
    if (empty($SessionIdAkses)) {
        ResponseEpisodePerawatan(
            "error",
            "Session akses tidak ditemukan."
        );
    }

    /**
     * AMBIL INPUT POST
     */
    $id_pasien = trim($_POST["id_pasien"] ?? "");
    $id_episode_perawatan_kode = trim($_POST["id_episode_perawatan_kode"] ?? "");
    $id_diagnosis = trim($_POST["id_diagnosis"] ?? "");
    $id_dokter = trim($_POST["id_dokter"] ?? "");
    $date_start = trim($_POST["date_start"] ?? "");
    $status = trim($_POST["status"] ?? "active");

    /**
     * VALIDASI INPUT WAJIB
     */
    if (
        $id_pasien === "" ||
        $id_episode_perawatan_kode === "" ||
        $id_diagnosis === "" ||
        $id_dokter === "" ||
        $date_start === ""
    ) {
        ResponseEpisodePerawatan(
            "error",
            "Semua data wajib diisi."
        );
    }

    /**
     * VALIDASI ID NUMERIK
     */
    $requiredIds = [
        "ID Pasien" => $id_pasien,
        "ID Kode Episode" => $id_episode_perawatan_kode,
        "ID Diagnosis" => $id_diagnosis,
        "ID Dokter" => $id_dokter
    ];

    foreach ($requiredIds as $label => $value) {
        if (!ctype_digit($value) || (int)$value <= 0) {
            ResponseEpisodePerawatan(
                "error",
                "$label tidak valid."
            );
        }
    }

    /**
     * CAST ID KE INTEGER
     */
    $id_pasien = (int)$id_pasien;
    $id_episode_perawatan_kode = (int)$id_episode_perawatan_kode;
    $id_diagnosis = (int)$id_diagnosis;
    $id_dokter = (int)$id_dokter;

    /**
     * VALIDASI STATUS ENUM
     */
    $allowedStatus = [
        "planned",
        "waitlist",
        "active",
        "onhold",
        "finished",
        "cancelled",
        "entered-in-error"
    ];

    if (!in_array($status, $allowedStatus, true)) {
        ResponseEpisodePerawatan(
            "error",
            "Status episode perawatan tidak valid."
        );
    }

    /**
     * VALIDASI TANGGAL
     */
    $dateObject = DateTime::createFromFormat(
        "!Y-m-d",
        $date_start
    );

    if (
        !$dateObject ||
        $dateObject->format("Y-m-d") !== $date_start
    ) {
        ResponseEpisodePerawatan(
            "error",
            "Format tanggal mulai harus YYYY-MM-DD."
        );
    }

    $date_start = $dateObject->format("Y-m-d");

    /**
     * DATE END
     * Kolom date_end bersifat NOT NULL pada database, disamakan dengan date_start.
     */
    $date_end = null;

    /**
     * AMBIL REFERENSI KODE EPISODE
     */
    $stmtKode = mysqli_prepare(
        $Conn,
        "SELECT
            episode_category,
            episode_name,
            episode_display,
            episode_code,
            episode_system
        FROM episode_perawatan_kode
        WHERE id_episode_perawatan_kode = ?
        AND status = 1
        LIMIT 1"
    );

    if (!$stmtKode) {
        ResponseEpisodePerawatan(
            "error",
            "Gagal menyiapkan query kode episode."
        );
    }

    mysqli_stmt_bind_param(
        $stmtKode,
        "i",
        $id_episode_perawatan_kode
    );

    mysqli_stmt_execute($stmtKode);

    $resultKode = mysqli_stmt_get_result($stmtKode);
    $dataKode = mysqli_fetch_assoc($resultKode);

    mysqli_stmt_close($stmtKode);

    if (!$dataKode) {
        ResponseEpisodePerawatan(
            "error",
            "Kode episode perawatan tidak ditemukan atau tidak aktif."
        );
    }

    /**
     * DATA EPISODE
     */
    $episode_name = $dataKode["episode_name"];
    $episode_display = $dataKode["episode_display"];
    $episode_code = $dataKode["episode_code"];
    $episode_system = $dataKode["episode_system"];

    /**
     * GENERATE KODE EPISODE
     */
    $kode_episode_perawatan =
        "EPS-" .
        date("Ymd") .
        "-" .
        GenerateRandomeToken(4);

    /**
     * DATA CREATOR
     */
    $creat_by_id = (int)$SessionIdAkses;
    $creat_by_name = $SessionNama; // Perbaikan: menggunakan $SessionNama
    $creat_at = gmdate("Y-m-d H:i:s");

    /**
     * INSERT EPISODE PERAWATAN
     */
    $sqlInsert = "
        INSERT INTO episode_perawatan (
            kode_episode_perawatan,
            id_pasien,
            id_episode_perawatan_kode,
            episode_name,
            episode_display,
            episode_code,
            episode_system,
            id_diagnosis,
            id_dokter,
            date_start,
            date_end,
            status,
            creat_by_id,
            creat_by_name,
            creat_at
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ";

    $stmtInsert = mysqli_prepare(
        $Conn,
        $sqlInsert
    );

    if (!$stmtInsert) {
        ResponseEpisodePerawatan(
            "error",
            "Gagal menyiapkan query insert episode perawatan."
        );
    }

    /**
     * BIND PARAMETER
     */
    mysqli_stmt_bind_param(
        $stmtInsert,
        "siissssiisssiss",
        $kode_episode_perawatan,
        $id_pasien,
        $id_episode_perawatan_kode,
        $episode_name,
        $episode_display,
        $episode_code,
        $episode_system,
        $id_diagnosis,
        $id_dokter,
        $date_start,
        $date_end,
        $status,
        $creat_by_id,
        $creat_by_name,
        $creat_at
    );

    /**
     * EKSEKUSI INSERT
     */
    if (!mysqli_stmt_execute($stmtInsert)) {
        $errorInsert = mysqli_stmt_error($stmtInsert);
        mysqli_stmt_close($stmtInsert);

        error_log(
            "Insert Episode Perawatan Error: " .
            $errorInsert
        );

        ResponseEpisodePerawatan(
            "error",
            "Gagal menyimpan episode perawatan."
        );
    }

    /**
     * AMBIL ID INSERT
     */
    $id_episode_perawatan = mysqli_insert_id($Conn);

    mysqli_stmt_close($stmtInsert);

    /**
     * LOG AKTIVITAS (Menggunakan urutan parameter helper SaveLog yang benar)
     */
    SaveLog(
        $Conn,
        $SessionIdAkses,
        $SessionNama,
        "Insert Episode Perawatan",
        "Episode Perawatan",
        [
            "id_episode_perawatan"      => $id_episode_perawatan,
            "kode_episode_perawatan"    => $kode_episode_perawatan,
            "id_pasien"                 => $id_pasien,
            "id_episode_perawatan_kode" => $id_episode_perawatan_kode,
            "id_diagnosis"              => $id_diagnosis,
            "id_dokter"                 => $id_dokter,
            "status"                    => $status
        ]
    );

    /**
     * RESPONSE SUKSES
     */
    ResponseEpisodePerawatan(
        "success",
        "Episode perawatan berhasil disimpan.",
        [
            "id_episode_perawatan" => $id_episode_perawatan,
            "kode_episode_perawatan" => $kode_episode_perawatan,
            "status" => $status,
            "date_start" => $date_start,
            "date_end" => $date_end
        ]
    );
?>