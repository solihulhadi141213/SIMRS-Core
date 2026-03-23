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
            "message" => "Metode Harus POST",
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
			$Exploder=explode(' ', $headers['x-token']);
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
                            "message" => "x-username: $Username Tidak Terdaftar Pada Database",
                            "code" => 201,
                        );
                        $Array = Array (
                            "metadata" => $metadata
                        );
					}else{
                        if(empty($Tangkap['nomorkartu'])){
                            $message="nomor kartu Tidak Boleh Kosong";
                            $code=201;
                            $metadata = Array (
                                "message" => $message,
                                "code" => $code,
                            );
                            $Array = Array (
                                "metadata" => $metadata
                            );
                        }else{
                            if(empty($Tangkap['nik'])){
                                $metadata = Array (
                                    "message" => "NIK Peserta Tidak Boleh Kosong",
                                    "code" => 201
                                );
                                $Array = Array (
                                    "metadata" => $metadata
                                );
                            }else{
                                if(empty($Tangkap['nohp'])){
                                    $metadata = Array (
                                        "message" => "Nomor HP/Kontak Peserta Tidak Boleh Kosong",
                                        "code" => 201,
                                    );
                                    $Array = Array (
                                        "metadata" => $metadata
                                    );
                                }else{
                                    if(empty($Tangkap['kodepoli'])){
                                        $metadata = Array (
                                            "message" => "Kode Poli Tidak Boleh Kosong",
                                            "code" => 201,
                                        );
                                        $Array = Array (
                                            "metadata" => $metadata
                                        );
                                    }else{
                                        if(empty($Tangkap['norm'])){
                                            $metadata = Array (
                                                "message" => "Pasien Baru",
                                                "code" => 202,
                                            );
                                            $Array = Array (
                                                "metadata" => $metadata
                                            );
                                        }else{
                                            if(empty($Tangkap['tanggalperiksa'])){
                                                $metadata = Array (
                                                    "message" => "Tanggal periksa Tidak Boleh Kosong",
                                                    "code" => 201,
                                                );
                                                $Array = Array (
                                                    "metadata" => $metadata
                                                );
                                            }else{
                                                if(empty($Tangkap['kodedokter'])){
                                                    $metadata = Array (
                                                        "message" => "Kode Dokter Tidak Boleh Kosong",
                                                        "code" => 201,
                                                    );
                                                    $Array = Array (
                                                        "metadata" => $metadata
                                                    );
                                                }else{
                                                    if(empty($Tangkap['jampraktek'])){
                                                        $metadata = Array (
                                                            "message" => "Jam Praktek Tidak Boleh kosong",
                                                            "code" => 201,
                                                        );
                                                        $Array = Array (
                                                            "metadata" => $metadata
                                                        );
                                                    }else{
                                                        if(empty($Tangkap['jeniskunjungan'])){
                                                            $message="Jenis Kunjungan Tidak Boleh kosong";
                                                            $code=201;
                                                            $metadata = Array (
                                                                "message" => $message,
                                                                "code" => $code,
                                                            );
                                                            $Array = Array (
                                                                "metadata" => $metadata
                                                            );
                                                        }else{
                                                            if(empty($Tangkap['nomorreferensi'])){
                                                                $message="Nomor Referensi tidak boleh kosong";
                                                                $code=201;
                                                                $metadata = Array (
                                                                    "message" => $message,
                                                                    "code" => $code,
                                                                );
                                                                $Array = Array (
                                                                    "metadata" => $metadata
                                                                );
                                                            }else{
                                                                //Inisiasi Semua Variabel Yang Ditnagkap Disini
                                                                $nomorkartu=$Tangkap['nomorkartu'];
                                                                $nik=$Tangkap['nik'];
                                                                $norm=$Tangkap['norm'];
                                                                $nohp=$Tangkap['nohp'];
                                                                $tanggalperiksa=$Tangkap['tanggalperiksa'];
                                                                $kodepoli=$Tangkap['kodepoli'];
                                                                $kodedokter=$Tangkap['kodedokter'];
                                                                $jampraktek=$Tangkap['jampraktek'];
                                                                $jeniskunjungan=$Tangkap['jeniskunjungan'];
                                                                $nomorreferensi=$Tangkap['nomorreferensi'];
                                                                $tanggal_daftar=date('Y-m-d H:i:s');
                                                                //Dapatkan ID pasien
                                                                $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$norm'")or die(mysqli_error($Conn));
                                                                $DataPasien = mysqli_fetch_array($QryPasien);
                                                                $id_pasien = $DataPasien['id_pasien'];
                                                                $nama_pasien = $DataPasien['nama'];
                                                                //Apakah ID pasien tersebut sudah terdaftar di hari yang sama
                                                                $CekAntrianSama = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE id_pasien='$norm' AND tanggal_kunjungan='$tanggalperiksa'"));
                                                                //Dapatkan id_poliklinik dari kode_poli
                                                                $Qry = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE kode='$kodepoli'")or die(mysqli_error($Conn));
                                                                $DataPoli = mysqli_fetch_array($Qry);
                                                                $id_poliklinik = $DataPoli['id_poliklinik'];
                                                                $nama_poli = $DataPoli['nama'];
                                                                //buka data dokter berdasarkan kodedokter
                                                                $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE kode='$kodedokter'")or die(mysqli_error($Conn));
                                                                $DataDokter = mysqli_fetch_array($QryDokter);
                                                                $id_dokter = $DataDokter['id_dokter'];
                                                                $nama_dokter = $DataDokter['nama'];
                                                                //Buka data jadwal
                                                                $QryJadwal = mysqli_query($Conn,"SELECT * FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'")or die(mysqli_error($Conn));
                                                                $DataJadwal = mysqli_fetch_array($QryJadwal);
                                                                $id_jadwal = $DataJadwal['id_jadwal'];
                                                                if(empty($id_jadwal)){
                                                                    $message="jadwal dokter  $nama_dokter tidak  ditemukan pada database jadwal";
                                                                    $code=201;
                                                                    $metadata = Array (
                                                                        "message" => $message,
                                                                        "code" => $code,
                                                                    );
                                                                    $Array = Array (
                                                                        "metadata" => $metadata
                                                                    );
                                                                }else{
                                                                    //Hari apa tanggal periksa
                                                                    $daftar_hari = array(
                                                                        'Sunday' => 'Minggu',
                                                                        'Monday' => 'Senin',
                                                                        'Tuesday' => 'Selasa',
                                                                        'Wednesday' => 'Rabu',
                                                                        'Thursday' => 'Kamis',
                                                                        'Friday' => 'Jumat',
                                                                        'Saturday' => 'Sabtu'
                                                                    );
                                                                    $namahari1 = date('l', strtotime($tanggalperiksa));
                                                                    $namahari = $daftar_hari[$namahari1];
                                                                    $hariberobat=$daftar_hari[$namahari1];
                                                                    //Apabila Tanggal bookign ternyata kemarin
                                                                    $now=date('Y-m-d');
                                                                    if($tanggalperiksa<=$now){
                                                                        $message="Tidak Bisa Mendaftar Untuk Hari Ini dan Kemarin";
                                                                        $code=201;
                                                                        $metadata = Array (
                                                                            "message" => $message,
                                                                            "code" => $code,
                                                                        );
                                                                        $Array = Array (
                                                                            "metadata" => $metadata
                                                                        );
                                                                    }else{
                                                                        $tanggalSekarang=date('Y-m-d');
                                                                        $tgl1 = new DateTime("$tanggalSekarang");
                                                                        $tgl2 = new DateTime("$tanggalperiksa");
                                                                        $d = $tgl2->diff($tgl1)->days + 1;
                                                                        if($d>7){
                                                                            $message="Pendaftaran online maksimal 7 hari dari sekarang";
                                                                            $code=201;
                                                                            $metadata = Array (
                                                                                "message" => $message,
                                                                                "code" => $code,
                                                                            );
                                                                            $Array = Array (
                                                                                "metadata" => $metadata
                                                                            );
                                                                        }else{
                                                                            //Periksa apakah pada tanggal tersebut ada jadwal dokternya
                                                                            $QueryJadwal = mysqli_query($Conn,"SELECT * FROM jadwal_dokter WHERE poliklinik='$nama_poli' AND hari='$hariberobat'")or die(mysqli_error($Conn));
                                                                            $DataJadwal = mysqli_fetch_array($QueryJadwal);
                                                                            $id_jadwal  = $DataJadwal['id_jadwal'];
                                                                            $JamPraktek = $DataJadwal['jam'];
                                                                            $id_dokter = $DataJadwal['id_dokter'];
                                                                            $kuota_non_jkn=$DataJadwal['kuota_non_jkn'];
                                                                            $kuota_jkn=$DataJadwal['kuota_jkn'];
                                                                            //Buka data dokter
                                                                            $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error($Conn));
                                                                            $DataDokter = mysqli_fetch_array($QryDokter);
                                                                            $NamaDokter = $DataDokter['nama'];
                                                                            $KodeDokter = $DataDokter['kode'];
                                                                            
                                                                            if(empty($id_jadwal)){
                                                                                $message="Tidak ada jadwal praktek $nama_poli untuk hari $hariberobat di tanggal tersebut di data RS";
                                                                                $code=201;
                                                                                $metadata = Array (
                                                                                    "message" => $message,
                                                                                    "code" => $code,
                                                                                );
                                                                                $Array = Array (
                                                                                    "metadata" => $metadata
                                                                                );
                                                                            }else{
                                                                                //Cari kapan mulai prakteknya
                                                                                $explode = explode("-" , $JamPraktek);
                                                                                $AwalPraktek=$explode[0];
                                                                                //Ada berapa orang yang daftar untuk poli tersebut pada hari yang sama
                                                                                $CekAdaBerapa = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa'"));
                                                                                //Satu layanan dihitung 10 menit
                                                                                $LamaLayanan=$CekAdaBerapa*10;
                                                                                $AwalPraktek = date('H:i:s', strtotime("+$LamaLayanan minute", strtotime($AwalPraktek)));
                                                                                //Ubah Tanggal Periksa menjadi milsecon
                                                                                date_default_timezone_set('Asia/Jakarta');
                                                                                $estimasi="$tanggalperiksa $AwalPraktek";
                                                                                $estimasi=strtotime(''.$estimasi.'');
                                                                                $estimasi=$estimasi*1000;
                                                                                $kodebooking=rand(100000,999999);
                                                                                $kodebooking="$estimasi$kodebooking";
                                                                                //Mencari nomor antrian
                                                                                $QueryAntrian=mysqli_query($Conn, "SELECT MAX(no_antrian) as no_antrian FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa'")or die(mysqli_error($Conn));
                                                                                while($DataAntrian=mysqli_fetch_array($QueryAntrian)){
                                                                                    $no_antrian=$DataAntrian['no_antrian'];
                                                                                }
                                                                                $NilaiTertinggi=$no_antrian+1;
                                                                                $JumlahAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggalperiksa' AND kodepoli='$kodepoli'"));
                                                                                $SisaAntrian=($kuota_non_jkn+$kuota_jkn)-$JumlahAntrian;
                                                                                $sisakuotanonjkn=$kuota_non_jkn-$JumlahAntrian;
                                                                                $sisakuotajkn=$kuota_jkn-$JumlahAntrian;
                                                                                //Apabila id_pasien tidak ditemukan
                                                                                if(empty($id_pasien)){
                                                                                    $message="Nomor Rekam Medis Yang Digunakan Tidak Ditemukan Pada Data RS.";
                                                                                    $code=201;
                                                                                    $metadata = Array (
                                                                                        "message" => $message,
                                                                                        "code" => $code,
                                                                                    );
                                                                                    $Array = Array (
                                                                                        "metadata" => $metadata
                                                                                    );
                                                                                }else{
                                                                                    if(empty($CekAntrianSama)){
                                                                                        //Input ke database kunjungan
                                                                                        $QueryInputKunjungan="INSERT INTO antrian (
                                                                                            id_kunjungan,
                                                                                            no_antrian,
                                                                                            kodebooking,
                                                                                            id_pasien,
                                                                                            nama_pasien,
                                                                                            nomorkartu,
                                                                                            nik,
                                                                                            notelp,
                                                                                            nomorreferensi,
                                                                                            jenisreferensi,
                                                                                            jenisrequest,
                                                                                            polieksekutif,
                                                                                            tanggal_daftar,
                                                                                            tanggal_kunjungan,
                                                                                            jam_kunjungan,
                                                                                            jam_checkin,
                                                                                            kode_dokter,
                                                                                            nama_dokter,
                                                                                            kodepoli,
                                                                                            namapoli,
                                                                                            kelas,
                                                                                            keluhan,
                                                                                            pembayaran,
                                                                                            no_rujukan,
                                                                                            status,
                                                                                            sumber_antrian
                                                                                        ) VALUES (
                                                                                            '0',
                                                                                            '$NilaiTertinggi',
                                                                                            '$kodebooking',
                                                                                            '$id_pasien',
                                                                                            '$nama_pasien',
                                                                                            '$nomorkartu',
                                                                                            '$nik',
                                                                                            '$nohp',
                                                                                            '$nomorreferensi',
                                                                                            '0',
                                                                                            '0',
                                                                                            '0',
                                                                                            '$tanggal_daftar',
                                                                                            '$tanggalperiksa',
                                                                                            '$jampraktek',
                                                                                            '',
                                                                                            '$KodeDokter',
                                                                                            '$NamaDokter',
                                                                                            '$kodepoli',
                                                                                            '$nama_poli',
                                                                                            'None',
                                                                                            'None',
                                                                                            'BPJS',
                                                                                            '$nomorreferensi',
                                                                                            'Terdaftar',
                                                                                            'Mesin Antrian'
                                                                                        )";
                                                                                        $InputKunjungan=mysqli_query($Conn, $QueryInputKunjungan);
                                                                                        if($InputKunjungan){
                                                                                            //Coba ubah
                                                                                            $nomorantrean="$NilaiTertinggi";
                                                                                            $kodebooking="$kodebooking";
                                                                                            $estimasidilayani="$estimasi";
                                                                                            $kodepoli=$kodepoli;
                                                                                            $namapoli="$nama_poli";
                                                                                            //Tambah data antrian ke WS BPJS
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
                                                                                                'jenispasien' => "JKN",
                                                                                                'nomorkartu' => $nomorkartu,
                                                                                                'nik' => $nik,
                                                                                                'nohp' => $nohp,
                                                                                                'kodepoli' => $kodepoli,
                                                                                                'namapoli' => $nama_poli,
                                                                                                'pasienbaru' => "0",
                                                                                                'norm' => $id_pasien,
                                                                                                'tanggalperiksa' => $tanggalperiksa,
                                                                                                'kodedokter' => $KodeDokter,
                                                                                                'namadokter' => $NamaDokter,
                                                                                                'jampraktek' => $jampraktek,
                                                                                                'jeniskunjungan' => $jeniskunjungan,
                                                                                                'nomorreferensi' => $nomorreferensi,
                                                                                                'nomorantrean' => "A-$nomorantrean",
                                                                                                'angkaantrean' => $nomorantrean,
                                                                                                'estimasidilayani' => $estimasi,
                                                                                                'sisakuotajkn' => $sisakuotajkn,
                                                                                                'kuotajkn' => $kuota_jkn,
                                                                                                'sisakuotanonjkn' => $sisakuotanonjkn,
                                                                                                'kuotanonjkn' => $kuota_non_jkn,
                                                                                                'keterangan' => "Peserta harap 30 menit lebih awal guna pencatatan administrasi"
                                                                                            );
                                                                                            $json = json_encode($KirimData);
                                                                                            //Membuat URL
                                                                                            $url="$url_antrol/antrean/add";
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
                                                                                                $response = Array (
                                                                                                    "nomorantrean" => "A-$nomorantrean",
                                                                                                    "angkaantrean" => "$nomorantrean",
                                                                                                    "kodebooking" => "$kodebooking",
                                                                                                    "norm" => "$id_pasien",
                                                                                                    "namapoli" => "$namapoli",
                                                                                                    "namadokter" => "$NamaDokter",
                                                                                                    "estimasidilayani" => "$estimasidilayani",
                                                                                                    "sisakuotajkn" => "$sisakuotajkn",
                                                                                                    "kuotajkn" => "$kuota_jkn",
                                                                                                    "sisakuotanonjkn" => "$sisakuotanonjkn",
                                                                                                    "kuotanonjkn" => "$kuota_non_jkn",
                                                                                                    "keterangan" => "Peserta harap 60 menit lebih awal guna pencatatan administrasi."
                                                                                                );
                                                                                                $metadata = Array (
                                                                                                    "message" => "Sukses",
                                                                                                    "code" => 200,
                                                                                                );
                                                                                                $Array = Array (
                                                                                                    "response" => $response,
                                                                                                    "metadata" => $metadata
                                                                                                );
                                                                                            }else{
                                                                                                $message="Gagal Input Data Antrian Ke JKN mobile.";
                                                                                                $code=201;
                                                                                                $metadata = Array (
                                                                                                    "message" => $message,
                                                                                                    "code" => $code,
                                                                                                );
                                                                                                $Array = Array (
                                                                                                    "metadata" => $metadata
                                                                                                );
                                                                                            }
                                                                                            
                                                                                        }else{
                                                                                            $message="Gagal Input Data Antrian Ke Data RS.";
                                                                                            $code=201;
                                                                                            $metadata = Array (
                                                                                                "message" => $message,
                                                                                                "code" => $code,
                                                                                            );
                                                                                            $Array = Array (
                                                                                                "metadata" => $metadata
                                                                                            );
                                                                                        }
                                                                                    }else{
                                                                                        $message="Anda Sudah Mempunyai Nomor Antrian.";
                                                                                        $code=201;
                                                                                        $metadata = Array (
                                                                                            "message" => $message,
                                                                                            "code" => $code,
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