<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['tanggal'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      Tanggal Laporan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $tanggal=$_POST['tanggal'];
        //Buka Pengaturan SIRS Online
        $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
        $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
        $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
        //Request Data
        $response=DataPcrNakes($x_id_rs,$password_sirs_online,$url_sirs_online,'GET',$tanggal);
        $php_array = json_decode($response, true);
        if(!empty($php_array['PCRNakes'])){
            $DataPcrNakes=$php_array['PCRNakes'];
            $JumlahData=count($DataPcrNakes);
        }else{
            $DataPcrNakes="";
            $JumlahData=0;
        }
        foreach ($DataPcrNakes as $array_data) {
            //Buka data json
            $tanggal = $array_data['tanggal'];
            $jumlah_tenaga_dokter_umum = $array_data['jumlah_tenaga_dokter_umum'];
            $sudah_periksa_dokter_umum = $array_data['sudah_periksa_dokter_umum'];
            $hasil_pcr_dokter_umum = $array_data['hasil_pcr_dokter_umum'];
            $jumlah_tenaga_dokter_spesialis = $array_data['jumlah_tenaga_dokter_spesialis'];
            $sudah_periksa_dokter_spesialis = $array_data['sudah_periksa_dokter_spesialis'];
            $hasil_pcr_dokter_spesialis = $array_data['hasil_pcr_dokter_spesialis'];
            $jumlah_tenaga_dokter_gigi = $array_data['jumlah_tenaga_dokter_gigi'];
            $sudah_periksa_dokter_gigi = $array_data['sudah_periksa_dokter_gigi'];
            $hasil_pcr_dokter_gigi = $array_data['hasil_pcr_dokter_gigi'];
            $jumlah_tenaga_residen = $array_data['jumlah_tenaga_residen'];
            $sudah_periksa_residen = $array_data['sudah_periksa_residen'];
            $hasil_pcr_residen = $array_data['hasil_pcr_residen'];
            $jumlah_tenaga_perawat = $array_data['jumlah_tenaga_perawat'];
            $sudah_periksa_perawat = $array_data['sudah_periksa_perawat'];
            $hasil_pcr_perawat = $array_data['hasil_pcr_perawat'];
            $jumlah_tenaga_bidan = $array_data['jumlah_tenaga_bidan'];
            $sudah_periksa_bidan = $array_data['sudah_periksa_bidan'];
            $hasil_pcr_bidan = $array_data['hasil_pcr_bidan'];
            $jumlah_tenaga_apoteker = $array_data['jumlah_tenaga_apoteker'];
            $sudah_periksa_apoteker = $array_data['sudah_periksa_apoteker'];
            $hasil_pcr_apoteker = $array_data['hasil_pcr_apoteker'];
            $jumlah_tenaga_radiografer = $array_data['jumlah_tenaga_radiografer'];
            $sudah_periksa_radiografer = $array_data['sudah_periksa_radiografer'];
            $hasil_pcr_radiografer = $array_data['hasil_pcr_radiografer'];
            $jumlah_tenaga_analis_lab = $array_data['jumlah_tenaga_analis_lab'];
            $sudah_periksa_analis_lab = $array_data['sudah_periksa_analis_lab'];
            $hasil_pcr_analis_lab = $array_data['hasil_pcr_analis_lab'];
            $jumlah_tenaga_co_ass = $array_data['jumlah_tenaga_co_ass'];
            $sudah_periksa_co_ass = $array_data['sudah_periksa_co_ass'];
            $hasil_pcr_co_ass = $array_data['hasil_pcr_co_ass'];
            $jumlah_tenaga_internship = $array_data['jumlah_tenaga_internship'];
            $sudah_periksa_internship = $array_data['sudah_periksa_internship'];
            $hasil_pcr_internship = $array_data['hasil_pcr_internship'];
            $jumlah_tenaga_nakes_lainnya = $array_data['jumlah_tenaga_nakes_lainnya'];
            $sudah_periksa_nakes_lainnya = $array_data['sudah_periksa_nakes_lainnya'];
            $hasil_pcr_nakes_lainnya = $array_data['hasil_pcr_nakes_lainnya'];
            $rekap_jumlah_tenaga = $array_data['rekap_jumlah_tenaga'];
            $rekap_jumlah_sudah_diperiksa = $array_data['rekap_jumlah_sudah_diperiksa'];
            $rekap_jumlah_hasil_pcr = $array_data['rekap_jumlah_hasil_pcr'];
            $tgllapor = $array_data['tgllapor'];
            //Buat Json
            $data = array(
                'tanggal' => $tanggal,
                'jumlah_tenaga_dokter_umum' => $jumlah_tenaga_dokter_umum,
                'sudah_periksa_dokter_umum' => $sudah_periksa_dokter_umum,
                'hasil_pcr_dokter_umum' => $hasil_pcr_dokter_umum,
                'jumlah_tenaga_dokter_spesialis' => $jumlah_tenaga_dokter_spesialis,
                'sudah_periksa_dokter_spesialis' => $sudah_periksa_dokter_spesialis,
                'hasil_pcr_dokter_spesialis' => $hasil_pcr_dokter_spesialis,
                'jumlah_tenaga_dokter_gigi' => $jumlah_tenaga_dokter_gigi,
                'sudah_periksa_dokter_gigi' => $sudah_periksa_dokter_gigi,
                'hasil_pcr_dokter_gigi' => $hasil_pcr_dokter_gigi,
                'jumlah_tenaga_residen' => $jumlah_tenaga_residen,
                'sudah_periksa_residen' => $sudah_periksa_residen,
                'hasil_pcr_residen' => $hasil_pcr_residen,
                'jumlah_tenaga_perawat' => $jumlah_tenaga_perawat,
                'sudah_periksa_perawat' => $sudah_periksa_perawat,
                'hasil_pcr_perawat' => $hasil_pcr_perawat,
                'jumlah_tenaga_bidan' => $jumlah_tenaga_bidan,
                'sudah_periksa_bidan' => $sudah_periksa_bidan,
                'hasil_pcr_bidan' => $hasil_pcr_bidan,
                'jumlah_tenaga_apoteker' => $jumlah_tenaga_apoteker,
                'sudah_periksa_apoteker' => $sudah_periksa_apoteker,
                'hasil_pcr_apoteker' => $hasil_pcr_apoteker,
                'jumlah_tenaga_radiografer' => $jumlah_tenaga_radiografer,
                'sudah_periksa_radiografer' => $sudah_periksa_radiografer,
                'hasil_pcr_radiografer' => $hasil_pcr_radiografer,
                'jumlah_tenaga_analis_lab' => $jumlah_tenaga_analis_lab,
                'sudah_periksa_analis_lab' => $sudah_periksa_analis_lab,
                'hasil_pcr_analis_lab' => $hasil_pcr_analis_lab,
                'jumlah_tenaga_co_ass' => $jumlah_tenaga_co_ass,
                'sudah_periksa_co_ass' => $sudah_periksa_co_ass,
                'hasil_pcr_co_ass' => $hasil_pcr_co_ass,
                'jumlah_tenaga_internship' => $jumlah_tenaga_internship,
                'sudah_periksa_internship' => $sudah_periksa_internship,
                'hasil_pcr_internship' => $hasil_pcr_internship,
                'jumlah_tenaga_nakes_lainnya' => $jumlah_tenaga_nakes_lainnya,
                'sudah_periksa_nakes_lainnya' => $sudah_periksa_nakes_lainnya,
                'hasil_pcr_nakes_lainnya' => $hasil_pcr_nakes_lainnya,
                'rekap_jumlah_tenaga' => $rekap_jumlah_tenaga,
                'rekap_jumlah_sudah_diperiksa' => $rekap_jumlah_sudah_diperiksa,
                'rekap_jumlah_hasil_pcr' => $rekap_jumlah_hasil_pcr,
                'tgllapor' => $tgllapor,
            );
            $json_data = json_encode($data);
            //Cek apakah data tersebut sudah ada?
            $id_pcr_nakes=getDataDetail($Conn,'pcr_nakes','tanggal',$tanggal,'id_pcr_nakes');
            if(empty($id_pcr_nakes)){
                //Tambah data
                $entry="INSERT INTO pcr_nakes (
                    tanggal,
                    tanggal_laporan,
                    jumlah,
                    raw_json,
                    status,
                    id_akses
                ) VALUES (
                    '$tanggal',
                    '$tgllapor',
                    '$rekap_jumlah_tenaga',
                    '$json_data',
                    'Syn',
                    '$SessionIdAkses'
                )";
                $hasil=mysqli_query($Conn, $entry);
                if($hasil){
                    $_SESSION['NotifikasiSwal']="Tambah PCR Nakes Berhasil";
                    echo '<span class="text-success" id="NotifikasiCopyPcrNakesBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan pada saat menyimpan data pada database</span>';
                }
            }else{
                //Update Data
                $UpdatePcrNakes = mysqli_query($Conn,"UPDATE pcr_nakes SET 
                    tanggal='$tanggal',
                    tanggal_laporan='$tgllapor',
                    jumlah='$rekap_jumlah_tenaga',
                    raw_json='$json_data',
                    status='Syn',
                    id_akses='$SessionIdAkses'
                WHERE id_pcr_nakes='$id_pcr_nakes'") or die(mysqli_error($Conn)); 
                if($UpdatePcrNakes){
                    $_SESSION['NotifikasiSwal']="Edit PCR Nakes Berhasil";
                    echo '<span class="text-success" id="NotifikasiCopyPcrNakesBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan pada saat menyimpan data pada database</span>';
                }
            }
        }
    }
?>