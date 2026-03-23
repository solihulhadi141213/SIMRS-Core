<?php
	//Koneksi database
	include "../../_Config/Connection.php";
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	//Decode data json
	$data = json_decode($raw,true);
	//Apabila data kategori_identitas tidak ada
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
			//password md5
			$password = md5($password);
			//Menangkap kategori_identitas dan keyword
			if(empty($data['kategori_identitas'])){
				$respon = Array (
					"massage" => "Kategori identitas tidak boleh kosong",
					"code" => 201
				);
			}else{
				if(empty($data['keyword'])){
					$respon = Array (
						"massage" => "Keyword identitas tidak boleh kosong",
						"code" => 201
					);
				}else{
					$keyword=$data['keyword'];
					$kategori_identitas=$data['kategori_identitas'];
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
						$QryPasien = mysqli_query($Conn, "SELECT * FROM pasien WHERE $kategori_identitas='$keyword'")or die(mysqli_error($Conn));
						$DataPasien = mysqli_fetch_array($QryPasien);
						if(empty($DataPasien['id_pasien'])){
							//apabila dengan nik sudah ada
							$respon = Array (
								"massage" => "Data yang anda masukan tidak terdaftar pada rekam medis",
								"code" => 201
							);
						}else{
							$id_pasien=$DataPasien['id_pasien'];
							$NIK=$DataPasien['nik'];
							$no_bpjs=$DataPasien['no_bpjs'];
							$nama=$DataPasien['nama'];
							$gender=$DataPasien['gender'];
							$kontak = $DataPasien['kontak'];
							$respon = Array (
								"id_pasien" => "$id_pasien",
								"nik" => "$NIK",
								"no_bpjs" => "$no_bpjs",
								"nama" => "$nama",
								"gender" => "$gender",
								"kontak" => "$kontak",
								"massage" => "Berhasil",
								"code" => 200
							);
						}
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