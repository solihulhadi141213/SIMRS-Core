<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //KeywordSupplier
    if(!empty($_POST['KeywordSupplier'])){
        $keyword=$_POST['KeywordSupplier'];
    }else{
        $keyword="";
    }
    //batas
    $batas="10";
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="DESC";
    }
    //OrderBy
    $OrderBy="id_supplier";
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier WHERE nama like '%$keyword%' OR company like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPageSupplier').click(function() {
        var valueNext=$('#NextPageSupplier').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Transaksi/ListSupplier.php",
            method  : "POST",
            data 	:  { page: valueNext, BatasSupplier: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#FormListSupplier').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageSupplier').click(function() {
        var ValuePrev = $('#PrevPageSupplier').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Transaksi/ListSupplier.php",
            method  : "POST",
            data 	:  { page: ValuePrev, BatasSupplier: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#FormListSupplier').html(data);
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
        $('#PageNumberSupplier<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumberSupplier<?php echo $i;?>').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Transaksi/ListSupplier.php",
                method  : "POST",
                data 	:  { page: PageNumber, BatasSupplier: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#FormListSupplier').html(data);
                }
            })
        });
    <?php } ?>
    $(".AddSupplierTransaksi").click(function() {
        var GetIdSupplier = $(this).attr('value');
        var GetNamaSupplier =$("#GetNamaSupplier"+GetIdSupplier).html();
        var GetCompanySupplier =$("#GetCompanySupplier"+GetIdSupplier).html();
        var OptionSupplier='<option selected value="'+GetIdSupplier+'">'+GetNamaSupplier+'-'+GetCompanySupplier+'</option>';
        $('#PutIdSupplier').html(OptionSupplier);
        //Reset Form
        $("#ProsesPencarianSupplier")[0].reset();
        //Tutup Modal
        $('#ModalListSupplier').modal('hide');
    });

</script>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">NO</th>
                        <th class="text-center">SUPPLIER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="2" class="text-center text-danger">Tidak Ada Data Supplier Yang Ditampilkan</td>';
                            echo '</tr>';
                        }
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM supplier ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM supplier WHERE nama like '%$keyword%' OR company like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_supplier= $data['id_supplier'];
                            $nama= $data['nama'];
                            $company= $data['company'];
                        ?>
                        <tr tabindex="0" class="table-light AddSupplierTransaksi" value="<?php echo "$id_supplier";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td align="left" >
                                <dt id="GetNamaSupplier<?php echo "$id_supplier";?>"><?php echo "$nama";?></dt>
                                <small id="GetCompanySupplier<?php echo "$id_supplier";?>"><?php echo "$company";?></small>
                            </td>
                        </tr>
                    <?php
                        $no++; }
                    ?>
                </tbody>
            </table>
        </div>
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
<div class="row">
    <div class="col-md-12 text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPageSupplier" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumberSupplier'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumberSupplier'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPageSupplier" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</div>