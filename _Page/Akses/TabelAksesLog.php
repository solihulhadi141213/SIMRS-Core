<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['IdAksesLog'])){
        echo 'ID Akses Tidak Boleh Kosong!';
    }else{
        $id_akses=$_POST['IdAksesLog'];
        //keyword_by
        if(!empty($_POST['KeywordByLog'])){
            $keyword_by=$_POST['KeywordByLog'];
        }else{
            $keyword_by="";
        }
        //keyword
        if(!empty($_POST['KeywordLog'])){
            $keyword=$_POST['KeywordLog'];
        }else{
            $keyword="";
        }
        //batas
        if(!empty($_POST['BatasLog'])){
            $batas=$_POST['BatasLog'];
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
            $ShortBy="DESC";
            $NextShort="ASC";
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
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$id_akses'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE (id_akses='$id_akses') AND (waktu like '%$keyword%' OR nama_log like '%$keyword%' OR kategori like '%$keyword%')"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$id_akses'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE (id_akses='$id_akses') AND ($keyword_by like '%$keyword%')"));
            }
        }
?>
    <script>
        //ketika klik next
        $('#NextPage').click(function() {
            var valueNext=$('#NextPage').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var IdAksesLog=$('#IdAksesLog').val();
            $.ajax({
                url     : "_Page/Akses/TabelAksesLog.php",
                method  : "POST",
                data 	:  { page: valueNext, BatasLog: batas, KeywordByLog: keyword_by, KeywordLog: keyword, ShortBy: ShortBy, OrderBy: OrderBy, IdAksesLog: IdAksesLog },
                success: function (data) {
                    $('#MenampilkanLogAkses').html(data);
                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var ValuePrev = $('#PrevPage').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var IdAksesLog=$('#IdAksesLog').val();
            $.ajax({
                url     : "_Page/Akses/TabelAksesLog.php",
                method  : "POST",
                data 	:  { page: ValuePrev, BatasLog: batas, KeywordByLog: keyword_by, KeywordLog: keyword, ShortBy: ShortBy, OrderBy: OrderBy, IdAksesLog: IdAksesLog },
                success : function (data) {
                    $('#MenampilkanLogAkses').html(data);
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
                var batas="<?php echo "$batas"; ?>";
                var keyword="<?php echo "$keyword"; ?>";
                var keyword_by="<?php echo "$keyword_by"; ?>";
                var ShortBy="<?php echo "$ShortBy"; ?>";
                var OrderBy="<?php echo "$OrderBy"; ?>";
                var IdAksesLog=$('#IdAksesLog').val();
                $.ajax({
                    url     : "_Page/Akses/TabelAksesLog.php",
                    method  : "POST",
                    data 	:  { page: PageNumber, BatasLog: batas, KeywordByLog: keyword_by, KeywordLog: keyword, ShortBy: ShortBy, OrderBy: OrderBy, IdAksesLog: IdAksesLog },
                    success: function (data) {
                        $('#MenampilkanLogAkses').html(data);
                    }
                })
            });
        <?php } ?>
    </script>

    <div class="card-block">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center"><dt>NO</dt></th>
                        <th class="text-center"><dt>TANGGAL/WAKTU</dt></th>
                        <th class="text-center"><dt>KATEGORI</dt></th>
                        <th class="text-center"><dt>KETERANGAN</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="4" class="text-center text-danger">Belum Ada Log Akses</td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword_by)){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$id_akses' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM log WHERE (id_akses='$id_akses') AND (waktu like '%$keyword%' OR nama_log like '%$keyword%' OR kategori like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$id_akses' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM log  WHERE (id_akses='$id_akses') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_log= $data['id_log'];
                                $waktu= $data['waktu'];
                                $nama_log= $data['nama_log'];
                                $kategori= $data['kategori'];
                                $id_akses= $data['id_akses'];
                    ?>
                            <tr>
                                <td class="" align="center"><?php echo "$no";?></td>
                                <td class="" align="left"><?php echo "$waktu";?></td>
                                <td class="" align="left"><?php echo "$kategori";?></td>
                                <td class="" align="left"><?php echo "$nama_log";?></td>
                            </tr>
                    <?php
                                $no++; 
                            }
                        }
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
<?php } ?>