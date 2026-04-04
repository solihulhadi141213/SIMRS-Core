<?php
    //Koneksi Database
    include "../../_Config/Connection.php";

    // Inisialisasi Jumlah Halaman
    $JmlHalaman = 0;

    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }

    //page
    if(!empty($_POST['limit'])){
        $limit=$_POST['limit'];
    }else{
        $limit="1";
    }
    
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $limit;
    }else{
        $page="1";
        $posisi = 0;
    }

    // Menghitung Jumlah Data
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE status!='Pulang' AND status!='Batal'"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE (id_pasien like '%$keyword%' OR nama like '%$keyword%' OR tujuan like '%$keyword%' OR poliklinik like '%$keyword%' OR ruangan like '%$keyword%') AND status!='Pulang' AND status!='Batal'"));
    }

    // Jika Tidak Ada Data
    if(empty($jml_data)){
       echo '
            <tr>
                <td colspan="7" class="text-center">
                    <small>Data Tidak Ditemukan</small>
                </td>
            </tr>
       ';
    }
    $JmlHalaman = ceil($jml_data/$limit); 

    $no = 1+$posisi;
    //KONDISI PENGATURAN MASING FILTER
    if(empty($keyword)){
        $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama ORDER BY id_kunjungan DESC LIMIT $posisi, $limit");
    }else{
        $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE (id_pasien like '%$keyword%' OR nama like '%$keyword%' OR tujuan like '%$keyword%' OR poliklinik like '%$keyword%' OR ruangan like '%$keyword%') AND status!='Pulang' AND status!='Batal' ORDER BY id_kunjungan DESC LIMIT $posisi, $limit");
    }
    while ($data = mysqli_fetch_array($query)) {
        $id_pasien  = $data['id_pasien'];
        $noRm       = sprintf("%07d", $id_pasien);
        $tanggal    = $data['tanggal'];
        $nama       = $data['nama'];
        $tujuan     = $data['tujuan'];
        $poliklinik = $data['poliklinik'];
        $ruangan    = $data['ruangan'];

        // Routing Kunjungan
        if($tujuan=="Rajal"){
            $label_tujuan = '<span class="badge bg-success">RAJAL</span>';
        }else{
            if($tujuan=="Ranap"){
                $label_tujuan = '<span class="badge bg-primary">RANAP</span>';
            }else{
                $label_tujuan = '<span class="badge bg-dark">NONE</span>';
            }
        }
        echo '
            <tr>
                <td class="text-center"><small>'.$no.'</small></td>
                <td class="text-left"><small>'.$noRm.'</small></td>
                <td class="text-left"><small>'.$nama.'</small></td>
                <td class="text-left"><small>'.date('d/m/Y', strtotime($tanggal)).'</small></td>
                <td class="text-center">'.$label_tujuan.'</td>
            </tr>
        ';
        $no++; 
    }
?>

<script>
    //Creat Javascript Variabel
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_info').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#previous_page').prop('disabled', true);
    }else{
        $('#previous_page').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_page').prop('disabled', true);
    }else{
        $('#next_page').prop('disabled', false);
    }
</script>