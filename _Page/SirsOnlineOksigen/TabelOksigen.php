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
        $OrderBy="id_sirs_online_task";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE kategori='Oksigen'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE (kategori='Oksigen') AND (tanggal like '%$keyword%' OR updatetime like '%$keyword%' OR id_akses like '%$keyword%')"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE kategori='Oksigen'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE (kategori='Oksigen') AND ($keyword_by like '%$keyword%')"));
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
            url     : "_Page/SirsOnlineOksigen/TabelOksigen.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelLaporanOksigen').html(data);
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
            url     : "_Page/SirsOnlineOksigen/TabelOksigen.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelLaporanOksigen').html(data);
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
                url     : "_Page/SirsOnlineOksigen/TabelOksigen.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelLaporanOksigen').html(data);
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
                        <dt>Tanggal Laporan</dt>
                    </th>
                    <th class="text-center">
                        <dt>Update Terakhir</dt>
                    </th>
                    <th class="text-center">
                        <dt>Nama Petugas</dt>
                    </th>
                    <th class="text-center">
                        <dt>Status</dt>
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
                        echo '      Tidak Ada Data Antrian';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE kategori='Oksigen' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE (kategori='Oksigen') AND (tanggal like '%$keyword%' OR updatetime like '%$keyword%' OR id_akses like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE kategori='Oksigen' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE (kategori='Oksigen') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_sirs_online_task = $data['id_sirs_online_task'];
                            $tanggal= $data['tanggal'];
                            $updatetime= $data['updatetime'];
                            $kategori= $data['kategori'];
                            $id_akses= $data['id_akses'];
                            //Format Tanggal Daftar
                            $strtotime = strtotime($tanggal);
                            $TanggalLaporan=date('d/m/Y',$strtotime);
                            //Update Time
                            $UpdateTime=date('d/m/Y H:i',$updatetime);
                            //Buka Data SIRS Online
                            $JumlahData=0;
                            $response_sisrs_online=DataOksigenSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$tanggal);
                            if(!empty($response_sisrs_online)){
                                $php_array = json_decode($response_sisrs_online, true);
                                $DataAntrianSirsOnline=$php_array['Oksigenasi'];
                                foreach ($DataAntrianSirsOnline as $item) {
                                    if(!empty($item['tanggal'])){
                                        $JumlahData=$JumlahData+1;
                                    }else{
                                        $JumlahData=$JumlahData+0;
                                    }
                                }
                            }else{
                                $JumlahData=$JumlahData+0;
                            }
                            if(!empty($JumlahData)){
                                $status='<label class="label label-success">Sudah Upload</label>';
                            }else{
                                $status='<label class="label label-danger">Belum Upload</label>';
                            }
                            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                    ?>
                        <tr class="table-light">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left">
                                <a href="javascript:void(0);" class="text-success" title="Detail Laporan Oksigen Dari SIRS Online" data-toggle="modal" data-target="#ModalDetailOksigenSirsOnline" data-id="<?php echo $tanggal; ?>">
                                    <?php echo "$TanggalLaporan";?>
                                </a>
                            </td>
                            <td class="" align="left"><?php echo "$UpdateTime";?></td>
                            <td class="" align="left"><?php echo "$NamaPetugas";?></td>
                            <td class="" align="center"><?php echo "$status";?></td>
                            <td class="" align="center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-info" title="Detail Laporan Oksigen" data-toggle="modal" data-target="#ModalDetailOksigen" data-id="<?php echo $id_sirs_online_task; ?>">
                                        <i class="ti-info-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" title="Edit Laporan Oksigen" data-toggle="modal" data-target="#ModalEditOksigen" data-id="<?php echo $id_sirs_online_task; ?>">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus Laporan Oksigen" data-toggle="modal" data-target="#ModalHapusOksigen" data-id="<?php echo $id_sirs_online_task; ?>">
                                        <i class="ti ti-close"></i>
                                    </button>
                                </div>
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