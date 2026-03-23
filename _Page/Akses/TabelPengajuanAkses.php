<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['keyword_pengajuan'])){
        $keyword=$_POST['keyword_pengajuan'];
    }else{
        $keyword="";
    }
    //keyword_by
    if(!empty($_POST['keyword_by_pengajuan'])){
        $keyword_by=$_POST['keyword_by_pengajuan'];
    }else{
        $keyword_by="";
    }
    //batas
    if(!empty($_POST['batas_pengajuan'])){
        $batas=$_POST['batas_pengajuan'];
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
        $ShortBy="ASC";
        $NextShort="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_akses_pengajuan";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_pengajuan"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_pengajuan WHERE tanggal like '%$keyword%' OR nik like '%$keyword%' OR nama like '%$keyword%' OR kontak like '%$keyword%' OR email like '%$keyword%' OR status like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_pengajuan"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_pengajuan WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas_pengajuan').val();
        var keyword=$('#keyword_pengajuan').val();
        var keyword_by=$('#keyword_by_pengajuan').val();
        $.ajax({
            url     : "_Page/Akses/TabelPengajuanAkses.php",
            method  : "POST",
            data 	:  { page: valueNext, batas_pengajuan: batas, keyword_pengajuan: keyword, keyword_by_pengajuan: keyword_by },
            success: function (data) {
                $('#MenampilkanTabelPengajuan').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas_pengajuan').val();
        var keyword=$('#keyword_pengajuan').val();
        var keyword_by=$('#keyword_by_pengajuan').val();
        $.ajax({
            url     : "_Page/Akses/TabelPengajuanAkses.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas_pengajuan: batas, keyword_pengajuan: keyword, keyword_by_pengajuan: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPengajuan').html(data);
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
            var batas=$('#batas_pengajuan').val();
            var keyword=$('#keyword_pengajuan').val();
            var keyword_by=$('#keyword_by_pengajuan').val();
            $.ajax({
                url     : "_Page/Akses/TabelPengajuanAkses.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas_pengajuan: batas, keyword_pengajuan: keyword, keyword_by_pengajuan: keyword_by },
                success: function (data) {
                    $('#MenampilkanTabelPengajuan').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><dt>NO</dt></th>
                    <th class="text-center"><dt>TANGGAL</dt></th>
                    <th class="text-center"><dt>NAMA</dt></th>
                    <th class="text-center"><dt>NIK</dt></th>
                    <th class="text-center"><dt>KONTAK</dt></th>
                    <th class="text-center"><dt>EMAIL</dt></th>
                    <th class="text-center"><dt>STATUS</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="7" class="text-center">';
                        echo '      Belum Ada Data Pengajuan Akses';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses_pengajuan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses_pengajuan WHERE tanggal like '%$keyword%' OR nik like '%$keyword%' OR nama like '%$keyword%' OR kontak like '%$keyword%' OR email like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses_pengajuan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses_pengajuan WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_akses_pengajuan= $data['id_akses_pengajuan'];
                            $tanggal= $data['tanggal'];
                            $nik= $data['nik'];
                            $nama= $data['nama'];
                            $kontak= $data['kontak'];
                            $email= $data['email'];
                            $alamat= $data['alamat'];
                            $deskripsi= $data['deskripsi'];
                            $foto= $data['foto'];
                            $status= $data['status'];
                            $keterangan= $data['keterangan'];
                            //Format Tanggal
                            $strtotime=strtotime($tanggal);
                            $TanggalFormat=date('d/m/Y H:i T', $strtotime);
                            //Label Status
                            if($status=="Pending"){
                                $LabelStatus='<span class="badge badge-danger"><i class="ti ti-time"></i> Pending</span>';
                            }else{
                                if($status=="Ditolak"){
                                    $LabelStatus='<span class="badge badge-inverse"><i class="ti ti-close"></i> Ditolak</span>';
                                }else{
                                    if($status=="Diterima"){
                                        $LabelStatus='<span class="badge badge-success"><i class="ti ti-check"></i> Diterima</span>';
                                    }else{
                                        $LabelStatus='<span class="badge badge-secondary"><i class="ti ti-close"></i> None</span>';
                                    }
                                }
                            }
                ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailPengajuanAkses" data-id="<?php echo "$id_akses_pengajuan,$keyword_by,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo $no;?></td>
                            <td class="" align="left"><?php echo $TanggalFormat;?></td>
                            <td class="" align="left"><?php echo $nama;?></td>
                            <td class="" align="left"><?php echo $nik;?></td>
                            <td class="" align="left"><?php echo $kontak;?></td>
                            <td class="" align="left"><?php echo $email;?></td>
                            <td class="" align="center"><?php echo $LabelStatus;?></td>
                        </tr>
                <?php
                            $no++;
                        }
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
<div class="card-footer text-left">
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