<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //keyword
    if(!empty($_POST['KeywordObatUntukAlokasi'])){
        $keyword=$_POST['KeywordObatUntukAlokasi'];
    }else{
        $keyword="";
    }
    //id_obat_storage
    if(!empty($_POST['id_obat_storage'])){
        $id_obat_storage=$_POST['id_obat_storage'];
    }else{
        $id_obat_storage="";
    }
    //batas
    if(!empty($_POST['BatasData'])){
        $batas=$_POST['BatasData'];
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
        $NextShort="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="nama";
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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPageAlokasi').click(function() {
        var id_obat_storage="<?php echo $id_obat_storage ?>";
        var NextPageAlokasi=$('#NextPageAlokasi').val();
        var BatasData="<?php echo $batas ?>";
        var KeywordObatUntukAlokasi="<?php echo $keyword ?>";
        $.ajax({
            url     : "_Page/ObatStorage/ListObatUntukAlokasi.php",
            method  : "POST",
            data 	:  { page: NextPageAlokasi, BatasData: BatasData, KeywordObatUntukAlokasi: KeywordObatUntukAlokasi, id_obat_storage: id_obat_storage },
            success: function (data) {
                $('#ListObatUntukAlokasi').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageAlokasi').click(function() {
        var id_obat_storage="<?php echo $id_obat_storage ?>";
        var PrevPageAlokasi = $('#PrevPageAlokasi').val();
        var BatasData="<?php echo $batas ?>";
        var KeywordObatUntukAlokasi="<?php echo $keyword ?>";
        $.ajax({
            url     : "_Page/ObatStorage/ListObatUntukAlokasi.php",
            method  : "POST",
            data 	:  { page: PrevPageAlokasi, BatasData: BatasData, KeywordObatUntukAlokasi: KeywordObatUntukAlokasi, id_obat_storage: id_obat_storage },
            success : function (data) {
                $('#ListObatUntukAlokasi').html(data);
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
        $('#PageNumberAlokasi<?php echo $i;?>').click(function() {
            var id_obat_storage="<?php echo $id_obat_storage ?>";
            var PageNumberAlokasi = $('#PageNumberAlokasi<?php echo $i;?>').val();
            var BatasData="<?php echo $batas ?>";
            var KeywordObatUntukAlokasi="<?php echo $keyword ?>";
            $.ajax({
                url     : "_Page/ObatStorage/ListObatUntukAlokasi.php",
                method  : "POST",
                data 	:  { page: PageNumberAlokasi, BatasData: BatasData, KeywordObatUntukAlokasi: KeywordObatUntukAlokasi, id_obat_storage: id_obat_storage },
                success: function (data) {
                    $('#ListObatUntukAlokasi').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row mb-4">
    <div class="col-md-12 pre-scrollable">
        <ul>
            <?php
                if(empty($jml_data)){
                    echo '<li class="sub-title text-danger">';
                    echo '  Data Tidak Ada';
                    echo '</li>';
                }else{
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_obat= $data['id_obat'];
                        $kode= $data['kode'];
                        $nama_obat= $data['nama'];
                        $kategori= $data['kategori'];
                        $stok= $data['stok'];
                        $satuan= $data['satuan'];
                        $ApakhSudahAda = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat='$id_obat' AND id_obat_storage='$id_obat_storage'"));
                        echo '<li class="sub-title">';
                        echo '  <a href="index.php?Page=ObatStorage&Sub=FormAlokasi&id='.$id_obat_storage.'&id_obat='.$id_obat.'" class="text-primary">'.$no.'. '.$nama_obat.'</a><br>';
                        echo '  <small class="text-secondary">Kode: '.$kode.'</small><br>';
                        echo '  <small class="text-secondary">Stok: '.$stok.' '.$satuan.'</small><br>';
                        echo '</li>';
                        $no++;
                    }
                }
            ?>
        </ul>
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
<div class="row mb-4">
    <div class="col-md-12 text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPageAlokasi" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-info" id="PageNumberAlokasi'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberAlokasi'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPageAlokasi" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</div>
