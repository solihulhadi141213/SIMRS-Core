<?php
    //Time zone
    date_default_timezone_set('Asia/Jakarta');
    $now=date('Y-m-d');
	//Koneksi database
	include "../../_Config/Connection.php";
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	//Decode data json
	$data = json_decode($raw,true);
	//Apabila data username tidak ada
	if(empty($data['username'])){
		$metadata = Array (
			"massage" => "SERVER Username Tidak Boleh Kosong",
			"code" => 201
		);
	}else{
		//Apabila password tidak ada
		if(empty($data['password'])){
			$metadata = Array (
                "massage" => "SERVER Password Tidak Boleh Kosong",
                "code" => 201
            );
		}else{
            $username=$data['username'];
            $password=$data['password'];
            if(empty($data['keyword_by'])){
                $keyword_by="";
            }else{
                $keyword_by=$data['keyword_by'];
            }
            if(empty($data['keyword'])){
                $keyword="";
            }else{
                $keyword=$data['keyword'];
            }
            //Password to md5
            $password = md5($password);
            //Mencari username dan password
            $QryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE username='$username' AND password='$password'")or die(mysqli_error($Conn));
            $Data = mysqli_fetch_array($QryAkses);
            //Apabila ID akses tidak ditemukan
            if(empty($Data['id_akses'])){
                $metadata = Array (
                    "massage" => "SERVER Akses Koneksi Tidak Valid",
                    "code" => 201
                );
            }else{
                //Apakah data antrian ada?
                $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE $keyword_by='$keyword'"));
                if(empty($JumlahData)){
                    $metadata = Array (
                        "massage" => "SERVER Data Antrian Tidak Ada Atau Tidak Ditemukan",
                        "code" => 201
                    );
                }else{
                    //Apakah data antrian ada?
                    $query = "SELECT * FROM antrian WHERE  $keyword_by='$keyword' ORDER BY id_antrian DESC";
                    $hasil  =mysqli_query($Conn, $query);
                    $list = array();
                    while($x = mysqli_fetch_array($hasil)){
                        //Kirim Dalam Bentuk Array
                        $h['id_antrian'] = $x["id_antrian"];
                        $h['no_antrian'] = $x["no_antrian"];
                        $h['kodebooking'] = $x["kodebooking"];
                        $h['id_pasien'] = $x["id_pasien"];
                        $h['nama_pasien'] = $x["nama_pasien"];
                        $h['nomorkartu'] = $x["nomorkartu"];
                        $h['nik'] = $x["nik"];
                        $h['notelp'] = $x["notelp"];
                        $h['tanggal_daftar'] = $x["tanggal_daftar"];
                        $h['tanggal_kunjungan'] = $x["tanggal_kunjungan"];
                        $h['jam_kunjungan'] = $x["jam_kunjungan"];
                        $h['nama_dokter'] = $x["nama_dokter"];
                        $h['namapoli'] = $x["namapoli"];
                        array_push($list, $h);
                    }
                    $metadata = Array (
                        "massage" => "Berhasil",
                        "code" => 200,
                        "totalitems" => "$JumlahData",
                        "list" => $list,
                    );
                }
            }
		}
	}
    $Array = Array (
		"metadata" => $metadata
	);
	$json = json_encode($Array);
	echo "$json";
?>