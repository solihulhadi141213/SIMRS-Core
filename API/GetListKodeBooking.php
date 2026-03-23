<?php
	// Import script autoload agar bisa menggunakan library
	include('vendor/autoload.php');
	// Import library
	use Firebase\JWT\JWT;
	use Dotenv\Dotenv;
	$dotenv = Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	header('Content-Type: application/json');
	header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (10 * 60)));
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header('Pragma: no-chache');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Credentials: true');
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, x-token, token");
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
		$headers= getallheaders();
		array_push($metadata["data"], $headers);
		$Array = Array (
			"metadata" => $headers
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
				if(empty($Tangkap['nopeserta'])){
					$message="no peserta Tidak Ada";
					$code=0;
				}else{
					$code=200;
					$Tgl_sekarang= date("Y-m-d");
					$tiga_hari= mktime(0,0,0,date("n"),date("j")+3,date("Y"));
					$Tiga_hari_kedepan= date("Y-m-d", $tiga_hari);
					$nopeserta=$Tangkap['nopeserta'];
					$jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM jadwal_operasi WHERE nopeserta='$nopeserta' AND terlaksana='0' AND tanggaloperasi<='$Tiga_hari_kedepan'"));
					$QryBookingOperasi = "SELECT * FROM jadwal_operasi WHERE nopeserta='$nopeserta' AND terlaksana='0' AND tanggaloperasi<='$Tiga_hari_kedepan'";
					$DataBooking  =mysqli_query($Conn, $QryBookingOperasi);
					 $response = array();
					  $response["list"] = array();
					  while($x = mysqli_fetch_array($DataBooking)){
						$h['kodebooking'] = $x["kodebooking"];
						$h['tanggaloperasi'] = $x["tanggaloperasi"];
						$h['jenistindakan'] = $x["jenistindakan"];
						$h['kodepoli'] = $x["kodepoli"];
						$h['namapoli'] = $x["namapoli"];
						$h['terlaksana'] = $x["terlaksana"];
						array_push($response["list"], $h);
					  }
				}
				if($code=="0"){
					$metadata = Array (
						"message" => "$message",
						"code" => $code
					);
					$Array = Array (
						"metadata" => $metadata
					);
				}else{
					//Apabila Data Tidak ada
					if(empty($jml_data)){
						$message="Tidak Ada Data Operasi Hingga 3 Hari Kedepan";
						$code=0;
						$metadata = Array (
							"message" => "$message",
							"code" => $code
						);
						$Array = Array (
							"metadata" => $metadata
						);
					}else{
						$message="Ok";
						$code=200;
						$metadata = Array (
							"message" => "$message",
							"code" => $code
						);
						$Array = Array (
							"response" => $response,
							"metadata" => $metadata
						);
					}	
				}
				$json = json_encode($Array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); 
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