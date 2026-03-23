<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d');
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="1";
    }
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //keyword_by
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
    }else{
        $keyword_by="";
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
        $OrderBy="id_obat_expired";
    }
    
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if($keyword_by!=="status_expired"){
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE batch like '%$keyword%' OR nama like '%$keyword%' OR satuan like '%$keyword%' OR expired like '%$keyword%' OR ingatkan like '%$keyword%' OR status like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE $keyword_by like '%$keyword%'"));
            }
        }
    }else{
        if($keyword=="Safe"){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE ingatkan>'$now' AND expired>'$now'"));
        }else{
            if($keyword=="Almost"){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE ingatkan<'$now' AND expired>'$now'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE expired<'$now'"));
            }
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        var keyword_by=$('#keyword_by').val();
        $.ajax({
            url     : "_Page/ExpiredLimit/TabelExpiredItem.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#TabelExpiredLimit').html(data);
                $('#GetPutPage').val(valueNext);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        var keyword_by=$('#keyword_by').val();
        $.ajax({
            url     : "_Page/ExpiredLimit/TabelExpiredItem.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#TabelExpiredLimit').html(data);
                $('#GetPutPage').val(ValuePrev);
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
            var keyword_by=$('#keyword_by').val();
            $.ajax({
                url     : "_Page/ExpiredLimit/TabelExpiredItem.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#TabelExpiredLimit').html(data);
                    $('#GetPutPage').val(PageNumber);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <?php
        if(empty($jml_data)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger sub-title">Tidak Ada Data Item Expired</div>';
            echo '</div>';
        }else{
            $no=1+$posisi;
            if($keyword_by!=="status_expired"){
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE batch like '%$keyword%' OR nama like '%$keyword%' OR satuan like '%$keyword%' OR expired like '%$keyword%' OR ingatkan like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
            }else{
                if($keyword=="Safe"){
                    $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE ingatkan>'$now' AND expired>'$now' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    if($keyword=="Almost"){
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE ingatkan<'$now' AND expired>'$now' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE expired<'$now' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
            }
            
            while ($data = mysqli_fetch_array($query)) {
                $id_obat_expired= $data['id_obat_expired'];
                $id_obat= $data['id_obat'];
                $batch= $data['batch'];
                $qty= $data['qty'];
                $satuan= $data['satuan'];
                $expired= $data['expired'];
                $ingatkan= $data['ingatkan'];
                $status= $data['status'];
                $TanggalSekarang=date('Y-m-d');
                if($TanggalSekarang>$expired){
                    $StatusExp='<span class="text-danger"><i class="ti ti-alert"></i> Expired</span>';
                }else{
                    if($ingatkan<$TanggalSekarang){
                        $StatusExp='<span class="text-warning"><i class="ti ti-alert"></i> Almost</span>';
                    }else{
                        $StatusExp='<span class="text-success"><i class="ti ti-calendar"></i> Safe</span>';
                    }
                }
                //Format Tanggal Expired
                $ExpiredFormat=DateFormatDinamis($expired,'d/m/Y');
                $IngatkanFormat=DateFormatDinamis($ingatkan,'d/m/Y');
                //Buka Data Obat
                $NamaObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
                $KodeObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
                $KategoriObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'kategori');
                //Routing Status
                if($status=="Terjual"){
                    $LabelStatus='<span class="text text-warning">Terjual</span>';
                }else{
                    if($status=="Tersedia"){
                        $LabelStatus='<span class="text text-dark">Tersedia</span>';
                    }else{
                        $LabelStatus='<span class="text text-secondary">None</span>';
                    }
                }
    ?>
        <div class="row mt-4 sub-title">
            <div class="col-md-12 mb-2">
                <dt>
                    <?php echo ''.$no.'. '.$NamaObat.'';?>
                </dt>
            </div>
            <div class="col-md-3 mb-2">
                <ul class="ml-3">
                    <li><?php echo '<small>Kode Utama : '.$KodeObat.'</small>';?></li>
                    <li><?php echo '<small>Kode Batch: '.$batch.'</small>';?></li>
                    <li><?php echo '<small>Kategrori: '.$KategoriObat.'</small>';?></li>
                </ul>
            </div>
            <div class="col-md-3 mb-2">
                <ul class="ml-3">
                    <li><?php echo '<small>QTY: '.$qty.' '.$satuan.'</small>';?></li>
                    <li><?php echo '<small>Expired: '.$ExpiredFormat.'</small>';?></li>
                    <li><?php echo '<small>Notifikasi : '.$IngatkanFormat.'</small>';?></li>
                </ul>
            </div>
            <div class="col-md-3 mb-2">
                <ul class="ml-3">
                    <li><?php echo '<small>Ketersediaan : '.$LabelStatus.'</small>';?></li>
                    <li><?php echo '<small>Expired : '.$StatusExp.'</small>';?></li>
                </ul>
            </div>
            <div class="col-md-3 mb-2 icon-btn">
                <div class="ml-3">
                    <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalEditExpiredItem" data-id="<?php echo "$id_obat_expired,$page";?>">
                        <i class="ti ti-pencil-alt"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalHapusExpiredItem" data-id="<?php echo "$id_obat_expired";?>">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php
                $no++;
            }
        }
    ?>
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
<div class="card-footer text-center">
    <div class="btn-group mb-4">
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