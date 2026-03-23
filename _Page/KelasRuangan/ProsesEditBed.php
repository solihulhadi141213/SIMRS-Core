<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap variabe;
    if(empty($_POST['id_ruang_rawat'])){
        echo '<span class="text-danger">ID Bed Tidak Boleh Kosong</span>';
    }else{
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
                        if(empty($_POST['bed'])){
                            echo '<span class="text-danger">Kode Bed Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['tipe'])){
                                echo '<span class="text-danger">Tipe Bed Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['status'])){
                                    echo '<span class="text-danger">Status Tidak Boleh Kosong</span>';
                                }else{
                                    $id_ruang_rawat=$_POST['id_ruang_rawat'];
                                    $kategori=$_POST['kategori'];
                                    $kodekelas=$_POST['kodekelas'];
                                    $kelas=$_POST['kelas'];
                                    $ruangan=$_POST['ruangan'];
                                    $bed=$_POST['bed'];
                                    $tipe=$_POST['tipe'];
                                    $status=$_POST['status'];
                                    $updatetime=date('Y-m-d H:i:s');
                                    //inisiasi tipe
                                    if($tipe=="bebas"){
                                        $bebas="1";
                                        $wanita="";
                                        $pria="";
                                    }else{
                                        if($tipe=="wanita"){
                                            $bebas="";
                                            $wanita="1";
                                            $pria="";
                                        }else{
                                            if($tipe=="pria"){
                                                $bebas="";
                                                $wanita="";
                                                $pria="1";
                                            }else{
                                                $bebas="";
                                                $wanita="";
                                                $pria="";
                                            }
                                        }
                                    }
                                    $Update= mysqli_query($Conn,"UPDATE ruang_rawat SET 
                                        bed='$bed',
                                        pria='$pria',
                                        wanita='$wanita',
                                        bebas='$bebas',
                                        status='$status',
                                        updatetime='$updatetime'
                                    WHERE id_ruang_rawat='$id_ruang_rawat'") or die(mysqli_error($Conn)); 
                                    if($Update){
                                        //Catat Log Aktivitas
                                        $WaktuLog=date('Y-m-d H:i');
                                        $nama_log="Edit Data Tempat Tidur Berhasil";
                                        $kategori_log="Kelas Ruangan";
                                        include "../../_Config/Log.php";
                                        echo '<span id="NotifikasiEditBedBerhasil">Berhasil</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi kegagalan pada saat input ke database</span>';
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