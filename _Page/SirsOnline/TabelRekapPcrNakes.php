<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
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
        $OrderBy="id_pcr_nakes";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pcr_nakes"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pcr_nakes WHERE tanggal like '%$keyword%' OR tanggal_laporan like '%$keyword%' OR jumlah like '%$keyword%' OR raw_json like '%$keyword%' OR id_akses like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pcr_nakes"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pcr_nakes WHERE $keyword_by like '%$keyword%'"));
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
        $.ajax({
            url     : "_Page/SirsOnline/TabelPcrNakes.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success: function (data) {
                $('#MenampilkanDataPcrnakes').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        var keyword_by=$('#keyword_by').val();
        $.ajax({
            url     : "_Page/SirsOnline/TabelPcrNakes.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanDataPcrnakes').html(data);
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
            $.ajax({
                url     : "_Page/SirsOnline/TabelPcrNakes.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by },
                success: function (data) {
                    $('#MenampilkanDataPcrnakes').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-block">
    <?php
        if(empty($jml_data)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Belum Ada Data PCR Nakes!';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM pcr_nakes ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM pcr_nakes WHERE tanggal like '%$keyword%' OR tanggal_laporan like '%$keyword%' OR jumlah like '%$keyword%' OR raw_json like '%$keyword%' OR id_akses like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM pcr_nakes ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM pcr_nakes WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_pcr_nakes= $data['id_pcr_nakes'];
                $tanggal= $data['tanggal'];
                $tanggal_laporan= $data['tanggal_laporan'];
                $jumlah= $data['jumlah'];
                $raw_json= $data['raw_json'];
                $status= $data['status'];
                $id_akses= $data['id_akses'];
                //Mendefinisikan id_akses
                $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                //Format Tanggal
                $strtotime1=strtotime($tanggal);
                $strtotime2=strtotime($tanggal_laporan);
                $FormatTanggal1=date('d/m/Y',$strtotime1);
                $FormatTanggal2=date('d/m/Y H:i:s',$strtotime2);
        ?>
        <div class="card mb-2">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <dt>
                            <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailPcrNakes" data-id="<?php echo "$id_pcr_nakes"; ?>">
                                <?php echo "$no. $FormatTanggal1"; ?> <i class="ti ti-new-window"></i>
                            </a>
                        </dt>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6"><small><i class="ti ti-calendar"></i> Periode</small></div>
                    <div class="col-md-6"><small><?php echo $FormatTanggal1;?></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><small><i class="ti ti-calendar"></i> Tgl.Laporan</small></div>
                    <div class="col-md-6"><small><?php echo $FormatTanggal2;?></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><small><i class="ti ti-user"></i> Petugas</small></div>
                    <div class="col-md-6"><small><?php echo $NamaPetugas;?></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><small><i class="ti ti-info"></i> Status</small></div>
                    <div class="col-md-6"><small><?php echo $status;?></small></div>
                </div>
            </div>
            <div class="card-footer">
                <a href="javascript:void(0);" class="btn btn-sm btn-secondary" title="Detail PCR Nakes"  data-toggle="modal" data-target="#ModalDetailPcrNakes" data-id="<?php echo "$id_pcr_nakes"; ?>">
                    <i class="ti ti-info-alt"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-sm btn-secondary" title="Edit PCR Nakes" data-toggle="modal" data-target="#ModalEditPcrNakes" data-id="<?php echo "$id_pcr_nakes"; ?>">
                    <i class="ti ti-pencil"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-sm btn-secondary" title="Hapus PCR Nakes" data-toggle="modal" data-target="#ModalHapusPcrNakes" data-id="<?php echo "$id_pcr_nakes"; ?>">
                    <i class="ti ti-trash"></i>
                </a>
            </div>
        </div>
    <?php
            $no++; }
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