<?php
    //koneksi dan session
    // ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
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
        $OrderBy="id_pasien_shk";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien_shk"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien_shk WHERE id_shk like '%$keyword%' OR id_pasien_ibu like '%$keyword%' OR nik_ibu like '%$keyword%' OR nama_ibu like '%$keyword%' OR id_pasien_anak like '%$keyword%' OR nik_anak like '%$keyword%' OR nama_anak like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien_shk"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien_shk WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/PasienShk/TabelPasienShk.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelPasienShk').html(data);
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
            url     : "_Page/PasienShk/TabelPasienShk.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelPasienShk').html(data);
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
                url     : "_Page/PasienShk/TabelPasienShk.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelPasienShk').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt>
                    </th>
                    <th class="text-center">
                        <dt>ID SHK</dt>
                    </th>
                    <th class="text-center">
                        <dt>RM</dt>
                    </th>
                    <th class="text-center">
                        <dt>Nama</dt>
                    </th>
                    <th class="text-center">
                        <dt>NIK</dt>
                    </th>
                    <th class="text-center">
                        <dt>Option</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td class="text-center text-danger" colspan="6">';
                        echo '      Tidak Ada Data Pasien SHK';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM pasien_shk ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM pasien_shk WHERE id_shk like '%$keyword%' OR id_pasien_ibu like '%$keyword%' OR nik_ibu like '%$keyword%' OR nama_ibu like '%$keyword%' OR id_pasien_anak like '%$keyword%' OR nik_anak like '%$keyword%' OR nama_anak like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM pasien_shk ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM pasien_shk WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_pasien_shk = $data['id_pasien_shk'];
                            $id_shk= $data['id_shk'];
                            $id_pasien_ibu= $data['id_pasien_ibu'];
                            $nik_ibu= $data['nik_ibu'];
                            $nama_ibu= $data['nama_ibu'];
                            $id_pasien_anak= $data['id_pasien_anak'];
                            $nik_anak= $data['nik_anak'];
                            $nama_anak= $data['nama_anak'];
                            $tgllahir= $data['tgllahir'];
                            $gender_anak= $data['gender_anak'];
                            $alamat= $data['alamat'];
                            $provinsi= $data['provinsi'];
                            $kabkota= $data['kabkota'];
                            $kecamatan= $data['kecamatan'];
                            $tgl_ambil_sampel= $data['tgl_ambil_sampel'];
                            $tgl_kirim_sampel= $data['tgl_kirim_sampel'];
                            $tgl_lapor= $data['tgl_lapor'];
                            $kode_perujuk= $data['kode_perujuk'];
                            $nama_fayankes_perujuk= $data['nama_fayankes_perujuk'];
                            $id_akses= $data['id_akses'];
                            //id_shk
                            if(empty($data['id_shk'])){
                                $id_shk='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $id_shk= $data['id_shk'];
                            }
                            //nik_ibu
                            if(empty($data['nik_ibu'])){
                                $nik_ibu='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $nik_ibu= $data['nik_ibu'];
                            }
                            //id_pasien_anak
                            if(empty($data['id_pasien_anak'])){
                                $id_pasien_anak='<span>Tidak Ada</span>';
                            }else{
                                $id_pasien_anak= $data['id_pasien_anak'];
                            }
                            //nik_anak
                            if(empty($data['nik_anak'])){
                                $nik_anak='<span>Tidak Ada</span>';
                            }else{
                                $nik_anak= $data['nik_anak'];
                            }
                            //nama_anak
                            if(empty($data['nama_anak'])){
                                $nama_anak='<span>Tidak Ada</span>';
                            }else{
                                $nama_anak= $data['nama_anak'];
                            }
                            //tgl_ambil_sampel
                            if(empty($data['tgl_ambil_sampel'])){
                                $tgl_ambil_sampel='<span>Tidak Ada</span>';
                            }else{
                                $tgl_ambil_sampel= $data['tgl_ambil_sampel'];
                                $strtotime = strtotime($tgl_ambil_sampel);
                                $tgl_ambil_sampel=date('d/m/Y',$strtotime);
                            }
                            //tgl_ambil_sampel
                            if(empty($data['tgl_kirim_sampel'])){
                                $tgl_kirim_sampel='<span>Tidak Ada</span>';
                            }else{
                                $tgl_kirim_sampel= $data['tgl_kirim_sampel'];
                                $strtotime = strtotime($tgl_kirim_sampel);
                                $tgl_kirim_sampel=date('d/m/Y',$strtotime);
                            }
                            //tgl_lapor
                            if(empty($data['tgl_lapor'])){
                                $tgl_lapor='<span>Tidak Ada</span>';
                            }else{
                                $tgl_lapor= $data['tgl_lapor'];
                                $strtotime = strtotime($tgl_lapor);
                                $tgl_lapor=date('d/m/Y',$strtotime);
                            }
                            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                    ?>
                        <tr class="table-light">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left">
                                <?php
                                    echo "<dt><a href='javascript:void(0);' class='text-primary' data-toggle='modal' data-target='#ModalDetailPasienShkSirsOnline' data-id='$id_shk'>ID.$id_shk</a></dt>";
                                    echo "<small class='text-mutted' title='Tanggal Laporan'><i class='icofont-ui-calendar'></i> $tgl_lapor</small>";
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailPasienByRm" data-id="'.$id_pasien_ibu.'" title="ID Pasien Ibu"><dt class="text-info"><i class="ti ti-user"></i> '.$id_pasien_ibu.'</dt></a>';
                                    echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailPasienByRm" data-id="'.$id_pasien_anak.'" title="ID Pasien/No.RM Anak"><small class="text-info"><i class="icofont-users-alt-3"></i> '.$id_pasien_anak.'</small></a><br>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="Nama Pasien Ibu"><i class="icofont-users-alt-3"></i> '.$nama_ibu.'</dt>';
                                    echo '<small title="Nama Pasien Anak"><i class="icofont-medical-sign"></i> '.$nama_anak.'</small><br>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="NIK Ibu"><i class="icofont-hospital"></i> '.$nik_ibu.'</dt>';
                                    echo '<small title="NIK Anak"><i class="icofont-bill"></i> '.$nik_anak.'</small><br>';
                                ?>
                            </td>
                            <td class="" align="center">
                                <button type="button" title="Detail Pasien SHK" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalDetailPasienShk" data-id="<?php echo "$id_pasien_shk"; ?>">
                                    <i class="ti ti-info-alt"></i>
                                </button>
                            </td>
                        </tr>
                <?php
                    $no++; }}
                ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table>
                <tr>
                    <td><dt>Dasar Pencarian</dt></td>
                    <td>:</td>
                    <td><?php echo "$keyword_by"; ?></td>
                </tr>
                <tr>
                    <td><dt>Kata Kunci</dt></td>
                    <td>:</td>
                    <td><?php echo "$keyword"; ?></td>
                </tr>
            </table>
        </div>
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