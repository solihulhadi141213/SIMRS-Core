<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword = $_POST['keyword'];
    }else{
        $keyword = "";
    }

    // Limit
    $limit = "10";

    // Menentukan Posisi
    if(!empty($_POST['page'])){
        $page   = $_POST['page'];
        $posisi = ( $page - 1 ) * $limit;
    }else{
        $page   = 1;
        $posisi = 0;
    }
   
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_diagnosa FROM diagnosa"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_diagnosa FROM diagnosa WHERE kode like '%$keyword%' OR long_des like '%$keyword%'"));
    }

    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="5" class="text-center">Tidak Ada Data Yang Ditemukan</td>
            </tr>
        ';
        exit;
    }
    // Menghiutng Jumlah Total Halaman
    $JmlHalaman = ceil($jml_data/$limit); 

    // Menampilkan Data Berdasarkan Filter
    $no = 1+$posisi;
    if(empty($keyword)){
        $query = mysqli_query($Conn, "SELECT * FROM diagnosa ORDER BY long_des ASC LIMIT $posisi, $limit");
    }else{
        $query = mysqli_query($Conn, "SELECT * FROM diagnosa WHERE kode like '%$keyword%' OR long_des like '%$keyword%' ORDER BY long_des ASC LIMIT $posisi, $limit");
    }
    while ($data = mysqli_fetch_array($query)) {
        $kode     = $data['kode'];
        $long_des = $data['long_des'];
        $versi    = $data['versi'];

        // Tampilkan data
        echo '
            <tr class="pilih_diagnosa" style="cursor:pointer;" data-kode="'.$data['kode'].'" data-long_des="'.$long_des.'">
                <td class="text-center">'.$no.'</td>
                <td>'.$data['kode'].'</td>
                <td>'.$data['long_des'].'</td>
                <td>'.$data['versi'].'</td>
                <td>SIMRS</td>
            </tr>
        ';
        $no++;
    }
    echo '
        <script>
            $("#page_info_diagnosa").html("'.$page.' / '.$JmlHalaman.'");
        </script>
    ';
?>
