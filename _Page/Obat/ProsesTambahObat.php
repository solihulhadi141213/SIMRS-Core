<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $Updatetime=date("Y-m-d H:i:s");
    if(empty($_POST['kode'])){
        echo '<span class="text-danger">Kode Obat/Alkes Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_obat'])){
            echo '<span class="text-danger">Nama Obat/Alkes Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['kategori'])){
                echo '<span class="text-danger">Kategori Obat/Alkes Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['satuan'])){
                    echo '<span class="text-danger">Satuan Obat/Alkes Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['isi'])){
                        echo '<span class="text-danger">Isi Per Kemasan Obat/Alkes Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['kelompok'])){
                            echo '<span class="text-danger">Kelompok Obat/Alkes Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['stok'])){
                                echo '<span class="text-danger">Kelompok Obat/Alkes Tidak Boleh Kosong!</span>';
                            }else{
                                //Variabel
                                $kode=$_POST['kode'];
                                $nama_obat=$_POST['nama_obat'];
                                $kategori=$_POST['kategori'];
                                $satuan=$_POST['satuan'];
                                $isi=$_POST['isi'];
                                $kelompok=$_POST['kelompok'];
                                if(empty($_POST['stok'])){
                                    $stok=0;
                                }else{
                                    $stok=$_POST['stok'];
                                }
                                if(empty($_POST['harga'])){
                                    $harga=0;
                                }else{
                                    $harga=$_POST['harga'];
                                }
                                if(empty($_POST['stok_min'])){
                                    $stok_min=0;
                                }else{
                                    $stok_min=$_POST['stok_min'];
                                }
                                if(empty($_POST['keterangan'])){
                                    $keterangan="";
                                }else{
                                    $keterangan=$_POST['keterangan'];
                                }
                                //validasi format angka
                                if(!is_numeric($harga)){
                                    echo '<span class="text-danger">Harga Beli Hanya Boleh Angka</span>';
                                }else{
                                    if(!is_numeric($stok)){
                                        echo '<span class="text-danger">Stok Obat Hanya Boleh Angka</span>';
                                    }else{
                                        if(!is_numeric($stok_min)){
                                            echo '<span class="text-danger">Stok Minimal Obat Hanya Boleh Angka</span>';
                                        }else{
                                            //validasi kode obat tidak boleh sama
                                            $cek_kode=mysqli_query($Conn,"SELECT * FROM obat WHERE kode='$kode'");
                                            $cek_kode_row=mysqli_num_rows($cek_kode);
                                            if($cek_kode_row>0){
                                                echo '<span class="text-danger">Kode Obat Sudah Ada!</span>';
                                            }else{
                                                //Simpan data
                                                $sql=mysqli_query($Conn,"INSERT INTO obat (
                                                    kode,
                                                    nama,
                                                    kelompok,
                                                    kategori,
                                                    satuan,
                                                    isi,
                                                    stok,
                                                    harga,
                                                    stok_min,
                                                    tanggal,
                                                    updatetime,
                                                    keterangan
                                                ) VALUES (
                                                    '$kode',
                                                    '$nama_obat',
                                                    '$kelompok',
                                                    '$kategori',
                                                    '$satuan',
                                                    '$isi',
                                                    '$stok',
                                                    '$harga',
                                                    '$stok_min',
                                                    '$Updatetime',
                                                    '$Updatetime',
                                                    '$keterangan'
                                                )");
                                                if($sql){
                                                    $MenyimpanLog=getSaveLog($Conn,$Updatetime,$SessionNama,"Input kategori Harga Obat","Obat",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        //Buka ID Obat
                                                        $id_obat=getDataDetail($Conn,'obat','kode',$kode,'id_obat');
                                                        //Buka Kategori
                                                        $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_kategori_harga"));
                                                        //Apabila Kategori Ada Maka Buka List Datanya
                                                        if(!empty($JumlahKategori)){
                                                            $query = mysqli_query($Conn, "SELECT*FROM obat_kategori_harga ORDER BY kategori_harga ASC");
                                                            while ($data = mysqli_fetch_array($query)) {
                                                                $id_kategori_harga= $data['id_kategori_harga'];
                                                                $kategori_harga= $data['kategori_harga'];
                                                                //Apakah ada harga multi yang ditangkap?
                                                                if(!empty($_POST['MultiHarga'.$id_kategori_harga.''])){
                                                                    $HargaMulti=$_POST['MultiHarga'.$id_kategori_harga.''];
                                                                    //Apabila ada maka simpan
                                                                    $TambahHargaMulti=mysqli_query($Conn,"INSERT INTO obat_harga (
                                                                        id_obat,
                                                                        id_kategori_harga,
                                                                        kategori_harga,
                                                                        harga
                                                                    ) VALUES (
                                                                        '$id_obat',
                                                                        '$id_kategori_harga',
                                                                        '$kategori_harga',
                                                                        '$HargaMulti'
                                                                    )");
                                                                }
                                                            }
                                                        }
                                                        echo '<span class="text-success" id="NotifikasiTambahObatBerhasil">Success</span>';
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data log</span>';
                                                    }
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
    }
?>