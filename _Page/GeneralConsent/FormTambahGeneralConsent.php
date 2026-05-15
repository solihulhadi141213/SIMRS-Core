<?php
    // Connection, Function & Session
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

    // VALIDASI ID KUNJUNGAN
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // DETAIL KUNJUNGAN & PASIEN
    $sql = "
        SELECT 
            k.*,
            k.status AS status_kunjungan,

            p.id_pasien,
            p.nama,
            p.nik,
            p.no_bpjs,
            p.id_ihs,
            p.gender,
            p.status AS status_pasien

        FROM kunjungan k

        LEFT JOIN pasien p 
            ON k.id_pasien = p.id_pasien

        WHERE k.id_kunjungan = ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_kunjungan);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();
    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data kunjungan tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    /// MAPPING DATA PASIEN
    $id_pasien = $Data['id_pasien'] ?? null;
    $nama      = $Data['nama'] ?? null;
    $gender    = $Data['gender'] ?? null;
    $id_ihs    = $Data['id_ihs'] ?? null;
    $nik       = $Data['nik'] ?? null;
    

    // MAPPING DATA KUNJUNGAN
    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? null;
    $datetime_daftar = $Data['datetime_daftar'] ?? null;
    $id_encounter = $Data['id_encounter'] ?? null;

    // Close
    $stmt->close();
?>

<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan; ?>">
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">

<div class="row mb-3">
    <div class="col-md-12">
        <label for="metode_consent" class="mb-3">
            <small><b>Metode Consent yang Digunakan</b></small>
        </label>
        <div class="d-flex flex-wrap gap-3 mb-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="metode_consent" id="metode_consent_digital" value="Digital" checked="">
                <label class="form-check-label" for="metode_consent_digital">
                    <small>Digital</small><br>
                    <small class="text-muted">
                        Petugas akan meminta pasien / penanggung jawab untuk menandatangani dokumen secara digital langsung pada form.
                    </small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="metode_consent" id="metode_consent_manual"  value="Manual">
                <label class="form-check-label" for="metode_consent_manual">
                    <small>Manual</small><br>
                    <small class="text-muted">
                        Petugas akan mencetak berkas <i>General Consent</i> kemudian meminta pasien / penanggung jawab untuk menandatangani dokumen pada lembar tersebut.
                    </small>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="policy_rule" class="mb-3">
            <small><i><b>Policy Rule</b></i></small>
        </label>
        <div class="d-flex flex-wrap gap-3 mb-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="policy_rule" id="policy_rule_out" value="opt-out" checked="">
                <label class="form-check-label" for="policy_rule_out">
                    <small>OPT-OUT</small><br>
                    <small class="text-muted">
                        Pasien dianggap MENYETUJUI secara default, kecuali pasien menolak.
                    </small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="policy_rule" id="policy_rule_in"  value="opt-in">
                <label class="form-check-label" for="policy_rule_in">
                    <small>OPT-IN</small><br>
                    <small class="text-muted">
                        Pasien dianggap BELUM menyetujui sampai pasien memberikan persetujuan secara eksplisit.
                    </small>
                </label>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="petugas">
            <small><b>Informasi Identitas Petugas Yang Memberikan Edukasi</b></small>
        </label>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="petugas_edukasi_id">
            <small class="text-muted">ID Akses Petugas</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="petugas_edukasi_id" id="petugas_edukasi_id" class="form-control" value="<?php echo $SessionIdAkses; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="petugas_edukasi_nama">
            <small class="text-muted">Nama Lengkap Petugas</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="petugas_edukasi_nama" id="petugas_edukasi_nama" class="form-control" value="<?php echo $SessionNama; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="petugas_edukasi_nik">
            <small class="text-muted">NIK / KTP Petugas</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="petugas_edukasi_nik" id="petugas_edukasi_nik" class="form-control" value="<?php echo $SessionNik; ?>">
    </div>
</div>
<hr>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="petugas" class="mb-3">
            <small><b>Penanggung Jawab</b></small>
        </label>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="penandatangan_tipe" id="penandatangan_tipe_pasien" value="Pasien" checked="">
            <label class="form-check-label" for="penandatangan_tipe_pasien">
                <small>Pasien</small><br>
                <small class="text-muted">
                    Pasien secara pribadi yang akan menandatangani <i>General Consent</i>
                </small>
            </label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="penandatangan_tipe" id="penandatangan_tipe_keluarga" value="Keluarga">
            <label class="form-check-label" for="penandatangan_tipe_keluarga">
                <small>Keluarga</small><br>
                <small class="text-muted">
                    Salah satu dari keluarga pasien yang akan menandatangani <i>General Consent</i>
                </small>
            </label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="penandatangan_tipe" id="penandatangan_tipe_penanggung" value="Penanggung Jawab">
            <label class="form-check-label" for="penandatangan_tipe_penanggung">
                <small>Pihak Lainnya</small><br>
                <small class="text-muted">
                    Pihak lain yang menyatakan diri bertanggung jawab atas pasien yang akan menandatangani <i>General Consent</i>
                </small>
            </label>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="penandatangan_nama">
            <small class="text-muted">Nama Lengkap (Sesuai KTP)</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="penandatangan_nama" id="penandatangan_nama" class="form-control" value="<?php echo $nama; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="penandatangan_nik">
            <small class="text-muted">NIK / KTP</small>
        </label>
    </div>
    <div class="col-md-8">
        <input type="text" name="penandatangan_nik" id="penandatangan_nik" class="form-control" value="<?php echo $nik; ?>">
    </div>
