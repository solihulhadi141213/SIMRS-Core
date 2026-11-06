<?php
    // ==========================================
    // FormEdit.php - Form Edit Episode Perawatan
    // ==========================================

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi Session Login
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir! Silahkan login ulang.</small></div>';
        exit;
    }

    // Validasi ID Episode Perawatan
    if (empty($_POST['id_episode_perawatan']) || !ctype_digit($_POST['id_episode_perawatan'])) {
        echo '<div class="alert alert-danger"><small>ID Episode Perawatan tidak valid!</small></div>';
        exit;
    }

    $id_episode_perawatan = (int) $_POST['id_episode_perawatan'];

    // Ambil data episode perawatan yang akan diedit
    $sql = "
        SELECT 
            e.*, 
            p.nama AS nama_pasien,
            epk.episode_name,
            epk.episode_code,
            d.nama AS nama_dokter,
            dg.icd_kode,
            dg.icd_deskripsi
        FROM episode_perawatan e
        LEFT JOIN pasien p ON p.id_pasien = e.id_pasien
        LEFT JOIN episode_perawatan_kode epk ON epk.id_episode_perawatan_kode = e.id_episode_perawatan_kode
        LEFT JOIN dokter d ON d.id_dokter = e.id_dokter
        LEFT JOIN diagnosis dg ON dg.id_diagnosis = e.id_diagnosis
        WHERE e.id_episode_perawatan = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        echo '<div class="alert alert-danger"><small>Gagal menyiapkan query database.</small></div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_episode_perawatan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$data) {
        echo '<div class="alert alert-danger"><small>Data episode perawatan tidak ditemukan.</small></div>';
        exit;
    }

    // Format Helper
    function showValue($val) {
        return htmlspecialchars($val ?? '');
    }

    // Apakah sudah memiliki 'IdEpisodeOfCare'?
    if(!empty($data['IdEpisodeOfCare'])) {
        $IdEpisodeOfCare = $data['IdEpisodeOfCare'];
    }else{
        $IdEpisodeOfCare = null;
    }
?>

<!-- Hidden Input untuk ID Utama -->
<input type="hidden" name="id_episode_perawatan" value="<?= $data['id_episode_perawatan'] ?>">

<!-- ID Pasien -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="IdEpisodeOfCare"><i>ID Episode of Care</i></label>
    </div>
    <div class="col-md-8" id="FormIdPasienEdit">
        <input type="text" readonly class="form-control" name="IdEpisodeOfCare" id="IdEpisodeOfCare" value="<?= showValue($IdEpisodeOfCare) ?>" placeholder="ID Episode of Care (Opsional)">
    </div>
</div>

<!-- Pilihan Sinkronisasi SATUSEHAT -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="update_satusehat">Sinkronisasi SATUSEHAT</label>
    </div>
    <div class="col-md-8">
        <div class="form-check">
            <input
                type="checkbox"
                class="form-check-input"
                name="update_satusehat"
                id="update_satusehat"
                value="1"
                <?= $IdEpisodeOfCare !== null ? 'checked' : 'disabled' ?>
            >
            <label class="form-check-label" for="update_satusehat">
                Perbarui data EpisodeOfCare di SATUSEHAT
            </label>
        </div>
        <?php if ($IdEpisodeOfCare === null): ?>
            <small class="text-muted">Tidak dapat disinkronkan karena ID EpisodeOfCare SATUSEHAT belum tersedia.</small>
        <?php else: ?>
            <small class="text-muted">Pilihan ini aktif secara default dan dapat dinonaktifkan.</small>
        <?php endif; ?>
    </div>
</div>

<!-- ID Pasien -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_id_pasien">ID/Nama Pasien <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8" id="FormIdPasienEdit">
        <select name="id_pasien" id="edit_id_pasien" class="form-control" required>
            <option value="<?= $data['id_pasien'] ?>" selected>
                <?= showValue($data['nama_pasien']) ?> (ID: <?= $data['id_pasien'] ?>)
            </option>
        </select>
    </div>
</div>

