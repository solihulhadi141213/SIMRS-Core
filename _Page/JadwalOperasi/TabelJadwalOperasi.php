<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //tanggal
    if(!empty($_POST['tanggal'])){
        $tanggal=$_POST['tanggal'];
    }else{
        $tanggal="";
    }
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
        $OrderBy="id_operasi";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_operasi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_operasi WHERE id_pasien like '%$keyword%' OR nama like '%$keyword%' OR nopeserta like '%$keyword%' OR tanggaloperasi like '%$keyword%' OR jenistindakan like '%$keyword%' OR kodepoli like '%$keyword%' OR namapoli like '%$keyword%' OR kodebooking like '%$keyword%' OR terlaksana like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_operasi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_operasi WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/JadwalOperasi/TabelJadwalOperasi.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanJadwalOperasi').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/JadwalOperasi/TabelJadwalOperasi.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanJadwalOperasi').html(data);
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
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/JadwalOperasi/TabelJadwalOperasi.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanJadwalOperasi').html(data);
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
                    <th id="" class="text-center">
                        <dt>NO</dt>
                    </th>
                    <th class="text-center">
                        <dt>BOOKING</dt>
                    </th>
                    <th id="" class="text-center">
                        <dt>TANGGAL/WAKTU</dt>
                    </th>
                    <th id="" class="text-center">
                        <dt>PASIEN</dt>
                    </th>
                    <th id="" class="text-center">
                        <dt>POLI & TINDAKAN</dt>
                    </th>
                    <th id="" class="text-center">
                        <dt>STATUS</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword_by)){
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM jadwal_operasi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM jadwal_operasi WHERE id_pasien like '%$keyword%' OR nama like '%$keyword%' OR nopeserta like '%$keyword%' OR tanggaloperasi like '%$keyword%' OR jenistindakan like '%$keyword%' OR kodepoli like '%$keyword%' OR namapoli like '%$keyword%' OR kodebooking like '%$keyword%' OR terlaksana like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM jadwal_operasi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM jadwal_operasi WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_operasi = $data['id_operasi'];
                        $id_pasien= $data['id_pasien'];
                        $nama= $data['nama'];
                        if(empty($data['nopeserta'])){
                            $nopeserta="Tidak Ada";
                        }else{
                            $nopeserta= $data['nopeserta'];
                        }
                        $tanggal_daftar= $data['tanggal_daftar'];
                        $jam_daftar= $data['jam_daftar'];
                        $tanggaloperasi= $data['tanggaloperasi'];
                        $jamoperasi= $data['jamoperasi'];
                        $jenistindakan= $data['jenistindakan'];
                        $kodepoli= $data['kodepoli'];
                        $namapoli= $data['namapoli'];
                        $keterangan= $data['keterangan'];
                        $terlaksana= $data['terlaksana'];
                        $kodebooking= $data['kodebooking'];
                        $lastupdate= $data['lastupdate'];
                        if($terlaksana=="0"){
                            $LabelStatus='<span class="badge badge-info"><i class="ti ti-pencil"></i> Terdaftar</span>';
                        }else{
                            if($terlaksana=="1"){
                                $LabelStatus='<span class="badge badge-success"><i class="ti ti-check-box"></i> Selesai</span>';
                            }
                        }
                        //Format Tanggal Booking
                        $strtotime1=strtotime("$tanggal_daftar $jam_daftar");
                        $strtotime2=strtotime("$tanggaloperasi $jamoperasi");
                        $strtotime3=strtotime("$lastupdate");
                        $TanggalDaftar=date('d/m/Y H:i',$strtotime1);
                        $TanggalOperasi=date('d/m/Y H:i',$strtotime2);
                        $TanggalUpdate=date('d/m/Y H:i',$strtotime3);
                        //Buka Data Lampiran
                        $IdRincianLaporanOperasi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_operasi');
                        if(empty($IdRincianLaporanOperasi)){
                            $LabelRincianOperasi='<span class="text-danger"><i class="ti ti-close"></i> Laporan Tidak Tersedia</span>';
                        }else{
                            $LabelRincianOperasi='<span class="text-success"><i class="ti ti-check"></i> Laporan Tersedia</span>';
                        }
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailJadwalOperasi" data-id="<?php echo "$id_operasi";?>" onmousemove="this.style.cursor='pointer'">
                            <td align="center"><?php echo "$no";?></td>
                            <td align="left">
                                <?php 
                                    echo '<dt title="Kode Booking"><i class="ti ti-ticket"></i> '.$kodebooking.'</dt>';
                                    echo '<small title="ID Jadwal Operasi">ID Jadwal : '.$id_operasi.'</small>';
                                ?>
                            </td>
                            <td align="left">
                                <?php 
                                    echo '<dt title="Tanggal/Waktu Operasi"><i class="ti-alarm-clock"></i> '.$TanggalOperasi.'</dt>';
                                    echo '<small class="text-muted" title="Tanggal Daftar"><i class="ti-pencil"></i>  '.$TanggalDaftar.'</small><br>';
                                    echo '<small class="text-muted" title="Terakhir Update"><i class="icofont-history"></i> '.$TanggalUpdate.'</small';
                                ?>
                            </td>
                            <td align="left">
                                <?php 
                                    echo '<dt title="Nama pasien"><i class="ti-user"></i> '.$nama.'</dt>';
                                    echo '<small class="text-muted" title="Nomor Peserta BPJS"><i class="ti-credit-card"></i>  '.$nopeserta.'</small><br>';
                                    echo '<small class="text-muted" title="No.RM"><i class="icofont-patient-file"></i> No.RM '.$id_pasien.'</small>';
                                ?>
                            </td>
                            <td align="left">
                                <?php 
                                    echo '<dt title="Kode Poliklinik"><i class="icofont-hospital"></i> '.$kodepoli.'</dt>';
                                    echo '<small class="text-muted" title="Nama Poliklinik"><i class="icofont icofont-dna"></i>  '.$namapoli.'</small><br>';
                                    echo '<small class="text-muted" title="Jenis Tindakan"><i class="ti ti-info-alt"></i>  '.$jenistindakan.'</small>';
                                ?>
                            </td>
                            <td align="left">
                                <?php 
                                    echo ''.$LabelStatus.'<br>';
                                    echo '<small>'.$LabelRincianOperasi.'</small>';
                                ?>
                            </td>
                        </tr>
                <?php
                    $no++; }
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
        <a href="javascript:void(0);" class="b-b-primary text-primary">
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
        </a>
    </div>
</div>