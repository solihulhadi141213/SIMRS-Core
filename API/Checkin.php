<?php
	// Import script autoload agar bisa menggunakan library
	require_once('vendor/autoload.php');
    //Koneksi
    include "../_Config/Connection.php";
    //Session
    include "../_Config/Session.php";
    //Setting Bridging
    include "../_Config/SettingBridging.php";
	// Import library
	use Firebase\JWT\JWT;
	use Dotenv\Dotenv;
	$dotenv = Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	header('Content-Type: application/json');
	// Cek method request apakah POST atau tidak
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		$metadata = Array (
            "message" => "Metode Kirim Data Hanya Boleh POST",
            "code" => 201,
        );
        $Array = Array (
            "metadata" => $metadata
        );
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
            
		}else{
			$Exploder=explode(' ', $headers['x-token']);;
            $Token=$Exploder[0];
            $Username=$headers['x-username'];
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
                        }else{
                            if(empty($Tangkap['waktu'])){
                                $metadata = Array (
                                    "message" => "Waktu Checkin Tidak Boleh Kosong",
                                    "code" => 201,
                                );
                                $Array = Array (
                                    "metadata" => $metadata
                                );
                            }else{
                                $kodebooking=$Tangkap['kodebooking'];
                                $waktu=$Tangkap['waktu'];
                                //Validasi kode booking
                                $QryKodeBooking = mysqli_query($Conn,"SELECT * FROM antrian WHERE kodebooking='$kodebooking'")or die(mysqli_error($Conn));
                                $DataBooking = mysqli_fetch_array($QryKodeBooking);
                                $id_antrian  = $DataBooking['id_antrian'];
                                if(empty($id_antrian)){
                                    $metadata = Array (
                                        "message" => "Kode Booking Tidak Ditemukan Pada Data RS",
                                        "code" => 201,
                                    );
                                    $Array = Array (
                                        "metadata" => $metadata
                                    );
                                }else{
                                    //Melakukan Update
                                    $Update= mysqli_query($Conn,"UPDATE antrian SET 
                                        status='Checkin'
                                    WHERE kodebooking='$kodebooking'") or die(mysqli_error($Conn));
                                    if($Update){
                                        //input data log
                                        $QryUpdate="INSERT INTO antrian_log (
                                            id_antrian,
                                            keterangan,
                                            status,
                                            waktu
                                        ) VALUES (
                                            '$id_antrian',
                                            'Checkin',
                                            'Checkin',
                                            '$waktu'
                                        )";
                                        $InputLog=mysqli_query($Conn, $QryUpdate);
                                        if($InputLog){
                                            //Update data antrian ke BPJS
                                            date_default_timezone_set('UTC');
                                            $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                            //Creat Signature
                                            $signature = hash_hmac('sha256', $cons_id_antrol."&".$tStamp, $secret_key_antrol, true);
                                            $encodedSignature = base64_encode($signature);
                                            $urlencodedSignature = urlencode($encodedSignature);
                                            $key="$cons_id_antrol$secret_key_antrol$tStamp";
                                            //Membuat header
                                            $headers = array(
                                                'Content-Type:Application/x-www-form-urlencoded',
                                                'X-cons-id: '.$cons_id_antrol .'',
                                                'X-timestamp: '.$tStamp.'' ,
                                                'X-signature: '.$encodedSignature.'',
                                                'user_key: '.$user_key_antrol.''
                                            ); 
                                            $KirimData = array(
                                                'kodebooking' => $kodebooking,
                                                'taskid' => 1,
                                                'waktu' => $waktu
                                            );
                                            $json = json_encode($KirimData);
                                            //Membuat URL
                                            $url="$url_antrol/antrean/updatewaktu";
                                            $ch = curl_init();
                                            curl_setopt($ch,CURLOPT_URL, "$url");
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                            curl_setopt($ch,CURLOPT_HEADER, 0);
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            $content = curl_exec($ch);
                                            $err = curl_error($ch);
                                            curl_close($ch);
                                            $ambil_json =json_decode($content, true);
                                            $codeWsBpjs=$ambil_json["metadata"]["code"];
                                            $message=$ambil_json["metadata"]["message"];
                                            if($codeWsBpjs==200){
                                                $metadata = Array (
                                                    "message" => "Ok",
                                                    "code" => 200,
                                                );
                                                $Array = Array (
                                                    "metadata" => $metadata
                                                );
                                            }else{
                                                $metadata = Array (
                                                    "message" => "Update Task ID Gagal!",
                                                    "code" => 201,
                                                );
                                                $Array = Array (
                                                    "metadata" => $metadata
                                                );
                                            }
                                            
                                        }else{
                                            $metadata = Array (
                                                "message" => "Input Log Checkin Gagal",
                                                "code" => 201,
                                            );
                                            $Array = Array (
                                                "metadata" => $metadata
                                            );
                                        }
                                        
                                    }else{
                                        $metadata = Array (
                                            "message" => "Update Pembatalan Gagal",
                                            "code" => 201,
                                        );
                                        $Array = Array (
                                            "metadata" => $metadata
                                        );
                                    }
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
			}		
		}
	}
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
?>