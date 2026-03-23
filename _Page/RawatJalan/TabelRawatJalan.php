<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    include "../../_Config/SimrsFunction.php";
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
        $NextShort="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_kunjungan";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_kunjungan like '%$keyword%' OR id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR sep like '%$keyword%' OR noRujukan like '%$keyword%' OR skdp like '%$keyword%' OR nama like '%$keyword%' OR tanggal like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelRajal').html(data);

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
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
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
                url     : "_Page/RawatJalan/TabelRawatJalan.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelRajal').html(data);
                }
            })
        });
    <?php } ?>
    //Ketika klik ShortNamaAsc
    $('#ShortNamaAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="nama";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortNamaDesc
    $('#ShortNamaDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="nama";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortTglRegAsc
    $('#ShortTglRegAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="tanggal_daftar";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortTglRegDesc
    $('#ShortTglRegDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="tanggal_daftar";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortNikAsc
    $('#ShortNikAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="nik";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortNikDesc
    $('#ShortNikDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="nik";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortBpjsAsc
    $('#ShortBpjsAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="no_bpjs";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortBpjsDesc
    $('#ShortBpjsDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="no_bpjs";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortGenderAsc
    $('#ShortGenderAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="gender";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortGenderDesc
    $('#ShortGenderDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="gender";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortStatusAsc
    $('#ShortStatusAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="status";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
    //Ketika klik ShortStatusDesc
    $('#ShortStatusDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="status";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/RawatJalan/TabelRawatJalan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelRajal').html(data);
            }
        })
    });
</script>

<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered" width="100%">
            <thead class="table">
                <tr class="table">
                    <th class="text-center">
                        <dt>NO</dt>
                    </th>
                    <th class="text-center">
                        <dt>KUNJUNGAN</dt>
                    </th>
                    <th class="text-center">
                        <dt>PASIEN</dt>
                    </th>
                    <th class="text-center">
                        <dt>KATEGORI</dt>
                    </th>
                    <th class="text-center">
                        <dt>POLI/DOKTER</dt>
                    </th>
                    <th class="text-center">
                        <dt>LABEL</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="5" class="text-center text-danger">Tidak Ada Data Kunjungan Yang Ditampilkan</td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_kunjungan like '%$keyword%' OR id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR sep like '%$keyword%' OR noRujukan like '%$keyword%' OR skdp like '%$keyword%' OR nama like '%$keyword%' OR tanggal like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_kunjungan= $data['id_kunjungan'];
                            if(!empty($data['tujuan'])){
                                $tujuan=$data['tujuan'];
                            }else{
                                $tujuan="";
                            }
                            if(!empty($data['tanggal'])){
                                $tanggal=$data['tanggal'];
                                $strtotime=strtotime($tanggal);
                                $TanggalFormat=date('d/m/Y H:i',$strtotime);
                            }else{
                                $TanggalFormat='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['tanggal_keluar'])){
                                $tanggal_keluar=$data['tanggal_keluar'];
                                $strtotime=strtotime($tanggal_keluar);
                                $TanggalKeluarFormat=date('d/m/Y H:i',$strtotime);
                            }else{
                                $TanggalKeluarFormat='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['nama_petugas'])){
                                $nama_petugas=$data['nama_petugas'];
                            }else{
                                $nama_petugas='<span class="text-danger">Tidak Diketahui</span>';
                            }
                            if(!empty($data['nama'])){
                                $nama=$data['nama'];
                            }else{
                                $nama='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['id_pasien'])){
                                $id_pasien=$data['id_pasien'];
                            }else{
                                $id_pasien='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['nik'])){
                                $nik=$data['nik'];
                            }else{
                                $nik='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['no_bpjs'])){
                                $no_bpjs=$data['no_bpjs'];
                            }else{
                                $no_bpjs='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['sep'])){
                                $sep=$data['sep'];
                            }else{
                                $sep='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['sep'])){
                                $sep=$data['sep'];
                            }else{
                                $sep='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['dokter'])){
                                $dokter=$data['dokter'];
                            }else{
                                $dokter='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['poliklinik'])){
                                $poliklinik=$data['poliklinik'];
                            }else{
                                $poliklinik='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['pembayaran'])){
                                $pembayaran=$data['pembayaran'];
                            }else{
                                $pembayaran='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['id_encounter'])){
                                $id_encounter=$data['id_encounter'];
                            }else{
                                $id_encounter='<span class="text-danger">Tidak Ada</span>';
                            }
                            if(!empty($data['status'])){
                                $status=$data['status'];
                            }else{
                                $status='<span class="text-danger">Tidak Ada</span>';
                            }
                            $Pecah = explode(" " , $tanggal);
                            $TanggalSaja=$Pecah['0'];
                            //Inisiasi Pembayaran

                            //Inisiasi Status
                            //Status Terdiri Dari
                            //-- Antrian
                            //-- Terdaftar
                            //-- Pulang
                            //-- Meninggal
                            if($status=="Antrian"){
                                $LabelData='<span class="text-inverse-warning"><i class="icofont-clock-time"></i> Antrian</span>';
                            }else{
                                if($status=="Meninggal"){
                                    $LabelData='<span class="text-danger"><i class="icofont-close-circled"></i> Meninggal</span>';
                                }else{
                                    if($status=="Terdaftar"){
                                        $LabelData='<span class="text-primary"><i class="icofont-edit"></i> Terdaftar</span>';
                                    }else{
                                        if($status=="Pulang"){
                                            $LabelData='<span class="text-success"><i class="icofont-checked"></i> Pulang</span>';
                                        }else{
                                            $LabelData='<span class="text-dark">'.$status.'</span>';
                                        }
                                    }
                                }
                            }
                            //Inisiasi tujuan
                            if($tujuan=="Rajal"){
                                $color_row="table-primary text-light";
                                $LabelTujuan='<dt class="text-info"><i class="icofont-foot-print"></i> RAJAL</dt>';
                            }else{
                                $color_row="table-success text-dark";
                                $LabelTujuan='<dt class="text-danger"><i class="icofont-building-alt"></i> RANAP</dt>';
                            }
                            if($status=="Batal"){
                                $color_row="table-dark text-dark";
                            }

                            //Buka data pasien
                            $tanggal_daftar=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_daftar');
                            //ubah ke milisecon
                            $tanggal_kunjungan_ms=date('Y-m-d',strtotime($tanggal));
                            $tanggal_daftar_ms=date('Y-m-d',strtotime($tanggal_daftar));
                            if ($tanggal_kunjungan_ms <= $tanggal_daftar_ms) {
                                $baru_lama = "Baru";
                            } else {
                                $baru_lama = "Lama"; 
                                // Misal, jika tanggal_kunjungan lebih besar dari tanggal_daftar
                            }
                ?>
                    <tr tabindex="0" class="<?php echo $color_row; ?>" data-toggle="modal" data-target="#ModalDetailKunjungan" data-id="<?php echo "$id_kunjungan,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi,$keyword_by";?>" onmousemove="this.style.cursor='pointer'">
                        <td class="" align="center"><?php echo "$no";?></td>
                        <td class="" align="left">
                            <?php
                                echo '<dt title="ID Kunjungan"><i class="ti ti-check-box"></i> '.$id_kunjungan.'</dt>';
                                echo '<small title="Tanggal/Waktu Masuk"><i class="ti ti-calendar"></i> '.$TanggalFormat.'</small><br>';
                                echo '<small title="Tanggal/Waktu Keluar"><i class="icofont-calendar"></i> '.$TanggalKeluarFormat.'</small><br>';
                                echo '<small title="Nama Petugas"><i class="ti ti-user"></i> '.$nama_petugas.'</small><br>';
                            ?>
                        </td>
                        <td class="" align="left">
                            <?php
                                echo '<dt title="Nama Pasien"><i class="icofont-users-alt-3"></i> '.$nama.'</dt>';
                                echo '<small title="Nomor Rekam Medis"><i class="icofont-card"></i> '.$id_pasien.'</small><br>';
                                echo '<small title="Nomor KTP/NIK"><i class="icofont-id-card"></i> '.$nik.'</small><br>';
                                echo '<small title="Nomor Kartu BPJS"><i class="icofont-medical-sign"></i> '.$no_bpjs.'</small><br>';
                            ?>
                        </td>
                        <td class="" align="left">
                            <?php
                                echo '<dt title="Tujuan Kunjungan">'.$LabelTujuan.'</dt>';
                                echo '<small title="Metode Pembayaran"><i class="icofont-credit-card"></i> '.$pembayaran.'</small><br>';
                                echo '<small title="Status Kunjungan">'.$LabelData.'</small><br>';
                                echo '<small title="Nomor SEP"><i class="icofont-prescription"></i> '.$sep.'</small><br>';
                            ?>
                        </td>
                        <td class="" align="left">
                            <?php
                                echo '<dt title="Poliklinik">'.$poliklinik.'</dt>';
                                echo '<small title="Dokter Pemeriksa"><i class="icofont-credit-card"></i> '.$dokter.'</small><br>';
                                echo '<small title="ID Encounter"><i class="icofont-patient-file"></i> '.$id_encounter.'</small><br>';
                            ?>
                        </td>
                        <td class="" align="left">
                            <?php
                                echo '<dt>'.$baru_lama.'</dt>';
                            ?>
                        </td>
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
<div class="card-footer text-left border-info">
    <div class="btn-group">
        <a href="#!" class="b-b-primary text-primary">
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