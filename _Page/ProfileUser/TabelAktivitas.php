<?php
    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";
    
    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Sessi Akses
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td align="center" colspan="4">
                    <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Validasi Tahun dan Bulan Tidak Boleh Kosong
    if(empty($_POST['tahun'])){
        echo '
            <tr>
                <td align="center" colspan="4">
                    <small class="text text-danger">Tentukan Periode Tahun Data Terlebih Dulu!</small>
                </td>
            </tr>
        ';
        exit;
    }
    if(empty($_POST['bulan'])){
        echo '
            <tr>
                <td align="center" colspan="4">
                    <small class="text text-danger">Tentukan Periode Bulan Data Terlebih Dulu!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Buat Variabel
    $tahun = $_POST['tahun'];
    $bulan = $_POST['bulan'];
    $periode_data = "$tahun-$bulan";
    $bulan_list = [
        "01" => "Januari",
        "02" => "Februari",
        "03" => "Maret",
        "04" => "April",
        "05" => "Mei",
        "06" => "Juni",
        "07" => "Juli",
        "08" => "Agustus",
        "09" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Desember"
    ];
    $nama_bulan = $bulan_list[$bulan];

    // PASIEN
    $query_pasien = mysqli_query($Conn, "SELECT id_pasien FROM pasien WHERE id_akses='$SessionIdAkses' AND tanggal_daftar LIKE '%$periode_data%'");
    $jml_pasien = mysqli_num_rows($query_pasien);

    // KUNJUNGAN
    $query_kunjungan = mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_akses='$SessionIdAkses' AND tanggal LIKE '%$periode_data%'");
    $jml_kunjungan = mysqli_num_rows($query_kunjungan);

?>
<tr class="modal_detail_aktivitas" data-kategori="Pasien" data-periode="<?php echo $periode_data; ?>" style="cursor:pointer;">
    <td class="text-center">
        <small class="text text-muted">1</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Pasien</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Data Master Pasien</small>
    </td>
    <td class="text-center">
        <small class="text text-muted"><?php echo $jml_pasien;?></small>
    </td>
</tr>
<tr class="modal_detail_aktivitas" data-kategori="Kunjungan" data-periode="<?php echo $periode_data; ?>" style="cursor:pointer;">
    <td class="text-center">
        <small class="text text-muted">2</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Kunjungan</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Kunjungan Rajal/Ranap</small>
    </td>
    <td class="text-center">
        <small class="text text-muted"><?php echo $jml_kunjungan;?></small>
    </td>
</tr>
<tr>
    <td class="text-center">
        <small class="text text-muted">3</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Kunjungan</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">SEP</small>
    </td>
    <td class="text-center">
        <small class="text text-muted">1.000</small>
    </td>
</tr>
<tr>
    <td class="text-center">
        <small class="text text-muted">4</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Kunjungan</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Diagnosis</small>
    </td>
    <td class="text-center">
        <small class="text text-muted">1.000</small>
    </td>
</tr>
<tr>
    <td class="text-center">
        <small class="text text-muted">5</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Kunjungan</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Rujukan</small>
    </td>
    <td class="text-center">
        <small class="text text-muted">1.000</small>
    </td>
</tr>
<tr>
    <td class="text-center">
        <small class="text text-muted">6</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Kunjungan</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Resume Medis</small>
    </td>
    <td class="text-center">
        <small class="text text-muted">1.000</small>
    </td>
</tr>
<tr>
    <td class="text-center">
        <small class="text text-muted">7</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Kunjungan</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Anamnesis</small>
    </td>
    <td class="text-center">
        <small class="text text-muted">1.000</small>
    </td>
</tr>
<tr>
    <td class="text-center">
        <small class="text text-muted">8</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">Kunjungan</small>
    </td>
    <td class="text-left">
        <small class="text text-muted">General Consent</small>
    </td>
    <td class="text-center">
        <small class="text text-muted">1.000</small>
    </td>
</tr>

<script>
    var nama_bulan = "<?php echo $nama_bulan; ?>" ;
    var tahun      = "<?php echo $tahun; ?>" ;
    $('.show_modal_filter_aktivitas').html(''+nama_bulan+', '+tahun+'');
</script>