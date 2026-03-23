//Fungsi Menampilkan Data Kelas
function TabelKelas() {
    var ProsesFilterKelas = $('#ProsesFilterKelas').serialize();

    // Loading
    $('#TabelKelas').html('<tr><td class="text-center" colspan="11"><small>Loading...</small></td></tr>');

    //Panggil Dengan Ajax
    $.ajax({
        type    : 'POST',
        url     : '_Page/KelasRuangan2/TabelKelas.php',
        data    : ProsesFilterKelas,
        success : function(data) {
            $('#TabelKelas').html(data);
        }
    });
}

//Ketika Halaman Selesai Inisialisasi
$(document).ready(function() {

    //Menampilkan Data Kelas Pertama Kali
    TabelKelas();

    //Pagging
    $(document).on('click', '#next_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page').val(next_page);
        TabelKelas(0);
    });
    $(document).on('click', '#prev_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page').val(next_page);
        TabelKelas(0);
    });

    //Ketika keyword_by diubah
    $('#KeywordBy').change(function(){
        var KeywordBy =$('#KeywordBy').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan2/FormFilter.php',
            data        : {KeywordBy: KeywordBy},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    //Submiit Filter Data
    $('#ProsesFilterKelas').submit(function(){
        $('#page').val("1");
        TabelKelas();
        $('#ModalFilter').modal('hide');
    });

    //Penanganan Click Label
    $('.label_kategori').on('click', function(){
        
        //Tangkap data id
        var kategori = $(this).data('id');
        
        //tempelkan nilai ke form
        $('#kategori_filter').val(kategori);

        //Reload Tabel
        TabelKelas(0);

       
    });

    // Form Tambah Kelas/Ruangan
    
    //Ketika kategori_tambah diubah
    $('#kategori_tambah').change(function(){
        var kategori_tambah =$('#kategori_tambah').val();

        //Loading
        $('#FormTambah').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan2/FormTambah.php',
            data        : {kategori_tambah: kategori_tambah},
            success     : function(data){
                $('#FormTambah').html(data);
            }
        });
    });

    // Delegasi event: ketika #kodekelas_tambah_option diubah
    $(document).on('change', '#kelas_tambah_option', function(){
        var kelas = $(this).val();

        // Loading
        $('#ruangan_tambah_option').html('Loading...');
        $.ajax({
            type    : 'POST',
            url     : '_Page/KelasRuangan2/FormSelectRuangan.php',
            data    : { kelas: kelas },
            success : function(data){
                $('#ruangan_tambah_option').html(data);
            }
        });
    });

    //Proses Tambah Ruang Rawat
    $('#ProsesTambah').submit(function(){
        $('#NotifikasiTambah').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesTambah')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan2/ProsesTambah.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiTambah').html(data);
                var NotifikasiTambahBerhasil=$('#NotifikasiTambahBerhasil').html();
                if(NotifikasiTambahBerhasil=="Berhasil"){

                    //Kosongkan Notifikasi
                    $('#NotifikasiTambah').html('');

                    //Reset Form
                    $("#ProsesTambah")[0].reset();

                    //Kosongkan Form Lanjutan
                    $('#FormTambah').html('');

                    //Reset Page
                    $('#page').val("1");

                    //Reset Form Filter
                    $("#ProsesFilterKelas")[0].reset();
                   
                    //Tutup Modal
                    $('#ModalTambah').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Tambah Ruang Kelas Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    TabelKelas();
                }
            }
        });
    });

    //Modal Edit
    $('#ModalEdit').on('show.bs.modal', function (e) {

        //Tangkap ID
        var id_ruang_rawat = $(e.relatedTarget).data('id');

        //Loading Form
        $('#FormEdit').html('Loading...');

        //Buka Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan2/FormEdit.php',
            data 	    :  {id_ruang_rawat: id_ruang_rawat},
            success     : function(data){
                $('#FormEdit').html(data);

                //Kosongkan Notifikasi
                $('#NotifikasiEdit').html('');
            }
        });
    });

    // Delegasi event: ketika #kodekelas_tambah_option diubah
    $(document).on('change', '#kelas_tambah_option_edit', function(){
        var kelas = $(this).val();

        // Loading
        $('#ruangan_tambah_option_edit').html('Loading...');
        $.ajax({
            type    : 'POST',
            url     : '_Page/KelasRuangan2/FormSelectRuangan.php',
            data    : { kelas: kelas },
            success : function(data){
                $('#ruangan_tambah_option_edit').html(data);
            }
        });
    });

    //Proses Edit Ruang Rawat
    $('#ProsesEdit').submit(function(){
        $('#NotifikasiEdit').html('Loading...');
        var form = $('#ProsesEdit')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan2/ProsesEdit.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiEdit').html(data);
                var NotifikasiEditBerhasil=$('#NotifikasiEditBerhasil').html();
                if(NotifikasiEditBerhasil=="Berhasil"){

                    //Kosongkan Notifikasi
                    $('#NotifikasiEdit').html('');
                   
                    //Tutup Modal
                    $('#ModalEdit').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Edit Data Ruang Kelas Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    TabelKelas();
                }
            }
        });
    });

    //Modal Hapus
    $('#ModalHapus').on('show.bs.modal', function (e) {

        //Tangkap ID
        var id_ruang_rawat = $(e.relatedTarget).data('id');

        //Loading Form
        $('#FormHapus').html('Loading...');

        //Buka Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan2/FormHapus.php',
            data 	    :  {id_ruang_rawat: id_ruang_rawat},
            success     : function(data){
                $('#FormHapus').html(data);

                //Kosongkan Notifikasi
                $('#NotifikasiHapus').html('');
            }
        });
    });

    //Proses Hapus Ruang Rawat
    $('#ProsesHapus').submit(function(){
        $('#NotifikasiHapus').html('Loading...');
        var form = $('#ProsesHapus')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan2/ProsesHapus.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapus').html(data);
                var NotifikasiHapusBerhasil=$('#NotifikasiHapusBerhasil').html();
                if(NotifikasiHapusBerhasil=="Berhasil"){

                    //Kosongkan Notifikasi
                    $('#NotifikasiHapus').html('');
                   
                    //Tutup Modal
                    $('#ModalHapus').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Hapus Data Ruang Kelas Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    TabelKelas();
                }
            }
        });
    });


});