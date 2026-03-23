<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['KeywordPasien'])){
        $keyword=$_POST['KeywordPasien'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="20";
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
        $OrderBy="id_pasien";
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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nama like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPagePasien').click(function() {
        var valueNext=$('#NextPagePasien').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Laboratorium/TabelPasien.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#TabelPasien').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPagePasien').click(function() {
        var ValuePrev = $('#PrevPagePasien').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Laboratorium/TabelPasien.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#TabelPasien').html(data);
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
        $('#PageNumberPasien<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumberPasien<?php echo $i;?>').val();
            var batas=$('#batas').val();
            var keyword="<?php echo "$keyword"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Laboratorium/TabelPasien.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#TabelPasien').html(data);
                }
            })
        });
    <?php } ?>
</script>

<div class="col-md-12 mb-3 pre-scrollable">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th id="" class="text-center">
                        <dt>NO</dt>
                    </th>
                    <th id="" class="text-center">
                        <dt>RM</dt>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <dt>PASIEN</dt>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <dt>NIK/BPJS</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td class="text-danger text-center" colspan="4">';
                        echo '      Tidak Ada Data Pasien Yang Ditampilkan';
                        echo '  </td>';
                        echo '</tr>';
                    }
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_pasien= $data['id_pasien'];
                        if(empty($data['nik'])){
                            $nik='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $nik= $data['nik'];
                        }
                        if(empty($data['no_bpjs'])){
                            $no_bpjs='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $no_bpjs= $data['no_bpjs'];
                        }
                        $nama= $data['nama'];
                        if(empty($data['desa'])){
                            $desa='<span class="text-danger">None</span>';
                        }else{
                            $desa= $data['desa'];
                        }
                        if(empty($data['kecamatan'])){
                            $kecamatan='<span class="text-danger">None</span>';
                        }else{
                            $kecamatan= $data['kecamatan'];
                        }
                ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalKonfirmasiPilihPasien" data-id="<?php echo "$id_pasien";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left"><?php echo "$id_pasien";?></td>
                            <td class="" align="left">
                                <?php
                                    echo '<span>'.$nama.'</span><br>';
                                    echo '<small class="text-muted">Ds.'.$desa.' - Kec.'.$kecamatan.'</small><br>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<span>NIK.'.$nik.'</span><br>';
                                    echo '<small class="text-muted">BPJS.'.$no_bpjs.'</small><br>';
                                ?>
                            </td>
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
<div class="col-md-12 mt-3 mb-3 text-center">
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPagePasien" value="<?php echo $prev;?>">
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
                    echo '<button type="button" class="btn btn-sm btn-secondary" id="PageNumberPasien'.$i.'" value="'.$i.'">';
                }else{
                    echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberPasien'.$i.'" value="'.$i.'">';
                }
                echo ''.$i.'';
                echo '</button>';
            }
        ?>
        <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPagePasien" value="<?php echo $next;?>">
            <i class="ti-angle-right"></i>
        </button>
    </div>
</div>