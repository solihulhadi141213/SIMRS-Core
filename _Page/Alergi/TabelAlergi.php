<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword_by
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
    }else{
        $keyword_by="";
    }
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
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
    }else{
        $ShortBy="DESC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_referensi_alergi";
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
            // Query untuk menghitung jumlah baris pada tabel
            $sql = "SELECT COUNT(*) AS jumlah FROM referensi_alergi";
            $result = $Conn->query($sql);
            $row = $result->fetch_assoc();
            $jml_data=$row["jumlah"];
        }else{
            // Query untuk menghitung jumlah baris pada tabel
            $sql = "SELECT COUNT(*) AS jumlah FROM referensi_alergi WHERE code like '%$keyword%' OR display like '%$keyword%' OR display like '%$keyword%'";
            $result = $Conn->query($sql);
            $row = $result->fetch_assoc();
            $jml_data=$row["jumlah"];
        }
    }else{
        if(empty($keyword)){
            // Query untuk menghitung jumlah baris pada tabel
            $sql = "SELECT COUNT(*) AS jumlah FROM referensi_alergi";
            $result = $Conn->query($sql);
            $row = $result->fetch_assoc();
            $jml_data=$row["jumlah"];
        }else{
            // Query untuk menghitung jumlah baris pada tabel
            $sql = "SELECT COUNT(*) AS jumlah FROM referensi_alergi WHERE $keyword_by like '%$keyword%'";
            $result = $Conn->query($sql);
            $row = $result->fetch_assoc();
            $jml_data=$row["jumlah"];
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
            $('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
            $.ajax({
                url     : "_Page/Alergi/TabelAlergi.php",
                method  : "POST",
                data 	:  { page: valueNext, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success: function (data) {
                    $('#TabelAlergi').html(data);
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
            $('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
            $.ajax({
                url     : "_Page/Alergi/TabelAlergi.php",
                method  : "POST",
                data 	:  { page: ValuePrev, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success : function (data) {
                    $('#TabelAlergi').html(data);
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
                $('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                $.ajax({
                    url     : "_Page/Alergi/TabelAlergi.php",
                    method  : "POST",
                    data 	:  { page: PageNumber, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                    success: function (data) {
                        $('#TabelAlergi').html(data);
                    }
                })
            });
        <?php } ?>
    </script>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center"><dt>NO</dt></th>
                        <th class="text-center"><dt>Code</dt></th>
                        <th class="text-center"><dt>Display</dt></th>
                        <th class="text-center"><dt>Code System</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="44" class="text-center text-danger">Tidak Ada Data Referensi Alergi Yang Ditampilkan</td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword_by)){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_alergi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_alergi WHERE code like '%$keyword%' OR display like '%$keyword%' OR display like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_alergi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_alergi  WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_referensi_alergi = $data['id_referensi_alergi'];
                                $code= $data['code'];
                                $display= $data['display'];
                                $sumber= $data['sumber'];
                    ?>
                            <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailAlergi" data-id="<?php echo $id_referensi_alergi;?>" onmousemove="this.style.cursor='pointer'">
                                <td align="center"><?php echo "$no";?></td>
                                <td align="left"><?php echo "$code";?></td>
                                <td align="left"><?php echo "$display";?></td>
                                <td align="left"><?php echo "$sumber";?></td>
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
<div class="card-footer text-center mb-3">
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
                    echo '<button type="button" class="btn btn-sm btn-info" id="PageNumber'.$i.'" value="'.$i.'">';
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