<!-- Nama Episode Perawatan -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_id_episode_perawatan_kode">Nama Episode Perawatan <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8" id="FormKodeEpisodePerawatanEdit">
        <select name="id_episode_perawatan_kode" id="edit_id_episode_perawatan_kode" class="form-control" required>
            <option value="<?= $data['id_episode_perawatan_kode'] ?>" selected>
                <?= showValue($data['episode_name']) ?> (Kode: <?= showValue($data['episode_code']) ?>)
            </option>
        </select>
        <small class="text-muted">Referensi episode perawatan sepenuhnya dikelola petugas rekam medis.</small>
    </div>
</div>

<!-- Diagnosis Pasien -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_id_diagnosis">Diagnosis Pasien <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8" id="FormDiagnosisEdit">
        <select name="id_diagnosis" id="edit_id_diagnosis" class="form-control" required>
            <?php if (!empty($data['id_diagnosis'])): ?>
                <option value="<?= $data['id_diagnosis'] ?>" selected>
                    [<?= showValue($data['icd_kode']) ?>] <?= showValue($data['icd_deskripsi']) ?>
                </option>
            <?php else: ?>
                <option value="">Pilih</option>
            <?php endif; ?>
        </select>
        <small class="text-muted">Hubungkan dengan diagnosis pasien</small>
    </div>
</div>

<!-- Dokter DPJP -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_id_dokter">Dokter DPJP <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8" id="FormDokterDPJPEdit">
        <select name="id_dokter" id="edit_id_dokter" class="form-control" required>
            <option value="<?= $data['id_dokter'] ?>" selected>
                <?= showValue($data['nama_dokter']) ?>
            </option>
        </select>
        <small class="text-muted">Dokter yang memberikan pernyataan</small>
    </div>
</div>

<!-- Tanggal Mulai -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_date_start">Tanggal Mulai <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8">
        <input type="date" class="form-control" name="date_start" id="edit_date_start" value="<?= showValue($data['date_start']) ?>" required>
    </div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="edit_status">Status <span class="text-danger">*</span></label>
    </div>
    <div class="col-md-8" id="FormStatusEdit">
        <?php 
            $statusList = [
                'planned'          => 'Direncanakan',
                'waitlist'         => 'Menunggu',
                'active'           => 'Aktif',
                'onhold'           => 'Ditahan',
                'finished'         => 'Selesai',
                'cancelled'        => 'Dibatalkan',
                'entered-in-error' => 'Kesalahan Entry'
            ];
        ?>
        <select name="status" id="edit_status" class="form-control" required>
            <?php foreach ($statusList as $key => $label): ?>
                <option value="<?= $key ?>" <?= ($data['status'] === $key) ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Script Inisialisasi Select2 Khusus Form Edit -->
