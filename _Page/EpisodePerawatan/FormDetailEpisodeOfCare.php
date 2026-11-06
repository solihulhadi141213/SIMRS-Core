<?php
// ==========================================
// FormDetailEpisodeOfCare.php - Detail EpisodeOfCare SATUSEHAT
// ==========================================

date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

// 1. Validasi Session Login
if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger text-center"><small>Sesi akses sudah berakhir, silakan login ulang.</small></div>';
    exit;
}

// 2. Validasi Metode Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<div class="alert alert-danger text-center"><small>Metode request tidak valid.</small></div>';
    exit;
}

// 3. Validasi Parameter IdEpisodeOfCare
if (empty($_POST['IdEpisodeOfCare'])) {
    echo '<div class="alert alert-danger text-center"><small>ID EpisodeOfCare SATUSEHAT tidak boleh kosong.</small></div>';
    exit;
}

$IdEpisodeOfCare = trim($_POST['IdEpisodeOfCare']);

// 4. Panggil Fungsi untuk Mengambil Detail dari SATUSEHAT
$resultApi = GetDetailEpisodeOfCareSatuSehat($Conn, $IdEpisodeOfCare);

if ($resultApi['status'] !== 'success') {
    echo '<div class="alert alert-danger text-center"><small>' . htmlspecialchars($resultApi['message']) . '</small></div>';
    exit;
}

$responseData = $resultApi['data'];

// 5. Mapping Data dari Response FHIR EpisodeOfCare
$resourceType   = $responseData['resourceType'] ?? '-';
$status         = $responseData['status'] ?? '-';
$patientRef     = $responseData['patient']['reference'] ?? '-';
$patientName    = $responseData['patient']['display'] ?? '-';
$orgRef         = $responseData['managingOrganization']['reference'] ?? '-';
$orgName        = $responseData['managingOrganization']['display'] ?? '-';
$managerRef     = $responseData['careManager']['reference'] ?? '-';
$managerName    = $responseData['careManager']['display'] ?? '-';

// Type / Coding Episode
$codingSystem   = $responseData['type'][0]['coding'][0]['system'] ?? '-';
$codingCode     = $responseData['type'][0]['coding'][0]['code'] ?? '-';
$codingDisplay  = $responseData['type'][0]['coding'][0]['display'] ?? '-';

// Diagnosis
$condRef        = $responseData['diagnosis'][0]['condition']['reference'] ?? '-';
$condDisplay    = $responseData['diagnosis'][0]['condition']['display'] ?? '-';

// Period
$periodStart    = $responseData['period']['start'] ?? '-';
$periodEnd      = $responseData['period']['end'] ?? '-';

// Format tanggal agar mudah dibaca
if ($periodStart !== '-') {
    $dtStart = DateTime::createFromFormat(DateTimeInterface::ATOM, $periodStart);
    if ($dtStart) $periodStart = $dtStart->format('d/m/Y H:i:s');
}
if ($periodEnd !== '-') {
    $dtEnd = DateTime::createFromFormat(DateTimeInterface::ATOM, $periodEnd);
    if ($dtEnd) $periodEnd = $dtEnd->format('d/m/Y H:i:s');
}

// Badge Status SATUSEHAT
$badge_status = [
    'planned'          => 'secondary',
    'waitlist'         => 'info',
    'active'           => 'success',
    'onhold'           => 'warning',
    'finished'         => 'primary',
    'cancelled'        => 'danger',
    'entered-in-error' => 'dark'
];
$badgeClass  = $badge_status[$status] ?? 'secondary';
$statusBadge = '<span class="badge bg-' . $badgeClass . '">' . htmlspecialchars($status) . '</span>';
?>

<div class="container-fluid px-0">
    <!-- A. Identifikasi Server SATUSEHAT -->
    <div class="row mb-2">
        <div class="col-12"><small class="text-primary fw-bold"><i class="bi bi-cloud-check"></i> A. Metadata Server SATUSEHAT</small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Resource Type</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted fw-bold"><?php echo htmlspecialchars($resourceType); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>ID EpisodeOfCare</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted fw-bold"><em><?php echo htmlspecialchars($IdEpisodeOfCare); ?></em></small></div>
    </div>
    <hr>

    <!-- B. Informasi Subjek & Organisasi -->
    <div class="row mb-2">
        <div class="col-12"><small class="text-primary fw-bold"><i class="bi bi-person-badge"></i> B. Subjek & Penanggung Jawab</small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Pasien (Patient)</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-primary fw-bold"><?php echo htmlspecialchars($patientName); ?> <span class="text-muted">(Ref: <?php echo htmlspecialchars($patientRef); ?>)</span></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Dokter (CareManager)</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($managerName); ?> <span class="text-muted">(Ref: <?php echo htmlspecialchars($managerRef); ?>)</span></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Organisasi (Fasyankes)</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($orgName); ?> <span class="text-muted">(Ref: <?php echo htmlspecialchars($orgRef); ?>)</span></small></div>
    </div>
    <hr>

    <!-- C. Detail Klinis & Waktu -->
    <div class="row mb-2">
        <div class="col-12"><small class="text-primary fw-bold"><i class="bi bi-journal-medical"></i> C. Detail Klinis & Periode</small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Tipe Episode</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($codingDisplay); ?> (Code: <code><?php echo htmlspecialchars($codingCode); ?></code>)</small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Diagnosis (Condition)</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($condDisplay); ?> <span class="text-muted">(Ref: <?php echo htmlspecialchars($condRef); ?>)</span></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Periode Mulai</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($periodStart); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Periode Selesai</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($periodEnd); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Status Perawatan</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><?php echo $statusBadge; ?></div>
    </div>
</div>