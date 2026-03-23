<?php
    include "../../_Config/Connection.php";
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter"));
    if(empty($jml_data)){
        echo '<div class="row"><div class="col-md-12 text-center text-danger">Belum Ada Dokter Untuk Pasien Tersebut</div></div>';
    }else{
        $batas="10";
        $OrderBy="id_dokter";
        $ShortBy="DESC";
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
?>
        <script>
            //ketika klik next
            $('#NextPageDokter').click(function() {
                var valueNext=$('#NextPageDokter').val();
                $.ajax({
                    url     : "_Page/Transaksi/ListDokter.php",
                    method  : "POST",
                    data 	:  { page: valueNext },
                    success: function (data) {
                        $('#FormListDokter').html(data);
                    }
                })
            });
            //Ketika klik Previous
            $('#PrevPageDokter').click(function() {
                var ValuePrev = $('#PrevPageDokter').val();
                $.ajax({
                    url     : "_Page/Transaksi/ListDokter.php",
                    method  : "POST",
                    data 	:  { page: ValuePrev },
                    success: function (data) {
                        $('#FormListDokter').html(data);
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
                $('#PageNumberDokter<?php echo $i;?>').click(function() {
                    var PageNumber = $('#PageNumberDokter<?php echo $i;?>').val();
                    $.ajax({
                        url     : "_Page/Transaksi/ListDokter.php",
                        method  : "POST",
                        data 	:  { page: ValuePrev },
                        success: function (data) {
                            $('#FormListDokter').html(data);
                        }
                    })
                });
            <?php } ?>
            $(".AddDokterTransaksi").click(function() {
                var GetIdDokter = $(this).attr('value');
                var GetDokter =$("#GetDokter"+GetIdDokter).html();
                var GetKodeDokter =$("#GetKodeDokter"+GetIdDokter).html();
                var OptionDokter='<option selected value="'+GetIdDokter+'">'+GetKodeDokter+'-'+GetDokter+'</option>';
                $('#PutIdDokter').html(OptionDokter);
                //Tutup Modal
                $('#ModalListDokter').modal('hide');
            });

        </script>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">KODE</th>
                                <th class="text-center">NAMA</th>
                                <th class="text-center">KATEGORI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1+$posisi;
                                $query = mysqli_query($Conn, "SELECT*FROM DOKTER ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_dokter= $data['id_dokter'];
                                    $nama= $data['nama'];
                                    $kode= $data['kode'];
                                    $kategori= $data['kategori'];
                                ?>
                                <tr tabindex="0" class="table-light AddDokterTransaksi" value="<?php echo "$id_dokter";?>" onmousemove="this.style.cursor='pointer'">
                                    <td class="" align="center"><?php echo "$no";?></td>
                                    <td align="left" id="GetKodeDokter<?php echo "$id_dokter";?>"><?php echo "$kode";?></td>
                                    <td align="left" id="GetDokter<?php echo "$id_dokter";?>"><?php echo "$nama";?></td>
                                    <td align="left"><?php echo "$kategori";?></td>
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
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPageDokter" value="<?php echo $prev;?>">
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
                                echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumberDokter'.$i.'" value="'.$i.'">';
                            }else{
                                echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumberDokter'.$i.'" value="'.$i.'">';
                            }
                            echo ''.$i.'';
                            echo '</button>';
                        }
                    ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPageDokter" value="<?php echo $next;?>">
                        <i class="ti-angle-right"></i>
                    </button>
                </div>
            </div>
        </div>
<?php
        }
?>