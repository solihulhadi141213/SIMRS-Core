<?php
    //koneksi dan session
    // ini_set("display_errors","off");
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
    if(!empty($_POST['batas_permintaan'])){
        $batas=$_POST['batas_permintaan'];
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
        $OrderBy="id_permintaan";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE nama_dokter like '%$keyword%' OR tanggal like '%$keyword%' OR faskes like '%$keyword%' OR unit like '%$keyword%' OR prioritas like '%$keyword%' OR diagnosis like '%$keyword%' OR keterangan_permintaan like '%$keyword%' OR nama_signature like '%$keyword%' OR status like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE $keyword_by like '%$keyword%'"));
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
        $.ajax({
            url     : "_Page/Laboratorium/TabelPermintaanLaboratorium.php",
            method  : "POST",
            data 	:  { page: valueNext, batas_permintaan: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#TabelPermintaanLaboratorium').html(data);

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
        $.ajax({
            url     : "_Page/Laboratorium/TabelPermintaanLaboratorium.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas_permintaan: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#TabelPermintaanLaboratorium').html(data);
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
            $.ajax({
                url     : "_Page/Laboratorium/TabelPermintaanLaboratorium.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas_permintaan: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#TabelPermintaanLaboratorium').html(data);
                }
            })
        });
    <?php } ?>
</script>

<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt> 
                    </th>
                    <th class="text-center">
                        <dt>DAFTAR</dt> 
                    </th>
                    <th class="text-center">
                        <dt>PASIEN</dt> 
                    </th>
                    <th class="text-center">
                        <dt>KUNJUNGAN</dt> 
                    </th>
                    <th class="text-center">
                        <dt>FASKES/UNIT</dt> 
                    </th>
                    <th class="text-center">
                        <dt>DOKTER</dt> 
                    </th>
                    <th class="text-center">
                        <dt>DURASI</dt> 
                    </th>
                    <th class="text-center">
                        <dt>STATUS</dt> 
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="8" class="text-center">Tidak Ada Data Permintaan Pelayanan Laboratorium</td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE id_pasien like '%$keyword%' OR id_kunjungan like '%$keyword%' OR tujuan like '%$keyword%' OR nama_pasien like '%$keyword%' OR nama_dokter like '%$keyword%' OR status like '%$keyword%' OR prioritas like '%$keyword%' OR unit like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_permintaan= $data['id_permintaan'];
                            $nama_pasien= $data['nama_pasien'];
                            if(empty($data['id_pasien'])){
                                $id_pasien="None";
                            }else{
                                $id_pasien= $data['id_pasien'];
                            }
                            if(empty($data['id_kunjungan'])){
                                $id_kunjungan="None";
                            }else{
                                $id_kunjungan= $data['id_kunjungan'];
                            }
                            if(empty($data['tujuan'])){
                                $tujuan="None";
                            }else{
                                $tujuan= $data['tujuan'];
                            }
                            if(empty($data['id_dokter'])){
                                $id_dokter="";
                            }else{
                                $id_dokter= $data['id_dokter'];
                            }
                            $tanggal= $data['tanggal'];
                            //Fotmat
                            $strtotime=strtotime($tanggal);
                            $Tanggal=date('d/m/Y',$strtotime);
                            $Jam=date('H:i',$strtotime);
                            if(empty($data['nama_dokter'])){
                                $nama_dokter="Tidak Ada";
                            }else{
                                $nama_dokter= $data['nama_dokter'];
                            }
                            if(empty($data['faskes'])){
                                $faskes="None";
                            }else{
                                $faskes= $data['faskes'];
                            }
                            if(empty($data['unit'])){
                                $unit="None";
                            }else{
                                $unit= $data['unit'];
                            }
                            $prioritas= $data['prioritas'];
                            if(empty($data['diagnosis'])){
                                $diagnosis="";
                            }else{
                                $diagnosis= $data['diagnosis'];
                            }
                            if(empty($data['keterangan_permintaan'])){
                                $keterangan_permintaan="";
                            }else{
                                $keterangan_permintaan= $data['keterangan_permintaan'];
                            }
                            if(empty($data['nama_signature'])){
                                $nama_signature="";
                            }else{
                                $nama_signature= $data['nama_signature'];
                            }
                            if(empty($data['signature'])){
                                $signature="";
                            }else{
                                $signature= $data['signature'];
                            }
                            if(empty($data['status'])){
                                $status="None";
                            }else{
                                $status= $data['status'];
                            }
                            if($status=="Pending"){
                                $LabelStatus='<label class="label label-inverse">Pending</label>';
                            }else{
                                if($status=="Diterima"){
                                    $LabelStatus='<label class="label label-success">Diterima</label>';
                                }else{
                                    if($status=="Ditolak"){
                                        $LabelStatus='<label class="label label-danger">Ditolak</label>';
                                    }else{
                                        if($status=="Selesai"){
                                            $LabelStatus='<label class="label label-primary">Selesai</label>';
                                        }else{
                                            $LabelStatus='<label class="label label-dark">None</label>';
                                        }
                                    }
                                }
                            }
                            //Label CITO
                            if($prioritas=="CITO"){
                                $LabelCito='<small class="text-danger"><i class="ti-alert"></i> CITO</small>';
                            }else{
                                $LabelCito='<small class="text-muted">NON CITO</small>';
                            }
                            //Hitung Durasi
                            if($status=="Selesai"){
                                $hasil_diserahkan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'hasil_diserahkan');
                                $pengambilan_sample=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'pengambilan_sample');
                                if(!empty($hasil_diserahkan)){
                                    $strtotime_end  = strtotime($hasil_diserahkan);
                                    $HasilDiserahkan =date('d/m/Y',$strtotime_end);
                                    $HasilDiserahkanJam =date('H:i',$strtotime_end);
                                    $awal  = strtotime($tanggal);
                                    $akhir = strtotime($hasil_diserahkan);
                                    $diff  = $akhir - $awal;
                                    $DurasiJam   = $diff / ( 60 * 60);
                                    $DurasiMenit   = $DurasiJam * 60;
                                    $Durasi ="$DurasiMenit Min";
                                }else{
                                    $strtotime_end  = strtotime($hasil_diserahkan);
                                    $HasilDiserahkan ="None";
                                    $HasilDiserahkanJam ="None";
                                    $Durasi ="0 Min";
                                }
                            }else{
                                $HasilDiserahkan ="None";
                                $HasilDiserahkanJam ="None";
                                $Durasi ="0 Min";
                            }
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailPermintaanLab" data-id="<?php echo "$id_permintaan";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left">
                                <?php 
                                    echo "<i class='ti ti-calendar'></i> $Tanggal<br>";
                                    echo "<small class='text-muted'><i class='ti ti-time'></i> $Jam</small>";
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo "<i class='ti ti-user'></i> $nama_pasien<br>";
                                    echo "<small class='text-muted'><i class='ti-credit-card'></i> RM. $id_pasien</small>";
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo "<i class='ti-ticket'></i> $tujuan<br>";
                                    echo "<small class='text-muted'><i class='ti-credit-card'></i> REG. $id_kunjungan</small>";
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo "<i class='ti ti-home'></i> $faskes<br>";
                                    echo "<small class='text-muted'><i class='ti ti-tag'></i> Unit: $unit</small>";
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo "<i class='icofont-doctor-alt'></i> $nama_dokter<br>";
                                    echo "$LabelCito";
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo "<i class='ti ti-calendar'></i> $HasilDiserahkan<br>";
                                    echo '<small class="text-info"><i class="ti ti-time"></i> '.$HasilDiserahkanJam.' '.$Durasi.'</small>';
                                ?>
                            </td>
                            <td class="" align="center"><?php echo "$LabelStatus";?></td>
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