<?php
    //Zona waktu dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Menangkap data
    if(empty($_POST['kode'])){
        echo '<span class="text-danger">Kode Dokter Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['nama'])){
            echo '<span class="text-danger">Nama Dokter Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kategori'])){
                echo '<span class="text-danger">Kategori Dokter Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['kategori_identitas'])){
                    echo '<span class="text-danger">Kategori identias Dokter Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['no_identitas'])){
                        echo '<span class="text-danger">Nomor Identitas Dokter Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['email'])){
                                $email="";
                                $ValidasiEmail="";
                            }else{
                                $email=$_POST['email'];
                                $ValidasiEmail=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE email='$email'"));
                            }
                            if(empty($_POST['SIP'])){
                                $SIP="";
                                $ValidasiSIP="";
                            }else{
                                $SIP=$_POST['SIP'];
                                $ValidasiSIP=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE SIP='$SIP'"));
                            }
                            if(empty($_POST['kontak'])){
                                $kontak="";
                                $ValidasiKarakterKontak=true;
                                $ValidasiKontak="";
                            }else{
                                $kontak=$_POST['kontak'];
                                $ValidasiKontak=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE kontak='$kontak'"));
                                //Validasi Kontak Hanya Boleh Angka
                                if(preg_match('/^[0-9]+$/', $kontak)){
                                    $ValidasiKarakterKontak=true;
                                }else{
                                    $ValidasiKarakterKontak=false;
                                }
                            }
                            if(empty($_POST['alamat'])){
                                $alamat="";
                            }else{
                                $alamat=$_POST['alamat'];
                            }
                            $kode=$_POST['kode'];
                            $nama=$_POST['nama'];
                            $kategori=$_POST['kategori'];
                            $kategori_identitas=$_POST['kategori_identitas'];
                            $no_identitas=$_POST['no_identitas'];
                            $status=$_POST['status'];
                            if(empty($_POST['id_ihs_practitioner'])){
                                $id_ihs_practitioner="";
                                $ValidasiIhs="";
                            }else{
                                $id_ihs_practitioner=$_POST['id_ihs_practitioner'];
                                $ValidasiIhs=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE id_ihs_practitioner='$id_ihs_practitioner'"));
                            }
                            //Validasi Duplikat
                            $ValidasiKode=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE kode='$kode'"));
                            $ValidasiNama=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE nama='$nama'"));
                            $ValidasiNomorIdentitas=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE no_identitas='$no_identitas'"));
                            if(!empty($ValidasiKode)){
                                echo '<span class="text-danger">Kode Tersebut Sudah terdaftar, Gunakan Kode Lain</span>';
                            }else{
                                if(!empty($ValidasiNama)){
                                    echo '<span class="text-danger">Dokter Tersebut Sudah terdaftar</span>';
                                }else{
                                    if(!empty($ValidasiEmail)){
                                        echo '<span class="text-danger">Email Tersebut Sudah terdaftar</span>';
                                    }else{
                                        if(!empty($ValidasiSIP)){
                                            echo '<span class="text-danger">SIP Tersebut Sudah terdaftar</span>';
                                        }else{
                                            if(!empty($ValidasiIhs)){
                                                echo '<span class="text-danger">ID IHS Tersebut Sudah terdaftar</span>';
                                            }else{
                                                if(!empty($ValidasiNomorIdentitas)){
                                                    echo '<span class="text-danger">Nomor Identitas Tersebut Sudah terdaftar</span>';
                                                }else{
                                                    //Validasi Jumlah karakter
                                                    $LengthKode = strlen($kode);
                                                    $LengthKategoriIdentitas = strlen($kategori_identitas);
                                                    $LengthKontak = strlen($kontak);
                                                    if($LengthKode>20){
                                                        echo '<span class="text-danger">Kode maksimal memiliki 20 karakter</span>';
                                                    }else{
                                                        if($LengthKategoriIdentitas>20){
                                                            echo '<span class="text-danger">Kategori identitas maksimal memiliki 20 karakter</span>';
                                                        }else{
                                                            if($LengthKontak>20){
                                                                echo '<span class="text-danger">Kontak maksimal memiliki 20 karakter</span>';
                                                            }else{
                                                                if($ValidasiKarakterKontak==false){
                                                                    echo '<span class="text-danger">Kontak hanya boleh angka</span>';
                                                                }else{
                                                                    if(!empty($ValidasiKontak)){
                                                                        echo '<span class="text-danger">Kontak tersebut sudah terdaftar</span>';
                                                                    }else{
                                                                        if(empty($_FILES['foto']['name'])){
                                                                            //Apabila tidak ada foto langsung input saja
                                                                            $entry="INSERT INTO dokter (
                                                                                id_ihs_practitioner,
                                                                                kode,
                                                                                nama,
                                                                                kategori,
                                                                                kategori_identitas,
                                                                                no_identitas,
                                                                                alamat,
                                                                                kontak,
                                                                                email,
                                                                                SIP,
                                                                                status
                                                                            ) VALUES (
                                                                                '$id_ihs_practitioner',
                                                                                '$kode',
                                                                                '$nama',
                                                                                '$kategori',
                                                                                '$kategori_identitas',
                                                                                '$no_identitas',
                                                                                '$alamat',
                                                                                '$kontak',
                                                                                '$email',
                                                                                '$SIP',
                                                                                '$status'
                                                                            )";
                                                                            $Input=mysqli_query($Conn, $entry);
                                                                            if($Input){
                                                                                $JsonUrl="../../_Page/Log/Log.json";
                                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Dokter","Dokter",$SessionIdAkses,$JsonUrl);
                                                                                echo '<span class="text-info" id="NotifikasiTambahDokterBerhasil">Berhasil</span>';
                                                                            }else{
                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada saat Proses Input</span>';
                                                                            }
                                                                        }else{
                                                                            //nama foto
                                                                            $nama_gambar=$_FILES['foto']['name'];
                                                                            //ukuran foto
                                                                            $ukuran_gambar = $_FILES['foto']['size']; 
                                                                            //tipe
                                                                            $tipe_gambar = $_FILES['foto']['type']; 
                                                                            //sumber gambar
                                                                            $tmp_gambar = $_FILES['foto']['tmp_name'];
                                                                            $milliseconds = round(microtime(true) * 1000);
                                                                            // Mendapatkan ekstensi berdasarkan MIME type
                                                                            switch ($tipe_gambar) {
                                                                                case 'image/jpeg':
                                                                                    $ext = 'jpg'; // Jika file adalah JPEG
                                                                                    break;
                                                                                case 'image/png':
                                                                                    $ext = 'png'; // Jika file adalah PNG
                                                                                    break;
                                                                                case 'image/gif':
                                                                                    $ext = 'gif'; // Jika file adalah GIF
                                                                                    break;
                                                                                case 'image/webp':
                                                                                    $ext = 'webp'; // Jika file adalah WebP
                                                                                    break;
                                                                                default:
                                                                                    // Jika tipe tidak dikenal, set ekstensi default atau tangani error
                                                                                    $ext = 'jpg';
                                                                                    break;
                                                                            }
                                                                            $namabaru = "$milliseconds.$Ext";
                                                                            //Simpan Gambar di
                                                                            $path = "../../assets/images/Dokter/".$namabaru;
                                                                            //Validasi tipe gambar
                                                                            if($ukuran_gambar>2000000){
                                                                                echo '<span class="text-danger">File Foto Tidak Boleh Lebih Dari 2 mb</span>';
                                                                            }else{
                                                                                if($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/jpg" || $tipe_gambar == "image/gif" || $tipe_gambar == "image/png"){
                                                                                    //Upload file
                                                                                    if(move_uploaded_file($tmp_gambar, $path)){
                                                                                        $entry="INSERT INTO dokter (
                                                                                            id_ihs_practitioner,
                                                                                            kode,
                                                                                            nama,
                                                                                            kategori,
                                                                                            kategori_identitas,
                                                                                            no_identitas,
                                                                                            alamat,
                                                                                            kontak,
                                                                                            email,
                                                                                            SIP,
                                                                                            status,
                                                                                            foto
                                                                                        ) VALUES (
                                                                                            '$id_ihs_practitioner',
                                                                                            '$kode',
                                                                                            '$nama',
                                                                                            '$kategori',
                                                                                            '$kategori_identitas',
                                                                                            '$no_identitas',
                                                                                            '$alamat',
                                                                                            '$kontak',
                                                                                            '$email',
                                                                                            '$SIP',
                                                                                            '$status',
                                                                                            '$namabaru'
                                                                                        )";
                                                                                        $Input=mysqli_query($Conn, $entry);
                                                                                        if($Input){
                                                                                            $JsonUrl="../../_Page/Log/Log.json";
                                                                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Dokter","Dokter",$SessionIdAkses,$JsonUrl);
                                                                                            echo '<span class="text-info" id="NotifikasiTambahDokterBerhasil">Berhasil</span>';
                                                                                        }else{
                                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada saat Proses Input</span>';
                                                                                        }
                                                                                    }
                                                                                }else{
                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada saat Proses Upload</span>';
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
?>