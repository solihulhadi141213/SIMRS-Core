<?php
    //koneksi dan session
    ini_set("display_errors","off");
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
        $OrderBy="id_akses";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE email like '%$keyword%' OR nama like '%$keyword%' OR akses like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/Akses/TabelAkses.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#MenampilkanTabelAkses').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/Akses/TabelAkses.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelAkses').html(data);
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
                url     : "_Page/Akses/TabelAkses.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#MenampilkanTabelAkses').html(data);
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
                        <dt>Nama</dt>
                    </th>
                    <th class="text-center">
                        <dt>Email & Kontak</dt>
                    </th>
                    <th class="text-center">
                        <dt>Akses</dt>
                    </th>
                    <th class="text-center">
                        <dt>Pengajuan</dt>
                    </th>
                    <th class="text-center">
                        <dt>Updatetime</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td class="text-center" colspan="6" align="center">';
                        echo '      Belum Ada Data Akses!';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses WHERE username like '%$keyword%' OR email like '%$keyword%' OR nama like '%$keyword%' OR akses like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM akses ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM akses WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_akses= $data['id_akses'];
                            $tanggal= $data['tanggal'];
                            $nama= $data['nama'];
                            $email= $data['email'];
                            $kontak= $data['kontak'];
                            $password= $data['password'];
                            $akses= $data['akses'];
                            $gambar= $data['gambar'];
                            $updatetime= $data['updatetime'];
                            //Format Tanggal
                            $strtotime=strtotime($tanggal);
                            $TanggalFormat=date('d/m/Y H:i',$strtotime);
                            //Updatetime Format
                            $strtotime2=strtotime($updatetime);
                            $UpdatetimeFormat=date('d/m/Y',$strtotime2);
                            $UpdatetimeJamFormat=date('H:i T',$strtotime2);
                            //Cek Akses Acc
                            $JumlahAcc = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_acc WHERE id_akses='$id_akses'"));
                            $JumlahAccYes = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_acc WHERE id_akses='$id_akses' AND status='Yes'"));
                            //Buka data pengajuan akses
                            $id_akses_pengajuan=getDataDetail($Conn,'akses_pengajuan','email',$email,'id_akses_pengajuan');
                            $StatusPengajuan=getDataDetail($Conn,'akses_pengajuan','email',$email,'status');
                            if(empty($id_akses_pengajuan)){
                                $LabelPengajuan='<i class="ti ti-close"></i> Tidak Ada';
                            }else{
                                $LabelPengajuan='<i class="ti ti-check"></i> Tersedia';
                            }
                            if(empty($StatusPengajuan)){
                                $LabelStatusPengajuan='<span class="text-dark"><i class="ti ti-more"></i> Tidak Ada</span>';
                            }else{
                                if($StatusPengajuan=="Pending"){
                                    $LabelStatusPengajuan='<span class="text-dark"><i class="ti ti-reload"></i> Pending</span>';
                                }else{
                                    if($StatusPengajuan=="Diterima"){
                                        $LabelStatusPengajuan='<span class="text-success"><i class="ti ti-check"></i> Diterima</span>';
                                    }else{
                                        if($StatusPengajuan=="Ditolak"){
                                            $LabelStatusPengajuan='<span class="text-danger"><i class="ti ti-close"></i> Ditolak</span>';
                                        }else{
                                            $LabelStatusPengajuan='<span class="text-dark"><i class="ti ti-more"></i> Tidak Ada</span>';
                                        }
                                    }
                                }
                            }
                            
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailAkses" data-id="<?php echo "$id_akses,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi,$keyword_by";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo $no;?></td>
                            <td class="" align="left">
                                <?php 
                                    echo '<dt><i class="ti ti-user"></i> '.$nama.'</dt>';
                                    echo '<small class="text-muted"><i class="ti ti-calendar"></i> '.$TanggalFormat.'</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo '<dt><i class="icofont-phone"></i> '.$kontak.'</dt>';
                                    echo '<small class="text-muted"><i class="ti ti-email"></i> '.$email.'</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo '<dt><i class="icofont-tag"></i> '.$akses.'</dt>';
                                    echo '<small class="text-muted"><i class="ti ti-check"></i> '.$JumlahAccYes.'/'.$JumlahAcc.' Fitur</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo '<dt>'.$LabelPengajuan.'</dt>';
                                    echo '<small>'.$LabelStatusPengajuan.'</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo '<dt><i class="ti ti-calendar"></i> '.$UpdatetimeFormat.'</dt>';
                                    echo '<small class="text-muted"><i class="icofont-clock-time"></i> '.$UpdatetimeJamFormat.'</small>';
                                ?>
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