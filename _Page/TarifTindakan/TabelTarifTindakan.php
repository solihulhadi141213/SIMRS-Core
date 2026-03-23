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
        if($ShortBy=="ASC"){
            $NextShort="DESC";
        }else{
            $NextShort="ASC";
        }
    }else{
        $ShortBy="DESC";
        $NextShort="DESC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_tarif";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM tarif"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM tarif WHERE id_tarif like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR tarif like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM tarif"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM tarif WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    $('#CheckAllObat').click(function() { 
        $('.IdObatCheck').prop('checked', this.checked);
    });
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/TarifTindakan/TabelTarifTindakan.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#MenampilkanTabelTarifTindakan').html(data);
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
            url     : "_Page/TarifTindakan/TabelTarifTindakan.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelTarifTindakan').html(data);
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
                url     : "_Page/TarifTindakan/TabelTarifTindakan.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#MenampilkanTabelTarifTindakan').html(data);
                    $('#page').val(PageNumber);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <?php
        if(empty($jml_data)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak ada data tarif yang ditampilkan.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM tarif ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM tarif WHERE id_tarif like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR tarif like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM tarif ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM tarif WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_tarif= $data['id_tarif'];
                $kategori= $data['kategori'];
                $nama= $data['nama'];
                $tarif= $data['tarif'];
                //Format tarif
                $TarifRp = "Rp " . number_format($tarif, 0, ',', '.');
                //Hitung Jumlah Cost
                $JumlahCost = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM tarif_cost WHERE id_tarif='$id_tarif'"));
                $SumCost = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(cost) AS cost FROM tarif_cost WHERE id_tarif='$id_tarif'"));
                $JumlahSumCost = $SumCost['cost'];
                //Format Cost
                $JumlahSumCostRp = "Rp " . number_format($JumlahSumCost, 0, ',', '.');
    ?>
        <div class="row sub-title">
            <div class="col-md-12 mb-2">
                <dt>
                    <?php echo ''.$no.'. '.$nama.'';?>
                </dt>
            </div>
            <div class="col-md-5 mb-2">
                <ul class="ml-3">
                    <li><?php echo '<small>Kategori: '.$kategori.'</small>';?></li>
                    <li><?php echo '<small>Tarif : '.$TarifRp.'</small>';?></li>
                </ul>
            </div>
            <div class="col-md-4 mb-2">
                <ul class="ml-3 <?php if(empty($JumlahCost)){echo "text-danger";} ?>">
                    <li><?php echo '<small>Data Cost: '.$JumlahCost.'</small>';?></li>
                    <li><?php echo '<small>Cost : '.$JumlahSumCostRp.'</small>';?></li>
                </ul>
            </div>
            <div class="col-md-3 mb-2 icon-btn">
                <div class="ml-3">
                    <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalDetailTarif" data-id="<?php echo "$id_tarif";?>" title="Detail Tarif Dan Tindakan">
                        <i class="ti ti-info"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalEditTarif" data-id="<?php echo "$id_tarif";?>" title="Edit Tarif Dan Tindakan">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalHapusTarif" data-id="<?php echo "$id_tarif";?>" title="Delete Tarif Dan Tindakan">
                        <i class="ti ti-close"></i>
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
