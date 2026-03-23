<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //version
    if(!empty($_POST['version'])){
        $version=$_POST['version'];
    }else{
        $version="";
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
        $OrderBy="id_diagnosa";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($version)){
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM diagnosa"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM diagnosa WHERE kode like '%$keyword%' OR long_des like '%$keyword%' OR short_des like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM diagnosa WHERE versi='$version'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM diagnosa WHERE (versi='$version') AND (kode like '%$keyword%' OR long_des like '%$keyword%' OR short_des like '%$keyword%')"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var version="<?php echo "$version"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Diagnosa/TabelDiagnosa.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, version: version, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanDataDiagnosa').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var version="<?php echo "$version"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Diagnosa/TabelDiagnosa.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, version: version, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanDataDiagnosa').html(data);
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
            var keyword="<?php echo "$keyword"; ?>";
            var version="<?php echo "$version"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Diagnosa/TabelDiagnosa.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, version: version, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanDataDiagnosa').html(data);
                }
            })
        });
    <?php } ?>
    //Batas Diubah
    $('#batas').change(function(){
        var BatasPencarianSimrs = $('#BatasPencarianSimrs').serialize();
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        $('#MenampilkanDataDiagnosa').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Diagnosa/TabelDiagnosa.php',
            data 	    :  BatasPencarianSimrs,
            success     : function(data){
                $('#MenampilkanDataDiagnosa').html(data);
            }
        });
    });
    //version Diubah
    $('#version').change(function(){
        var BatasPencarianSimrs = $('#BatasPencarianSimrs').serialize();
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        $('#MenampilkanDataDiagnosa').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Diagnosa/TabelDiagnosa.php',
            data 	    :  BatasPencarianSimrs,
            success     : function(data){
                $('#MenampilkanDataDiagnosa').html(data);
            }
        });
    });
</script>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><dt>NO</dt></th>
                    <th class="text-center"><dt>ICD</dt></th>
                    <th class="text-center"><dt>KODE</dt></th>
                    <th class="text-center"><dt>DESCRIPTION</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="4" class="text-center">';
                        echo '      Data Tidak Ditemukan';
                        echo '  </td>';
                        echo '</tr>';
                    }
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($version)){
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM diagnosa ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM diagnosa WHERE kode like '%$keyword%' OR long_des like '%$keyword%' OR short_des like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM diagnosa WHERE versi='$version' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM diagnosa WHERE (versi='$version') AND(kode like '%$keyword%' OR long_des like '%$keyword%' OR short_des like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_diagnosa= $data['id_diagnosa'];
                        $kode= $data['kode'];
                        $long_des= $data['long_des'];
                        $short_des= $data['short_des'];
                        $versi= $data['versi'];
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailDiagnosa" data-id="<?php echo "$id_diagnosa,$keyword,$batas,$ShortBy,$OrderBy,$page,$version";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left"><?php echo $versi;?></td>
                            <td class="" align="left"><?php echo $kode;?></td>
                            <td class="" align="left">
                                <?php 
                                    echo ''.$short_des.'<br>';
                                    echo '<small>'.$long_des.'</small>';
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
        <a href="javascript:void(0);" class="b-b-primary text-primary">
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
        </a>
    </div>
</div>