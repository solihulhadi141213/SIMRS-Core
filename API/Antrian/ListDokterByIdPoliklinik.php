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
				//Apabila id_poliklinik tidak ada
				if(empty($data['id_poliklinik'])){
					$respon = Array (
						"massage" => "Poliklinik Tidak Boleh Kosong!",
						"code" => "0"
					);
					$Array = Array (
						"respon" => $respon
					);
					$json = json_encode(array("data" => $Array));
					echo "$json";
				}else{
					$tanggal=$data['tanggal'];
					$id_poliklinik=$data['id_poliklinik'];
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
						$JumlahDokter = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE hari='$NamaHari' AND id_poliklinik='$id_poliklinik'"));
						if(empty($JumlahDokter)){
							$respon = Array (
								"massage" => "Dokter Tidak Ada",
								"code" => "0"
							);
							$Array = Array (
								"respon" => $respon
							);
							$json = json_encode(array("data" => $Array));
							echo "$json";
						}else{
							$query = "SELECT DISTINCT dokter FROM jadwal_dokter WHERE hari='$NamaHari' AND id_poliklinik='$id_poliklinik' ORDER BY dokter ASC";
							$hasil  =mysqli_query($Conn, $query);
							$metadata = array();
							$metadata["data"] = array();
							while($x = mysqli_fetch_array($hasil)){
								$dokter =$x["dokter"];
								$h['dokter'] = $dokter;
								array_push($metadata["data"], $h);
							}
							$respon = Array (
								"massage" => "Berhasil",
								"code" => 200
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
	}
?>