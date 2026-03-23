<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    //Tangkap id_ruang_rawat
    if(empty($_POST['id_ruang_rawat'])){
        echo '
            <div class="alert alert-danger">ID Ruang Rawat Tidak Boleh Kosong!</div>
        ';
        exit;
    }

    //Tangkap kategori
    if(empty($_POST['kategori'])){
        echo '
            <div class="alert alert-danger">Kategori Data Tidak Boleh Kosong!</div>
        ';
        exit;
    }
    
    //Buat Variabel
    $id_ruang_rawat = $_POST['id_ruang_rawat'];
    $kategori       = $_POST['kategori'];

    //Buka Data Lama
    $Qry = mysqli_query($Conn,"SELECT *  FROM ruang_rawat WHERE id_ruang_rawat='$id_ruang_rawat'")or die(mysqli_error($Conn));
    $Data = mysqli_fetch_array($Qry);

    //Apabila kategori tidak diemukan
    if(Empty($Data['kategori'])){
        echo '<div clas="alert alert-danger">Data yang anda pilih dari database tidak ditemukan!</div>';
        exit;
    }

    //Inisialisasi Variabel Lainnya
    $kodekelas  = "";
    $kelas      = "";
    $ruangan    = "";
    $bed        = "";
    $pria       = "";
    $wanita     = "";
    $bebas      = "";
    $tarif      = "";
    $status     = "Aktif";
    $updatetime = date('Y-m-d H:i:s');

    //Inisialisasi Validasi Form
    $form_validation = "Valid";

    //Validasi Kelengkapan Data Berdasarkan kategori
    if($kategori=='kelas'){

        //Kode Kelas Tidak Boleh Kosong!
        if(empty($_POST['kodekelas'])){
            $form_validation = "Kode Kelas Tidak Boleh Kosong!";
        }else{

            //Nama kelas tidak boleh kosong!
            if(empty($_POST['kelas'])){
                $form_validation = "Nama Kelas Tidak Boleh Kosong!";
            }else{
                $kodekelas  = $_POST['kodekelas'];
                $kelas      = $_POST['kelas'];
                $form_validation = "Valid";
            }
        }
    }else{
        if($kategori=='ruangan'){

            //Kode Kelas Tidak Boleh Kosong!
            if(empty($_POST['kodekelas'])){
                $form_validation = "Kode Kelas Tidak Boleh Kosong!";
            }else{

                //Nama ruangan tidak boleh kosong!
                if(empty($_POST['ruangan'])){
                    $form_validation = "Nama ruangan Tidak Boleh Kosong!";
                }else{
                    $kodekelas  = $_POST['kodekelas'];
                    $kelas      = getDataDetail_v2($Conn, 'ruang_rawat', 'kodekelas', $kodekelas, 'kelas');
                    $ruangan    = $_POST['ruangan'];
                    $form_validation = "Valid";
                }
            }
        }else{
            if($kategori=='bed'){

                //Nama Kelas Tidak Boleh Kosong!
                if(empty($_POST['kelas'])){
                    $form_validation = "Nama Kelas Tidak Boleh Kosong!";
                }else{

                    //Nama ruangan tidak boleh kosong!
                    if(empty($_POST['ruangan'])){
                        $form_validation = "Nama ruangan Tidak Boleh Kosong!";
                    }else{
                        //Gender tidak boleh kosong!
                        if(empty($_POST['gender'])){
                            $form_validation = "Gender Khusus Tidak Boleh Kosong!";
                        }else{
                            //nama bed tidak boleh kosong!
                            if(empty($_POST['bed'])){
                                $form_validation = "Nama Tempat Tidur Tidak Boleh Kosong!";
                            }else{
                                $kelas      = $_POST['kelas'];
                                $bed        = $_POST['bed'];
                                $kodekelas  = getDataDetail_v2($Conn, 'ruang_rawat', 'kelas', $kelas, 'kodekelas');
                                $ruangan    = $_POST['ruangan'];
                                $gender     = $_POST['gender'];

                                //Routing Gender
                                if($gender=="Campur"){
                                    $pria       = "0";
                                    $wanita     = "0";
                                    $bebas      = "1";
                                }else{
                                    if($gender=="Pria"){
                                        $pria       = "1";
                                        $wanita     = "0";
                                        $bebas      = "0";
                                    }else{
                                        if($gender=="Wanita"){
                                            $pria       = "0";
                                            $wanita     = "1";
                                            $bebas      = "0";
                                        }else{
                                            $pria       = "0";
                                            $wanita     = "0";
                                            $bebas      = "0";
                                        }
                                    }
                                }
                                $form_validation = "Valid";
                            }
                        }
                    }
                }
            }else{
                $form_validation = "Kategori Tidak Valid!";
            }
        }
    }

    if($form_validation!=="Valid"){
        echo '
            <div class="alert alert-danger">'.$form_validation.'</div>
        ';
        exit;
    }

    //Routing Proses Update Berdasarkan Kategori
    $validasi_proses = "Tidak Ada Proses";

    //Update Kelas
    if($kategori=="kelas"){
        $kelas_lama = $Data['kelas'];
        $Update = mysqli_query($Conn,"UPDATE ruang_rawat SET 
            kodekelas='$kodekelas',
            kelas='$kelas'
        WHERE kelas='$kelas_lama'") or die(mysqli_error($Conn)); 
        if($Update){
            $validasi_proses = "Berhasil";
        }else{
            $validasi_proses = "Terjadi Kesalahan Pada Saat Update Kelas";
        }
    }

    //Update Ruangan
    if($kategori=="ruangan"){
        
        //Kelas lama
        $kelas_lama = $Data['kelas'];

        //Validasi kodekelas tidak boleh kosong
        if(empty($_POST['kelas'])){
            $validasi_proses = "Silahkan Pilih Kelas Rawat Yang Sesuai Terlebih Dulu";
        }else{

            if(empty($_POST['ruangan'])){
                $validasi_proses = "Nama Ruangan Tidak Boleh Kosong";
            }else{

                //Buat Variabel Ruangan
                $ruangan = $_POST['ruangan'];

                //Buat Variabel kodekelas
                $kelas = $_POST['kelas'];

                //Cari kodekelas
                $kodekelas = getDataDetail_v2($Conn, 'ruang_rawat', 'kelas', $kelas, 'kodekelas');

                //Buka nama ruangan lama
                $ruangan_lama = $Data['ruangan'];

                //Proses Update
                $Update = mysqli_query($Conn,"UPDATE ruang_rawat SET 
                    kodekelas='$kodekelas',
                    kelas='$kelas',
                    ruangan='$ruangan'
                WHERE kelas='$kelas_lama' AND ruangan='$ruangan_lama'") or die(mysqli_error($Conn)); 
                if($Update){
                    $validasi_proses = "Berhasil";
                }else{
                    $validasi_proses = "Terjadi Kesalahan Pada Saat Update Ruangan";
                }
            }
        } 
    }
    //Update Ruangan
    if($kategori=="bed"){
        
        //Kelas lama
        $kelas_lama     = $Data['kelas'];
        $ruangan_lama   = $Data['ruangan'];
        $bed_lama       = $Data['bed'];

        //Validasi kodekelas tidak boleh kosong
        if(empty($_POST['kelas'])){
            $validasi_proses = "Silahkan Pilih Kelas Rawat Yang Sesuai Terlebih Dulu";
        }else{

            if(empty($_POST['ruangan'])){
                $validasi_proses = "Nama Ruangan Tidak Boleh Kosong";
            }else{

                if(empty($_POST['bed'])){
                    $validasi_proses = "Nama Tempat Tidur Tidak Boleh Kosong";
                }else{

                    if(empty($_POST['gender'])){
                        $validasi_proses = "Gender Tempat Tidur Tidak Boleh Kosong";
                    }else{

                        //Buat Variabel Ruangan
                        $ruangan = $_POST['ruangan'];

                        //Buat Variabel kodekelas
                        $kelas = $_POST['kelas'];

                        //Buat Variabel Bed
                        $bed = $_POST['bed'];

                        //Buat Variabel Bed
                        $gender = $_POST['gender'];

                        //Cari nama kelas
                        $kodekelas = getDataDetail_v2($Conn, 'ruang_rawat', 'kelas', $kelas, 'kodekelas');

                        //Routing Gender
                        if($gender=="Campur"){
                            $pria       = "0";
                            $wanita     = "0";
                            $bebas      = "1";
                        }else{
                            if($gender=="Pria"){
                                $pria       = "1";
                                $wanita     = "0";
                                $bebas      = "0";
                            }else{
                                if($gender=="Wanita"){
                                    $pria       = "0";
                                    $wanita     = "1";
                                    $bebas      = "0";
                                }else{
                                    $pria       = "0";
                                    $wanita     = "0";
                                    $bebas      = "0";
                                }
                            }
                        }
                        //Proses Update
                        $Update = mysqli_query($Conn,"UPDATE ruang_rawat SET 
                            kodekelas='$kodekelas',
                            kelas='$kelas',
                            ruangan='$ruangan',
                            bed='$bed',
                            pria='$pria',
                            wanita='$wanita',
                            bebas='$bebas'
                        WHERE kelas='$kelas_lama' AND ruangan='$ruangan_lama' AND bed='$bed_lama'") or die(mysqli_error($Conn)); 
                        if($Update){
                            $validasi_proses = "Berhasil";
                        }else{
                            $validasi_proses = "Terjadi Kesalahan Pada Saat Update Tempat Tidur";
                        }
                    }
                }
            }
        } 
    }
   
    if($validasi_proses=="Berhasil") {
         echo '
            <div class="alert alert-success">Data <b id="NotifikasiEditBerhasil">Berhasil</b> Disimpan</div>
        ';
    }else{
        echo '
            <div class="alert alert-danger">'.$validasi_proses.'</div>
        ';
    }
?>