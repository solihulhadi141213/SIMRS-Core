<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Keyword
    if(!empty($_POST['Keyword'])){
        $Keyword=$_POST['Keyword'];
    }else{
        $Keyword="";
    }
    //Keyword By
    if(!empty($_POST['KeywordBy'])){
        $KeywordBy=$_POST['KeywordBy'];
    }else{
        $KeywordBy="";
    }
    //Batas Data
    if(!empty($_POST['BatasData'])){
        $BatasData=$_POST['BatasData'];
    }else{
        $BatasData="10";
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
        $OrderBy="id_laporan_pengguna";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $BatasData;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($KeywordBy)){
        if(empty($Keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE nama like '%$Keyword%' OR tanggal like '%$Keyword%' OR judul like '%$Keyword%' OR laporan like '%$Keyword%' OR response like '%$Keyword%'"));
        }
    }else{
        if(empty($Keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE $KeywordBy like '%$Keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var BatasData=$('#BatasData').val();
        var Keyword=$('#Keyword').val();
        var KeywordBy=$('#KeywordBy').val();
        $('#TabelLaporanPengguna').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
        $.ajax({
            url     : "_Page/LaporanPengguna/TabelLaporanPengguna.php",
            method  : "POST",
            data 	:  { page: valueNext, BatasData: BatasData, Keyword: Keyword, KeywordBy: KeywordBy },
            success: function (data) {
                $('#TabelLaporanPengguna').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var BatasData=$('#BatasData').val();
        var Keyword=$('#Keyword').val();
        var KeywordBy=$('#KeywordBy').val();
        $('#TabelLaporanPengguna').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
        $.ajax({
            url     : "_Page/LaporanPengguna/TabelLaporanPengguna.php",
            method  : "POST",
            data 	:  { page: ValuePrev, BatasData: BatasData, Keyword: Keyword, KeywordBy: KeywordBy },
            success : function (data) {
                $('#TabelLaporanPengguna').html(data);
            }
        })
    });
    <?php 
        $JmlHalaman =ceil($jml_data/$BatasData); 
        $a=1;
        $b=$JmlHalaman;
        for ( $i =$a; $i<=$b; $i++ ){
    ?>
        //ketika klik page number
        $('#PageNumber<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumber<?php echo $i;?>').val();
            var BatasData=$('#BatasData').val();
            var Keyword=$('#Keyword').val();
            var KeywordBy=$('#KeywordBy').val();
            $('#TabelLaporanPengguna').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
            $.ajax({
                url     : "_Page/LaporanPengguna/TabelLaporanPengguna.php",
                method  : "POST",
                data 	:  { page: PageNumber, BatasData: BatasData, Keyword: Keyword, KeywordBy: KeywordBy },
                success: function (data) {
                    $('#TabelLaporanPengguna').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <input type="hidden" name="page" id="page" value="<?php echo $page; ?>">
    <?php
        if(empty($jml_data)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak ada data laporan pengguna yang ditampilkan.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($KeywordBy)){
                if(empty($Keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM laporan_pengguna ORDER BY $OrderBy $ShortBy LIMIT $posisi, $BatasData");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE nama like '%$Keyword%' OR tanggal like '%$Keyword%' OR judul like '%$Keyword%' OR laporan like '%$Keyword%' OR response like '%$Keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $BatasData");
                }
            }else{
                if(empty($Keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM laporan_pengguna ORDER BY $OrderBy $ShortBy LIMIT $posisi, $BatasData");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE $KeywordBy like '%$Keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $BatasData");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_laporan_pengguna= $data['id_laporan_pengguna'];
                $id_akses= $data['id_akses'];
                $nama= $data['nama'];
                $tanggal= $data['tanggal'];
                $judul= $data['judul'];
                $laporan= $data['laporan'];
                $response= $data['response'];
                //Update timestamp
                $Tanggal=strtotime($tanggal);
                $Tanggal=date('d/m/Y H:i T',$Tanggal);
                if(empty($response)){
                    $status='<code class="text-danger">Belum Ada Response</code>';
                }else{
                    $status='<code class="text-success">Sudah Di Response</code>';
                }
        ?>
            <div class="row mb-3 sub-title">
                <div class="col-md-12 mb-3">
                    <dt>
                        <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailLaporanPengguna" data-id="<?php echo "$id_laporan_pengguna"; ?>" title="Detail Laporan Pengguna">
                            <?php echo "$no. $judul";?>
                        </a>
                    </dt>
                </div>
                <div class="col-md-12 mb-3">
                    <ul class="mb-3">
                        <li>Nama Pengirim : <code class="text-secondary"><?php echo "$nama";?></code></li>
                        <li>Tanggal/Jam : <code class="text-secondary"><?php echo "$Tanggal";?></code></li>
                        <li>Status : <?php echo "$status";?></li>
                    </ul>
                </div>
                <div class="col-md-12 mb-3 icon-btn">
                    <button type="button" class="btn btn-icon btn-outline-dark btn-round" data-toggle="modal" data-target="#ModalDetailLaporanPengguna" data-id="<?php echo "$id_laporan_pengguna"; ?>" title="Detail Informasi  Laporan Pengguna">
                        <i class="ti ti-info"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-dark btn-round" data-toggle="modal" data-target="#ModalKirimResponse" data-id="<?php echo "$id_laporan_pengguna"; ?>" title="Kirim Balasan/Response Laporan">
                        <i class="ti ti-email"></i>
                    </button>
                </div>
            </div>
    <?php
                $no++; 
            }
        }
    ?>
</div>
<div class="card-footer">
    <?php
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$BatasData); 
        $JmlHalaman_real = ceil($jml_data/$BatasData); 
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
    </div>
</div>