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
    if(empty($_POST['id_pasien_shk'])){
        echo '<span class="text-danger">ID Pasien SHK Tidak Boleh Kosong!</span>';
    }else{
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
                                                            if(empty($_POST['update_sisrs_online'])){
                                                                echo '<span class="text-danger">Keputusan Untuk Update Ke SIRS Online Tidak Boleh Kosong!</span>';
                                                            }else{
                                                                $id_pasien_shk=$_POST['id_pasien_shk'];
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
                                                                $update_sisrs_online=$_POST['update_sisrs_online'];
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
                                                                    $id_shk_lama=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_shk');
                                                                    if($id_shk==$id_shk_lama){
                                                                        $ValidasiIdShkDuplikat="";
                                                                    }else{
                                                                        $ValidasiIdShkDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien_shk WHERE id_shk='$id_shk'"));
                                                                    }
                                                                    
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
                                                                                if($update_sisrs_online=="Ya"){
                                                                                    if(empty($_POST['id_shk'])){
                                                                                        $ProsesUpdateSirsOnline='<span class="text-danger">ID SHK SIRS Online Tidak Boleh Kosong!</span>';
                                                                                    }else{
                                                                                        //Update Ke SIRS Online
                                                                                        //Buat json
                                                                                        $data = array(
                                                                                            'id_shk' => $id_shk,
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
                                                                                        $KirimData=UpdatePasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                                                                                        if(empty($KirimData)){
                                                                                            $ProsesUpdateSirsOnline='<span class="text-danger">Tidak ada response apapun dari service SIRS Online</span>';
                                                                                        }else{
                                                                                            $response = json_decode($KirimData, true);
                                                                                            if($response['shk'][0]['status']=="200"){
                                                                                                $ProsesUpdateSirsOnline="Berhasil";
                                                                                            }else{
                                                                                                $pesan=$response['shk'][0]['message'];
                                                                                                $ProsesUpdateSirsOnline='<span class="text-danger">'.$pesan.'</span>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }else{
                                                                                    $ProsesUpdateSirsOnline="Berhasil";
                                                                                }
                                                                                //Apabila Proses Update Ke SIRS Online Berhasil
                                                                                if($ProsesUpdateSirsOnline!=="Berhasil"){
                                                                                    echo "$ProsesUpdateSirsOnline";
                                                                                }else{
                                                                                    //Update Ke Database
                                                                                    $UpdatePasienShk= mysqli_query($Conn,"UPDATE pasien_shk SET 
                                                                                        id_shk='$id_shk',
                                                                                        id_pasien_ibu='$id_pasien_ibu',
                                                                                        nik_ibu='$nik_ibu',
                                                                                        nama_ibu='$nama_ibu',
                                                                                        id_pasien_anak='$id_pasien_anak',
                                                                                        nik_anak='$nik_anak',
                                                                                        nama_anak='$nama_anak',
                                                                                        tgllahir='$tgllahir',
                                                                                        gender_anak='$gender',
                                                                                        alamat='$dom_alamat',
                                                                                        provinsi='$provinsi',
                                                                                        kabkota='$kabkota',
                                                                                        kecamatan='$kecamatan',
                                                                                        tgl_ambil_sampel='$tgl_ambil_sampel',
                                                                                        tgl_kirim_sampel='$tgl_kirim_sampel',
                                                                                        tgl_lapor='$tgl_lapor',
                                                                                        kode_perujuk='$kode_perujuk',
                                                                                        nama_fayankes_perujuk='$nama_fayankes_perujuk',
                                                                                        jenis_fasyankes='$jenis_fasyankes'
                                                                                    WHERE id_pasien_shk='$id_pasien_shk'") or die(mysqli_error($Conn));
                                                                                    if($UpdatePasienShk){
                                                                                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Edit Pasien SHK","Pasien SHK",$SessionIdAkses,$LogJsonFile);
                                                                                        if($MenyimpanLog=="Berhasil"){
                                                                                            $_SESSION['NotifikasiSwal']="Edit Pasien SHK Berhasil";
                                                                                            echo '<span class="text-success" id="NotifikasiEditPasienShkBerhasil">Success</span>';
                                                                                            echo '<span class="text-success" id="UrlBack">index.php?Page=PasienShk&&Sub=DetailPasienShk&id='.$id_pasien_shk.'</span>';
                                                                                        }else{
                                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                        }
                                                                                    }else{
                                                                                        echo '<i class="text-danger">Tambah Pasien SHK Gagal</i>';
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