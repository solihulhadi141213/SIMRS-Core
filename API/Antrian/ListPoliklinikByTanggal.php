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
			//Apabila tanggal tidak ada
			if(empty($data['tanggal'])){
				$respon = Array (
					"massage" => "Tanggal Tidak Boleh Kosong!",
					"code" => "0"
				);
				$Array = Array (
					"respon" => $respon
				);
				$json = json_encode(array("data" => $Array));
				echo "$json";
			}else{
				$tanggal=$data['tanggal'];
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
					$JumlahPoliklinik = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT id_poliklinik FROM jadwal_dokter WHERE hari='$NamaHari'"));
					if(empty($JumlahPoliklinik)){
						$respon = Array (
							"massage" => "Poliklinik Tidak Ada",
							"code" => "0"
						);
						$Array = Array (
							"respon" => $respon
						);
						$json = json_encode(array("data" => $Array));
						echo "$json";
					}else{
						$query = "SELECT DISTINCT id_poliklinik FROM jadwal_dokter WHERE hari='$NamaHari'  ORDER BY id_poliklinik ASC";
						$hasil  =mysqli_query($Conn, $query);
						$metadata = array();
						$metadata["data"] = array();
						while($x = mysqli_fetch_array($hasil)){
							$id_poliklinik=$x["id_poliklinik"];
							//Buka nama poli
							$QryPoli = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'")or die(mysqli_error($Conn));
							$DataPoli = mysqli_fetch_array($QryPoli);
							$NamaPoli=$DataPoli["nama"];
							$h['id_poliklinik'] = $id_poliklinik;
							$h['poliklinik'] = $NamaPoli;
							array_push($metadata["data"], $h);
						}
						$respon = Array (
							"massage" => "Berhasil",
							"code" => 200,
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
	}
?>