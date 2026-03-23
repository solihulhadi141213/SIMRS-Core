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
        $NextShort="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_pasien";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pasien FROM pasien"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pasien FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pasien FROM pasien"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pasien FROM pasien WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelPasien').html(data);

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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
                url     : "_Page/Pasien/TabelPasien.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
            }
        })
    });
    //Ketika klik ShortRmAsc
    $('#ShortRmAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="id_pasien";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
            }
        })
    });
    //Ketika klik ShortRmDesc
    $('#ShortRmDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="id_pasien";
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $.ajax({
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Pasien/TabelPasien.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
            }
        })
    });
</script>

<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">ID/RM</th>
                    <th class="text-center">PASIEN</th>
                    <th class="text-center">ALAMAT</th>
                    <th class="text-center">LABEL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="5" class="text-center text-danger">Tidak Ada Data Pasien Yang Ditampilkan</td>';
                        echo '</tr>';
                    }
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword_by)){
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_pasien= $data['id_pasien'];
                        $noRm=sprintf("%07d", $id_pasien);
                        $tanggal_daftar= $data['tanggal_daftar'];
                        $nama= $data['nama'];
                        $gender= $data['gender'];
                        $propinsi= $data['propinsi'];
                        $kabupaten= $data['kabupaten'];
                        $kecamatan= $data['kecamatan'];
                        $desa= $data['desa'];
                        $kontak= $data['kontak'];
                        $status= $data['status'];
                        if(!empty($data['desa'])){
                            $desa= $data['desa'];
                        }else{
                            $desa="None";
                        }
                        if(!empty($data['kecamatan'])){
                            $kecamatan= $data['kecamatan'];
                        }else{
                            $kecamatan="None";
                        }
                        if(!empty($data['kabupaten'])){
                            $kabupaten= $data['kabupaten'];
                        }else{
                            $kabupaten="None";
                        }
                        if(!empty($data['propinsi'])){
                            $propinsi= $data['propinsi'];
                        }else{
                            $propinsi="None";
                        }
                        if(!empty($data['tempat_lahir'])){
                            $tempat_lahir= $data['tempat_lahir'];
                        }else{
                            $tempat_lahir="None";
                        }
                        if(!empty($data['tanggal_lahir'])){
                            $tanggal_lahir= $data['tanggal_lahir'];
                        }else{
                            $tanggal_lahir="None";
                        }
                        if(!empty($data['nik'])){
                            $nik= $data['nik'];
                        }else{
                            $nik="NIK Tidak Ada";
                        }
                        if(!empty($data['no_bpjs'])){
                            $no_bpjs= $data['no_bpjs'];
                        }else{
                            $no_bpjs="No BPJS Tidak Ada";
                        }
                        if(!empty($data['alamat'])){
                            if (strlen($data["alamat"])<=20) {
                                $alamat= $data['alamat'];
                            }else{
                                $alamat=substr($data["alamat"],0,20);
                                $alamat="$alamat..";
                            }
                        }else{
                            $alamat="Alamat Tidak Ada";
                        }
                        if(!empty($data['id_ihs'])){
                            $id_ihs= $data['id_ihs'];
                        }else{
                            $id_ihs="IHS Tidak Ada";
                        }
                        if(!empty($data['kontak'])){
                            $kontak= $data['kontak'];
                        }else{
                            $kontak="Kontak Tidak Ada";
                        }
                        //Inisiasi gender 
                        if($gender=="Laki-laki"){
                            $labelGender='<span class="text-info"><i class="icofont-user-male"></i> Male</span>';
                        }else{
                            if($gender=="Perempuan"){
                                $labelGender='<span class="text-primary"><i class="icofont-user-female"></i> Female</span>';
                            }else{
                                $labelGender='<span class="text-danger"><i class="ti ti-close"></i> None</span>';
                            }
                        }
                        if($status=="Aktiv"){
                            $LabelData='<span class="text-success"><i class="ti ti-check-box"></i> Aktiv</span>';
                        }else{
                            if($status=="Meninggal"){
                                $LabelData='<span class="text-danger"><i class="icofont-close-squared"></i> Meninggal</span>';
                            }else{
                                $LabelData='<span class="text-secondary"><i class="ti ti-close"></i> '.$status.'</span>';
                            }
                        }
                        if(!empty($data['updatetime'])){
                            $updatetime= $data['updatetime'];
                            $strtotime=strtotime($updatetime);
                            $updatetime=date('d/m/Y H:i', $strtotime);
                        }else{
                            $updatetime="None";
                        }
                        //Format Tanggal Daftar
                        $strtotime=strtotime($tanggal_daftar);
                        $TanggalDaftar=date('d/m/Y H:i', $strtotime);
                        //Jumlah Kunjungan
                        $JumlahKunjungan=mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_pasien='$id_pasien'"));
                    ?>
                    <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailPasien" data-id="<?php echo "$id_pasien,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi,$keyword_by";?>" onmousemove="this.style.cursor='pointer'">
                        <td class="" align="center"><?php echo "$no";?></td>
                        <td class="" align="left">
                            <?php 
                                echo "<dt title='Nomor Rekam Medis'>$id_pasien</dt>";
                                if(!empty($nik)){
                                    echo '<small class="text-muted m-b-0" title="Nomor KTP"><i class="ti ti-credit-card"></i> '.$nik.'</i></small><br>';
                                }
                                if(!empty($no_bpjs)){
                                    echo '<small class="text-muted m-b-0" title="Nomor Kartu BPJS"><i class="icofont-id-card"></i> '.$no_bpjs.'</i></small><br>';
                                }
                                if(!empty($id_ihs)){
                                    echo '<small class="text-muted m-b-0" title="Nomor IHS"><i class="icofont-medical-sign"></i> '.$id_ihs.'</i></small>';
                                }
                            ?>
                        </td>
                        <td class="" align="left">
                            <dt class="text-dark"><?php echo "$nama";?></dt>
                            <?php
                                if(!empty($tanggal_lahir)){
                                    echo "<small class='text-muted m-b-0' title='Tempat Tanggal Lahir'><i class='icofont-baby'></i> $tempat_lahir, $tanggal_lahir</small><br>";
                                }
                                if(!empty($TanggalDaftar)){
                                    echo '<small class="text-muted m-b-0" title="Tanggal Daftar"><i class="ti ti-calendar"> '.$TanggalDaftar.'</i></small><br>';
                                }
                                if(!empty($updatetime)){
                                    echo '<small class="text-muted m-b-0" title="Update Time"><i class="icofont-clock-time"></i> '.$updatetime.'</i></small><br>';
                                }
                            ?>
                        </td>
                        <td class="" align="left">
                            <?php
                                if(!empty($alamat)){
                                    echo "<dt><i class='icofont-search-map'></i> $alamat</dt>";
                                }
                                if(!empty($desa)&&!empty($kecamatan)){
                                    echo "<small class='text-muted m-b-0' title='Desan & Kecamatan'><i class='icofont-google-map'></i> $desa, $kecamatan</small><br>";
                                }
                                if(!empty($kabupaten)&&!empty($propinsi)){
                                    echo "<small class='text-muted m-b-0' title='Kabupaten & Provinsi'><i class='icofont-search-map'></i> $kabupaten, $propinsi</small><br>";
                                }
                                if(!empty($kontak)){
                                    echo "<small class='text-muted m-b-0' title='Nomor Kontak Pasien'><i class='icofont-phone-circle'></i> $kontak</small><br>";
                                }
                            ?>
                        </td>
                        <td class="text-left">
                            <?php 
                                echo "<dt title='Status pasien'>$LabelData</dt>";
                                echo "<small title='Jenis Kelamin'>$labelGender</small><br>";
                                if(empty($JumlahKunjungan)){
                                    echo "<span class='label label-default'>No Record</span>";
                                }else{
                                    echo "<span class='label label-success'><i class='ti ti-align-justify'></i> $JumlahKunjungan Record</span>";
                                }
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
<div class="card-footer text-left border-info">
    <div class="btn-group">
        <a href="javascript:void(0);" class="b-b-primary text-primary">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-info" id="PageNumber'.$i.'" value="'.$i.'">';
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