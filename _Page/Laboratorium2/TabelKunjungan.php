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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_pasien like '%$keyword%' OR nama like '%$keyword%'"));
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
        $query = mysqli_query($Conn, "SELECT id_kunjungan, id_encounter, id_pasien, nama, tanggal, tujuan, poliklinik, ruangan, pembayaran FROM kunjungan_utama ORDER BY id_kunjungan DESC LIMIT $posisi, $limit");
    }else{
        $query = mysqli_query($Conn, "SELECT id_kunjungan, id_encounter, id_pasien, nama, tanggal, tujuan, poliklinik, ruangan, pembayaran  FROM kunjungan_utama WHERE id_pasien like '%$keyword%' OR nama like '%$keyword%' ORDER BY id_kunjungan DESC LIMIT $posisi, $limit");
    }
    while ($data = mysqli_fetch_array($query)) {
        $id_encounter = $data['id_encounter'];
        $id_kunjungan = $data['id_kunjungan'];
        $id_pasien    = $data['id_pasien'];
        $poliklinik   = $data['poliklinik'];
        $ruangan      = $data['ruangan'];
        $tujuan       = $data['tujuan'];

        // Buka Data Dari Tabel pasien
        $tanggal_lahir = getDataDetail_v2($Conn, 'pasien', 'id_pasien', $id_pasien, 'tanggal_lahir');
        $gender        = getDataDetail_v2($Conn, 'pasien', 'id_pasien', $id_pasien, 'gender');
        $id_ihs        = getDataDetail_v2($Conn, 'pasien', 'id_pasien', $id_pasien, 'id_ihs');

        // Apabila Rajal / Ranap
        if($tujuan=="Rajal"){
            $unit = $poliklinik;
        }else{
            $unit = $ruangan;
        }

        // Tampilkan data
        echo '
            <tr class="pilih_kunjungan" style="cursor:pointer;" data-id_kunjungan="'.$data['id_kunjungan'].'" data-id_pasien="'.$id_pasien.'" data-nama="'.$data['nama'].'" data-tanggal_lahir="'.$tanggal_lahir.'" data-gender="'.$gender.'" data-tujuan="'.$data['tujuan'].'" data-pembayaran="'.$data['pembayaran'].'" data-unit="'.$unit.'" data-id_ihs="'.$id_ihs.'" data-id_encounter="'.$id_encounter.'">
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
            $("#page_info_kunjungan").html("'.$page.' / '.$JmlHalaman.'");
        </script>
    ';
?>
