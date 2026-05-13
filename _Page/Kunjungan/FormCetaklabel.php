<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // Validasi ID
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // Sanitasi
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // Query
    $sql = "
        SELECT 
            kunjungan.*,

            pasien.nama AS nama_pasien,
            pasien.nik,
            pasien.gender,
            pasien.tanggal_lahir

        FROM kunjungan
        LEFT JOIN pasien 
            ON kunjungan.id_pasien = pasien.id_pasien

        WHERE kunjungan.id_kunjungan = ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_kunjungan);
    $stmt->execute();

    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    $stmt->close();

    // Validasi data
    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data kunjungan tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Data
    $id_pasien       = $Data['id_pasien'] ?? '';
    $nama_pasien     = $Data['nama_pasien'] ?? '';
    $nik             = $Data['nik'] ?? '';
    $gender          = $Data['gender'] ?? '';
    $tanggal_lahir   = $Data['tanggal_lahir'] ?? '';
    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? '';
    $poliklinik      = $Data['poliklinik'] ?? '';
    $kelas           = $Data['kelas'] ?? '';
    $ruang_rawat     = $Data['ruang_rawat'] ?? '';

    // Nomor RM tanpa nol depan
    $no_rm = (string)$id_pasien;

    // Usia
    $usia = hitungUsia($tanggal_lahir);

    // Gender
    $gender_label = ($gender == 'Laki-laki') ? 'L' : 'P';

    // Informasi layanan
    if ($jenis_kunjungan == 'Ranap') {
        $info_layanan = trim($kelas . ', ' . $ruang_rawat, ', ');
    } else {
        $info_layanan = $poliklinik;
    }
?>

<!-- JsBarcode -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

<style>

    /* =========================================
       WRAPPER PREVIEW
    ========================================= */

    .preview-wrapper{
        background:#f8f9fa;
        border-radius:12px;
        padding:24px;
    }

    /* =========================================
       AREA PREVIEW
    ========================================= */

    #print-area{
        display:flex;
        justify-content:center;
        align-items:center;
    }

    /* =========================================
       LABEL PREVIEW (BESAR)
    ========================================= */

    .label-pasien{

        width:430px;
        min-height:150px;

        background:#fff;

        border-radius:16px;
        box-shadow:0 2px 12px rgba(0,0,0,0.12);

        padding:16px 18px;

        box-sizing:border-box;

        display:flex;
        justify-content:space-between;
        align-items:center;

        gap:16px;

        font-family:Arial, sans-serif;
    }

    /* =========================================
       IDENTITAS
    ========================================= */

    .label-identitas{
        flex:1;
        overflow:hidden;
    }

    .label-rm{
        font-size:36px;
        font-weight:700;
        line-height:1;
        margin-bottom:10px;
    }

    .label-nama{

        font-size:14px;
        font-weight:700;

        line-height:1.2;

        margin-bottom:10px;

        word-break:break-word;
    }

    .label-meta{
        display:flex;
        align-items:center;
        gap:8px;

        margin-bottom:8px;
    }

    .gender-box{

        background:#000;
        color:#fff;

        min-width:28px;
        height:28px;

        border-radius:6px;

        display:flex;
        justify-content:center;
        align-items:center;

        font-size:15px;
        font-weight:bold;
    }

    .usia-label{
        font-size:14px;
        font-weight:600;
    }

    .layanan-label{

        font-size:13px;
        font-weight:600;

        line-height:1.2;

        word-break:break-word;
    }

    /* =========================================
       BARCODE
    ========================================= */

    .barcode-wrapper{

        width:160px;
        flex-shrink:0;

        border-left:1px dashed #ccc;

        padding-left:12px;

        text-align:center;
    }

    #barcode{
        width:100%;
        height:80px;
    }

    .barcode-text{

        font-size:15px;
        font-weight:bold;

        margin-top:4px;
    }

</style>

<div class="preview-wrapper">

    <div class="alert alert-primary mb-4">
        <b>Preview Label Pasien</b><br>
        Pastikan data pasien dan barcode sudah sesuai sebelum dicetak.
    </div>

    <div id="print-area">

        <div class="label-pasien">

            <!-- IDENTITAS -->
            <div class="label-identitas">

                <div class="label-rm">
                    RM <?= htmlspecialchars($no_rm); ?>
                </div>

                <div class="label-nama">
                    <?= strtoupper(htmlspecialchars($nama_pasien)); ?>
                </div>

                <div class="label-meta">

                    <div class="gender-box">
                        <?= $gender_label; ?>
                    </div>

                    <div class="usia-label">
                        <?= htmlspecialchars($usia); ?>
                    </div>

                </div>

                <div class="layanan-label">
                    <?= strtoupper(htmlspecialchars($info_layanan)); ?>
                </div>

            </div>

            <!-- BARCODE -->
            <div class="barcode-wrapper">

                <svg id="barcode"></svg>

                <div class="barcode-text">
                    <?= htmlspecialchars($no_rm); ?>
                </div>

            </div>

        </div>

    </div>