<script>
    $(document).ready(function() {
        // 1. Select2 Pasien Edit
        function InisialisasiSelectPasienEdit() {
            $('#edit_id_pasien').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#FormEdit'),
                width: '100%',
                ajax: {
                    method: 'POST',
                    url: '_Page/EpisodePerawatan/GetPasien.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { keyword: params.term || '', page: params.page || 1 };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        // Mapping agar properti text terbaca oleh Select2
                        let formattedResults = (data.results || []).map(function(item) {
                            return {
                                id: item.id_pasien,
                                text: item.nama + ' (No. RM: ' + item.id_pasien + ')',
                                nama: item.nama,
                                id_pasien: item.id_pasien,
                                nik: item.nik || '-',
                                no_bpjs: item.no_bpjs || '-'
                            };
                        });
                        return { results: formattedResults, pagination: { more: !!(data.pagination && data.pagination.more) } };
                    }
                },
                templateResult: function (item) {
                    if (item.loading) return item.text;
                    if (!item.id) return item.text;
                    return $(`<div><strong>${item.nama}</strong><br><small class="text-muted">No. RM: ${item.id_pasien} | NIK: ${item.nik} | BPJS: ${item.no_bpjs}</small></div>`);
                },
                templateSelection: function (item) {
                    if (!item.id) return item.text;
                    return item.text || `${item.nama} (No. RM: ${item.id_pasien})`;
                },
                escapeMarkup: function (markup) { return markup; }
            });
        }

        // 2. Select2 Episode Kode Edit
        function InisialisasiSelectEpisodeKodeEdit() {
            $('#edit_id_episode_perawatan_kode').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#FormEdit'),
                width: '100%',
                ajax: {
                    method: 'POST',
                    url: '_Page/EpisodePerawatan/GetEpisodeKode.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { keyword: params.term || '', page: params.page || 1 };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        let formattedResults = (data.results || []).map(function(item) {
                            return {
                                id: item.id,
                                text: item.episode_name + ' (' + item.episode_code + ')',
                                episode_name: item.episode_name,
                                episode_display: item.episode_display,
                                episode_code: item.episode_code,
                                episode_category: item.episode_category
                            };
                        });
                        return { results: formattedResults, pagination: { more: !!(data.pagination && data.pagination.more) } };
                    }
                },
                templateResult: function (item) {
                    if (item.loading) return item.text;
                    if (!item.id) return item.text;
                    return $(`<div><strong>${item.episode_name}</strong><br><small class="text-muted">Display: ${item.episode_display} | Kode: ${item.episode_code}</small></div>`);
                },
                templateSelection: function (item) {
                    if (!item.id) return item.text;
                    return item.text || `${item.episode_name} (${item.episode_code})`;
                },
                escapeMarkup: function (markup) { return markup; }
            });
        }

        // 3. Select2 Diagnosis Edit (Dependent terhadap Pasien)
        function InisialisasiSelectDiagnosisEdit() {
            $('#edit_id_diagnosis').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#FormEdit'),
                width: '100%',
                ajax: {
                    method: 'POST',
                    url: '_Page/EpisodePerawatan/GetDiagnosis.php',
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term || '',
                            page: params.page || 1,
                            id_pasien: $('#edit_id_pasien').val()
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        let formattedResults = (data.results || []).map(function(item) {
                            return {
                                id: item.id,
                                text: '[' + item.icd_kode + '] ' + item.icd_deskripsi,
                                icd_kode: item.icd_kode,
                                icd_deskripsi: item.icd_deskripsi,
                                jenis_diagnosis: item.jenis_diagnosis,
                                status_kasus: item.status_kasus,
                                dokter_nama: item.dokter_nama
                            };
                        });
                        return { results: formattedResults, pagination: { more: !!(data.pagination && data.pagination.more) } };
                    }
                },
                templateResult: function (item) {
                    if (item.loading) return item.text;
                    if (!item.id) return item.text;
                    return $(`<div><strong>[${item.icd_kode}] ${item.icd_deskripsi}</strong><br><small class="text-muted">Jenis: ${item.jenis_diagnosis} | Kasus: ${item.status_kasus} | Dokter: ${item.dokter_nama}</small></div>`);
                },
                templateSelection: function (item) {
                    if (!item.id) return item.text;
                    return item.text || `[${item.icd_kode}] ${item.icd_deskripsi}`;
                },
                escapeMarkup: function (markup) { return markup; }
            });
        }

        // 4. Select2 Dokter Edit
        function InisialisasiSelectDokterEdit() {
            $('#edit_id_dokter').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#FormEdit'),
                width: '100%',
                ajax: {
                    method: 'POST',
                    url: '_Page/EpisodePerawatan/GetDokter.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { keyword: params.term || '', page: params.page || 1 };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        let formattedResults = (data.results || []).map(function(item) {
                            return {
                                id: item.id,
                                text: item.nama + ' (' + item.kategori + ')',
                                nama: item.nama,
                                kategori: item.kategori,
                                kode: item.kode
                            };
                        });
                        return { results: formattedResults, pagination: { more: !!(data.pagination && data.pagination.more) } };
                    }
                },
                templateResult: function (item) {
                    if (item.loading) return item.text;
                    if (!item.id) return item.text;
                    return $(`<div><strong>${item.nama}</strong><br><small class="text-muted">Spesialisasi: ${item.kategori} | Kode: ${item.kode}</small></div>`);
                },
                templateSelection: function (item) {
                    if (!item.id) return item.text;
                    return item.text || `${item.nama} (${item.kategori})`;
                },
                escapeMarkup: function (markup) { return markup; }
            });
        }

        // Jalankan inisialisasi
        InisialisasiSelectPasienEdit();
        InisialisasiSelectEpisodeKodeEdit();
        InisialisasiSelectDiagnosisEdit();
        InisialisasiSelectDokterEdit();

        // Reset diagnosis jika pasien diubah pada form edit
        $(document).on('change', '#edit_id_pasien', function() {
            $('#edit_id_diagnosis').val(null).trigger('change');
        });
    });
</script>