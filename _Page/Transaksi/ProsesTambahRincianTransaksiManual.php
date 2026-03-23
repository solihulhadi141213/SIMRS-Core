<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    $updatetime=date('Y-m-d H:i');
    //ID Data Tidak Boleh Kosong
    if(empty($_POST['KategoriRincian'])){
        echo '<span class="text-danger">Kategori Rincian Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['KodeTransaksi'])){
            echo '<span class="text-danger">Kode Transaksi Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['NamaRincian'])){
                echo '<span class="text-danger">Nama Rincian Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['QtyRincian'])){
                    echo '<span class="text-danger">Setidaknya anda menambahkan sebuah kuantitas item yang dipilih</span>';
                }else{
                    if(empty($_POST['SatuanRincian'])){
                        echo '<span class="text-danger">Satuan Tindakan/Obat Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['transaksi'])){
                            echo '<span class="text-danger">Jenis Transaksi Tidak Boleh Kosong</span>';
                        }else{
                            $id_obat_tindakan="0";
                            $kategori=$_POST['KategoriRincian'];
                            $kode=$_POST['KodeTransaksi'];
                            $nama=$_POST['NamaRincian'];
                            $qty=$_POST['QtyRincian'];
                            $satuan=$_POST['SatuanRincian'];
                            $transaksi=$_POST['transaksi'];
                            $qty = intval(str_replace('.', '', $qty));
                            if(empty($_POST['KlaimRincian'])){
                                $klaim="UMUM";
                            }else{
                                $klaim=$_POST['KlaimRincian'];
                            }
                            if(empty($_POST['PenyimpananRincian'])){
                                $PenyimpananRincian="0";
                            }else{
                                $PenyimpananRincian=$_POST['PenyimpananRincian'];
                            }
                            if(empty($_POST['HargaRincian'])){
                                $HargaRincian="0";
                            }else{
                                $HargaRincian=$_POST['HargaRincian'];
                                $HargaRincian = intval(str_replace('.', '', $HargaRincian));
                            }
                            if(empty($_POST['PpnRincian'])){
                                $PpnRincian="0";
                            }else{
                                $PpnRincian=$_POST['PpnRincian'];
                                $PpnRincian = intval(str_replace('.', '', $PpnRincian));
                            }
                            if(empty($_POST['DiskonRincian'])){
                                $DiskonRincian="0";
                            }else{
                                $DiskonRincian=$_POST['DiskonRincian'];
                                $DiskonRincian = intval(str_replace('.', '', $DiskonRincian));
                            }
                            if(empty($_POST['JumlahRincian'])){
                                $JumlahRincian="0";
                            }else{
                                $JumlahRincian=$_POST['JumlahRincian'];
                                $JumlahRincian = intval(str_replace('.', '', $JumlahRincian));
                            }
                            //Validasi Hanya Boleh Angka
                            if(!preg_match("/^[0-9]*$/", $qty)){
                                echo '<span class="text-danger">QTY Hanya boleh diisi angka!</span>';
                            }else{
                                if(!preg_match("/^[0-9]*$/", $HargaRincian)){
                                    echo '<span class="text-danger">Harga Hanya boleh diisi angka!</span>';
                                }else{
                                    if(!preg_match("/^[0-9]*$/", $PpnRincian)){
                                        echo '<span class="text-danger">PPN Hanya boleh diisi angka!</span>';
                                    }else{
                                        if(!preg_match("/^[0-9]*$/", $DiskonRincian)){
                                            echo '<span class="text-danger">Diskon Hanya boleh diisi angka!</span>';
                                        }else{
                                            if(!preg_match("/^[0-9]*$/", $JumlahRincian)){
                                                echo '<span class="text-danger">Jumlah Rincian Hanya boleh diisi angka!</span>';
                                            }else{
                                                //Simpan Rincian
                                                $entry="INSERT INTO transaksi_rincian (
                                                    kode,
                                                    transaksi,
                                                    kategori,
                                                    id_obat_tindakan,
                                                    id_inventori_posisi,
                                                    nama,
                                                    qty,
                                                    satuan,
                                                    harga,
                                                    ppn,
                                                    diskon,
                                                    jumlah,
                                                    klaim,
                                                    retur,
                                                    updatetime
                                                ) VALUES (
                                                    '$kode',
                                                    '$transaksi',
                                                    '$kategori',
                                                    '$id_obat_tindakan',
                                                    '$PenyimpananRincian',
                                                    '$nama',
                                                    '$qty',
                                                    '$satuan',
                                                    '$HargaRincian',
                                                    '$PpnRincian',
                                                    '$DiskonRincian',
                                                    '$JumlahRincian',
                                                    '$klaim',
                                                    'No',
                                                    '$updatetime'
                                                )";
                                                $Input=mysqli_query($Conn, $entry);
                                                if($Input){
                                                    echo '<span class="text-success" id="NotifikasiTambahRincianManualBerhasil">Success</span>';
                                                }else{
                                                    echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan rincian transaksi ke dalam database</span>';
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