<?php
    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    require '../../vendor/autoload.php';

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger mb-0">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // VALIDASI ID
    // =========================================================
    if (empty($_GET['id'])) {
        echo '
            <div class="alert alert-danger mb-0">
                <small>ID General Consent tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_general_consent = validateAndSanitizeInput($_GET['id']);

    // =========================================================
    // GET SETTING
    // =========================================================
    $querySetting = "SELECT * FROM setting LIMIT 1";
    $resultSetting = mysqli_query($Conn, $querySetting);
    $Setting = mysqli_fetch_assoc($resultSetting);

    $hospital_name    = $Setting['hospital_name'] ?? 'RUMAH SAKIT';
    $hospital_address = $Setting['hospital_address'] ?? '';
    $hospital_contact = $Setting['hospital_contact'] ?? '';
    $hospital_email   = $Setting['hospital_email'] ?? '';
    $logo             = $Setting['logo'] ?? '';

    // =========================================================
    // GET GENERAL CONSENT
    // =========================================================
    $sql = "
        SELECT 
            gc.*,

            k.id_encounter,
            k.jenis_kunjungan,
            k.datetime_daftar,

            p.nama AS nama_pasien,
            p.nik AS nik_pasien,
            p.gender,
            p.tanggal_lahir

        FROM general_consent gc

        LEFT JOIN kunjungan k 
            ON gc.id_kunjungan = k.id_kunjungan

        LEFT JOIN pasien p
            ON gc.id_pasien = p.id_pasien

        WHERE gc.id_general_consent = ?
        LIMIT 1
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_general_consent);
    $stmt->execute();

    $result = $stmt->get_result();
    $Data = $result->fetch_assoc();

    if (empty($Data)) {
        echo '
            <div class="alert alert-danger mb-0">
                <small>Data General Consent tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // MAPPING DATA
    // =========================================================
    $id_kunjungan            = $Data['id_kunjungan'] ?? '';
    $id_pasien               = $Data['id_pasien'] ?? '';
    $nama_pasien             = $Data['nama_pasien'] ?? '';
    $nik_pasien              = $Data['nik_pasien'] ?? '';
    $gender                  = $Data['gender'] ?? '';
    $tanggal_lahir           = $Data['tanggal_lahir'] ?? '';
    $id_encounter            = $Data['id_encounter'] ?? '';
    $jenis_kunjungan         = $Data['jenis_kunjungan'] ?? '';
    $datetime_daftar         = $Data['datetime_daftar'] ?? '';

    $metode_consent          = $Data['metode_consent'] ?? '';
    $policy_rule             = strtoupper($Data['policy_rule'] ?? '');

    $petugas_edukasi_nama    = $Data['petugas_edukasi_nama'] ?? '';
    $petugas_edukasi_nik     = $Data['petugas_edukasi_nik'] ?? '';
    $petugas_edukasi_ttd     = $Data['petugas_edukasi_ttd'] ?? '';

    $penandatangan_tipe      = $Data['penandatangan_tipe'] ?? '';
    $penandatangan_nama      = $Data['penandatangan_nama'] ?? '';
    $penandatangan_nik       = $Data['penandatangan_nik'] ?? '';
    $penandatangan_ttd       = $Data['penandatangan_ttd'] ?? '';

    $pernyataan_pasien       = $Data['pernyataan_pasien'] ?? '[]';
    $datetime_creat          = $Data['datetime_creat'] ?? '';

    // =========================================================
    // FORMAT DATA
    // =========================================================
    if (!empty($datetime_daftar)) {
        $datetime_daftar = date('d/m/Y H:i', strtotime($datetime_daftar));
    }

    if (!empty($datetime_creat)) {
        $datetime_creat = date('d/m/Y H:i', strtotime($datetime_creat));
    }

    if (!empty($tanggal_lahir)) {
        $tanggal_lahir = date('d/m/Y', strtotime($tanggal_lahir));
    }

    // =========================================================
    // DECODE JSON PERNYATAAN
    // =========================================================
    $arrPernyataan = json_decode($pernyataan_pasien, true);

    $htmlPernyataan = '';

    if (!empty($arrPernyataan)) {

        $no = 1;

        foreach ($arrPernyataan as $item) {

            $htmlPernyataan .= '
                <tr>
                    <td width="5%" style="vertical-align:top;">'.$no.'.</td>
                    <td width="95%" style="text-align:justify;">
                        '.$item.'
                    </td>
                </tr>
            ';

            $no++;
        }
    }

    // =========================================================
    // LOGO
    // =========================================================
    $logoPath = '../../assets/images/'.$logo;

    if (!empty($logo) && file_exists($logoPath)) {

        $logoData = base64_encode(file_get_contents($logoPath));

        $logoHtml = '
            <img 
                src="data:image/png;base64,'.$logoData.'" 
                style="width:80px;"
            >
        ';
    } else {

        $logoHtml = '';
    }

    // =========================================================
    // HTML PDF
    // =========================================================
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">

        <style>

            body{
                font-family: DejaVu Sans, sans-serif;
                font-size:12px;
                color:#000;
            }

            .text-center{
                text-align:center;
            }

            .text-right{
                text-align:right;
            }

            .mb-10{
                margin-bottom:10px;
            }

            .mb-20{
                margin-bottom:20px;
            }

            .table{
                width:100%;
                border-collapse:collapse;
            }

            .table td{
                padding:4px;
                vertical-align:top;
            }

            .table-border{
                width:100%;
                border-collapse:collapse;
            }

            .table-border td,
            .table-border th{
                border:1px solid #000;
                padding:6px;
            }

            .title{
                font-size:18px;
                font-weight:bold;
            }

            .subtitle{
                font-size:14px;
                font-weight:bold;
            }

            hr{
                border:1px solid #000;
            }

            .signature-box{
                border:1px solid #999;
                height:120px;
                text-align:center;
                vertical-align:middle;
            }

        </style>
    </head>

    <body>

        <!-- ================================================= -->
        <!-- KOP SURAT -->
        <!-- ================================================= -->
        <table width="100%">
            <tr>

                <td width="15%" class="text-center">
                    '.$logoHtml.'
                </td>

                <td width="85%" class="text-center">

                    <div class="title">
                        '.$hospital_name.'
                    </div>

                    <div>
                        '.$hospital_address.'
                    </div>

                    <div>
                        Telp : '.$hospital_contact.' | Email : '.$hospital_email.'
                    </div>

                </td>

            </tr>
        </table>

        <hr>

        <!-- ================================================= -->
        <!-- JUDUL -->
        <!-- ================================================= -->
        <div class="text-center mb-20">
            <div class="subtitle">
                GENERAL CONSENT / PERSETUJUAN UMUM
            </div>
        </div>

        <!-- ================================================= -->
        <!-- DATA PASIEN -->
        <!-- ================================================= -->
        <table class="table mb-20">

            <tr>
                <td width="25%">No. RM</td>
                <td width="2%">:</td>
                <td width="73%">'.$id_pasien.'</td>
            </tr>

            <tr>
                <td>Nama Pasien</td>
                <td>:</td>
                <td>'.$nama_pasien.'</td>
            </tr>

            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>'.$nik_pasien.'</td>
            </tr>

            <tr>
                <td>Gender</td>
                <td>:</td>
                <td>'.$gender.'</td>
            </tr>

            <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td>'.$tanggal_lahir.'</td>
            </tr>

            <tr>
                <td>No. Registrasi</td>
                <td>:</td>
                <td>'.$id_kunjungan.'</td>
            </tr>

            <tr>
                <td>Jenis Kunjungan</td>
                <td>:</td>
                <td>'.$jenis_kunjungan.'</td>
            </tr>

            <tr>
                <td>Tanggal Pendaftaran</td>
                <td>:</td>
                <td>'.$datetime_daftar.'</td>
            </tr>

            <tr>
                <td>ID Encounter</td>
                <td>:</td>
                <td>'.$id_encounter.'</td>
            </tr>

            <tr>
                <td>Metode Consent</td>
                <td>:</td>
                <td>'.$metode_consent.'</td>
            </tr>

            <tr>
                <td>Policy Rule</td>
                <td>:</td>
                <td>'.$policy_rule.'</td>
            </tr>

        </table>

        <!-- ================================================= -->
        <!-- ISI PERNYATAAN -->
        <!-- ================================================= -->
        <div class="subtitle mb-10">
            Pernyataan / Persetujuan
        </div>

        <table class="table mb-20">
            '.$htmlPernyataan.'
        </table>

        <!-- ================================================= -->
        <!-- PENANGGUNG JAWAB -->
        <!-- ================================================= -->
        <div class="subtitle mb-10">
            Penanggung Jawab
        </div>

        <table class="table mb-20">

            <tr>
                <td width="25%">Jenis Penanggung Jawab</td>
                <td width="2%">:</td>
                <td width="73%">'.$penandatangan_tipe.'</td>
            </tr>

            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>'.$penandatangan_nama.'</td>
            </tr>

            <tr>
                <td>NIK / KTP</td>
                <td>:</td>
                <td>'.$penandatangan_nik.'</td>
            </tr>

        </table>

        <!-- ================================================= -->
        <!-- TANDA TANGAN -->
        <!-- ================================================= -->
        <table width="100%" class="table">

            <tr>

                <td width="50%" class="text-center">

                    <div>
                        Penanggung Jawab
                    </div>

                    <div class="signature-box">

                        <img 
                            src="'.$penandatangan_ttd.'" 
                            style="max-width:200px; max-height:100px;"
                        >

                    </div>

                    <div>
                        <b>'.$penandatangan_nama.'</b>
                    </div>

                </td>

                <td width="50%" class="text-center">

                    <div>
                        Petugas Pemberi Edukasi
                    </div>

                    <div class="signature-box">

                        <img 
                            src="'.$petugas_edukasi_ttd.'" 
                            style="max-width:200px; max-height:100px;"
                        >

                    </div>

                    <div>
                        <b>'.$petugas_edukasi_nama.'</b>
                    </div>

                </td>

            </tr>

        </table>

        <!-- ================================================= -->
        <!-- FOOTER -->
        <!-- ================================================= -->
        <div style="margin-top:30px; font-size:10px; color:#666;">
            Dokumen ini dicetak otomatis oleh sistem pada '.date('d/m/Y H:i:s').'
        </div>

    </body>
    </html>
    ';

    // =====================================================
    // MPDF
    // =====================================================
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_top' => 15,
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_bottom' => 15
    ]);

    // TITLE
    $mpdf->SetTitle('General Consent');

    // WRITE HTML
    $mpdf->WriteHTML($html);

    // OUTPUT PDF
    $mpdf->Output(
        'General-Consent-'.$id_general_consent.'.pdf',
        \Mpdf\Output\Destination::INLINE
    );
    exit;
?>