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
        $OrderBy="id_ruang_rawat";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori like '%$keyword%' OR kodekelas like '%$keyword%' OR kelas like '%$keyword%' OR ruangan like '%$keyword%' OR bed like '%$keyword%' OR status like '%$keyword%' OR updatetime like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);

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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
                url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
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
            url     : "_Page/KelasRuangan/TabelKelasRuangan.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelKelasRuangan').html(data);
            }
        })
    });
</script>

<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th id="" class="text-center">
                        <div class="dropdown-primary">
                            <button class="btn btn-round btn-sm btn-outline-secondary waves-effect waves-light btn-disabled" type="button">
                                No
                            </button>
                        </div> 
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Kategori
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="nama"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortNamaAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="nama"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortNamaDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="nama">
                                    <i class="ti-search"></i> Group By
                                </a>
                            </div>
                        </div>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Kelas
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="tanggal_daftar"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortTglRegAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="tanggal_daftar"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortTglRegDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="tanggal_daftar">
                                    <i class="ti-search"></i> Group By
                                </a>
                            </div>
                        </div>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ruangan
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="nik"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortNikAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="nik"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortNikDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="nik">
                                    <i class="ti-search"></i> Group By
                                </a>
                            </div>
                        </div>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Bed
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="no_bpjs"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortBpjsAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="no_bpjs"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortBpjsDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="no_bpjs">
                                    <i class="ti-search"></i> Group By
                                </a>
                            </div>
                        </div>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Status
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="gender"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortGenderAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="gender"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortGenderDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="gender">
                                    <i class="ti-search"></i> Group By
                                </a>
                            </div>
                        </div>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Updatetime
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="status"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortStatusAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="status"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortStatusDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="status">
                                    <i class="ti-search"></i> Group By
                                </a>
                            </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword_by)){
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_pasien= $data['id_pasien'];
                        $noRm=sprintf("%07d", $id_pasien);
                        $tanggal_daftar= $data['tanggal_daftar'];
                        $nik= $data['nik'];
                        $no_bpjs= $data['no_bpjs'];
                        $nama= $data['nama'];
                        $gender= $data['gender'];
                        $tempat_lahir= $data['tempat_lahir'];
                        $tanggal_lahir= $data['tanggal_lahir'];
                        $propinsi= $data['propinsi'];
                        $kabupaten= $data['kabupaten'];
                        $kecamatan= $data['kecamatan'];
                        $desa= $data['desa'];
                        $alamat= $data['alamat'];
                        $status= $data['status'];
                        $gambar= $data['gambar'];
                        //Inisiasi gender 
                        if($gender=="Laki-laki"){
                            $labelGender='<label class="label label-info">Male</label>';
                        }else{
                            if($gender=="Perempuan"){
                                $labelGender='<label class="label label-primary">Female</label>';
                            }else{
                                $labelGender='<label class="label label-danger">None</label>';
                            }
                        }
                        if(empty($gambar)){
                            $LinkGambar="avatar-blank.jpg";
                        }else{
                            $LinkGambar="pasien/$gambar";
                        }
                        //Inisiasi Status
                        //Status ada yang aktiv dan meninggal

                        if($status=="Aktiv"){
                            $LabelData='<label class="label label-success"><i class="ti ti-check-box"></i> Aktiv</label>';
                        }else{
                            if($status=="Meninggal"){
                                $LabelData='<label class="label label-danger"><i class="icofont-close-squared"></i> Meninggal</label>';
                            }else{
                                $LabelData='<label class="label label-info">'.$status.'</label>';
                            }
                        }
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailPasien" data-id="<?php echo "$id_pasien,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi,$keyword_by";?>" onmousemove="this.style.cursor='pointer'">
                        <td class="" align="center"><?php echo "$no";?></td>
                        <td class="" align="left">
                            <div class="d-inline-block align-middle">
                                <img src="assets/images/<?php echo $LinkGambar;?>" alt="user image" class="img-radius img-40 align-top m-r-15">
                                <div class="d-inline-block">
                                    <dt class="text-primary"><?php echo "$nama ($id_pasien)";?></dt>
                                    <p class="text-muted m-b-0">
                                        TTL : <?php echo ''.$tempat_lahir.','.$tanggal_lahir.''; ?>
                                    </p>
                                    <p class="text-muted m-b-0">
                                        <?php echo ''.$alamat.'<br>'.$desa.', '.$kecamatan.''; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="" align="left"><?php echo $tanggal_daftar;?></td>
                        <td class="" align="left"><?php echo ''.$nik.'';?></td>
                        <td class="" align="left"><?php echo ''.$no_bpjs.'';?></td>
                        <td class="" align="center"><?php echo $labelGender;?></td>
                        <td class="text-center"><?php echo $LabelData;?></td>
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