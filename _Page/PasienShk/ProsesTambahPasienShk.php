<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Log
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['id_pasien_ibu'])){
        echo '<span class="text-danger">No.RM Ibu Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_ibu'])){
            echo '<span class="text-danger">Nama Ibu Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nik_ibu'])){
                echo '<span class="text-danger">NIK Ibu Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['id_pasien_anak'])){
                    echo '<span class="text-danger">No.RM Anak Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['tgllahir'])){
                        echo '<span class="text-danger">Tanggal Lahir Anak Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['gender'])){
                            echo '<span class="text-danger">Gender Anak Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['dom_alamat'])){
                                echo '<span class="text-danger">Alamat Tinggal Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['provinsi'])){
                                    echo '<span class="text-danger">Provinsi Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['kabkota'])){
                                        echo '<span class="text-danger">Kabupaten Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['kecamatan'])){
                                            echo '<span class="text-danger">Kecamatan Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['tgl_ambil_sampel'])){
                                                echo '<span class="text-danger">Tanggal Ambil Sample Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['tgl_kirim_sampel'])){
                                                    echo '<span class="text-danger">Tanggal Kirim Sample Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['tgl_lapor'])){
                                                        echo '<span class="text-danger">Tanggal Laporan Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['generate_id_shk'])){
                                                            echo '<span class="text-danger">Generate ID SHK Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            $id_pasien_ibu=$_POST['id_pasien_ibu'];
                                                            $nama_ibu=$_POST['nama_ibu'];
                                                            $nik_ibu=$_POST['nik_ibu'];
                                                            $id_pasien_anak=$_POST['id_pasien_anak'];
                                                            $tgllahir=$_POST['tgllahir'];
                                                            $gender=$_POST['gender'];
                                                            $dom_alamat=$_POST['dom_alamat'];
                                                            $provinsi=$_POST['provinsi'];
                                                            $kabkota=$_POST['kabkota'];
                                                            $kecamatan=$_POST['kecamatan'];
                                                            $tgl_ambil_sampel=$_POST['tgl_ambil_sampel'];
                                                            $tgl_kirim_sampel=$_POST['tgl_kirim_sampel'];
                                                            $tgl_lapor=$_POST['tgl_lapor'];
                                                            $generate_id_shk=$_POST['generate_id_shk'];
                                                            if(empty($_POST['nama_anak'])){
                                                                $nama_anak="";
                                                            }else{
                                                                $nama_anak=$_POST['nama_anak'];
                                                            }
                                                            if(empty($_POST['nik_anak'])){
                                                                $nik_anak="";
                                                            }else{
                                                                $nik_anak=$_POST['nik_anak'];
                                                            }
                                                            if(empty($_POST['jenis_fasyankes'])){
                                                                $jenis_fasyankes="0";
                                                            }else{
                                                                $jenis_fasyankes=$_POST['jenis_fasyankes'];
                                                            }
                                                            if(empty($_POST['kode_perujuk'])){
                                                                $kode_perujuk="";
                                                            }else{
                                                                $kode_perujuk=$_POST['kode_perujuk'];
                                                            }
                                                            if(empty($_POST['nama_fayankes_perujuk'])){
                                                                $nama_fayankes_perujuk="";
                                                            }else{
                                                                $nama_fayankes_perujuk=$_POST['nama_fayankes_perujuk'];
                                                            }
                                                            if(empty($_POST['id_shk'])){
                                                                $id_shk="";
                                                                $ValidasiIdShkDuplikat="";
                                                            }else{
                                                                $id_shk=$_POST['id_shk'];
                                                                $ValidasiIdShkDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien_shk WHERE id_shk='$id_shk'"));
                                                            }
                                                            if(!empty($ValidasiIdShkDuplikat)){
                                                                echo '<span class="text-danger">ID SHK tersebut sudah ada pada database!</span>';
                                                            }else{
                                                                //Mencari Kode Provinsi
                                                                $QryParam = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE nama='$provinsi'")or die(mysqli_error($Conn));
                                                                $DataParam = mysqli_fetch_array($QryParam);
                                                                if(empty($DataParam['kode'])){
                                                                    echo '<span class="text-danger">Kode Provinsi Untuk '.$provinsi.' Tidak Ditemukan!</span>';
                                                                }else{
                                                                    $provinsi=$DataParam['kode'];
                                                                    //Mencari Kode kabkot
                                                                    $QryParam = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE nama='$kabkota' AND kategori='Kota Kabupaten' AND kode like '%$provinsi%'")or die(mysqli_error($Conn));
                                                                    $DataParam = mysqli_fetch_array($QryParam);
                                                                    if(empty($DataParam['kode'])){
                                                                        echo '<span class="text-danger">Kode Kabupaten/Kota Untuk '.$kabkota.' Tidak Ditemukan!</span>';
                                                                    }else{
                                                                        $kabkota=$DataParam['kode'];
                                                                        //Mencari Kode kecamatan
                                                                        $QryParam = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE nama='$kecamatan' AND kategori='Kecamatan' AND kode like '%$kabkota%'")or die(mysqli_error($Conn));
                                                                        $DataParam = mysqli_fetch_array($QryParam);
                                                                        if(empty($DataParam['kode'])){
                                                                            echo '<span class="text-danger">Kode Kecamatan Untuk '.$kecamatan.' Tidak Ditemukan!</span>';
                                                                        }else{
                                                                            $kecamatan=$DataParam['kode'];
                                                                            $umur=date_diff(date_create($tgllahir), date_create('today'))->y;
                                                                            if($generate_id_shk=="No"){
                                                                                if(empty($_POST['id_shk'])){
                                                                                    echo '<span class="text-danger">ID SHK SIRS Online Tidak Boleh Kosong!</span>';
                                                                                }else{
                                                                                    //Tambah Ke Database Tanpa Generate
                                                                                    $entry="INSERT INTO pasien_shk (
                                                                                        id_shk,
                                                                                        id_pasien_ibu,
                                                                                        nik_ibu,
                                                                                        nama_ibu,
                                                                                        id_pasien_anak,
                                                                                        nik_anak,
                                                                                        nama_anak,
                                                                                        tgllahir,
                                                                                        gender_anak,
                                                                                        alamat,
                                                                                        provinsi,
                                                                                        kabkota,
                                                                                        kecamatan,
                                                                                        tgl_ambil_sampel,
                                                                                        tgl_kirim_sampel,
                                                                                        tgl_lapor,
                                                                                        kode_perujuk,
                                                                                        nama_fayankes_perujuk,
                                                                                        jenis_fasyankes,
                                                                                        id_akses
                                                                                    ) VALUES (
                                                                                        '$id_shk',
                                                                                        '$id_pasien_ibu',
                                                                                        '$nik_ibu',
                                                                                        '$nama_ibu',
                                                                                        '$id_pasien_anak',
                                                                                        '$nik_anak',
                                                                                        '$nama_anak',
                                                                                        '$tgllahir',
                                                                                        '$gender',
                                                                                        '$dom_alamat',
                                                                                        '$provinsi',
                                                                                        '$kabkota',
                                                                                        '$kecamatan',
                                                                                        '$tgl_ambil_sampel',
                                                                                        '$tgl_kirim_sampel',
                                                                                        '$tgl_lapor',
                                                                                        '$kode_perujuk',
                                                                                        '$nama_fayankes_perujuk',
                                                                                        '$jenis_fasyankes',
                                                                                        '$SessionIdAkses'
                                                                                    )";
                                                                                    $Input=mysqli_query($Conn, $entry);
                                                                                    if($Input){
                                                                                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Tambah Pasien SHK","Pasien SHK",$SessionIdAkses,$LogJsonFile);
                                                                                        if($MenyimpanLog=="Berhasil"){
                                                                                            $_SESSION['NotifikasiSwal']="Tambah Pasien SHK Berhasil";
                                                                                            echo '<span class="text-success" id="NotifikasiTambahPasienShkBerhasil">Success</span>';
                                                                                        }else{
                                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                        }
                                                                                        echo '<span class="text-success" id="NotifikasiTambahPasienShkBerhasil" class="text-info">Success</span><br>';
                                                                                        echo '<span class="text-success" id="UrlBack" class="text-info">index.php?Page=PasienShk&Sub=DetailPasienShk&id_shk='.$id_shk.'</span>';
                                                                                    }else{
                                                                                        echo '<i class="text-danger">Tambah Pasien SHK Gagal</i>';
                                                                                    }
                                                                                }
                                                                            }else{
                                                                                //Buat json
                                                                                $data = array(
                                                                                    'koders' => $x_id_rs,
                                                                                    'nik_ibu' => $nik_ibu,
                                                                                    'nama_ibu' => $nama_ibu,
                                                                                    'nik_anak' => $nik_anak,
                                                                                    'nama_anak' => $nama_anak,
                                                                                    'tgllahir' => $tgllahir,
                                                                                    'gender' => $gender,
                                                                                    'umur' => $umur,
                                                                                    'alamat' => $dom_alamat,
                                                                                    'provinsi' => $provinsi,
                                                                                    'kabkota' => $kabkota,
                                                                                    'kecamatan' => $kecamatan,
                                                                                    'tgl_ambil_sampel' => $tgl_ambil_sampel,
                                                                                    'tgl_kirim_sampel' => $tgl_kirim_sampel,
                                                                                    'tgl_lapor' => $tgl_lapor,
                                                                                    'kode_perujuk' => $kode_perujuk,
                                                                                    'nama_fayankes_perujuk' => $nama_fayankes_perujuk,
                                                                                    'jenis_fasyankes' => $jenis_fasyankes
                                                                                );
                                                                                $json_data = json_encode($data);
                                                                                //Kirim Data
                                                                                $KirimData=CreatPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                                                                                if(empty($KirimData)){
                                                                                    echo '<span class="text-danger">Tidak ada response apapun dari service SIRS Online</span>';
                                                                                }else{
                                                                                    $response = json_decode($KirimData, true);
                                                                                    if($response['shk'][0]['status']=="200"){
                                                                                        if(!empty($response['shk'][0]['id_shk'])){
                                                                                            $status=$response['shk'][0]['status'];
                                                                                            $id_shk=$response['shk'][0]['id_shk'];
                                                                                            $message=$response['shk'][0]['message'];
                                                                                            //Simpan Ke Database
                                                                                            $entry="INSERT INTO pasien_shk (
                                                                                                id_shk,
                                                                                                id_pasien_ibu,
                                                                                                nik_ibu,
                                                                                                nama_ibu,
                                                                                                id_pasien_anak,
                                                                                                nik_anak,
                                                                                                nama_anak,
                                                                                                tgllahir,
                                                                                                gender_anak,
                                                                                                alamat,
                                                                                                provinsi,
                                                                                                kabkota,
                                                                                                kecamatan,
                                                                                                tgl_ambil_sampel,
                                                                                                tgl_kirim_sampel,
                                                                                                tgl_lapor,
                                                                                                kode_perujuk,
                                                                                                nama_fayankes_perujuk,
                                                                                                jenis_fasyankes,
                                                                                                id_akses
                                                                                            ) VALUES (
                                                                                                '$id_shk',
                                                                                                '$id_pasien_ibu',
                                                                                                '$nik_ibu',
                                                                                                '$nama_ibu',
                                                                                                '$id_pasien_anak',
                                                                                                '$nik_anak',
                                                                                                '$nama_anak',
                                                                                                '$tgllahir',
                                                                                                '$gender',
                                                                                                '$dom_alamat',
                                                                                                '$provinsi',
                                                                                                '$kabkota',
                                                                                                '$kecamatan',
                                                                                                '$tgl_ambil_sampel',
                                                                                                '$tgl_kirim_sampel',
                                                                                                '$tgl_lapor',
                                                                                                '$kode_perujuk',
                                                                                                '$nama_fayankes_perujuk',
                                                                                                '$jenis_fasyankes',
                                                                                                '$SessionIdAkses'
                                                                                            )";
                                                                                            $Input=mysqli_query($Conn, $entry);
                                                                                            if($Input){
                                                                                                //Mencari id_pasien_shk
                                                                                                $QryParam = mysqli_query($Conn,"SELECT * FROM pasien_shk WHERE id_akses='$SessionIdAkses' ORDER BY id_pasien_shk DESC")or die(mysqli_error($Conn));
                                                                                                $DataParam = mysqli_fetch_array($QryParam);
                                                                                                $id_pasien_shk=$DataParam['id_pasien_shk'];
                                                                                                $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Tambah Pasien SHK","Pasien SHK",$SessionIdAkses,$LogJsonFile);
                                                                                                if($MenyimpanLog=="Berhasil"){
                                                                                                    $_SESSION['NotifikasiSwal']="Tambah Pasien SHK Berhasil";
                                                                                                    echo '<span class="text-success" id="NotifikasiTambahPasienShkBerhasil">Success</span>';
                                                                                                    echo '<span class="text-success" id="UrlBack" class="text-info">index.php?Page=PasienShk&Sub=DetailPasienShk&id='.$id_pasien_shk.'</span>';
                                                                                                }else{
                                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                                }
                                                                                            }else{
                                                                                                echo '<i class="text-danger">Tambah Pasien SHK Gagal <br> '.$json_data.'</i>';
                                                                                            }
                                                                                        }else{
                                                                                            $message=$response['shk'][0]['message'];
                                                                                            echo '<span class="text-danger">Creat Pasien SHK Gagal!<br> Pesan: '.$message.'</span>';
                                                                                        }
                                                                                    }else{
                                                                                        $message=$response['shk'][0]['message'];
                                                                                        echo '<span class="text-danger">Creat Pasien SHK Gagal!<br> Pesan: '.$message.'</span>';
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
    }
?>