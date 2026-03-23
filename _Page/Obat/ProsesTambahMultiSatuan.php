<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    $Updatetime=date("Y-m-d H:i:s");
    if(empty($_POST['id_obat'])){
        echo '<span class="text-danger">ID Obat Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['kode_multi'])){
            echo '<span class="text-danger">Kode Multi Satuan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['satuan_multi'])){
                echo '<span class="text-danger">satuan Multi Obat Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['isi_multi'])){
                    echo '<span class="text-danger">Jumlah Isi Kemasan Obat Tidak Boleh Kosong!</span>';
                }else{
                    //Variabel
                    $id_obat=$_POST['id_obat'];
                    $kode_multi=$_POST['kode_multi'];
                    $satuan_multi=$_POST['satuan_multi'];
                    $isi_multi=$_POST['isi_multi'];
                    if(empty($_POST['stok_multi'])){
                        $stok_multi=0;
                    }else{
                        $stok_multi=$_POST['stok_multi'];
                    }
                    if(empty($_POST['harga_multi_1'])){
                        $harga_multi_1=0;
                    }else{
                        $harga_multi_1=$_POST['harga_multi_1'];
                    }
                    if(empty($_POST['harga_multi_2'])){
                        $harga_multi_2=0;
                    }else{
                        $harga_multi_2=$_POST['harga_multi_2'];
                    }
                    if(empty($_POST['harga_multi_3'])){
                        $harga_multi_3=0;
                    }else{
                        $harga_multi_3=$_POST['harga_multi_3'];
                    }
                    if(empty($_POST['harga_multi_4'])){
                        $harga_multi_4=0;
                    }else{
                        $harga_multi_4=$_POST['harga_multi_4'];
                    }
                    //validasi format angka
                    if(!is_numeric($harga_multi_1)){
                        echo '<span class="text-danger">Harga Beli Hanya Boleh Angka</span>';
                    }else{
                        if(!is_numeric($harga_multi_2)){
                            echo '<span class="text-danger">Harga Eceran Hanya Boleh Angka</span>';
                        }else{
                            if(!is_numeric($harga_multi_3)){
                                echo '<span class="text-danger">Harga Grosir Hanya Boleh Angka</span>';
                            }else{
                                if(!is_numeric($harga_multi_4)){
                                    echo '<span class="text-danger">Harga Medis Hanya Boleh Angka</span>';
                                }else{
                                    if(!is_numeric($stok_multi)){
                                        echo '<span class="text-danger">Stok Obat Hanya Boleh Angka</span>';
                                    }else{
                                        //validasi kode obat tidak boleh sama
                                        $cek_kode=mysqli_query($Conn,"SELECT * FROM obat_multi WHERE kode_multi='$kode_multi'");
                                        $cek_kode_row=mysqli_num_rows($cek_kode);
                                        if($cek_kode_row>0){
                                            echo '<span class="text-danger">Kode Obat Sudah Ada!</span>';
                                        }else{
                                            //Simpan data
                                            $sql=mysqli_query($Conn,"INSERT INTO obat_multi (
                                                id_obat,
                                                kode_multi,
                                                satuan_multi,
                                                isi_multi,
                                                stok_multi,
                                                harga_multi_1,
                                                harga_multi_2,
                                                harga_multi_3,
                                                harga_multi_4,
                                                updatetime
                                            ) VALUES (
                                                '$id_obat',
                                                '$kode_multi',
                                                '$satuan_multi',
                                                '$isi_multi',
                                                '$stok_multi',
                                                '$harga_multi_1',
                                                '$harga_multi_2',
                                                '$harga_multi_3',
                                                '$harga_multi_4',
                                                '$Updatetime'
                                            )");
                                            if($sql){
                                                echo '<span class="text-success" id="NotifikasiTambahMultiSatuanBerhasil">Berhasil</span>';
                                            }else{
                                                echo '<span class="text-danger">Data Obat Gagal Ditambahkan!</span>';
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