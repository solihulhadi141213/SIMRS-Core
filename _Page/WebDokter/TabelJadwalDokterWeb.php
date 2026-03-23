<?php
    if(empty($_POST['GetIdDokter'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <span class="text-danger">ID Dokter Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_POST['GetIdDokter'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Jadwal By Dokter');
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
            echo '      <span class="text-danger">'.$err.'</span>';
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
                echo '      <span class="text-danger">'.$massage.'</span>';
                echo '  </div>';
                echo '</div>';
            }else{
                $ListJadwal=$JsonData['response']['list'];
                $JumlahJadwal=count($ListJadwal);
                if(empty($JumlahJadwal)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <span class="text-danger">Belum Ada Jadwal Dokter</span>';
                    echo '  </div>';
                    echo '</div>';
                }else{
?>
    <div class="row">
        <div class="col-md-12 mb-3 table table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Poliklinik</th>
                        <th>Jam</th>
                        <th>Kuota Non JKN</th>
                        <th>Kuota JKN</th>
                        <th>Waktu Kedatangan</th>
                        <th>Update Time</th>
                        <th>Opt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($_POST['nama_hari'])){
                            $no=1;
                            foreach($ListJadwal as $value){
                                $id_jadwal=$value['id_jadwal'];
                                $nama_poliklinik=$value['nama_poliklinik'];
                                $hari=$value['hari'];
                                $jam=$value['jam'];
                                $kuota_non_jkn=$value['kuota_non_jkn'];
                                $kuota_jkn=$value['kuota_jkn'];
                                $time_max=$value['time_max'];
                                $last_update=$value['last_update'];
                                echo '<tr>';
                                echo '  <td class="text-center">'.$no.'</td>';
                                echo '  <td class="text-left">'.$hari.'</td>';
                                echo '  <td class="text-left">'.$nama_poliklinik.'</td>';
                                echo '  <td class="text-left">'.$jam.'</td>';
                                echo '  <td class="text-left">'.$kuota_non_jkn.' Pasien</td>';
                                echo '  <td class="text-left">'.$kuota_jkn.' Pasien</td>';
                                echo '  <td class="text-left">'.$time_max.' Menit</td>';
                                echo '  <td class="text-left">'.$last_update.'</td>';
                                echo '  <td class="text-center">';
                                echo '      <div class="btn-group dropdown-split-inverse">';
                                echo '          <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">';
                                echo '              <i class="ti ti-settings"></i>';
                                echo '          </button>';
                                echo '          <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">';
                                echo '              <a href="javascript:void(0);" class="dropdown-item waves-effect waves-light" data-toggle="modal" data-target="#ModalEditJadwal" data-id="'.$id_jadwal.'" title="Edit jadwal">';
                                echo '                  <i class="ti ti-pencil"></i> Edit';
                                echo '              </a>';
                                echo '              <div class="dropdown-divider"></div>';
                                echo '              <a href="javascript:void(0);" class="dropdown-item waves-effect waves-light" data-toggle="modal" data-target="#ModalHapusJadwal" data-id="'.$id_jadwal.'" title="Hapus jadwal">';
                                echo '                  <i class="ti ti-close"></i> Hapus';
                                echo '              </a>';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </td>';
                                echo '</tr>';
                                $no++;
                            }
                        }else{
                            $nama_hari=$_POST['nama_hari'];
                            $no=1;
                            foreach($ListJadwal as $value){
                                $id_jadwal=$value['id_jadwal'];
                                $nama_poliklinik=$value['nama_poliklinik'];
                                $hari=$value['hari'];
                                $jam=$value['jam'];
                                $kuota_non_jkn=$value['kuota_non_jkn'];
                                $kuota_jkn=$value['kuota_jkn'];
                                $time_max=$value['time_max'];
                                $last_update=$value['last_update'];
                                if($hari==$nama_hari){
                                    echo '<tr>';
                                    echo '  <td class="text-center">'.$no.'</td>';
                                    echo '  <td class="text-left">'.$hari.'</td>';
                                    echo '  <td class="text-left">'.$nama_poliklinik.'</td>';
                                    echo '  <td class="text-left">'.$jam.'</td>';
                                    echo '  <td class="text-left">'.$kuota_non_jkn.' Pasien</td>';
                                    echo '  <td class="text-left">'.$kuota_jkn.' Pasien</td>';
                                    echo '  <td class="text-left">'.$time_max.' Menit</td>';
                                    echo '  <td class="text-left">'.$last_update.'</td>';
                                    echo '  <td class="text-center">';
                                    echo '      <div class="btn-group dropdown-split-inverse">';
                                    echo '          <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">';
                                    echo '              <i class="ti ti-settings"></i>';
                                    echo '          </button>';
                                    echo '          <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">';
                                    echo '              <a href="javascript:void(0);" class="dropdown-item waves-effect waves-light" data-toggle="modal" data-target="#ModalEditJadwal" data-id="'.$id_jadwal.'" title="Edit jadwal">';
                                    echo '                  <i class="ti ti-pencil"></i> Edit';
                                    echo '              </a>';
                                    echo '              <div class="dropdown-divider"></div>';
                                    echo '              <a href="javascript:void(0);" class="dropdown-item waves-effect waves-light" data-toggle="modal" data-target="#ModalHapusJadwal" data-id="'.$id_jadwal.'" title="Hapus jadwal">';
                                    echo '                  <i class="ti ti-close"></i> Hapus';
                                    echo '              </a>';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </td>';
                                    echo '</tr>';
                                }
                                $no++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php }}}} ?>