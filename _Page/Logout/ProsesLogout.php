<?PHP
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
   
    //Bersihkan Session
    session_destroy();
    header('Location:../../login.php');
?>