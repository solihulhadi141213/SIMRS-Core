<?php
    //Koneksi
    include "../_Config/Connection.php";
	header('Content-Type: application/json');
	// Cek method request apakah POST atau tidak
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		$metadata = Array (
            "message" => "Metode Kirim Data Hanya Boleh POST",
            "code" => 201,
        );
        $Array = Array (
            "metadata" => $metadata
        );
	}else{
		//Tangkap Data Post
		$fp = fopen('php://input', 'r');
		$raw = stream_get_contents($fp);
		//Decode data json
		$Tangkap = json_decode($raw,true);	
        if(empty($Tangkap['kodebooking'])){
            $metadata = Array (
                "message" => "Kode Booking Tidak Boleh Kosong",
                "code" => 201,
            );
            $Array = Array (
                "metadata" => $metadata
            );
        }else{
            $kodebooking=$Tangkap['kodebooking'];
            //buka data antrian
            $QryBooking = mysqli_query($Conn, "SELECT * FROM antrian WHERE kodebooking='$kodebooking'")or die(mysqli_error($Conn));
            $DataBooking = mysqli_fetch_array($QryBooking);
            //Apabila data booking tidak ditemukan
            if(empty($DataBooking['kodebooking'])){
                $metadata = Array (
                    "message" => "Data Booking Tidak Ditemukan",
                    "code" => 201,
                );
                $Array = Array (
                    "metadata" => $metadata
                );
            }else{
                //Apabila Berhasil Jadikan Variabel
                $id_antrian = $DataBooking['id_antrian'];
                $kodebooking = $DataBooking['kodebooking'];
                $no_antrian = $DataBooking['no_antrian'];
                $id_pasien = $DataBooking['id_pasien'];
                $nama_pasien = $DataBooking['nama_pasien'];
                $nomorkartu = $DataBooking['nomorkartu'];
                $nik = $DataBooking['nik'];
                $notelp = $DataBooking['notelp'];
                $tanggal_daftar = $DataBooking['tanggal_daftar'];
                $tanggal_kunjungan = $DataBooking['tanggal_kunjungan'];
                $jam_kunjungan = $DataBooking['jam_kunjungan'];
                $kode_dokter = $DataBooking['kode_dokter'];
                $nama_dokter = $DataBooking['nama_dokter'];
                $kodepoli = $DataBooking['kodepoli'];
                $namapoli = $DataBooking['namapoli'];
                $pembayaran = $DataBooking['pembayaran'];
                $status = $DataBooking['status'];
                $respon = Array (
                    "id_antrian" => "$id_antrian",
                    "kodebooking" => "$kodebooking",
                    "no_antrian" => "$no_antrian",
                    "id_pasien" => "$id_pasien",
                    "nama_pasien" => "$nama_pasien",
                    "nomorkartu" => "$nomorkartu",
                    "nik" => "$nik",
                    "notelp" => "$notelp",
                    "tanggal_daftar" => "$tanggal_daftar",
                    "tanggal_kunjungan" => "$tanggal_kunjungan",
                    "jam_kunjungan" => "$jam_kunjungan",
                    "kode_dokter" => "$kode_dokter",
                    "nama_dokter" => "$nama_dokter",
                    "kodepoli" => "$kodepoli",
                    "namapoli" => "$namapoli",
                    "pembayaran" => "$pembayaran",
                    "status" => "$status"
                );
                $metadata = Array (
                    "message" => "Ok",
                    "code" => 200,
                );
                $Array = Array (
                    "metadata" => $metadata,
                    "response" => $respon,
                );
            }
        }
	}
    $json = json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header('Content-Type: application/json');
    header('Pragma: no-chache');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token"); 
    echo $json;
    exit();
?>