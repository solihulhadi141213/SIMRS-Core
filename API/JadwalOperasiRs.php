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
		//Apakah Token Ada?
		if(empty($headers['x-token'])){
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
			$Exploder=explode(' ', $headers['x-token']);;
            $Token=$Exploder[0];
            $Username=$headers['x-username'];
			//Cek Username dengan token yang sudah di deskripsikan
			try {
				JWT::decode($Token, $_ENV['ACCESS_TOKEN_SECRET'], ['HS256']);
				if(empty($Username)){
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
                    $ValidasiUsername = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akses WHERE username>='$Username'"));
					if(empty($ValidasiUsername)){
						$metadata = Array (
                            "message" => "x-username Tidak Terdaftar $Username",
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
                        //Validasi Kode Poli
                        if(empty($Tangkap['tanggalawal'])){
                            $metadata = Array (
                                "message" => "Tanggal Awal Tidak Boleh Kosong",
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
                            if(empty($Tangkap['tanggalakhir'])){
                                $metadata = Array (
                                    "message" => "Tanggal Akhir Tidak Boleh Kosong",
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
                                $tanggalawal=$Tangkap['tanggalawal'];
                                $tanggalakhir=$Tangkap['tanggalakhir'];
                                //Cek apakah data ada atau tidak
                                $JumlahListJadwalOperasi = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM jadwal_operasi WHERE tanggaloperasi>='$tanggalawal' AND tanggaloperasi<='$tanggalakhir'"));
                                if(empty($JumlahListJadwalOperasi)){
                                    $metadata = Array (
                                        "message" => "Tidak ada data untuk jadwal tersebut",
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
                                    $message="Ok";
                                    $code=200;
                                    $QryBookingOperasi = "SELECT * FROM jadwal_operasi WHERE tanggaloperasi>='$tanggalawal' AND tanggaloperasi<='$tanggalakhir'";
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
                                        $h['nopeserta'] = $x["nopeserta"];
                                        $h['lastupdate'] = $x["lastupdate"];
                                        array_push($response["list"], $h);
                                    }
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
				}
			}
            catch (Exception $e) {	
				// Bagian ini akan jalan jika terdapat error saat JWT diverifikasi atau di-decode
				$metadata = Array (
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