<?php
	// Import script autoload agar bisa menggunakan library
	include('vendor/autoload.php');
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
		include "../_Config/Connection.php";
		//Tangkap Data Post
		$fp = fopen('php://input', 'r');
		$raw = stream_get_contents($fp);
		//Decode data json
		$Tangkap = json_decode($raw,true);
		//Buka data HTTP header
		$metadata = array();
		$metadata["data"] = array();
		$h= getallheaders();
		$headers= getallheaders();
		array_push($metadata["data"], $h);
		$Array = Array (
			"metadata" => $h
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
				if(empty($Tangkap['nomorkartu'])){
					$message="nomor kartu Tidak Ada";
					$code=0;
				}else{
					if(empty($Tangkap['nik'])){
						$message="nik Tidak Ada";
						$code=0;
					}else{
						if(empty($Tangkap['nomorrm'])){
							$message="nomor rm Tidak Ada";
							$code=0;
						}else{
							if(empty($Tangkap['notelp'])){
								$message="notelp Tidak Ada";
								$code=0;
							}else{
								if(empty($Tangkap['tanggalperiksa'])){
									$message="tanggal periksa Tidak Ada";
									$code=0;
								}else{
									if(empty($Tangkap['kodepoli'])){
										$message="kodepoli Tidak Ada";
										$code=0;
									}else{
										if(empty($Tangkap['nomorreferensi'])){
											$message="nomor referensi Tidak Ada";
											$code=0;
										}else{
											if(empty($Tangkap['jenisreferensi'])){
												$message="jenis referensi Tidak Ada";
												$code=0;
											}else{
												if(empty($Tangkap['jenisrequest'])){
													$message="jenis request Tidak Ada";
													$code=0;
												}else{
													if(empty($Tangkap['polieksekutif'])){
														$message="Sukses";
														$code="1";
														$polieksekutif=0;
													}else{
														$polieksekutif=$Tangkap['polieksekutif'];
													}
													//Inisiasi Semua Variabel Yang Ditnagkap Disini
													$nomorkartu=$Tangkap['nomorkartu'];
													$nik=$Tangkap['nik'];
													$nomorrm=$Tangkap['nomorrm'];
													$notelp=$Tangkap['notelp'];
													$tanggal_daftar=date('Y-m-d H:i:s');
													$tanggalperiksa=$Tangkap['tanggalperiksa'];
													$kodepoli=$Tangkap['kodepoli'];
													$nomorreferensi=$Tangkap['nomorreferensi'];
													$jenisreferensi=$Tangkap['jenisreferensi'];
													$jenisrequest=$Tangkap['jenisrequest'];
													$polieksekutif=$Tangkap['polieksekutif'];
													//Dapatkan ID pasien
													$QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$nomorrm'")or die(mysqli_error($Conn));
													$DataPasien = mysqli_fetch_array($QryPasien);
													$id_pasien = $DataPasien['id_pasien'];
													//Apakah ID pasien tersebut sudah terdaftar di hari yang sama
													$CekAntrianSama = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan WHERE id_pasien='$id_pasien' AND tanggal_kunjungan='$tanggalperiksa'"));
													//Dapatkan id_poliklinik dari kode_poli
													$Qry = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE kode='$kodepoli'")or die(mysqli_error($Conn));
													$DataPoli = mysqli_fetch_array($Qry);
													$id_poliklinik = $DataPoli['id_poliklinik'];
													$nama_poli = $DataPoli['nama'];
													//Hari apa tanggal periksa
													$daftar_hari = array(
													'Sunday' => 'minggu',
													'Monday' => 'senin',
													'Tuesday' => 'selasa',
													'Wednesday' => 'rabu',
													'Thursday' => 'kamis',
													'Friday' => 'jumat',
													'Saturday' => 'sabtu'
													);
													$date=$tanggalperiksa;
													$namahari = date('l', strtotime($date));
													$hariberobat=$daftar_hari[$namahari];
													//Apabila Tanggal bookign ternyata kemarin
													$now=date('Y-m-d');
													if($tanggalperiksa<=$now){
														$message="Tidak Bisa Mendaftar Untuk Hari Ini dan Kemarin";
														$code=0;
													}else{
														//Periksa apakah pada tanggal tersebut ada jadwal dokternya
														$QueryJadwal = mysqli_query($Conn,"SELECT * FROM jadwal_dokter WHERE id_poliklinik='$id_poliklinik' AND hari='$hariberobat'")or die(mysqli_error($Conn));
														$DataJadwal = mysqli_fetch_array($QueryJadwal);
														$JamPraktek = $DataJadwal['jam'];
														$id_dokter = $DataJadwal['id_dokter'];
														
														//Buka data dokter
														$QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error($Conn));
														$DataDokter = mysqli_fetch_array($QryDokter);
														$NamaDokter = $DataDokter['nama'];
														$KodeDokter = $DataDokter['kode'];
														
														if(empty($JamPraktek)){
															$message="Tidak ada jadwal praktek untuk tanggal tersebut";
															$code=0;
														}else{
															//Cari kapan mulai prakteknya
															$explode = explode("-" , $JamPraktek);
															$AwalPraktek=$explode[0];
															//Ada berapa orang yang daftar untuk poli tersebut pada hari yang sama
															$CekAdaBerapa = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan WHERE tanggal_kunjungan='$tanggalperiksa'"));
															//Satu layanan dihitung 10 menit
															$LamaLayanan=$CekAdaBerapa*10;
															$AwalPraktek = date('H:i:s', strtotime("+$LamaLayanan minute", strtotime($AwalPraktek)));
															//Ubah Tanggal Periksa menjadi milsecon
															date_default_timezone_set('Asia/Jakarta');
															$estimasi="$tanggalperiksa $AwalPraktek";
															$estimasi=strtotime(''.$estimasi.'');
															$estimasi=$estimasi*1000;
															$kodebooking=rand(100000,999999);
															//Mencari nomor antrian
															$QueryAntrian=mysqli_query($Conn, "SELECT MAX(no_antrian) as no_antrian FROM kunjungan WHERE tanggal_kunjungan='$tanggalperiksa'")or die(mysqli_error($Conn));
															while($DataAntrian=mysqli_fetch_array($QueryAntrian)){
																$no_antrian=$DataAntrian['no_antrian'];
															}
															$NilaiTertinggi=$no_antrian+1;
															//Apabila id_pasien tidak ditemukan
															if(empty($id_pasien)){
																$message="Nomor Rekam Medis Yang Digunakan Tidak Ditemukan Pada Database.";
																$code=0;
															}else{
																if(empty($CekAntrianSama)){
																	//Input ke database kunjungan
																	$QueryInputKunjungan="INSERT INTO kunjungan (
																		id_pasien,
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
																		kode_dokter,
																		nama_dokter,
																		kodepoli,
																		namapoli,
																		kelas,
																		keluhan,
																		pembayaran,
																		no_rujukan,
																		status,
																		no_antrian,
																		kodebooking
																	) VALUES (
																		'$id_pasien',
																		'$nomorkartu',
																		'$nik',
																		'$notelp',
																		'$nomorreferensi',
																		'$jenisreferensi',
																		'$jenisrequest',
																		'$polieksekutif',
																		'$tanggal_daftar',
																		'$tanggalperiksa',
																		'$estimasi',
																		'$KodeDokter',
																		'$NamaDokter',
																		'$kodepoli',
																		'$nama_poli',
																		'None',
																		'None',
																		'BPJS',
																		'$nomorreferensi',
																		'Terdaftar',
																		'$NilaiTertinggi',
																		'$kodebooking'
																	)";
																	$InputKunjungan=mysqli_query($Conn, $QueryInputKunjungan);
																	if($InputKunjungan){
																		//Coba ubah
																		$nomorantrean="$NilaiTertinggi";
																		$kodebooking="$kodebooking";
																		$jenisantrean="$jenisrequest";
																		$estimasidilayani="$estimasi";
																		$kodepoli=$kodepoli;
																		$namapoli="$nama_poli";
																		//Respon
																		$message="Sukses";
																		$code=200;
																	}else{
																		$message="Gagal Input Data Antrian Ke Database Webhost.";
																		$code=0;
																	}
																}else{
																	$message="Anda Sudah Mempunyai Nomor Antrian.";
																	$code=0;
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
				if($code==0){
					$metadata = Array (
						"message" => "$message",
						"code" => $code,
					);
					$Array = Array (
						"metadata" => $metadata
					);
				}else{
					$response = Array (
						"nomorantrean" => "$nomorantrean",
						"kodebooking" => "$kodebooking",
						"jenisantrean" => "$jenisantrean",
						"estimasidilayani" => "$estimasidilayani",
						"namapoli" => "$namapoli"
					);
					$metadata = Array (
						"message" => "Sukses",
						"code" => 200,
					);
					$Array = Array (
						"response" => $response,
						"metadata" => $metadata
					);
				}
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
			catch (Exception $e) {	
				// Bagian ini akan jalan jika terdapat error saat JWT diverifikasi atau di-decode
				http_response_code(401);
				exit();
			}		
		}
	}
?>