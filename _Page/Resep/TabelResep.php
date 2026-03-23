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
    //Batas 
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="9";
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
        $OrderBy="id_resep";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM resep"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM resep WHERE id_pasien like '%$keyword%' OR id_kunjungan like '%$keyword%' OR nama_pasien like '%$keyword%' OR nama_dokter like '%$keyword%' OR tanggal_entry like '%$keyword%' OR status like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM resep"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM resep WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        var keyword_by=$('#keyword_by').html();
        $.ajax({
            url     : "_Page/Resep/TabelResep.php",
            method  : "POST",
            data 	:  { page: valueNext, Batas: Batas, keyword: keyword, keyword_by: keyword_by },
            success: function (data) {
                $('#TabelResep').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var Keyword=$('#Keyword').val();
        var keyword_by=$('#keyword_by').html();
        $.ajax({
            url     : "_Page/Resep/TabelResep.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#TabelResep').html(data);
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
            var keyword_by=$('#keyword_by').html();
            $.ajax({
                url     : "_Page/Resep/TabelResep.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by },
                success: function (data) {
                    $('#TabelResep').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="row">
    <?php
        if(empty($jml_data)){
            echo '<li class="list-group-item text-center text-danger">';
            echo '  Tidak ada data sesi stok opename yang ditampilkan.';
            echo '</li>';
        }else{
            $no = 1+$posisi;
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT * FROM resep ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT * FROM resep WHERE id_pasien like '%$keyword%' OR id_kunjungan like '%$keyword%' OR nama_pasien like '%$keyword%' OR nama_dokter like '%$keyword%' OR tanggal_entry like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT * FROM resep ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT * FROM resep WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_resep= $data['id_resep'];
                $id_pasien= $data['id_pasien'];
                $id_kunjungan= $data['id_kunjungan'];
                $id_akses= $data['id_akses'];
                $id_dokter= $data['id_dokter'];
                $nama_pasien= $data['nama_pasien'];
                $petugas_entry= $data['petugas_entry'];
                $nama_dokter= $data['nama_dokter'];
                $tanggal_entry= $data['tanggal_entry'];
                $tanggal_resep= $data['tanggal_resep'];
                $status= $data['status'];
                //Format Tanggal
                $strtotime= strtotime($tanggal_resep);
                $FormatTanggal= date('d/m/Y',$strtotime);
                //Decode pasien
                $Jsonpasien =json_decode($nama_pasien, true);
                $NamaPasien=$Jsonpasien['nama_pasien'];
                //Routing Status
                if($status=="Pending"){
                    $LabelStatus='<span class="text-warning">Pending</span>';
                }else{
                    $LabelStatus='<span class="text-success">Selesai</span>';
                }
        ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <span><?php echo "$no. $NamaPasien"; ?></span>
                </div>
                <div class="card-body">
                    <ul>
                        <li>
                            No.RM/REG : <code class="text-secondary"><?php echo "$id_pasien/$id_kunjungan"; ?></code>
                        </li>
                        <li>
                            Tgl Resep : <code class="text-secondary"><?php echo "$FormatTanggal"; ?></code>
                        </li>
                        <li>
                            Dokter : <code class="text-secondary"><?php echo "$nama_dokter"; ?></code>
                        </li>
                        <li>
                            Status : <code class="text-secondary"><?php echo "$LabelStatus"; ?></code>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-sm btn-outline-dark btn-block btn-round" data-toggle="modal" data-target="#ModalDetailResep" data-id="<?php echo "$id_resep"; ?>">
                                Selengkapnya <i class="ti ti-more"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
                $no++; 
            }
        }
    ?>
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
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-info" id="PageNumber'.$i.'" value="'.$i.'">';
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
</div>