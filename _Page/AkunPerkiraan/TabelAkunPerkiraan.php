<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
    //ShortBy
    $ShortBy="ASC";
    //OrderBy
    $OrderBy="kode";
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan"));
        $QryMaksimum=mysqli_query($Conn, "SELECT max(level) as level_akun FROM akun_perkiraan")or die(mysqli_error($Conn));
        while($HasilMaksimum=mysqli_fetch_array($QryMaksimum)){
            $LevelMaksimum=$HasilMaksimum['level_akun'];
        }
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kode like '%$keyword%' OR nama like '%$keyword%'"));
        $QryMaksimum=mysqli_query($Conn, "SELECT max(level) as level_akun FROM akun_perkiraan WHERE kode like '%$keyword%' OR nama like '%$keyword%'")or die(mysqli_error($Conn));
        while($HasilMaksimum=mysqli_fetch_array($QryMaksimum)){
            $LevelMaksimum=$HasilMaksimum['level_akun'];
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/AkunPerkiraan/TabelAkunPerkiraan.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#MenampilkanTabelAkunPerkiraan').html(data);
                $('#page').val(valueNext);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/AkunPerkiraan/TabelAkunPerkiraan.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelAkunPerkiraan').html(data);
                $('#page').val(ValuePrev);
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
            var batas=$('#batas').val();
            var keyword=$('#keyword').val();
            $.ajax({
                url     : "_Page/AkunPerkiraan/TabelAkunPerkiraan.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#MenampilkanTabelAkunPerkiraan').html(data);
                    $('#page').val(PageNumber);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-block">
    <div class="table table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" colspan="<?php echo "$LevelMaksimum"; ?>"><dt>Akun</dt></th>
                    <th class="text-center"><dt>Account</dt></th>
                    <th class="text-center"><dt>Saldo</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="4" class="text-center text-danger">';
                        echo '      Tidak ada data akun perkiraan yang ditampilkan.';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kode like '%$keyword%' OR nama like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_perkiraan= $data['id_perkiraan'];
                            $kode= $data['kode'];
                            $nama= $data['nama'];
                            $name= $data['name'];
                            $level= $data['level'];
                            $rank= $data['rank'];
                            $saldo_normal= $data['saldo_normal'];
                            if($saldo_normal=="Debet"){
                                $LabelSaldoNormal='<label class="label label-primary">Debet</label>';
                                $BgText='text-primary';
                            }else{
                                $LabelSaldoNormal='<label class="label label-danger">Kredit</label>';
                                $BgText='text-danger';
                            }
                            //Hitung Anak
                            if($level=='1'){
                                $JumlahAnak="2";
                            }else{
                                $JumlahAnak= mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE kd$level='$kode' AND level>'$level'"));
                            }
                            //Hitung Colspan
                            $LevelMin=$level-1;
                            $ColpanData=$LevelMaksimum-$LevelMin;
                ?>
                    <tr>
                        <?php
                            //Kolom Kosong
                            if(!empty($LevelMin)){
                                for ( $z=1; $z<=$LevelMin; $z++ ){
                                    echo '<td></td>';
                                }
                            }
                        ?>
                        <td class="text-left" colspan="<?php echo $ColpanData; ?>">
                            <a href="javascript:void(0);" class="<?php echo $BgText;?>" data-toggle="modal" data-target="#ModalDetailAkunPerkiraan" data-id="<?php echo "$id_perkiraan";?>" title="Detail Akun Perkiraan">
                                <?php
                                    if(!empty($JumlahAnak)){
                                        echo '<dt>'.$kode.'. '.$nama.'</dt>';
                                    }else{
                                        echo ''.$kode.'. '.$nama.'';
                                    }
                                ?>
                            </a>
                        </td>
                        <td class="text-left">
                            <?php
                                if(!empty($JumlahAnak)){
                                    echo '<dt>'.$name.'</dt>';
                                }else{
                                    echo ''.$name.'';
                                }
                            ?>
                        </td>
                        <td class="text-center"><?php echo ''.$LabelSaldoNormal.'';?></td>
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
<div class="card-footer text-center">
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPage" value="<?php echo $prev;?>">
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
                    echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumber'.$i.'" value="'.$i.'">';
                }else{
                    echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumber'.$i.'" value="'.$i.'">';
                }
                echo ''.$i.'';
                echo '</button>';
            }
        ?>
        <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPage" value="<?php echo $next;?>">
            <i class="ti-angle-right"></i>
        </button>
    </div>
</div>
