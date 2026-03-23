<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //keyword
    if(!empty($_POST['KeywordHistoriTransfer'])){
        $keyword=$_POST['KeywordHistoriTransfer'];
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
    }else{
        $ShortBy="DESC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_obat_transfer_alokasi";
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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_from='$id_obat_storage' OR storage_to='$id_obat_storage'"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE (storage_from='$id_obat_storage' OR storage_to='$id_obat_storage') AND (kode like '%$keyword%' OR nama like '%$keyword%')"));
    }
?>
<script>
    //ketika klik next
    $('#NextPageTransfer').click(function() {
        var id_obat_storage="<?php echo $id_obat_storage ?>";
        var NextPageTransfer=$('#NextPageTransfer').val();
        var BatasData="<?php echo $batas ?>";
        var KeywordHistoriTransfer="<?php echo $keyword ?>";
        $.ajax({
            url     : "_Page/ObatStorage/ListHistoriTransfer.php",
            method  : "POST",
            data 	:  { page: NextPageTransfer, BatasData: BatasData, KeywordHistoriTransfer: KeywordHistoriTransfer, id_obat_storage: id_obat_storage },
            success: function (data) {
                $('#ListHistoriTransfer').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageTransfer').click(function() {
        var id_obat_storage="<?php echo $id_obat_storage ?>";
        var PrevPageTransfer = $('#PrevPageTransfer').val();
        var BatasData="<?php echo $batas ?>";
        var KeywordHistoriTransfer="<?php echo $keyword ?>";
        $.ajax({
            url     : "_Page/ObatStorage/ListHistoriTransfer.php",
            method  : "POST",
            data 	:  { page: PrevPageTransfer, BatasData: BatasData, KeywordHistoriTransfer: KeywordHistoriTransfer, id_obat_storage: id_obat_storage },
            success : function (data) {
                $('#ListHistoriTransfer').html(data);
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
        $('#PageNumberTransfer<?php echo $i;?>').click(function() {
            var id_obat_storage="<?php echo $id_obat_storage ?>";
            var PageNumberTransfer = $('#PageNumberTransfer<?php echo $i;?>').val();
            var BatasData="<?php echo $batas ?>";
            var KeywordHistoriTransfer="<?php echo $keyword ?>";
            $.ajax({
                url     : "_Page/ObatStorage/ListHistoriTransfer.php",
                method  : "POST",
                data 	:  { page: PageNumberTransfer, BatasData: BatasData, KeywordHistoriTransfer: KeywordHistoriTransfer, id_obat_storage: id_obat_storage },
                success: function (data) {
                    $('#ListHistoriTransfer').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row mb-4">
    <div class="col-md-12">
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
                        $query = mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE (storage_from='$id_obat_storage' OR storage_to='$id_obat_storage') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE (storage_from='$id_obat_storage' OR storage_to='$id_obat_storage') AND (kode like '%$keyword%' OR nama like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_obat_transfer_alokasi= $data['id_obat_transfer_alokasi'];
                        $id_obat= $data['id_obat'];
                        $id_akses= $data['id_akses'];
                        $kode= $data['kode'];
                        $nama_obat= $data['nama'];
                        $tanggal= $data['tanggal'];
                        $keterangan= $data['keterangan'];
                        $storage_from= $data['storage_from'];
                        $storage_to= $data['storage_to'];
                        $qty= $data['qty'];
                        $nama_petugas= $data['nama_petugas'];
                        //Format Tanggal
                        $strtotime=strtotime($tanggal);
                        $FormatTanggal=date('d/m/Y H:i T',$strtotime);
                        //Routing jenis transfer
                        if($id_obat_storage==$storage_from){
                            $JenisTransfer="Transfer Keluar";
                        }else{
                            $JenisTransfer="Transfer Masuk";
                        }
                        echo '<li class="sub-title">';
                        echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailTransfer" data-id="'.$id_obat_transfer_alokasi.'">'.$no.'. '.$nama_obat.'</a><br>';
                        echo '  <small class="text-secondary">Kode: '.$kode.'</small><br>';
                        echo '  <small class="text-secondary">Tanggal: '.$FormatTanggal.'</small><br>';
                        echo '  <small class="text-secondary">Kategori: '.$JenisTransfer.'</small><br>';
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
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPageTransfer" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-info" id="PageNumberTransfer'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberTransfer'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPageTransfer" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</div>
