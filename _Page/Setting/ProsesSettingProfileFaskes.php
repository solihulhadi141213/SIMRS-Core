<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['nama_faskes'])){
        echo '<span class="text-danger">Nama Faskes Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kode_faskes'])){
            echo '<span class="text-danger">Kode Faskes Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['alamat_faskes'])){
                echo '<span class="text-danger">Alamat Faskes Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['kontak_faskes'])){
                    echo '<span class="text-danger">Kontak Faskes Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['email_faskes'])){
                        echo '<span class="text-danger">Email Faskes Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['tahun_berdiri'])){
                            echo '<span class="text-danger">Tahun Berdiri Faskes Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['direktur_faskes'])){
                                echo '<span class="text-danger">Mnajer/Direktur Faskes Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['visi_faskes'])){
                                    echo '<span class="text-danger">Visi Faskes Tidak Boleh Kosong</span>';
                                }else{
                                    if(empty($_POST['misi_faskes'])){
                                        echo '<span class="text-danger">Misi Faskes Tidak Boleh Kosong</span>';
                                    }else{
                                        if(empty($_POST['link_website'])){
                                            echo '<span class="text-danger">Link Website Faskes Tidak Boleh Kosong</span>';
                                        }else{
                                            if(empty($_POST['base_url'])){
                                                echo '<span class="text-danger">Base URL Aplikasi Tidak Boleh Kosong</span>';
                                            }else{  
                                                if(empty($_POST['judul_tab'])){
                                                    echo '<span class="text-danger">Judul Tab Tidak Boleh Kosong</span>';
                                                }else{
                                                    if(empty($_POST['judul_halaman'])){
                                                        echo '<span class="text-danger">Judul Halaman Tidak Boleh Kosong</span>';
                                                    }else{
                                                        if(empty($_POST['warna'])){
                                                            echo '<span class="text-danger">Warna Tema Aplikasi Tidak Boleh Kosong</span>';
                                                        }else{
                                                            //Bentuk variabel
                                                            $nama_faskes=$_POST['nama_faskes'];
                                                            $JmlKarNamaFaskes = strlen($nama_faskes);
                                                            $kode_faskes=$_POST['kode_faskes'];
                                                            $JmlKarKodeFaskes = strlen($kode_faskes);
                                                            $alamat_faskes=$_POST['alamat_faskes'];
                                                            $kontak_faskes=$_POST['kontak_faskes'];
                                                            $JmlKarKontakFaskes = strlen($kontak_faskes);
                                                            $email_faskes=$_POST['email_faskes'];
                                                            $tahun_berdiri=$_POST['tahun_berdiri'];
                                                            $JmlKarTahunBerdiri= strlen($tahun_berdiri);
                                                            $direktur_faskes=$_POST['direktur_faskes'];
                                                            $visi_faskes=$_POST['visi_faskes'];
                                                            $misi_faskes=$_POST['misi_faskes'];
                                                            $link_website=$_POST['link_website'];
                                                            $base_url=$_POST['base_url'];
                                                            $judul_tab=$_POST['judul_tab'];
                                                            $JmlKarJudulTab= strlen($judul_tab);
                                                            $judul_halaman=$_POST['judul_halaman'];
                                                            $JmlKarJudulHalaman= strlen($judul_halaman);
                                                            $warna=$_POST['warna'];
                                                            $JmlKarWarna= strlen($warna);
                                                            //Menangkap Variabel Yang tidak wajib
                                                            if(empty($_POST['id_profile'])){
                                                                $id_profile="";
                                                            }else{
                                                                $id_profile=$_POST['id_profile'];
                                                            }
                                                            if(empty($_POST['status'])){
                                                                $status="Non-Active";
                                                            }else{
                                                                $status=$_POST['status'];
                                                            }
                                                            //Validasi Jumlah Karakter
                                                            if($JmlKarNamaFaskes>50){
                                                                echo '<span class="text-danger">Nama Faskes Tidak Boleh Lebih Dari 50 karakter</span>';
                                                            }else{
                                                                if($JmlKarKodeFaskes>20){
                                                                    echo '<span class="text-danger">Kode Faskes Tidak Boleh Lebih Dari 20 karakter</span>';
                                                                }else{
                                                                    if($JmlKarKontakFaskes>20){
                                                                        echo '<span class="text-danger">Nomor Kontak Faskes Tidak Boleh Lebih Dari 20 karakter</span>';
                                                                    }else{
                                                                        if($JmlKarTahunBerdiri>10){
                                                                            echo '<span class="text-danger">Tahun Berdiri Tidak Valid</span>';
                                                                        }else{
                                                                            if($JmlKarTahunBerdiri>10){
                                                                                echo '<span class="text-danger">Tahun Berdiri Tidak Valid</span>';
                                                                            }else{
                                                                                if($JmlKarJudulTab>20){
                                                                                    echo '<span class="text-danger">Judul Tab Tidak Boleh Lebih Dari 20 Karakter</span>';
                                                                                }else{
                                                                                    if($JmlKarJudulHalaman>20){
                                                                                        echo '<span class="text-danger">Nama Aplikasi Tidak Boleh Lebih Dari 20 Karakter</span>';
                                                                                    }else{
                                                                                        if($JmlKarWarna>20){
                                                                                            echo '<span class="text-danger">Kode Warna Aplikasi Tidak Boleh Lebih Dari 20 Karakter</span>';
                                                                                        }else{
                                                                                            //Validasi Format
                                                                                            if(!preg_match("/^[0-9]*$/", $kontak_faskes)){
                                                                                                echo '<span class="text-danger">Kontak Faskes Hanya Boleh Angka</span>';
                                                                                            }else{
                                                                                                if(!preg_match("/^[0-9]*$/", $tahun_berdiri)){
                                                                                                    echo '<span class="text-danger">Tahun Berdiri Hanya Boleh Angka</span>';
                                                                                                }else{
                                                                                                    //Menentukan Update Atau Insert
                                                                                                    if(empty($id_profile)){
                                                                                                        //Validasi Duplikat Data
                                                                                                        $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_profile WHERE nama_faskes='$nama_faskes' AND kode_faskes='$kode_faskes'"));
                                                                                                        if(!empty($ValidasiDuplikat)){
                                                                                                            echo '<span class="text-danger">Setting Faskes Tersebut Sudah Ada</span>';
                                                                                                        }else{
                                                                                                            //File logo dan favicon tidak boleh kosong
                                                                                                            if(empty($_FILES['favicon']['name'])){
                                                                                                                echo '<span class="text-danger">File Favicon Tidak Boleh Kosong!</span>';
                                                                                                            }else{
                                                                                                                if(empty($_FILES['logo']['name'])){
                                                                                                                    echo '<span class="text-danger">File Logo Tidak Boleh Kosong!</span>';
                                                                                                                }else{
                                                                                                                    //Favicon
                                                                                                                    $nama_gambar_favicon=$_FILES['favicon']['name'];
                                                                                                                    $ukuran_gambar_favicon = $_FILES['favicon']['size']; 
                                                                                                                    $tipe_gambar_favicon = $_FILES['favicon']['type']; 
                                                                                                                    $tmp_gambar_favicon = $_FILES['favicon']['tmp_name'];
                                                                                                                    //Logo
                                                                                                                    $nama_gambar_logo=$_FILES['logo']['name'];
                                                                                                                    $ukuran_gambar_logo = $_FILES['logo']['size']; 
                                                                                                                    $tipe_gambar_logo = $_FILES['logo']['type']; 
                                                                                                                    $tmp_gambar_logo = $_FILES['logo']['tmp_name'];
                                                                                                                    //File logo dan favicon Hanya Boleh JPG, JPEG, PNG
                                                                                                                    if($tipe_gambar_favicon !== "image/jpeg" && $tipe_gambar_favicon !== "image/jpg" &&  $tipe_gambar_favicon !== "image/png"){
                                                                                                                        echo '<span class="text-danger">Tipe File Favicon Hanya Boleh JPEG, JPG atau PNG!</span>';
                                                                                                                    }else{
                                                                                                                        if($tipe_gambar_logo !== "image/jpeg" && $tipe_gambar_logo !== "image/jpg" &&  $tipe_gambar_logo !== "image/png"){
                                                                                                                            echo '<span class="text-danger">Tipe File Logo Hanya Boleh JPEG, JPG atau PNG! ('.$tmp_gambar_logo.')</span>';
                                                                                                                        }else{
                                                                                                                            //File logo dan favicon Tidak boleh lebih dari 1 mb
                                                                                                                            if($ukuran_gambar_favicon>1000000){
                                                                                                                                echo '<span class="text-danger">Ukuran file favicon tidak boleh lebih dari 1 mb!</span>';
                                                                                                                            }else{
                                                                                                                                if($ukuran_gambar_logo>1000000){
                                                                                                                                    echo '<span class="text-danger">Ukuran file logo tidak boleh lebih dari 1 mb!</span>';
                                                                                                                                }else{
                                                                                                                                    //Membuat Nama Gambar baru
                                                                                                                                    $milliseconds = round(microtime(true) * 1000);
                                                                                                                                    $Pecah1 = explode("." , $nama_gambar_favicon);
                                                                                                                                    $Pecah2 = explode("." , $nama_gambar_logo);
                                                                                                                                    $BiasanyaNama1=$Pecah1[0];
                                                                                                                                    $BiasanyaNama2=$Pecah2[0];
                                                                                                                                    $Ext1=$Pecah1[1];
                                                                                                                                    $Ext2=$Pecah2[1];
                                                                                                                                    $NamaFaviconBaru = "Favicon-$milliseconds.$Ext1";
                                                                                                                                    $NamaLogoBaru = "Logo-$milliseconds.$Ext2";
                                                                                                                                    //path
                                                                                                                                    $path_favicon = "../../assets/images/".$NamaFaviconBaru;
                                                                                                                                    $path_logo = "../../assets/images/".$NamaLogoBaru;
                                                                                                                                    //Proses Upload gambar_logo
                                                                                                                                    if(move_uploaded_file($tmp_gambar_logo, $path_logo)){
                                                                                                                                        if(move_uploaded_file($tmp_gambar_favicon, $path_favicon)){
                                                                                                                                            //Insert Pengaturan Profile Faskes
                                                                                                                                            $entry="INSERT INTO setting_profile (
                                                                                                                                                kode_faskes,
                                                                                                                                                nama_faskes,
                                                                                                                                                alamat_faskes,
                                                                                                                                                kontak_faskes,
                                                                                                                                                email_faskes,
                                                                                                                                                link_website,
                                                                                                                                                base_url,
                                                                                                                                                tahun_berdiri,
                                                                                                                                                direktur_faskes,
                                                                                                                                                visi_faskes,
                                                                                                                                                misi_faskes,
                                                                                                                                                judul_tab,
                                                                                                                                                judul_halaman,
                                                                                                                                                warna,
                                                                                                                                                favicon,
                                                                                                                                                logo,
                                                                                                                                                status
                                                                                                                                            ) VALUES (
                                                                                                                                                '$kode_faskes',
                                                                                                                                                '$nama_faskes',
                                                                                                                                                '$alamat_faskes',
                                                                                                                                                '$kontak_faskes',
                                                                                                                                                '$email_faskes',
                                                                                                                                                '$link_website',
                                                                                                                                                '$base_url',
                                                                                                                                                '$tahun_berdiri',
                                                                                                                                                '$direktur_faskes',
                                                                                                                                                '$visi_faskes',
                                                                                                                                                '$misi_faskes',
                                                                                                                                                '$judul_tab',
                                                                                                                                                '$judul_halaman',
                                                                                                                                                '$warna',
                                                                                                                                                '$NamaFaviconBaru',
                                                                                                                                                '$NamaLogoBaru',
                                                                                                                                                '$status'
                                                                                                                                            )";
                                                                                                                                            $Input=mysqli_query($Conn, $entry);
                                                                                                                                            if($Input){
                                                                                                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Insert Setting Profil Faskes","Setting",$SessionIdAkses,$LogJsonFile);
                                                                                                                                                if($MenyimpanLog=="Berhasil"){
                                                                                                                                                    //Apabila Status Active maka Non Aktifkan Yang Lainnya
                                                                                                                                                    if($status=="Active"){
                                                                                                                                                        $NonAktifkan= mysqli_query($Conn,"UPDATE setting_profile SET status='Non-Active' WHERE kode_faskes!='$kode_faskes'") or die(mysqli_error($Conn)); 
                                                                                                                                                    }
                                                                                                                                                    $_SESSION['NotifikasiSwal']="Simpan Setting Berhasil";
                                                                                                                                                    echo '<span class="text-success" id="NotifikasiSimpanSettingProfileFaskesBerhasil">Success</span>';
                                                                                                                                                }else{
                                                                                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                                                                                }
                                                                                                                                            }else{
                                                                                                                                                echo '<span class="text-danger">Simpan Setting Gagal!</span>';
                                                                                                                                            }
                                                                                                                                        }else{
                                                                                                                                            echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan upload file favicon!</span>';
                                                                                                                                        }
                                                                                                                                    }else{
                                                                                                                                        echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan upload file logo!</span>';
                                                                                                                                    }
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    }else{
                                                                                                        //Kondisi Ketika File Ada
                                                                                                        if(!empty($_FILES['favicon']['name'])){
                                                                                                            $nama_gambar_favicon=$_FILES['favicon']['name'];
                                                                                                            $ukuran_gambar_favicon = $_FILES['favicon']['size']; 
                                                                                                            $tipe_gambar_favicon = $_FILES['favicon']['type']; 
                                                                                                            $tmp_gambar_favicon = $_FILES['favicon']['tmp_name'];
                                                                                                            //File favicon Hanya Boleh JPG, JPEG, PNG
                                                                                                            if($tipe_gambar_favicon !== "image/jpeg" && $tipe_gambar_favicon !== "image/jpg" &&  $tipe_gambar_favicon !== "image/png"){
                                                                                                                $ValidasiFavicon="Tipe File Favicon Hanya Boleh JPEG, JPG atau PNG!";
                                                                                                            }else{
                                                                                                                //File favicon Tidak boleh lebih dari 1 mb
                                                                                                                if($ukuran_gambar_favicon>1000000){
                                                                                                                    $ValidasiFavicon="Ukuran file favicon tidak boleh lebih dari 1 mb!";
                                                                                                                }else{
                                                                                                                    //Membuat Nama Gambar baru
                                                                                                                    $milliseconds = round(microtime(true) * 1000);
                                                                                                                    $Pecah1 = explode("." , $nama_gambar_favicon);
                                                                                                                    $BiasanyaNama1=$Pecah1[0];
                                                                                                                    $Ext1=$Pecah1[1];
                                                                                                                    $NamaFaviconBaru = "Favicon-$milliseconds.$Ext1";
                                                                                                                    //path
                                                                                                                    $path_favicon = "../../assets/images/".$NamaFaviconBaru;
                                                                                                                    if(move_uploaded_file($tmp_gambar_favicon, $path_favicon)){
                                                                                                                        //Hapus File Lama
                                                                                                                        $FileLama=getDataDetail($Conn,'setting_profile','id_profile',$id_profile,'favicon');
                                                                                                                        $UrlFileLama = "../../assets/images/".$FileLama;
                                                                                                                        unlink($UrlFileLama);
                                                                                                                        $ValidasiFavicon="Valid";
                                                                                                                    }else{
                                                                                                                        $ValidasiFavicon="Terjadi Kesalahan Pada Saat Upload File Vaficon";
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }else{
                                                                                                            $ValidasiFavicon="Valid";
                                                                                                            $NamaFaviconBaru=getDataDetail($Conn,'setting_profile','id_profile',$id_profile,'favicon');
                                                                                                        }
                                                                                                        if(!empty($_FILES['logo']['name'])){
                                                                                                            $nama_gambar_logo=$_FILES['logo']['name'];
                                                                                                            $ukuran_gambar_logo = $_FILES['logo']['size']; 
                                                                                                            $tipe_gambar_logo= $_FILES['logo']['type']; 
                                                                                                            $tmp_gambar_logo= $_FILES['logo']['tmp_name'];
                                                                                                            //File logo Hanya Boleh JPG, JPEG, PNG
                                                                                                            if($tipe_gambar_logo !== "image/jpeg" && $tipe_gambar_logo !== "image/jpg" &&  $tipe_gambar_logo !== "image/png"){
                                                                                                                $ValidasiLogo="Tipe File Logo Hanya Boleh JPEG, JPG atau PNG!";
                                                                                                            }else{
                                                                                                                //File Logo Tidak boleh lebih dari 1 mb
                                                                                                                if($ukuran_gambar_logo>1000000){
                                                                                                                    $ValidasiLogo="Ukuran file Logo tidak boleh lebih dari 1 mb!";
                                                                                                                }else{
                                                                                                                    //Membuat Nama Logo baru
                                                                                                                    $milliseconds = round(microtime(true) * 1000);
                                                                                                                    $Pecah2 = explode("." , $nama_gambar_logo);
                                                                                                                    $BiasanyaNama2=$Pecah2[0];
                                                                                                                    $Ext2=$Pecah2[1];
                                                                                                                    $NamaLogoBaru = "Logo-$milliseconds.$Ext2";
                                                                                                                    //path
                                                                                                                    $path_logo= "../../assets/images/".$NamaLogoBaru;
                                                                                                                    if(move_uploaded_file($tmp_gambar_logo, $path_logo)){
                                                                                                                        $FileLama=getDataDetail($Conn,'setting_profile','id_profile',$id_profile,'logo');
                                                                                                                        $UrlFileLama = "../../assets/images/".$FileLama;
                                                                                                                        unlink($UrlFileLama);
                                                                                                                        $ValidasiLogo="Valid";
                                                                                                                    }else{
                                                                                                                        $ValidasiLogo="Terjadi Kesalahan Pada Saat Upload File Logo";
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }else{
                                                                                                            $ValidasiLogo="Valid";
                                                                                                            $NamaLogoBaru=getDataDetail($Conn,'setting_profile','id_profile',$id_profile,'logo');
                                                                                                        }
                                                                                                        //Apabila Penanganan File Valid
                                                                                                        if($ValidasiFavicon!=="Valid"){
                                                                                                            echo '<span class="text-danger">'.$ValidasiFavicon.'</span>';
                                                                                                        }else{
                                                                                                            if($ValidasiLogo!=="Valid"){
                                                                                                                echo '<span class="text-danger">'.$ValidasiLogo.'</span>';
                                                                                                            }else{
                                                                                                                $UpdateSetting= mysqli_query($Conn,"UPDATE setting_profile SET 
                                                                                                                    kode_faskes='$kode_faskes',
                                                                                                                    nama_faskes='$nama_faskes',
                                                                                                                    alamat_faskes='$alamat_faskes',
                                                                                                                    kontak_faskes='$kontak_faskes',
                                                                                                                    email_faskes='$email_faskes',
                                                                                                                    link_website='$link_website',
                                                                                                                    base_url='$base_url',
                                                                                                                    tahun_berdiri='$tahun_berdiri',
                                                                                                                    direktur_faskes='$direktur_faskes',
                                                                                                                    visi_faskes='$visi_faskes',
                                                                                                                    misi_faskes='$misi_faskes',
                                                                                                                    judul_tab='$judul_tab',
                                                                                                                    judul_halaman='$judul_halaman',
                                                                                                                    warna='$warna',
                                                                                                                    favicon='$NamaFaviconBaru',
                                                                                                                    logo='$NamaLogoBaru',
                                                                                                                    status='$status'
                                                                                                                WHERE id_profile='$id_profile'") or die(mysqli_error($Conn)); 
                                                                                                                if($UpdateSetting){
                                                                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Setting Profil Faskes","Setting",$SessionIdAkses,$LogJsonFile);
                                                                                                                    if($MenyimpanLog=="Berhasil"){
                                                                                                                        //Apabila Status Active maka Non Aktifkan Yang Lainnya
                                                                                                                        if($status=="Active"){
                                                                                                                            $NonAktifkan= mysqli_query($Conn,"UPDATE setting_profile SET status='Non-Active' WHERE id_profile!='$id_profile'") or die(mysqli_error($Conn)); 
                                                                                                                        }
                                                                                                                        $_SESSION['NotifikasiSwal']="Simpan Setting Berhasil";
                                                                                                                        echo '<span class="text-success" id="NotifikasiSimpanSettingProfileFaskesBerhasil">Success</span>';
                                                                                                                    }else{
                                                                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                                                    }
                                                                                                                }else{
                                                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Setting Profile Faskes!</span>';
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
        }
    }
?>