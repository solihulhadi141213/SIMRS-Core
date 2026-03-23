<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //id_obat_storage
    if(!empty($_POST['id_obat_storage'])){
        $id_obat_storage=$_POST['id_obat_storage'];
    }else{
        $id_obat_storage="0";
    }
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //Batas 
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="tanggal";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT tanggal FROM obat_so WHERE id_obat_storage='$id_obat_storage'"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT tanggal FROM obat_so WHERE id_obat_storage='$id_obat_storage' AND tanggal='$keyword'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        var id_obat_storage=$('#GetIdPenyimpanan').html();
        $.ajax({
            url     : "_Page/StokOpename/TableSesiStokOpename.php",
            method  : "POST",
            data 	:  { page: valueNext, Batas: Batas, Keyword: Keyword, id_obat_storage: id_obat_storage },
            success: function (data) {
                $('#TableSesiStokOpename').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var Keyword=$('#Keyword').val();
        var id_obat_storage=$('#GetIdPenyimpanan').html();
        $.ajax({
            url     : "_Page/StokOpename/TableSesiStokOpename.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas: batas, keyword: keyword, id_obat_storage: id_obat_storage },
            success : function (data) {
                $('#TableSesiStokOpename').html(data);
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
            var Keyword=$('#Keyword').val();
            var id_obat_storage=$('#GetIdPenyimpanan').html();
            $.ajax({
                url     : "_Page/StokOpename/TableSesiStokOpename.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, id_obat_storage: id_obat_storage },
                success: function (data) {
                    $('#TableSesiStokOpename').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <div class="row mb-4">
        <div class="col-md-12">
            <ul class="list-group">
            <?php
                if(empty($jml_data)){
                    echo '<li class="list-group-item text-center text-danger">';
                    echo '  Tidak ada data sesi stok opename yang ditampilkan.';
                    echo '</li>';
                }else{
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT DISTINCT tanggal FROM obat_so WHERE id_obat_storage='$id_obat_storage' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT DISTINCT tanggal FROM obat_so WHERE id_obat_storage='$id_obat_storage' AND tanggal='$keyword' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $tanggal= $data['tanggal'];
                        $strtotime= strtotime($tanggal);
                        $FormatTanggal= date('d/m/Y',$strtotime);

                ?>
                    <li class="list-group-item">
                        <dt>
                            <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailSesiStokOpename" data-id="<?php echo "$id_obat_storage,$tanggal"; ?>" title="Detail Sesi Stok Opename">
                                <?php echo "$no. $FormatTanggal";?>
                            </a>
                        </dt>
                    </li>
            <?php
                        $no++; 
                    }
                }
            ?>
            </ul>
        </div>
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
<div class="card-footer">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage" value="<?php echo $prev;?>">
                    <i class="ti-angle-left"></i>
                </button>
                <?php 
                    //Navigasi nomor
                    if($JmlHalaman>5){
                        if($page>=5){
                            $a=$page-2;
                            $b=$page+2;
                            if($JmlHalaman<=$b){
                                $a=$page-2;
                                $b=$JmlHalaman;
                            }
                        }else{
                            $a=1;
                            $b=5;
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
    </div>
</div>