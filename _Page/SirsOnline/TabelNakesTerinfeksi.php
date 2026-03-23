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
        $OrderBy="id_nakes_terinfeksi";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE id_pasien like '%$keyword%' OR id_kunjungan like '%$keyword%' OR id_nakes_pcr like '%$keyword%' OR nama like '%$keyword%' OR tanggal like '%$keyword%' OR kategori like '%$keyword%' OR status like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/SirsOnline/TabelNakesTerinfeksi.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success: function (data) {
                $('#MenampilkanTabelNakesTerinfeksi').html(data);

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
            url     : "_Page/SirsOnline/TabelNakesTerinfeksi.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelNakesTerinfeksi').html(data);
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
                url     : "_Page/SirsOnline/TabelNakesTerinfeksi.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by },
                success: function (data) {
                    $('#MenampilkanTabelNakesTerinfeksi').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-block">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center"><dt>No</dt></th>
                    <th class="text-center"><dt>Tgl</dt></th>
                    <th class="text-center"><dt>Nama Nakes</dt></th>
                    <th class="text-center"><dt>Status</dt></th>
                    <th class="text-center"><dt>Option</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="5" class="text-center">';
                        echo '      Belum Ada Data Nakes Terinfeksi!';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE id_pasien like '%$keyword%' OR id_kunjungan like '%$keyword%' OR id_nakes_pcr like '%$keyword%' OR nama like '%$keyword%' OR tanggal like '%$keyword%' OR kategori like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_nakes_terinfeksi= $data['id_nakes_terinfeksi'];
                            if(empty($data['id_nakes_pcr'])){
                                $id_nakes_pcr='<span class="text-danger">None</span>';
                            }else{
                                $id_nakes_pcr= $data['id_nakes_pcr'];
                                $id_nakes_pcr='<a href="javascript:voi(0);" class="text-info">'.$id_nakes_pcr.'</a>';
                            }
                            $nama= $data['nama'];
                            $tanggal= $data['tanggal'];
                            $kategori= $data['kategori'];
                            $status= $data['status'];
                            $id_akses= $data['id_akses'];
                            //Mendefinisikan id_akses
                            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                            //Format Tanggal
                            $strtotime1=strtotime($tanggal);
                            $FormatTanggal1=date('d/m/Y',$strtotime1);
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-left">
                            <i class="ti ti-calendar"></i> <?php echo "$FormatTanggal1"; ?><br>
                            <small>
                                ID.PCR: <?php echo "$id_nakes_pcr"; ?>
                            </small>
                        </td>
                        <td class="text-left">
                            <i class="icofont-doctor-alt"></i> <?php echo "$nama"; ?><br>
                            <small title="Kategori Nakes">
                                <i class="ti ti-tag"></i> <?php echo "$kategori"; ?>
                            </small>
                        </td>
                        <td class="text-left">
                            <?php
                                if($status=="Meninggal"){
                                    echo '<span class="text-danger">Meninggal</span>';
                                }else{
                                    if($hasil_pcr=="Dirawat"){
                                        echo '<span class="text-warning">Dirawat</span>';
                                    }else{
                                        if($hasil_pcr=="Isoman"){
                                            echo '<span class="text-success">Isoman</span>';
                                        }else{
                                            echo '<span class="text-info">Sembuh</span>';
                                        }
                                    }
                                }
                            ?><br>
                            <small title="Nama Petugas">
                                <i class="ti ti-user"></i> <?php echo "$NamaPetugas"; ?>
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Detail PCR Nakes"  data-toggle="modal" data-target="#ModalDetailNakesTerinfeksi" data-id="<?php echo "$id_nakes_terinfeksi"; ?>">
                                    <i class="ti ti-info-alt"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Edit PCR Nakes" data-toggle="modal" data-target="#ModalEditNakesTerinfeksi" data-id="<?php echo "$id_nakes_terinfeksi"; ?>">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Hapus PCR Nakes" data-toggle="modal" data-target="#ModalHapusNakesTerinfeksi" data-id="<?php echo "$id_nakes_terinfeksi"; ?>">
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