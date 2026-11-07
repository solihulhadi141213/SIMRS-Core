<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //id_akses
    if(!empty($_POST['id_akses'])){
        $id_akses=$_POST['id_akses'];
    }else{
        $id_akses="";
    }
    //keyword
    if(!empty($_POST['tanggal'])){
        $keyword=$_POST['tanggal'];
    }else{
        if(!empty($_POST['kategori'])){
            $keyword=$_POST['kategori'];
        }else{
            if(!empty($_POST['keyword'])){
                $keyword=$_POST['keyword'];
            }else{
                if(!empty($_POST['nama_log'])){
                    $keyword=$_POST['nama_log'];
                }else{
                    $keyword="";
                }
            }
        }
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=max(1, (int) $_POST['batas']);
    }else{
        $batas=10;
    }
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=strtoupper($_POST['ShortBy']);
        if($ShortBy=="ASC"){
            $NextShort="DESC";
        }else{
            $NextShort="ASC";
        }
    }else{
        $ShortBy="ASC";
        $NextShort="DESC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_log";
    }
    $allowedOrderBy = ['id_log', 'waktu', 'nama_log', 'kategori', 'id_akses'];
    if (!in_array($OrderBy, $allowedOrderBy, true)) {
        $OrderBy = 'id_log';
    }
    if (!in_array($ShortBy, ['ASC', 'DESC'], true)) {
        $ShortBy = 'ASC';
        $NextShort = 'DESC';
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=max(1, (int) $_POST['page']);
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($id_akses)){
        if(empty($keyword)){
            // Prepared Statement: hitung log pengguna saat tidak ada filter.
            $stmtCount = mysqli_prepare($Conn, "SELECT COUNT(*) AS total FROM log WHERE id_akses=?");
            mysqli_stmt_bind_param($stmtCount, "s", $SessionIdAkses);
        }else{
            // Prepared Statement: hitung log pengguna dengan kata kunci.
            $stmtCount = mysqli_prepare($Conn, "SELECT COUNT(*) AS total FROM log WHERE id_akses=? AND waktu LIKE ? OR nama_log LIKE ? OR kategori LIKE ? OR id_akses LIKE ?");
            $likeKeyword = "%$keyword%";
            mysqli_stmt_bind_param($stmtCount, "sssss", $SessionIdAkses, $likeKeyword, $likeKeyword, $likeKeyword, $likeKeyword);
        }
    }else{
        // Prepared Statement: hitung log untuk akses terpilih.
        $stmtCount = mysqli_prepare($Conn, "SELECT COUNT(*) AS total FROM log WHERE id_akses=?");
        mysqli_stmt_bind_param($stmtCount, "s", $id_akses);
    }
    mysqli_stmt_execute($stmtCount);
    $countResult = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount));
    $jml_data = (int) ($countResult['total'] ?? 0);
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/ProfileUser/TabelLog.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/ProfileUser/TabelLog.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    <?php 
        $JmlHalaman =ceil($jml_data/$batas); 
        $a=1;
        $b=$JmlHalaman;
        for ( $i =$a; $i<=$b; $i++ ){
    ?>
        //ketika klik page number
        $('#PageNumber<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumber<?php echo $i;?>').val();
            var batas=$('#batas').val();
            var keyword=$('#keyword').val();
            $.ajax({
                url     : "_Page/ProfileUser/TabelLog.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#MenampilkanTabelLog').html(data);
                }
            })
        });
    <?php } ?>
</script>

<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="center"><dt>NO</dt></th>
                    <th class="center"><dt>AKTIVITAS</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($id_akses)){
                        if(empty($keyword)){
                            // Prepared Statement: ambil halaman log pengguna.
                            $stmtLogs = mysqli_prepare($Conn, "SELECT * FROM log WHERE id_akses=? ORDER BY $OrderBy $ShortBy LIMIT ?, ?");
                            mysqli_stmt_bind_param($stmtLogs, "sii", $SessionIdAkses, $posisi, $batas);
                        }else{
                            // Prepared Statement: cari dan ambil halaman log pengguna.
                            $stmtLogs = mysqli_prepare($Conn, "SELECT * FROM log WHERE id_akses=? AND waktu LIKE ? OR nama_log LIKE ? OR kategori LIKE ? ORDER BY $OrderBy $ShortBy LIMIT ?, ?");
                            $likeKeyword = "%$keyword%";
                            mysqli_stmt_bind_param($stmtLogs, "ssssii", $SessionIdAkses, $likeKeyword, $likeKeyword, $likeKeyword, $posisi, $batas);
                        }
                    }else{
                        // Prepared Statement: ambil halaman log untuk akses terpilih.
                        $stmtLogs = mysqli_prepare($Conn, "SELECT * FROM log WHERE id_akses=? ORDER BY $OrderBy $ShortBy LIMIT ?, ?");
                        mysqli_stmt_bind_param($stmtLogs, "sii", $id_akses, $posisi, $batas);
                    }
                    mysqli_stmt_execute($stmtLogs);
                    $query = mysqli_stmt_get_result($stmtLogs);
                    while ($data = mysqli_fetch_array($query)) {
                        $id_log= $data['id_log'];
                        $waktu= $data['waktu'];
                        $nama_log= $data['nama_log'];
                        $kategori= $data['kategori'];
                        $id_akses= $data['id_akses'];
                        //Buka data user
                        // Prepared Statement: ambil identitas pemilik log.
                        $stmtUser = mysqli_prepare($Conn, "SELECT * FROM akses WHERE id_akses=?");
                        mysqli_stmt_bind_param($stmtUser, "s", $id_akses);
                        mysqli_stmt_execute($stmtUser);
                        $Qry = mysqli_stmt_get_result($stmtUser);
                        $Data= mysqli_fetch_array($Qry);
                        $id_akses = $Data['id_akses'];
                        $NamaUser = $Data['nama'];
                    ?>
                        <tr>
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt>'.$kategori.'</dt>';
                                    echo ''.$nama_log.'<br>';
                                    echo '<small>'.$waktu.'</small>';
                                ?>
                            </td>
                        </tr>
                <?php
                    $no++; }
                ?>
            </tbody>
        </table>
        
    </div>
</div>
<?php
    //Mengatur Halaman
    $JmlHalaman = ceil($jml_data/$batas); 
    $JmlHalaman_real = ceil($jml_data/$batas); 
    $prev=$page-1;
    $next=$page+1;
    if($next>$JmlHalaman){
        $next=$page;
    }else{
        $next=$page+1;
    }
    if($prev<"1"){
        $prev="1";
    }else{
        $prev=$page-1;
    }
?>
<div class="card-footer text-left">
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage" value="<?php echo $prev;?>">
            <i class="bi bi-chevron-left"></i>
        </button>
        <?php 
            //Navigasi nomor
            if($JmlHalaman>5){
                if($page>=3){
                    $a=$page-2;
                    $b=$page+2;
                    if($JmlHalaman<=$b){
                        $a=$page-2;
                        $b=$JmlHalaman;
                    }
                }else{
                    $a=1;
                    $b=$page+2;
                    if($JmlHalaman<=$b){
                        $a=1;
                        $b=$JmlHalaman;
                    }
                }
            }else{
                $a=1;
                $b=$JmlHalaman;
            }
            for ( $i =$a; $i<=$b; $i++ ){
                if($page=="$i"){
                    echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumber'.$i.'" value="'.$i.'">';
                }else{
                    echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumber'.$i.'" value="'.$i.'">';
                }
                echo ''.$i.'';
                echo '</button>';
            }
        ?>
        <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPage" value="<?php echo $next;?>">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>