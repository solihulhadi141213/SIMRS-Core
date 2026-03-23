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
    $batas="10";
    $ShortBy="DESC";
    $OrderBy="id_pasien";
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
    $('#NextPage2').click(function() {
        var valueNext=$('#NextPage2').val();
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/JadwalOperasi/FormDataPasien.php",
            method  : "POST",
            data 	:  { page: valueNext, keyword: keyword},
            success: function (data) {
                $('#FormHasilPencarianPasien').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage2').click(function() {
        var ValuePrev = $('#PrevPage2').val();
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/JadwalOperasi/FormDataPasien.php",
            method  : "POST",
            data 	:  { page: ValuePrev, keyword: keyword},
            success : function (data) {
                $('#FormHasilPencarianPasien').html(data);
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
            var PageNumberPasien = $('#PageNumberPasien<?php echo $i;?>').val();
            var keyword="<?php echo "$keyword"; ?>";
            $.ajax({
                url     : "_Page/JadwalOperasi/FormDataPasien.php",
                method  : "POST",
                data 	:  { page: PageNumberPasien, keyword: keyword},
                success: function (data) {
                    $('#FormHasilPencarianPasien').html(data);
                }
            })
        });
    <?php } ?>
</script>
<?php
    if(empty($jml_data)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Tidak Ada Data pasien Yang Ditemukan';
        echo '  </div>';
        echo '</div>';
    }else{
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
    <div class="row mb-4">
        <div class="col-md-12 pre-scrollable">
            <ol class="list-group">
                <?php
                    $no=1;
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nama like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_pasien= $data['id_pasien'];
                        $nama= $data['nama'];
                        echo '<li class="list-group-item">';
                        echo '  <div class="ms-2 me-auto">';
                        echo '      <a href="index.php?Page=JadwalOperasi&Sub=TambahJadwalOperasi&id_pasien='.$id_pasien.'" class="text-dark">';
                        echo '          '.$no.'. '.$nama.' ('.$id_pasien.')';
                        echo '      </a>';
                        echo '  </div>';
                        echo '</li>';
                        $no++;
                    }
                ?>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="btn-group">
                <a href="javascript:void(0);" class="b-b-primary text-primary">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage2" value="<?php echo $prev;?>">
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
                                echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumberPasien'.$i.'" value="'.$i.'">';
                            }else{
                                echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberPasien'.$i.'" value="'.$i.'">';
                            }
                            echo ''.$i.'';
                            echo '</button>';
                        }
                    ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPage2" value="<?php echo $next;?>">
                        <i class="ti-angle-right"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>
<?php } ?>
