<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword_by
    if(!empty($_POST['keyword_by_practitioner'])){
        $keyword_by=$_POST['keyword_by_practitioner'];
    }else{
        $keyword_by="";
    }
    //keyword
    if(!empty($_POST['keyword_practitioner'])){
        $keyword=$_POST['keyword_practitioner'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['batas_practitioner'])){
        $batas=$_POST['batas_practitioner'];
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
        $OrderBy="id_practitioner";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_practitioner"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_practitioner WHERE id_ihs_practitioner like '%$keyword%' OR kategori like '%$keyword%' OR nik like '%$keyword%' OR nama like '%$keyword%' OR gender like '%$keyword%' OR tanggal_lahir like '%$keyword%' OR kontak like '%$keyword%' OR email like '%$keyword%' OR status like '%$keyword%')"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_practitioner"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_practitioner WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
    <script>
        //ketika klik next
        $('#NextPage').click(function() {
            var valueNext=$('#NextPage').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            $('#TabelPractitionerSimrs').html('Loading...');
            $.ajax({
                url     : "_Page/Referensi/TabelPractitionerSimrs.php",
                method  : "POST",
                data 	:  { page: valueNext, batas_practitioner: batas, keyword_by_practitioner: keyword_by, keyword_practitioner: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success: function (data) {
                    $('#TabelPractitionerSimrs').html(data);
                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var ValuePrev = $('#PrevPage').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            $('#TabelPractitionerSimrs').html('Loading...');
            $.ajax({
                url     : "_Page/Referensi/TabelPractitionerSimrs.php",
                method  : "POST",
                data 	:  { page: ValuePrev, batas_practitioner: batas, keyword_by_practitioner: keyword_by, keyword_practitioner: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                success : function (data) {
                    $('#TabelPractitionerSimrs').html(data);
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
                var batas="<?php echo "$batas"; ?>";
                var keyword="<?php echo "$keyword"; ?>";
                var keyword_by="<?php echo "$keyword_by"; ?>";
                var ShortBy="<?php echo "$ShortBy"; ?>";
                var OrderBy="<?php echo "$OrderBy"; ?>";
                $('#TabelPractitionerSimrs').html('Loading...');
                $.ajax({
                    url     : "_Page/Referensi/TabelPractitionerSimrs.php",
                    method  : "POST",
                    data 	:  { page: PageNumber, batas_practitioner: batas, keyword_by_practitioner: keyword_by, keyword_practitioner: keyword, ShortBy: ShortBy, OrderBy: OrderBy },
                    success: function (data) {
                        $('#TabelPractitionerSimrs').html(data);
                    }
                })
            });
        <?php } ?>
    </script>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center"><dt>NO</dt></th>
                        <th class="text-center"><dt>PRACTITIONER</dt></th>
                        <th class="text-center"><dt>KONTAK</dt></th>
                        <th class="text-center"><dt>KATEGORI</dt></th>
                        <th class="text-center"><dt>OPTION</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="5" class="text-center text-danger">Tidak Ada Data Practitioner Yang Ditampilkan</td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword_by)){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner WHERE id_ihs_practitioner like '%$keyword%' OR kategori like '%$keyword%' OR nik like '%$keyword%' OR nama like '%$keyword%' OR gender like '%$keyword%' OR tanggal_lahir like '%$keyword%' OR kontak like '%$keyword%' OR email like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner  WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_practitioner= $data['id_practitioner'];
                                $kategori= $data['kategori'];
                                $nama= $data['nama'];
                                $gender= $data['gender'];
                                $status= $data['status'];
                                if($status=="Aktif"){
                                    $LabelStatus='<i class="icofont-check-circled"></i> Aktif';
                                }else{
                                    $LabelStatus='<i class="icofont-close-line-circled"></i> Tidak Aktif';
                                }
                                if($gender=="male"){
                                    $LabelGender='<i class="icofont-male"></i> Male';
                                }else{
                                    $LabelGender='<i class="icofont-female"></i> Female';
                                }
                    ?>
                            <tr>
                                <td align="center"><?php echo "$no";?></td>
                                <td align="left">
                                    <?php 
                                        echo '<dt title="Nama Practitioner"><i class="icofont-doctor" title="Nama Practitioner"></i> '.$nama.'</dt>';
                                        if(!empty($data['id_ihs_practitioner'])){
                                            $id_ihs_practitioner= $data['id_ihs_practitioner'];
                                            echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailPractitionerById" data-id="'.$id_ihs_practitioner.'" title="ID IHS Practitioner">';
                                            echo '  <small class="text-info" title="ID IHS Practitioner"><i class="icofont-id-card"></i> '.$id_ihs_practitioner.'</small>';
                                            echo '</a><br>';
                                        }else{
                                            echo '  <small class="text-danger" title="ID IHS Practitioner"><i class="icofont-id-card"></i> Tidak Ada</small><br>';
                                        }
                                        if(!empty($data['nik'])){
                                            $nik= $data['nik'];
                                            echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailPractitionerByNik" data-id="'.$nik.'" title="ID IHS Practitioner">';
                                            echo '  <small class="text-info" title="Nik Practitioner"><i class="icofont-card"></i> '.$nik.'</small>';
                                            echo '</a>';
                                        }else{
                                            echo '  <small class="text-danger" title="Nik Practitioner"><i class="icofont-card"></i> Tidak Ada</small>';
                                        }
                                    ?>
                                </td>
                                <td align="left">
                                    <?php 
                                        if(!empty($data['kontak'])){
                                            $kontak= $data['kontak'];
                                            echo '<dt title="Nomor Kontak"><i class="icofont-phone-circle"></i> '.$kontak.'</dt>';
                                        }else{
                                            echo '<dt class="text-danger" title="Nomor Kontak"><i class="icofont-phone-circle"></i> Tidak Ada</dt>';
                                        }
                                        if(!empty($data['email'])){
                                            $email= $data['email'];
                                            echo '<small class="text-mutted" title="Alamat Email"><i class="icofont-email"></i> '.$email.'</small><br>';
                                        }else{
                                            echo '<small class="text-danger" title="Alamat Email"><i class="icofont-email"></i> Tidak Ada</small><br>';
                                        }
                                        if(!empty($data['tanggal_lahir'])){
                                            $tanggal_lahir= $data['tanggal_lahir'];
                                            echo '<small class="text-mutted" title="Tanggal Lahir"><i class="icofont-heart-beat"></i> '.$tanggal_lahir.'</small>';
                                        }else{
                                            echo '<small class="text-danger" title="Tanggal Lahir"><i class="icofont-heart-beat"></i> Tidak Ada</small>';
                                        }
                                        
                                    ?>
                                </td>
                                <td align="left">
                                    <?php 
                                        echo '<dt title="Kategori Practitioner"><i class="icofont-bandage"></i> '.$kategori.'</dt>';
                                        echo '<small class="text-mutted" title="Status Practitioner">'.$LabelStatus.'</small><br>';
                                        echo '<small class="text-mutted" title="Jenis Kelamin">'.$LabelGender.'</small>';
                                    ?>
                                </td>
                                <td align="center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalEditPractitioner" data-id="<?php echo $id_practitioner; ?>" title="Edit Practitioner">
                                            <i class="icofont-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalHapusPractitioner" data-id="<?php echo $id_practitioner; ?>" title="Hapus Practitioner">
                                            <i class="icofont-close-line-circled"></i>
                                        </button>
                                    </div>
                                </td>
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