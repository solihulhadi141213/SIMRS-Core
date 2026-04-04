<?PHP
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $HapusAksesToken = mysqli_query($Conn, "DELETE FROM akses_login WHERE id_akses='$SessionIdAkses' AND login_token='$SessionToken'") or die(mysqli_error($Conn));
    if($HapusAksesToken){
        session_destroy();   
        session_unset();
        header('Location:../../login.php');
    }else{
        session_destroy();   
        session_unset();
        header('Location:../../login.php');
    }
?>