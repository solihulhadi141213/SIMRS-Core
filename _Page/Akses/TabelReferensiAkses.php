<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['keyword_referensi'])){
        $keyword=$_POST['keyword_referensi'];
    }else{
        $keyword="";
    }
    //keyword_by
    if(!empty($_POST['keyword_by_referensi'])){
        $keyword_by=$_POST['keyword_by_referensi'];
    }else{
        $keyword_by="";
    }
    //batas
    if(!empty($_POST['batas_referensi'])){
        $batas=$_POST['batas_referensi'];
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
        $OrderBy="id_akses_ref";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ref"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ref WHERE nama_fitur like '%$keyword%' OR kategori like '%$keyword%' OR kode like '%$keyword%' OR keterangan like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ref"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ref WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas_referensi').val();
        var keyword=$('#keyword_referensi').val();
        var keyword_by=$('#keyword_by_referensi').val();
        //Menempelkan Nilai Page Pada Form Page
        $('#PutPageReferensi').val(valueNext);
        $.ajax({
            url     : "_Page/Akses/TabelReferensiAkses.php",
            method  : "POST",
            data 	:  { page: valueNext, batas_referensi: batas, keyword_referensi: keyword, keyword_by_referensi: keyword_by },
            success: function (data) {
                $('#MenampilkanTabelReferensiAkses').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas_referensi').val();
        var keyword=$('#keyword_referensi').val();
        var keyword_by=$('#keyword_by_referensi').val();
        //Menempelkan Nilai Page Pada Form Page
        $('#PutPageReferensi').val(ValuePrev);
        $.ajax({
            url     : "_Page/Akses/TabelReferensiAkses.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas_referensi: batas, keyword_referensi: keyword, keyword_by_referensi: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelReferensiAkses').html(data);
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
            var batas=$('#batas_referensi').val();
            var keyword=$('#keyword_referensi').val();
            var keyword_by=$('#keyword_by_referensi').val();
            //Menempelkan Nilai Page Pada Form Page
            $('#PutPageReferensi').val(PageNumber);
            $.ajax({
                url     : "_Page/Akses/TabelReferensiAkses.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas_referensi: batas, keyword_referensi: keyword, keyword_by_referensi: keyword_by },
                success: function (data) {
                    $('#MenampilkanTabelReferensiAkses').html(data);
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
                    <th class="text-center"><dt>NO</dt></th>
                    <th class="text-center"><dt>FITUR</dt></th>
                    <th class="text-center"><dt>KATEGORI</dt></th>
                    <th class="text-center"><dt>KODE</dt></th>
                    <th class="text-center"><dt>AKSES</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="5" class="text-center">';
                        echo '      Belum Ada Data Referensi Fitur Akses';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses_ref ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses_ref WHERE nama_fitur like '%$keyword%' OR kategori like '%$keyword%' OR kode like '%$keyword%' OR keterangan like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses_ref ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses_ref WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_akses_ref= $data['id_akses_ref'];
                            $nama_fitur= $data['nama_fitur'];
                            $kategori= $data['kategori'];
                            $kode= $data['kode'];
                            $keterangan= $data['keterangan'];
                            //Hitung berapa user yang memperoleh akses fitur ini
                            $JumlahAksesUser = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_acc WHERE id_akses_ref='$id_akses_ref' AND status='Yes'"));
                ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailReferensiFitur" data-id="<?php echo "$id_akses_ref";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo $no;?></td>
                            <td class="" align="left">
                                <?php 
                                    echo "<dt><i class='ti ti-check-box'></i> $nama_fitur</dt>";
                                    echo "<small class='text-muted'><i class='ti ti-info-alt'></i> $keterangan</small>";
                                ?>
                            </td>
                            <td class="" align="left"><?php echo "<i class='ti ti-tag'></i> $kategori";?></td>
                            <td class="" align="left"><?php echo '<span class="badge badge-inverse">'.$kode.'</span>';?></td>
                            <td class="" align="left"><?php echo "<i class='ti ti-user'></i> $JumlahAksesUser Ijin User";?></td>
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
<div class="card-footer text-left">
    <div class="btn-group">
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
    </div>
</div>