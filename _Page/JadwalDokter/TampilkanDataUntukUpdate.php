<div class="table table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center"><dt>No</dt></th>
                <th class="text-center"><dt>Hari/Jam</dt></th>
                <th class="text-center"><dt>Kode Poli</dt></th>
                <th class="text-center"><dt>Kode Dokter</dt></th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(empty($_POST['id_dokter'])){
                    echo "
                    <tr>
                        <td colspan='5' class='text-center'>Data ID Dokter Tidak Boleh Kosong</td>
                    </tr>";
                }else{
                    if(empty($_POST['id_poliklinik'])){
                        echo "
                        <tr>
                            <td colspan='5' class='text-center'>Data ID Poliklinik Tidak Boleh Kosong</td>
                        </tr>";
                    }else{
                        include "../../_Config/Connection.php";
                        $id_dokter=$_POST['id_dokter'];
                        $id_poliklinik=$_POST['id_poliklinik'];
                        //Buka data jadwal dokter dari database
                        $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'"));
                        //Kondisi jika data jadwal dokter kosong
                        if(empty($JumlahData)){
                            echo "
                            <tr>
                                <td colspan='5' class='text-center'>Tidak Ada Jadwal Dokter</td>
                            </tr>";
                        }else{
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            $query = mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'  ORDER BY jam ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_jadwal= $data['id_jadwal'];
                                $id_dokter= $data['id_dokter'];
                                $id_poliklinik= $data['id_poliklinik'];
                                $dokter= $data['dokter'];
                                $poliklinik= $data['poliklinik'];
                                $hari= $data['hari'];
                                $jam= $data['jam'];
                                echo "
                                <tr>
                                    <td class='text-center'>$no</td>
                                    <td class='text-center'>$hari, $jam</td>
                                    <td class='text-center'>$poliklinik</td>
                                    <td class='text-center'>$dokter</td>
                                </tr>";
                            $no++;}
                        }
                    }
                }
            ?>
        </tbody>
    </table>
</div>