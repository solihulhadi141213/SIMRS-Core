<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi id_pasien tidak boleh kosong
        if(empty($_POST['id_pasien'])){
            echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
        }else{
            //Validasi nama_pasien tidak boleh kosong
            if(empty($_POST['nama_pasien'])){
                echo '<small class="text-danger">Nama pasien tidak boleh kosong</small>';
            }else{
                //Validasi tanggal_entry tidak boleh kosong
                if(empty($_POST['tanggal_entry'])){
                    echo '<small class="text-danger">Tanggal Entry tidak boleh kosong</small>';
                }else{
                    //Validasi jam_entry tidak boleh kosong
                    if(empty($_POST['jam_entry'])){
                        echo '<small class="text-danger">Jam Entry tidak boleh kosong</small>';
                    }else{
                        //Validasi tanggal Periksa tidak boleh kosong
                        if(empty($_POST['tanggal_periksa'])){
                            echo '<small class="text-danger">Tanggal periksa tidak boleh kosong</small>';
                        }else{
                            //Validasi jam Periksa tidak boleh kosong
                            if(empty($_POST['jam_periksa'])){
                                echo '<small class="text-danger">Jam Periksa tidak boleh kosong</small>';
                            }else{
                                //Validasi petugas_entry tidak boleh kosong
                                if(empty($_POST['petugas_entry'])){
                                    echo '<small class="text-danger">Petugas Entry tidak boleh kosong</small>';
                                }else{
                                    //Validasi pemeriksa tidak boleh kosong
                                    if(empty($_POST['pemeriksa'])){
                                        echo '<small class="text-danger">Pemeriksa tidak boleh kosong</small>';
                                    }else{
                                        //Validasi dokter tidak boleh kosong
                                        if(empty($_POST['dokter'])){
                                            echo '<small class="text-danger">Nama Dokter tidak boleh kosong</small>';
                                        }else{
                                            //Validasi status_decubitus tidak boleh kosong
                                            if(empty($_POST['status_decubitus'])){
                                                echo '<small class="text-danger">Status Decubitus tidak boleh kosong</small>';
                                            }else{
                                                 //Membuat variabel wajib
                                                $id_kunjungan=$_POST['id_kunjungan'];
                                                $id_pasien=$_POST['id_pasien'];
                                                $nama_pasien=$_POST['nama_pasien'];
                                                $tanggal_entry=$_POST['tanggal_entry'];
                                                $jam_entry=$_POST['jam_entry'];
                                                $tanggal_periksa=$_POST['tanggal_periksa'];
                                                $jam_periksa=$_POST['jam_periksa'];
                                                $petugas_entry=$_POST['petugas_entry'];
                                                $pemeriksa=$_POST['pemeriksa'];
                                                $dokter=$_POST['dokter'];
                                                $status_decubitus=$_POST['status_decubitus'];
                                                //Validasi Data Tidak Wajib
                                                if(empty($_POST['keterangan_decubitus'])){
                                                    $keterangan_decubitus="";
                                                }else{
                                                    $keterangan_decubitus=$_POST['keterangan_decubitus'];
                                                }
                                                if(empty($_POST['batuk1'])){
                                                    $batuk1="Tidak";
                                                }else{
                                                    $batuk1=$_POST['batuk1'];
                                                }
                                                if(empty($_POST['batuk2'])){
                                                    $batuk2="Tidak";
                                                }else{
                                                    $batuk2=$_POST['batuk2'];
                                                }
                                                if(empty($_POST['batuk3'])){
                                                    $batuk3="Tidak";
                                                }else{
                                                    $batuk3=$_POST['batuk3'];
                                                }
                                                if(empty($_POST['batuk4'])){
                                                    $batuk4="Tidak";
                                                }else{
                                                    $batuk4=$_POST['batuk4'];
                                                }
                                                if(empty($_POST['batuk5'])){
                                                    $batuk5="Tidak";
                                                }else{
                                                    $batuk5=$_POST['batuk5'];
                                                }
                                                if(empty($_POST['gizi1'])){
                                                    $gizi1="Tidak";
                                                }else{
                                                    $gizi1=$_POST['gizi1'];
                                                }
                                                if(empty($_POST['gizi1a'])){
                                                    $gizi1a="";
                                                }else{
                                                    $gizi1a=$_POST['gizi1a'];
                                                }
                                                if(empty($_POST['gizi2'])){
                                                    $gizi2="Tidak";
                                                }else{
                                                    $gizi2=$_POST['gizi2'];
                                                }
                                                if(empty($_POST['gizi2a'])){
                                                    $gizi2a="";
                                                }else{
                                                    $gizi2a=$_POST['gizi2a'];
                                                }
                                                if(empty($_POST['gizi3'])){
                                                    $gizi3="Tidak";
                                                }else{
                                                    $gizi3=$_POST['gizi3'];
                                                }
                                                if(empty($_POST['gizi3a'])){
                                                    $gizi3a="";
                                                }else{
                                                    $gizi3a=$_POST['gizi3a'];
                                                }
                                                if(empty($_POST['gizi4'])){
                                                    $gizi4="Tidak";
                                                }else{
                                                    $gizi4=$_POST['gizi4'];
                                                }
                                                if(empty($_POST['gizi4a'])){
                                                    $gizi4a="";
                                                }else{
                                                    $gizi4a=$_POST['gizi4a'];
                                                }
                                                if(empty($_POST['gizi5'])){
                                                    $gizi5="Tidak";
                                                }else{
                                                    $gizi5=$_POST['gizi5'];
                                                }
                                                if(empty($_POST['gizi5a'])){
                                                    $gizi5a="";
                                                }else{
                                                    $gizi5a=$_POST['gizi5a'];
                                                }
                                                //Assamble Tanggal
                                                $tanggal_entry="$tanggal_entry $jam_entry";
                                                $tanggal_periksa="$tanggal_periksa $jam_periksa";
                                                //Validasi Duplikat
                                                $id_screening=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'id_screening');
                                                if(!empty($id_screening)){
                                                    echo '<small class="text-danger">Data Sebelumnya Sudah Ada</small>';
                                                }else{
                                                    //Json Nama Petugas
                                                    $nama_petugas=Array (
                                                        "petugas_entry" => $petugas_entry,
                                                        "pemeriksa" => $pemeriksa,
                                                        "dokter" => $dokter
                                                    );
                                                    //Json decubitus
                                                    $decubitus=Array (
                                                        "status_decubitus" => $status_decubitus,
                                                        "keterangan_decubitus" => $keterangan_decubitus
                                                    );
                                                    //Json batuk
                                                    $batuk=Array (
                                                        "batuk1" => $batuk1,
                                                        "batuk2" => $batuk2,
                                                        "batuk3" => $batuk3,
                                                        "batuk4" => $batuk4,
                                                        "batuk5" => $batuk5
                                                    );
                                                    $ArryGizi1=Array (
                                                        "label" => "Penurunan BB dalam waktu 6 bulan terakhir",
                                                        "value" => $gizi1,
                                                        "keterangan" => $gizi1a,
                                                    );
                                                    $ArryGizi2=Array (
                                                        "label" => "Penurunan asupan makanan karena nafsu makan berkurang",
                                                        "value" => $gizi2,
                                                        "keterangan" => $gizi2a,
                                                    );
                                                    $ArryGizi3=Array (
                                                        "label" => "Gejala gastrointestinal (mual, muntah, diare, anorexia)",
                                                        "value" => $gizi3,
                                                        "keterangan" => $gizi3a,
                                                    );
                                                    $ArryGizi4=Array (
                                                        "label" => "Faktor pemberat (komorbid)",
                                                        "value" => $gizi4,
                                                        "keterangan" => $gizi4a,
                                                    );
                                                    $ArryGizi5=Array (
                                                        "label" => "Penurunan kapasitas fungsional",
                                                        "value" => $gizi5,
                                                        "keterangan" => $gizi5a,
                                                    );
                                                    //Json spiritual
                                                    $gizi=Array (
                                                        "gizi1" => $ArryGizi1,
                                                        "gizi2" => $ArryGizi2,
                                                        "gizi3" => $ArryGizi3,
                                                        "gizi4" => $ArryGizi4,
                                                        "gizi5" => $ArryGizi5
                                                    );
                                                    //Json Encode
                                                    $nama_petugas= json_encode($nama_petugas);
                                                    $decubitus= json_encode($decubitus);
                                                    $batuk= json_encode($batuk);
                                                    $gizi= json_encode($gizi);
                                                    //Menyimpan Kedalam Database
                                                    $entry="INSERT INTO screening (
                                                        id_pasien,
                                                        id_kunjungan,
                                                        id_akses,
                                                        nama_pasien,
                                                        nama_petugas,
                                                        tanggal_entry,
                                                        tanggal_periksa,
                                                        decubitus,
                                                        batuk,
                                                        gizi
                                                    ) VALUES (
                                                        '$id_pasien',
                                                        '$id_kunjungan',
                                                        '$SessionIdAkses',
                                                        '$nama_pasien',
                                                        '$nama_petugas',
                                                        '$tanggal_entry',
                                                        '$tanggal_periksa',
                                                        '$decubitus',
                                                        '$batuk',
                                                        '$gizi'
                                                    )";
                                                    $hasil=mysqli_query($Conn, $entry);
                                                    if($hasil){
                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Screening","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                        if($MenyimpanLog=="Berhasil"){
                                                            echo '<span class="text-success" id="NotifikasiTambahScreeningBerhasil">Success</span>';
                                                        }else{
                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                        }
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan data</span>';
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
