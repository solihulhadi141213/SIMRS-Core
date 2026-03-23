<?php
    //Koneksi dan SessionLogin
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Waktu Sekarang
    $now=date('Y-m-d H:i:s');
    $WaktuLog=date('Y-m-d H:i:s');
    //Apabila ID akses Tidak Ada
    if(empty($_POST['id_api_access'])){
        echo json_encode([
            'status' => 400,
            'message' => 'ID API Key Tidak Boleh Kosong!'
        ]);
        exit;
    }else{
        $id_api_access=$_POST['id_api_access'];
        //Proses hapus data
        $HapusApiKey = mysqli_query($Conn, "DELETE FROM api_access WHERE id_api_access='$id_api_access'") or die(mysqli_error($Conn));
        if($HapusApiKey) {
            $HapusLog = mysqli_query($Conn, "DELETE FROM api_log WHERE id_api_access='$id_api_access'") or die(mysqli_error($Conn));
            if($HapusLog){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus API Key","Setting",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                // Respons jika login berhasil
                    echo json_encode([
                        'status' => 200,
                        'message' => 'Success'
                    ]);
                }else{
                    if (empty($api_name)) {
                        echo json_encode([
                            'status' => 400,
                            'message' => 'Terjadi kesalahan pada saat menyimpan log'
                        ]);
                        exit;
                    }
                }
            }else{
                echo json_encode([
                    'status' => 400,
                    'message' => 'Terjadi kesalahan pada saat menghapus data API Log'
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'status' => 400,
                'message' => 'Terjadi kesalahan pada saat menghapus data pada mysql'
            ]);
            exit;
        }
    }
    $Conn->close();
?>