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
        $OrderBy="loinc_num";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM loinc"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM loinc WHERE loinc_num like '%$keyword%' OR component like '%$keyword%' OR property like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM loinc"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM loinc WHERE $keyword_by like '%$keyword%'"));
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
            $('#TabelLoinc').html('Loading...');
            $.ajax({
                url     : "_Page/Referensi/TabelLoinc.php",
                method  : "POST",
                data 	:  { page: valueNext, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success: function (data) {
                    $('#TabelLoinc').html(data);
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
            $('#TabelLoinc').html('Loading...');
            $.ajax({
                url     : "_Page/Referensi/TabelLoinc.php",
                method  : "POST",
                data 	:  { page: ValuePrev, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success : function (data) {
                    $('#TabelLoinc').html(data);
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
                $('#TabelLoinc').html('Loading...');
                $.ajax({
                    url     : "_Page/Referensi/TabelLoinc.php",
                    method  : "POST",
                    data 	:  { page: PageNumber, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                    success: function (data) {
                        $('#TabelLoinc').html(data);
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
                        <th class="text-center"><dt>NUM</dt></th>
                        <th class="text-center"><dt>COMPONENT</dt></th>
                        <th class="text-center"><dt>PROPERTY</dt></th>
                        <th class="text-center"><dt>SYSTEM</dt></th>
                        <th class="text-center"><dt>SCALE</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="6" class="text-center text-danger">Tidak Ada Data LOINC Yang Ditampilkan</td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword_by)){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM loinc ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM loinc WHERE loinc_num like '%$keyword%' OR component like '%$keyword%' OR property like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM loinc ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM loinc  WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $loinc_num = $data['loinc_num'];
                                $component= $data['component'];
                                $property= $data['property'];
                                $time_aspct= $data['time_aspct'];
                                $system= $data['system'];
                                $scale_typ= $data['scale_typ'];
                                $method_typ= $data['method_typ'];
                    ?>
                            <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailLoinc" data-id="<?php echo $loinc_num;?>" onmousemove="this.style.cursor='pointer'">
                                <td align="center"><?php echo "$no";?></td>
                                <td align="left"><?php echo "$loinc_num";?></td>
                                <td align="left"><?php echo "$component";?></td>
                                <td align="left"><?php echo "$property";?></td>
                                <td align="left"><?php echo "$system";?></td>
                                <td align="left"><?php echo "$scale_typ";?></td>
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