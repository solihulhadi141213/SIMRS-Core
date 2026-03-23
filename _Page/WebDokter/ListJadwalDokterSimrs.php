<?php
    if(empty($_POST['id_dokter'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <span class="text-danger">';
        echo '          ID Dokter Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=urlService('Detail Dokter');
        $KirimData = array(
            'api_key' => $api_key,
            'id_dokter' => $id_dokter
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!empty($err)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <span class="text-danger">';
            echo '          '.$err.'';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $JsonData =json_decode($content, true);
            if(!empty($JsonData['metadata']['massage'])){
                $massage=$JsonData['metadata']['massage'];
            }else{
                $massage="";
            }
            if(!empty($JsonData['metadata']['code'])){
                $code=$JsonData['metadata']['code'];
            }else{
                $code="";
            }
            if($code!==200){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <span class="text-danger">';
                echo '          '.$massage.'';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_dokter=$JsonData['response']['id_dokter'];
                $kode=$JsonData['response']['kode'];
                //Jumlah Jadwal di SIMRS
                $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE kode='$kode'")or die(mysqli_error($Conn));
                $DataDokter = mysqli_fetch_array($QryDokter);
                if(empty($DataDokter['id_dokter'])){
                    $id_dokter_simrs="";
                    $JumlahJadwalSimrs="";
                }else{
                    $id_dokter_simrs= $DataDokter['id_dokter'];
                    //Mencari jadwal dokter dengan id tersebut
                    $JumlahJadwalSimrs = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter_simrs'"));
                }
                if(empty($id_dokter_simrs)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <span class="text-danger">';
                    echo '          Dokter dengan kode '.$kode.' tersebut belum terdaftar di SIMRS!';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($JumlahJadwalSimrs)){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center">';
                        echo '      <span class="text-danger">';
                        echo '          Dokter dengan kode '.$kode.' belum memiliki data jadwal di SIMRS!';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
?>
    <input type="hidden" id="id_dokter" name="id_dokter" value="<?php echo $id_dokter;?>">
    <div class="row">
        <div class="col-md-12 table table-responsive pre-scrollable">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="form-control" name="CheckAll" id="CheckAll" value="Ya">
                        </th>
                        <th>
                            <dt>Poli</dt>
                        </th>
                        <th>
                            <dt>Hari</dt>
                        </th>
                        <th>
                            <dt>Jam</dt>
                        </th>
                        <th>
                            <dt>Kuota JKN</dt>
                        </th>
                        <th>
                            <dt>Kuota Non JKN</dt>
                        </th>
                        <th>
                            <dt>Waktu Maks</dt>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        //KONDISI PENGATURAN MASING FILTER
                        $query = mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter_simrs' ORDER BY hari ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $IdJadwalSimrs= $data['id_jadwal'];
                            $IdPoliSimrs= $data['id_poliklinik'];
                            $NamaDokter= $data['dokter'];
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
                            //Mencari Kode Poli SIMRS
                            $QryPoli = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$IdPoliSimrs'")or die(mysqli_error($Conn));
                            $DataPoli = mysqli_fetch_array($QryPoli);
                            $KodePoliSimrs= $DataPoli['kode'];
                            //Apakah Kode poliklinik tersebut ada pada data web
                            $UrlListPoli=urlService('List Poliklinik');
                            $keyword_by="kode";
                            $keyword=$KodePoliSimrs;
                            $short_by="ASC";
                            $order_by="kode";
                            $ListPoli=GetListInline($api_key,$UrlListPoli,$keyword_by,$keyword,$short_by,$order_by);
                            $JumlahCountPoli=count($ListPoli);
                            if(!empty($JumlahCountPoli)){
                                $ClassText="text-success";
                                $ClassCheck="";
                            }else{
                                $ClassText="text-danger";
                                $ClassCheck="disabled";
                            }
                    ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" <?php echo "$ClassCheck"; ?> class="form-control checkbox" name="IdJadwalSimrs[]" id="<?php echo "IdJadwalSimrs$no";?>" value="<?php echo "$IdJadwalSimrs";?>">
                                </td>
                                <td class="text-left <?php echo "$ClassText"; ?>">
                                    <label for="<?php echo "IdJadwalSimrs$no";?>"><?php echo "$poliklinik";?></label>
                                </td>
                                <td class="text-left"><?php echo "$hari";?></td>
                                <td class="text-left"><?php echo "$jam";?></td>
                                <td class="text-left"><?php echo "$kuota_jkn Pasien";?></td>
                                <td class="text-left"><?php echo "$kuota_non_jkn Pasien";?></td>
                                <td class="text-center"><?php echo "$time_max Menit";?></td>
                            </tr>
                    <?php
                        $no++; }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="NotifikasiSinkronisasiJadwal">
            <span class="text-primary">Pastikan anda memilih data jadwal yang ingin di set pada website</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-md btn-primary btn-block">
                Set Jadwal Ke Website
            </button>
        </div>
    </div>
<?php
                    }
                }
            }
        }
    }
?>