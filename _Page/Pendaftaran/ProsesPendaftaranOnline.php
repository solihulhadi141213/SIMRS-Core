<?php
    //include Connection
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    //POST data from form
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
    if(empty($_POST['nomorreferensi'])){
        $nomorreferensi="";
    }else{
        $nomorreferensi=$_POST['nomorreferensi'];
    }
    if(empty($_POST['jeniskunjungan'])){
        $jeniskunjungan="";
        $Pembayaran="UMUM";
        $JenisPasien="NON JKN";
    }else{
        $jeniskunjungan=$_POST['jeniskunjungan'];
        $Pembayaran="BPJS";
        $JenisPasien="JKN";
    }
    $now=date('Y-m-d');
    $tanggal_daftar=date('Y-m-d');
    $updatetime=date('Y-m-d H:i');
    //Tidak bisa daftar untuk hari kemarin
    if($tanggal<$now){
        echo "<span class='text-danger'>Tidak bisa melakukan pendaftaran untuk hari kemarin</span>";
    }else{    
        //check data nik from databse
        if(empty($_POST['nomorkartu'])){
            $sql = "SELECT * FROM pasien WHERE nik='$nik'";
        }else{
            $sql = "SELECT * FROM pasien WHERE nik='$nik' OR no_bpjs='$nomorkartu'";
        }
        $result = mysqli_query($Conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id_pasien=$row['id_pasien'];
        //Apakah ID pasien tersebut sudah terdaftar di hari yang sama
        $CekAntrianSama = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE id_pasien='$id_pasien' AND tanggal_kunjungan='$tanggal'"));
        if(!empty($CekAntrianSama)){
            echo "<span class='text-danger'>Pasien sudah terdaftar di hari ini2</span>";
        }else{
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
            //Menghitung estimasi
            //Cari kapan mulai prakteknya
            $explode = explode("-" , $JamPraktek);
            $AwalPraktek=$explode[0];
            //Ada berapa orang yang daftar untuk poli tersebut pada hari yang sama
            $CekAdaBerapa = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal'"));
            //Satu layanan dihitung 10 menit
            $LamaLayanan=$CekAdaBerapa*10;
            $AwalPraktek = date('H:i:s', strtotime("+$LamaLayanan minute", strtotime($AwalPraktek)));
            //Ubah Tanggal Periksa menjadi milsecon
            date_default_timezone_set('Asia/Jakarta');
            $estimasi="$tanggal $AwalPraktek";
            $estimasi=strtotime(''.$estimasi.'');
            $estimasi=$estimasi*1000;
            if(empty($id_jadwal)){
                echo "<span class='text-danger'>Poliklinik atau dokter tidak tersedia</span>";
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
                $jeniskunjungan=1;
                $JumlahAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal' AND kodepoli='$KodePoli'"));
                $SisaAntrian=($kuota_non_jkn+$kuota_jkn)-$JumlahAntrian;
                $sisakuotanonjkn=$kuota_non_jkn-$JumlahAntrian;
                $sisakuotajkn=$kuota_jkn-$JumlahAntrian;
                if(empty($id_pasien)){
                    //max id pasien
                    //Mencari id_pasien
                    $QryRm=mysqli_query($Conn, "SELECT MAX(id_pasien) as id_pasien FROM pasien")or die(mysqli_error($Conn));
                    while($DataRm=mysqli_fetch_array($QryRm)){
                        $Maksimal=$DataRm['id_pasien'];
                    }
                    $IDPasienBaru=$Maksimal+1;
                    //insert data pasien
                    $sql = "INSERT INTO pasien (
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
                        '$IDPasienBaru',
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
                    $result = mysqli_query($Conn, $sql);
                    if($result){
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
                            '$IDPasienBaru',
                            '$nama',
                            '$nomorkartu',
                            '$nik',
                            '$notelp',
                            '',
                            '0',
                            '0',
                            '0',
                            '$now',
                            '$tanggal',
                            '$jam2',
                            '',
                            '$KodeDokter',
                            '$NamaDokter',
                            '$KodePoli',
                            '$NamaPoli',
                            'None',
                            'None',
                            '$Pembayaran',
                            '',
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
                                'pasienbaru' => "1",
                                'norm' => $IDPasienBaru,
                                'tanggalperiksa' => $tanggal,
                                'kodedokter' => $KodeDokter,
                                'namadokter' => $NamaDokter,
                                'jampraktek' => $jam,
                                'jeniskunjungan' => $jeniskunjungan,
                                'nomorreferensi' => $nomorreferensi,
                                'nomorantrean' => "A-$NoAntrian",
                                'angkaantrean' => $NoAntrian,
                                'estimasidilayani' => $estimasi,
                                'sisakuotajkn' => $sisakuotajkn,
                                'kuotajkn' => $kuota_jkn,
                                'sisakuotanonjkn' => $sisakuotanonjkn,
                                'kuotanonjkn' => $kuota_non_jkn,
                                'keterangan' => "Peserta harap 30 menit lebih awal guna pencatatan administrasi"
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
                                echo "<span class='text-success' id='NotifikasiPendaftaranBerhasil'>Pendaftaran Berhasil</span>";
                                echo "<span class='text-success' id='kodebooking'>$kodebooking</span>";
                            }else{
                                echo "<span class='text-success' id='NotifikasiPendaftaranBerhasil'>Pendaftaran Berhasil</span>";
                                echo "<span class='text-success' id='kodebooking'>$kodebooking</span>";
                            }
                        }else{
                            echo "<span class='text-danger'>Gagal ketika mendaftarkan pasien baru</span>";
                        }
                    }else{
                        echo "<span class='text-danger'>Gagal ketika mendaftarkan pasien baru</span>";
                    }
                
                }else{
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
                        '',
                        '0',
                        '0',
                        '0',
                        '$now',
                        '$tanggal',
                        '$jam2',
                        '',
                        '$KodeDokter',
                        '$NamaDokter',
                        '$KodePoli',
                        '$NamaPoli',
                        'None',
                        'None',
                        '$Pembayaran',
                        '',
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
                            'jampraktek' => $jam,
                            'jeniskunjungan' => $jeniskunjungan,
                            'nomorreferensi' => $nomorreferensi,
                            'nomorantrean' => "A-$NoAntrian",
                            'angkaantrean' => $NoAntrian,
                            'estimasidilayani' => $estimasi,
                            'sisakuotajkn' => $sisakuotajkn,
                            'kuotajkn' => $kuota_jkn,
                            'sisakuotanonjkn' => $sisakuotanonjkn,
                            'kuotanonjkn' => $kuota_non_jkn,
                            'keterangan' => "Peserta harap 30 menit lebih awal guna pencatatan administrasi"
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
                            echo "<span class='text-success' id='NotifikasiPendaftaranBerhasil'>Pendaftaran Berhasil</span><br>";
                            echo "<span class='text-success' id='kodebooking'>$kodebooking</span>";
                        }else{
                            echo "<span class='text-success' id='NotifikasiPendaftaranBerhasil'>Pendaftaran Berhasil</span><br>";
                            echo "<span class='text-success' id='kodebooking'>$kodebooking</span>";
                        }
                    }else{
                        echo "<span class='text-danger'>Gagal ketika mendaftarkan pasien baru</span>";
                    }
                }
            }
        }
    }
?>