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
			"code" => 201
		);
	}else{
		//Apabila password tidak ada
		if(empty($data['password'])){
			$respon = Array (
				"massage" => "Koneksi Ke Server Gagal Karena Password Tidak Ada!!",
				"code" => 201
			);
		}else{
			$username=$data['username'];
			$password=$data['password'];
			//md5 password
			$password = md5($password);
			//Menangkap nik dan no_kartu
			if(empty($data['nik'])){
				$nik="";
			}else{
				$nik=$data['nik'];
			}
			if(empty($data['no_kartu'])){
				$no_kartu="";
			}else{
				$no_kartu=$data['no_kartu'];
			}
			//Mencari username dan password
			$QryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE username='$username' AND password='$password'")or die(mysqli_error($Conn));
			$Data = mysqli_fetch_array($QryAkses);
			//Apabila ID akses tidak ditemukan
			if(empty($Data['id_akses'])){
				$respon = Array (
					"massage" => "Koneksi Ke Server Gagal Karena Username dan Password Tidak Valid",
					"code" => 201
				);
			}else{
				//Cek pada database apakah ada?
				if(!empty($nik)){
					$QryPasien = mysqli_query($Conn, "SELECT * FROM pasien WHERE nik='$nik'")or die(mysqli_error($Conn));
					$DataPasien = mysqli_fetch_array($QryPasien);
					if(!empty($DataPasien['id_pasien'])){
						//apabila dengan nik sudah ada
						$respon = Array (
							"massage" => "Anda Terdaftar Sebagai Pasien Lama",
							"code" => 201
						);
					}else{
						if(!empty($no_kartu)){
							//menggunakan no_kartu
							$QryPasien = mysqli_query($Conn, "SELECT * FROM pasien WHERE no_bpjs='$no_kartu'")or die(mysqli_error($Conn));
							$DataPasien = mysqli_fetch_array($QryPasien);
							if(!empty($DataPasien['id_pasien'])){
								//apabila dengan nik sudah ada
								$respon = Array (
									"massage" => "Anda Terdaftar Sebagai Pasien Lama",
									"code" => 201
								);
							}else{
								$respon = Array (
									"massage" => "Berhasil",
									"code" => 200
								);
							}
						}else{
							$respon = Array (
								"massage" => "Berhasil",
								"code" => 200
							);
						}
					}
				}else{
					if(!empty($no_kartu)){
						//menggunakan no_kartu
						$QryPasien = mysqli_query($Conn, "SELECT * FROM pasien WHERE no_bpjs='$no_kartu'")or die(mysqli_error($Conn));
						$DataPasien = mysqli_fetch_array($QryPasien);
						if(!empty($DataPasien['id_pasien'])){
							//apabila dengan nik sudah ada
							$respon = Array (
								"massage" => "Anda Terdaftar Sebagai Pasien Lama",
								"code" => "0"
							);
						}else{
							$respon = Array (
								"massage" => "Berhasil",
								"code" => 200
							);
						}
					}else{
						$respon = Array (
							"massage" => "Berhasil",
							"code" => 200
						);
					}
				}
			}
			
		}
	}
	$Array = Array (
		"respon" => $respon
	);
	$json = json_encode(array("data" => $Array));
	echo "$json";
?>