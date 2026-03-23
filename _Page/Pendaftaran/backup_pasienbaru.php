<?php
    //include Connection
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    //POST data from form
    if(empty($_POST['metode_pembayaran'])){
        $metode_pembayaran="UMUM";
    }else{
        $metode_pembayaran=$_POST['metode_pembayaran'];
    }
    if(empty($_POST['id_pasien'])){
        $id_pasien="";
        //Nilai max id_pasien
        $query_max_id_pasien = mysqli_query($Conn,"SELECT MAX(id_pasien) AS max_id_pasien FROM pasien");
        $data_max_id_pasien = mysqli_fetch_array($query_max_id_pasien);
        $max_id_pasien = $data_max_id_pasien['max_id_pasien'];
        $id_pasien=$max_id_pasien+1;
    }else{
        $id_pasien=$_POST['id_pasien'];
    }
    if(empty($_POST['nik'])){
        $nik="";
    }else{
        $nik=$_POST['nik'];
    }
    if(empty($_POST['nomorkartu'])){
        $nomorkartu="";
    }else{
        $nomorkartu=$_POST['nomorkartu'];
    }
    if(empty($_POST['nama'])){
        $nama="";
    }else{
        $nama=$_POST['nama'];
    }
    if(empty($_POST['notelp'])){
        $notelp=""; 
    }else{
        $notelp=$_POST['notelp'];
    }
    if(empty($_POST['poliklinik'])){
        $poliklinik="";
    }else{
        $poliklinik=$_POST['poliklinik'];
    }
    if(empty($_POST['dokter'])){
        $dokter="";
    }else{
        $dokter=$_POST['dokter'];
    }
    if(empty($_POST['tanggal'])){
        $tanggal="";
    }else{
        $tanggal=$_POST['tanggal'];
    }
    if(empty($_POST['jam'])){
        $jam="";
    }else{
        $jam=$_POST['jam'];
    }
    if(empty($_POST['jam'])){
        $jam2="";
    }else{
        $jam2=$_POST['jam'];
    }
    if(empty($_POST['keluhan'])){
        $keluhan="";
    }else{
        $keluhan=$_POST['keluhan'];
    }
    if(empty($_POST['jeniskunjungan'])){
        $jeniskunjungan="1";
    }else{
        $jeniskunjungan=$_POST['jeniskunjungan'];
    }
    if(empty($_POST['nomorreferensi'])){
        $nomorreferensi="";
    }else{
        $nomorreferensi=$_POST['nomorreferensi'];
    }
    //Inisiasi metode pembayaran
    if($metode_pembayaran=="UMUM"){
        $Pembayaran="UMUM";
        $JenisPasien="NON JKN";
    }else{
        $Pembayaran="BPJS";
        $JenisPasien="JKN";
    }
    //Inisiasi waktu daftar
    $now=date('Y-m-d');
    $tanggal_daftar_time=date('Y-m-d H:i');
    $tanggal_daftar=date('Y-m-d');
    $updatetime=date('Y-m-d H:i');
    //Buka nama hari
    $day = date('D', strtotime($tanggal));
    $dayList = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );
    $NamaHari=$dayList[$day];
    //Cek jadwal
    $sql = "SELECT * FROM jadwal_dokter WHERE id_poliklinik='$poliklinik' AND id_dokter='$dokter' AND hari='$NamaHari' AND jam='$jam'";
    $result = mysqli_query($Conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id_jadwal=$row['id_jadwal'];
    $JamPraktek = $row['jam'];
    $kuota_non_jkn=$row['kuota_non_jkn'];
    $kuota_jkn=$row['kuota_jkn'];
    $time_max=$row['time_max'];
    //Kuota berdasar jenis kunjungan
    if($Pembayaran=="UMUM"){
        $kuota=$kuota_non_jkn;
    }else{
        $kuota=$kuota_jkn;
    }
    //Cari jam kapan mulai prakteknya
    $explode = explode("-" , $JamPraktek);
    $MulaiPraktekPraktek=$explode[0];
    //Tanggal & jam praktek aktual
    $tanggal_praktek_aktual="$tanggal $MulaiPraktekPraktek";
    $tanggal_praktek_aktual2=strtotime($tanggal_praktek_aktual);
    $tanggal_pendaftaran_minimum=date('Y-m-d H:i', $tanggal_praktek_aktual2 - $time_max);
    //Ada berapa orang yang daftar untuk poli tersebut pada hari yang sama
    $CekAdaBerapa = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal'"));
    //Satu layanan dihitung 10 menit
    $LamaLayanan=$CekAdaBerapa*10;
    $AwalPraktek = date('H:i:s', strtotime("+$LamaLayanan minute", strtotime($MulaiPraktekPraktek)));
    //Ubah Tanggal Periksa menjadi milsecon
    date_default_timezone_set('Asia/Jakarta');
    $estimasi="$tanggal $AwalPraktek";
    $estimasi=strtotime(''.$estimasi.'');
    $estimasi=$estimasi*1000;
    //Jumlah antrian total dengan yang bersangkutan
    $JumlahAntrianTotal=$CekAdaBerapa+1;
    //Validasi ketersediaan data
    if(empty($_POST['nik'])){
        echo "<span class='text-danger'>NIK Tidak Boleh Kosong, Mohon diisi untuk kelengkapan data!</span>";
    }else{
        if(empty($_POST['nama'])){
            echo "<span class='text-danger'>Nama Tidak Boleh Kosong, Mohon diisi untuk kelengkapan data!</span>";
        }else{
            if(empty($_POST['notelp'])){
                echo "<span class='text-danger'>Nomor Kontak Tidak Boleh Kosong, Mohon diisi agar kami mudah menghubungi anda!</span>";
            }else{
                if(empty($_POST['poliklinik'])){
                    echo "<span class='text-danger'>Poliklinik Tidak Boleh Kosong, Mohon diisi untuk kelengkapan pendaftaran!</span>";
                }else{
                    if(empty($_POST['dokter'])){
                        echo "<span class='text-danger'>Dokter Tidak Boleh Kosong, Mohon diisi untuk kelengkapan pendaftaran!</span>";
                    }else{
                        if(empty($_POST['tanggal'])){
                            echo "<span class='text-danger'>Tanggal Rencana Kunjungan Tidak Boleh Kosong, Mohon diisi untuk kelengkapan pendaftaran!</span>";
                        }else{
                            if(empty($_POST['jam'])){
                                echo "<span class='text-danger'>Waktu/Jam Rencana Kunjungan Tidak Boleh Kosong, Mohon diisi untuk kelengkapan pendaftaran!</span>";
                            }else{
                                if(empty($_POST['keluhan'])){
                                    echo "<span class='text-danger'>Keterangan Keluhan / Keterangan Kunjungan Tidak Boleh Kosong, Mohon diisi untuk kelengkapan pendaftaran!</span>";
                                }else{
                                    //Tidak bisa daftar untuk hari kemarin
                                    if($tanggal<$now){
                                        echo "<span class='text-danger'>Tidak bisa melakukan pendaftaran untuk hari kemarin</span>";
                                    }else{
                                        //Tidak bisa daftar sekian menit sebelum
                                        if($tanggal_daftar_time>$tanggal_pendaftaran_minimum){
                                            echo "<span class='text-danger'>Pendaftaran hanya bisa dilakukan sebelum $tanggal_pendaftaran_minimum</span>";
                                        }else{
                                            //Apakah ID pasien tersebut sudah terdaftar di hari yang sama
                                            $QryAntrian = mysqli_query($Conn,"SELECT * FROM antrian WHERE id_pasien='$id_pasien' AND tanggal_kunjungan='$tanggal'")or die(mysqli_error($Conn));
                                            $DataAntrian = mysqli_fetch_array($QryAntrian);
                                            $kodebooking= $DataAntrian['kodebooking'];
                                            $CekAntrianSama = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE id_pasien='$id_pasien' AND tanggal_kunjungan='$tanggal'"));
                                            if(!empty($kodebooking)){
                                                echo "<span class='text-danger'>Anda sudah terdaftar di hari ini dengan kode booking $kodebooking</span>";
                                            }else{
                                                //Validasi apakah jadwal ada
                                                if(empty($id_jadwal)){
                                                    echo "<span class='text-danger'>Poliklinik dokter tidak tersedia untuk hari tersebut</span>";
                                                }else{
                                                    //Validasi kuota antrian
                                                    if($JumlahAntrianTotal>$kuota){
                                                        echo "<span class='text-danger'>Maaf kuota antrian sudah penuh! Cari jadwal di hari lainnya</span>";
                                                    }else{
                                                        //Mencari nomor antrian
                                                        $QueryAntrian=mysqli_query($Conn, "SELECT MAX(no_antrian) as no_antrian FROM antrian WHERE tanggal_kunjungan='$tanggal'")or die(mysqli_error($Conn));
                                                        while($DataAntrian=mysqli_fetch_array($QueryAntrian)){
                                                            $no_antrian=$DataAntrian['no_antrian'];
                                                        }
                                                        $NoAntrian=$no_antrian+1;   
                                                        $kodebooking=rand(100000,999999);   
                                                        $kodebooking=("$NoAntrian$kodebooking");
                                                        //buka data dokter
                                                        $SqlDokter = "SELECT * FROM dokter WHERE id_dokter='$dokter'";
                                                        $DataDokter = mysqli_query($Conn, $SqlDokter);
                                                        $RowDokter = mysqli_fetch_assoc($DataDokter);
                                                        $KodeDokter=$RowDokter['kode'];
                                                        $NamaDokter=$RowDokter['nama'];
                                                        //buka data poli
                                                        $SqlPoli = "SELECT * FROM poliklinik WHERE id_poliklinik='$poliklinik'";
                                                        $DataPoli = mysqli_query($Conn, $SqlPoli);
                                                        $RowPoli = mysqli_fetch_assoc($DataPoli);
                                                        $KodePoli=$RowPoli['kode'];
                                                        $NamaPoli=$RowPoli['nama'];
                                                        $JumlahAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal' AND kodepoli='$KodePoli'"));
                                                        $SisaAntrian=($kuota_non_jkn+$kuota_jkn)-$JumlahAntrian;
                                                        $sisakuotanonjkn=$kuota_non_jkn-($JumlahAntrian+1);
                                                        $sisakuotajkn=$kuota_jkn-($JumlahAntrian+1);
                                                        //Save to database pasien
                                                        $SqlPasien = "INSERT INTO pasien (
                                                            id_pasien, 
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
                                                            updatetime
                                                        ) VALUES (
                                                            '$id_pasien',
                                                            '$tanggal_daftar',
                                                            '$nik',
                                                            '$nomorkartu',
                                                            '$nama',
                                                            '',
                                                            '',
                                                            '',
                                                            '',
                                                            '',
                                                            '',
                                                            '',
                                                            '',
                                                            '$notelp',
                                                            '',
                                                            '',
                                                            '',
                                                            '',
                                                            '',
                                                            '',
                                                            'Aktiv',
                                                            '$updatetime'
                                                        )";
                                                        $InputPasien = mysqli_query($Conn, $SqlPasien);
                                                        if($InputPasien){
                                                            //Input ke database kunjungan
                                                            $QryAntrian="INSERT INTO antrian (
                                                                id_kunjungan,
                                                                no_antrian,
                                                                kodebooking,
                                                                id_pasien,
                                                                nama_pasien,
                                                                nomorkartu,
                                                                nik,
                                                                notelp,
                                                                nomorreferensi,
                                                                jenisreferensi,
                                                                jenisrequest,
                                                                polieksekutif,
                                                                tanggal_daftar,
                                                                tanggal_kunjungan,
                                                                jam_kunjungan,
                                                                jam_checkin,
                                                                kode_dokter,
                                                                nama_dokter,
                                                                kodepoli,
                                                                namapoli,
                                                                kelas,
                                                                keluhan,
                                                                pembayaran,
                                                                no_rujukan,
                                                                status
                                                            ) VALUES (
                                                                '0',
                                                                '$NoAntrian',
                                                                '$kodebooking',
                                                                '$id_pasien',
                                                                '$nama',
                                                                '$nomorkartu',
                                                                '$nik',
                                                                '$notelp',
                                                                '$nomorreferensi',
                                                                '$jeniskunjungan',
                                                                '0',
                                                                '0',
                                                                '$now',
                                                                '$tanggal',
                                                                '$AwalPraktek',
                                                                '',
                                                                '$KodeDokter',
                                                                '$NamaDokter',
                                                                '$KodePoli',
                                                                '$NamaPoli',
                                                                '',
                                                                '$keluhan',
                                                                '$Pembayaran',
                                                                '$nomorreferensi',
                                                                'Terdaftar'
                                                            )";
                                                            $InputAntrian=mysqli_query($Conn, $QryAntrian);
                                                            if($InputAntrian){
                                                                //Tambah data antrian ke WS BPJS
                                                                date_default_timezone_set('UTC');
                                                                $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                                                //Creat Signature
                                                                $signature = hash_hmac('sha256', $cons_id_antrol."&".$tStamp, $secret_key_antrol, true);
                                                                $encodedSignature = base64_encode($signature);
                                                                $urlencodedSignature = urlencode($encodedSignature);
                                                                $key="$cons_id_antrol$secret_key_antrol$tStamp";
                                                                //Membuat header
                                                                $headers = array(
                                                                    'Content-Type:Application/x-www-form-urlencoded',
                                                                    'X-cons-id: '.$cons_id_antrol .'',
                                                                    'X-timestamp: '.$tStamp.'' ,
                                                                    'X-signature: '.$encodedSignature.'',
                                                                    'user_key: '.$user_key_antrol.''
                                                                ); 
                                                                $KirimData = array(
                                                                    'kodebooking' => $kodebooking,
                                                                    'jenispasien' => "$JenisPasien",
                                                                    'nomorkartu' => $nomorkartu,
                                                                    'nik' => $nik,
                                                                    'nohp' => $notelp,
                                                                    'kodepoli' => $KodePoli,
                                                                    'namapoli' => $NamaPoli,
                                                                    'pasienbaru' => "0",
                                                                    'norm' => $id_pasien,
                                                                    'tanggalperiksa' => $tanggal,
                                                                    'kodedokter' => $KodeDokter,
                                                                    'namadokter' => $NamaDokter,
                                                                    'jampraktek' => $JamPraktek,
                                                                    'jeniskunjungan' => $jeniskunjungan,
                                                                    'nomorreferensi' => $nomorreferensi,
                                                                    'nomorantrean' => "A-$NoAntrian",
                                                                    'angkaantrean' => $NoAntrian,
                                                                    'estimasidilayani' => $estimasi,
                                                                    'sisakuotajkn' => $sisakuotajkn,
                                                                    'kuotajkn' => $kuota_jkn,
                                                                    'sisakuotanonjkn' => $sisakuotanonjkn,
                                                                    'kuotanonjkn' => $kuota_non_jkn,
                                                                    'keterangan' => "Peserta harap checkin di lokasi sebelum jam praktek"
                                                                );
                                                                $json = json_encode($KirimData);
                                                                //Membuat URL
                                                                $url="$url_antrol/antrean/add";
                                                                $ch = curl_init();
                                                                curl_setopt($ch,CURLOPT_URL, "$url");
                                                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                                                curl_setopt($ch,CURLOPT_HEADER, 0);
                                                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                $content = curl_exec($ch);
                                                                $err = curl_error($ch);
                                                                curl_close($ch);
                                                                $ambil_json =json_decode($content, true);
                                                                $codeWsBpjs=$ambil_json["metadata"]["code"];
                                                                $message=$ambil_json["metadata"]["message"];
                                                                if($codeWsBpjs==200){
                                                                    echo "<span class='text-success' id='NotifikasiPendaftaranPasienBaruBerhasil'>Pendaftaran Berhasil</span><br>";
                                                                    echo "<span class='text-success' id='kodebooking'>$kodebooking</span>";
                                                                }else{
                                                                    //Hapus antrian
                                                                    $QryHapusAntrian="DELETE FROM antrian WHERE kodebooking='$kodebooking'";
                                                                    $HapusAntrian=mysqli_query($Conn, $QryHapusAntrian);
                                                                    echo "<span class='text-danger' id='NotifikasiPendaftaranBerhasil'>Pendaftaran gagal dilakukan!</span><br>";
                                                                    echo "<dt>Pesan :</dt> $message <br>";
                                                                }
                                                            }else{
                                                                echo "<span class='text-danger'>Mohon maaf! Pendaftaran antrian gagal, terjadi kesalahan pada sistem rumah sakit.</span>";
                                                                echo "";
                                                            }
                                                        }else{
                                                            echo "<span class='text-danger'>Mohon maaf! Pendaftaran antrian gagal, terjadi kesalahan pada sistem rumah sakit.</span>";
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
    }    
    
?>