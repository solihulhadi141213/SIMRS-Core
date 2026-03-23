<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
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
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
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
        $OrderBy="id_transaksi";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_transaksi like '%$keyword%' OR kode like '%$keyword%' OR transaksi like '%$keyword%' OR tanggal like '%$keyword%' OR nama_akses like '%$keyword%' OR nama_supplier like '%$keyword%' OR id_pasien like '%$keyword%' OR nama_pasien like '%$keyword%' OR id_kunjungan like '%$keyword%' OR nama_dokter like '%$keyword%' OR status like '%$keyword%' OR kunci like '%$keyword%' OR catatan like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/Transaksi/TabelTransaksi.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#TabelTransaksi').html(data);
                $('#page').val(valueNext);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/Transaksi/TabelTransaksi.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#TabelTransaksi').html(data);
                $('#page').val(ValuePrev);
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
            $.ajax({
                url     : "_Page/Transaksi/TabelTransaksi.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#TabelTransaksi').html(data);
                    $('#page').val(PageNumber);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <?php
        if(empty($jml_data)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak ada data transaksi yang ditampilkan.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_transaksi like '%$keyword%' OR kode like '%$keyword%' OR transaksi like '%$keyword%' OR tanggal like '%$keyword%' OR nama_akses like '%$keyword%' OR nama_supplier like '%$keyword%' OR id_pasien like '%$keyword%' OR nama_pasien like '%$keyword%' OR id_kunjungan like '%$keyword%' OR nama_dokter like '%$keyword%' OR status like '%$keyword%' OR kunci like '%$keyword%' OR catatan like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_transaksi= $data['id_transaksi'];
                $kode= $data['kode'];
                $transaksi= $data['transaksi'];
                $tanggal= $data['tanggal'];
                $id_akses= $data['id_akses'];
                $nama_akses= $data['nama_akses'];
                $subtotal= $data['subtotal'];
                $diskon= $data['diskon'];
                $ppn= $data['ppn'];
                $status= $data['status'];
                $kunci= $data['kunci'];
                $updatetime= $data['updatetime'];
                //Format Subtotal
                $SubtotalFormat = "Rp " . number_format($subtotal, 0, ',', '.');
                $DiskonFormat = "Rp " . number_format($diskon, 0, ',', '.');
                $PpnFormat = "Rp " . number_format($ppn, 0, ',', '.');
                //Format Tanggal
                $strtotime=strtotime($tanggal);
                $strtotime2=strtotime($updatetime);
                $TanggalFormat=date('d/m/Y H:i:s T',$strtotime);
                $UpdatetimeFormat=date('d/m/Y H:i:s T',$strtotime2);
                //Routing Transaksi
                if($transaksi=="Pemasukan"){
                    $LabelTransaksi='<span class="text-success">'.$transaksi.'</span>';
                }else{
                    $LabelTransaksi='<span class="text-danger">'.$transaksi.'</span>';
                }
                //Routing Status
                if($status=="Lunas"){
                    $LabelStatus='<span class="text-success">'.$status.'</span>';
                }else{
                    $LabelStatus='<span class="text-danger">'.$status.'</span>';
                }
                //Hitung Ketersediaan Jurnal
                $QryJurnal = "SELECT COUNT(*) as total FROM jurnal WHERE kode='$kode'";
                $HasilHitungJurnal = $Conn->query($QryJurnal);
                // Memeriksa apakah query berhasil dijalankan
                if (!$HasilHitungJurnal) {
                    $JumlahJurnal="0";
                }else{
                    // Mendapatkan jumlah data
                    $BarisJurnal = $HasilHitungJurnal->fetch_assoc();
                    $JumlahJurnal = $BarisJurnal['total'];
                }
                //Hitung Jumlah Rincian
                $QryRincian = "SELECT COUNT(*) as total FROM transaksi_rincian WHERE kode='$kode'";
                $HasilHitungRincian = $Conn->query($QryRincian);
                // Memeriksa apakah query berhasil dijalankan
                if (!$HasilHitungRincian) {
                    $JumlahRincian="0";
                }else{
                    // Mendapatkan jumlah data
                    $BarisRincian = $HasilHitungRincian->fetch_assoc();
                    $JumlahRincian = $BarisRincian['total'];
                }
    ?>
        <div class="row sub-title">
            <div class="col-md-12 mb-2">
                <dt>
                    <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailTransaksi" data-id="<?php echo "$id_transaksi";?>" title="Detail Transaksi">
                        <?php echo ''.$no.'. '.$kode.'';?> <i class="ti ti-new-window"></i>
                    </a>
                </dt>
            </div>
            <div class="col-md-4 mb-2">
                <ul class="ml-3">
                    <li><?php echo 'Tanggal : <span class="text-secondary">'.$TanggalFormat.'</span>';?></li>
                    <li><?php echo 'Update : <span class="text-secondary">'.$UpdatetimeFormat.'</span>';?></li>
                    <li><?php echo 'Kategori: <span>'.$LabelTransaksi.'</span>';?></li>
                    <li><?php echo 'Petugas: <span class="text-secondary">'.$nama_akses.'</span>';?></li>
                    <li>
                        Jurnal : 
                        <a href="javascript:void(0);" class="<?php if(empty($JumlahJurnal)){echo "text-danger";}else{echo "text-primary";} ?>" data-toggle="modal" data-target="#ModalDetailJurnal" data-id="<?php echo "$kode"; ?>">
                            <?php echo "$JumlahJurnal Record"; ?> <i class="icofont-sub-listing"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-5 mb-2 icon-btn">
                <ul class="ml-3">
                    <li>
                        Rincian : 
                        <a href="javascript:void(0);" class="<?php if(empty($JumlahRincian)){echo "text-danger";}else{echo "text-primary";} ?>" data-toggle="modal" data-target="#ModalRincianTransaksi" data-id="<?php echo "$id_transaksi"; ?>">
                            <?php echo "$JumlahRincian Record"; ?> <i class="icofont-sub-listing"></i>
                        </a>
                    </li>
                    <?php
                        if(!empty($data['id_pasien'])){
                            if(!empty($data['nama_pasien'])){
                                $id_pasien= $data['id_pasien'];
                                $nama_pasien= $data['nama_pasien'];
                                echo '<li>';
                                echo '  No.RM/Pasien : ';
                                echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailPasien" data-id="'.$id_pasien.'">';
                                echo '      '.$id_pasien.' <i class="ti ti-info-alt"></i>';
                                echo '  </a>';
                                echo '</li>';
                                echo '<li>';
                                echo '  Nama : <span class="text-secondary">'.$nama_pasien.'</span>';
                                echo '</li>';
                            }
                            if(!empty($data['id_kunjungan'])){
                                $id_kunjungan= $data['id_kunjungan'];
                                echo '<li>';
                                echo '  No.REG : ';
                                echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailKunjungan" data-id="'.$id_kunjungan.'">';
                                echo '      '.$id_kunjungan.' <i class="ti ti-info-alt"></i>';
                                echo '  </a>';
                                echo '</li>';
                            }
                        }
                        if(!empty($data['nama_dokter'])){
                            $nama_dokter= $data['nama_dokter'];
                            echo '<li>';
                            echo '  Dokter : <span class="text-secondary">'.$nama_dokter.'</span>';
                            echo '</li>';
                        }
                        if(!empty($data['id_supplier'])){
                            if(!empty($data['nama_supplier'])){
                                $id_supplier= $data['id_supplier'];
                                $nama_supplier= $data['nama_supplier'];
                                echo '<li>';
                                echo '  Supplier : ';
                                echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailSupplier" data-id="'.$id_supplier.'">';
                                echo '      '.$nama_supplier.' <i class="ti ti-info-alt"></i>';
                                echo '  </a>';
                                echo '</li>';
                            }
                        }
                        if(empty($data['id_pasien'])){
                            if(empty($data['id_kunjungan'])){
                                if(empty($data['nama_dokter'])){
                                    if(empty($data['id_supplier'])){
                                        echo '<li class="text-danger">';
                                        echo '  Tidak ada informasi tambahan lain untuk transaksi ini';
                                        echo '</li>';
                                    }
                                }
                            }
                        }
                    ?>
                </ul>
            </div>
            <div class="col-md-3 mb-2">
                <ul class="ml-3">
                    <li><?php echo 'Kunci: '.$kunci.'';?></li>
                    <li><?php echo 'Status: '.$LabelStatus.'';?></li>
                    <li><?php echo 'Diskon : <span class="text-secondary">'.$DiskonFormat.'</span>';?></li>
                    <li><?php echo 'PPN : <span class="text-secondary">'.$PpnFormat.'</span>';?></li>
                    <li><?php echo 'Subtotal : <span class="text-secondary">'.$SubtotalFormat.'</span>';?></li>
                </ul>
            </div>
            <?php
                if(!empty($data['catatan'])){
                    $catatan=$data['catatan'];
                    echo '<div class="col col-md-12 mb-2">';
                    echo '  <span class="ml-3">Catatan : '.$catatan.'</span>';
                    echo '</div>';
                }
            ?>
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
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPage" value="<?php echo $prev;?>">
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
                    echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumber'.$i.'" value="'.$i.'">';
                }else{
                    echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumber'.$i.'" value="'.$i.'">';
                }
                echo ''.$i.'';
                echo '</button>';
            }
        ?>
        <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPage" value="<?php echo $next;?>">
            <i class="ti-angle-right"></i>
        </button>
    </div>
</div>
