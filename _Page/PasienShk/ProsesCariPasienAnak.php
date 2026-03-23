<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //KeywordPencarianPasienAnak
    if(!empty($_POST['KeywordPencarianPasienAnak'])){
        $keyword=$_POST['KeywordPencarianPasienAnak'];
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
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/PasienShk/ProsesCariPasienAnak.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, KeywordPencarianPasienAnak: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#ListPasienAnak').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/PasienShk/ProsesCariPasienAnak.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, KeywordPencarianPasienAnak: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#ListPasienAnak').html(data);
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
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/PasienShk/ProsesCariPasienAnak.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, KeywordPencarianPasienAnak: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#ListPasienAnak').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row mb-3">
    <div class="col-md-12">
        <?php
            if(empty($jml_data)){
                echo '<tr>';
                echo '  <td colspan="5" class="text-center text-danger">Tidak Ada Data Pasien Yang Ditampilkan</td>';
                echo '</tr>';
            }
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword)){
                $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }else{
                $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_pasien= $data['id_pasien'];
                $noRm=sprintf("%07d", $id_pasien);
                $tanggal_daftar= $data['tanggal_daftar'];
                $nama= $data['nama'];
                $nik= $data['nik'];
                $gender= $data['gender'];
                $propinsi= $data['propinsi'];
                $kabupaten= $data['kabupaten'];
                $kecamatan= $data['kecamatan'];
                $desa= $data['desa'];
                $kontak= $data['kontak'];
                $status= $data['status'];
                $tanggal_lahir= $data['tanggal_lahir'];
                echo '<div class="list-group-item list-group-item-action">';
                echo '  <ul>';
                echo '      <li><a href="javascript:void(0);" class="text-primary" id="SetIdPasienAnak'.$id_pasien.'">'.$id_pasien.'</a></li>';
                echo '      <li id="NamaPasienAnak'.$id_pasien.'">'.$nama.'</li>';
                echo '      <li id="NikPasienAnak'.$id_pasien.'">'.$nik.'</li>';
                echo '      <li id="TanggalLahirPasienAnak'.$id_pasien.'">'.$tanggal_lahir.'</li>';
                echo '      <li id="GenderPasienAnak'.$id_pasien.'">'.$gender.'</li>';
                echo '  </ul>';
                echo '</div>';
            }
        ?>
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
<div class="row">
    <div class="col-md-12 text-center">
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
</div>

<script>
    <?php
    if(!empty($jml_data)){
        if(empty($keyword)){
            $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
        }else{
            $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
        }
        while ($data = mysqli_fetch_array($query)) {
            $id_pasien= $data['id_pasien'];
?>
    //Ketika Dipilih Pasien Anak
    $("#SetIdPasienAnak<?php echo $id_pasien ?>").click(function() {
        //Menangkap Data
        var id_pasien_anak= $('#SetIdPasienAnak<?php echo $id_pasien ?>').html();
        var nama_anak= $('#NamaPasienAnak<?php echo $id_pasien ?>').html();
        var nik= $('#NikPasienAnak<?php echo $id_pasien ?>').html();
        var tgllahir= $('#TanggalLahirPasienAnak<?php echo $id_pasien ?>').html();
        var gender= $('#GenderPasienAnak<?php echo $id_pasien ?>').html();
        if(gender=="Laki-laki"){
            var gender="Laki-Laki";
        }else{
            var gender="Perempuan";
        }
        //Masukan ke Form
        $('#id_pasien_anak').val(id_pasien_anak);
        $('#nama_anak').val(nama_anak);
        $('#nik_anak').val(nik);
        $('#tgllahir').val(tgllahir);
        $('#gender').val(gender);
        //Tutup Modal
        $('#ModalCariPasienAnak').modal('hide');
    });
<?php
        }
    }
?>
</script>