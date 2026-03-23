<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //id_obat_storage
    if(!empty($_POST['id_obat_storage'])){
        $id_obat_storage=$_POST['id_obat_storage'];
    }else{
        $id_obat_storage="0";
    }
    //tanggal
    if(!empty($_POST['tanggal'])){
        $tanggal=$_POST['tanggal'];
    }else{
        $tanggal="";
    }
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //Batas 
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //OrderBy
    if(empty($_POST['id_obat_storage'])){
        $OrderBy='nama';
    }else{
        $OrderBy="nama_obat";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($_POST['id_obat_storage'])){
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM obat"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM obat_posisi WHERE id_obat_storage='$id_obat_storage'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM obat_posisi WHERE id_obat_storage='$id_obat_storage' AND (kode like '%$keyword%' OR nama_obat like '%$keyword%')"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas="<?php echo $batas; ?>";
        var keyword="<?php echo $keyword; ?>";
        var id_obat_storage="<?php echo $id_obat_storage; ?>";
        var tanggal="<?php echo $tanggal; ?>";
        $.ajax({
            url     : "_Page/StokOpename/TableSesiStokOpenameItem.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, id_obat_storage: id_obat_storage, tanggal: tanggal },
            success: function (data) {
                $('#TableSesiStokOpenameItem').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas="<?php echo $batas; ?>";
        var keyword="<?php echo $keyword; ?>";
        var id_obat_storage="<?php echo $id_obat_storage; ?>";
        var tanggal="<?php echo $tanggal; ?>";
        $.ajax({
            url     : "_Page/StokOpename/TableSesiStokOpenameItem.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas: batas, keyword: keyword, id_obat_storage: id_obat_storage, tanggal: tanggal },
            success : function (data) {
                $('#TableSesiStokOpenameItem').html(data);
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
            var batas="<?php echo $batas; ?>";
            var keyword="<?php echo $keyword; ?>";
            var id_obat_storage="<?php echo $id_obat_storage; ?>";
            var tanggal="<?php echo $tanggal; ?>";
            $.ajax({
                url     : "_Page/StokOpename/TableSesiStokOpenameItem.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, id_obat_storage: id_obat_storage, tanggal: tanggal },
                success: function (data) {
                    $('#TableSesiStokOpenameItem').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <div class="row mb-4">
        <div class="col-md-12 table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center"><dt>No</dt></th>
                        <th class="text-center"><dt>Nama/Kode</dt></th>
                        <th class="text-center"><dt>Stok Opename</dt></th>
                        <th class="text-center"><dt>Keterangan</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="5" class="text-center text-danger">Tidak ada data sesi stok opename yang ditampilkan.</td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($_POST['id_obat_storage'])){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT * FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT * FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT * FROM obat_posisi WHERE id_obat_storage='$id_obat_storage' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT * FROM obat_posisi WHERE id_obat_storage='$id_obat_storage' AND (kode like '%$keyword%' OR nama_obat like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_obat= $data['id_obat'];
                                $kode= $data['kode'];
                                if(empty($_POST['id_obat_storage'])){
                                    $nama= $data['nama'];
                                }else{
                                    $nama= $data['nama_obat'];
                                }
                                //Detail Obat
                                $QryObat = mysqli_query($Conn,"SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($Conn));
                                $DataObat = mysqli_fetch_array($QryObat);
                                $satuan=$DataObat['satuan'];
                                //Detail SO
                                $QrySo= mysqli_query($Conn,"SELECT * FROM obat_so WHERE id_obat='$id_obat' AND tanggal='$tanggal' AND id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
                                $DataSo = mysqli_fetch_array($QrySo);
                                if(empty($DataSo['id_obat_so'])){
                                    $id_obat_so="0";
                                    $stok_awal="0";
                                    $stok_akhir="0";
                                    $stok_selisih="0";
                                    $keterangan="";
                                    $harga=$DataObat['harga'];
                                    $updatetime=$DataObat['updatetime'];
                                    //Format RP
                                    $HargaRp = "Rp " . number_format($harga,0,',','.');
                                    //Format Updatetime
                                    $strtotime_updatetime=strtotime($updatetime);
                                    $updatetime=date('d/m/Y H:i T',$updatetime);
                                    echo '<tr class="text-secondary">';
                                    echo '  <td class="text-center">'.$no.'</td>';
                                    echo '  <td class="text-left">';
                                    echo '      <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalTambahSo" data-id="'.$id_obat.','.$id_obat_storage.','.$tanggal.'">';
                                    echo '          <i class="ti ti-plus"></i> '.$nama.'';
                                    echo '      </a><br>';
                                    echo '      <small>Kode: '.$kode.'</small><br>';
                                    echo '      <small>Harga: '.$HargaRp.'</small>';
                                    echo '  </td>';
                                    echo '  <td class="text-left">';
                                    echo '      <span>Awal : '.$stok_awal.' '.$satuan.'</span><br>';
                                    echo '      <small>Akhir : '.$stok_akhir.' '.$satuan.'</small><br>';
                                    echo '      <small>Selisih : '.$stok_selisih.' '.$satuan.'</small>';
                                    echo '  </td>';
                                    echo '  <td class="text-left">';
                                    echo '      <span>'.$updatetime.'</span><br>';
                                    echo '      <small>Keterangan : '.$keterangan.'</small>';
                                    echo '  </td>';
                                    echo '</tr>';
                                }else{
                                    $id_obat_so=$DataSo['id_obat_so'];
                                    $stok_awal=$DataSo['stok_awal'];
                                    $stok_akhir=$DataSo['stok_akhir'];
                                    $stok_selisih=$DataSo['stok_selisih'];
                                    $keterangan=$DataSo['keterangan'];
                                    $updatetime=$DataSo['updatetime'];
                                    $harga=$DataSo['harga'];
                                    //Format Harga
                                    $HargaRp = "Rp " . number_format($harga,0,',','.');
                                    //Format Updatetime
                                    $strtotime_updatetime=strtotime($updatetime);
                                    $updatetime=date('d/m/Y H:i T',$updatetime);
                                    echo '<tr class="text-dark">';
                                    echo '  <td class="text-center">'.$no.'</td>';
                                    echo '  <td class="text-left">';
                                    echo '      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailStokOpenameItem" data-id="'.$id_obat_so.'">';
                                    echo '          <i class="ti ti-info-alt"></i> '.$nama.'';
                                    echo '      </a><br>';
                                    echo '      <small>Kode: '.$kode.'</small><br>';
                                    echo '      <small>Harga: '.$HargaRp.'</small>';
                                    echo '  </td>';
                                    echo '  <td class="text-left">';
                                    echo '      <span>Awal : '.$stok_awal.' '.$satuan.'</span><br>';
                                    echo '      <small>Akhir : '.$stok_akhir.' '.$satuan.'</small><br>';
                                        if($stok_selisih<0){
                                            echo '<small class="text-danger">Selisih : '.$stok_selisih.' '.$satuan.'</small>';
                                        }else{
                                            echo '<small class="text-dark">Selisih : '.$stok_selisih.' '.$satuan.'</small>';
                                        }
                                    echo '  </td>';
                                    echo '  <td class="text-left">';
                                    echo '      <span class="text-dark">'.$updatetime.'</span><br>';
                                    echo '      <small>Keterangan : '.$keterangan.'</small><br>';
                                    if(!empty($stok_selisih)){
                                        //Apabila terdapat selisih maka hitung nilai RP nya
                                        $RpSelisih=$stok_selisih*$harga;
                                        $RpSelisihFormat = "Rp " . number_format($RpSelisih,0,',','.');
                                        //Apabila Selisih Kurang Dari 0 maka merah
                                        if($RpSelisih<0){
                                            echo '      <small class="text-danger">Rp Selisih : '.$RpSelisihFormat.'</small>';
                                        }else{
                                            echo '      <small>Rp Selisih : '.$RpSelisihFormat.'</small>';
                                        }
                                    }
                                    echo '  </td>';
                                    echo '</tr>';
                                }
                                
                                
                                $no++; 
                            }
                        }
                    ?>
                </tbody>
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
<div class="card-footer">
    <div class="row">
        <div class="col-md-12 text-center mb-3">
            <div class="btn-group">
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
            </div>
        </div>
    </div>
</div>