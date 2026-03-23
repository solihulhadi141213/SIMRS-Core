<?php
    //Koneksi
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Tangkap id_antrian
    if(empty($_POST['GetContent'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Antrian Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $GetContent=$_POST['GetContent'];
        //Explode
        $GetContent = explode(",", $GetContent);
        $kodebooking =$GetContent[0];
        $tanggal_kunjungan =$GetContent[1];
        //Buka data Antrian
        //Buka Data SIRS Online
        $response_sisrs_online=DataAntrianSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET',$tanggal_kunjungan);
        $php_array = json_decode($response_sisrs_online, true);
        $DataAntrianSirsOnline=$php_array['antrian'];
        $JumlahData=0;
        foreach ($DataAntrianSirsOnline as $item) {
            if($kodebooking==$item['kodebooking']){
                $antrianid = $item['antrianid'];
                $koders = $item['koders'];
                $kodebooking = $item['kodebooking'];
                $jenispasien = $item['jenispasien'];
                $nik = $item['nik'];
                $idpoli = $item['idpoli'];
                $kodepoli = $item['kodepoli'];
                $pasienbaru = $item['pasienbaru'];
                $norm = $item['norm'];
                $tanggalperiksa = $item['tanggalperiksa'];
                $kodedokter = $item['kodedokter'];
                $jampraktekawal = $item['jampraktekawal'];
                $jampraktekakhir = $item['jampraktekakhir'];
                $jeniskunjungan = $item['jeniskunjungan'];
                $nomorantrean = $item['nomorantrean'];
                $angkaantrean = $item['angkaantrean'];
                $estimasidilayani = $item['estimasidilayani'];
                $sisakuotajkn = $item['sisakuotajkn'];
                $kuotajkn = $item['kuotajkn'];
                $sisakuotanonjkn = $item['sisakuotanonjkn'];
                $kuotanonjkn = $item['kuotanonjkn'];
                if(!empty($item['nomorreferensi'])){
                    $nomorreferensi = $item['nomorreferensi'];
                }else{
                    $nomorreferensi ="";
                }
                
                $keterangan = $item['keterangan'];
                $tglupdate = $item['tglupdate'];
                //Buka Nama Pasien
                $id_antrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'id_antrian');
                $NamaPasien=getDataDetail($Conn,'pasien','id_pasien',$norm,'nama');
                $namapoli=getDataDetail($Conn,'poliklinik','kode',$kodepoli,'nama');
                $namadokter=getDataDetail($Conn,'dokter','kode',$kodedokter,'nama');
                $JumlahData=$JumlahData+1;
                //Estimasi Dilayani
                $jam_estimasidilayani=date('H:i',$estimasidilayani);
                $tanggal_estimasidilayani=date('Y-m-d',$estimasidilayani);
                //Explode Jam praktek
                $explode_jampraktekawal=explode(' ', $jampraktekawal);
                $tanggal_praktek_mulai=$explode_jampraktekawal['0'];
                $jam_praktek_mulai=$explode_jampraktekawal['1'];
                $explode_jampraktekakhir=explode(' ', $jampraktekakhir);
                $tanggal_praktek_akhir=$explode_jampraktekakhir['0'];
                $jam_praktek_akhir=$explode_jampraktekakhir['1'];
?>
        <input type="hidden" name="kodebooking" value="<?php echo "$kodebooking"; ?>">
        <input type="hidden" name="tanggal_kunjungan" value="<?php echo "$tanggal_kunjungan"; ?>">
        <div class="row mb-3"> 
            <div class="col col-md-12 table table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>ID</dt></th>
                            <th class="text-center"><dt>Keterangan</dt></th>
                            <th class="text-center"><dt>Waktu</dt></th>
                            <th class="text-center"><dt>Status</dt></th>
                        </tr>
                    </thead>
                    <tbody id="NotifikasiProsesUpdateTaskId">
                        <?php
                            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian_task_id WHERE kodebooking='$kodebooking'"));
                            if(empty($jml_data)){
                                echo '<tr>';
                                echo '  <td colspan="4" align="center">Tidak Ada Task ID Untuk Kode Booking Ini. Silahkan lakukan update task ID pada modul antrian SIMRS</td>';
                                echo '</tr>';
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM antrian_task_id WHERE kodebooking='$kodebooking' ORDER BY taskid ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $taskid = $data['taskid'];
                                    $taskname = $data['taskname'];
                                    $wakturs = $data['wakturs'];
                                    $keterangan = $data['keterangan'];
                                    //Format waktu
                                    $strtotime=strtotime($wakturs);
                                    $waktu=date('H:i',$strtotime);
                                    echo '<tr>';
                                    echo '  <td align="center"><small>'.$taskid.'</small></td>';
                                    echo '  <td align="left"><small>'.$taskname.'</small></td>';
                                    echo '  <td align="left"><small>'.$waktu.'</small></td>';
                                    echo '  <td align="left"><small>Ready</small></td>';
                                    echo '</tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php }}} ?>