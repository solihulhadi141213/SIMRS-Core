
<?php
    // ==========================================
    // FORM KIRIM EPISODE OF CARE
    // ==========================================

    header("Content-Type: application/json; charset=utf-8");

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // ==========================================
    // RESPONSE JSON
    // ==========================================

    function ResponseFormKirim($status, $message, $html = ""){
        echo json_encode([
            "status"  => $status,
            "message" => $message,
            "html"    => $html
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }

    // ==========================================
    // VALIDASI SESSION
    // ==========================================

    if (empty($SessionIdAkses)) {
        ResponseFormKirim(
            "error",
            "Session akses tidak ditemukan. Silakan login ulang."
        );
    }

    // ==========================================
    // VALIDASI INPUT
    // ==========================================

    $id_episode_perawatan = trim($_POST["id_episode_perawatan"] ?? "");

    if (
        $id_episode_perawatan === "" ||
        !ctype_digit($id_episode_perawatan) ||
        (int)$id_episode_perawatan <= 0
    ) {
        ResponseFormKirim(
            "error",
            "ID Episode Perawatan tidak valid."
        );
    }

    $id_episode_perawatan = (int)$id_episode_perawatan;

    // ==========================================
    // AMBIL DETAIL EPISODE PERAWATAN
    // ==========================================

    $sql = "
        SELECT
            ep.id_episode_perawatan,
            ep.kode_episode_perawatan,
            ep.IdEpisodeOfCare,
            ep.id_pasien,
            ep.id_episode_perawatan_kode,
            ep.episode_name,
            ep.episode_display,
            ep.episode_code,
            ep.episode_system,
            ep.id_diagnosis,
            ep.id_dokter,
            ep.date_start,
            ep.date_end,
            ep.status,

            p.id_ihs,
            p.nama AS nama_pasien,
            p.nik,
            p.gender,
            p.tanggal_lahir,

            d.id_ihs_practitioner,
            d.nama AS nama_dokter,

            dg.id_condition,
            dg.icd_kode,
            dg.icd_deskripsi,
            dg.jenis_diagnosis,

            epk.episode_category

        FROM episode_perawatan ep

        LEFT JOIN pasien p
            ON ep.id_pasien = p.id_pasien

        LEFT JOIN dokter d
            ON ep.id_dokter = d.id_dokter

        LEFT JOIN diagnosis dg
            ON ep.id_diagnosis = dg.id_diagnosis

        LEFT JOIN episode_perawatan_kode epk
            ON ep.id_episode_perawatan_kode =
            epk.id_episode_perawatan_kode

        WHERE ep.id_episode_perawatan = ?

        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    if (!$stmt) {
        error_log("Prepare Form Kirim Episode Error: " . mysqli_error($Conn));

        ResponseFormKirim(
            "error",
            "Gagal menyiapkan query data episode."
        );
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id_episode_perawatan
    );

    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute Form Kirim Episode Error: " . mysqli_stmt_error($stmt));

        mysqli_stmt_close($stmt);

        ResponseFormKirim(
            "error",
            "Gagal mengambil data episode perawatan."
        );
    }

    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if (!$data) {
        ResponseFormKirim(
            "error",
            "Data episode perawatan tidak ditemukan."
        );
    }

    // ==========================================
    // HELPER
    // ==========================================

    function EscapeKirim($value)
    {
        return htmlspecialchars(
            (string)($value ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );
    }

    function FormatTanggalKirim($tanggal)
    {
        if (empty($tanggal)) {
            return "-";
        }

        return date("d-m-Y", strtotime($tanggal));
    }

    // ==========================================
    // CHECKLIST KELENGKAPAN PAYLOAD
    // ==========================================

    $checklist = [];

    $checklist[] = [
        "label" => "Identitas Pasien SATUSEHAT",
        "value" => $data["id_ihs"],
        "description" => "Patient/{id_ihs}"
    ];

    $checklist[] = [
        "label" => "Status Episode Perawatan",
        "value" => $data["status"],
        "description" => "EpisodeOfCare.status"
    ];

    $checklist[] = [
        "label" => "Kode Episode Perawatan",
        "value" => $data["episode_code"],
        "description" => "EpisodeOfCare.type.coding.code"
    ];

    $checklist[] = [
        "label" => "System Episode Perawatan",
        "value" => $data["episode_system"],
        "description" => "EpisodeOfCare.type.coding.system"
    ];

    $checklist[] = [
        "label" => "Display Episode Perawatan",
        "value" => $data["episode_display"],
        "description" => "EpisodeOfCare.type.coding.display"
    ];

    $checklist[] = [
        "label" => "Tanggal Mulai",
        "value" => $data["date_start"],
        "description" => "EpisodeOfCare.period.start"
    ];

    $checklist[] = [
        "label" => "Diagnosis SATUSEHAT",
        "value" => $data["id_condition"],
        "description" => "Condition/{id_condition}"
    ];

    $checklist[] = [
        "label" => "Practitioner Dokter SATUSEHAT",
        "value" => $data["id_ihs_practitioner"],
        "description" => "Practitioner/{id_ihs_practitioner}"
    ];

    // ==========================================
    // HITUNG STATUS CHECKLIST
    // ==========================================

    $totalChecklist = count($checklist);
    $totalLengkap = 0;

    foreach ($checklist as $item) {
        if (trim((string)$item["value"]) !== "") {
            $totalLengkap++;
        }
    }

    $semuaLengkap = ($totalChecklist === $totalLengkap);

    // ==========================================
    // STATUS RESPONSE
    // ==========================================

    $statusResponse = $semuaLengkap ? "ready" : "incomplete";

    // ==========================================
    // MULAI MEMBUAT HTML FORM
    // ==========================================

    $html = "";

    // ==========================================
    // INPUT HIDDEN
    // ==========================================

    $html .= '
    <input
        type="hidden"
        name="id_episode_perawatan"
        value="' . EscapeKirim($data["id_episode_perawatan"]) . '"
    >
    ';

    // ==========================================
    // DETAIL EPISODE PERAWATAN
    // ==========================================

    $html .= '
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="mb-1">
                        <i class="bi bi-clipboard2-pulse"></i>
                        Detail Episode Perawatan
                    </h6>

                    <small class="text-muted">
                        ' . EscapeKirim($data["kode_episode_perawatan"]) . '
                    </small>
                </div>
    ';

    // Status SATUSEHAT

    if (!empty($data["IdEpisodeOfCare"])) {
        $html .= '
                <span class="badge bg-success">
                    Sudah Terdaftar SATUSEHAT
                </span>
        ';
    } else {
        $html .= '
                <span class="badge bg-warning text-dark">
                    Belum Terdaftar
                </span>
        ';
    }

    $html .= '
            </div>

            <hr>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Pasien</div>
                <div class="col-md-8 fw-semibold">
                    ' . EscapeKirim($data["nama_pasien"]) . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">ID IHS Pasien</div>
                <div class="col-md-8">
                    ' . EscapeKirim($data["id_ihs"] ?: "-") . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">NIK</div>
                <div class="col-md-8">
                    ' . EscapeKirim($data["nik"] ?: "-") . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Jenis Episode</div>
                <div class="col-md-8">
                    ' . EscapeKirim($data["episode_display"]) . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Diagnosis</div>
                <div class="col-md-8">
                    ' . EscapeKirim($data["icd_kode"] ?: "-") . '
                    -
                    ' . EscapeKirim($data["icd_deskripsi"] ?: "-") . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Condition SATUSEHAT</div>
                <div class="col-md-8">
    ';

    // Condition

    if (!empty($data["id_condition"])) {
        $html .= '
                    <span class="text-success">
                        ' . EscapeKirim($data["id_condition"]) . '
                    </span>
        ';
    } else {
        $html .= '
                    <span class="text-danger">
                        Belum tersedia
                    </span>
        ';
    }

    $html .= '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Dokter</div>
                <div class="col-md-8">
                    ' . EscapeKirim($data["nama_dokter"] ?: "-") . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Practitioner SATUSEHAT</div>
                <div class="col-md-8">
                    ' . EscapeKirim($data["id_ihs_practitioner"] ?: "-") . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Tanggal Mulai</div>
                <div class="col-md-8">
                    ' . EscapeKirim(FormatTanggalKirim($data["date_start"])) . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Tanggal Selesai</div>
                <div class="col-md-8">
                    ' . EscapeKirim(FormatTanggalKirim($data["date_end"])) . '
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 text-muted">Status</div>
                <div class="col-md-8">
                    <span class="badge bg-primary">
                        ' . EscapeKirim($data["status"]) . '
                    </span>
                </div>
            </div>

        </div>
    </div>
    ';

    // ==========================================
    // CHECKLIST KELENGKAPAN
    // ==========================================

    $html .= '
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">
                    <i class="bi bi-check2-square"></i>
                    Kelengkapan Payload
                </h6>

                <span class="badge ' . ($semuaLengkap ? "bg-success" : "bg-danger") . '">
                    ' . $totalLengkap . '/' . $totalChecklist . ' Lengkap
                </span>
            </div>

            <div class="list-group list-group-flush">
    ';

    // Render setiap checklist

    foreach ($checklist as $item) {

        $isComplete = trim((string)$item["value"]) !== "";

        $icon = $isComplete
            ? '<i class="bi bi-check-circle-fill text-success"></i>'
            : '<i class="bi bi-x-circle-fill text-danger"></i>';

        $classText = $isComplete
            ? "text-success"
            : "text-danger";

        $html .= '
                <div class="list-group-item px-0">
                    <div class="d-flex align-items-start">

                        <div class="me-2">
                            ' . $icon . '
                        </div>

                        <div class="flex-grow-1">
                            <div class="' . $classText . '">
                                ' . EscapeKirim($item["label"]) . '
                            </div>

                            <small class="text-muted">
                                ' . EscapeKirim($item["description"]) . '
                            </small>
        ';

        if (!$isComplete) {
            $html .= '
                            <div>
                                <small class="text-danger">
                                    Data belum tersedia
                                </small>
                            </div>
            ';
        }

        $html .= '
                        </div>

                    </div>
                </div>
        ';
    }

    $html .= '
            </div>

            <div class="mt-3">
    ';

    // Notifikasi kelengkapan

    if ($semuaLengkap) {

        $html .= '
                <div class="alert alert-success mb-0">
                    <i class="bi bi-check-circle"></i>
                    Data lokal memenuhi checklist awal payload.
                    Silakan lanjutkan proses pengiriman.
                </div>
        ';

    } else {

        $html .= '
                <div class="alert alert-danger mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    Masih terdapat data yang belum lengkap.
                    Proses pengiriman belum dapat dilakukan.
                </div>
        ';
    }

    $html .= '
            </div>

        </div>
    </div>
    ';

    // ==========================================
    // RESPONSE JSON
    // ==========================================

    ResponseFormKirim(
        $statusResponse,
        $semuaLengkap
            ? "Data episode perawatan siap dikirim."
            : "Data episode perawatan belum lengkap.",
        $html
    );
?>
