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
                <td align="center" colspan="5">
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
    $keyword = !empty($_POST['keyword']) ? $_POST['keyword'] : "";

    //Atur Page
    if(!empty($_POST['page'])){
        $page = (int)$_POST['page'];
        $posisi = ( $page - 1 ) * $limit;
    }else{
        $page=1;
        $posisi = 0;
    }

    // Filter dasar
    $filterKategori = empty($keyword) ? "" : "WHERE af.kategori LIKE ?";

    // Prepared Statement: hitung kategori dengan filter pencarian opsional.
    $countQuery = mysqli_prepare($Conn, "
        SELECT COUNT(*) AS total 
        FROM (
            SELECT 1 FROM akses_fitur af
            $filterKategori
            GROUP BY af.kategori
        ) kategori_group
    ");
    if (!empty($keyword)) {
        $keywordLike = "%$keyword%";
        mysqli_stmt_bind_param($countQuery, "s", $keywordLike);
    }
    mysqli_stmt_execute($countQuery);
    $countQuery = mysqli_stmt_get_result($countQuery);
    $countData  = mysqli_fetch_assoc($countQuery);
    $jml_data   = !empty($countData['total']) ? (int)$countData['total'] : 0;
    if(empty($jml_data)){
        echo '
            <tr>
                <td align="center" colspan="5">
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
    // Prepared Statement: ambil kategori beserta hak akses dan pagination.
    $stmt = mysqli_prepare($Conn, "
        SELECT 
            af.kategori,
            COUNT(*) AS jumlah_fitur,
            SUM(CASE WHEN aa.id_akses IS NULL THEN 0 ELSE 1 END) AS jumlah_own_fitur
        FROM akses_fitur af
        LEFT JOIN akses_acc aa 
            ON aa.id_akses_fitur = af.id_akses_fitur 
            AND aa.id_akses = ?
        $filterKategori
        GROUP BY af.kategori
        ORDER BY af.kategori ASC
        LIMIT ?, ?
    ");
    if (!empty($keyword)) {
        $keywordLike = "%$keyword%";
        mysqli_stmt_bind_param($stmt, "ssii", $SessionIdAkses, $keywordLike, $posisi, $limit);
    } else {
        mysqli_stmt_bind_param($stmt, "sii", $SessionIdAkses, $posisi, $limit);
    }
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    while ($data = mysqli_fetch_array($query)) {
        $kategori = $data['kategori'];
        $jumlah_fitur = (int)$data['jumlah_fitur'];
        $jumlah_own_fitur = (int)$data['jumlah_own_fitur'];

        echo '
            <tr class="show_own_fiture" data-kategori="'.$kategori.'" style="cursor:pointer;">
                <td align="center"><small class="text text-muted">'.$no.'</small></td>
                <td align="left"><small class="text text-muted">'.$kategori.'</small></td>
                <td align="left"><small class="text text-muted">'.$jumlah_fitur.' Fitur</small></td>
                <td align="left"><small class="text text-muted">'.$jumlah_own_fitur.' Access</small></td>
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
