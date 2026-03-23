<?php
	// Import script autoload agar bisa menggunakan library
	include('vendor/autoload.php');
	include "../_Config/Connection.php";
	// Import library
	use Firebase\JWT\JWT;
	use Dotenv\Dotenv;
	$dotenv = Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	header('Content-Type: application/json');
	// Cek method request apakah POST atau tidak
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		http_response_code(405);
		exit();
	}else{
		//Tangkap Data Get
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
		// Jika tidak ada data email atau password
		if(empty($headers['x-username'])){
			$metadata = Array (
				"message" => "Username Tidak Boleh Kosong",
				"code" => 201,
			);
			$Array = Array (
				"metadata" => $metadata
			);
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
		}else{
			if(empty($headers['x-password'])){
				$metadata = Array (
					"message" => "Password Tidak Boleh Kosong",
					"code" => 201,
				);
				$Array = Array (
					"metadata" => $metadata
				);
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
			}else{
				$username=$headers['x-username'];
				$password=$headers['x-password'];
				//Encrip MD5
				$password=md5($password);
				//Cek Apakah Ada pada database
				$Qry = mysqli_query($Conn,"SELECT * FROM akses WHERE username='$username' AND password='$password'")or die(mysqli_error($Conn));
				$DataOtenet = mysqli_fetch_array($Qry);
				if(empty($DataOtenet['id_akses'])){
					$metadata = Array (
						"message" => "Akses Ditolak Karena Tidak Terdaftar",
						"code" => 201,
					);
					$Array = Array (
						"metadata" => $metadata
					);
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
				}else{
					$waktu_kadaluarsa['exp'] = time() + (10 * 60);
					$payload = [
						'x-username' => $username,
						'x-password' => $password,
						'exp' => $waktu_kadaluarsa,
					];				
					$access_token = JWT::encode($waktu_kadaluarsa, $_ENV['ACCESS_TOKEN_SECRET']);
					$response = Array (
						"token" => $access_token
					);
					$metadata = Array (
						"message" => "Ok",
						"code" => 200,
					);
					$Array = Array (
						"response" => $response,
						"metadata" => $metadata
					);
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
			}
		}
	}
?>