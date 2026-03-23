<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Hari
    if(!empty($_POST['Hari'])){
        $Hari=$_POST['Hari'];
    }else{
        $Hari="";
    }
?>
<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><dt>No</dt></th>
                    <th class="text-center"><dt>Poli</dt></th>
                    <th class="text-center"><dt>Dokter</dt></th>
                    <th class="text-center"><dt>Kuota JKN</dt></th>
                    <th class="text-center"><dt>Kuota NON-JKN</dt></th>
                    <th class="text-center"><dt>Hari-Jam</dt></th>
                    <th class="text-center"><dt>Waktu Pendaftaran</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //menghitung jumlah
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE hari='$Hari'"));
                    if(empty($jml_data)){
                        echo '<tr><td colspan="4" class="text-center">Tidak Ada Jadwal Hari Ini</td></tr>';
                    }else{
                        $no = 1;
                        //KONDISI PENGATURAN MASING FILTER
                        $query = mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE hari='$Hari'  ORDER BY jam ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_jadwal= $data['id_jadwal'];
                            $id_dokter= $data['id_dokter'];
                            $id_poliklinik= $data['id_poliklinik'];
                            $dokter= $data['dokter'];
                            $kuota_non_jkn= $data['kuota_non_jkn'];
                            $kuota_jkn= $data['kuota_jkn'];
                            $poliklinik= $data['poliklinik'];
                            $hari= $data['hari'];
                            $jam= $data['jam'];
                            $time_max= $data['time_max'];
                            if(empty($time_max)){
                                $time_max="0";
                            }else{
                                $time_max=$time_max;
                            }
                    ?>
                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalEditJadwalDokter" data-id="<?php echo "$id_jadwal";?>" onmousemove="this.style.cursor='pointer'">
                            <td class="text-center"><?php echo "$no";?></td>
                            <td class="text-left"><?php echo "$poliklinik";?></td>
                            <td class="text-left"><?php echo "$dokter";?></td>
                            <td class="text-left"><?php echo "$kuota_jkn Pasien";?></td>
                            <td class="text-left"><?php echo "$kuota_non_jkn Pasien";?></td>
                            <td class="text-center"><?php echo "<small>$hari, $jam</small>";?></td>
                            <td class="text-center"><?php echo "$time_max Menit";?></td>
                        </tr>
                <?php
                    $no++; }}
                ?>
            </tbody>
        </table>
    </div>
</div>
