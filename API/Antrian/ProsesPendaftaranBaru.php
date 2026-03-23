<?php
	//Catatan validasi
	// 1.Username dan Password tidak boleh kosong (Password & Username Hak Akses Admin).
	// 2.Nama, gender, kontak, id_poliklinik, id_dokter, pembayaran, tanggal pelayanan, jam pelayanan dan keluhan tidak boleh kosong.
	// 3.nik dan no_kartu tidak boleh kosong bersamaan
	// 4.Apabila pembayaran BPJS maka nik tidak boleh kosong.
	// 5.Apabila pembayaran BPJS maka no_kartu tidak boleh kosong.
	// 6.Apabila pembayaran BPJS maka jeniskunjungan tidak boleh kosong.
	// 7.Apabila pembayaran BPJS maka nomorreferensi tidak boleh kosong.
	// 8.Validasi username dan password harus terdaftar sebagai admin.
	// 9.Validasi antrian yang sama tidak boleh
	// 10.Tanggal pelayanan tidak boleh hari kemarin
	// 11.Validasi ketersediaan kuota
	// 12.Validasi id_dokter pada database
	// 13.Validasi id_poliklinik pada database
	// 14.Validasi jadwal pada database
	// 15. Cek Nik Apakah sudah ada di data pasien 
	// 16. Cek Nomor Kartu Apakah sudah ada di data pasien

	//Koneksi database
	include "../../_Config/Connection.php";
	include "../../_Config/SettingBridging.php";
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	//Decode data json
	$data = json_decode($raw,true);
	//Apabila data username tidak ada
	if(empty($data['username'])){
		$respon = Array (
			"massage" => "Koneksi Ke Server Gagal Karena Username Tidak Ada!!",
			"code" => 201
		);
	}else{
		//Apabila password tidak ada
		if(empty($data['password'])){
			$respon = Array (
				"massage" => "Koneksi Ke Server Gagal Karena Password Tidak Ada!!",
				"code" => 201
			);
		}else{
			//Apabila nama tidak ada
			if(empty($data['nama'])){
				$respon = Array (
					"massage" => "Nama Pasien Tidak Boleh Kosong",
					"code" => 201
				);
			}else{
				//Apabila gender tidak ada
				if(empty($data['gender'])){
					$respon = Array (
						"massage" => "Gender Pasien Tidak Boleh Kosong",
						"code" => 201
					);
				}else{
					//Apabila kontak tidak ada
					if(empty($data['kontak'])){
						$respon = Array (
							"massage" => "No Kontak Tidak Boleh Kosong",
							"code" => 201
						);
					}else{
						//Apabila id_poliklinik tidak ada
						if(empty($data['id_poliklinik'])){
							$respon = Array (
								"massage" => "Poliklinik Tidak Boleh Kosong",
								"code" => 201
							);
						}else{
							//Apabila dokter tidak ada
							if(empty($data['dokter'])){
								$respon = Array (
									"massage" => "Dokter Tidak Boleh Kosong",
									"code" => 201
								);
							}else{
								//Apabila pembayaran tidak ada
								if(empty($data['pembayaran'])){
									$respon = Array (
										"massage" => "Metode Pembayaran Tidak Boleh Kosong",
										"code" => 201
									);
								}else{
									//Apabila tanggal_pelayanan tidak ada
									if(empty($data['tanggal_pelayanan'])){
										$respon = Array (
											"massage" => "Tanggal Pelayanan Tidak Boleh Kosong",
											"code" => 201
										);
									}else{
										//Apabila jam_pelayanan tidak ada
										if(empty($data['jam_pelayanan'])){
											$respon = Array (
												"massage" => "Jam Pelayanan Tidak Boleh Kosong",
												"code" => 201
											);
										}else{
											//Apabila keluhan tidak ada
											if(empty($data['keluhan'])){
												$respon = Array (
													"massage" => "Keterangan Keluhan/Tujuan Tidak Boleh Kosong",
													"code" => 201
												);
											}else{
												//Apabila nik dan no_kartu tidak ada
												if(empty($data['nik'])&&empty($data['no_kartu'])){
													$respon = Array (
														"massage" => "Setidaknya diantara No NIK dan No Kartu harus terisi",
														"code" => 201
													);
												}else{
													//Apabila peserta bpjs dan tidak ada no_kartu
													if($data['pembayaran']=="BPJS"&&empty($data['no_kartu'])){
														$respon = Array (
															"massage" => "No Kartu tidak boleh kosong jika pembayaran bpjs",
															"code" => 201
														);
													}else{
														//Apabila peserta bpjs dan tidak ada nik
														if($data['pembayaran']=="BPJS"&&empty($data['nik'])){
															$respon = Array (
																"massage" => "NIK tidak boleh kosong jika pembayaran bpjs",
																"code" => 201
															);
														}else{
															//Apabila peserta bpjs dan tidak ada jeniskunjungan
															if($data['pembayaran']=="BPJS"&&empty($data['jeniskunjungan'])){
																$respon = Array (
																	"massage" => "Jenis Kunjungan tidak boleh kosong jika pembayaran bpjs",
																	"code" => 201
																);
															}else{
																//Apabila peserta bpjs dan tidak ada nomorreferensi
																if($data['pembayaran']=="BPJS"&&empty($data['nomorreferensi'])){
																	$respon = Array (
																		"massage" => "No.Referensi tidak boleh kosong jika pembayaran bpjs",
																		"code" => 201
																	);
																}else{
																	$username=$data['username'];
																	$password=$data['password'];
																	$nama=$data['nama'];
																	$gender=$data['gender'];
																	$kontak=$data['kontak'];
																	$id_poliklinik=$data['id_poliklinik'];
																	$dokter=$data['dokter'];
																	$pembayaran=$data['pembayaran'];
																	$tanggal_pelayanan=$data['tanggal_pelayanan'];
																	$jam_pelayanan=$data['jam_pelayanan'];
																	$keluhan=$data['keluhan'];
																	$day = date('D', strtotime($tanggal_pelayanan));
																	$dayList = array(
																		'Sun' => 'Minggu',
																		'Mon' => 'Senin',
																		'Tue' => 'Selasa',
																		'Wed' => 'Rabu',
																		'Thu' => 'Kamis',
																		'Fri' => 'Jumat',
																		'Sat' => 'Sabtu'
																	);
																	$NamaHari=$dayList[$day];
																	if(empty($data['nik'])){
																		$nik="";
																		$CekNik="";
																	}else{
																		$nik=$data['nik'];
																		//Cek Nik Apakah sudah ada
																		$QryCekNik=mysqli_query($Conn,"SELECT * FROM pasien WHERE nik='$nik'");
																		$CekNik=mysqli_num_rows($QryCekNik);
																	}
																	if(empty($data['no_kartu'])){
																		$no_kartu="";
																	}else{
																		$no_kartu=$data['no_kartu'];
																		//Cek No Kartu Apakah sudah ada
																		$QryNoKartu=mysqli_query($Conn,"SELECT * FROM pasien WHERE no_bpjs='$no_kartu'");
																		$CekNoKartu=mysqli_num_rows($QryNoKartu);
																	}
																	if(empty($data['jeniskunjungan'])){
																		if($pembayaran=="BPJS"){
																			$jeniskunjungan="0";
																		}else{
																			$jeniskunjungan="1";
																		}
																		
																	}else{
																		$jeniskunjungan=$data['jeniskunjungan'];
																	}
																	if(empty($data['nomorreferensi'])){
																		$nomorreferensi="";
																	}else{
																		$nomorreferensi=$data['nomorreferensi'];
																	}
																	//Validasi username dan password
																	//md5 password
																	$password=md5($password);
																	$QryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE username='$username' AND password='$password' AND akses='Admin'")or die(mysqli_error($Conn));
																	$Data = mysqli_fetch_array($QryAkses);
																	//Apabila ID akses tidak ditemukan
																	if(empty($Data['id_akses'])){
																		$respon = Array (
																			"massage" => "Koneksi Ke Server Gagal Karena Username dan Password Tidak Valid",
																			"code" => 201
																		);
																	}else{
																		//Time config
																		$now=date('Y-m-d');
																		$tanggal_daftar_time=date('Y-m-d H:i');
																		$tanggal_daftar=date('Y-m-d');
																		$updatetime=date('Y-m-d H:i');
																		//Buka Id Dokter
																		$QryDokter = mysqli_query($Conn, "SELECT * FROM dokter WHERE nama='$dokter'")or die(mysqli_error($Conn));
																		$DataDokter = mysqli_fetch_array($QryDokter);
																		$id_dokter = $DataDokter['id_dokter'];
																		$kode_dokter = $DataDokter['kode'];
																		$nama_dokter = $DataDokter['nama'];
																		//PANGGIL NAMA POLI DAN ID POLI
																		$QryPoli = mysqli_query($Conn, "SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'")or die(mysqli_error($Conn));
																		$DataPoli = mysqli_fetch_array($QryPoli);
																		$nama_poliklinik = $DataPoli['nama'];
																		$kode_poliklinik = $DataPoli['kode'];
																		//Buka Jadwal Untuk mengetahui jam layanan
																		$QryJadwal = mysqli_query($Conn, "SELECT * FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik' AND jam='$jam_pelayanan' AND hari='$NamaHari'")or die(mysqli_error($Conn));
																		$DataJadwal = mysqli_fetch_array($QryJadwal);
																		$id_jadwal = $DataJadwal['id_jadwal'];
																		$JamPraktek=$DataJadwal['jam'];
																		$kuota_non_jkn=$DataJadwal['kuota_non_jkn'];
																		$kuota_jkn=$DataJadwal['kuota_jkn'];
																		$time_max=$DataJadwal['time_max'];
																		//Cari jam kapan mulai prakteknya
																		$explode = explode("-" , $JamPraktek);
																		$MulaiPraktekPraktek=$explode[0];
																		//Tanggal & jam praktek aktual
																		$tanggal_praktek_aktual="$tanggal_pelayanan $MulaiPraktekPraktek";
																		$tanggal_praktek_aktual2=strtotime($tanggal_praktek_aktual);
																		$tanggal_pendaftaran_minimum=date('Y-m-d H:i', $tanggal_praktek_aktual2 - $time_max);
																		//Ada berapa orang yang daftar untuk poli tersebut pada hari yang sama
																		$CekAdaBerapa = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal_pelayanan'"));
																		//Satu layanan dihitung 10 menit
																		$LamaLayanan=$CekAdaBerapa*10;
																		$AwalPraktek = date('H:i:s', strtotime("+$LamaLayanan minute", strtotime($MulaiPraktekPraktek)));
																		//Ubah Tanggal Periksa menjadi milsecon
																		date_default_timezone_set('Asia/Jakarta');
																		$estimasi="$tanggal_pelayanan $AwalPraktek";
																		$estimasi=strtotime(''.$estimasi.'');
																		$estimasi=$estimasi*1000;
																		//Jumlah antrian total dengan yang bersangkutan
																		$JumlahAntrianTotal=$CekAdaBerapa+1;
																		//Kuota berdasar jenis kunjungan
																		if($pembayaran=="BPJS"){
																			$kuota=$kuota_jkn;
																		}else{
																			$kuota=$kuota_non_jkn;
																		}
																		//Generate nomor rm
																		$query_rm=mysqli_query($Conn, "SELECT max(id_pasien) as maksimal FROM pasien")or die(mysqli_error($Conn));
																		while($hasil_kode=mysqli_fetch_array($query_rm)){
																			$rm=$hasil_kode['maksimal'];
																		}
																		$id_pasien=$rm+1;
																		//Mencari nomor antrian
																		$QueryAntrian=mysqli_query($Conn, "SELECT MAX(no_antrian) as no_antrian FROM antrian WHERE tanggal_kunjungan='$tanggal_pelayanan'")or die(mysqli_error($Conn));
																		while($DataAntrian=mysqli_fetch_array($QueryAntrian)){
																			$no_antrian=$DataAntrian['no_antrian'];
																		}
																		$NoAntrian=$no_antrian+1;   
																		$kodebooking=rand(100000,999999);   
																		$kodebooking=("$NoAntrian$kodebooking");
																		//Sisa Kuota
																		$JumlahAntrian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE tanggal_kunjungan='$tanggal_pelayanan' AND kode_dokter='$kode_dokter'"));
																		$SisaAntrian=($kuota_non_jkn+$kuota_jkn)-$JumlahAntrian;
																		$sisakuotanonjkn=$kuota_non_jkn-($JumlahAntrian+1);
																		$sisakuotajkn=$kuota_jkn-($JumlahAntrian+1);
																		if($pembayaran=="BPJS"){
																			$SiswaKuota=$sisakuotajkn;
																		}else{
																			$SiswaKuota=$sisakuotanonjkn;
																		}
																		//Inisiasi metode pembayaran
																		if($pembayaran=="BPJS"){
																			$Pembayaran="BPJS";
																			$JenisPasien="JKN";
																		}else{
																			$Pembayaran="UMUM";
																			$JenisPasien="NON JKN";
																		}
																		$CekAntrianSama = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE id_pasien='$id_pasien' AND tanggal_kunjungan='$tanggal_pelayanan' AND jam_kunjungan='$jam_pelayanan'"));
																		//Validasi antrian sama
																		if(!empty($CekAntrianSama)){
																			$respon = Array (
																				"massage" => "Peserta dengan no.RM $id_pasien sudah terdaftar",
																				"code" => 201
																			);
																		}else{
																			//Validasi pendaftaran tidak bisa untuk kemarin
																			if($tanggal_pelayanan<$now){
																				$respon = Array (
																					"massage" => "Tidak bisa mendaftar untuk hari kemarin",
																					"code" => 201
																				);
																			}else{
																				//Validasi kuota tidak boleh melebihi
																				if($JumlahAntrianTotal>$kuota){
																					$respon = Array (
																						"massage" => "Kuota sudah penuh",
																						"code" => 201
																					);
																				}else{
																					if(empty($DataDokter['id_dokter'])){
																						$respon = Array (
																							"massage" => "Dokter yang anda pilih tidak ditemukan",
																							"code" => 201
																						);
																					}else{
																						if(empty($DataPoli['nama'])){
																							$respon = Array (
																								"massage" => "Poli yang anda pilih tidak ditemukan",
																								"code" => 201
																							);
																						}else{
																							if(empty($DataJadwal['id_jadwal'])){
																								$respon = Array (
																									"massage" => "Jadwal yang anda pilih tidak ditemukan",
																									"code" => 201
																								);
																							}else{
																								if(!empty($CekNik)){
																									$respon = Array (
																										"massage" => "NIK Sudah Terdaftar, Silahkan Lakukan Pendaftaran Sebagai Pasien Lama",
																										"code" => 201
																									);
																								}else{
																									if(!empty($CekNoKartu)){
																										$respon = Array (
																											"massage" => "Nomor Kartu Sudah Terdaftar, Silahkan Lakukan Pendaftaran Sebagai Pasien Lama",
																											"code" => 201
																										);
																									}else{
																										$InputPasien="INSERT INTO pasien (
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
																											'$now',
																											'$nik',
																											'$no_kartu',
																											'$nama',
																											'$gender',
																											'',
																											'',
																											'',
																											'',
																											'',
																											'',
																											'',
																											'$kontak',
																											'$kontak',
																											'$nama',
																											'',
																											'',
																											'',
																											'',
																											'Aktiv',
																											'$updatetime'
																										)";
																										$HasilInputPasien=mysqli_query($Conn, $InputPasien);
																										if($HasilInputPasien){
																											$InputKunjungan="INSERT INTO antrian (
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
																												status
																											) VALUES (
																												'0',
																												'$NoAntrian',
																												'$kodebooking',
																												'$id_pasien',
																												'$nama',
																												'$no_kartu',
																												'$nik',
																												'$kontak',
																												'$nomorreferensi',
																												'$jeniskunjungan',
																												'0',
																												'0',
																												'$now',
																												'$tanggal_pelayanan',
																												'$jam_pelayanan',
																												'',
																												'$kode_dokter',
																												'$nama_dokter',
																												'$kode_poliklinik',
																												'$nama_poliklinik',
																												'',
																												'$keluhan',
																												'$pembayaran',
																												'$nomorreferensi',
																												'Terdaftar'
																											)";
																											$HasilInputKunjungan=mysqli_query($Conn, $InputKunjungan);
																											if($HasilInputKunjungan){
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
																													'jenispasien' => "$JenisPasien",
																													'nomorkartu' => $no_kartu,
																													'nik' => $nik,
																													'nohp' => $kontak,
																													'kodepoli' => $kode_poliklinik,
																													'namapoli' => $nama_poliklinik,
																													'pasienbaru' => "1",
																													'norm' => $id_pasien,
																													'tanggalperiksa' => $tanggal_pelayanan,
																													'kodedokter' => $kode_dokter,
																													'namadokter' => $nama_dokter,
																													'jampraktek' => $jam_pelayanan,
																													'jeniskunjungan' => $jeniskunjungan,
																													'nomorreferensi' => $nomorreferensi,
																													'nomorantrean' => "A-$NoAntrian",
																													'angkaantrean' => $NoAntrian,
																													'estimasidilayani' => $estimasi,
																													'sisakuotajkn' => $sisakuotajkn,
																													'kuotajkn' => $kuota_jkn,
																													'sisakuotanonjkn' => $sisakuotanonjkn,
																													'kuotanonjkn' => $kuota_non_jkn,
																													'keterangan' => "Peserta harap checkin di lokasi sebelum jam praktek"
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
																													$respon = Array (
																														"massage" => "Berhasil",
																														"kodebooking" => "$kodebooking",
																														"code" => 200
																													);
																												}else{
																													$respon = Array (
																														"massage" => "Kirim Data Antrian Ke BPJS Gagal! $message Jenis: $jeniskunjungan",
																														"pesan" => $message,
																														"code" => 201
																													);
																													//Hapus antrian
																													$QryHapusAntrian="DELETE FROM antrian WHERE kodebooking='$kodebooking'";
																													$HapusAntrian=mysqli_query($Conn, $QryHapusAntrian);
																													if($QryHapusAntrian){
																														//hapus pasien
																														$hapus_pasien = "DELETE FROM pasien WHERE id_pasien = '$id_pasien'";
																														$HasilHapusPasien = mysqli_query($Conn, $hapus_pasien);
																													}
																												}
																											}else{
																												$respon = Array (
																													"massage" => "Pendaftaran Antrian Gagal, Silahkan Hubungi Admin Untuk Masalah ini",
																													"code" => 201
																												);
																												//hapus pasien
																												$hapus_pasien = "DELETE FROM pasien WHERE id_pasien = '$id_pasien'";
																												$HasilHapusPasien = mysqli_query($Conn, $hapus_pasien);
																											}
																										}else{
																											$respon = Array (
																												"massage" => "Pendaftaran pasien baru gagal!",
																												"code" => 201
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
							}
						}
					}
				}
			}
		}
	}
	$Array = Array (
		"respon" => $respon
	);
	$json = json_encode(array("data" => $Array));
	echo "$json";
?>