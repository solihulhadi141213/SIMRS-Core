<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $Updatetime=date('Y-m-d H:i:s');
    if(empty($_POST['id_obat'])){
        echo '  <span class="text-danger">';
        echo '      ID Obat Tidak Boleh Kosong!';
        echo '  </span>';
    }else{
        if(empty($_POST['tanggal'])){
            echo '  <span class="text-danger">';
            echo '      Tanggal Periode Stok Opename Tidak Boleh Kosong!';
            echo '  </span>';
        }else{
            if(empty($_POST['id_obat_storage'])){
                $id_obat_storage="0";
            }else{
                $id_obat_storage=$_POST['id_obat_storage'];
            }
            if(empty($_POST['stok_awal'])){
                $stok_awal="0";
            }else{
                $stok_awal=$_POST['stok_awal'];
            }
            if(empty($_POST['stok_akhir'])){
                $stok_akhir="0";
            }else{
                $stok_akhir=$_POST['stok_akhir'];
            }
            if(empty($_POST['keterangan'])){
                $keterangan="";
            }else{
                $keterangan=$_POST['keterangan'];
            }
            $id_obat=$_POST['id_obat'];
            $tanggal=$_POST['tanggal'];
            //Nama Penyimpanan
            if(empty($id_obat_storage)){
                $NamaPenyimpanan='Penyimpanan Utama';
            }else{
                $NamaPenyimpanan=getDataDetail($Conn,'obat_storage','id_obat_storage',$id_obat_storage,'nama_penyimpanan');
            }
            //Nama dan Kode Obat
            $NamaObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
            $KodeObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
            $SatuanObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
            $HargaObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'harga');
            $Selisih=$stok_akhir-$stok_awal;
            //Validasi Duplikat
            $JumlahDataDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM obat_so WHERE id_obat_storage='$id_obat_storage' AND id_obat='$id_obat' AND tanggal='$tanggal'"));
            if(!empty($JumlahDataDuplikat)){
                echo '  <span class="text-danger">';
                echo '      Data Tersebut Sudah Ada!';
                echo '  </span>';
            }else{
                //Validasi Hanya Integer
                if(is_numeric($stok_akhir) && is_int($stok_akhir + 0)) {
                    //Insert
                    $entry="INSERT INTO obat_so (
                        id_obat_storage,
                        id_obat,
                        tanggal,
                        nama_penyimpanan,
                        kode,
                        nama,
                        satuan,
                        harga,
                        stok_awal,
                        stok_akhir,
                        stok_selisih,
                        keterangan,
                        updatetime
                    ) VALUES (
                        '$id_obat_storage',
                        '$id_obat',
                        '$tanggal',
                        '$NamaPenyimpanan',
                        '$KodeObat',
                        '$NamaObat',
                        '$SatuanObat',
                        '$HargaObat',
                        '$stok_awal',
                        '$stok_akhir',
                        '$Selisih',
                        '$keterangan',
                        '$Updatetime'
                    )";
                    $Input=mysqli_query($Conn, $entry);
                    if($Input){
                        //Update Stok Obat Sesuai Penyimpanannya
                        if(empty($id_obat_storage)){
                            $UpdateStokObat=mysqli_query($Conn, "UPDATE obat SET stok='$stok_akhir' WHERE id_obat='$id_obat'");
                            if($UpdateStokObat){
                                //Simpan Log
                                $JsonUrl="../../_Page/Log/Log.json";
                                $MenyimpanLog=getSaveLog($Conn,$Updatetime,$SessionNama,"Tambah Stok Opename Berhasil","Stok Opename",$SessionIdAkses,$JsonUrl);
                                echo '<span class="text-danger" id="NotifikasiTambahSoBerhasil">Success</span>';
                            }else{
                                echo '  <span class="text-danger">';
                                echo '      Terjadi kesalahan pada saat melakukan update data obat di penyimpanan utama';
                                echo '  </span>';
                            }
                        }else{
                            $UpdateStokObat=mysqli_query($Conn, "UPDATE obat_posisi SET stok='$stok_akhir' WHERE id_obat='$id_obat' AND id_obat_storage='$id_obat_storage'");
                            if($UpdateStokObat){
                                //Simpan Log
                                $JsonUrl="../../_Page/Log/Log.json";
                                $MenyimpanLog=getSaveLog($Conn,$Updatetime,$SessionNama,"Tambah Stok Opename Berhasil","Stok Opename",$SessionIdAkses,$JsonUrl);
                                echo '<span class="text-danger" id="NotifikasiTambahSoBerhasil">Success</span>';
                            }else{
                                echo '  <span class="text-danger">';
                                echo '      Terjadi kesalahan pada saat melakukan update data obat pada id penyimpanan '.$id_obat_storage.'';
                                echo '  </span>';
                            }
                        }
                        
                    }else{
                        echo '  <span class="text-danger">';
                        echo '      Terjadi kesalahan pada saat menyimpan data ke database!';
                        echo '  </span>';
                    }
                }else{
                    echo '  <span class="text-danger">';
                    echo '      Stok akhir hanya boleh angka!';
                    echo '  </span>';
                }
            }
        }
    }
?>