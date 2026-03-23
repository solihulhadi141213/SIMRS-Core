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
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
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
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($id_akses)){
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses' AND waktu like '%$keyword%' OR nama_log like '%$keyword%' OR kategori like '%$keyword%' OR id_akses like '%$keyword%'"));
        }
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$id_akses'"));
    }
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
                            $query = mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses' AND waktu like '%$keyword%' OR nama_log like '%$keyword%' OR kategori like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$id_akses' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_log= $data['id_log'];
                        $waktu= $data['waktu'];
                        $nama_log= $data['nama_log'];
                        $kategori= $data['kategori'];
                        $id_akses= $data['id_akses'];
                        //Buka data user
                        $Qry= mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
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
            <i class="ti-angle-left"></i>
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
            <i class="ti-angle-right"></i>
        </button>
    </div>
</div>