<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Pasien');
    //Validasi Form Data Yang Wajib Diisi
    if(empty($_POST['id_pasien'])){
        echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['tanggal_daftar'])){
            echo '<span class="text-danger">Tanggal Daftar Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['nama'])){
                echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['gender'])){
                    echo '<span class="text-danger">Gender Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['status'])){
                        echo '<span class="text-danger">Status Data Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['id_web_pasien'])){
                            echo '<span class="text-danger">ID Pasien Web Tidak Boleh Kosong</span>';
                        }else{
                            $id_web_pasien=$_POST['id_web_pasien'];
                            $id_pasien=$_POST['id_pasien'];
                            $tanggal_daftar=$_POST['tanggal_daftar'];
                            $nama=$_POST['nama'];
                            $gender=$_POST['gender'];
                            $status=$_POST['status'];
                            $updatetime=date('Y-m-d H:i');
                            //Buat variabel dari data lain yang tidak wajib
                            if(!empty($_POST['nik'])){
                                $nik=$_POST['nik'];
                                $ValidasiNik=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE nik='$nik'"));
                            }else{
                                $nik="";
                                $ValidasiNik="";
                            }
                            if(!empty($_POST['no_bpjs'])){
                                $no_bpjs=$_POST['no_bpjs'];
                                $ValidasiBpjs=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE no_bpjs='$no_bpjs'"));
                            }else{
                                $no_bpjs="";
                                $ValidasiBpjs="";
                            }
                            if(!empty($_POST['tempat_lahir'])){
                                $tempat_lahir=$_POST['tempat_lahir'];
                            }else{
                                $tempat_lahir="";
                            }
                            if(!empty($_POST['tanggal_lahir'])){
                                $tanggal_lahir=$_POST['tanggal_lahir'];
                            }else{
                                $tanggal_lahir="";
                            }
                            if(!empty($_POST['propinsi'])){
                                $propinsi=$_POST['propinsi'];
                            }else{
                                $propinsi="";
                            }
                            if(!empty($_POST['kabupaten'])){
                                $kabupaten=$_POST['kabupaten'];
                            }else{
                                $kabupaten="";
                            }
                            if(!empty($_POST['kecamatan'])){
                                $kecamatan=$_POST['kecamatan'];
                            }else{
                                $kecamatan="";
                            }
                            if(!empty($_POST['desa'])){
                                $desa=$_POST['desa'];
                            }else{
                                $desa="";
                            }
                            if(!empty($_POST['alamat'])){
                                $alamat=$_POST['alamat'];
                            }else{
                                $alamat="";
                            }
                            if(!empty($_POST['kontak'])){
                                $kontak=$_POST['kontak'];
                            }else{
                                $kontak="";
                            }
                            if(!empty($_POST['kontak_darurat'])){
                                $kontak_darurat=$_POST['kontak_darurat'];
                            }else{
                                $kontak_darurat="";
                            }
                            if(!empty($_POST['penanggungjawab'])){
                                $penanggungjawab=$_POST['penanggungjawab'];
                            }else{
                                $penanggungjawab="";
                            }
                            if(!empty($_POST['golongan_darah'])){
                                $golongan_darah=$_POST['golongan_darah'];
                            }else{
                                $golongan_darah="";
                            }
                            if(!empty($_POST['perkawinan'])){
                                $perkawinan=$_POST['perkawinan'];
                            }else{
                                $perkawinan="";
                            }
                            if(!empty($_POST['pekerjaan'])){
                                $pekerjaan=$_POST['pekerjaan'];
                            }else{
                                $pekerjaan="";
                            }
                            if(!empty($_POST['status'])){
                                $status=$_POST['status'];
                            }else{
                                $status="";
                            }
                            if(!empty($_POST['password'])){
                                $password=$_POST['password'];
                            }else{
                                $password="";
                            }
                            if(!empty($_POST['email'])){
                                $email=$_POST['email'];
                            }else{
                                $email="";
                            }
                            if(!empty($_POST['token'])){
                                $token=$_POST['token'];
                            }else{
                                $token="";
                            }
                            if(!empty($_POST['status_web'])){
                                $status_web=$_POST['status_web'];
                            }else{
                                $status_web="";
                            }
                            $hex_string="";
                            $ValidasiIdPasien=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien='$id_pasien'"));
                            if(!empty($ValidasiIdPasien)){
                                echo '<span class="text-danger">No.RM Sudah Digunakan</span>';
                            }else{
                                if(!empty($ValidasiNik)){
                                    echo '<span class="text-danger">Nik Tersebut Sudah Digunakan</span>';
                                }else{
                                    if(!empty($ValidasiBpjs)){
                                        echo '<span class="text-danger">No.Bpjs Tersebut Sudah Digunakan</span>';
                                    }else{
                                        $gambar="";
                                        $entry="INSERT INTO pasien (
                                            id_pasien,
                                            tanggal_daftar,
                                            nik,
                                            no_bpjs,
                                            nama,
                                            gender,
                                            tempat_lahir,
                                            tanggal_lahir,
                                            propinsi,
                                            kabupaten,
                                            kecamatan,
                                            desa,
                                            alamat,
                                            kontak,
                                            kontak_darurat,
                                            penanggungjawab,
                                            golongan_darah,
                                            perkawinan,
                                            pekerjaan,
                                            gambar,
                                            status,
                                            updatetime
                                        ) VALUES (
                                            '$id_pasien',
                                            '$tanggal_daftar',
                                            '$nik',
                                            '$no_bpjs',
                                            '$nama',
                                            '$gender',
                                            '$tempat_lahir',
                                            '$tanggal_lahir',
                                            '$propinsi',
                                            '$kabupaten',
                                            '$kecamatan',
                                            '$desa',
                                            '$alamat',
                                            '$kontak',
                                            '$kontak_darurat',
                                            '$penanggungjawab',
                                            '$golongan_darah',
                                            '$perkawinan',
                                            '$pekerjaan',
                                            '$gambar',
                                            '$status',
                                            '$updatetime'
                                        )";
                                        $Input=mysqli_query($Conn, $entry);
                                        if($Input){
                                            //Update Ke web
                                            $KirimData = array(
                                                'api_key' => $api_key,
                                                'id_web_pasien' => $id_web_pasien,
                                                'id_pasien' => $id_pasien,
                                                'tanggal_daftar' => $tanggal_daftar,
                                                'nik' => $nik,
                                                'bpjs' => $no_bpjs,
                                                'nama' => $nama,
                                                'propinsi' => $propinsi,
                                                'kabupaten' => $kabupaten,
                                                'kecamatan' => $kecamatan,
                                                'desa' => $desa,
                                                'alamat' => $alamat,
                                                'tepat_lahir' => $tempat_lahir,
                                                'tanggal_lahir' => $tanggal_lahir,
                                                'kontak' => $kontak,
                                                'gol_darah' => $golongan_darah,
                                                'sex' => $gender,
                                                'pekerjaan' => $pekerjaan,
                                                'perkawinan' => $perkawinan,
                                                'email' => $email,
                                                'password' => $password,
                                                'token' => $token,
                                                'status' => $status_web,
                                                'foto_profile' => $hex_string
                                            );
                                            $json = json_encode($KirimData);
                                            //Mulai CURL
                                            $ch = curl_init();
                                            curl_setopt($ch,CURLOPT_URL, "$Url");
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
                                                echo '<span class="text-danger">'.$err.'</span>';
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
                                                if($code==200){
                                                    $_SESSION['NotifikasiSwal']="Edit Pasien Berhasil";
                                                    echo '<span class="text-success" id="NotifikasiTambahPasienBerhasil">Success</span>';
                                                }else{
                                                    echo '<span class="text-danger">'.$massage.'</span>';
                                                }
                                            }
                                        }else{
                                            echo '<i id="NotifikasiTambah" class="text-danger">Tambah Pasien Gagal</i>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    
?>