</div>
<hr>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="petugas">
            <small><b>Pernyataan / Persetujuan Umum</b></small>
        </label>
    </div>
</div>
<hr>

<!-- ===================================================== -->
<!-- PERNYATAAN / PERSETUJUAN UMUM -->
<!-- ===================================================== -->
<div class="row mb-3">
    <div class="col-md-12">

        <div class="alert alert-light border">
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="pernyataan_pasien[]" id="pernyataan_1" value="Saya menyetujui untuk mendapatkan pelayanan kesehatan di rumah sakit." checked>
                <label class="form-check-label" for="pernyataan_1">
                    <small>
                        Saya menyetujui untuk mendapatkan pelayanan kesehatan di rumah sakit.
                    </small>
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="pernyataan_pasien[]" id="pernyataan_2"value="Saya bersedia memberikan informasi kesehatan yang benar dan lengkap."checked>
                <label class="form-check-label" for="pernyataan_2">
                    <small>
                        Saya bersedia memberikan informasi kesehatan yang benar dan lengkap.
                    </small>
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="pernyataan_pasien[]" id="pernyataan_3"value="Saya memahami hak dan kewajiban sebagai pasien selama mendapatkan pelayanan kesehatan."checked>
                <label class="form-check-label" for="pernyataan_3">
                    <small>
                        Saya memahami hak dan kewajiban sebagai pasien selama mendapatkan pelayanan kesehatan.
                    </small>
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="pernyataan_pasien[]" id="pernyataan_4"value="Saya memberikan persetujuan penggunaan data medis untuk kepentingan pelayanan kesehatan sesuai ketentuan yang berlaku." checked >

                <label class="form-check-label" for="pernyataan_4">
                    <small>
                        Saya memberikan persetujuan penggunaan data medis untuk kepentingan pelayanan kesehatan sesuai ketentuan yang berlaku.
                    </small>
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="pernyataan_pasien[]" id="pernyataan_5"value="Saya memahami bahwa persetujuan tindakan medis tertentu akan dimintakan secara terpisah." checked>
                <label class="form-check-label" for="pernyataan_5">
                    <small>
                        Saya memahami bahwa persetujuan tindakan medis tertentu akan dimintakan secara terpisah.
                    </small>
                </label>
            </div>

        </div>

    </div>
</div>

<hr>

<!-- ===================================================== -->
<!-- TANDA TANGAN -->
<!-- ===================================================== -->
<div class="row mb-3">

    <!-- PENANGGUNG JAWAB -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <small>
                    <b>Tanda Tangan Penanggung Jawab</b>
                </small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">
                        Silahkan tanda tangan pada area di bawah ini.
                    </small>
                </div>
                <div class="border rounded bg-light position-relative" style="height:250px;">
                    <canvas id="signature-pad-pasien" style="width:100%; height:100%;"></canvas>
                </div>
                <input type="hidden" name="penandatangan_ttd" id="penandatangan_ttd">
                <div class="mt-3 d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100" id="clear-signature-pasien">
                        <i class="bi bi-eraser"></i> Hapus & Ulangi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- PETUGAS -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <small>
                    <b>Tanda Tangan Petugas</b>
                </small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">
                        Petugas Pemberi Edukasi, Silahkan Sertakan Tanda Tangan Disini.
                    </small>
                </div>
                <div class="border rounded bg-light position-relative" style="height:250px;">
                    <canvas id="signature-pad-petugas" style="width:100%; height:100%;"></canvas>
                </div>
                <input type="hidden" name="petugas_edukasi_ttd" id="petugas_edukasi_ttd">

                <div class="mt-3 d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100" id="clear-signature-petugas">
                        <i class="bi bi-eraser"></i> Hapus & Ulangi
                    </button>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- INFORMASI -->
<!-- ===================================================== -->
<div class="alert alert-info">
    <small>
        Dengan menandatangani dokumen ini, pasien / penanggung jawab 
        menyatakan telah membaca, memahami dan menyetujui seluruh 
        isi <i>General Consent</i> yang berlaku di rumah sakit.
    </small>
</div>