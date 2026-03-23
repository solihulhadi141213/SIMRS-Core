<?php
	//Koneksi database
    date_default_timezone_set('Asia/Jakarta');
	include "../../../_Config/Connection.php";
	$fp = fopen('php://input', 'r');
	$raw = stream_get_contents($fp);
	//Decode data json
	$data = json_decode($raw,true);
	//Apabila data api_key tidak ada
	if(empty($data['api_key'])){
		$metadata = Array (
			"massage" => "Koneksi Ke Server Gagal Karena API Key Tidak Ada!!",
			"code" => 401
		);
        $response = Array ();
	}else{
        $api_key=$data['api_key'];
        //Validasi API Key
        $QryApiKey = mysqli_query($Conn,"SELECT * FROM web_setting  WHERE api_key='$api_key'")or die(mysqli_error($Conn));
        $DataApiKey = mysqli_fetch_array($QryApiKey);
        //Apabila api_key tidak ditemukan
        if(empty($DataApiKey['id_web_setting'])){
            $metadata = Array (
                "massage" => "Koneksi Ke Server Gagal Karena API Key Tidak Valid",
                "code" => 401
            );
            $response = Array ();
        }else{
            //Apabila Api Key Tidak Aktif
            $api_status = $DataApiKey['api_status'];
            if($api_status!=="Active"){
                $metadata = Array (
                    "massage" => "Koneksi Ke Server Gagal Karena API Key Sudah Tidak Aktif",
                    "code" => 401
                );
                $response = Array ();
            }else{
                //Jika Valid Buat Variabel
                $web_title = $DataApiKey['web_title'];
                $web_deskripsi = $DataApiKey['web_deskripsi'];
                $web_keywords = $DataApiKey['web_keywords'];
                $web_author = $DataApiKey['web_author'];
                $web_kontak = $DataApiKey['web_kontak'];
                $web_email = $DataApiKey['web_email'];
                $web_alamat = $DataApiKey['web_alamat'];
                $web_favicon = $DataApiKey['web_favicon'];
                $web_waktu_operasional = $DataApiKey['web_waktu_operasional'];
                $web_baseurl = $DataApiKey['web_baseurl'];
                $metadata = Array (
                    "massage" => "Berhasil",
                    "code" => 200
                );
                $response = Array (
                    "web_title" => "$web_title",
                    "web_deskripsi" => "$web_deskripsi",
                    "web_keywords" => "$web_keywords",
                    "web_author" => "$web_author",
                    "web_kontak" => "$web_kontak",
                    "web_email" => "$web_email",
                    "web_alamat" => "$web_alamat",
                    "web_favicon" => "$web_favicon",
                    "web_waktu_operasional" => "$web_waktu_operasional",
                    "web_baseurl" => "$web_baseurl"
                );
            }
		}
	}
    //Simpan Data Log
    $web_metadata = json_encode($metadata, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    $web_datetime=date('Y-m-d H:i:s');
    $InputWebLog="INSERT INTO web_log_api (
        api_key,
        web_datetime,
        web_log_service,
        web_metadata
    ) VALUES (
        '$api_key',
        '$web_datetime',
        'Web Info',
        '$web_metadata'
    )";
    $HasilInputWebLog=mysqli_query($Conn, $InputWebLog);
    if($HasilInputWebLog){
        $Array = Array (
            "metadata" => $metadata,
            "response" => $response,
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
?>