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
                        if(empty($Tangkap['nopeserta'])){
                            $metadata = Array (
                                "message" => "Nomor Peserta Tidak Boleh Kosong",
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
                            $nopeserta=$Tangkap['nopeserta'];
                            //Cek apakah data ada atau tidak
                            $JumlahListJadwalOperasi = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM jadwal_operasi WHERE nopeserta='$nopeserta'"));
                            if(empty($JumlahListJadwalOperasi)){
                                $metadata = Array (
                                    "message" => "Tidak ada data untuk no peserta $nopeserta tersebut",
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
                                $Tgl_sekarang= date("Y-m-d");
                                $tiga_hari= mktime(0,0,0,date("n"),date("j")+3,date("Y"));
                                $Tiga_hari_kedepan= date("Y-m-d", $tiga_hari);
                                $nopeserta=$Tangkap['nopeserta'];
                                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM jadwal_operasi WHERE nopeserta='$nopeserta' AND terlaksana='0' AND tanggaloperasi<='$Tiga_hari_kedepan'"));
                                if(empty($jml_data)){
                                    $metadata = Array (
                                        "message" => "Tidak ada jadwal 3 hari kedepan",
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