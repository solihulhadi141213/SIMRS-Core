<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =====================================================
    // VALIDASI SESSION
    // =====================================================
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // =====================================================
    // VALIDASI ID KUNJUNGAN
    // =====================================================
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // =====================================================
    // SANITASI INPUT
    // =====================================================
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // =====================================================
    // DETAIL KUNJUNGAN & PASIEN
    // =====================================================
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
    $id_pasien       = $Data['id_pasien'] ?? null;
    $nama            = $Data['nama'] ?? null;
    $gender          = $Data['gender'] ?? null;
    $id_ihs          = $Data['id_ihs'] ?? null;
    

    // MAPPING DATA KUNJUNGAN
    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? null;
    $datetime_daftar = $Data['datetime_daftar'] ?? null;
    $id_encounter = $Data['id_encounter'] ?? null;

    // Close
    $stmt->close();

    // =====================================================
    // FORMAT TANGGAL DAFTAR
    // =====================================================
    if (!empty($datetime_daftar)) {
        $datetime_daftar = date('d/m/Y H:i', strtotime($datetime_daftar));
    }

    // =====================================================
    // DAFTAR KATEGORI DIAGNOSIS
    // =====================================================
    $kategoriDiagnosis = [
        1 => 'Admission',
        2 => 'Provisional',
        3 => 'Primary',
        4 => 'Secondary',
        5 => 'Working',
        6 => 'Differential',
        7 => 'Final'
    ];

    // =====================================================
    // BUKA SEMUA DATA DIAGNOSIS
    // =====================================================
    $dataDiagnosis = [];

    $sqlDiagnosis = "
        SELECT *
        FROM diagnosis
        WHERE id_kunjungan = ?
    ";

    $stmtDiagnosis = $Conn->prepare($sqlDiagnosis);
    $stmtDiagnosis->bind_param("i", $id_kunjungan);
    $stmtDiagnosis->execute();

    $resultDiagnosis = $stmtDiagnosis->get_result();

    while ($rowDiagnosis = $resultDiagnosis->fetch_assoc()) {

        $jenis = $rowDiagnosis['jenis_diagnosis'];

        $dataDiagnosis[$jenis] = $rowDiagnosis;
    }

    $stmtDiagnosis->close();

    // =====================================================
    // FUNCTION LIMIT TEXT
    // =====================================================
    function limitText($text, $limit = 40)
    {
        if (empty($text)) {
            return '-';
        }

        $text = strip_tags($text);

        if (mb_strlen($text) > $limit) {
            return mb_substr($text, 0, $limit) . '...';
        }

        return $text;
    }
?>

<!-- ===================================================== -->
<!-- INFORMASI PASIEN & KUNJUNGAN -->
<!-- ===================================================== -->
<div class="row mb-3">

    <div class="col-md-6">

        <b class="mb-2">A. Informasi Pasien</b>

        <div class="row mb-2">
            <div class="col-4"><small>No.RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_pasien; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $nama; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Gender</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $gender; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>ID IHS</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_ihs; ?>
                </small>
            </div>
        </div>

    </div>

    <div class="col-md-6">

        <b class="mb-2">B. Informasi Kunjungan</b>

        <div class="row mb-2">
            <div class="col-4"><small>No.REG</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_kunjungan; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Tujuan/Jenis</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $jenis_kunjungan; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Daftar</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $datetime_daftar; ?>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID Encounter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_encounter; ?>
                </small>
            </div>
        </div>

    </div>

</div>

<hr>

