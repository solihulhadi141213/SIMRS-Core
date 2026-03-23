<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['id_pasien'])){
        echo '<div class="row"><div class="col-md-12 text-center text-danger">Pilih Pasien Terlebih Dulu</div></div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$id_pasien'"));
        if(empty($jml_data)){
            echo '<div class="row"><div class="col-md-12 text-center text-danger">Belum Ada Kunjungan Untuk Pasien Tersebut</div></div>';
        }else{
            $batas="10";
            $OrderBy="id_Kunjungan";
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
                    $('#NextPageKunjungan').click(function() {
                        var valueNext=$('#NextPageKunjungan').val();
                        var id_pasien="<?php echo "$id_pasien"; ?>";
                        $.ajax({
                            url     : "_Page/Transaksi/ListKunjungan.php",
                            method  : "POST",
                            data 	:  { page: valueNext, id_pasien: id_pasien },
                            success: function (data) {
                                $('#FormListKunjungan').html(data);
                            }
                        })
                    });
                    //Ketika klik Previous
                    $('#PrevPageKunjungan').click(function() {
                        var ValuePrev = $('#PrevPageKunjungan').val();
                        var id_pasien="<?php echo "$id_pasien"; ?>";
                        $.ajax({
                            url     : "_Page/Transaksi/ListKunjungan.php",
                            method  : "POST",
                            data 	:  { page: ValuePrev, id_pasien: id_pasien },
                            success: function (data) {
                                $('#FormListKunjungan').html(data);
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
                        $('#PageNumberKunjungan<?php echo $i;?>').click(function() {
                            var PageNumber = $('#PageNumberKunjungan<?php echo $i;?>').val();
                            var id_pasien="<?php echo "$id_pasien"; ?>";
                            $.ajax({
                                url     : "_Page/Transaksi/ListKunjungan.php",
                                method  : "POST",
                                data 	:  { page: ValuePrev, id_pasien: id_pasien },
                                success: function (data) {
                                    $('#FormListKunjungan').html(data);
                                }
                            })
                        });
                    <?php } ?>
                    $(".AddKunjunganTransaksi").click(function() {
                        var GetIdKunjungan = $(this).attr('value');
                        var GetTujuan =$("#GetTujuan"+GetIdKunjungan).html();
                        var OptionKunjungan='<option selected value="'+GetIdKunjungan+'">'+GetIdKunjungan+'-'+GetTujuan+'</option>';
                        $('#PutIdKunjungan').html(OptionKunjungan);
                        //Tutup Modal
                        $('#ModalListKunjungan').modal('hide');
                    });

                </script>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">ID.REG</th>
                                        <th class="text-center">TANGGAL</th>
                                        <th class="text-center">KUNJUNGAN</th>
                                        <th class="text-center">KLAIM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1+$posisi;
                                        $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$id_pasien' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_kunjungan= $data['id_kunjungan'];
                                            $tanggal= $data['tanggal'];
                                            $tujuan= $data['tujuan'];
                                            $pembayaran= $data['pembayaran'];
                                            $nama= $data['nama'];
                                            $strtotime=strtotime($tanggal);
                                            $TanggalFormat=date('d/m/Y',$strtotime);
                                        ?>
                                        <tr tabindex="0" class="table-light AddKunjunganTransaksi" value="<?php echo "$id_kunjungan";?>" onmousemove="this.style.cursor='pointer'">
                                            <td class="" align="center"><?php echo "$no";?></td>
                                            <td align="left"><?php echo "$id_kunjungan";?></td>
                                            <td align="left"><?php echo "$TanggalFormat";?></td>
                                            <td align="left" id="GetTujuan<?php echo "$id_kunjungan";?>"><?php echo "$tujuan";?></td>
                                            <td align="left"><?php echo "$pembayaran";?></td>
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
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPageKunjungan" value="<?php echo $prev;?>">
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
                                        echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumberKunjungan'.$i.'" value="'.$i.'">';
                                    }else{
                                        echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumberKunjungan'.$i.'" value="'.$i.'">';
                                    }
                                    echo ''.$i.'';
                                    echo '</button>';
                                }
                            ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPageKunjungan" value="<?php echo $next;?>">
                                <i class="ti-angle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
<?php
        }
    }
?>