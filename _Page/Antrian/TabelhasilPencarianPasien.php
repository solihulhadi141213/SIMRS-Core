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
    //batas
    $batas="10";
    $ShortBy="DESC";
    $OrderBy="id_pasien";
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
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPagePasien').click(function() {
        var valueNext=$('#NextPagePasien').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $('#HasilPencarianPasien').html('Loading...');
        $.ajax({
            url     : "_Page/Antrian/TabelhasilPencarianPasien.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#HasilPencarianPasien').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPagePasien').click(function() {
        var ValuePrev = $('#PrevPagePasien').val();
        var batas=$('#batas').val();
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $('#HasilPencarianPasien').html('Loading...');
        $.ajax({
            url     : "_Page/Antrian/TabelhasilPencarianPasien.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#HasilPencarianPasien').html(data);
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
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $('#HasilPencarianPasien').html('Loading...');
            $.ajax({
                url     : "_Page/Antrian/TabelhasilPencarianPasien.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#HasilPencarianPasien').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="table table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><dt>No</dt></th>
                        <th class="text-center"><dt>Pasien</dt></th>
                        <th class="text-center"><dt>NIK/Kartu</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td class="text-center text-danger" colspan="3">';
                            echo '      Tidak Ada Data Pasien Yang Ditampilkan!';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_pasien= $data['id_pasien'];
                                $noRm=sprintf("%07d", $id_pasien);
                                $gender= $data['gender'];
                                $status= $data['status'];
                                if(!empty($data['nama'])){
                                    $nama= $data['nama'];
                                }else{
                                    $nama="Tidak Ada";
                                }
                                if(!empty($data['nik'])){
                                    $nik= $data['nik'];
                                }else{
                                    $nik='<i class="text-danger">Tidak ADa</i>';
                                }
                                if(!empty($data['no_bpjs'])){
                                    $no_bpjs= $data['no_bpjs'];
                                }else{
                                    $no_bpjs='<i class="text-danger">Tidak ADa</i>';
                                }
                                echo '<tr>';
                                echo '  <td class="text-center">'.$no.'</td>';
                                echo '  <td class="text-left">';
                                echo '      <dt>';
                                echo '          <a href="index.php?Page=Antrian&Sub=TambahAntrian&id='.$id_pasien.'" class="text-primary">'.$nama.'</a>';
                                echo '      </dt>';
                                echo '      No.RM: '.$id_pasien.'';
                                echo '  </td>';
                                echo '  <td class="text-left">';
                                echo '      <dt>NIK. '.$nik.'</dt>';
                                echo '      BPJS: '.$no_bpjs.'';
                                echo '  </td>';
                                echo '</tr>';
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
<div class="row">
    <div class="col-md-12 text-center">
        <div class="btn-group">
            <a href="javascript:void(0);" class="b-b-primary text-primary">
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
                            echo '<button type="button" class="btn btn-sm btn-info" id="PageNumberPasien'.$i.'" value="'.$i.'">';
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
            </a>
        </div>
    </div>
</div>