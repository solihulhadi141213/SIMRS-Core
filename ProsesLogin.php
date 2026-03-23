<?php
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/Connection.php";
    //TANGKAP VARIABEL DARI FORMULIR LOGIN.PHP
    $username=$_POST["username"];
    $password=$_POST["password"];
    $password=md5($password);
    //QUERY MEMANGGIL DATA DARI DATABASE
    $QueryAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE username='$username' AND password='$password'")or die(mysqli_error($conn));
    $DataAkses = mysqli_fetch_array($QueryAkses);
    $MyIdAkses=$DataAkses["id_akses"];
    $MyUsername=$DataAkses["username"];
    $MyLevel=$DataAkses["akses"];
    $nama=$DataAkses["nama"];

    //CEK APAKAH USERNAME ADA DALAM DATABASE
    if(!empty($DataAkses["id_akses"])){
        //Catat Log Aktivitas
        $WaktuLog=date('Y-m-d H:i');
        $SessionNama=$nama;
        $nama_log="Login Berhasil";
        $kategori_log="Login";
        $SessionIdAkses=$MyIdAkses;
        include "_Config/Log.php";
        //Jika valid-langsung masuk SESSION
        session_start();
        $_SESSION ["id_akses"]= $MyIdAkses;
        header('Location:index.php');
    }else{
        header('Location:Login.php?Notifikasi=error');
    }	
?>