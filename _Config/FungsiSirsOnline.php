<?php
    //ReferensiTtSirsOnline
    function ReferensiTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$metode){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Referensi/tempat_tidur',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //ReferensiTtSirsOnline
    function DataTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$metode){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //ReferensiTtSirsOnline
    function ReferensiSdmSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$metode){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Referensi/kebutuhan_sdm',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //ReferensiSdmSirsOnline
    function DataSdmSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$metode){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes/sdm',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //CreatSdmSirsOnline
    function CreatSdmSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$json){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes/sdm',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>''.$json.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.'',
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //CreatSdmSirsOnline
    function UpdateSdmSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$json){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes/sdm',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS =>''.$json.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.'',
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //ReferensiAlkesSirsOnline
    function ReferensiAlkesSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$metode){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Referensi/kebutuhan_apd',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //DataAlkesSirsOnline
    function DataAlkesSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$metode){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes/apd',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //DataPcrNakes
    function DataPcrNakes($x_id_rs,$password_sirs_online,$url_sirs_online,$metode,$tanggal){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/pcr_nakes',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.'',
            'X-tanggal: '.$tanggal.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //PostDataSirsOnline
    function PostDataSirsOnline($x_id_rs,$password_sirs_online,$BaseUrl,$UrlService,$RawData){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$BaseUrl.'/'.$UrlService.'',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$RawData.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //HapusDataPcrNakes
    function HapusDataPcrNakes($x_id_rs,$password_sirs_online,$BaseUrl,$UrlService,$tanggal){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$BaseUrl.'/'.$UrlService.'',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'X-tanggal: '.$tanggal.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //ReferensiSdmSirsOnline
    function DataAntrianSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$metode,$tanggal){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Antrian',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => ''.$metode.'',
        CURLOPT_POSTFIELDS =>'{
            "tanggal": "'.$tanggal.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.''
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //CreatBookingAntrian
    function CreatBookingAntrian($x_id_rs,$password_sirs_online,$url_sirs_online,$json){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Antrian',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>''.$json.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.'',
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //UpdateBookingAntrian
    function UpdateBookingAntrian($x_id_rs,$password_sirs_online,$url_sirs_online,$json){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Antrian',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS =>''.$json.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.'',
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //UpdateBookingAntrian
    function UpdateTaskIdAntrian($x_id_rs,$password_sirs_online,$url_sirs_online,$json){
        $x_timestamp=time();
        //Kirim CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Antrian/Task',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS =>''.$json.'',
        CURLOPT_HTTPHEADER => array(
            'X-rs-id: '.$x_id_rs.'',
            'X-Timestamp: '.$x_timestamp.'',
            'X-pass: '.$password_sirs_online.'',
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //CreatPasienShk
    function CreatPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/shk',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$json,
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    //UpdatePasienShk
    function UpdatePasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/shk',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>$json,
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function DetailPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$id_shk,$tgl_ambil_sampel){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/shk',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>'{
                "id_shk": "'.$id_shk.'",
                "tgl_ambil_smpel": "'.$tgl_ambil_sampel.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function HapusPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/hasilShk',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function DetailLabPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$id_shk){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/hasilShk',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>'{
                "id_shk": "'.$id_shk.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function TambahHasilLabPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/hasilShk',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function HapusLabPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$id_shk,$id_hasil){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/hasilShk',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS =>'{
                "id_shk": "'.$id_shk.'",
                "id_hasil": "'.$id_hasil.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function UpdateHasilLabPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/hasilShk',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function DataOksigenSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,$tanggal){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Logistik/oksigen',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'X-tanggal: '.$tanggal.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function TambahLaporanOksigen($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Logistik/oksigen',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function UpdateLaporanOksigen($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Logistik/oksigen',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function TambahTempatTidur($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function UpdateTempatTidur($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function HapusTempatTidur($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function TambahAlkes($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes/apd',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function EditAlkes($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes/apd',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function HapusAlkes($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Fasyankes/apd',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function AddNakesTerinfeksi($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/harian_nakes_terinfeksi',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>''.$json_data.'',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function GetNakesTerinfeksi($x_id_rs,$password_sirs_online,$url_sirs_online,$tanggal){
        $x_timestamp=time();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$url_sirs_online.'/fo/index.php/Pasien/harian_nakes_terinfeksi',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-rs-id: '.$x_id_rs.'',
                'X-Timestamp: '.$x_timestamp.'',
                'X-pass: '.$password_sirs_online.'',
                'Content-Type: application/json',
                'X-tanggal: '.$tanggal.'',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
?>