<?php
    // CONNECTION, FUNCTION & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger mb-0"><small>Sesi akses sudah berakhir! Silahkan login ulang.</small></div>';
        exit;
    }

    if (empty($_POST['id_kunjungan'])) {
        echo '<div class="alert alert-danger mb-0"><small>ID Kunjungan tidak boleh kosong!</small></div>';
        exit;
    }

    // SANITASI INPUT
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // HELPER
    function infoRow($label, $value){
        return '
            <div class="row mb-1">
                <div class="col-4"><small>'.$label.'</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text-muted">'.$value.'</small></div>
            </div>
        ';
    }

    function showSignature($ttd){
        if (empty($ttd)) {
            return '
                <div class="alert alert-warning mb-0">
                    <small>Tanda tangan tidak tersedia.</small>
                </div>
            ';
        }

        return '
            <img 
                src="'.$ttd.'"
                class="img-fluid border rounded p-2 bg-white"
                style="max-height:220px;"
            >
        ';
    }

    // QUERY KUNJUNGAN & PASIEN
    $sql = "
        SELECT 
            k.id_kunjungan,
            k.id_pasien,
            k.jenis_kunjungan,
            k.datetime_daftar,
            k.id_encounter,
            p.nama,
            p.gender,
            p.id_ihs
        FROM kunjungan k
        LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
        WHERE k.id_kunjungan = ?
        LIMIT 1
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_kunjungan);
    $stmt->execute();

    $Data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // VALIDASI DATA
    if (empty($Data)) {
        echo '<div class="alert alert-danger mb-0"><small>Data kunjungan tidak ditemukan!</small></div>';
        exit;
    }

   // MAPPING DATA
    $id_pasien       = $Data['id_pasien'] ?? '-';
    $nama            = $Data['nama'] ?? '-';
    $gender          = $Data['gender'] ?? '-';
    $id_ihs          = $Data['id_ihs'] ?? '-';

    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? '-';
    $id_encounter    = $Data['id_encounter'] ?? '-';

    $datetime_daftar = !empty($Data['datetime_daftar'])
        ? date('d/m/Y H:i', strtotime($Data['datetime_daftar']))
        : '-';
?>

<!-- INFORMASI PASIEN & KUNJUNGAN -->
<div class="row">

    <div class="col-md-6 mb-3">
        <div class="border rounded p-3 h-100 bg-light bg-opacity-25">

            <div class="mb-2">
                <b><i class="bi bi-person"></i> Informasi Pasien</b>
            </div>

            <?php
                echo infoRow('No.RM', $id_pasien);
                echo infoRow('Nama Pasien', $nama);
                echo infoRow('Gender', $gender);
                echo infoRow('ID IHS', $id_ihs);
            ?>

        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="border rounded p-3 h-100 bg-light bg-opacity-25">

            <div class="mb-2">
                <b><i class="bi bi-hospital"></i> Informasi Kunjungan</b>
            </div>

            <?php
                echo infoRow('No.REG', $id_kunjungan);
                echo infoRow('Tujuan/Jenis', $jenis_kunjungan);
                echo infoRow('Tanggal Daftar', $datetime_daftar);
                echo infoRow('ID Encounter', $id_encounter);
            ?>

        </div>
    </div>

</div>

<?php
    // QUERY GENERAL CONSENT
    $queryConsent = "
        SELECT * 
        FROM general_consent 
        WHERE id_kunjungan = ?
        ORDER BY datetime_creat DESC
        LIMIT 1
    ";

    $stmtConsent = $Conn->prepare($queryConsent);
    $stmtConsent->bind_param("i", $id_kunjungan);
    $stmtConsent->execute();

    $row = $stmtConsent->get_result()->fetch_assoc();
    $stmtConsent->close();

    // JIKA BELUM ADA GENERAL CONSENT
    if (empty($row)) {

        echo '
            <div class="alert alert-warning text-center mb-3">

                <div class="mb-2">
                    <b>
                        <i class="bi bi-exclamation-triangle"></i>
                        General Consent Belum Tersedia
                    </b>
                </div>

                <small>
                    Kunjungan pasien ini belum memiliki dokumen 
                    <i>General Consent</i> / Persetujuan Umum.
                </small>

            </div>

            <button 
                type="button" 
                class="btn btn-outline-primary w-100 border border-primary border-2 tambah_general_consent"
                style="border-style:dashed !important; height:70px;"
                data-id="'.$id_kunjungan.'"
            >
                <i class="bi bi-plus-circle"></i> 
                Buat General Consent
            </button>
        ';

        exit;
    }

    // MAPPING GENERAL CONSENT
    $id_general_consent = $row['id_general_consent'] ?? NULL;
    $metode_consent     = $row['metode_consent'] ?? '-';
    $petugas_id         = $row['petugas_edukasi_id'] ?? '-';
    $petugas_nama       = $row['petugas_edukasi_nama'] ?? '-';
    $petugas_nik        = $row['petugas_edukasi_nik'] ?? '-';
    $petugas_ttd        = $row['petugas_edukasi_ttd'] ?? '';
    $pj_tipe            = $row['penandatangan_tipe'] ?? '-';
    $pj_nama            = $row['penandatangan_nama'] ?? '-';
    $pj_nik             = $row['penandatangan_nik'] ?? '-';
    $pj_ttd             = $row['penandatangan_ttd'] ?? '';
    $policy_rule        = $row['policy_rule'] ?? '';
    $status             = $row['status'] ?? 0;
    $datetime_creat       = !empty($row['datetime_creat'])
        ? date('d/m/Y H:i', strtotime($row['datetime_creat']))
        : '-';

    $pernyataan_pasien = json_decode($row['pernyataan_pasien'] ?? '[]', true);
    if (!is_array($pernyataan_pasien)) {
        $pernyataan_pasien = [];
    }

    // =========================================================
    // BADGE
    // =========================================================
    $badgePolicy = $policy_rule == "opt-in"
        ? '<span class="badge bg-success">OPT-IN</span>'
        : '<span class="badge bg-danger">OPT-OUT</span>';

    $badgeStatus = $status == 1
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Tidak Aktif</span>';
?>

