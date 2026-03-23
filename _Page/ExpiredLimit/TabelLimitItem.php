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
        $OrderBy="id_obat";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE stok<stok_min"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE (stok<stok_min) AND (kode like '%$keyword%' OR nama like '%$keyword%' OR satuan like '%$keyword%' OR kelompok like '%$keyword%' OR kategori like '%$keyword%' OR tanggal like '%$keyword%')"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE stok<stok_min"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE stok<stok_min AND ($keyword_by like '%$keyword%')"));
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
            url     : "_Page/ExpiredLimit/TabelLimitItem.php",
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
            url     : "_Page/ExpiredLimit/TabelLimitItem.php",
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
                url     : "_Page/ExpiredLimit/TabelLimitItem.php",
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
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE stok<stok_min ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE (stok<stok_min) AND (kode like '%$keyword%' OR nama like '%$keyword%' OR satuan like '%$keyword%' OR kelompok like '%$keyword%' OR kategori like '%$keyword%' OR tanggal like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE stok<stok_min ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE (stok<stok_min) AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_obat= $data['id_obat'];
                $kode= $data['kode'];
                $nama_obat= $data['nama'];
                $kelompok= $data['kelompok'];
                $kategori= $data['kategori'];
                $satuan= $data['satuan'];
                $stok= $data['stok'];
                $isi= $data['isi'];
                $harga= $data['harga'];
                $stok_min= $data['stok_min'];
                $tanggal= $data['tanggal'];
                $updatetime= $data['updatetime'];
                //Update timestamp
                $strtotime1=strtotime($tanggal);
                $strtotime2=strtotime($updatetime);
                $TanggalInput=date('d/m/Y H:i',$strtotime1);
                $UpdateTime=date('d/m/Y H:i',$strtotime2);
                //Format Harga
                $HargaBeli = "Rp " . number_format($harga, 0, ',', '.');
    ?>
        <div class="row mt-4 sub-title">
            <div class="col-md-12 mb-2">
                <dt>
                    <?php echo ''.$no.'. '.$nama_obat.'';?>
                </dt>
            </div>
            <div class="col-md-3 mb-2">
                <ul class="ml-3">
                    <li><?php echo '<small>Kode : '.$kode.'</small>';?></li>
                    <li><?php echo '<small>Kelompok: '.$kelompok.'</small>';?></li>
                    <li><?php echo '<small>Kategrori: '.$kategori.'</small>';?></li>
                </ul>
            </div>
            <div class="col-md-3 mb-2">
                <ul class="ml-3">
                    <li><?php echo '<small>Stok: '.$stok.' '.$satuan.'</small>';?></li>
                    <li><?php echo '<small>Min Stok: '.$stok_min.' '.$satuan.'</small>';?></li>
                    <li><?php echo '<small>Harga : '.$HargaBeli.'</small>';?></li>
                </ul>
            </div>
            <div class="col-md-3 mb-2">
                <ul class="ml-3">
                    <li><?php echo '<small>Input : '.$TanggalInput.'</small>';?></li>
                    <li><?php echo '<small>Update : '.$UpdateTime.'</small>';?></li>
                </ul>
            </div>
            <div class="col-md-3 mb-2">
                <div class="ml-3">
                    <button type="button" class="btn btn-round btn-outline-dark" data-toggle="modal" data-target="#ModalDetailObat" data-id="<?php echo "$id_obat";?>">
                        <i class="ti ti-info-alt"></i> Detail
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