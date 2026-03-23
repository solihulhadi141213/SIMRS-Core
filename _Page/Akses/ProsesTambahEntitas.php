<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Validasi akses
    if(empty($_POST['akses'])){
        echo '<span class="text-danger">Nama Entitas Akses Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['deskripsi'])){
            echo '<span class="text-danger">Setidaknya Anda Harus Menyertakan Penjelasan Agar Tidak Bingung</span>';
        }else{
            $akses=$_POST['akses'];
            $deskripsi=$_POST['deskripsi'];
            //Validasi jumlah karakter
            $JumlahKarakterAkses=strlen($akses);
            $JumlahKarakterDeskripsi=strlen($deskripsi);
            if($JumlahKarakterAkses>20){
                echo '<span class="text-danger">Nama entitas tidak boleh lebih dari 20 karakter</span>';
            }else{
                if($JumlahKarakterDeskripsi>50){
                    echo '<span class="text-danger">Deskripsi entitas tidak boleh lebih dari 50 karakter</span>';
                }else{
                    $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_entitas WHERE akses='$akses'"));
                    if(!empty($ValidasiDuplikat)){
                        echo '<span class="text-danger">Entitas Tersebut Sudah Terdaftar</span>';
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
                        $entry="INSERT INTO akses_entitas (
                            akses ,
                            deskripsi,
                            standar_referensi
                        ) VALUES (
                            '$akses',
                            '$deskripsi',
                            '$json'
                        )";
                        $Input=mysqli_query($Conn, $entry);
                        if($Input){
                            $JsonUrl="../../_Page/Log/Log.json";
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Entitas Akses","Akses",$SessionIdAkses,$JsonUrl);
                            if($MenyimpanLog=="Berhasil"){
                                $_SESSION['NotifikasiSwal']="Tambah Entitas Akses Berhasil";
                                echo '<span class="text-success" id="NotifikasiTambahEntitasBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Tambah Data Entitas Gagal!</span>';
                        }
                    }
                }
            }
        }
    }
?>