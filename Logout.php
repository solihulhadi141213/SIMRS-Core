<?PHP
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/Connection.php";
    include "_Config/Session.php";
    include "_Config/SimrsFunction.php";
    //Catat Log Aktivitas
    $WaktuLog=date('Y-m-d H:i');
    $nama_log="Logout Berhasil";
    $kategori_log="Logout";
    $JsonUrl="_Page/Log/Log.json";
    $SimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,$nama_log,$kategori_log,$SessionIdAkses,$JsonUrl);
    if($SimpanLog!=="Berhasil"){
        echo $SimpanLog;
    }else{
        //Bersihkan Session
        session_destroy();
        header('Location:Login.php');
    }
?>