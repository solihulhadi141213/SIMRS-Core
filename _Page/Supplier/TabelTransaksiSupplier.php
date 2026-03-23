<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_supplier'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Supplier Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_supplier=$_POST['id_supplier'];
        $IdSupplier=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'id_supplier');
        if(empty($IdSupplier)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Supplier Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            //keyword
            if(!empty($_POST['keyword'])){
                $keyword=$_POST['keyword'];
            }else{
                $keyword="";
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
            }else{
                $ShortBy="DESC";
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
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_supplier='$id_supplier'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE (id_supplier='$id_supplier') AND (kode like '%$keyword%' OR transaksi like '%$keyword%' OR tanggal like '%$keyword%' OR status like '%$keyword%' OR catatan like '%$keyword%')"));
            }
?>
            <script>
                //ketika klik next
                $('#NextPageTransaksiTransaksi').click(function() {
                    var valueNextTransaksi=$('#NextPageTransaksiTransaksi').val();
                    var keyword=$('#KeywordForTransaksiSupplier').val();
                    var id_supplier=$('#PutIdSupplierForTransaksi').val();
                    $('#TabelTransaksiSupplier').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
                    $.ajax({
                        url     : "_Page/Supplier/TabelTransaksiSupplier.php",
                        method  : "POST",
                        data 	:  { page: valueNextTransaksi, id_supplier: id_supplier, keyword: keyword },
                        success: function (data) {
                            $('#TabelTransaksiSupplier').html(data);
                            $('#PutPageTransaksiSupplier').val(valueNextTransaksi);
                        }
                    })
                });
                //Ketika klik Previous
                $('#PrevPageTransaksi').click(function() {
                    var ValuePrevTransaksi = $('#PrevPageTransaksi').val();
                    var keyword=$('#KeywordForTransaksiSupplier').val();
                    var id_supplier=$('#PutIdSupplierForTransaksi').val();
                    $('#TabelTransaksiSupplier').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
                    $.ajax({
                        url     : "_Page/Supplier/TabelTransaksiSupplier.php",
                        method  : "POST",
                        data 	:  { page: ValuePrevTransaksi, id_supplier: id_supplier, keyword: keyword },
                        success : function (data) {
                            $('#TabelTransaksiSupplier').html(data);
                            $('#PutPageTransaksiSupplier').val(ValuePrevTransaksi);
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
                    $('#PageNumberTransaksi<?php echo $i;?>').click(function() {
                        var PageNumberTransaksi = $('#PageNumberTransaksi<?php echo $i;?>').val();
                        var keyword=$('#KeywordForTransaksiSupplier').val();
                        var id_supplier=$('#PutIdSupplierForTransaksi').val();
                        $('#TabelTransaksiSupplier').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
                        $.ajax({
                            url     : "_Page/Supplier/TabelTransaksiSupplier.php",
                            method  : "POST",
                            data 	:  { page: PageNumberTransaksi, id_supplier: id_supplier, keyword: keyword },
                            success: function (data) {
                                $('#TabelTransaksiSupplier').html(data);
                                $('#PutPageTransaksiSupplier').val(PageNumberTransaksi);
                            }
                        })
                    });
                <?php } ?>
            </script>
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
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_supplier='$id_supplier' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE (id_supplier='$id_supplier') AND (kode like '%$keyword%' OR transaksi like '%$keyword%' OR tanggal like '%$keyword%' OR status like '%$keyword%' OR catatan like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
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
                        $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE kode='$kode'"));
            ?>
                <div class="row sub-title">
                    <div class="col-md-12 mb-2">
                        <dt>
                            <?php echo ''.$no.'. '.$kode.' | '.$LabelTransaksi.'';?>
                        </dt>
                    </div>
                    <div class="col-md-5 mb-2">
                        <ul class="ml-3">
                            <li><?php echo 'Tanggal : <span class="text-secondary">'.$TanggalFormat.'</span>';?></li>
                            <li><?php echo 'Petugas: <span class="text-secondary">'.$nama_akses.'</span>';?></li>
                            <li><?php echo 'Status: '.$LabelStatus.'';?></li>
                        </ul>
                    </div>
                    <div class="col-md-5 mb-2">
                        <ul class="ml-3">
                            <li><?php echo 'Diskon : <span class="text-secondary">'.$DiskonFormat.'</span>';?></li>
                            <li><?php echo 'PPN : <span class="text-secondary">'.$PpnFormat.'</span>';?></li>
                            <li><?php echo 'Subtotal : <span class="text-secondary">'.$SubtotalFormat.'</span>';?></li>
                        </ul>
                    </div>
                    <div class="col-2 mb-2">
                        <a href="index.php?Page=Transaksi&Sub=DetailTransaksi&id=<?php echo "$id_transaksi"; ?>" target="_blank" class="text-primary">
                            Lihat <i class="ti ti-new-window"></i>
                        </a>
                    </div>
                </div>
            <?php
                        $no++; 
                    }
                }
            ?>
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
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPageTransaksi" value="<?php echo $prev;?>">
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
                                    echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumberTransaksi'.$i.'" value="'.$i.'">';
                                }else{
                                    echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumberTransaksi'.$i.'" value="'.$i.'">';
                                }
                                echo ''.$i.'';
                                echo '</button>';
                            }
                        ?>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPageTransaksi" value="<?php echo $next;?>">
                            <i class="ti-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
<?php 
        }
    }
?>