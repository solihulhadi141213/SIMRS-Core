<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(empty($_POST['id_pasien'])){
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Silahkan Isi No RM pasien terlebih dulu!';
        echo '  </div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        $JumlahDataKunjungan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$id_pasien'"));
?>
<div class="col-md-12 mb-3 pre-scrollable">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th id="" class="text-center">
                        <dt>NO</dt>
                    </th>
                    <th id="" class="text-center">
                        <dt>TANGGAL</dt>
                    </th>
                    <th id="" class="text-center">
                        <dt>KUNJUNGAN</dt>
                    </th>
                    <th id="" class="text-center">
                        <dt>POLI/DOKTER</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($JumlahDataKunjungan)){
                        echo '<tr>';
                        echo '  <td colspan="4" class="text-danger text-center">';
                        echo '      Belum Ada Data Kunjungan Untuk Pasien Ini';
                        echo '  </td>';
                        echo '</tr>';
                    }
                    $no = 1;
                    $QryKunjungan = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$id_pasien' ORDER BY id_kunjungan DESC");
                    while ($DataKunjungan = mysqli_fetch_array($QryKunjungan)) {
                        $id_kunjungan= $DataKunjungan['id_kunjungan'];
                        $tanggal= $DataKunjungan['tanggal'];
                        $tujuan= $DataKunjungan['tujuan'];
                        $pembayaran= $DataKunjungan['pembayaran'];
                        $dokter= $DataKunjungan['dokter'];
                        $poliklinik= $DataKunjungan['poliklinik'];
                        //Format Tanggal
                        $strtotime=strtotime($tanggal);
                        $FormatTanggal=date('d/m/Y H:i',$strtotime);
                ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalKonfirmasiPilihKunjungan" data-id="<?php echo "$id_kunjungan";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left">
                                <?php 
                                    echo '<span>'.$tanggal.'</span><br>';
                                    echo '<small class="text-muted">ID. '.$id_kunjungan.'</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo '<span>'.$tujuan.'</span><br>';
                                    echo '<small class="text-muted">Pasien '.$pembayaran.'</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php 
                                    echo '<span>'.$dokter.'</span><br>';
                                    echo '<small class="text-muted">Pasien '.$poliklinik.'</small>';
                                ?>
                            </td>
                        </tr>
                    <?php
                        $no++; }
                    ?>
            </tbody>
        </table>
        
    </div>
</div>
<?php } ?>