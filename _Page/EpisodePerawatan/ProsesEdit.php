
<?php
    // ==========================================
    // Proses Edit Episode Perawatan
    // ==========================================

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
            "Session akses tidak ditemukan. Silakan login ulang."
        );
    }

    /**
     * AMBIL INPUT POST
     */
    $id_episode_perawatan      = trim($_POST["id_episode_perawatan"] ?? "");
    $id_pasien                 = trim($_POST["id_pasien"] ?? "");
    $id_episode_perawatan_kode = trim($_POST["id_episode_perawatan_kode"] ?? "");
    $id_diagnosis              = trim($_POST["id_diagnosis"] ?? "");
    $id_dokter                 = trim($_POST["id_dokter"] ?? "");
    $date_start                = trim($_POST["date_start"] ?? "");
    $status                    = trim($_POST["status"] ?? "");
    $updateSatuSehat = false;

    if (array_key_exists("update_satusehat", $_POST)) {
        if (
            !is_string($_POST["update_satusehat"]) ||
            $_POST["update_satusehat"] !== "1"
        ) {
            ResponseEpisodePerawatan(
                "error",
                "Pilihan sinkronisasi SATUSEHAT tidak valid."
            );
        }
        $updateSatuSehat = true;
    }

    /**
     * VALIDASI INPUT WAJIB
     */
    if (
        $id_episode_perawatan === "" ||
        $id_pasien === "" ||
        $id_episode_perawatan_kode === "" ||
        $id_diagnosis === "" ||
        $id_dokter === "" ||
        $date_start === "" ||
        $status === ""
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
        "ID Episode Perawatan" => $id_episode_perawatan,
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
    $id_episode_perawatan      = (int)$id_episode_perawatan;
    $id_pasien                 = (int)$id_pasien;
    $id_episode_perawatan_kode = (int)$id_episode_perawatan_kode;
    $id_diagnosis              = (int)$id_diagnosis;
    $id_dokter                 = (int)$id_dokter;

    /**
     * VALIDASI STATUS
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
     * VALIDASI DATE START
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
     * AMBIL REFERENSI KODE EPISODE
     */
    $stmtKode = mysqli_prepare(
        $Conn,
        "SELECT
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
        error_log("Prepare Kode Episode Error: " . mysqli_error($Conn));

        ResponseEpisodePerawatan(
            "error",
            "Gagal menyiapkan query referensi kode episode."
        );
    }

    mysqli_stmt_bind_param(
        $stmtKode,
        "i",
        $id_episode_perawatan_kode
    );

    if (!mysqli_stmt_execute($stmtKode)) {
        error_log("Execute Kode Episode Error: " . mysqli_stmt_error($stmtKode));
        mysqli_stmt_close($stmtKode);

        ResponseEpisodePerawatan(
            "error",
            "Gagal mengambil referensi kode episode."
        );
    }

    $resultKode = mysqli_stmt_get_result($stmtKode);
    $dataKode = mysqli_fetch_assoc($resultKode);

    mysqli_stmt_close($stmtKode);

    if (!$dataKode) {
        ResponseEpisodePerawatan(
            "error",
            "Referensi kode episode tidak ditemukan atau tidak aktif."
        );
    }

    /**
     * DATA REFERENSI
     */
    $episode_name    = $dataKode["episode_name"];
    $episode_display = $dataKode["episode_display"];
    $episode_code    = $dataKode["episode_code"];
    $episode_system  = $dataKode["episode_system"];

    /**
     * CEK DATA EPISODE
     *
     * date_end hanya dibaca untuk mempertahankan
     * nilainya pada response dan log.
     */
    $stmtCheck = mysqli_prepare(
        $Conn,
        "SELECT
            id_episode_perawatan,
            date_end,
            IdEpisodeOfCare
        FROM episode_perawatan
        WHERE id_episode_perawatan = ?
        LIMIT 1"
    );

    if (!$stmtCheck) {
        error_log("Prepare Check Episode Error: " . mysqli_error($Conn));

        ResponseEpisodePerawatan(
            "error",
            "Gagal menyiapkan query pemeriksaan episode."
        );
    }

    mysqli_stmt_bind_param(
        $stmtCheck,
        "i",
        $id_episode_perawatan
    );

    if (!mysqli_stmt_execute($stmtCheck)) {
        error_log("Execute Check Episode Error: " . mysqli_stmt_error($stmtCheck));
        mysqli_stmt_close($stmtCheck);

        ResponseEpisodePerawatan(
            "error",
            "Gagal memeriksa data episode perawatan."
        );
    }

    $resultCheck = mysqli_stmt_get_result($stmtCheck);
    $dataEpisode = mysqli_fetch_assoc($resultCheck);

    mysqli_stmt_close($stmtCheck);

    if (!$dataEpisode) {
        ResponseEpisodePerawatan(
            "error",
            "Data episode perawatan tidak ditemukan."
        );
    }

    // Ambil date_end yang sudah tersimpan
    $date_end = $dataEpisode["date_end"];
    $idEpisodeOfCare = trim($dataEpisode["IdEpisodeOfCare"] ?? "");

    if ($updateSatuSehat && $idEpisodeOfCare === "") {
        ResponseEpisodePerawatan(
            "error",
            "EpisodeOfCare belum memiliki ID SATUSEHAT, sehingga tidak dapat diperbarui."
        );
    }

    /**
     * UPDATE EPISODE PERAWATAN
     *
     * date_end sengaja tidak dimasukkan ke UPDATE.
     * Nilai date_end di database tidak akan berubah.
     */
    $sqlUpdate = "
        UPDATE episode_perawatan SET
            id_pasien = ?,
            id_episode_perawatan_kode = ?,
            episode_name = ?,
            episode_display = ?,
            episode_code = ?,
            episode_system = ?,
            id_diagnosis = ?,
            id_dokter = ?,
            date_start = ?,
            status = ?
        WHERE id_episode_perawatan = ?
    ";

    $stmtUpdate = mysqli_prepare(
        $Conn,
        $sqlUpdate
    );

    if (!$stmtUpdate) {
        error_log("Prepare Update Episode Error: " . mysqli_error($Conn));

        ResponseEpisodePerawatan(
            "error",
            "Gagal menyiapkan query update episode perawatan."
        );
    }

    /**
     * BIND PARAMETER
     *
     * i = integer
     * s = string
     *
     * Total 11 parameter.
     * date_end tidak diikutsertakan.
     */
    mysqli_stmt_bind_param(
        $stmtUpdate,
        "iissssiissi",
        $id_pasien,
        $id_episode_perawatan_kode,
        $episode_name,
        $episode_display,
        $episode_code,
        $episode_system,
        $id_diagnosis,
        $id_dokter,
        $date_start,
        $status,
        $id_episode_perawatan
    );

    /**
     * EKSEKUSI UPDATE
     */
    if (!mysqli_stmt_execute($stmtUpdate)) {
        $errorUpdate = mysqli_stmt_error($stmtUpdate);

        mysqli_stmt_close($stmtUpdate);

        error_log("Update Episode Perawatan Error: " . $errorUpdate);

        ResponseEpisodePerawatan(
            "error",
            "Gagal memperbarui data episode perawatan."
        );
    }

    $affectedRows = mysqli_stmt_affected_rows($stmtUpdate);

    mysqli_stmt_close($stmtUpdate);

    /**
     * LOG AKTIVITAS
     */
    SaveLog(
        $Conn,
        $SessionIdAkses,
        $SessionNama,
        "Update Episode Perawatan",
        "Episode Perawatan",
        [
            "id_episode_perawatan"      => $id_episode_perawatan,
            "id_pasien"                 => $id_pasien,
            "id_episode_perawatan_kode" => $id_episode_perawatan_kode,
            "id_diagnosis"              => $id_diagnosis,
            "id_dokter"                 => $id_dokter,
            "date_start"                => $date_start,
            "date_end"                  => $date_end,
            "status"                    => $status
        ]
    );

    /**
     * PERBARUI RESOURCE EPISODE OF CARE DI SATUSEHAT
     */
    if ($updateSatuSehat) {
        $satuSehatResult = UpdateEpisodeOfCareSatuSehat(
            $Conn,
            $id_episode_perawatan,
            $idEpisodeOfCare
        );

        if (($satuSehatResult['status'] ?? '') !== 'success') {
            ResponseEpisodePerawatan(
                'error',
                'Data lokal tersimpan, tetapi ' .
                ($satuSehatResult['message'] ?? 'update SATUSEHAT gagal.')
            );
        }
    }
    /**
     * RESPONSE SUKSES
     */
    ResponseEpisodePerawatan(
        "success",
        $updateSatuSehat
            ? "Episode perawatan dan data SATUSEHAT berhasil diperbarui."
            : "Episode perawatan berhasil diperbarui.",
        [
            "id_episode_perawatan" => $id_episode_perawatan,
            "status"               => $status,
            "date_start"           => $date_start,
            "date_end"             => $date_end,
            "affected_rows"        => $affectedRows
        ]
    );
?>
