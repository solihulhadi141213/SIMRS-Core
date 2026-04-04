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
                <td align="center" colspan="3">
                    <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
            <script>
                $("#page_info_ijin_akses").html("0 / 0");
                $("#prev_btn_ijin_akses").prop("disabled", true);
                $("#next_btn_ijin_akses").prop("disabled", true);
            </script>
        ';
        exit;
    }

    // Limit Data yang Ditampilkan
    $limit = 10;

    // keyword
    $keyword = !empty($_POST['keyword']) ? mysqli_real_escape_string($Conn, $_POST['keyword']) : "";

    //Atur Page
    if(!empty($_POST['page'])){
        $page = (int)$_POST['page'];
        $posisi = ( $page - 1 ) * $limit;
    }else{
        $page=1;
        $posisi = 0;
    }

    // Filter dasar
    $filterKategori = empty($keyword) ? "" : "WHERE af.kategori LIKE '%$keyword%'";

    // Hitung Jumlah Data (menggunakan agregasi agar tetap konsisten dengan query utama)
    $countQuery = mysqli_query($Conn, "
        SELECT COUNT(*) AS total 
        FROM (
            SELECT 1 FROM akses_fitur af
            $filterKategori
            GROUP BY af.kategori
        ) kategori_group
    ");
    $countData  = mysqli_fetch_assoc($countQuery);
    $jml_data   = !empty($countData['total']) ? (int)$countData['total'] : 0;
    if(empty($jml_data)){
        echo '
            <tr>
                <td align="center" colspan="3">
                    <small class="text text-danger">Tidak Ada Data Yang Ditemukan!</small>
                </td>
            </tr>
            <script>
                $("#page_info_ijin_akses").html("0 / 0");
                $("#prev_btn_ijin_akses").prop("disabled", true);
                $("#next_btn_ijin_akses").prop("disabled", true);
            </script>
        ';
        exit;
    }
    $JmlHalaman = ceil($jml_data/$limit); 

    // Ambil data kategori beserta jumlah fitur dan hak akses (menghindari N+1 query)
    $no = 1+$posisi;
    $query = mysqli_query($Conn, "
        SELECT 
            af.kategori,
            COUNT(*) AS jumlah_fitur,
            SUM(CASE WHEN aa.id_akses IS NULL THEN 0 ELSE 1 END) AS jumlah_own_fitur
        FROM akses_fitur af
        LEFT JOIN akses_acc aa 
            ON aa.id_akses_fitur = af.id_akses_fitur 
            AND aa.id_akses = '$SessionIdAkses'
        $filterKategori
        GROUP BY af.kategori
        ORDER BY af.kategori ASC
        LIMIT $posisi, $limit
    ");
    while ($data = mysqli_fetch_array($query)) {
        $kategori = $data['kategori'];
        $jumlah_fitur = (int)$data['jumlah_fitur'];
        $jumlah_own_fitur = (int)$data['jumlah_own_fitur'];

        echo '
            <tr>
                <td align="center"><small class="text text-muted">'.$no.'</small></td>
                <td align="left"><small class="text text-muted">'.$kategori.'</small></td>
                <td align="center">
                    <a href="javascript:void(0);" class="show_own_fiture" data-kategori="'.$kategori.'">
                        <small class="text text-primary">'.$jumlah_own_fitur.' / '.$jumlah_fitur.'</small>
                    </a>
                </td>
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
    $('#page_info_ijin_akses').html(''+curent_page+' / '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_btn_ijin_akses').prop('disabled', true);
    }else{
        $('#prev_btn_ijin_akses').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_btn_ijin_akses').prop('disabled', true);
    }else{
        $('#next_btn_ijin_akses').prop('disabled', false);
    }
</script>
