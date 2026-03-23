<?php
	// Import script autoload agar bisa menggunakan library
	require_once('vendor/autoload.php');
    include "../_Config/Connection.php";
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
		$Exploder=explode(' ', $headers['x-token']);
		//Apakah Token Ada?
		if(empty($Token)){
			$metadata = Array (
                "message" => "x-token Tidak Boleh Kosong",
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
			
			//Cek Username dengan token yang sudah di deskripsikan
			try {
				JWT::decode($xtoken, $_ENV['ACCESS_TOKEN_SECRET'], ['HS256']);
				if(empty($headers['x-username'])){
					$metadata = Array (
                        "message" => "x-username Tidak Boleh Kosong",
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
                    $metadata = Array (
                        "message" => "Validasi berhasil",
                        "code" => 200,
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
				}
			}
            catch (Exception $e) {	
				// Bagian ini akan jalan jika terdapat error saat JWT diverifikasi atau di-decode
				$metadata = Array (
                    "token" => "$xtoken",
                    "username" => "$json",
                    "message" => "Token Tidak Valid Atau Sudah Expired",
                    "code" => 201
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
			}		
		}
	}
?>