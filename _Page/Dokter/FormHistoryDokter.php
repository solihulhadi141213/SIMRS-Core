<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_dokter
    if(empty($_POST['id_dokter'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Dokter Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        $kode=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kode');
        if(empty($kode)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Dokter Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            //keyword_kunjungan
            if(!empty($_POST['keyword_kunjungan'])){
                $keyword_kunjungan=$_POST['keyword_kunjungan'];
            }else{
                $keyword_kunjungan="";
            }
            //Atur Page
            $batas="10";
            if(!empty($_POST['page_kunjungan'])){
                $page=$_POST['page_kunjungan'];
                $posisi = ( $page - 1 ) * $batas;
            }else{
                $page="1";
                $posisi = 0;
            }
            //Jumlah Kunjungan
            if(empty($_POST['keyword_kunjungan'])){
                $JumlahKunjungan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_dokter='$id_dokter'"));
            }else{
                $JumlahKunjungan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE (id_dokter='$id_dokter') AND (id_kunjungan like '%$keyword_kunjungan%' OR id_pasien like '%$keyword_kunjungan%' OR nama like '%$keyword_kunjungan%')"));
            }
            if(empty($JumlahKunjungan)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center text-danger">';
                echo '      Tidak Ada Riwayat Pelayanan/Kunjungan';
                echo '  </div>';
                echo '</div>';
            }else{
                //Menampilkan Kunjungan
                $no=1+$posisi;
                if(empty($_POST['keyword_kunjungan'])){
                    $QryKunjungan = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_dokter='$id_dokter' ORDER BY id_kunjungan DESC LIMIT $posisi, $batas");
                }else{
                    $QryKunjungan = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE (id_dokter='$id_dokter') AND (id_kunjungan like '%$keyword_kunjungan%' OR id_pasien like '%$keyword_kunjungan%' OR nama like '%$keyword_kunjungan%') ORDER BY id_kunjungan DESC LIMIT $posisi, $batas");
                }
                while ($DataKunjungan = mysqli_fetch_array($QryKunjungan)) {
                    $id_kunjungan= $DataKunjungan['id_kunjungan'];
                    $id_pasien= $DataKunjungan['id_pasien'];
                    $nama= $DataKunjungan['nama'];
                    $tanggal= $DataKunjungan['tanggal'];
                    $tujuan= $DataKunjungan['tujuan'];
                    $status= $DataKunjungan['status'];
                    //Format Tanggal
                    $strtotime=strtotime($tanggal);
                    $TanggalFormat=date('d/m/Y H:i T',$strtotime);
?>
                    <div class="row mb-3 sub-title">
                        <div class="col-md-12">
                            <dt><?php echo "$no. $nama"; ?></dt>
                        </div>
                        <div class="col-md-6">
                            <ul class="ml-3">
                                <li>No.Reg : <code><?php echo $id_kunjungan; ?></code></li>
                                <li>No.RM : <code><?php echo $id_pasien; ?></code></li>
                                <li>Tanggal : <code><?php echo $TanggalFormat; ?></code></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="ml-3">
                                <li>Tujuan : <code><?php echo $tujuan; ?></code></li>
                                <li>Status : <code><?php echo $status; ?></code></li>
                                <li>
                                    <a href="index.php?Page=RawatJalan&Sub=DetailKunjungan&id=<?php echo $id_kunjungan; ?>" target="_blank" class="text-primary">
                                        Lihat Data <i class="ti ti-new-window"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
<?php 
                    $no++;
                }
                 //Mengatur Halaman
                    $JmlHalaman = ceil($JumlahKunjungan/$batas); 
                    $JmlHalaman_real = ceil($JumlahKunjungan/$batas); 
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
<script>
    //ketika klik next
    $('#NextPageKunjungan').click(function() {
        var valueNextKunjungan=$('#NextPageKunjungan').val();
        var keyword_kunjungan="<?php echo "$keyword_kunjungan"; ?>";
        var id_dokter="<?php echo "$id_dokter"; ?>";
        $.ajax({
            url     : '_Page/Dokter/FormHistoryDokter.php',
            method  : "POST",
            data 	:  { page_kunjungan: valueNextKunjungan, keyword_kunjungan: keyword_kunjungan, id_dokter: id_dokter },
            success: function (data) {
                $('#FormHistoryDokter').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageKunjungan').click(function() {
        var PrevPageKunjungan = $('#PrevPageKunjungan').val();
        var keyword_kunjungan="<?php echo "$keyword_kunjungan"; ?>";
        var id_dokter="<?php echo "$id_dokter"; ?>";
        $.ajax({
            url     : '_Page/Dokter/FormHistoryDokter.php',
            method  : "POST",
            data 	:  { page_kunjungan: PrevPageKunjungan, keyword_kunjungan: keyword_kunjungan, id_dokter: id_dokter },
            success : function (data) {
                $('#FormHistoryDokter').html(data);
            }
        })
    });
    <?php 
        $JmlHalaman =ceil($JumlahKunjungan/$batas); 
        $a=1;
        $b=$JmlHalaman;
        for ( $i =$a; $i<=$b; $i++ ){
    ?>
        //ketika klik page number
        $('#PageNumberKunjungan<?php echo $i;?>').click(function() {
            var PageNumberKunjungan = $('#PageNumberKunjungan<?php echo $i;?>').val();
            var keyword_kunjungan="<?php echo "$keyword_kunjungan"; ?>";
            var id_dokter="<?php echo "$id_dokter"; ?>";
            $.ajax({
                url     : '_Page/Dokter/FormHistoryDokter.php',
                method  : "POST",
                data 	:  { page_kunjungan: PageNumberKunjungan, keyword_kunjungan: keyword_kunjungan, id_dokter: id_dokter },
                success: function (data) {
                    $('#FormHistoryDokter').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row mb-3 mt-3">
    <div class="col-md-12 text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPageKunjungan" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-outline-info btn-round" id="PageNumberKunjungan'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumberKunjungan'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPageKunjungan" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</div>
<?php
            }
        }
    } 
?>