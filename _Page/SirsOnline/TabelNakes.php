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
        $OrderBy="id_nakes";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE ihs like '%$keyword%' OR nik like '%$keyword%' OR nama like '%$keyword%' OR referensi_sdm like '%$keyword%' OR kategori like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/SirsOnline/TabelNakes.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success: function (data) {
                $('#MenampilkanTabelSdm').html(data);

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
            url     : "_Page/SirsOnline/TabelNakes.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelSdm').html(data);
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
                url     : "_Page/SirsOnline/TabelNakes.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by },
                success: function (data) {
                    $('#MenampilkanTabelSdm').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-block">
    <div class="row">
        <div class="col-md-10 mb-3"></div>
        <div class="col-md-2 mb-3">
            <button type="button" class="btn btn-md btn-block btn-secondary" data-toggle="modal" data-target="#ModalFilterNakes">
                <i class="ti ti-search"></i> Filter/Cari
            </button>
        </div>
    </div>
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center"><dt>No</dt></th>
                    <th class="text-center"><dt>Nama Nakes</dt></th>
                    <th class="text-center"><dt>Nik & IHS</dt></th>
                    <th class="text-center"><dt>Kategori Nakes</dt></th>
                    <th class="text-center"><dt>Petugas</dt></th>
                    <th class="text-center"><dt>Option</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="6" class="text-center">';
                        echo '      Belum Ada Data Nakes!';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM nakes ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM nakes WHERE ihs like '%$keyword%' OR nik like '%$keyword%' OR nama like '%$keyword%' OR referensi_sdm like '%$keyword%' OR kategori like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM nakes ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM nakes WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_nakes= $data['id_nakes'];
                            $nama= $data['nama'];
                            if(empty($data['ihs'])){
                                $ihs='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $ihs= $data['ihs'];
                                $ihs='<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailIhsNakes" data-id="'.$ihs.'">'.$ihs.'</a>';
                            }
                            if(empty($data['nik'])){
                                $nik='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $nik= $data['nik'];
                                $nik='<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailIhsNakesByNik" data-id="'.$nik.'">'.$nik.'</a>';
                            }
                            if(empty($data['kode'])){
                                $kode='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kode= $data['kode'];
                                $kode='<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailKodeDokter" data-id="'.$kode.'">'.$nik.'</a>';
                            }
                            $kategori= $data['kategori'];
                            $referensi_sdm= $data['referensi_sdm'];
                            $id_akses= $data['id_akses'];
                            //Mendefinisikan id_akses
                            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-left">
                            <?php echo "$nama"; ?><br>
                            <small>(Kode : <?php echo "$kode"; ?>)</small>
                        </td>
                        <td class="text-left">
                            <?php echo "NIK: $nik"; ?><br>
                            <small>
                                (<?php echo "IHS: $ihs"; ?>)
                            </small>
                        </td>
                        <td class="text-left">
                            <?php echo "$kategori"; ?><br>
                            <small title="Referensi SDM">
                                (<?php echo "Referensi SDM : $referensi_sdm"; ?>)
                            </small>
                        </td>
                        <td class="text-left">
                            <?php echo "$NamaPetugas"; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Detail Nakes"  data-toggle="modal" data-target="#ModalDetailNakes" data-id="<?php echo "$id_nakes"; ?>">
                                    <i class="ti ti-info-alt"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Edit Nakes" data-toggle="modal" data-target="#ModalEditnakes" data-id="<?php echo "$id_nakes"; ?>">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Hapus Nakes" data-toggle="modal" data-target="#ModalHapusNakes" data-id="<?php echo "$id_nakes"; ?>">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php
                        $no++; }
                    }
                ?>
            </tbody>
        </table>
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