<!-- ========================================================= -->
<!-- GENERAL CONSENT -->
<!-- ========================================================= -->
<div class="border rounded p-3 mb-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <b><i class="bi bi-file-earmark-medical"></i> General Consent</b>
        <?php echo $badgeStatus; ?>
    </div>

    <?php
        echo infoRow('Tanggal Dibuat', $datetime_creat);
        echo infoRow('Metode Consent', $metode_consent);
    ?>

    <div class="row mb-1">
        <div class="col-4"><small>Policy Rule</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <small class="text-muted"><?php echo $badgePolicy; ?></small>
        </div>
    </div>

</div>

<!-- ========================================================= -->
<!-- PETUGAS & PENANGGUNG JAWAB -->
<!-- ========================================================= -->
<div class="row">

    <div class="col-md-6 mb-3">

        <div class="border rounded p-3 h-100">

            <div class="mb-2">
                <b><i class="bi bi-person-badge"></i> Petugas Edukasi</b>
            </div>

            <?php
                echo infoRow('Nama', $petugas_nama);
                echo infoRow('ID Akses', $petugas_id);
                echo infoRow('NIK/KTP', $petugas_nik);
            ?>

        </div>

    </div>

    <div class="col-md-6 mb-3">

        <div class="border rounded p-3 h-100">

            <div class="mb-2">
                <b><i class="bi bi-person-check"></i> Penanggung Jawab</b>
            </div>

            <?php
                echo infoRow('Tipe', $pj_tipe);
                echo infoRow('Nama', $pj_nama);
                echo infoRow('NIK/KTP', $pj_nik);
            ?>

        </div>

    </div>

</div>

<!-- ========================================================= -->
<!-- PERNYATAAN -->
<!-- ========================================================= -->
<div class="border rounded p-3 mb-3">

    <div class="mb-3">
        <b>
            <i class="bi bi-check2-square"></i>
            Pernyataan / Persetujuan Umum
        </b>
    </div>

    <?php
        if (!empty($pernyataan_pasien)) {

            foreach ($pernyataan_pasien as $item) {
                echo '
                    <div class="form-check mb-2">
                        <input 
                            class="form-check-input"
                            type="checkbox"
                            checked
                            disabled
                        >

                        <label class="form-check-label">
                            <small>'.$item.'</small>
                        </label>
                    </div>
                ';
            }

        } else {

            echo '
                <div class="alert alert-warning mb-0">
                    <small>Tidak ada data pernyataan.</small>
                </div>
            ';
        }
    ?>

</div>

<!-- ========================================================= -->
<!-- TANDA TANGAN -->
<!-- ========================================================= -->
<div class="row">

    <div class="col-md-6 mb-3">

        <div class="border rounded p-3 text-center h-100">

            <div class="mb-3">
                <b>Tanda Tangan Penanggung Jawab</b>
            </div>

            <?php echo showSignature($pj_ttd); ?>

        </div>

    </div>

    <div class="col-md-6 mb-3">

        <div class="border rounded p-3 text-center h-100">

            <div class="mb-3">
                <b>Tanda Tangan Petugas</b>
            </div>

            <?php echo showSignature($petugas_ttd); ?>

        </div>

    </div>

</div>

<!-- ========================================================= -->
<!-- TOMBOL AKSI -->
<!-- ========================================================= -->
<div class="row">
    <div class="col-md-6 mb-2">
        <a href="_Page/GeneralConsent/ProsesCetakGeneralConsent.php?id=<?php echo $id_general_consent; ?>" class="btn btn-outline-primary border border-primary border-2 w-100 rounded-2" style="border-style:dashed !important;" target="_blank">
            <i class="bi bi-printer"></i> Print General Consent
        </a>
    </div>
    <div class="col-md-6 mb-2">
        <button type="button" class="btn btn-outline-danger border border-danger border-2 w-100 rounded-2 modal_hapus_general_consent" style="border-style:dashed !important;" data-id="<?php echo $id_general_consent; ?>">
            <i class="bi bi-trash"></i> Hapus General Consent
        </button>

    </div>

</div>