<!-- ===================================================== -->
<!-- TABEL DIAGNOSIS -->
<!-- ===================================================== -->
<div class="row">

    <div class="col-12">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <td align="center">
                            <small><b>No</b></small>
                        </td>

                        <td>
                            <small><b>Kategori</b></small>
                        </td>

                        <td>
                            <small><b>Dokter</b></small>
                        </td>

                        <td>
                            <small><b>Text</b></small>
                        </td>

                        <td>
                            <small><b><i>ICD</i></b></small>
                        </td>

                        <td>
                            <small><b><i>Code</i></b></small>
                        </td>

                        <td>
                            <small><b><i>Description</i></b></small>
                        </td>

                        <td>
                            <small><b><i>Datetime</i></b></small>
                        </td>

                        <td align="center">
                            <small><b><i>ID Condition</i></b></small>
                        </td>

                        <td align="center">
                            <small><b>Opsi</b></small>
                        </td>
                    </tr>
                </thead>

                <tbody>

                    <?php
                        foreach ($kategoriDiagnosis as $no => $kategori) {

                            $diagnosis = $dataDiagnosis[$kategori] ?? null;

                            // ==========================================
                            // DEFAULT VALUE
                            // ==========================================
                            $dokter         = '-';
                            $diagnosis_text = '-';
                            $icd_version    = '-';
                            $icd_kode       = '-';
                            $icd_deskripsi  = '-';
                            $datetime_creat = '-';
                            $id_condition   = '-';

                            // ==========================================
                            // JIKA DATA ADA
                            // ==========================================
                            if (!empty($diagnosis)) {

                                $id_diagnosis   = $diagnosis['id_diagnosis'];
                                $dokter         = $diagnosis['dokter_nama'] ?? '-';
                                $diagnosis_text = limitText($diagnosis['diagnosis_text'] ?? '-', 35);
                                $icd_version    = $diagnosis['icd_version'] ?? '-';
                                $icd_kode       = $diagnosis['icd_kode'] ?? '-';
                                $id_condition   = $diagnosis['id_condition'] ?? '-';
                                $icd_deskripsi  = limitText($diagnosis['icd_deskripsi'] ?? '-', 35);

                                // Routing Condition
                                if(empty($diagnosis['id_condition'])){
                                    $id_condition  = '
                                        <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-danger modal_kirim_condition" data-id="'.$id_diagnosis.'" title="Kirim Condition">
                                            <i class="bi bi-plus"></i>
                                        </a>
                                    ';
                                }else{
                                    $id_condition  = $diagnosis['id_condition'];
                                    $id_condition  = '
                                        <div class="dropdown icon-btn">
                                            <button class="btn btn-sm btn-icon btn-outline-info" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item modal_detail_condition" href="javascript:void(0);" data-id="'.$id_condition.'">
                                                        <i class="bi bi-info-circle"></i> Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item modal_edit_condition" href="javascript:void(0);" data-id="'.$id_condition.'">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    ';
                                }
                                

                                if (!empty($diagnosis['datetime_creat'])) {
                                    $datetime_creat = date(
                                        'd/m/Y H:i',
                                        strtotime($diagnosis['datetime_creat'])
                                    );
                                }

                                // KATEGORI LINK
                                $kategoriElement = '
                                    <a href="javascript:void(0);" class="text-primary text-decoration-underline modal_detail_diagnosis" data-id="'.$id_diagnosis.'">
                                        <small><i>'.$kategori.'</i></small>
                                    </a>
                                ';

                                // ======================================
                                // DROPDOWN OPSI
                                // ======================================
                                $opsiButton = '
                                    <div class="dropdown icon-btn">
                                        <button class="btn btn-sm btn-icon btn-outline-info" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item modal_detail_diagnosis" href="javascript:void(0);" data-id="'.$id_diagnosis.'">
                                                    <i class="bi bi-info-circle"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item modal_edit_diagnosis" href="javascript:void(0);" data-id="'.$id_diagnosis.'">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger modal_hapus_diagnosis" href="javascript:void(0);" data-id="'.$id_diagnosis.'">
                                                    <i class="bi bi-trash"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                ';

                            } else {

                                // ======================================
                                // KATEGORI TEXT BIASA
                                // ======================================
                                $kategoriElement = '
                                    <small class="text-muted">
                                        <i>'.$kategori.'</i>
                                    </small>
                                ';

                                // ======================================
                                // BUTTON ADD
                                // ======================================
                                $opsiButton = '
                                    <div class="icon-btn">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-danger modal_tambah_diagnosis" data-id_kunjungan="'.$id_kunjungan.'" data-kategori="'.$kategori.'" >
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                ';
                            }

                            // ==========================================
                            // TAMPILKAN ROW
                            // ==========================================
                            echo '
                                <tr>

                                    <td align="center">
                                        <small class="text-muted">'.$no.'</small>
                                    </td>

                                    <td align="left">
                                        '.$kategoriElement.'
                                    </td>

                                    <td align="left">
                                        <small class="text-muted">
                                            '.$dokter.'
                                        </small>
                                    </td>

                                    <td align="left">
                                        <small class="text-muted">
                                            '.$diagnosis_text.'
                                        </small>
                                    </td>

                                    <td align="left">
                                        <small class="text-muted">
                                            '.$icd_version.'
                                        </small>
                                    </td>

                                    <td align="left">
                                        <small class="text-muted">
                                            '.$icd_kode.'
                                        </small>
                                    </td>

                                    <td align="left">
                                        <small class="text-muted">
                                            '.$icd_deskripsi.'
                                        </small>
                                    </td>

                                    <td align="left">
                                        <small class="text-muted">
                                            '.$datetime_creat.'
                                        </small>
                                    </td>
                                    <td align="center" class="icon-btn">'.$id_condition.'</td>
                                    <td align="center">'.$opsiButton.'</td>

                                </tr>
                            ';
                        }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>