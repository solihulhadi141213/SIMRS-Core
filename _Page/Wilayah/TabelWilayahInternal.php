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
    //kategori
    if(!empty($_POST['kategori'])){
        $kategori=$_POST['kategori'];
    }else{
        $kategori="";
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
        $OrderBy="kategori";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($kategori)){
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori like '%$keyword%' OR propinsi like '%$keyword%' OR kabupaten like '%$keyword%' OR kecamatan like '%$keyword%' OR desa like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE $keyword_by like '%$keyword%'"));
            }
        }
    }else{
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='$kategori'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE (kategori='$kategori') AND (kategori like '%$keyword%' OR propinsi like '%$keyword%' OR kabupaten like '%$keyword%' OR kecamatan like '%$keyword%' OR desa like '%$keyword%')"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='$kategori'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE (kategori='$kategori') AND ($keyword_by like '%$keyword%')"));
            }
        }
    }
?>
<script>
    //Ketika Batas Diubah
    $('#batas').change(function(){
        var BatasPencarianInternal = $('#BatasPencarianInternal').serialize();
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        $('#MenampilkanTabelWilayahInternal').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Wilayah/TabelWilayahInternal.php',
            data 	    :  BatasPencarianInternal,
            success     : function(data){
                $('#MenampilkanTabelWilayahInternal').html(data);
            }
        });
    });
    //Ketika Kategori Diubah
    $('#kategori').change(function(){
        var BatasPencarianInternal = $('#BatasPencarianInternal').serialize();
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        $('#MenampilkanTabelWilayahInternal').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Wilayah/TabelWilayahInternal.php',
            data 	    :  BatasPencarianInternal,
            success     : function(data){
                $('#MenampilkanTabelWilayahInternal').html(data);
            }
        });
    });
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var kategori="<?php echo "$kategori"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Wilayah/TabelWilayahInternal.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, kategori: kategori, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelWilayahInternal').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var kategori="<?php echo "$kategori"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Wilayah/TabelWilayahInternal.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, kategori: kategori, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelWilayahInternal').html(data);
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
            var kategori="<?php echo "$kategori"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Wilayah/TabelWilayahInternal.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, kategori: kategori, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelWilayahInternal').html(data);
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
                    <th id="" class="text-center">
                        <dt>NO</dt>
                    </th>
                    <th class="text-center">
                        <dt>KODE</dt>
                    </th>
                    <th class="text-center">
                        <dt>KATEGORI</dt>
                    </th>
                    <th class="text-center">
                        <dt>PROPINSI</dt>
                    </th>
                    <th class="text-center">
                        <dt>KABUPATEN</dt>
                    </th>
                    <th class="text-center">
                        <dt>KECAMATAN</dt>
                    </th>
                    <th class="text-center">
                        <dt>DESA</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1+$posisi;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($kategori)){
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM wilayah ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori like '%$keyword%' OR propinsi like '%$keyword%' OR kabupaten like '%$keyword%' OR kecamatan like '%$keyword%' OR desa like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM wilayah ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                    }else{
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='$kategori' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE (kategori='$kategori') AND (kategori like '%$keyword%' OR propinsi like '%$keyword%' OR kabupaten like '%$keyword%' OR kecamatan like '%$keyword%' OR desa like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='$kategori' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE (kategori='$kategori') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_wilayah= $data['id_wilayah'];
                        $kategori_list= $data['kategori'];
                        $propinsi= $data['propinsi'];
                        $kabupaten= $data['kabupaten'];
                        $kecamatan= $data['kecamatan'];
                        $desa= $data['desa'];
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailWilayah" data-id="<?php echo "$id_wilayah,$keyword,$batas,$ShortBy,$OrderBy,$page,$posisi,$keyword_by,$kategori";?>" onmousemove="this.style.cursor='pointer'">
                        <td class="" align="center"><?php echo "$no";?></td>
                        <td class="" align="center"><?php echo "$id_wilayah";?></td>
                        <td class="" align="left"><?php echo $kategori_list;?></td>
                        <td class="" align="left"><?php echo ''.$propinsi.'';?></td>
                        <td class="" align="left"><?php echo ''.$kabupaten.'';?></td>
                        <td class="" align="left"><?php echo $kecamatan;?></td>
                        <td class="text-left"><?php echo $desa;?></td>
                    </tr>
                <?php
                    $no++; }
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
<div class="card-footer">
    <div class="btn-group">
        <a href="javascript:void(0);" class="b-b-primary text-primary">
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
        </a>
    </div>
</div>