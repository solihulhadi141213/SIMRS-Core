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
                        if(empty($Tangkap['kodepoli'])){
                            $metadata = Array (
                                "message" => "Kode Poli Tidak Boleh Kosong",
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
                            //Validasi Kode Dokter
                            if(empty($Tangkap['kodedokter'])){
                                $metadata = Array (
                                    "message" => "Kode Dokter Tidak Boleh Kosong",
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
                                //Validasi tanggal periksa
                                if(empty($Tangkap['tanggalperiksa'])){
                                    $metadata = Array (
                                        "message" => "Tanggal Periksa Tidak Boleh Kosong",
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
                                    //Validasi Jam Praktek
                                    if(empty($Tangkap['jampraktek'])){
                                        $metadata = Array (
                                            "message" => "Jam Praktek Tidak Boleh Kosong",
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
                                        $TanggalSekarang=date('Y-m-d');
                                        $kodepoli=$Tangkap['kodepoli'];
                                        $kodedokter=$Tangkap['kodedokter'];
                                        $tanggalperiksa=$Tangkap['tanggalperiksa'];
                                        $yearsNow=date("Y");
                                        //explode datetime
                                        $exp=explode("-",$tanggalperiksa);
                                        //get year
                                        $year=$exp[0];
                                        //get month
                                        $month=$exp[1];
                                        //get day
                                        $day=$exp[2];
                                        $jampraktek=$Tangkap['jampraktek'];
                                        if($year!==$yearsNow){
                                            $metadata = Array (
                                                "message" => "Format Datetime tidak sesuai (Y-m-d)",
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
                                            //Validasi datetime format sesuai
                                            //validasi backdate
                                            if($tanggalperiksa<$TanggalSekarang){
                                                $metadata = Array (
                                                    "message" => "Tanggal tidak boleh kurang dari hari sekarang",
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
                                                //Apakah Kode Poli Ada?
                                                $QryPoliklinik = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE kode='$kodepoli'")or die(mysqli_error($Conn));
                                                $DataPoliklinik = mysqli_fetch_array($QryPoliklinik);
                                                $id_poliklinik = $DataPoliklinik['id_poliklinik'];
                                                $NamaPoli = $DataPoliklinik['nama'];
                                                if(empty($id_poliklinik)){
                                                    $metadata = Array (
                                                        "message" => "Polilinik Tidak Ditemukan Pada Database",
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
                                                    //Apakah Kode Dokter Ada?
                                                    $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE kode='$kodedokter'")or die(mysqli_error($Conn));
                                                    $DataDokter = mysqli_fetch_array($QryDokter);
                                                    $id_dokter=$DataDokter['id_dokter'];
                                                    $NamaDokter=$DataDokter['nama'];
                                                    //Mencari Nama Hari
                                                    $daftar_hari = array(
                                                        'Sunday' => 'Minggu',
                                                        'Monday' => 'Senin',
                                                        'Tuesday' => 'Selasa',
                                                        'Wednesday' => 'Rabu',
                                                        'Thursday' => 'Kamis',
                                                        'Friday' => 'Jumat',
                                                        'Saturday' => 'Sabtu'
                                                    );
                                                    $namahari = date('l', strtotime($tanggalperiksa));
                                                    $namahari = $daftar_hari[$namahari];
                                                    //Validasi Jadwal Praktek
                                                    $QryJadwal = mysqli_query($Conn,"SELECT * FROM jadwal_dokter WHERE dokter='$NamaDokter' AND poliklinik='$NamaPoli' AND jam='$jampraktek'")or die(mysqli_error($Conn));
                                                    $DataJadwal = mysqli_fetch_array($QryJadwal);
                                                    $id_jadwal=$DataJadwal['id_jadwal'];
                                                    $kuota_non_jkn=$DataJadwal['kuota_non_jkn'];
                                                    $kuota_jkn=$DataJadwal['kuota_jkn'];
                                                    if(empty($id_jadwal)){
                                                        $metadata = Array (
                                                            "message" => "jadwal Poliklinik tidak ditemukan",
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
                                                        //Mencari Data Antrian Yang sedang dipanggil
                                                        $QryAntrian = mysqli_query($Conn,"SELECT * FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa' AND kodepoli='$kodepoli' AND status='Panggil'")or die(mysqli_error($Conn));
                                                        $DataAntrian = mysqli_fetch_array($QryAntrian);
                                                        $id_antrian =$DataAntrian['id_antrian'];
                                                        $no_antrian =$DataAntrian['no_antrian'];
                                                        //Jumlah antran
                                                        $JumlahAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa' AND kodepoli='$kodepoli'"));
                                                        $SisaAntrian=($JumlahAntrian)-$no_antrian;
                                                        $sisakuotanonjkn=$kuota_non_jkn-$JumlahAntrian;
                                                        $sisakuotajkn=$kuota_jkn-$JumlahAntrian;
                                                        $response = Array (
                                                            "namapoli" => "$NamaPoli",
                                                            "namadokter" => "$NamaDokter",
                                                            "totalantrean" => "$JumlahAntrian",
                                                            "sisaantrean" => "$SisaAntrian",
                                                            "antreanpanggil" => "$no_antrian",
                                                            "sisakuotajkn" => "$sisakuotajkn",
                                                            "kuotajkn" => "$kuota_jkn",
                                                            "sisakuotanonjkn" => "$sisakuotanonjkn",
                                                            "kuotanonjkn" => "$kuota_non_jkn",
                                                            "keterangan" => "Hubungi Syamsul Maarif Dari RSU El-Syifa Jika Ada Masalah"
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