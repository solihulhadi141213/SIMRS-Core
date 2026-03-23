<?php
    //Zona waktu dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Menangkap data
    if(empty($_POST['nama'])){
        echo '<span class="text-danger">Nama Petugas Penanggung Jawab Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['alamat'])){
            echo '<span class="text-danger">Alamat Operasional Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kontak'])){
                echo '<span class="text-danger">Kontak Supplier Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['company'])){
                    echo '<span class="text-danger">Nama Perusahaan/Badan Hukum Tidak Boleh Kosong</span>';
                }else{
                    $alamat=$_POST['alamat'];
                    $nama=$_POST['nama'];
                    $kontak=$_POST['kontak'];
                    $company=$_POST['company'];
                    if(empty($_POST['email'])){
                        $email="";
                        $ValidasiEmail="";
                    }else{
                        $email=$_POST['email'];
                        $ValidasiEmail=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier WHERE email='$email'"));
                    }
                    $ValidasiKontak=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier WHERE kontak='$kontak'"));
                    $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM supplier WHERE nama='$nama' AND company='$company'"));
                    if(preg_match('/^[0-9]+$/', $kontak)){
                        $ValidasiKarakterKontak=true;
                    }else{
                        $ValidasiKarakterKontak=false;
                    }
                    if(!empty($ValidasiEmail)){
                        echo '<span class="text-danger">Email Tersebut Sudah terdaftar, Gunakan Email Lain</span>';
                    }else{
                        if(!empty($ValidasiKontak)){
                            echo '<span class="text-danger">Kontak Tersebut Sudah terdaftar</span>';
                        }else{
                            if(!empty($ValidasiDuplikat)){
                                echo '<span class="text-danger">Kombinasi nama petugas dan perusahan sudah terdaftar</span>';
                            }else{
                                //Validasi Jumlah karakter
                                $LengthKontak = strlen($kontak);
                                if($LengthKontak>20){
                                    echo '<span class="text-danger">Kontak maksimal memiliki 20 karakter</span>';
                                }else{
                                    if($ValidasiKarakterKontak==false){
                                        echo '<span class="text-danger">Kontak hanya boleh angka</span>';
                                    }else{
                                        $entry="INSERT INTO supplier (
                                            nama,
                                            alamat,
                                            kontak,
                                            email,
                                            company
                                        ) VALUES (
                                            '$nama',
                                            '$alamat',
                                            '$kontak',
                                            '$email',
                                            '$company'
                                        )";
                                        $Input=mysqli_query($Conn, $entry);
                                        if($Input){
                                            $JsonUrl="../../_Page/Log/Log.json";
                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Supplier","Supplier",$SessionIdAkses,$JsonUrl);
                                            echo '<span class="text-info" id="NotifikasiTambahSupplierBerhasil">Berhasil</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada saat Proses Input</span>';
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