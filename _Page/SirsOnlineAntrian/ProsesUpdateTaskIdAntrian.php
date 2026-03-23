<?php
    //Koneksi
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
    if(empty($_POST['kodebooking'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 table table-responsive">';
        echo '      <table class="col col-md-12 table table-bordered">';
        echo '          <thead>';
        echo '              <tr>';
        echo '                  <th class="text-center"><dt>ID</dt></th>';
        echo '                  <th class="text-center"><dt>Keterangan</dt></th>';
        echo '                  <th class="text-center"><dt>Waktu</dt></th>';
        echo '                  <th class="text-center"><dt>Status</dt></th>';
        echo '              </tr>';
        echo '          </thead>';
        echo '          <tbody>';
        echo '              <tr>';
        echo '                  <td colspan="4" align="center">Kode Booking Tidak Boleh Kosong</td>';
        echo '              </tr>';
        echo '          </tbody>';
        echo '      </table>';
        echo '  </div>';
        echo '</div>';
    }else{
        $kodebooking=$_POST['kodebooking'];
        echo '<input type="hidden" name="kodebooking" value="'.$kodebooking.'">';
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian_task_id WHERE kodebooking='$kodebooking'"));
        if(empty($jml_data)){
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-12 table table-responsive">';
            echo '      <table class="col col-md-12 table table-bordered">';
            echo '          <thead>';
            echo '              <tr>';
            echo '                  <th class="text-center"><dt>ID</dt></th>';
            echo '                  <th class="text-center"><dt>Keterangan</dt></th>';
            echo '                  <th class="text-center"><dt>Waktu</dt></th>';
            echo '                  <th class="text-center"><dt>Status</dt></th>';
            echo '              </tr>';
            echo '          </thead>';
            echo '          <tbody>';
            echo '              <tr>';
            echo '                  <td colspan="4" align="center">Tidak Ada Task ID Untuk Kode Booking  '.$kodebooking.'Ini. Silahkan lakukan update task ID pada modul antrian SIMRS</td>';
            echo '              </tr>';
            echo '          </tbody>';
            echo '      </table>';
            echo '  </div>';
            echo '</div>';
        }else{
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-12 table table-responsive">';
            echo '      <table class="col col-md-12 table table-bordered">';
            echo '          <thead>';
            echo '              <tr>';
            echo '                  <th class="text-center"><dt>ID</dt></th>';
            echo '                  <th class="text-center"><dt>Keterangan</dt></th>';
            echo '                  <th class="text-center"><dt>Waktu</dt></th>';
            echo '                  <th class="text-center"><dt>Status</dt></th>';
            echo '              </tr>';
            echo '          </thead>';
            echo '          <tbody>';
            $query = mysqli_query($Conn, "SELECT*FROM antrian_task_id WHERE kodebooking='$kodebooking' ORDER BY taskid ASC");
            while ($data = mysqli_fetch_array($query)) {
                $taskid = $data['taskid'];
                $taskname = $data['taskname'];
                $wakturs = $data['wakturs'];
                $keterangan = $data['keterangan'];
                //Format waktu
                $strtotime=strtotime($wakturs);
                $waktu=date('H:i',$strtotime);
                //Melakukan Update
                $data = array(
                    'kodebooking' => $kodebooking,
                    'taskid' => $taskid,
                    'waktu' => $strtotime
                );
                $json_data = json_encode($data);
                $KirimData=UpdateTaskIdAntrian($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                $response = json_decode($KirimData, true);
                $status=$response['task'][0]['status'];
                $message=$response['task'][0]['message'];
                echo '<tr>';
                echo '  <td align="center"><small>'.$taskid.'</small></td>';
                echo '  <td align="left"><small>'.$taskname.'</small></td>';
                echo '  <td align="left"><small>'.$waktu.'</small></td>';
                echo '  <td align="left"><small>'.$message.'</small></td>';
                echo '</tr>';
            }
            echo '          </tbody>';
            echo '      </table>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>