</div>

<script>

    // =========================================
    // AKTIFKAN TOMBOL CETAK
    // =========================================
    $('#ButtonCetak').prop('disabled', false);

    // =========================================
    // GENERATE BARCODE
    // =========================================
    function generateBarcode(){

        const barcodeElement = document.getElementById("barcode");

        if(typeof JsBarcode !== 'undefined'){

            try{

                JsBarcode(barcodeElement, "<?= $no_rm; ?>", {
                    format: "CODE128",
                    lineColor: "#000",
                    width: 2,
                    height: 55,
                    displayValue: false,
                    margin: 0
                });

            }catch(err){

                console.log(err);

                $('.barcode-wrapper').html(`
                    <div class="text-danger small">
                        Barcode gagal dibuat
                    </div>
                `);

            }

        }else{

            $('.barcode-wrapper').html(`
                <div class="text-danger small">
                    Library JsBarcode belum dimuat
                </div>
            `);

        }

    }

    // Tunggu library siap
    setTimeout(function(){
        generateBarcode();
    }, 300);

    // =========================================
    // CETAK LABEL
    // =========================================
    $('#ProsesCetaklabel').off('submit').on('submit', function(e){

        e.preventDefault();

        // Ambil SVG barcode
        let barcodeSvg = document.getElementById('barcode').outerHTML;

        // Buka window print
        let printWindow = window.open('', '', 'width=500,height=300');

        // Tulis HTML print
        printWindow.document.write(`
            <html>

            <head>

                <title>Cetak Label Pasien</title>

                <style>

                    @page{
                        margin:0;
                    }

                    html, body{
                        margin:0;
                        padding:0;
                        font-family:Arial, sans-serif;
                    }

                    body{
                        padding:2mm;
                    }

                    /* =========================================
                       LABEL CETAK UKURAN KECIL
                    ========================================= */

                    .label-pasien{

                        width:50mm;
                        height:20mm;

                        box-sizing:border-box;

                        display:flex;
                        justify-content:space-between;
                        align-items:center;

                        gap:2mm;

                        overflow:hidden;

                        font-family:Arial, sans-serif;
                    }

                    .label-identitas{
                        flex:1;
                        overflow:hidden;
                    }

                    .label-rm{

                        font-size:10pt;
                        font-weight:bold;

                        line-height:1;

                        margin-bottom:1mm;
                    }

                    .label-nama{

                        font-size:5pt;
                        font-weight:bold;

                        line-height:1.1;

                        margin-bottom:1mm;

                        word-break:break-word;
                    }

                    .label-meta{
                        display:flex;
                        align-items:center;
                        gap:1mm;

                        margin-bottom:1mm;
                    }

                    .gender-box{

                        min-width:4mm;
                        height:4mm;

                        background:#000;
                        color:#fff;

                        display:flex;
                        align-items:center;
                        justify-content:center;

                        font-size:5pt;
                        font-weight:bold;

                        border-radius:1mm;
                    }

                    .usia-label{
                        font-size:4.5pt;
                    }

                    .layanan-label{

                        font-size:4pt;
                        font-weight:bold;

                        line-height:1.1;
                    }

                    .barcode-wrapper{

                        width:16mm;
                        flex-shrink:0;

                        text-align:center;
                    }

                    .barcode-wrapper svg{
                        width:100%;
                        height:8mm;
                    }

                    .barcode-text{

                        font-size:4.5pt;
                        font-weight:bold;

                        margin-top:0.5mm;
                    }

                </style>

            </head>

            <body>

                <div class="label-pasien">

                    <div class="label-identitas">

                        <div class="label-rm">
                            RM <?= htmlspecialchars($no_rm); ?>
                        </div>

                        <div class="label-nama">
                            <?= strtoupper(htmlspecialchars($nama_pasien)); ?>
                        </div>

                        <div class="label-meta">

                            <div class="gender-box">
                                <?= $gender_label; ?>
                            </div>

                            <div class="usia-label">
                                <?= htmlspecialchars($usia); ?>
                            </div>

                        </div>

                        <div class="layanan-label">
                            <?= strtoupper(htmlspecialchars($info_layanan)); ?>
                        </div>

                    </div>

                    <div class="barcode-wrapper">

                        ${barcodeSvg}

                        <div class="barcode-text">
                            <?= htmlspecialchars($no_rm); ?>
                        </div>

                    </div>

                </div>

                <script>

                    window.onload = function(){

                        window.print();

                        setTimeout(function(){
                            window.close();
                        }, 500);

                    }

                <\/script>

            </body>

            </html>
        `);

        printWindow.document.close();

    });

</script>