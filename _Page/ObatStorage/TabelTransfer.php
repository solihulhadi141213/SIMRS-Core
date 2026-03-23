<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Keyword Transfer
    if(!empty($_POST['KeywordTransfer'])){
        $KeywordTransfer=$_POST['KeywordTransfer'];
    }else{
        $KeywordTransfer="";
    }
    //Keyword By Transfer
    if(!empty($_POST['KeywordByTransfer'])){
        $KeywordByTransfer=$_POST['KeywordByTransfer'];
    }else{
        $KeywordByTransfer="";
    }
    //Batas Transfer
    if(!empty($_POST['BatasTransfer'])){
        $batas=$_POST['BatasTransfer'];
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
    if(empty($KeywordByTransfer)){
        if(empty($KeywordTransfer)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE kode like '%$KeywordTransfer%' OR nama like '%$KeywordTransfer%' OR tanggal like '%$KeywordTransfer%' OR keterangan like '%$KeywordTransfer%'"));
        }
    }else{
        if(empty($KeywordTransfer)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE $KeywordByTransfer like '%$KeywordTransfer%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPageTransfer').click(function() {
        var valueNextTransfer=$('#NextPageTransfer').val();
        var BatasTransfer=$('#BatasTransfer').val();
        var KeywordTransfer=$('#KeywordTransfer').val();
        var KeywordByTransfer=$('#KeywordByTransfer').val();
        $('#TabelTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
        $.ajax({
            url     : "_Page/Obat/TabelTransfer.php",
            method  : "POST",
            data 	:  { page: valueNextTransfer, BatasTransfer: BatasTransfer, KeywordTransfer: KeywordTransfer, KeywordByTransfer: KeywordByTransfer },
            success: function (data) {
                $('#TabelTransfer').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageTransfer').click(function() {
        var ValuePrevTransfer = $('#PrevPageTransfer').val();
        var BatasTransfer=$('#BatasTransfer').val();
        var KeywordTransfer=$('#KeywordTransfer').val();
        var KeywordByTransfer=$('#KeywordByTransfer').val();
        $('#TabelTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
        $.ajax({
            url     : "_Page/Obat/TabelTransfer.php",
            method  : "POST",
            data 	:  { page: ValuePrevTransfer, BatasTransfer: BatasTransfer, KeywordTransfer: KeywordTransfer, KeywordByTransfer: KeywordByTransfer },
            success : function (data) {
                $('#TabelTransfer').html(data);
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
            var PageNumberTransfer = $('#PageNumberTransfer<?php echo $i;?>').val();
            var BatasTransfer=$('#BatasTransfer').val();
            var KeywordTransfer=$('#KeywordTransfer').val();
            var KeywordByTransfer=$('#KeywordByTransfer').val();
            $('#TabelTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                url     : "_Page/Obat/TabelTransfer.php",
                method  : "POST",
                data 	:  { page: PageNumberTransfer, BatasTransfer: BatasTransfer, KeywordTransfer: KeywordTransfer, KeywordByTransfer: KeywordByTransfer },
                success: function (data) {
                    $('#TabelTransfer').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row mb-4">
    <div class="col-md-12">
        <ul class="list-group">
        <?php
            if(empty($jml_data)){
                echo '<li class="list-group-item text-center text-danger">';
                echo '  Tidak ada data obat yang ditampilkan.';
                echo '</li>';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($KeywordByTransfer)){
                    if(empty($KeywordTransfer)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE kode like '%$KeywordTransfer%' OR nama like '%$KeywordTransfer%' OR tanggal like '%$KeywordTransfer%' OR keterangan like '%$KeywordTransfer%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($KeywordTransfer)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE $KeywordByTransfer like '%$KeywordTransfer%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_obat_transfer_alokasi= $data['id_obat_transfer_alokasi'];
                    $id_obat= $data['id_obat'];
                    $kode= $data['kode'];
                    $nama= $data['nama'];
                    $tanggal= $data['tanggal'];
                    $keterangan= $data['keterangan'];
                    $storage_from= $data['storage_from'];
                    $storage_to= $data['storage_to'];
                    $qty= $data['qty'];
                    $nama_petugas= $data['nama_petugas'];
                    //Update timestamp
                    $TanggalTransfer=strtotime($tanggal);
                    $TanggalTransfer=date('d/m/Y H:i T',$TanggalTransfer);
                    //Penyimpanan
                    $AsalPenyimpanan=getDataDetail($Conn,'obat_storage','id_obat_storage',$storage_from,'nama_penyimpanan');
                    $TujuanPenyimpanan=getDataDetail($Conn,'obat_storage','id_obat_storage',$storage_to,'nama_penyimpanan');
                    if(empty($AsalPenyimpanan)){
                        $LabelAsalPenyimpanan='<code class="text-danger">Tidak Ada/Sudah Dihapus</code>';
                    }else{
                        $LabelAsalPenyimpanan='<code class="text-secondary">'.$AsalPenyimpanan.'</code>';
                    }
                    if(empty($TujuanPenyimpanan)){
                        $LabelTujuanPenyimpanan='<code class="text-danger">Tidak Ada/Sudah Dihapus</code>';
                    }else{
                        $LabelTujuanPenyimpanan='<code class="text-secondary">'.$TujuanPenyimpanan.'</code>';
                    }
                    //Satuan
                    $Satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
            ?>
                <li class="list-group-item">
                    <dt>
                        <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailTransfer" data-id="<?php echo "$id_obat_transfer_alokasi"; ?>" title="Nama merek/brand barang">
                            <?php echo "$no. $nama";?>
                        </a>
                    </dt>
                    <ul class="mb-3">
                        <li>Kode : <code class="text-secondary"><?php echo "$kode";?></code></li>
                        <li>Tanggal/Jam : <code class="text-secondary"><?php echo "$TanggalTransfer";?></code></li>
                        <li>Asal : <?php echo "$LabelAsalPenyimpanan";?></li>
                        <li>Tujuan : <?php echo "$LabelTujuanPenyimpanan";?></li>
                        <li>Qty : <code class="text-secondary"><?php echo "$qty $Satuan";?></code></li>
                    </ul>
                    <div class="row">
                        <div class="col-md-12 icon-btn">
                            <button type="button" class="btn btn-icon btn-outline-dark btn-round" data-toggle="modal" data-target="#ModalDetailTransfer" data-id="<?php echo "$id_obat_transfer_alokasi"; ?>" title="Detail Informasi Transfer Barang">
                                <i class="ti ti-info"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-outline-dark btn-round" data-toggle="modal" data-target="#ModalKonfirmasiEditTransfer" data-id="<?php echo "$id_obat_transfer_alokasi"; ?>" title="Ubah Data Transfer Barang">
                                <i class="ti ti-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-round btn-outline-dark" data-toggle="modal" data-target="#ModalHapusTransfer" data-id="<?php echo "$id_obat_transfer_alokasi"; ?>" title="Hapus Data Transfer Barang">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                </li>
        <?php
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
<div class="row">
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