<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    //Validasi Form Data Yang Wajib Diisi
    if(empty($_POST['id_pasien'])){
        echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['tanggal_daftar'])){
            echo '<span class="text-danger">Tanggal Daftar Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['jam_daftar'])){
                echo '<span class="text-danger">Jam Daftar Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['nama'])){
                    echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['gender'])){
                        echo '<span class="text-danger">Gender Tidak Boleh Kosong</span>';
                    }else{
                        $id_pasien=$_POST['id_pasien'];
                        $tanggal_daftar=$_POST['tanggal_daftar'];
                        $jam_daftar=$_POST['jam_daftar'];
                        $tanggal_daftar="$tanggal_daftar $jam_daftar";
                        $nama=$_POST['nama'];
                        $gender=$_POST['gender'];
                        if(!empty($_POST['updatetime'])){
                            $updatetime=$_POST['updatetime'];
                        }else{
                            $updatetime=date('Y-m-d H:i');
                        }
                        //Validasi IHS
                        if(!empty($_POST['id_ihs'])){
                            $id_ihs=$_POST['id_ihs'];
                            $ValidasiIhs=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE id_ihs='$id_ihs'"));
                        }else{
                            $id_ihs="";
                            $ValidasiIhs="";
                        }
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
                        if(!empty($_POST['id_pasien_relasi'])){
                            $id_pasien_relasi=$_POST['id_pasien_relasi'];
                        }else{
                            $id_pasien_relasi="0";
                        }
                        if(!empty($_POST['status_relasi'])){
                            $status_relasi=$_POST['status_relasi'];
                        }else{
                            $status_relasi="";
                        }
                        if(!empty($_POST['status'])){
                            $status=$_POST['status'];
                        }else{
                            $status="Aktiv";
                        }
                        //Validasi Jumlah Karakter Kontak
                        if(strlen($kontak)>20){
                            echo '<span class="text-danger">Kontak Maksimal 20 Karakter</span>';
                        }else{
                            $ValidasiIdPasien=mysqli_num_rows(mysqli_query($Conn, "SELECT id_pasien FROM pasien WHERE id_pasien='$id_pasien'"));
                            if(!empty($ValidasiIdPasien)){
                                echo '<span class="text-danger">No.RM Sudah Terdaftar</span>';
                            }else{
                                if(!empty($ValidasiNik)){
                                    echo '<span class="text-danger">Nik Tersebut Sudah Terdaftar</span>';
                                }else{
                                    if(!empty($ValidasiBpjs)){
                                        echo '<span class="text-danger">No.Bpjs Tersebut Sudah Terdaftar</span>';
                                    }else{
                                        if(!empty($ValidasiIhs)){
                                            echo '<span class="text-danger">ID IHS Tersebut Sudah Terdaftar</span>';
                                        }else{
                                            $entry="INSERT INTO pasien (
                                                id_pasien,
                                                id_ihs,
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
                                                id_pasien_relasi,
                                                status_relasi,
                                                id_akses,
                                                nama_petugas,
                                                updatetime
                                            ) VALUES (
                                                '$id_pasien',
                                                '$id_ihs',
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
                                                '',
                                                '$status',
                                                '$id_pasien_relasi',
                                                '$status_relasi',
                                                '$SessionIdAkses',
                                                '$SessionNama',
                                                '$updatetime'
                                            )";
                                            $Input=mysqli_query($Conn, $entry);
                                            if($Input){
                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Pasien Baru","Pasien",$SessionIdAkses,$LogJsonFile);
                                                if($MenyimpanLog=="Berhasil"){
                                                    //Koneksi Database SIMRS Lama
                                                    include "../../_Config/ConnectionSimLama.php";
                                                    //Cek id_pasien apakah sudah ada pada database atau belum
                                                    $validasi_pasien_lama=mysqli_num_rows(mysqli_query($Conn2, "SELECT id_pasien FROM pasien WHERE id_pasien='$id_pasien'"));
                                                    if(empty($validasi_pasien_lama)){
                                                        //Apabila belum ada maka tambahkan
                                                        $entry2="INSERT INTO pasien (
                                                            id_pasien,
                                                            tanggal,
                                                            NIK,
                                                            no_kartu,
                                                            nama,
                                                            sex,
                                                            tempat_lahir,
                                                            tanggal_lahir,
                                                            propinsi,
                                                            kabupaten,
                                                            kecamatan,
                                                            desa,
                                                            rt_rw,
                                                            kontak,
                                                            an_kontak,
                                                            golongan_darah,
                                                            perkawinan,
                                                            pekerjaan,
                                                            status,
                                                            id_akses,
                                                            hapus,
                                                            kunci
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
                                                            '$penanggungjawab',
                                                            '$golongan_darah',
                                                            '$perkawinan',
                                                            '$pekerjaan',
                                                            '$status',
                                                            '$SessionIdAkses',
                                                            'No',
                                                            'No'
                                                        )";
                                                        $Input2=mysqli_query($Conn2, $entry2);
                                                    }



                                                    $_SESSION['NotifikasiSwal']="Tambah Pasien Berhasil";
                                                    echo '<span class="text-success" id="NotifikasiEditLocationBerhasil">Success</span>';
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                }
                                                echo '<span class="text-success" id="NotifikasiTambahPasienBerhasil" class="text-info">Success</span><br>';
                                                echo '<span class="text-success" id="UrlBack" class="text-info">index.php?Page=Pasien&Sub=DetailPasien&id='.$id_pasien.'</span>';
                                            }else{
                                                echo '<i class="text-danger">Tambah Pasien Gagal</i>';
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