<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    //Validasi akses
    if(empty($_POST['akses'])){
        echo '<span class="text-danger">Nama Entitas Akses Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['deskripsi'])){
            echo '<span class="text-danger">Setidaknya Anda Harus Menyertakan Penjelasan Agar Tidak Bingung</span>';
        }else{
            if(empty($_POST['id_akses_entitas'])){
                echo '<span class="text-danger">ID Entitas Tidak Boleh Kosong!</span>';
            }else{
                $akses=$_POST['akses'];
                $deskripsi=$_POST['deskripsi'];
                $id_akses_entitas=$_POST['id_akses_entitas'];
                //Validasi Jumlah Karakter
                $JumlahKarakterAkses=strlen($akses);
                $JumlahKarakterDeskripsi=strlen($deskripsi);
                if($JumlahKarakterAkses>20){
                    echo '<span class="text-danger">Nama entitas tidak boleh lebih dari 20 karakter</span>';
                }else{
                    if($JumlahKarakterDeskripsi>50){
                        echo '<span class="text-danger">Deskripsi entitas tidak boleh lebih dari 50 karakter</span>';
                    }else{
                        //Buat Data Referensi Checklist
                        $ListReferensi = array();
                        $QryReferensi = mysqli_query($Conn, "SELECT * FROM akses_ref");
                        while ($DataReferensi = mysqli_fetch_array($QryReferensi)) {
                            $id_akses_ref= $DataReferensi['id_akses_ref'];
                            if(!empty($_POST['Referensi'.$id_akses_ref.''])){
                                $StatusRef=$_POST['Referensi'.$id_akses_ref.''];
                            }else{
                                $StatusRef="No";
                            }
                            $h['id_akses_ref'] = $id_akses_ref;
                            $h['status'] = $StatusRef;
                            array_push($ListReferensi, $h);
                        }
                        $json = json_encode($ListReferensi, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); 
                        //Update Data entitas
                        $UpdateReferensi = mysqli_query($Conn,"UPDATE akses_entitas SET 
                            akses='$akses',
                            deskripsi='$deskripsi',
                            standar_referensi='$json'
                        WHERE id_akses_entitas='$id_akses_entitas'") or die(mysqli_error($Conn)); 
                        if($UpdateReferensi){
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Entitas Akses","Akses",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                $_SESSION['NotifikasiSwal']="Edit Entitas Akses Berhasil";
                                echo '<span class="text-success" id="NotifikasiEditEntitasBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Edit Data Entitas Gagal!</span>';
                        }
                    }
                }
            }
        }
    }
?>