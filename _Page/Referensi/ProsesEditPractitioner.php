<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['nama'])){
        echo '<span class="text-danger">Nama Practitioner Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<span class="text-danger">Kategori Practitioner Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['gender'])){
                echo '<span class="text-danger">Gender Practitioner Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['status'])){
                    echo '<span class="text-danger">Status Practitioner Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['id_practitioner'])){
                        echo '<span class="text-danger">ID Practitioner Tidak Boleh Kosong!</span>';
                    }else{
                        $id_practitioner=$_POST['id_practitioner'];
                        $nama=$_POST['nama'];
                        $kategori=$_POST['kategori'];
                        $gender=$_POST['gender'];
                        $status=$_POST['status'];
                        //Buka Data Lama
                        $NikLama=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'nik');
                        $IdIhsLama=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'id_ihs_practitioner');
                        if(empty($_POST['nik'])){
                            $nik="";
                            $ValidasiNik="";
                        }else{
                            $nik=$_POST['nik'];
                            if($NikLama==$nik){
                                $ValidasiNik="";
                            }else{
                                $ValidasiNik=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_practitioner WHERE nik='$nik'"));
                            }
                        }
                        if(empty($_POST['id_ihs_practitioner'])){
                            $id_ihs_practitioner="";
                            $ValidasiIhsPractitioner="";
                        }else{
                            $id_ihs_practitioner=$_POST['id_ihs_practitioner'];
                            if($IdIhsLama==$id_ihs_practitioner){
                                $ValidasiIhsPractitioner="";
                            }else{
                                // $ValidasiIhsPractitioner = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_practitioner WHERE id_ihs_practitioner='$id_ihs_practitioner'"));
                                $ValidasiIhsPractitioner="";
                            }
                        }
                        if(empty($_POST['tanggal_lahir'])){
                            $tanggal_lahir="";
                        }else{
                            $tanggal_lahir=$_POST['tanggal_lahir'];
                        }
                        if(empty($_POST['kontak'])){
                            $kontak="";
                        }else{
                            $kontak=$_POST['kontak'];
                        }
                        if(empty($_POST['email'])){
                            $email="";
                        }else{
                            $email=$_POST['email'];
                        }
                    
                        //Validasi Duplikat Data
                        if(!empty($ValidasiNik)){
                            echo '<span class="text-danger">NIK Tersebut Sudah Terdaftar!</span>';
                        }else{
                            if(!empty($ValidasiIhsPractitioner)){
                                echo '<span class="text-danger">ID IHS Practitioner Tersebut Sudah Terdaftar!</span>';
                            }else{
                                //Simpan Data Ke Database
                                $UpdatePractitioner = mysqli_query($Conn,"UPDATE referensi_practitioner SET 
                                    id_ihs_practitioner='$id_ihs_practitioner',
                                    kategori='$kategori',
                                    nik='$nik',
                                    nama='$nama',
                                    gender='$gender',
                                    tanggal_lahir='$tanggal_lahir',
                                    kontak='$kontak',
                                    email='$email',
                                    status='$status'
                                WHERE id_practitioner='$id_practitioner'") or die(mysqli_error($Conn)); 
                                if($UpdatePractitioner){
                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Practitioner","Referensi",$SessionIdAkses,$LogJsonFile);
                                    if($MenyimpanLog=="Berhasil"){
                                        echo '<span class="text-success" id="NotifikasiEditPractitionerBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Tabah Practitioner Baru Gagal!</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>