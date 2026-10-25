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

        $NotifikasiProfile = [
            'Foto Profile Berhasil Diperbarui' => 'Foto profile berhasil diperbarui.',
            'Profile Berhasil Diperbarui' => 'Email dan kontak berhasil diperbarui.',
            'Password Berhasil Diperbarui' => 'Password berhasil diperbarui.'
        ];

        if (isset($NotifikasiProfile[$NotifikasiSwal])) {
            echo '
                Swal.fire({
                    title            : "Berhasil",
                    text             : '.json_encode($NotifikasiProfile[$NotifikasiSwal]).',
                    icon             : "success",
                    confirmButtonText: "Tutup"
                })
            ';
        }
        
        unset($_SESSION['NotifikasiSwal']);
    }
?>
</script>