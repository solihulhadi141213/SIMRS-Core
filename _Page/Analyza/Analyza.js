function ShowData(){

    // Loading Table
    $('#TabelData').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Analyza/TabelAnalyza.php',
        success     : function(data){
            $('#TabelData').html(data);
        }
    });
}

$(document).ready(function() {

    // Menampilkan data pertama kali
    ShowData();

    // =================================================================
    // Proses Tambah Pengaturan
    // =================================================================
    $('#ProsesTambah').submit(function(e){

        e.preventDefault();
       
        /* Menangkap data dari form  */
        var ProsesTambah=$('#ProsesTambah').serialize();

        /* Loading Notification */
        $('#NotifikasiTambah').html('loading..');

        /* Kirim data dengan AJAX  */
        $.ajax({
            type    : 'POST',
            url     : '_Page/Analyza/ProsesTambah.php',
            dataType: 'json',
            data    : ProsesTambah,
            success: function(response) {
                var status  = response.status;
                var message = response.message;

                // Apabila berhasil
                if(status=='success'){
                    //Bersihkan notifikasi
                    $('#NotifikasiTambah').html('');

                    //reset form
                    $('#ProsesTambah')[0].reset();

                    // Kembalikan posisi layar ke atas
                    $('html, body').scrollTop(0);

                    //Tutup modal
                    $('#ModalTambah').modal('hide');

                    //Menampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Tambah Pengaturan Berhasil!',
                        'success'
                    )

                    //reload tabel
                    ShowData();

                }else{
                    $('#NotifikasiTambah').html('<div class="alert alert-danger"><small>'+message+'</small></div>');
                }
                
            }
        });
    });

    // Modal Detail
    $('#ModalDetail').on('show.bs.modal', function (e) {

        // Tangkap data-id
        var id_setting_analyza = $(e.relatedTarget).data('id');

        // Kosongkan Form Uji Koneksi
        $('#FormUjiKoneksi').html('');

        // Loading
        $('#FormDetail').html('Loading...');

        // Tampilkan Data Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Analyza/FormDetail.php',
            data        :  {id_setting_analyza: id_setting_analyza},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });

    // Ketika Proses Uji Koneksi Di Submit
    $('#ProsesUjiKoneksi').submit(function(e){

        e.preventDefault();
       
        /* Menangkap data dari form  */
        var ProsesUjiKoneksi=$('#ProsesUjiKoneksi').serialize();

        /* Loading Notification */
        $('#FormUjiKoneksi').html('loading..');

        /* Kirim data dengan AJAX  */
        $.ajax({
            type    : 'POST',
            url     : '_Page/Analyza/ProsesUjiKoneksi.php',
            data    : ProsesUjiKoneksi,
            success: function(response) {
                $('#FormUjiKoneksi').html(response);
                ShowData();
            }
        });

    });

    // Modal Edit
    $('#ModalEdit').on('show.bs.modal', function (e) {

        // Tangkap data-id
        var id_setting_analyza = $(e.relatedTarget).data('id');

        // Kosongkan Notifikasi Edit
        $('#NotifikasiEdit').html('');

        // Loading
        $('#FormEdit').html('Loading...');

        // Tampilkan Data Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Analyza/FormEdit.php',
            data        :  {id_setting_analyza: id_setting_analyza},
            success     : function(data){
                $('#FormEdit').html(data);
            }
        });
    });

    $('#ProsesEdit').submit(function(e){

        e.preventDefault();
       
        /* Menangkap data dari form  */
        var ProsesEdit=$('#ProsesEdit').serialize();

        /* Loading Notification */
        $('#NotifikasiEdit').html('loading..');

        /* Kirim data dengan AJAX  */
        $.ajax({
            type    : 'POST',
            url     : '_Page/Analyza/ProsesEdit.php',
            dataType: 'json',
            data    : ProsesEdit,
            success: function(response) {
                var status  = response.status;
                var message = response.message;

                // Apabila berhasil
                if(status=='success'){
                    //Bersihkan notifikasi
                    $('#NotifikasiEdit').html('');

                    //reset form
                    $('#ProsesEdit')[0].reset();

                    // Kembalikan posisi layar ke atas
                    $('html, body').scrollTop(0);

                    //Tutup modal
                    $('#ModalEdit').modal('hide');

                    //Menampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Edit Pengaturan Berhasil!',
                        'success'
                    )

                    //reload tabel
                    ShowData();

                }else{
                    $('#NotifikasiEdit').html('<div class="alert alert-danger"><small>'+message+'</small></div>');
                }
                
            }
        });
    });

    // Modal Hapus
    $('#ModalHapus').on('show.bs.modal', function (e) {

        // Tangkap data-id
        var id_setting_analyza = $(e.relatedTarget).data('id');

        // Kosongkan Notifikasi Hapus
        $('#NotifikasiHapus').html('');

        // Loading
        $('#FormHapus').html('Loading...');

        // Tampilkan Data Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Analyza/FormHapus.php',
            data        :  {id_setting_analyza: id_setting_analyza},
            success     : function(data){
                $('#FormHapus').html(data);
            }
        });
    });

    $('#ProsesHapus').submit(function(e){

        e.preventDefault();
       
        /* Menangkap data dari form  */
        var ProsesHapus=$('#ProsesHapus').serialize();

        /* Loading Notification */
        $('#NotifikasiHapus').html('loading..');

        /* Kirim data dengan AJAX  */
        $.ajax({
            type    : 'POST',
            url     : '_Page/Analyza/ProsesHapus.php',
            dataType: 'json',
            data    : ProsesHapus,
            success: function(response) {
                var status  = response.status;
                var message = response.message;

                // Apabila berhasil
                if(status=='success'){
                    //Bersihkan notifikasi
                    $('#NotifikasiHapus').html('');

                    //reset form
                    $('#ProsesHapus')[0].reset();

                    // Kembalikan posisi layar ke atas
                    $('html, body').scrollTop(0);

                    //Tutup modal
                    $('#ModalHapus').modal('hide');

                    //Menampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Hapus Pengaturan Berhasil!',
                        'success'
                    )

                    //reload tabel
                    ShowData();

                }else{
                    $('#NotifikasiHapus').html('<div class="alert alert-danger"><small>'+message+'</small></div>');
                }
                
            }
        });
    });


});