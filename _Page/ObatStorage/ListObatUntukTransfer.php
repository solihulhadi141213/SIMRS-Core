<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //keyword
    if(!empty($_POST['KeywordObatUntukTransfer'])){
        $keyword=$_POST['KeywordObatUntukTransfer'];
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
        $OrderBy="nama_obat";
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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat_storage='$id_obat_storage'"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat_storage='$id_obat_storage' AND (kode like '%$keyword%' OR nama_obat like '%$keyword%')"));
    }
?>
<script>
    //ketika klik next
    $('#NextPageTransfer').click(function() {
        var id_obat_storage="<?php echo $id_obat_storage ?>";
        var NextPageTransfer=$('#NextPageTransfer').val();
        var BatasData="<?php echo $batas ?>";
        var KeywordObatUntukTransfer="<?php echo $keyword ?>";
        $.ajax({
            url     : "_Page/ObatStorage/ListObatUntukTransfer.php",
            method  : "POST",
            data 	:  { page: NextPageTransfer, BatasData: BatasData, KeywordObatUntukTransfer: KeywordObatUntukTransfer, id_obat_storage: id_obat_storage },
            success: function (data) {
                $('#ListObatUntukTransfer').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageTransfer').click(function() {
        var id_obat_storage="<?php echo $id_obat_storage ?>";
        var PrevPageTransfer = $('#PrevPageTransfer').val();
        var BatasData="<?php echo $batas ?>";
        var KeywordObatUntukTransfer="<?php echo $keyword ?>";
        $.ajax({
            url     : "_Page/ObatStorage/ListObatUntukTransfer.php",
            method  : "POST",
            data 	:  { page: PrevPageTransfer, BatasData: BatasData, KeywordObatUntukTransfer: KeywordObatUntukTransfer, id_obat_storage: id_obat_storage },
            success : function (data) {
                $('#ListObatUntukTransfer').html(data);
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
            var KeywordObatUntukTransfer="<?php echo $keyword ?>";
            $.ajax({
                url     : "_Page/ObatStorage/ListObatUntukTransfer.php",
                method  : "POST",
                data 	:  { page: PageNumberTransfer, BatasData: BatasData, KeywordObatUntukTransfer: KeywordObatUntukTransfer, id_obat_storage: id_obat_storage },
                success: function (data) {
                    $('#ListObatUntukTransfer').html(data);
                }
            })
        });
    <?php } ?>
    $(".AddObatFormStorage").click(function() {
        var id_obat = $(this).attr('value');
        var nama_obat = $('#GetNamaObat'+id_obat+'').html();
        var satuan = $('#GetSatuan'+id_obat+'').html();
        //Masukan Ke form    
        $('#PutIdObatTransfer').html('<option value="'+id_obat+'">'+nama_obat+'</option>');
        $('#PutSatuanItem').html(satuan);
        $('#ModalPilihObatUntukTransfer').modal('hide');
    });
</script>
<div class="row mb-4">
    <div class="col-md-12">
        <ol>
            <?php
                if(empty($jml_data)){
                    echo '<li class="sub-title text-danger">';
                    echo '  Data Tidak Ada';
                    echo '</li>';
                }else{
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat_storage='$id_obat_storage' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat_storage='$id_obat_storage' AND (kode like '%$keyword%' OR nama_obat like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_obat_posisi= $data['id_obat_posisi'];
                        $id_obat= $data['id_obat'];
                        $kode= $data['kode'];
                        $nama_obat= $data['nama_obat'];
                        $satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
                        echo '<li class="sub-title mb-3">';
                        echo '  <a href="javascript:void(0);" class="AddObatFormStorage" id="GetNamaObat'.$id_obat.'" value="'.$id_obat.'">'.$nama_obat.'</a><br>';
                        echo '  <small class="text-secondary">Kode: '.$kode.'</small><br>';
                        echo '  <small class="text-secondary">Satuan: <span id="GetSatuan'.$id_obat.'">'.$satuan.'</span></small><br>';
                        echo '</li>';
                        $no++;
                    }
                }
            ?>
        </ol>
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
