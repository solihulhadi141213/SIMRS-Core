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
            $Username=$Exploder[2];
			//Cek Username dengan token yang sudah di deskripsikan
			try {
				JWT::decode($Token, $_ENV['ACCESS_TOKEN_SECRET'], ['HS256']);
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
                        if(empty($Tangkap['kodebooking'])){
                            $metadata = Array (
                                "message" => "Kode Booking Tidak Boleh Kosong",
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
                            $kodebooking=$Tangkap['kodebooking'];
                            //Apakah Kode booking Ada?
                            $QryKodeBooking = mysqli_query($Conn,"SELECT * FROM antrian WHERE kodebooking='$kodebooking'")or die(mysqli_error($Conn));
                            $DataBooking = mysqli_fetch_array($QryKodeBooking);
                            $id_antrian  = $DataBooking['id_antrian'];
                            $id_kunjungan  = $DataBooking['id_kunjungan'];
                            $no_antrian  = $DataBooking['no_antrian'];
                            $id_pasien  = $DataBooking['id_pasien'];
                            $nama_pasien  = $DataBooking['nama_pasien'];
                            $namapoli  = $DataBooking['namapoli'];
                            $nama_dokter  = $DataBooking['nama_dokter'];
                            $tanggal_kunjungan  = $DataBooking['tanggal_kunjungan'];
                            $kodepoli  = $DataBooking['kodepoli'];
                            $SisaAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal_kunjungan' AND kodepoli='$kodepoli' AND status='Terdaftar' AND no_antrian<'$no_antrian'"));
                            //Antrian Panggil
                            $QryAntrianPanggil = mysqli_query($Conn,"SELECT * FROM antrian WHERE tanggal_kunjungan='$tanggal_kunjungan' AND kodepoli='$kodepoli' AND status='Panggil'")or die(mysqli_error($Conn));
                            $DataPanggilan = mysqli_fetch_array($QryAntrianPanggil);
                            $AntrianPanggil=$DataPanggilan['no_antrian'];
                            if(empty($SisaAntrian)){
                                $KaliWaktuTunggu=1;
                            }else{
                                $KaliWaktuTunggu=$SisaAntrian+1;
                            }
                            $waktutunggu=(1000*10*60)*$KaliWaktuTunggu;
                            if(empty($id_antrian)){
                                $metadata = Array (
                                    "message" => "Kode Booking Tidak Ditemukan",
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
                                $response = Array (
                                    "nomorantrean" => "$no_antrian",
                                    "namapoli" => "$namapoli",
                                    "namadokter" => "$nama_dokter",
                                    "sisaantrean" => "$SisaAntrian",
                                    "antreanpanggil" => "$AntrianPanggil",
                                    "waktutunggu" => "$waktutunggu",
                                    "keterangan" => "Hubungi Syamsul El-Syifa Jika Ada Masalah"
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