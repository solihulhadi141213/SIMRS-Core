<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $TanggalSekarang=date('Y-m-d');
    //id_obat
    if(empty($_POST['id_obat'])){
        echo '<div class="card-body text-center text-danger">ID Obat Tidak Boleh Kosong!</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        //KeywordByExpiredDate
        if(empty($_POST['KeywordByExpiredDate'])){
            $KeywordByExpiredDate="";
        }else{
            $KeywordByExpiredDate=$_POST['KeywordByExpiredDate'];
        }
        //KeywordExpiredDate
        if(empty($_POST['KeywordExpiredDate'])){
            $KeywordExpiredDate="";
        }else{
            $KeywordExpiredDate=$_POST['KeywordExpiredDate'];
        }
        //BatasDataExpired
        if(!empty($_POST['BatasDataExpired'])){
            $batas=$_POST['BatasDataExpired'];
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
            $NextShort="DESC";
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
        if(empty($KeywordByExpiredDate)){
            if(empty($KeywordExpiredDate)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE id_obat='$id_obat'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE id_obat='$id_obat' AND (batch like '%$KeywordExpiredDate%' OR expired like '%$KeywordExpiredDate%' OR ingatkan like '%$KeywordExpiredDate%' OR status like '%$KeywordExpiredDate%')"));
            }
        }else{
            if(empty($KeywordExpiredDate)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE id_obat='$id_obat'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_expired WHERE id_obat='$id_obat' AND $KeywordByExpiredDate like '%$KeywordExpiredDate%'"));
            }
        }
?>
<script>
    //ketika klik next
    $('#NextPageExpired').click(function() {
        var valueNext=$('#NextPageExpired').val();
        var id_obat="<?php echo $id_obat; ?>";
        var BatasDataExpired="<?php echo $batas; ?>";
        var KeywordByExpiredDate="<?php echo $KeywordByExpiredDate; ?>";
        var KeywordExpiredDate="<?php echo $KeywordExpiredDate; ?>";
        $.ajax({
            url     : "_Page/Obat/TabelExpiredDate.php",
            method  : "POST",
            data 	:  { page: valueNext, id_obat: id_obat, BatasDataExpired: BatasDataExpired, KeywordByExpiredDate: KeywordByExpiredDate, KeywordExpiredDate: KeywordExpiredDate },
            success: function (data) {
                $('#TabelExpiredDate').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageExpired').click(function() {
        var ValuePrev = $('#PrevPageExpired').val();
        var id_obat="<?php echo $id_obat; ?>";
        var BatasDataExpired="<?php echo $batas; ?>";
        var KeywordByExpiredDate="<?php echo $KeywordByExpiredDate; ?>";
        var KeywordExpiredDate="<?php echo $KeywordExpiredDate; ?>";
        $.ajax({
            url     : "_Page/Obat/TabelExpiredDate.php",
            method  : "POST",
            data 	:  { page: ValuePrev, id_obat: id_obat, BatasDataExpired: BatasDataExpired, KeywordByExpiredDate: KeywordByExpiredDate, KeywordExpiredDate: KeywordExpiredDate },
            success : function (data) {
                $('#TabelExpiredDate').html(data);
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
        $('#PageNumberExpired<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumberExpired<?php echo $i;?>').val();
            var id_obat="<?php echo $id_obat; ?>";
            var BatasDataExpired="<?php echo $batas; ?>";
            var KeywordByExpiredDate="<?php echo $KeywordByExpiredDate; ?>";
            var KeywordExpiredDate="<?php echo $KeywordExpiredDate; ?>";
            $.ajax({
                url     : "_Page/Obat/TabelExpiredDate.php",
                method  : "POST",
                data 	:  { page: PageNumber, id_obat: id_obat, BatasDataExpired: BatasDataExpired, KeywordByExpiredDate: KeywordByExpiredDate, KeywordExpiredDate: KeywordExpiredDate },
                success: function (data) {
                    $('#TabelExpiredDate').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <ul class="list-group">
        <?php
            if(empty($jml_data)){
                echo '<li class="list-group-item text-danger text-center">';
                echo '  Tidak Ada Data Expired Data';
                echo '</li>';
            }else{
                $no = 1+$posisi;
                if(empty($KeywordByExpiredDate)){
                    if(empty($KeywordExpiredDate)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE id_obat='$id_obat' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE id_obat='$id_obat' AND (batch like '%$KeywordExpiredDate%' OR expired like '%$KeywordExpiredDate%' OR ingatkan like '%$KeywordExpiredDate%' OR status like '%$KeywordExpiredDate%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($KeywordExpiredDate)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE id_obat='$id_obat' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_expired WHERE id_obat='$id_obat' AND $KeywordByExpiredDate like '%$KeywordExpiredDate%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
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
                    $strtotime=strtotime($expired);
                    $strtotime2=strtotime($ingatkan);
                    $Expired=date('d/m/Y',$strtotime);
                    $Ingatkan=date('d/m/Y',$strtotime2);
                    //Routing Status
                    if($status=="Tersedia"){
                        $LabelStatus='<code class="text-success">Tersedia</code>';
                    }else{
                        $LabelStatus='<code class="text-secondary">'.$status.'</code>';
                    }
                    //Routing Batch
                    if(empty($batch)){
                        $LabelBatch='<code class="text-danger">Tidak Ada</code>';
                    }else{
                        $LabelBatch='<code class="text-secondary">'.$batch.'</code>';
                    }

        ?>
            <li class="list-group-item">
                <dt>
                    <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditExpiredDate" data-id="<?php echo "$id_obat_expired"; ?>">
                        <i class="ti ti-calendar"></i> <?php echo "$Expired"; ?>
                    </a>
                </dt>
                <?php echo "Batch: $LabelBatch"; ?><br>
                <small><?php echo "QTY: $qty $satuan ($LabelStatus)"; ?></small>
            </li>
        <?php $no++; }} ?>
    </ul>
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
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPageExpired" value="<?php echo $prev;?>">
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
                    echo '<button type="button" class="btn btn-sm btn-info" id="PageNumberExpired'.$i.'" value="'.$i.'">';
                }else{
                    echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberExpired'.$i.'" value="'.$i.'">';
                }
                echo ''.$i.'';
                echo '</button>';
            }
        ?>
        <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPageExpired" value="<?php echo $next;?>">
            <i class="ti-angle-right"></i>
        </button>
    </div>
</div>
<?php } ?>