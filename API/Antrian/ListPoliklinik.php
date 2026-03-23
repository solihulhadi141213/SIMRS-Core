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
			"code" => "0"
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
				"code" => "0"
			);
			$Array = Array (
				"respon" => $respon
			);
			$json = json_encode(array("data" => $Array));
			echo "$json";
		}else{
			$username=$data['username'];
			$password=$data['password'];
			//password to md5
			$password = md5($password);
			//Mencari username dan password
			$QryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE username='$username' AND password='$password'")or die(mysqli_error($Conn));
			$Data = mysqli_fetch_array($QryAkses);
			//Apabila ID akses tidak ditemukan
			if(empty($Data['id_akses'])){
				$respon = Array (
					"massage" => "Koneksi Ke Server Gagal Karena Username dan Password Tidak Valid",
					"code" => "0"
				);
				$Array = Array (
					"respon" => $respon
				);
				$json = json_encode(array("data" => $Array));
				echo "$json";
			}else{
				//Apakah data poliklinik ada?
				$JumlahPoliklinik = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM poliklinik"));
				if(empty($JumlahPoliklinik)){
					$respon = Array (
						"massage" => "Data Poliklinik Tidak Ada Pada Database Server",
						"code" => "0"
					);
					$Array = Array (
						"respon" => $respon
					);
					$json = json_encode(array("data" => $Array));
					echo "$json";
				}else{
					$query = "SELECT * FROM poliklinik ORDER BY kode ASC";
					$hasil  =mysqli_query($Conn, $query);
					$metadata = array();
					$metadata["data"] = array();
					while($x = mysqli_fetch_array($hasil)){
						$h['id_poliklinik'] = $x["id_poliklinik"];
						$h['nama'] = $x["nama"];
						$h['koordinator'] = $x["koordinator"];
						$h['deskripsi'] = $x["deskripsi"];
						$h['kode'] = $x["kode"];
						$h['status'] = $x["status"];
						array_push($metadata["data"], $h);
					}
					$respon = Array (
						"massage" => "Berhasil",
						"code" => "1",
						"totalitems" => "$JumlahPoliklinik",
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
?>