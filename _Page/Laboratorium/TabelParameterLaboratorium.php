<?php
    //koneksi dan session
    // ini_set("display_errors","off");
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
        if($ShortBy=="ASC"){
            $NextShort="DESC";
        }else{
            $NextShort="ASC";
        }
    }else{
        $ShortBy="DESC";
        $NextShort="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_laboratorium_parameter";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_parameter"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_parameter WHERE parameter like '%$keyword%' OR kategori_parameter like '%$keyword%' OR tipe_data like '%$keyword%' OR alternatif like '%$keyword%' OR nilai_rujukan like '%$keyword%' OR nilai_kritis like '%$keyword%' OR satuan like '%$keyword%' OR keterangan like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_parameter"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_parameter WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/Laboratorium/TabelLaboratorium.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#TabelParameterLaboratorium').html(data);
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
            url     : "_Page/Laboratorium/TabelLaboratorium.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#TabelParameterLaboratorium').html(data);
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
                url     : "_Page/Laboratorium/TabelLaboratorium.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#TabelParameterLaboratorium').html(data);
                    $('#page').val(PageNumber);
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
                        <dt>Prameter</dt> 
                    </th>
                    <th class="text-center">
                        <dt>Kategori</dt> 
                    </th>
                    <th class="text-center">
                        <dt>Tipe</dt> 
                    </th>
                    <th class="text-center">
                        <dt>Satuan</dt> 
                    </th>
                    <th class="text-center">
                        <dt>Opsi</dt> 
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="6">Tidak Ada Data Parameter Yang Ditampilkan</td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_parameter ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_parameter WHERE parameter like '%$keyword%' OR kategori_parameter like '%$keyword%' OR tipe_data like '%$keyword%' OR alternatif like '%$keyword%' OR nilai_rujukan like '%$keyword%' OR nilai_kritis like '%$keyword%' OR satuan like '%$keyword%' OR keterangan like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_parameter ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_parameter WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_laboratorium_parameter= $data['id_laboratorium_parameter'];
                            $parameter= $data['parameter'];
                            $kategori_parameter= $data['kategori_parameter'];
                            $tipe_data= $data['tipe_data'];
                            if(empty($data['satuan'])){
                                $satuan="None";
                            }else{
                                $satuan= $data['satuan'];
                            }
                    ?>
                        <tr class="table-light">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left"><?php echo "$parameter";?></td>
                            <td class="" align="left"><?php echo "$kategori_parameter";?></td>
                            <td class="" align="left"><?php echo "$tipe_data";?></td>
                            <td class="" align="left"><?php echo "$satuan";?></td>
                            <td class="" align="center">
                                <div class="btn-group dropdown-split-inverse">
                                    <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                        <i class="ti ti-settings"></i>
                                    </button>
                                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailParameter" data-id="<?php echo "$id_laboratorium_parameter"; ?>">
                                            <i class="ti ti-info-alt"></i> Detail
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditParameter" data-id="<?php echo "$id_laboratorium_parameter"; ?>">
                                            <i class="ti-pencil"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusParameter" data-id="<?php echo "$id_laboratorium_parameter,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi,$keyword_by"; ?>">
                                            <i class="ti-trash"></i> Hapus
                                        </a>
                                    </div>
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
<div class="card-footer text-left border-info">
    <div class="btn-group">
        <a href="javascript:void(0);" class="b-b-primary text-primary">
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
        </a>
    </div>
</div>