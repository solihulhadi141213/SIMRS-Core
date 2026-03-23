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
        $OrderBy="id_rujukan";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rujukan"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rujukan WHERE noRujukan like '%$keyword%' OR id_pasien like '%$keyword%' OR nama like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR noSep like '%$keyword%' OR tglRujukan like '%$keyword%' OR ppkDirujuk like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rujukan"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rujukan WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
                url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelPasien').html(data);
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
            url     : "_Page/Rujukan/TabelRujukanInternal.php",
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
                                No.Rujukan
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
                                Nama Pasien
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
                                Jenis Pelayanan
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
                                Tipe Rujukan
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
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword_by)){
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM rujukan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM rujukan WHERE noRujukan like '%$keyword%' OR id_pasien like '%$keyword%' OR nama like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR noSep like '%$keyword%' OR tglRujukan like '%$keyword%' OR ppkDirujuk like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM rujukan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM rujukan WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_rujukan = $data['id_rujukan'];
                        $id_pasien= $data['id_pasien'];
                        $id_kunjungan= $data['id_kunjungan'];
                        $nama= $data['nama'];
                        $nik= $data['nik'];
                        $no_bpjs= $data['no_bpjs'];
                        $noSep= $data['noSep'];
                        $noRujukan= $data['noRujukan'];
                        $tglRujukan= $data['tglRujukan'];
                        $tglRencanaKunjungan= $data['tglRencanaKunjungan'];
                        $ppkDirujuk= $data['ppkDirujuk'];
                        $jnsPelayanan= $data['jnsPelayanan'];
                        $catatan= $data['catatan'];
                        $diagRujukan= $data['diagRujukan'];
                        $tipeRujukan= $data['tipeRujukan'];
                        $poliRujukan= $data['poliRujukan'];
                        $user= $data['user'];
                        //Inisiasi jnsPelayanan 
                        if($jnsPelayanan=="1"){
                            $LabelPelayanan='<label class="label label-info">Ranap</label>';
                        }else{
                            $LabelPelayanan='<label class="label label-info">Rajal</label>';
                        }
                        //Inisiasi Tripe rujukan
                        if($tipeRujukan=="0"){
                            $LabelRujukan='<label class="label label-inverse-primary">Rujukan Penuh</label>';
                        }else{
                            if($tipeRujukan=="1"){
                                $LabelRujukan='<label class="label label-inverse-primary">Rujukan Partial</label>';
                            }else{
                                if($tipeRujukan=="2"){
                                    $LabelRujukan='<label class="label label-inverse-primary">Rujuk Balik (PRB)</label>';
                                }else{
                                    $LabelRujukan='<label class="label label-danger">None</label>';
                                }
                            }
                        }
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailRujukanInternal" data-id="<?php echo "$id_rujukan,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi,$keyword_by";?>" onmousemove="this.style.cursor='pointer'">
                        <td class="" align="center"><?php echo "$no";?></td>
                        <td class="" align="left">
                            <div class="d-inline-block align-middle">
                                <div class="d-inline-block">
                                    <dt class="text-primary"><?php echo "$noRujukan";?></dt>
                                    <p class="text-muted m-b-0">
                                        Tgl.Rujukan : <?php echo ''.$tglRujukan.''; ?>
                                    </p>
                                    <p class="text-muted m-b-0">
                                        Tgl.Kunjungan : <?php echo ''.$tglRencanaKunjungan.''; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="" align="left">
                            <div class="d-inline-block align-middle">
                                <div class="d-inline-block">
                                    <dt class="text-primary"><?php echo "$nama";?></dt>
                                    <p class="text-muted m-b-0">
                                        No.Rm : <?php echo ''.$id_pasien.''; ?>
                                    </p>
                                    <p class="text-muted m-b-0">
                                        No.Nik : <?php echo ''.$nik.''; ?>
                                    </p>
                                    <p class="text-muted m-b-0">
                                        No.Kartu : <?php echo ''.$no_bpjs.''; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="" align="center"><?php echo ''.$LabelPelayanan.'';?></td>
                        <td class="" align="center"><?php echo ''.$LabelRujukan.'';?></td>
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