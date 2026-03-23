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
                        if(empty($Tangkap['nomorkartu'])){
                            $metadata = Array (
                                "message" => "Nomor Kartu BPJS Tidak Boleh Kosong",
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
                            if(empty($Tangkap['nik'])){
                                $metadata = Array (
                                    "message" => "NIK Tidak Boleh Kosong",
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
                                if(empty($Tangkap['nama'])){
                                    $metadata = Array (
                                        "message" => "Nama Tidak Boleh Kosong",
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
                                    if(empty($Tangkap['jeniskelamin'])){
                                        $metadata = Array (
                                            "message" => "Gender Tidak Boleh Kosong",
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
                                        if(empty($Tangkap['tanggallahir'])){
                                            $metadata = Array (
                                                "message" => "Tanggal Lahir Tidak Boleh Kosong",
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
                                            if(empty($Tangkap['nohp'])){
                                                $metadata = Array (
                                                    "message" => "No HP Tidak Boleh Kosong",
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
                                                if(empty($Tangkap['alamat'])){
                                                    $metadata = Array (
                                                        "message" => "Alamat Tidak Boleh Kosong",
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
                                                    if(empty($Tangkap['namaprop'])){
                                                        $metadata = Array (
                                                            "message" => "Nama Propinsi Tidak Boleh Kosong",
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
                                                        if(empty($Tangkap['namadati2'])){
                                                            $metadata = Array (
                                                                "message" => "Nama Kabupaten/Kota Tidak Boleh Kosong",
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
                                                            if(empty($Tangkap['namakec'])){
                                                                $metadata = Array (
                                                                    "message" => "Nama Kecamatan Tidak Boleh Kosong",
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
                                                                if(empty($Tangkap['namakel'])){
                                                                    $metadata = Array (
                                                                        "message" => "Nama Desa/Kelurahan Tidak Boleh Kosong",
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
                                                                    //Menangkap semua variabel penting
                                                                    $nomorkartu=$Tangkap['nomorkartu'];
                                                                    $nik=$Tangkap['nik'];
                                                                    if(empty($Tangkap['nomorkk'])){
                                                                        $nomorkk="";
                                                                    }else{
                                                                        $nomorkk=$Tangkap['nomorkk'];
                                                                    }
                                                                    if(empty($Tangkap['namaprop'])){
                                                                        $namaprop="";
                                                                    }else{
                                                                        $namaprop=$Tangkap['namaprop'];
                                                                    }
                                                                    if(empty($Tangkap['namadati2'])){
                                                                        $namadati2="";
                                                                    }else{
                                                                        $namadati2=$Tangkap['namadati2'];
                                                                    }
                                                                    if(empty($Tangkap['namakec'])){
                                                                        $namakec="";
                                                                    }else{
                                                                        $namakec=$Tangkap['namakec'];
                                                                    }
                                                                    if(empty($Tangkap['namakel'])){
                                                                        $namakel="";
                                                                    }else{
                                                                        $namakel=$Tangkap['namakel'];
                                                                    }
                                                                    if(empty($Tangkap['rw'])){
                                                                        $rw="";
                                                                    }else{
                                                                        $rw=$Tangkap['rw'];
                                                                    }
                                                                    if(empty($Tangkap['rt'])){
                                                                        $rt="";
                                                                    }else{
                                                                        $rt=$Tangkap['rt'];
                                                                    }
                                                                    $nama=$Tangkap['nama'];
                                                                    if($Tangkap['jeniskelamin']=="L"){
                                                                        $jeniskelamin="Laki-laki";
                                                                    }else{
                                                                        $jeniskelamin="Perempuan";
                                                                    }
                                                                    $tanggallahir=$Tangkap['tanggallahir'];
                                                                    $nohp=$Tangkap['nohp'];
                                                                    $alamat=$Tangkap['alamat'];
                                                                    $updatetime=date('Y-m-d H:i');
                                                                    //Validasi duplikasi data nomorkartu
                                                                    $ValidasiNoKartu = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE no_bpjs='$nomorkartu'"));
                                                                    $ValidasiNik = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE nik='$nik'"));
                                                                    $ValidasiNoHp = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pasien WHERE kontak='$nohp'"));
                                                                    //Validasi
                                                                    if(!empty($ValidasiNoKartu)){
                                                                        $metadata = Array (
                                                                            "message" => "No Kartu yang digunakan sudah terdaftar",
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
                                                                        if(!empty($ValidasiNik)){
                                                                            $metadata = Array (
                                                                                "message" => "Nik Sudah ada pada database",
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
                                                                            if(!empty($ValidasiNoHp)){
                                                                                $metadata = Array (
                                                                                    "message" => "Nomor Kontak (HP) Sudah Digunakan",
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
                                                                                $tanggal_daftar=date('Y-m-d');
                                                                                $Qry=mysqli_query($Conn, "SELECT max(id_pasien) as maksimal FROM pasien")or die(mysqli_error($Conn));
                                                                                while($Hasil=mysqli_fetch_array($Qry)){
                                                                                    $NilaiMaxRm=$Hasil['maksimal'];
                                                                                }
                                                                                $id_pasien=$NilaiMaxRm+1;
                                                                                //Input data pasien
                                                                                $entry="INSERT INTO pasien (
                                                                                    id_pasien,
                                                                                    tanggal_daftar,
                                                                                    nik,
                                                                                    no_bpjs,
                                                                                    nama,
                                                                                    gender,
                                                                                    tempat_lahir,
                                                                                    tanggal_lahir,
                                                                                    propinsi,
                                                                                    kabupaten,
                                                                                    kecamatan,
                                                                                    desa,
                                                                                    alamat,
                                                                                    kontak,
                                                                                    kontak_darurat,
                                                                                    penanggungjawab,
                                                                                    golongan_darah,
                                                                                    perkawinan,
                                                                                    pekerjaan,
                                                                                    gambar,
                                                                                    status,
                                                                                    updatetime
                                                                                ) VALUES (
                                                                                    '$id_pasien',
                                                                                    '$tanggal_daftar',
                                                                                    '$nik',
                                                                                    '$nomorkartu',
                                                                                    '$nama',
                                                                                    '$jeniskelamin',
                                                                                    '',
                                                                                    '$tanggallahir',
                                                                                    '$namaprop',
                                                                                    '$namadati2',
                                                                                    '$namakec',
                                                                                    '$namakel',
                                                                                    '$alamat',
                                                                                    '$nohp',
                                                                                    '$nohp',
                                                                                    '',
                                                                                    '',
                                                                                    '',
                                                                                    '',
                                                                                    '',
                                                                                    'Aktiv',
                                                                                    '$updatetime'
                                                                                )";
                                                                                $Input=mysqli_query($Conn, $entry);
                                                                                if($Input){
                                                                                    $response = Array (
                                                                                        "norm" => "$id_pasien"
                                                                                    );
                                                                                    $metadata = Array (
                                                                                        "message" => "Harap datang ke admisi untuk melengkapi data rekam medis",
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
                                                                                }else{
                                                                                    $metadata = Array (
                                                                                        "message" => "Input Data Pasien Baru Gagal",
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