<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword_by
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
    }else{
        $keyword_by="";
    }
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
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
        $OrderBy="id_log";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE waktu like '%$keyword%' OR nama_log like '%$keyword%' OR kategori like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE $keyword_by like '%$keyword%'"));
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
        var ShortBy="<?php echo "$ShortBy"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
            success: function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
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
            var ShortBy="<?php echo "$ShortBy"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            $.ajax({
                url     : "_Page/Log/TabelLog.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success: function (data) {
                    $('#MenampilkanTabelLog').html(data);
                }
            })
        });
    <?php } ?>
    //Ketika klik ShortNamaAsc
    $('#ShortNamaAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="nama";
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik ShortNamaDesc
    $('#ShortNamaDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="nama";
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik ShortWaktuAsc
    $('#ShortWaktuAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="waktu";
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik ShortWaktuDesc
    $('#ShortWaktuDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="waktu";
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik ShortKategoriAsc
    $('#ShortKategoriAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="kategori";
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik ShortKategoriDesc
    $('#ShortKategoriDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="kategori";
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik ShortNamaLogAsc
    $('#ShortNamaLogAsc').click(function() {
        var ShortBy ="ASC";
        var OrderBy ="nama_log";
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
    //Ketika klik ShortNamaLogDesc
    $('#ShortNamaLogDesc').click(function() {
        var ShortBy ="DESC";
        var OrderBy ="nama_log";
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Log/TabelLog.php",
            method  : "POST",
            data 	:  { ShortBy: ShortBy, OrderBy: OrderBy, batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelLog').html(data);
            }
        })
    });
</script>

<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-disabled btn-round btn-sm btn-outline-secondary" type="button">
                                No
                            </button>
                        </div>
                    </th>
                    <th class="text-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Nama User
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="nama"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortNamaAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="nama"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortNamaDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <!-- <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="nama">
                                    <i class="ti-search"></i> Group By
                                </a> -->
                            </div>
                        </div>
                    </th>
                    <th class="text-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tanggal/Waktu
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="waktu"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortWaktuAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="waktu"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortWaktuDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <!-- <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="waktu">
                                    <i class="ti-search"></i> Group By
                                </a> -->
                            </div>
                        </div>
                    </th>
                    <th class="text-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Kategori
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="kategori"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortKategoriAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="kategori"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortKategoriDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <!-- <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="kategori">
                                    <i class="ti-search"></i> Group By
                                </a> -->
                            </div>
                        </div>
                    </th>
                    <th class="text-center">
                        <div class="dropdown-primary dropdown open">
                            <button class="btn btn-round btn-sm btn-outline-secondary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Keterangan
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="nama_log"&&$ShortBy=="ASC"){echo "active";} ?>" id="ShortNamaLogAsc">
                                    <i class="ti-arrow-circle-up"></i> Short A to Z
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect <?php if($OrderBy=="nama_log"&&$ShortBy=="DESC"){echo "active";} ?>" id="ShortNamaLogDesc">
                                    <i class="ti-arrow-circle-down"></i> Short Z to A
                                </a>
                                <!-- <div class="dropdown-divider"></div>
                                <a  href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalFilterTabel" data-id="nama_log">
                                    <i class="ti-search"></i> Group By
                                </a> -->
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
                            $query = mysqli_query($Conn, "SELECT*FROM log ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM log WHERE waktu like '%$keyword%' OR nama_log like '%$keyword%' OR kategori like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }else{
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM log ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM log WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_log= $data['id_log'];
                        $waktu= $data['waktu'];
                        $nama_log= $data['nama_log'];
                        $kategori= $data['kategori'];
                        $id_akses= $data['id_akses'];
                        //Buka data nama
                        $QryDetailAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
                        $DataDetailAkses = mysqli_fetch_array($QryDetailAkses);
                        $nama = $DataDetailAkses['nama'];
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailLog" data-id="<?php echo "$id_log";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left"><?php echo "$nama";?></td>
                            <td class="" align="left"><?php echo "$waktu";?></td>
                            <td class="" align="left"><?php echo "$kategori";?></td>
                            <td class="" align="left"><?php echo "$nama_log";?></td>
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