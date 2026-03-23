<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //keyword
    if(!empty($_POST['PeriodeLogNakesTerinfeksi'])){
        $keyword=$_POST['PeriodeLogNakesTerinfeksi'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="2";
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
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM sirs_online_task  WHERE kategori='Nakes Terinfeksi'"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE kategori='Nakes Terinfeksi' AND tanggal like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPageLog').click(function() {
        var valueNext=$('#NextPageLog').val();
        var batas="<?php echo $batas; ?>";
        var keyword="<?php echo $keyword; ?>";
        $.ajax({
            url     : "_Page/SirsOnlineNakesTerinfeksi/TabelLogNakesTerinfeksi.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, PeriodeLogNakesTerinfeksi: keyword },
            success: function (data) {
                $('#MenampilkanTabelLogNakesTerinfeksi').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageLog').click(function() {
        var ValuePrev = $('#PrevPageLog').val();
        var batas="<?php echo $batas; ?>";
        var keyword="<?php echo $keyword; ?>";
        $.ajax({
            url     : "_Page/SirsOnlineNakesTerinfeksi/TabelLogNakesTerinfeksi.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, PeriodeLogNakesTerinfeksi: keyword },
            success : function (data) {
                $('#MenampilkanTabelLogNakesTerinfeksi').html(data);
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
        $('#PageNumberLog<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumber<?php echo $i;?>').val();
            var batas="<?php echo $batas; ?>";
            var keyword="<?php echo $keyword; ?>";
            $.ajax({
                url     : "_Page/SirsOnlineNakesTerinfeksi/TabelLogNakesTerinfeksi.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, PeriodeLogNakesTerinfeksi: keyword },
                success: function (data) {
                    $('#MenampilkanTabelLogNakesTerinfeksi').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row mb-3">
    <div class="col-md-12">
        <div class="table table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><dt>No</dt></th>
                        <th class="text-center"><dt>Tanggal</dt></th>
                        <th class="text-center"><dt>Petugas Entry</dt></th>
                        <th class="text-center"><dt>Detail</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="5" class="text-center">';
                            echo '      Belum Ada Data Laporan Nakes Terinfeksi!';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE kategori='Nakes Terinfeksi' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE kategori='Nakes Terinfeksi' AND tanggal like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_sirs_online_task = $data['id_sirs_online_task'];
                                $tanggal = $data['tanggal'];
                                $id_akses = $data['id_akses'];
                                //Mendefinisikan id_akses
                                $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                                //Format Tanggal
                                $strtotime1=strtotime($tanggal);
                                $FormatTanggal1=date('d/m/Y',$strtotime1);
                    ?>
                        <tr>
                            <td class="text-center"><?php echo "$no"; ?></td>
                            <td class="text-left"><?php echo "$FormatTanggal1"; ?></td>
                            <td class="text-left"><?php echo "$NamaPetugas"; ?></td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-sm btn-info" title="Detail Log Laporan Nakes Terinfeksi"  data-toggle="modal" data-target="#ModalDetailLaporanNakesTerinfeksi" data-id="<?php echo "$id_sirs_online_task"; ?>">
                                    <i class="ti ti-info-alt"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php
                            $no++; }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 text-center">
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
                <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPageLog" value="<?php echo $prev;?>">
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
                            echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumberLog'.$i.'" value="'.$i.'">';
                        }else{
                            echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberLog'.$i.'" value="'.$i.'">';
                        }
                        echo ''.$i.'';
                        echo '</button>';
                    }
                ?>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPageLog" value="<?php echo $next;?>">
                    <i class="ti-angle-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>