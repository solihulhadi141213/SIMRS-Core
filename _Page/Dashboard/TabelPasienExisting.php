<?php
    // Koneksi Database
    include "../../_Config/Connection.php";

    // =========================
    // PARAMETER
    // =========================
    $keyword = !empty($_POST['keyword']) ? trim($_POST['keyword']) : '';
    $limit   = !empty($_POST['limit']) ? (int) $_POST['limit'] : 10;
    $page    = !empty($_POST['page']) ? (int) $_POST['page'] : 1;

    // Validasi minimum
    if($limit <= 0){
        $limit = 10;
    }

    if($page <= 0){
        $page = 1;
    }

    $posisi = ($page - 1) * $limit;

    // =========================
    // WHERE CONDITION
    // =========================
    $where = "WHERE k.status!='Selesai' AND k.status!='Batal'";

    if(!empty($keyword)){
        $keyword = mysqli_real_escape_string($Conn, $keyword);

        $where .= " AND (
            p.nama LIKE '%$keyword%' OR
            k.id_pasien LIKE '%$keyword%' OR
            k.tujuan LIKE '%$keyword%' OR
            k.poliklinik LIKE '%$keyword%' OR
            k.ruang_rawat LIKE '%$keyword%'
        )";
    }

    // =========================
    // HITUNG TOTAL DATA
    // =========================
    $query_count = "
        SELECT COUNT(*) as total
        FROM kunjungan k
        LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
        $where
    ";

    $result_count = mysqli_query($Conn, $query_count);
    $data_count   = mysqli_fetch_assoc($result_count);

    $jml_data = $data_count['total'];

    // =========================
    // JIKA DATA KOSONG
    // =========================
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="7" class="text-center">
                    <small>Data Tidak Ditemukan</small>
                </td>
            </tr>
        ';
    }

    // =========================
    // PAGINATION
    // =========================
    $JmlHalaman = ceil($jml_data / $limit);

    // =========================
    // QUERY DATA
    // =========================
    $query = "
        SELECT
            k.id_kunjungan,
            k.id_pasien,
            k.tanggal_kunjungan,
            k.tujuan,
            k.poliklinik,
            k.ruang_rawat,
            p.nama
        FROM kunjungan k
        LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
        $where
        ORDER BY k.id_kunjungan DESC
        LIMIT $posisi, $limit
    ";

    $result = mysqli_query($Conn, $query);

    $no = 1 + $posisi;

    while($data = mysqli_fetch_assoc($result)){

        $id_pasien         = $data['id_pasien'];
        $noRm              = sprintf("%07d", $id_pasien);
        $tanggal_kunjungan = $data['tanggal_kunjungan'];
        $nama              = $data['nama'];
        $tujuan            = $data['tujuan'];
        $poliklinik        = $data['poliklinik'];
        $ruang_rawat       = $data['ruang_rawat'];

        // Label Tujuan
        if($tujuan == "Rajal"){
            $label_tujuan = '
                <span class="py-1 px-2 bg-success-subtle text-success rounded-1">
                    <small>Rajal</small>
                </span>
            ';
        }elseif($tujuan == "Ranap"){
            $label_tujuan = '
                <span class="py-1 px-2 bg-danger-subtle text-danger rounded-1">
                    <small>Ranap</small>
                </span>
            ';
        }else{
            $label_tujuan = '
                <span class="py-1 px-2 bg-secondary-subtle text-secondary rounded-1">
                    <small>None</small>
                </span>
            ';
        }

        echo '
            <tr>
                <td class="text-center">
                    <small class="text-muted">'.$no.'</small>
                </td>

                <td class="text-start">
                    <small class="text-muted">'.$noRm.'</small>
                </td>

                <td class="text-start">
                    <small class="text-muted">'.$nama.'</small>
                </td>

                <td class="text-start">
                    <small class="text-muted">'.date('d/m/Y', strtotime($tanggal_kunjungan)).'</small>
                </td>

                <td class="text-center">
                    '.$label_tujuan.'
                </td>
            </tr>
        ';

        $no++;
    }
?>

<script>
    // Creat Javascript Variabel
    var page_count = <?php echo $JmlHalaman; ?>;
    var curent_page = <?php echo $page; ?>;

    // Put Into Pagging Element
    $('#page_info').html('Page ' + curent_page + ' Of ' + page_count);

    // Set Pagging Button
    if(curent_page == 1){
        $('#previous_page').prop('disabled', true);
    }else{
        $('#previous_page').prop('disabled', false);
    }

    if(page_count <= curent_page){
        $('#next_page').prop('disabled', true);
    }else{
        $('#next_page').prop('disabled', false);
    }
</script>