<?php
    //Zona waktu dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Menangkap data
    if(empty($_POST['id_dokter'])){
        echo '<span class="text-danger">ID Dokter Tidak Boleh Kosong</span>';
    }else{
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
                                //Buat Variabel
                                $id_dokter=$_POST['id_dokter'];
                                //Validasi Kode
                                $kode=$_POST['kode'];
                                $kodeLama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kode');
                                if($kode!==$kodeLama){
                                    $ValidasiKode=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE kode='$kode'"));
                                }else{
                                    $ValidasiKode="";
                                }
                                //Validasi Nama
                                $nama=$_POST['nama'];
                                $namaLama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'nama');
                                if($nama!==$namaLama){
                                    $ValidasiNama=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE nama='$nama'"));
                                }else{
                                    $ValidasiNama="";
                                }
                                //Validasi Nomor Identitas
                                $no_identitas=$_POST['no_identitas'];
                                $no_identitasLama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'no_identitas');
                                if($no_identitas!==$no_identitasLama){
                                    $ValidasiNomorIdentitas=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE no_identitas='$no_identitas'"));
                                }else{
                                    $ValidasiNomorIdentitas="";
                                }
                                $kategori=$_POST['kategori'];
                                $kategori_identitas=$_POST['kategori_identitas'];
                                $status=$_POST['status'];
                                //Variabel Tidak Wajib
                                if(empty($_POST['email'])){
                                    $email="";
                                    $ValidasiEmail="";
                                }else{
                                    $email=$_POST['email'];
                                    $EmailLama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'email');
                                    if($email!==$EmailLama){
                                        $ValidasiEmail=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE email='$email'"));
                                    }else{
                                        $ValidasiEmail="";
                                    }
                                }
                                if(empty($_POST['SIP'])){
                                    $SIP="";
                                    $ValidasiSIP="";
                                }else{
                                    $SIP=$_POST['SIP'];
                                    $SIPLama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'SIP');
                                    if($SIP!==$SIPLama){
                                        $ValidasiSIP=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE SIP='$SIP'"));
                                    }else{
                                        $ValidasiSIP="";
                                    }
                                }
                                if(empty($_POST['kontak'])){
                                    $kontak="";
                                    $ValidasiKarakterKontak=true;
                                    $ValidasiKontak="";
                                }else{
                                    $kontak=$_POST['kontak'];
                                    $KontakLama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kontak');
                                    if($kontak!==$KontakLama){
                                        $ValidasiKontak=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE kontak='$kontak'"));
                                    }else{
                                        $ValidasiKontak="";
                                    }
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
                                if(empty($_POST['id_ihs_practitioner'])){
                                    $id_ihs_practitioner="";
                                    $ValidasiIhs="";
                                }else{
                                    $id_ihs_practitioner=$_POST['id_ihs_practitioner'];
                                    $id_ihs_practitionerLama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'id_ihs_practitioner');
                                    if($id_ihs_practitioner!==$id_ihs_practitionerLama){
                                        $ValidasiIhs=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM dokter WHERE id_ihs_practitioner='$id_ihs_practitioner'"));
                                    }else{
                                        $ValidasiIhs="";
                                    }
                                    
                                }
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
                                                                            //Membuka Data foto Lama
                                                                            $FotoLama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'foto');
                                                                            if(empty($_FILES['foto']['name'])){
                                                                                //Path Foto
                                                                                if(!empty($FotoLama)){
                                                                                    $path_foto_lama="../../assets/images/Dokter/" . $FotoLama;
                                                                                    if (!file_exists($path_foto_lama)) {
                                                                                        $ValidasiRename="File lama tidak ditemukan pada tempat yang seharusnya";
                                                                                    }else{
                                                                                        // Membaca MIME type dari file lama
                                                                                        $mime_type = mime_content_type($path_foto_lama); // Mendapatkan MIME type
                                                                                        $ext = ''; // Variabel untuk ekstensi file
                                                                                        // Tentukan ekstensi berdasarkan MIME type
                                                                                        switch ($mime_type) {
                                                                                            case 'image/jpeg':
                                                                                                $ext = 'jpg';
                                                                                                break;
                                                                                            case 'image/png':
                                                                                                $ext = 'png';
                                                                                                break;
                                                                                            case 'image/gif':
                                                                                                $ext = 'gif';
                                                                                                break;
                                                                                            case 'image/webp':
                                                                                                $ext = 'webp';
                                                                                                break;
                                                                                            default:
                                                                                                die("Jenis file tidak didukung: $mime_type");
                                                                                        }

                                                                                        // Membuat string acak 36 karakter (alphanumeric)
                                                                                        $random_string = bin2hex(random_bytes(18)); // 18 bytes menghasilkan 36 karakter
                                                                                        $namabaru = $random_string . '.' . $ext;

                                                                                        // Menyusun path baru untuk file
                                                                                        $path_foto_baru = "../../assets/images/Dokter/" . $namabaru;

                                                                                        // Mengganti nama file lama dengan nama baru
                                                                                        if (rename($path_foto_lama, $path_foto_baru)) {
                                                                                            $ValidasiRename="Berhasil";
                                                                                        }else{
                                                                                            $ValidasiRename="Gagal Mengubah Nama File Lama";
                                                                                        }
                                                                                    }
                                                                                }else{
                                                                                    $namabaru=$FotoLama;
                                                                                    $ValidasiRename="Berhasil";
                                                                                }
                                                                                if($ValidasiRename!=="Berhasil"){
                                                                                    echo '<span class="text-danger">'.$ValidasiRename.'</span>';
                                                                                }else{
                                                                                    //Ubah Nama Foto Lama
                                                                                    $UpdateDokter= mysqli_query($Conn,"UPDATE dokter SET 
                                                                                        id_ihs_practitioner='$id_ihs_practitioner',
                                                                                        kode='$kode',
                                                                                        nama='$nama',
                                                                                        kategori='$kategori',
                                                                                        kategori_identitas='$kategori_identitas',
                                                                                        no_identitas='$no_identitas',
                                                                                        alamat='$alamat',
                                                                                        kontak='$kontak',
                                                                                        email='$email',
                                                                                        SIP='$SIP',
                                                                                        status='$status',
                                                                                        foto='$namabaru'
                                                                                    WHERE id_dokter='$id_dokter'") or die(mysqli_error($Conn));
                                                                                    if($UpdateDokter){
                                                                                        $JsonUrl="../../_Page/Log/Log.json";
                                                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Dokter","Dokter",$SessionIdAkses,$JsonUrl);
                                                                                        echo '<span class="text-info" id="NotifikasiEditDokterBerhasil">Success</span>';
                                                                                    }else{
                                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada saat Proses update data dokter</span>';
                                                                                    }
                                                                                }
                                                                            }else{
                                                                                // Nama file
                                                                                $nama_gambar = $_FILES['foto']['name'];

                                                                                // Ukuran file
                                                                                $ukuran_gambar = $_FILES['foto']['size']; 

                                                                                // Tipe file (MIME type)
                                                                                $tipe_gambar = $_FILES['foto']['type']; 

                                                                                // Sumber file sementara
                                                                                $tmp_gambar = $_FILES['foto']['tmp_name'];

                                                                                // Mendapatkan waktu dalam milidetik
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
                                                                                // Membuat nama baru dengan menggunakan waktu (milliseconds) dan ekstensi yang benar
                                                                                $namabaru = "$milliseconds.$ext";
                                                                                $path = "../../assets/images/Dokter/" . $namabaru;
                                                                                //Validasi tipe gambar
                                                                                if($tipe_gambar == "image/jpeg" || $tipe_gambar == "image/jpg" || $tipe_gambar == "image/gif" || $tipe_gambar == "image/png"){
                                                                                    //Upload file
                                                                                    if(move_uploaded_file($tmp_gambar, $path)){
                                                                                        $UpdateDokter= mysqli_query($Conn,"UPDATE dokter SET 
                                                                                            id_ihs_practitioner='$id_ihs_practitioner',
                                                                                            kode='$kode',
                                                                                            nama='$nama',
                                                                                            kategori='$kategori',
                                                                                            kategori_identitas='$kategori_identitas',
                                                                                            no_identitas='$no_identitas',
                                                                                            alamat='$alamat',
                                                                                            kontak='$kontak',
                                                                                            email='$email',
                                                                                            SIP='$SIP',
                                                                                            status='$status',
                                                                                            foto='$namabaru'
                                                                                        WHERE id_dokter='$id_dokter'") or die(mysqli_error($Conn));
                                                                                        if($UpdateDokter){
                                                                                            if(!empty($FotoLama)){
                                                                                                $files="../../assets/images/Dokter/$FotoLama";
                                                                                                unlink($files);
                                                                                            }
                                                                                            $JsonUrl="../../_Page/Log/Log.json";
                                                                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Dokter","Dokter",$SessionIdAkses,$JsonUrl);
                                                                                            echo '<span class="text-info" id="NotifikasiEditDokterBerhasil">Success</span>';
                                                                                        }else{
                                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada saat Proses Update Data Dokter</span>';
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