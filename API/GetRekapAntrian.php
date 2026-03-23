<?php
	// Import script autoload agar bisa menggunakan library
	include('vendor/autoload.php');
	// Import library
	use Firebase\JWT\JWT;
	use Dotenv\Dotenv;
	$dotenv = Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	header('Content-Type: application/json');
	// Cek method request apakah POST atau tidak
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		http_response_code(405);
		exit();
	}else{
		include "../_Config/Connection.php";
		//Tangkap Data Post
		$fp = fopen('php://input', 'r');
		$raw = stream_get_contents($fp);
		//Decode data json
		$Tangkap = json_decode($raw,true);
		//Buka data HTTP header
		$metadata = array();
		$metadata["data"] = array();
		$h= getallheaders();
		$headers= getallheaders();
		array_push($metadata["data"], $h);
		$Array = Array (
			"metadata" => $h
		);
		$json = json_encode($Array);
		//Apakah Token Ada?
		if(empty($headers['x-token'])){
			$message="Token Tidak Ada";
			$code=0;
		}else{
			$Token=$headers['x-token'];
			//Cek Username dengan token yang sudah di deskripsikan
			try {
				JWT::decode($Token, $_ENV['ACCESS_TOKEN_SECRET'], ['HS256']);
				if(empty($Tangkap['tanggalperiksa'])){
					$message="Tanggal Pemeriksaan Harus Diisi";
					$code=0;
				}else{
					if(empty($Tangkap['kodepoli'])){
						$message="Kode Poli Harus Diisi";
						$code=0;
					}else{
						$tanggalperiksa=$Tangkap['tanggalperiksa'];
						$kodepoli=$Tangkap['kodepoli'];
						$polieksekutif=$Tangkap['polieksekutif'];
						//Buka nama poli
						$QryPoli = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE kode='$kodepoli'")or die(mysqli_error($Conn));
						$DataPoli = mysqli_fetch_array($QryPoli);
						$id_poliklinik = $DataPoli['id_poliklinik'];
						$namapoli = $DataPoli['nama'];
						//Apabila Nama Poli Tidak Ditemukan
						if(empty($namapoli)){
							$message="Poliklinik Tidak Ditemukan";
							$code=0;
						}else{
							//Total Antrean
							$totalantrean = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan WHERE kodepoli='$kodepoli' AND tanggal_kunjungan='$tanggalperiksa' AND polieksekutif='$polieksekutif'"));
							$jumlahterlayani = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan WHERE kodepoli='$kodepoli' AND tanggal_kunjungan='$tanggalperiksa' AND polieksekutif='$polieksekutif' AND status!='Terdaftar'"));
							date_default_timezone_set('UTC');
							$lastupdate=date('Y-m-d H:i:s');
							$lastupdate =strtotime(''.$lastupdate.'');
							$lastupdate =$lastupdate*1000;
							$lastupdatetanggal=date('Y-m-d H:i:s');
							$message="Ok";
							$code=200;
						}
					}
				}
				if($code==0){
					$metadata = Array (
						"message" => "$message",
						"code" => $code,
					);
					$Array = Array (
						"metadata" => $metadata
					);
				}else{
					$response = Array (
						"namapoli" => "$namapoli",
						"totalantrean" => "$totalantrean",
						"jumlahterlayani" => "$jumlahterlayani",
						"lastupdate" => "$lastupdate"
					);
					$metadata = Array (
						"message" => "Ok",
						"code" => 200,
					);
					$Array = Array (
						"response" => $response,
						"metadata" => $metadata
					);
				}
				$json = json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
				header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
				header("Cache-Control: no-store, no-cache, must-revalidate");
				header('Pragma: no-chache');
				header('Access-Control-Allow-Origin: *');
				header('Access-Control-Allow-Credentials: true');
				header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
				header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token"); 
				echo $json;
				exit();
			}
			catch (Exception $e) {	
				// Bagian ini akan jalan jika terdapat error saat JWT diverifikasi atau di-decode
				http_response_code(401);
				exit();
			}
		}
	}
?>