<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    $batas="10";
    $ShortBy="DESC";
    $OrderBy="nama";
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_practitioner"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_practitioner WHERE id_ihs_practitioner like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR nik like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPagePractitioner').click(function() {
        var valueNext=$('#NextPagePractitioner').val();
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/SirsOnline/ListDataPractitioner.php",
            method  : "POST",
            data 	:  { page: valueNext, keyword: keyword },
            success: function (data) {
                $('#ListDataPractitioner').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPagePractitioner').click(function() {
        var ValuePrev = $('#PrevPagePractitioner').val();
        var keyword="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/SirsOnline/ListDataPractitioner.php",
            method  : "POST",
            data 	:  { page: ValuePrev, keyword: keyword },
            success : function (data) {
                $('#ListDataPractitioner').html(data);
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
        $('#PageNumberPractitioner<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumberPractitioner<?php echo $i;?>').val();
            var keyword="<?php echo "$keyword"; ?>";
            $.ajax({
                url     : "_Page/SirsOnline/ListDataPractitioner.php",
                method  : "POST",
                data 	:  { page: PageNumber, keyword: keyword },
                success: function (data) {
                    $('#ListDataPractitioner').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row mb-3">
    <div class="col-md-12 pre-scrollable bg-light mb-3 mt-3">
        <div class="table table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><dt>Opt</dt></th>
                        <th class="text-center"><dt>Practitioner</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="5" class="text-center">';
                            echo '      Belum Ada Data PCR Nakes!';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner WHERE id_ihs_practitioner like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR nik like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_practitioner= $data['id_practitioner'];
                                $id_ihs_practitioner= $data['id_ihs_practitioner'];
                                $nama= $data['nama'];
                                $nik= $data['nik'];
                                //Cari Apakah id_ihs_practitioner sudah ada?
                                $AdaIdNakes=getDataDetail($Conn,'nakes','ihs',$id_ihs_practitioner,'id_nakes');
                                if(empty($id_nakes)){
                                    $AdaIdNakes=getDataDetail($Conn,'nakes','nik',$nik,'id_nakes');
                                }else{
                                    $AdaIdNakes="";
                                }
                    ?>
                        <tr>
                            <td class="text-center">
                                <?php if(!empty($AdaIdNakes)){ ?>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-secondary">
                                        <i class="ti ti-check-box"></i>
                                    </a>
                                <?php }else{ ?>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalTambahNakes" data-id="id_practitioner-<?php echo "$id_practitioner"; ?>">
                                        <i class="ti ti-check-box"></i>
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-left">
                                <i class="icofont-doctor-alt"></i> <?php echo "$nama"; ?><br>
                                <small>
                                    ID IHS : <?php echo "$id_ihs_practitioner"; ?><br>
                                    NIK : <?php echo "$nik"; ?><br>
                                </small>
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
<div class="row">
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
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPagePractitioner" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumberPractitioner'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberPractitioner'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPagePractitioner" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</div>