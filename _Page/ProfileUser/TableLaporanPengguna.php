<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $batas=10;
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE id_akses='$SessionIdAkses'"));
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        $.ajax({
            url     : "_Page/ProfileUser/TableLaporanPengguna.php",
            method  : "POST",
            data 	:  { page: valueNext },
            success: function (data) {
                $('#TableLaporanPengguna').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        $.ajax({
            url     : "_Page/ProfileUser/TableLaporanPengguna.php",
            method  : "POST",
            data 	:  { page: ValuePrev },
            success : function (data) {
                $('#TableLaporanPengguna').html(data);
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
            $.ajax({
                url     : "_Page/ProfileUser/TableLaporanPengguna.php",
                method  : "POST",
                data 	:  { page: PageNumber },
                success: function (data) {
                    $('#TableLaporanPengguna').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row mb-3">
    <?php
        if(empty($jml_data)){
            echo '<div class="col-md-12 text-center text-danger">';
            echo '  Tidak Ada Data Laporan Pengguna!';
            echo '</div>';
        }else{
            $no = 1;
            //KONDISI PENGATURAN MASING FILTER
            $QryLaporan = mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE id_akses='$SessionIdAkses' ORDER BY id_laporan_pengguna DESC LIMIT $posisi, $batas");
            while ($DataLaporan = mysqli_fetch_array($QryLaporan)) {
                $id_laporan_pengguna= $DataLaporan['id_laporan_pengguna'];
                $nama= $DataLaporan['nama'];
                $tanggal= $DataLaporan['tanggal'];
                $judul= $DataLaporan['judul'];
                $laporan= $DataLaporan['laporan'];
                $response= $DataLaporan['response'];
        ?>
            <div class="col-md-12 mb-4" tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailLaporanPengguna" data-id="<?php echo "$id_laporan_pengguna";?>" onmousemove="this.style.cursor='pointer'">
                <dt><?php echo "$nama";?></dt>
                <?php echo "$judul";?><br>
                <small><?php echo "$tanggal";?></small>
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
<div class="row">
    <div class="col col-md-12">
        <div class="btn-group">
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
</div>