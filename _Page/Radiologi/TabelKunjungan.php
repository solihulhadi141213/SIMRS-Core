<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    
    //keyword
    if(!empty($_POST['keyword_kunjungan'])){
        $keyword = $_POST['keyword_kunjungan'];
    }else{
        $keyword = "";
    }

    // Limit
    $limit = "10";

    // Menentukan Posisi
    if(!empty($_POST['page_kunjungan'])){
        $page   = $_POST['page_kunjungan'];
        $posisi = ( $page - 1 ) * $limit;
    }else{
        $page   = 1;
        $posisi = 0;
    }
   
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_pasien like '%$keyword%' OR nama like '%$keyword%'"));
    }

    if(empty($jml_data)){
        echo '
            <tr>
                <td colaspn="5" class="text-center">Tidak Ada Data Yang Ditemukan</td>
            </tr>
            <script>
                $("#page_info").html("0 / 0");
            </script>
        ';
        exit;
    }
    // Menghiutng Jumlah Total Halaman
    $JmlHalaman = ceil($jml_data/$limit); 

    // Menampilkan Data Berdasarkan Filter
    $no = 1+$posisi;
    if(empty($keyword)){
        $query = mysqli_query($Conn, "SELECT id_kunjungan, id_pasien, nama, tanggal, tujuan FROM kunjungan_utama ORDER BY id_kunjungan DESC LIMIT $posisi, $limit");
    }else{
        $query = mysqli_query($Conn, "SELECT id_kunjungan, id_pasien, nama, tanggal, tujuan  FROM kunjungan_utama WHERE id_pasien like '%$keyword%' OR nama like '%$keyword%' ORDER BY id_kunjungan DESC LIMIT $posisi, $limit");
    }
    while ($data = mysqli_fetch_array($query)) {
        $id_kunjungan= $data['id_kunjungan'];

        // Tampilkan data
        echo '
            <tr class="pilih_kunjungan" style="cursor:pointer;" data-id="'.$data['id_kunjungan'].'">
                <td class="text-center">'.$no.'</td>
                <td>'.$data['id_pasien'].'</td>
                <td>'.$data['nama'].'</td>
                <td>'.date('d F Y', strtotime($data['tanggal'])).'</td>
                <td>'.$data['tujuan'].'</td>
            </tr>
        ';
        $no++;
    }
    echo '
        <script>
            $("#page_info").html("'.$page.' / '.$JmlHalaman.'");
        </script>
    ';
?>
