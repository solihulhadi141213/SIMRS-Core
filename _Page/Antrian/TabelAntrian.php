<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
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
        $OrderBy="id_antrian";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($tanggal)){
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian WHERE no_antrian like '%$keyword%' OR kodebooking like '%$keyword%' OR nomorkartu like '%$keyword%' OR nik like '%$keyword%' OR tanggal_kunjungan like '%$keyword%' OR nama_pasien like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian WHERE $keyword_by like '%$keyword%'"));
            }
        }
    }else{
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian WHERE tanggal_kunjungan='$tanggal'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian WHERE (tanggal_kunjungan='$tanggal') AND (no_antrian like '%$keyword%' OR kodebooking like '%$keyword%' OR nomorkartu like '%$keyword%' OR nik like '%$keyword%' OR tanggal_kunjungan like '%$keyword%' OR nama_pasien like '%$keyword%')"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian WHERE tanggal_kunjungan='$tanggal'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_antrian FROM antrian WHERE tanggal_kunjungan='$tanggal' AND $keyword_by like '%$keyword%'"));
            }
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
            url     : "_Page/Antrian/TabelAntrian.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanDataAntrian').html(data);

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
            url     : "_Page/Antrian/TabelAntrian.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanDataAntrian').html(data);
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
                url     : "_Page/Antrian/TabelAntrian.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanDataAntrian').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-header">
    <h4><i class="ti ti-list"></i> Data Antrian SIMRS</h4>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt>
                    </th>
                    <th class="text-center">
                        <dt>Kode Booking</dt>
                    </th>
                    <th class="text-center">
                        <dt>Nama Pasien</dt>
                    </th>
                    <th class="text-center">
                        <dt>Kunjungan</dt>
                    </th>
                    <th class="text-center">
                        <dt>Poliklinik/Status</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td class="text-center text-danger" colspan="7">';
                        echo '      Tidak Ada Data Antrian';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($tanggal)){
                            if(empty($keyword_by)){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM antrian ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM antrian WHERE no_antrian like '%$keyword%' OR kodebooking like '%$keyword%' OR nomorkartu like '%$keyword%' OR nik like '%$keyword%' OR tanggal_kunjungan like '%$keyword%' OR nama_pasien like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM antrian ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM antrian WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                        }else{
                            if(empty($keyword_by)){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM antrian WHERE (tanggal_kunjungan='$tanggal') AND (no_antrian like '%$keyword%' OR kodebooking like '%$keyword%' OR nomorkartu like '%$keyword%' OR nik like '%$keyword%' OR tanggal_kunjungan like '%$keyword%' OR nama_pasien like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM antrian WHERE (tanggal_kunjungan='$tanggal') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_antrian = $data['id_antrian'];
                            $no_antrian= $data['no_antrian'];
                            $kodebooking= $data['kodebooking'];
                            $nama_pasien= $data['nama_pasien'];
                            $nomorreferensi= $data['nomorreferensi'];
                            $tanggal_daftar= $data['tanggal_daftar'];
                            $tanggal_kunjungan= $data['tanggal_kunjungan'];
                            
                            $kode_dokter= $data['kode_dokter'];
                            $nama_dokter= $data['nama_dokter'];
                            $kodepoli= $data['kodepoli'];
                            $namapoli= $data['namapoli'];
                            $pembayaran= $data['pembayaran'];
                            $no_rujukan= $data['no_rujukan'];
                            $status= $data['status'];
                            //ID Pasien
                            if(empty($data['id_pasien'])){
                                $id_pasien='<span class="text-danger">No.RM Tidak Ada</span>';
                            }else{
                                $id_pasien= $data['id_pasien'];
                            }
                            //NIK
                            if(empty($data['nik'])){
                                $nik='<span>NIK Tidak Ada</span>';
                            }else{
                                $nik= $data['nik'];
                            }
                             //ID Kunjungan
                            if(empty($data['id_kunjungan'])){
                                $id_kunjungan='<span class="text-danger">ID Kunjungan Tidak Ada</span>';
                            }else{
                                $id_kunjungan= $data['id_kunjungan'];
                            }
                            if(empty($data['sumber_antrian'])){
                                $sumber_antrian='<span class="text-danger">Sumber Tidak Diketahui</span>';
                            }else{
                                $sumber_antrian= $data['sumber_antrian'];
                            }
                            //Status
                            if($status=="Terdaftar"){
                                $LabelStatus='<span class="text-info">Terdaftar</span>';
                            }else{
                                if($status=="Checkin"){
                                    $LabelStatus='<span class="text-warning">Checkin</span>';
                                }else{
                                    if($status=="Batal"){
                                        $LabelStatus='<span class="text-danger">Batal</span>';
                                    }else{
                                        if($status=="Selesai"){
                                            $LabelStatus='<span class="text-success">Selesai</span>';
                                        }else{
                                            if($status=="Panggil"){
                                                $LabelStatus='<b class="text-success">Panggil</b>';
                                            }else{
                                                if($status=="Tunggu Poli"){
                                                    $LabelStatus='<b class="text-success">Tunggu Poli</b>';
                                                }else{
                                                    if($status=="Layanan Poli"){
                                                        $LabelStatus='<b class="text-success">Layanan Poli</b>';
                                                    }else{
                                                        if($status=="Tunggu Farmasi"){
                                                            $LabelStatus='<b class="text-success">Tunggu Farmasi</b>';
                                                        }else{
                                                            if($status=="Layanan Farmasi"){
                                                                $LabelStatus='<b class="text-success">Layanan Farmasi</b>';
                                                            }else{
                                                                $LabelStatus='<span class="text-dark">None</span>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if(!empty($data['jam_kunjungan'])){
                                $jam_kunjungan= $data['jam_kunjungan'];
                            }else{
                                $jam_kunjungan="";
                            }
                            
                            //Format Tanggal Daftar
                            $strtotime = strtotime($tanggal_daftar);
                            $TanggalDaftar=date('d/m/Y H:i',$strtotime);
                            //Tanggal Kunjungan
                            $strtotime2 = strtotime($tanggal_kunjungan);
                            $TanggalKunjungan=date('d/m/Y',$strtotime2);
                            //Zero padding 
                            $fzeropadded = sprintf("%05d", $no_antrian);
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailAntrian" data-id="<?php echo "$id_antrian,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi,$keyword_by,$tanggal";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left">
                                <?php
                                    echo "<dt title='Kode Booking'><i class='ti ti-info-alt'></i> $kodebooking</dt>";
                                    echo "<small class='text-mutted' title='Nomor Antrian'><i class='icofont-ticket'></i> $fzeropadded ($sumber_antrian)</small><br>";
                                    echo "<small class='text-mutted' title='Tanggal Daftar'><i class='icofont-ui-calendar'></i> $TanggalDaftar</small>";
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="Nama Pasien"><i class="icofont-users-alt-3"></i> '.$nama_pasien.'</dt>';
                                    echo '<small title="ID Pasien/No.RM"><i class="icofont-medical-sign"></i> '.$id_pasien.'</small><br>';
                                    echo '<small title="ID Pasien/No.RM"><i class="icofont-ui-v-card"></i> '.$nik.'</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="Tanggal Kunjungan"><i class="icofont-ui-calendar"></i> '.$TanggalKunjungan.'</dt>';
                                    echo '<small title="Jam Kunjungan"><i class="icofont-clock-time"></i> '.$jam_kunjungan.'</small><br>';
                                    echo '<small title="ID Kunjungan"><i class="icofont-ui-v-card"></i> '.$id_kunjungan.'</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="Poliklinik"><i class="icofont-hospital"></i> '.$namapoli.'</dt>';
                                    echo '<small title="Metode Pembayaran"><i class="icofont-bill"></i> '.$pembayaran.'</small><br>';
                                    echo '<small title="Status Antrian"><i class="icofont-tag"></i> '.$LabelStatus.'</small>';
                                ?>
                            </td>
                        </tr>
                <?php
                    $no++; }}
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