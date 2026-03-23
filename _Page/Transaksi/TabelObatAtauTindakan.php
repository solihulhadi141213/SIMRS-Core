<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Apabila Obat Atau Tindakan Belum Diisi
    if(empty($_POST['ObatAtauTindakan'])){
        echo '<div class="row"><div class="col-md-12 text-center text-danger">Pilih Data Yang Ingin Ditampilkan Terlebih Dulu</div></div>';
    }else{
        $ObatAtauTindakan=$_POST['ObatAtauTindakan'];
        //KeywordObatAtauTindakan
        if(!empty($_POST['KeywordObatAtauTindakan'])){
            $keyword=$_POST['KeywordObatAtauTindakan'];
        }else{
            $keyword="";
        }
        //batas
        $batas="10";
        //ShortBy
        $ShortBy="ASC";
        //OrderBy
        if($ObatAtauTindakan=="Obat"){
            $OrderBy="id_obat";
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
        if($ObatAtauTindakan=="Obat"){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM tarif"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM tarif WHERE nama like '%$keyword%' OR kategori like '%$keyword%'"));
            }
        }
?>
    <script>
        //ketika klik next
        $('#NextPageObatTindakan').click(function() {
            var valueNext=$('#NextPageObatTindakan').val();
            var ObatAtauTindakan="<?php echo "$ObatAtauTindakan"; ?>";
            var KeywordObatAtauTindakan="<?php echo "$keyword"; ?>";
            $.ajax({
                url     : "_Page/Transaksi/TabelObatAtauTindakan.php",
                method  : "POST",
                data 	:  { page: valueNext, ObatAtauTindakan: ObatAtauTindakan, KeywordObatAtauTindakan: KeywordObatAtauTindakan },
                success: function (data) {
                    $('#TabelObatAtauTindakan').html(data);

                }
            })
        });
        //Ketika klik Previous
        $('#PrevPageObatTindakan').click(function() {
            var ValuePrev = $('#PrevPageObatTindakan').val();
            var ObatAtauTindakan="<?php echo "$ObatAtauTindakan"; ?>";
            var KeywordObatAtauTindakan="<?php echo "$keyword"; ?>";
            $.ajax({
                url     : "_Page/Transaksi/TabelObatAtauTindakan.php",
                method  : "POST",
                data 	:  { page: ValuePrev, ObatAtauTindakan: ObatAtauTindakan, KeywordObatAtauTindakan: KeywordObatAtauTindakan },
                success : function (data) {
                    $('#TabelObatAtauTindakan').html(data);
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
            $('#PageNumberObatTindakan<?php echo $i;?>').click(function() {
                var PageNumber = $('#PageNumberObatTindakan<?php echo $i;?>').val();
                var ObatAtauTindakan="<?php echo "$ObatAtauTindakan"; ?>";
                var KeywordObatAtauTindakan="<?php echo "$keyword"; ?>";
                $.ajax({
                    url     : "_Page/Transaksi/TabelObatAtauTindakan.php",
                    method  : "POST",
                    data 	:  { page: PageNumber, ObatAtauTindakan: ObatAtauTindakan, KeywordObatAtauTindakan: KeywordObatAtauTindakan },
                    success: function (data) {
                        $('#TabelObatAtauTindakan').html(data);
                    }
                })
            });
        <?php } ?>
    </script>
    <div class="row mb-3 sub-title">
        <div class="col-md-12 bg-light pre-scrollable">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>No</dt></th>
                            <th class="text-center"><dt>Nama/Keterangan</dt></th>
                            <th class="text-center"><dt>Kategori</dt></th>
                            <th class="text-center"><dt>Harga/Tarif</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(empty($jml_data)){
                                echo '<tr>';
                                echo '  <td colspan="3" class="text-center text-danger">Tidak Ada Data Obat/Tarif Tindakan Yang Ditampilkan</td>';
                                echo '</tr>';
                            }
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if($ObatAtauTindakan=="Obat"){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM tarif ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM tarif WHERE nama like '%$keyword%' OR kategori like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                if($ObatAtauTindakan=="Obat"){
                                    $IdData= $data['id_obat'];
                                }else{
                                    $IdData= $data['id_tarif'];
                                }
                                $nama= $data['nama'];
                                $Kategori= $data['kategori'];
                                if($ObatAtauTindakan=="Obat"){
                                    $HargaTarif= $data['harga'];
                                }else{
                                    $HargaTarif= $data['tarif'];
                                }
                                $FormatHarga = "Rp " . number_format($HargaTarif, 0, ',', '.');
                            ?>
                            <tr tabindex="0" class="table-light" onmousemove="this.style.cursor='pointer'" data-toggle="modal" data-target="#ModalTambahRincian" data-id="<?php echo "$IdData,$ObatAtauTindakan"; ?>">
                                <td class="" align="center"><?php echo "$no";?></td>
                                <td class="" align="left"><?php echo "$nama";?></td>
                                <td class="" align="left"><?php echo "$Kategori";?></td>
                                <td class="" align="right"><?php echo "$FormatHarga";?></td>
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
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPageObatTindakan" value="<?php echo $prev;?>">
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
                            echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumberObatTindakan'.$i.'" value="'.$i.'">';
                        }else{
                            echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumberObatTindakan'.$i.'" value="'.$i.'">';
                        }
                        echo ''.$i.'';
                        echo '</button>';
                    }
                ?>
                <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPageObatTindakan" value="<?php echo $next;?>">
                    <i class="ti-angle-right"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>