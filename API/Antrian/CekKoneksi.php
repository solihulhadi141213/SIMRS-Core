<?php
	//Koneksi database
	include "../../_Config/Connection.php";
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	//Decode data json
	$data = json_decode($raw,true);
	//Apabila data username tidak ada
	if(empty($data['username'])){
		$respon = Array (
			"massage" => "Koneksi Ke Server Gagal Karena Username Tidak Ada!!",
			"code" => "401"
		);
	}else{
		//Apabila password tidak ada
		if(empty($data['password'])){
			$respon = Array (
				"massage" => "Koneksi Ke Server Gagal Karena Password Tidak Ada!!",
				"code" => "401"
			);
		}else{
			$username=$data['username'];
			$password=$data['password'];
			//Encrypt to md5
			$password = md5($password);
			//Mencari username dan password
			$QryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE username='$username' AND password='$password'")or die(mysqli_error($Conn));
			$Data = mysqli_fetch_array($QryAkses);
			//Apabila ID akses tidak ditemukan
			if(empty($Data['id_akses'])){
				$respon = Array (
					"massage" => "Koneksi Ke Server Gagal Karena Username dan Password Tidak Valid",
					"code" => "401"
				);
			}else{
				//Apabila Berhasil Jadikan Variabel
				$id_akses = $Data['id_akses'];
				$nama = $Data['nama'];
				$email = $Data['email'];
				$no_hp = $Data['kontak'];
				$level = $Data['akses'];
				$status ="Aktiv";
				$respon = Array (
					"massage" => "Koneksi Berhasil",
					"code" => "1",
					"id_akses" => "$id_akses",
					"nama" => "$nama",
					"email" => "$email",
					"no_hp" => "$no_hp",
					"level" => "$level",
					"status" => "$status"
				);
			}
			
		}
	}
	$Array = Array (
		"respon" => $respon
	);
	$json = json_encode(array("data" => $Array));
	echo "$json";
?>