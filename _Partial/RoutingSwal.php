<script>
<?php
    if(!empty($_SESSION['NotifikasiSwal'])){
        $NotifikasiSwal=$_SESSION['NotifikasiSwal'];
        
        if($NotifikasiSwal=="Login Berhasil"){ 
            echo '
                Swal.fire({
                    title            : "Selamat Datang!",
                    text             : "Login Berhasil",
                    icon             : "success",
                    confirmButtonText: "Tutup"
                })
            ';
        }
        
        unset($_SESSION['NotifikasiSwal']);
    }
?>
</script>