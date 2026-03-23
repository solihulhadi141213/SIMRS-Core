<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Validasi id_referensi_alergi
    if(empty($_POST['id_referensi_alergi'])){
        echo '<span class="text-danger">ID Referensi Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['code'])){
            echo '<span class="text-danger">Code Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['display'])){
                echo '<span class="text-danger">Display Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['sumber'])){
                    echo '<span class="text-danger">Sumber Tidak Boleh Kosong</span>';
                }else{
                    if(empty($SessionIdAkses)){
                        echo '<span class="text-danger">Sesi Telah Berakhir. Silahkan Login Ulang Terlebih Dulu Untuk Melanjutkan Proses</span>';
                    }else{
                        $id_referensi_alergi=$_POST['id_referensi_alergi'];
                        $code=$_POST['code'];
                        $display=$_POST['display'];
                        $sumber=$_POST['sumber'];
                        //Buka Data Sebelumnya
                        $Kodelama=getDataDetail($Conn,'referensi_alergi','id_referensi_alergi',$id_referensi_alergi,'code');
                        if($Kodelama==$code){
                            $ValidasiDuplikat="0";
                        }else{
                            $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_alergi WHERE code='$code'"));
                        }
                        if(!empty($ValidasiDuplikat)){
                            echo '<span class="text-danger">Data Tersebut Sudah Ada Pada Database</span>';
                        }else{
                            $UpdateAlergi = mysqli_query($Conn,"UPDATE referensi_alergi SET 
                                code='$code',
                                display='$display',
                                sumber='$sumber'
                            WHERE id_referensi_alergi='$id_referensi_alergi'") or die(mysqli_error($Conn)); 
                            if($UpdateAlergi){
                                $JsonUrl="../../_Page/Log/Log.json";
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Referensi Alergi","Referensi Alergi",$SessionIdAkses,$JsonUrl);
                                if($MenyimpanLog=="Berhasil"){
                                    echo '<span class="text-success" id="NotifikasiEditAlergiBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Update Data Referensi Alergi Gagal!</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>