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
        $OrderBy="id_bantuan";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bantuan"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bantuan WHERE tanggal like '%$keyword%' OR judul like '%$keyword%' OR kategori like '%$keyword%' OR isi like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bantuan"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bantuan WHERE $keyword_by like '%$keyword%'"));
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
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Bantuan/TabelBantuan.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) { 
                $('#TabelBantuan').html(data);
                $('#page').val(valueNext);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Bantuan/TabelBantuan.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#TabelBantuan').html(data);
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
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Bantuan/TabelBantuan.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#TabelBantuan').html(data);
                    $('#page').val(PageNumber);
                }
            })
        });
    <?php } ?>
</script>
<div class="row">
    <?php
        if(empty($jml_data)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Tidak Ada Informasi Bantuan Yang Ditampilkan';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM bantuan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM bantuan WHERE tanggal like '%$keyword%' OR judul like '%$keyword%' OR kategori like '%$keyword%' OR isi like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM bantuan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM bantuan WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_bantuan = $data['id_bantuan'];
                $tanggal= $data['tanggal'];
                $judul= $data['judul'];
                $kategori= $data['kategori'];
                $isi= $data['isi'];
                //Format Tanggal Post
                $strtotime = strtotime($tanggal);
                $TanggalFormat=date('d/m/Y H:i',$strtotime);
                //Routing Status
                if(!empty($data['status'])){
                    $status= $data['status'];
                    if($status=="Terbit"){
                        $LabelStatus='<span class="text-success"><i class="ti ti-check"></i> Terbit</span>';
                    }else{
                        if($status=="Draft"){
                            $LabelStatus='<span class="text-warning"><i class="ti ti-notepad"></i> Draft</span>';
                        }else{
                            $LabelStatus='<span class="text-secondary">Tidak Diketahui</span>';
                        }
                    }
                }else{
                    $LabelStatus='<span class="text-secondary">Tidak Diketahui</span>';
                }
    ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <dt class="card-title">
                        <?php echo "$no. $judul"; ?>
                    </dt>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <ul>
                                <li>
                                    <i class="ti ti-calendar"></i> Tanggal Post : <code class="text-dark"><?php echo "$TanggalFormat"; ?></code>
                                </li>
                                <li>
                                    <i class="icofont-tag"></i> Kategori: <code class="text-dark"><?php echo "$kategori"; ?></code>
                                </li>
                                <li>
                                    <i class="ti ti-check"></i> Status: <code class="text-dark"><?php echo "$LabelStatus"; ?></code>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer icon-btn">
                    <button type="button" class="btn btn-sm btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalDetailBantuan" data-id="<?php echo "$id_bantuan"; ?>" title="Detail Bantuan">
                        <i class="ti ti-info"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalEditBantuan" data-id="<?php echo "$id_bantuan"; ?>" title="Edit Bantuan">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalDeleteBantuan" data-id="<?php echo "$id_bantuan"; ?>" title="Hapus Bantuan">
                        <i class="ti ti-trash"></i>
                    </button>
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
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPage" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-outline-info btn-round" id="PageNumber'.$i.'" value="'.$i.'">';
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
</div>