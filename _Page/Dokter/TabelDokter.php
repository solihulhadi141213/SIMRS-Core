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
        $OrderBy="id_dokter";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR alamat like '%$keyword%' OR kontak like '%$keyword%' OR email like '%$keyword%' OR SIP like '%$keyword%' OR status like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $('#page').val(valueNext);
        $.ajax({
            url     : "_Page/Dokter/TabelDokter.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelDokter').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $('#page').val(ValuePrev);
        $.ajax({
            url     : "_Page/Dokter/TabelDokter.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelDokter').html(data);
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
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $('#page').val(PageNumber);
            $.ajax({
                url     : "_Page/Dokter/TabelDokter.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelDokter').html(data);
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
            echo '      Tidak Ada Data Yang Ditampilkan';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM dokter ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM dokter WHERE kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR alamat like '%$keyword%' OR kontak like '%$keyword%' OR email like '%$keyword%' OR SIP like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM dokter ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM dokter WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_dokter= $data['id_dokter'];
                $nama= $data['nama'];
                $kategori= $data['kategori'];
                $status= $data['status'];
                $foto= $data['foto'];
                //alamat
                if(empty($data['alamat'])){
                    $alamat='<span class="text-danger">None</span>';
                }else{
                    $alamat= $data['alamat'];
                }
                //kontak
                if(empty($data['kontak'])){
                    $kontak='<span class="text-danger">None</span>';
                }else{
                    $kontak= $data['kontak'];
                }
                //email
                if(empty($data['email'])){
                    $email='<span class="text-danger">None</span>';
                }else{
                    $email= $data['email'];
                }
                //SIP
                if(empty($data['SIP'])){
                    $SIP='<span class="text-danger">None</span>';
                }else{
                    $SIP= $data['SIP'];
                }
                //kategori_identitas
                if(empty($data['kategori_identitas'])){
                    $kategori_identitas='<span class="text-danger">None</span>';
                }else{
                    $kategori_identitas= $data['kategori_identitas'];
                }
                //no_identitas
                if(empty($data['no_identitas'])){
                    $no_identitas='<span class="text-danger">None</span>';
                }else{
                    $no_identitas= $data['no_identitas'];
                }
                //ID IHS
                if(empty($data['id_ihs_practitioner'])){
                    $LabaleIhs='<a href="javascript:void(0);" class="text-danger">None</a>';
                }else{
                    $id_ihs_practitioner= $data['id_ihs_practitioner'];
                    $LabaleIhs='<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalIhsDokter" data-id="'.$id_ihs_practitioner.'" class="text-info">'.$id_ihs_practitioner.' <i class="ti ti-new-window"></i></a>';
                }
                //Inisiasi Gambar
                if(empty($foto)){
                    $LinkGambar="avatar-blank.jpg";
                }else{
                    $LinkGambar="Dokter/$foto";
                }
                //Inisiasi Kode
                if(empty($data['kode'])){
                    $kode="None";
                    $LabelKode='<a href="javascript:void(0);" class="text-danger">'.$kode.'</a>';
                }else{
                    $kode=$data['kode'];
                    $LabelKode='<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDataHfis" data-id="'.$kode.'">'.$kode.' <i class="ti ti-new-window"></i></a>';
                }
                //Status Dokter Terdiri Dari
                //--Aktiv
                //--Non-Aktiv
                //--Cuti
                if($status=="Aktiv"){
                    $LabelData='<span class="text-success"><i class="ti ti-check-box"></i> Aktiv</span>';
                }else{
                    if($status=="Non-Aktiv"){
                        $LabelData='<span class="text-danger"><i class="icofont-close-squared"></i> Non-Aktiv</span>';
                    }else{
                        if($status=="Cuti"){
                            $LabelData='<span class="text-info"><i class="icofont-close-squared"></i> Cuti</span>';
                        }else{
                            $LabelData='<span class="text-info">'.$status.'</span>';
                        }
                    }
                }
                //Hitung Record Jadwal
                $JumlahJadwalDokter = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter'"));
                if(empty($JumlahJadwalDokter)){
                    $LabelRecordJadwal='<span class="text-danger">None</span>';
                }else{
                    $LabelRecordJadwal='<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalJadwalDokter" data-id="'.$id_dokter.'" class="text-info">'.$JumlahJadwalDokter.' Record <i class="ti ti-new-window"></i></a>';
                }
                //Hitung Jumlah Layanan Kunjungan
                $JumlahpasienDilayani = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_dokter='$id_dokter'"));
                if($JumlahpasienDilayani>=1000&&$JumlahpasienDilayani<1000000){
                    $JumlahpasienDilayani=$JumlahpasienDilayani/1000;
                    $JumlahpasienDilayani=round($JumlahpasienDilayani,1);
                    $JumlahpasienDilayani="$JumlahpasienDilayani K";
                }else{
                    if($JumlahpasienDilayani>=1000000){
                        $JumlahpasienDilayani=$JumlahpasienDilayani/1000000;
                        $JumlahpasienDilayani=round($JumlahpasienDilayani,1);
                        $JumlahpasienDilayani="$JumlahpasienDilayani M";
                    }else{
                        $JumlahpasienDilayani="$JumlahpasienDilayani";
                    }
                }
        ?>
            <div class="row mb-3">
                <div class="col-md-12">
                    <dt>
                        <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailDokter" data-id="<?php echo "$id_dokter"; ?>" title="Detail Informasi Dokter">
                            <?php echo "$no. $nama";?>
                        </a>
                    </dt>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <ul  class="ml-2">
                        <li>Kode : <?php echo ''.$LabelKode.''; ?></li>
                        <li>Kategori : <span class="text-secondary"><?php echo ''.$kategori.''; ?></span></li>
                        <li>Identitas : <?php echo ''.$no_identitas.' ('.$kategori_identitas.')'; ?></li>
                        <li>SIP : <span class="text-secondary"><?php echo ''.$SIP.''; ?></span></li>
                        <li>Status : <span class="text-secondary"><?php echo ''.$LabelData.''; ?></span></li>
                    </ul>
                </div>
                <div class="col-md-5">
                    <ul class="ml-2">
                        <li>IHS : <?php echo ''.$LabaleIhs.''; ?></li>
                        <li>Alamat : <span class="text-secondary"><?php echo ''.$alamat.''; ?></span></li>
                        <li>Kontak (HP) : <span class="text-secondary"><?php echo ''.$kontak.''; ?></span></li>
                        <li>Email : <span class="text-secondary"><?php echo ''.$email.''; ?></span></li>
                        <li>Jadwal : <?php echo ''.$LabelRecordJadwal.''; ?></li>
                    </ul>
                </div>
                <div class="col-md-3 mt-3 text-left">
                    <div class="icon-btn label-icon">
                        <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalHistoryDokter" data-id="<?php echo "$id_dokter"; ?>" title="Riwayat Pelayanan Kepada Pasien">
                            <i class="icofont-history"></i> 
                            <?php
                                if(!empty($JumlahpasienDilayani)){
                                    echo '<label class="label badge-top-left label-icon label-success"><small>'.$JumlahpasienDilayani.'</small></label>';
                                }
                            ?>
                        </button>
                        <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalEditDokter" data-id="<?php echo "$id_dokter"; ?>" title="Edit Data Dokter">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalHapusDokter" data-id="<?php echo "$id_dokter"; ?>" title="Hapus Data Dokter">
                            <i class="ti ti-close"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mb-4 sub-title">
                <div class="col-md-12">

                </div>
            </div>
        </tr>
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
                    echo '<button type="button" class="btn btn-sm btn-outline-info btn-round" id="PageNumber'.$i.'" value="'.$i.'">';
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