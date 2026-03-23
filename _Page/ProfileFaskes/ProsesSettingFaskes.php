<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Validasi Form Data
    if(empty($_POST['nama_faskes'])){
        echo '<span class="text-danger">Nama Faskes Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kode'])){
            echo '<span class="text-danger">Kode Faskes Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['alamat'])){
                echo '<span class="text-danger">Alamat Faskes Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['kontak'])){
                    echo '<span class="text-danger">Kontak Faskes Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['tahun_berdiri'])){
                        echo '<span class="text-danger">Tahun Berdiri Faskes Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['direktur'])){
                            echo '<span class="text-danger">Kepala Faskes Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['base_url'])){
                                echo '<span class="text-danger">Base URL Tidak Boleh Kosong</span>';
                            }else{
                                //Bentuk variabel
                                $nama_faskes=$_POST['nama_faskes'];
                                $kode=$_POST['kode'];
                                $alamat=$_POST['alamat'];
                                $kontak=$_POST['kontak'];
                                $tahun_berdiri=$_POST['tahun_berdiri'];
                                $direktur=$_POST['direktur'];
                                $base_url=$_POST['base_url'];
                                if(!empty($_POST['email'])){
                                    $email=$_POST['email'];
                                }else{
                                    $email="";
                                }
                                if(!empty($_POST['link_website'])){
                                    $link_website=$_POST['link_website'];
                                }else{
                                    $link_website="";
                                }
                                if(!empty($_POST['visi'])){
                                    $visi=$_POST['visi'];
                                }else{
                                    $visi="";
                                }
                                if(!empty($_POST['misi'])){
                                    $misi=$_POST['misi'];
                                }else{
                                    $misi="";
                                }
                                $ValidasiSetting=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_profile"));
                                //Apabila data akses grup belum ada maka input
                                if(empty($ValidasiSetting)){
                                    $entry="INSERT INTO setting_profile (
                                        nama_faskes,
                                        kode,
                                        alamat,
                                        kontak,
                                        email,
                                        link_website,
                                        base_url,
                                        tahun_berdiri,
                                        direktur,
                                        nisn,
                                        visi,
                                        misi
                                    ) VALUES (
                                        '$nama_faskes',
                                        '$kode',
                                        '$alamat',
                                        '$kontak',
                                        '$email',
                                        '$link_website',
                                        '$base_url',
                                        '$tahun_berdiri',
                                        '$direktur',
                                        '$nisn',
                                        '$visi',
                                        '$misi'
                                    )";
                                    $Input=mysqli_query($Conn, $entry);
                                    if($Input){
                                        echo '<i id="Notifikasi">Berhasil</i>';
                                    }else{
                                        echo '<i id="Notifikasi">Setting Profile Faskes Gagal</i>';
                                    }
                                }else{
                                    //Apabila sudah ada maka update
                                    $Update = mysqli_query($Conn,"UPDATE setting_profile SET 
                                        kode='$kode',
                                        nama_faskes='$nama_faskes',
                                        alamat='$alamat',
                                        kontak='$kontak',
                                        email='$email',
                                        link_website='$link_website',
                                        base_url='$base_url',
                                        tahun_berdiri='$tahun_berdiri',
                                        direktur='$direktur',
                                        visi='$visi',
                                        misi='$misi'
                                    WHERE id_profile='1'") or die(mysqli_error($Conn)); 
                                    if($Update){
                                        echo '<i id="Notifikasi">Berhasil</i>';
                                    }else{
                                        echo '<i id="Notifikasi">Setting Profile Faskes Gagal</i>';
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