<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //KeywordPasien
    if(!empty($_POST['KeywordPasien'])){
        $keyword=$_POST['KeywordPasien'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['BatasPasien'])){
        $batas=$_POST['BatasPasien'];
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
        $OrderBy="id_pasien";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPagePasien').click(function() {
        var valueNext=$('#NextPagePasien').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Transaksi/ListPasien.php",
            method  : "POST",
            data 	:  { page: valueNext, BatasPasien: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#FormListPasien').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPagePasien').click(function() {
        var ValuePrev = $('#PrevPagePasien').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Transaksi/ListPasien.php",
            method  : "POST",
            data 	:  { page: ValuePrev, BatasPasien: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#FormListPasien').html(data);
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
        $('#PageNumberPasien<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumberPasien<?php echo $i;?>').val();
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Transaksi/ListPasien.php",
                method  : "POST",
                data 	:  { page: PageNumber, BatasPasien: batas, keyword: keyword, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#FormListPasien').html(data);
                }
            })
        });
    <?php } ?>
    $(".AddPasienTransaksi").click(function() {
        var GetIdPasien = $(this).attr('value');
        var GetNamapasien =$("#GetNamapasien"+GetIdPasien).html();
        var OptionPasien='<option selected value="'+GetIdPasien+'">'+GetIdPasien+'-'+GetNamapasien+'</option>';
        $('#PutIdPasien').html(OptionPasien);
        //Reset Form
        $("#ProsesPencarianPasien")[0].reset();
        //Tutup Modal
        $('#ModalListPasien').modal('hide');
    });

</script>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">NO</th>
                        <th class="text-center">ID/RM</th>
                        <th class="text-center">PASIEN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="3" class="text-center text-danger">Tidak Ada Data Pasien Yang Ditampilkan</td>';
                            echo '</tr>';
                        }
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword)){
                            $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' OR tanggal_daftar like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_pasien= $data['id_pasien'];
                            $nama= $data['nama'];
                        ?>
                        <tr tabindex="0" class="table-light AddPasienTransaksi" value="<?php echo "$id_pasien";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td align="left"><?php echo "$id_pasien";?></td>
                            <td class="" id="GetNamapasien<?php echo "$id_pasien";?>" align="left"><?php echo "$nama";?></td>
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
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPagePasien" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumberPasien'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumberPasien'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPagePasien" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</div>