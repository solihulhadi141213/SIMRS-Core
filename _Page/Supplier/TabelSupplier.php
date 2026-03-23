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
    }else{
        $ShortBy="DESC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_supplier";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier WHERE id_supplier like '%$keyword%' OR nama like '%$keyword%' OR alamat like '%$keyword%' OR kontak like '%$keyword%' OR email like '%$keyword%' OR company like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        var keyword_by=$('#keyword_by').val();
        var ShortBy=$('#ShortBy').val();
        var OrderBy=$('#OrderBy').val();
        $.ajax({
            url     : "_Page/Supplier/TabelSupplier.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, ShortBy: ShortBy, OrderBy: OrderBy },
            success: function (data) {
                $('#TabelSupplier').html(data);
                $('#page').val(valueNext);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        var keyword_by=$('#keyword_by').val();
        var ShortBy=$('#ShortBy').val();
        var OrderBy=$('#OrderBy').val();
        $.ajax({
            url     : "_Page/Supplier/TabelSupplier.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas: batas, keyword: keyword, keyword_by: keyword_by, ShortBy: ShortBy, OrderBy: OrderBy },
            success : function (data) {
                $('#TabelSupplier').html(data);
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
            var keyword_by=$('#keyword_by').val();
            var ShortBy=$('#ShortBy').val();
            var OrderBy=$('#OrderBy').val();
            $.ajax({
                url     : "_Page/Supplier/TabelSupplier.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, ShortBy: ShortBy, OrderBy: OrderBy },
                success: function (data) {
                    $('#TabelSupplier').html(data);
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
            echo '      Tidak ada data supplier yang ditampilkan.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM supplier ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM supplier WHERE id_supplier like '%$keyword%' OR nama like '%$keyword%' OR alamat like '%$keyword%' OR kontak like '%$keyword%' OR email like '%$keyword%' OR company like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM supplier ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM supplier WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_supplier= $data['id_supplier'];
                $nama= $data['nama'];
                $alamat= $data['alamat'];
                $kontak= $data['kontak'];
                $email= $data['email'];
                $company= $data['company'];
                //Routing email
                if(empty($data['email'])){
                    $email='<small class="text-danger">Tidak Ada</small>';
                }else{
                    $email='<small class="text-secondary">'.$data['email'].'</small>';
                }
                //Hitung Jumlah Transaksi
                $JumlahTransaksi = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_supplier='$id_supplier'"));
                if(empty($JumlahTransaksi)){
                    $LabelTransaksi='<a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalTransaksiSupplier" data-id="'.$id_supplier.'" title="Lihat Riwayat Transaksi">Tidak Ada <i class="ti ti-info-alt"></i></a>';
                }else{
                    $LabelTransaksi='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalTransaksiSupplier" data-id="'.$id_supplier.'" title="Lihat Riwayat Transaksi">'.$JumlahTransaksi.' Record <i class="ti ti-info-alt"></i></a>';
                }
    ?>
        <div class="row sub-title">
            <div class="col-md-12 mb-2">
                <dt>
                    <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailSupplier" data-id="<?php echo "$id_supplier";?>" title="Detail Supplier">
                        <?php echo ''.$no.'. '.$nama.'';?> <i class="ti ti-new-window"></i>
                    </a>
                </dt>
            </div>
            <div class="col-md-6 mb-2">
                <ul class="ml-3">
                    <li><?php echo 'ID Supplier : <span class="text-secondary">'.$id_supplier.'</span>';?></li>
                    <li><?php echo 'Perusahaan: <span class="text-secondary">'.$company.'</span>';?></li>
                    <li><?php echo 'Alamat : <span class="text-secondary">'.$alamat.'</span>';?></li>
                </ul>
            </div>
            <div class="col-md-4 mb-2">
                <ul class="ml-3">
                    <li><?php echo 'Email: '.$email.'';?></li>
                    <li><?php echo 'Kontak: <span class="text-secondary">'.$kontak.'</span>';?></li>
                    <li><?php echo 'Transaksi: '.$LabelTransaksi.'';?></li>
                </ul>
            </div>
            <div class="col-md-2 mb-2">
                <div class="icon-btn ml-3">
                    <button type="button" class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalEditSupplier" data-id="<?php echo "$id_supplier";?>" title="Edit Supplier">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalHapusSupplier" data-id="<?php echo "$id_supplier";?>" title="Hapus Supplier">
                        <i class="ti ti-close"></i>
                    </button>
                </div>
            </div>
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
