<?php if($NotifikasiSwal=="Tambah SO Berhasil"){ ?>
    <script>
        Swal.fire({
            title: 'Mantap!',
            text: 'Tambah Struktur Organisasi Berhasil',
            icon: 'success',
            confirmButtonText: 'Tutup'
        })
    </script>
<?php } ?>
<?php if($NotifikasiSwal=="Edit SO Berhasil"){ ?>
    <script>
        Swal.fire({
            title: 'Mantap!',
            text: 'Edit Struktur Organisasi Berhasil',
            icon: 'success',
            confirmButtonText: 'Tutup'
        })
    </script>
<?php } ?>
<?php if($NotifikasiSwal=="Hapus SO Berhasil"){ ?>
    <script>
        Swal.fire({
            title: 'Mantap!',
            text: 'Hapus Struktur Organisasi Berhasil',
            icon: 'success',
            confirmButtonText: 'Tutup'
        })
    </script>
<?php } ?>