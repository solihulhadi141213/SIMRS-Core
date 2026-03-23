<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //keyword
    if(!empty($_POST['keyword_nakes_untuk_pcr'])){
        $keyword=$_POST['keyword_nakes_untuk_pcr'];
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
        $OrderBy="id_nakes";
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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE id_nakes like '%$keyword%' OR nik like '%$keyword%' OR kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR referensi_sdm like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPageNakesUntukPcr').click(function() {
        var valueNext=$('#NextPageNakesUntukPcr').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/SirsOnline/TabelNakesUntukPcr.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword_nakes_untuk_pcr: keyword },
            success: function (data) {
                $('#TabelNakesUntukPcr').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageNakesUntukPcr').click(function() {
        var ValuePrev = $('#PrevPageNakesUntukPcr').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/SirsOnline/TabelNakesUntukPcr.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas: batas, keyword_nakes_untuk_pcr: keyword },
            success : function (data) {
                $('#TabelNakesUntukPcr').html(data);
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
        $('#PageNumberNakesUntukPcr<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumberNakesUntukPcr<?php echo $i;?>').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            $.ajax({
                url     : "_Page/SirsOnline/TabelNakesUntukPcr.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword_nakes_untuk_pcr: keyword },
                success: function (data) {
                    $('#TabelNakesUntukPcr').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row">
    <div class="col-md-12 pre-scrollable">
        <div class="table table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><dt>Pilih</dt></th>
                        <th class="text-center"><dt>Kode</dt></th>
                        <th class="text-center"><dt>Nama</dt></th>
                        <th class="text-center"><dt>Kategori</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="5" class="text-center">';
                            echo '      Belum Ada Data Nakes!';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM nakes ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM nakes WHERE id_nakes like '%$keyword%' OR nik like '%$keyword%' OR kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR referensi_sdm like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_nakes= $data['id_nakes'];
                                $kode= $data['kode'];
                                $nama= $data['nama'];
                                $kategori= $data['kategori'];
                    ?>
                        <tr>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#ModalTambahHasilPcrNakes" data-id="<?php echo "$id_nakes"; ?>">
                                    <i class="ti ti-check"></i>
                                </a>
                            </td>
                            <td class="text-left"><?php echo "$kode"; ?></td>
                            <td class="text-left"><?php echo "$nama"; ?></td>
                            <td class="text-left"><?php echo "$kategori"; ?></td>
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
<div class="row">
    <div class="col-md-12 text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPageNakesUntukPcr" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumberNakesUntukPcr'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberNakesUntukPcr'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPageNakesUntukPcr" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</div>