<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['keyword_entitas'])){
        $keyword=$_POST['keyword_entitas'];
    }else{
        $keyword="";
    }
    //keyword_by
    if(!empty($_POST['keyword_by_entitas'])){
        $keyword_by=$_POST['keyword_by_entitas'];
    }else{
        $keyword_by="";
    }
    //batas
    if(!empty($_POST['batas_entitas'])){
        $batas=$_POST['batas_entitas'];
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
        $OrderBy="id_akses_entitas";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE akses like '%$keyword%' OR deskripsi like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas_entitas').val();
        var keyword=$('#keyword_entitas').val();
        var keyword_by=$('#keyword_by_entitas').val();
        $.ajax({
            url     : "_Page/Akses/TabelEntitas.php",
            method  : "POST",
            data 	:  { page: valueNext, batas_entitas: batas, keyword_entitas: keyword, keyword_by_entitas: keyword_by },
            success: function (data) {
                $('#MenampilkanTabelEntitas').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas_entitas').val();
        var keyword=$('#keyword_entitas').val();
        var keyword_by=$('#keyword_by_entitas').val();
        $.ajax({
            url     : "_Page/Akses/TabelEntitas.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas_entitas: batas, keyword_entitas: keyword, keyword_by_entitas: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelEntitas').html(data);
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
            var batas=$('#batas_entitas').val();
            var keyword=$('#keyword_entitas').val();
            var keyword_by=$('#keyword_by_entitas').val();
            $.ajax({
                url     : "_Page/Akses/TabelEntitas.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas_entitas: batas, keyword_entitas: keyword, keyword_by_entitas: keyword_by },
                success: function (data) {
                    $('#MenampilkanTabelEntitas').html(data);
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
                    <th class="text-center"><dt>AKSES</dt></th>
                    <th class="text-center"><dt>DESKRIPSI</dt></th>
                    <th class="text-center"><dt>FITUR</dt></th>
                    <th class="text-center"><dt>USER</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="5" class="text-center">';
                        echo '      Belum Ada Data Entitas Akses';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses_entitas ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE akses like '%$keyword%' OR deskripsi like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses_entitas ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_akses_entitas= $data['id_akses_entitas'];
                            $akses= $data['akses'];
                            $deskripsi= $data['deskripsi'];
                            $standar_referensi= $data['standar_referensi'];
                            //Hitung berapa user menggunakan akses ini
                            $JumlahUser = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE akses='$akses'"));
                            //Decode data json
                            if(!empty($data['standar_referensi'])){
                                $JsonData = json_decode($standar_referensi,true);
                                $string=count($JsonData);
                                $JumlahFitur=0;
                                for($i=0; $i<$string; $i++){
                                    $id_akses_ref=$JsonData[$i]['id_akses_ref'];
                                    $StatusItem=$JsonData[$i]['status'];
                                    if($StatusItem=="Yes"){
                                        $JumlahFitur=$JumlahFitur+1;
                                    }else{
                                        $JumlahFitur=$JumlahFitur+0;
                                    }
                                }
                            }else{
                                $JsonData ="";
                                $JumlahFitur =0;
                            }
                            if(empty($JumlahUser)){
                                $LabelJumlahUser='<span class="text-danger">0 Orang</span>';
                            }else{
                                $LabelJumlahUser='<span class="text-success">'.$JumlahUser.' Orang</span>';
                            }
                            if(empty($JumlahFitur)){
                                $LabelJumlahFitur='<span class="text-danger">0 Fitur</span>';
                            }else{
                                $LabelJumlahFitur='<span class="text-success">'.$JumlahFitur.' Fitur</span>';
                            }
                ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailEntitas" data-id="<?php echo "$id_akses_entitas,$keyword_by,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo $no;?></td>
                            <td class="" align="left"><?php echo "$akses";?></td>
                            <td class="" align="left"><?php echo "$deskripsi";?></td>
                            <td class="" align="center"><?php echo "$LabelJumlahFitur";?></td>
                            <td class="" align="center"><?php echo "$LabelJumlahUser";?></td>
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