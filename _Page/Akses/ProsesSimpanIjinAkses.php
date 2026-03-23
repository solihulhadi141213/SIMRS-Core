<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_akses'])){
        echo '<span class="text-danger">ID Akses Tidak Boleh Kosong</span>';
    }else{
        $id_akses=$_POST['id_akses'];
        $JumlahTotalReferensi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ref"));
        $JumlahProses=0;
        $QryRef = mysqli_query($Conn, "SELECT * FROM akses_ref");
        while ($DataRef = mysqli_fetch_array($QryRef)) {
            $id_akses_ref= $DataRef['id_akses_ref'];
            //Menangkap Data
            if(empty($_POST['IdAksesRef'.$id_akses_ref.''])){
                $IdAksesRef="No";
            }else{
                $IdAksesRef="Yes";
            }
            //Cek Keberadaan akses_acc
            $QryAcc = mysqli_query($Conn,"SELECT * FROM akses_acc WHERE id_akses='$id_akses' AND id_akses_ref='$id_akses_ref'")or die(mysqli_error($Conn));
            $DataAcc = mysqli_fetch_array($QryAcc);
            if(empty($DataAcc['status'])){
                $SimpanAksesAcc="INSERT INTO akses_acc (
                    id_akses,
                    id_akses_ref,
                    status
                ) VALUES (
                    '$id_akses',
                    '$id_akses_ref',
                    '$IdAksesRef'
                )";
                $InputAksesAcc=mysqli_query($Conn, $SimpanAksesAcc);
                if($InputAksesAcc){
                    $JumlahProses=$JumlahProses+1;
                }else{
                    $JumlahProses=$JumlahProses+0;
                }
            }else{
                $Update = mysqli_query($Conn,"UPDATE akses_acc SET 
                    status='$IdAksesRef'
                WHERE id_akses='$id_akses' AND id_akses_ref='$id_akses_ref'") or die(mysqli_error($Conn)); 
                if($Update){
                    $JumlahProses=$JumlahProses+1;
                }else{
                    $JumlahProses=$JumlahProses+0;
                }
            }
        }
        if($JumlahProses==$JumlahTotalReferensi){
            $JsonUrl2="../../_Page/Log/Log.json";
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Ijin Akses","Akses",$SessionIdAkses,$JsonUrl2);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Update Ijin Akses Berhasil";
                echo '<span class="text-success" id="NotifikasiSimpanIjinAksesBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan ijin akses</span>';
        }
    }
?>