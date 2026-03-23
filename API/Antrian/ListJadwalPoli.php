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
			"code" => 200
		);
		$Array = Array (
			"respon" => $respon
		);
		$json = json_encode(array("data" => $Array));
		echo "$json";
	}else{
		//Apabila password tidak ada
		if(empty($data['password'])){
			$respon = Array (
				"massage" => "Koneksi Ke Server Gagal Karena Password Tidak Ada!!",
				"code" => 200
			);
			$Array = Array (
				"respon" => $respon
			);
			$json = json_encode(array("data" => $Array));
			echo "$json";
		}else{
			//Apakah ada kode_poli yang dikirim
			if(empty($data['kode_poli'])){
				$respon = Array (
					"massage" => "Kode Poli TiddakkBoleh Kosong",
					"code" => 200
				);
				$Array = Array (
					"respon" => $respon
				);
				$json = json_encode(array("data" => $Array));
				echo "$json";
			}else{
				$username=$data['username'];
				$password=$data['password'];
				//Password to md5
				$password = md5($password);
				$kode_poli=$data['kode_poli'];
				//Mencari username dan password
				$QryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE username='$username' AND password='$password'")or die(mysqli_error($Conn));
				$Data = mysqli_fetch_array($QryAkses);
				//Apabila ID akses tidak ditemukan
				if(empty($Data['id_akses'])){
					$respon = Array (
						"massage" => "Koneksi Ke Server Gagal Karena Username dan Password Tidak Valid",
						"code" => 200
					);
					$Array = Array (
						"respon" => $respon
					);
					$json = json_encode(array("data" => $Array));
					echo "$json";
				}else{
					//Apakah data jadwal poliklinik ada?
					//Membuka id_poliklinik
					$query_poli = mysqli_query($Conn, "SELECT * FROM poliklinik WHERE kode='$kode_poli'")or die(mysqli_error());
					$data_poli = mysqli_fetch_array($query_poli);
					$id_poliklinik = $data_poli['id_poliklinik'];
					$JumlahJadwal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_poliklinik='$id_poliklinik'"));
					if(empty($JumlahJadwal)){
						$respon = Array (
							"massage" => "Data Jadwal Poliklinik Tidak Ada Pada Database Server",
							"code" => 200
						);
						$Array = Array (
							"respon" => $respon
						);
						$json = json_encode(array("data" => $Array));
						echo "$json";
					}else{
						$query = "SELECT * FROM jadwal_dokter WHERE id_poliklinik='$id_poliklinik' ORDER BY id_jadwal ASC";
						$hasil  =mysqli_query($Conn, $query);
						$metadata = array();
						$metadata["data"] = array();
						while($x = mysqli_fetch_array($hasil)){
							//Kirim Dalam Bentuk Array
							$h['id_jadwal'] = $x["id_jadwal"];
							$h['id_dokter'] = $x["id_dokter"];
							$h['id_poliklinik'] = $x["id_poliklinik"];
							$h['dokter'] = $x["dokter"];
							$h['poliklinik'] = $x["poliklinik"];
							$h['hari'] = $x["hari"];
							$h['jam'] = $x["jam"];
							$h['kuota_non_jkn'] = $x["kuota_non_jkn"];
							$h['kuota_jkn'] = $x["kuota_jkn"];
							$h['time_max'] = $x["time_max"];
							array_push($metadata["data"], $h);
						}
						$respon = Array (
							"massage" => "Berhasil",
							"code" => 200,
							"totalitems" => "$JumlahJadwal",
						);
						$Array = Array (
							"respon" => $respon,
							"metadata" => $metadata
						);
						$json = json_encode(array("data" => $Array));
						echo "$json";
					}
				}
			}
			
		}
	}
?>