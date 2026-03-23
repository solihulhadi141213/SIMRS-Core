<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    //Tangkap kategori_tambah
    if(empty($_POST['kategori'])){
        echo '
            <div class="alert alert-danger">Kategori Data Tidak Boleh Kosong!</div>
        ';
        exit;
    }
    
    //Buat Variabel
    $kategori    = $_POST['kategori'];

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

    //Simpan Data
    $EntryRuangKelas = "INSERT INTO ruang_rawat (
        kategori,
        kodekelas,
        kelas,
        ruangan,
        bed,
        pria,
        wanita,
        bebas,
        tarif,
        status,
        updatetime
    ) VALUES (
        '$kategori',
        '$kodekelas',
        '$kelas',
        '$ruangan',
        '$bed',
        '$pria',
        '$wanita',
        '$bebas',
        '$tarif',
        '$status',
        '$updatetime'
    )";
    
    $InputRuangKelas = mysqli_query($Conn, $EntryRuangKelas);
    if($InputRuangKelas) {
         echo '
            <div class="alert alert-success">Data <b id="NotifikasiTambahBerhasil">Berhasil</b> Disimpan</div>
        ';
    }else{
        echo '
            <div class="alert alert-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</div>
        ';
    }
?>