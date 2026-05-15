<?php
    // CONNECTION, FUNCTION & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI INPUT
    if (empty($_POST['id_general_consent'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID General Consent tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_general_consent = validateAndSanitizeInput($_POST['id_general_consent']);

    // QUERY GENERAL CONSENT
    $query = "
        SELECT 
            gc.*,
            k.id_encounter,
            k.jenis_kunjungan,
            k.datetime_daftar,
            p.nama AS nama_pasien,
            p.nik AS nik_pasien,
            p.id_ihs AS id_ihs_pasien,
            p.gender
        FROM general_consent gc

        LEFT JOIN kunjungan k
            ON gc.id_kunjungan = k.id_kunjungan

        LEFT JOIN pasien p
            ON gc.id_pasien = p.id_pasien

        WHERE gc.id_general_consent = ?
        LIMIT 1
    ";

    $stmt = $Conn->prepare($query);
    $stmt->bind_param("i", $id_general_consent);
    $stmt->execute();

    $result = $stmt->get_result();
    $data   = $result->fetch_assoc();

    // VALIDASI DATA
    if (empty($data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data General Consent tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // MAPPING DATA
    $id_consent              = $data['id_consent'] ?? '';
    $id_kunjungan            = $data['id_kunjungan'] ?? '';
    $id_pasien               = $data['id_pasien'] ?? '';
    $id_encounter            = $data['id_encounter'] ?? '';
    $nama_pasien             = $data['nama_pasien'] ?? '';
    $nik_pasien              = $data['nik_pasien'] ?? '';
    $id_ihs_pasien           = $data['id_ihs_pasien'] ?? '';
    $gender                  = $data['gender'] ?? '';
    $metode_consent          = $data['metode_consent'] ?? '';
    $policy_rule             = $data['policy_rule'] ?? '';
    $petugas_edukasi_id      = $data['petugas_edukasi_id'] ?? '';
    $petugas_edukasi_nama    = $data['petugas_edukasi_nama'] ?? '';
    $petugas_edukasi_nik     = $data['petugas_edukasi_nik'] ?? '';
    $penandatangan_tipe      = $data['penandatangan_tipe'] ?? '';
    $penandatangan_nama      = $data['penandatangan_nama'] ?? '';
    $penandatangan_nik       = $data['penandatangan_nik'] ?? '';
    $pernyataan_pasien       = $data['pernyataan_pasien'] ?? '[]';
    $datetime_creat          = $data['datetime_creat'] ?? '';

    $stmt->close();

    // KONFIGURASI SATUSEHAT
    $status_setting = 1;
    $sql_satusehat = "SELECT * FROM setting_satusehat WHERE status_setting_satusehat = ? LIMIT 1";
    $stmt_satusehat = $Conn->prepare($sql_satusehat);
    $stmt_satusehat->bind_param("i", $status_setting);
    $stmt_satusehat->execute();
    $DataSatuSehat = $stmt_satusehat->get_result()->fetch_assoc();
    $stmt_satusehat->close();

    // Validasi Konfigurasi Satusehat
    if (empty($DataSatuSehat)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Konfigurasi Satu Sehat Tidak Ditemukan!
                </small>
            </div>
        ';
        exit;
    }
    if(empty($DataSatuSehat['url_satusehat'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Konfigurasi Satu Sehat Tidak Ditemukan!
                </small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Pengaturan Koneksi Satusehat
    $url_satusehat    = $DataSatuSehat['url_satusehat'];
    $token            = $DataSatuSehat['token'] ?? '';
    $organization_id  = $DataSatuSehat['organization_id'] ?? '';
    $datetime_expired = $DataSatuSehat['datetime_expired'] ?? '';

    // Generate Token baru Jika Expired
    if (empty($token) || strtotime($datetime_expired) <= time()) {
        $tokenResult = generateTokenSatuSehat($Conn);
        if (($tokenResult['status'] ?? '') !== 'success') {
            echo '
                <div class="alert alert-danger text-center">
                    <small>
                        Terjadi kesalahan saat generate token SATUSEHAT!
                    </small>
                </div>
            ';
            exit;
        }
        $token = $tokenResult['token'] ?? '';
    }

    // Memastikan Token Ada
    if (empty($token)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Token SATUSEHAT tidak tersedia!
                </small>
            </div>
        ';
        exit;
    }

    // Validasi Jika $id_ihs_pasien belum ada
    if(empty($id_ihs_pasien)){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    ID IHS Pasien Belum Ada. Data Tidak Bisa Dikirim Ke Satusehat!
                </small>
            </div>
        ';
        exit;
    }

    // Cek Status Consent Pasien
    $DetailConsent = GetConsent($url_satusehat,$token,$id_ihs_pasien);
    $json_decode   = json_decode($DetailConsent, true);
    if(empty($json_decode['id'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    <b>OPSS!</b><BR>
                    Terjadi Keaslahan Pada Saat Membuka Detail Consent!<br>
                    <pre>
                        '.$DetailConsent.'
                    </pre>
                </small>
            </div>
        ';
        exit;
    }

    $ss_id                = $json_decode['id'] ?? '-';
    $ss_status            = $json_decode['status'] ?? '-';
    $ss_patient           = $json_decode['patient']['reference'] ?? '-';
    $ss_datetime          = $json_decode['dateTime'] ?? '-';
    $ss_organization      = $json_decode['organization'][0]['reference'] ?? '-';
    $ss_policy_rule       = $json_decode['policyRule']['coding'][0]['code'] ?? '-';
    $ss_scope             = $json_decode['scope']['coding'][0]['code'] ?? '-';
    $ss_category          = $json_decode['category'][0]['coding'][0]['code'] ?? '-';
    $ss_period_start      = $json_decode['provision']['period']['start'] ?? '-';

    // FORMAT DATETIME SATUSEHAT
    if ($ss_datetime != '-') {
        $ss_datetime = date('d/m/Y H:i:s', strtotime($ss_datetime));
    }

    if ($ss_period_start != '-') {
        $ss_period_start = date('d/m/Y H:i:s', strtotime($ss_period_start));
    }

    // BADGE STATUS
    $badge_status = ''.htmlspecialchars($ss_status).'';

?>
<div class="row mb-2">
    <div class="col-4"><small>Resource Type</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $json_decode['resourceType']; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $badge_status; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Consent ID</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $ss_id; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Patient Reference</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $ss_patient; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Organization</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $ss_organization; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Policy Rule</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $ss_policy_rule; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Consent Scope</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $ss_scope; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Category</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $ss_category; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Date Time</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $ss_datetime; ?>
        </small>
    </div>
</div>

<div class="row mb-0">
    <div class="col-4"><small>Provision Start</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $ss_period_start; ?>
        </small>
    </div>
</div>