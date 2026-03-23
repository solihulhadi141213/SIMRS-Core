<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap variabe;
    if(empty($_POST['kategori'])){
        echo '<span class="text-danger">Kategori Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kodekelas'])){
            echo '<span class="text-danger">Kode Kelas Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kelas'])){
                echo '<span class="text-danger">Kelas Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['ruangan'])){
                    echo '<span class="text-danger">Ruangan Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['ruangan'])){
                        echo '<span class="text-danger">Ruangan Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status Tidak Boleh Kosong</span>';
                        }else{
                            $kategori=$_POST['kategori'];
                            $kodekelas=$_POST['kodekelas'];
                            $kelas=$_POST['kelas'];
                            $ruangan=$_POST['ruangan'];
                            $status=$_POST['status'];
                            $updatetime=date('Y-m-d H:i:s');
                            //Input data ke database
                            $Input="INSERT INTO ruang_rawat (
                                kategori,
                                kodekelas,
                                kelas,
                                ruangan,
                                bed,
                                pria,
                                wanita,
                                bebas,
                                tarif,
                                status,
                                updatetime
                            ) VALUES (
                                '$kategori',
                                '$kodekelas',
                                '$kelas',
                                '$ruangan',
                                '',
                                '',
                                '',
                                '',
                                '',
                                'Aktif',
                                '$updatetime'
                            )";
                            $ProsesInput=mysqli_query($Conn, $Input);
                            if($ProsesInput){
                                echo '<span id="NotifikasiTambahRuanganBerhasil">Berhasil</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi kegagalan pada saat input ke database</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>