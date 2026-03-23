<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword_by
    if(empty($_POST['keyword_by'])){
        echo '<div class="card-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          <h3>Data Terlalu Besar</h3> Harap Isi Data Pencarian Spesifik Terlebih Dulu';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $keyword_by=$_POST['keyword_by'];
         //keyword
        if(empty($_POST['keyword'])){
            echo '<div class="card-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          <h3>Data Terlalu Besar</h3> Harap Isi Kata Kunci Pencarian Spesifik Terlebih Dulu';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $keyword=$_POST['keyword'];
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
                $OrderBy="conceptId";
            }
            //Atur Page
            if(!empty($_POST['page'])){
                $page=$_POST['page'];
                $posisi = ( $page - 1 ) * $batas;
            }else{
                $page="1";
                $posisi = 0;
            }
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM snomed WHERE $keyword_by like '%$keyword%'"));
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
            $('#TabelSnomed').html('Loading...');
            $.ajax({
                url     : "_Page/Referensi/TabelSnomed.php",
                method  : "POST",
                data 	:  { page: valueNext, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success: function (data) {
                    $('#TabelSnomed').html(data);
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
            $('#TabelSnomed').html('Loading...');
            $.ajax({
                url     : "_Page/Referensi/TabelSnomed.php",
                method  : "POST",
                data 	:  { page: ValuePrev, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success : function (data) {
                    $('#TabelSnomed').html(data);
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
                $('#TabelSnomed').html('Loading...');
                $.ajax({
                    url     : "_Page/Referensi/TabelSnomed.php",
                    method  : "POST",
                    data 	:  { page: PageNumber, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                    success: function (data) {
                        $('#TabelSnomed').html(data);
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
                        <th class="text-center"><dt>CONCEPT ID</dt></th>
                        <th class="text-center"><dt>LANGUAGE</dt></th>
                        <th class="text-center"><dt>TERM</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="4" class="text-center text-danger">Tidak Ada Data SNOMED Yang Ditampilkan</td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            $query = mysqli_query($Conn, "SELECT*FROM snomed  WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_snomed = $data['id_snomed'];
                                $active= $data['active'];
                                $conceptId= $data['conceptId'];
                                $languageCode= $data['languageCode'];
                                $term= $data['term'];
                    ?>
                            <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailSnomed" data-id="<?php echo $conceptId;?>" onmousemove="this.style.cursor='pointer'">
                                <td align="center"><?php echo "$no";?></td>
                                <td align="left"><?php echo "$conceptId";?></td>
                                <td align="left"><?php echo "$languageCode";?></td>
                                <td align="left"><?php echo "$term";?></td>
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
<?php }} ?>