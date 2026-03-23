<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //id_obat
    if(empty($_POST['id_obat'])){
        echo '<div class="card-body text-center text-danger">ID Obat Tidak Boleh Kosong!</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        //KategoriTransaksi
        if(empty($_POST['KategoriTransaksi'])){
            echo '<div class="card-body text-center text-danger">Kode Transaksi Tidak Boleh Kosong!</div>';
        }else{
            $KategoriTransaksi=$_POST['KategoriTransaksi'];
            //BatasData
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
                $ShortBy="DESC";
                $NextShort="DESC";
            }
            //OrderBy
            if(!empty($_POST['OrderBy'])){
                $OrderBy=$_POST['OrderBy'];
            }else{
                $OrderBy="id_rincian";
            }
            //Atur Page
            if(!empty($_POST['page'])){
                $page=$_POST['page'];
                $posisi = ( $page - 1 ) * $batas;
            }else{
                $page="1";
                $posisi = 0;
            }
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kategori='Obat' AND id_obat_tindakan='$id_obat' AND kode like '%$KategoriTransaksi%'"));
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var id_obat="<?php echo $id_obat; ?>";
        var BatasData="<?php echo $batas; ?>";
        var KategoriTransaksi="<?php echo $KategoriTransaksi; ?>";
        var PeriodeAwal="<?php echo $PeriodeAwal; ?>";
        var PeriodeAkhir="<?php echo $PeriodeAkhir; ?>";
        $.ajax({
            url     : "_Page/Obat/TabelRiwayatTransaksi.php",
            method  : "POST",
            data 	:  { page: valueNext, id_obat: id_obat, BatasData: BatasData, KategoriTransaksi: KategoriTransaksi, PeriodeAwal: PeriodeAwal, PeriodeAkhir: PeriodeAkhir },
            success: function (data) {
                $('#TabelRiwayatTransaksi').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var id_obat="<?php echo $id_obat; ?>";
        var BatasData="<?php echo $batas; ?>";
        var KategoriTransaksi="<?php echo $KategoriTransaksi; ?>";
        var PeriodeAwal="<?php echo $PeriodeAwal; ?>";
        var PeriodeAkhir="<?php echo $PeriodeAkhir; ?>";
        $.ajax({
            url     : "_Page/Obat/TabelRiwayatTransaksi.php",
            method  : "POST",
            data 	:  { page: ValuePrev, id_obat: id_obat, BatasData: BatasData, KategoriTransaksi: KategoriTransaksi, PeriodeAwal: PeriodeAwal, PeriodeAkhir: PeriodeAkhir },
            success : function (data) {
                $('#TabelRiwayatTransaksi').html(data);
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
            var id_obat="<?php echo $id_obat; ?>";
            var BatasData="<?php echo $batas; ?>";
            var KategoriTransaksi="<?php echo $KategoriTransaksi; ?>";
            var PeriodeAwal="<?php echo $PeriodeAwal; ?>";
            var PeriodeAkhir="<?php echo $PeriodeAkhir; ?>";
            $.ajax({
                url     : "_Page/Obat/TabelRiwayatTransaksi.php",
                method  : "POST",
                data 	:  { page: PageNumber, id_obat: id_obat, BatasData: BatasData, KategoriTransaksi: KategoriTransaksi, PeriodeAwal: PeriodeAwal, PeriodeAkhir: PeriodeAkhir },
                success: function (data) {
                    $('#TabelRiwayatTransaksi').html(data);
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
                echo '  Tidak Ada Riwayat Transaksi';
                echo '</li>';
            }else{
                $no = 1+$posisi;
                $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kategori='Obat' AND id_obat_tindakan='$id_obat' AND kode like '%$KategoriTransaksi%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                while ($data = mysqli_fetch_array($query)) {
                    $id_rincian= $data['id_rincian'];
                    $KodeTransaksi= $data['kode'];
                    $qty= $data['qty'];
                    $satuan= $data['satuan'];
                    $harga= $data['harga'];
                    $jumlah= $data['jumlah'];
                    $updatetime= $data['updatetime'];
                    $strtotime2=strtotime($updatetime);
                    $UpdateTime=date('d/m/Y H:i',$strtotime2);
                    //Format Harga
                    $HargaJual = "Rp " . number_format($harga, 0, ',', '.');
                    $TotalTagihan = "Rp " . number_format($jumlah, 0, ',', '.');
        ?>
            <li class="list-group-item">
                <dt>
                    <a href="" class="text-primary"><?php echo "$KodeTransaksi"; ?></a>
                </dt>
                <ul>
                    <li>
                        Rincian : 
                        <code class="text-secondary">
                            <small><?php echo "$HargaJual X $qty $satuan"; ?></small>
                        </code>
                    </li>
                    <li>
                        Jumlah : 
                        <code class="text-secondary">
                            <small><?php echo "$TotalTagihan"; ?></small>
                        </code>
                    </li>
                </ul>
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
<?php }} ?>