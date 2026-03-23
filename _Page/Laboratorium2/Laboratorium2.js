// DATA LABORATORIUM
function ShowLaboratorium(){

    var ProsesFilter = $('#ProsesFilter').serialize();
    var $container  = $('#ListLaboratorium');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url: '_Page/Laboratorium2/TabelLaboratorium2.php',
        data: ProsesFilter,
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({opacity: 0.3}, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Tangkap Halaman dan Posisi
            let currentPage = $('#page_lab').val();
            let totalPages = $('#total_page').val();

            // Preview Button
            if (currentPage <= 1) {
                $('#prev_rad').prop('disabled', true).addClass('disabled');
            } else {
                $('#prev_rad').prop('disabled', false).removeClass('disabled');
            }

            // Next button
            if (currentPage >= totalPages) {
                $('#next_rad').prop('disabled', true).addClass('disabled');
            } else {
                $('#next_rad').prop('disabled', false).removeClass('disabled');
            }
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

// DETAIL
function ShowDetail(id_laboratorium){

    var $container  = $('#FormDetail');

    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $container.fadeOut(150, function(){

        $.ajax({
            type: 'POST',
            url: '_Page/Laboratorium2/FormDetail.php',
            data: {id_laboratorium: id_laboratorium},
            success: function (data) {
                $container.html(data).fadeIn(200, function(){
                    $container.css('min-height', '');
                });
            }
        });

    });
}

// HAPUS
function ShowHapus(id_laboratorium){

    var $container  = $('#FormHapus');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url: '_Page/Laboratorium2/FormHapus.php',
        data: {id_laboratorium: id_laboratorium},
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({opacity: 0.3}, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

// KUNJUNGAN
function ShowDataKunjungan(){
    var FilterKunjunganPasien = $('#FilterKunjunganPasien').serialize();
    var $container  = $('#ListKunjungan');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url: '_Page/Laboratorium2/TabelKunjungan.php',
        data: FilterKunjunganPasien,
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({
                opacity: 0.3
            }, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

// DIAGNOSA
function ShowDiagnosa(){
    var FilterDiagnosa = $('#FilterDiagnosa').serialize();
    var $container  = $('#TabelDiagnosa');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url: '_Page/Laboratorium2/TabelDiagnosa.php',
        data: FilterDiagnosa,
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({
                opacity: 0.3
            }, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

function ShowDataPemeriksaan(){

    var ProsesCariPermintaanPemeriksaan = $('#ProsesCariPermintaanPemeriksaan').serialize();
    var $container  = $('#ListDataPemeriksaan');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url : '_Page/Laboratorium2/TabelPemeriksaan.php',
        data: ProsesCariPermintaanPemeriksaan,
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({
                opacity: 0.3
            }, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}



$(document).ready(function() {
    // Inisialisasi Data Pertama Kali
    $('.data_laboratorium').show();
    $('.tambah_laboratorium').hide();
    $('.detail_laboratorium').hide();
    ShowLaboratorium();

    // Menampilkan Pilih Kunjungan
    // $('#ModalKunjunganPasien').modal('show');
    // ShowDataKunjungan();

    //Pagging Laboratorium
    $(document).on('click', '#prev_rad', function() {
        var page_now = parseInt($('#page_lab').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_lab').val(next_page);
        ShowLaboratorium(0);
    });
    $(document).on('click', '#next_rad', function() {
        var page_now = parseInt($('#page_lab').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_lab').val(next_page);
        ShowLaboratorium(0);
    });

    $('#ProsesFilter').submit(function(){
        $('#page_lab').val(1);
        ShowLaboratorium();

        $('#ModalFilter').modal('hide');
    });
    
    //-------------------------------------------------------------
    // FORM TAMBAH LABORATORIUM
    //-------------------------------------------------------------
    $('.form_tambah_laboratorium').click(function(){
        $('.data_laboratorium').hide();
        $('.tambah_laboratorium').show();
        $('.detail_laboratorium').hide();

        $('.tambah_laboratorium').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium2/FormTambah.php',
            success     : function(data){
                $('.tambah_laboratorium').html(data);
            }
        });
    });

    $(document).on('click', '.kembali_ke_data_laboratorium', function() {
        $('.data_laboratorium').show();
        $('.tambah_laboratorium').hide();
        $('.detail_laboratorium').hide();
    });

    // Event Ketika Tombol 'PilihKunjunganPasien' di click
    $(document).on('click', '#PilihKunjunganPasien', function() {
        $('#ModalKunjunganPasien').modal('show');

        // Load Data Kunjungan
        ShowDataKunjungan();
    });

    // Event Ketika Pencarian Dilakukan
    $('#FilterKunjunganPasien').submit(function(e){
        $('#page_kunjungan').val(1);
        ShowDataKunjungan();
    });

    //Pagging Kunjungan
    $(document).on('click', '#btn_prev_kunjungan', function() {
        var page_now_kunjungan = parseInt($('#page_kunjungan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_kunjungan = page_now_kunjungan - 1;
        $('#page_kunjungan').val(next_page_kunjungan);
        ShowDataKunjungan(0);
    });
    $(document).on('click', '#btn_next_kunjungan', function() {
        var page_now_kunjungan = parseInt($('#page_kunjungan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_kunjungan = page_now_kunjungan + 1;
        $('#page_kunjungan').val(next_page_kunjungan);
        ShowDataKunjungan(0);
    });

    // Ketika pilih_kunjungan di click
    $(document).on('click', '.pilih_kunjungan', function() {

          // Buat Variabel Dari Data Yang Ditangkap
        var id_encounter  = $(this).data('id_encounter');
        var id_ihs        = $(this).data('id_ihs');
        var id_kunjungan  = $(this).data('id_kunjungan');
        var id_pasien     = $(this).data('id_pasien');
        var nama          = $(this).data('nama');
        var tanggal_lahir = $(this).data('tanggal_lahir');
        var gender        = $(this).data('gender');
        var tujuan        = $(this).data('tujuan');
        var pembayaran    = $(this).data('pembayaran');
        var unit          = $(this).data('unit');

        // Tempelkan Data Ke Form
        $('#id_encounter').val(id_encounter);
        $('#ihs_pasien').val(id_ihs);
        $('#id_kunjungan').val(id_kunjungan);
        $('#id_pasien').val(id_pasien);
        $('#nama').val(nama);
        $('#tanggal_lahir').val(tanggal_lahir);
        $('#gender').val(gender);
        $('#tujuan').val(tujuan);
        $('#pembayaran').val(pembayaran);
        $('#unit').val(unit);

       // Tutup Modal
       $('#ModalKunjunganPasien').modal('hide');
    });

    // Check Box
    $(document).on('click', '.row-pemeriksaan', function(e){
        // Cegah double toggle kalau klik langsung checkbox
        if ($(e.target).is('input')) return;

        let target = $(this).data('target');
        let checkbox = $('#' + target);

        checkbox.prop('checked', !checkbox.prop('checked'));
    });

    // Event Ketika Tombol 'CariDiagnosa' di click
    $(document).on('click', '#CariDiagnosa', function() {
        $('#ModalDiagnosa').modal('show');
        // Load Data Kunjungan
        ShowDiagnosa();
    });

    // Event Ketika Pencarian Dilakukan
    $('#FilterDiagnosa').submit(function(e){
        $('#page_diagnosa').val(1);
        ShowDiagnosa();
    });

    //Pagging Kunjungan
    $(document).on('click', '#btn_prev_diagnosa', function() {
        var page_now_diagnosa = parseInt($('#page_diagnosa').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_diagnosa = page_now_diagnosa - 1;
        $('#page_diagnosa').val(next_page_diagnosa);
        ShowDiagnosa(0);
    });
    $(document).on('click', '#btn_next_diagnosa', function() {
        var page_now_diagnosa = parseInt($('#page_diagnosa').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_diagnosa = page_now_diagnosa + 1;
        $('#page_diagnosa').val(next_page_diagnosa);
        ShowDiagnosa(0);
    });

    // Ketika pilih_diagnosa di click
    $(document).on('click', '.pilih_diagnosa', function() {

        // Buat Variabel Dari Data Yang Ditangkap
        var kode  = $(this).data('kode');
        var long_des     = $(this).data('long_des');

        // Tempelkan Data Ke Form
        $('#diagnosis').val(''+kode+'|'+long_des+'');

       // Tutup Modal 'ModalDiagnosa'
       $('#ModalDiagnosa').modal('hide');
    });


    // PROSES TAMBAH PENDAFTARAN Laboratorium
    $('#ProsesPendaftaranLaboratorium').submit(function(e){

        // Stop Submit Double
        e.preventDefault();

        // Ambil data form
        var formData = $(this).serialize();

        // Loading state
        $('#NotifikasiPendaftaranLaboratorium').html(
            '<div class="alert alert-info">Mengirim permintaan...</div>'
        );

        // Disable tombol submit sementara
        $('#ProsesPendaftaranLaboratorium button[type="submit"]').prop('disabled', true);

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Laboratorium2/ProsesPendaftaranLaboratorium.php',
            data    : formData,

            success: function(response) {

                // Tampilkan response ke notifikasi
                $('#NotifikasiPendaftaranLaboratorium').html(response);

                // Ambil status insert dari HTML response
                var status = $('#InsertNotif').html();

                // Jika BERHASIL
                if (status === "Berhasil") {
                
                    Swal.fire({
                        title: 'Pendaftaran Laboratorium Berhasil',
                        text: 'Silahkan pilih tindakan selanjutnya',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Kembali ke Laboratorium',
                        cancelButtonText: 'Input Lainnya',
                        reverseButtons: true
                    }).then((result) => {

                        // Jika klik Kembali ke Laboratorium
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?Page=Laboratorium2';
                        }

                        // Jika klik Lanjut Input
                        else {
                            location.reload();
                        }
                    });

                }

                // Enable kembali tombol submit
                $('#ProsesPendaftaranLaboratorium button[type="submit"]').prop('disabled', false);
            },

            error: function(xhr, status, error) {

                $('#NotifikasiPendaftaranLaboratorium').html(
                    '<div class="alert alert-danger">AJAX Error: '+error+'</div>'
                );

                $('#ProsesPendaftaranLaboratorium button[type="submit"]').prop('disabled', false);
            }
        });
    });

    //---------------------------------------------------------------------------------------------------
    // DETAIL LABORATORIUM
    //---------------------------------------------------------------------------------------------------
    $(document).on('click', '.modal_detail', function () {

        // Get id_laboratorium
        var id_laboratorium = $(this).data('id');

        // Tampilkan Modal
        $('#ModalDetail').modal('show');

        // Loading
        $('#FormDetail').html('<div class="alert alert-dark text-center">Mengambil Data ..</div>');

        // Tampilkan Data Dengan function 'ShowDetail(id_Laboratorium)'
        ShowDetail(id_laboratorium);
    });
    $('#ProsesTampilkanDetailLaboratoium').submit(function(e){

        // Stop Submit Double
        e.preventDefault();

        // Tutup Modal
        $('#ModalDetail').modal('hide');

        // Ambil data form
        var id_laboratorium = $('#get_id_laboratorium').val();

        // Tampilkan Halaman Detail Dan Sembunyikan Yang Lain
        $('.data_laboratorium').hide();
        $('.tambah_laboratorium').hide();
        $('.detail_laboratorium').show();

        // Loading state
        $('.detail_laboratorium').html('<div class="alert alert-info">Loading...</div>');

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Laboratorium2/_DetailPemeriksaan.php',
            data    : {id_laboratorium: id_laboratorium},
            success: function(response) {
                $('.detail_laboratorium').html(response);
            }
        });
    });

    $(document).on('click', '.reload_detail_pemeriksaan', function () {

        var id_laboratorium = $('#get_id_laboratorium').val();
        // Loading state
        $('.detail_laboratorium').html('<div class="alert alert-info">Loading...</div>');

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Laboratorium2/_DetailPemeriksaan.php',
            data    : {id_laboratorium: id_laboratorium},
            success: function(response) {
                $('.detail_laboratorium').html(response);
            }
        });
    });

    //---------------------------------------------------------------------------------------------------
    // Modal Tambah Rincian
    //---------------------------------------------------------------------------------------------------
    $(document).on('click', '.modal_tambah_rincian', function () {

        // Tutup Modal Detail
        $('#ModalDetail').modal('hide');

        // Tampilkan Modal Tambah Rincian Modal Detail
        $('#ModalTambahRincian').modal('show');

        // Buka Form Rincian
        var id_laboratorium = $(this).data('id');
        $('#FormTambahRincian').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium2/FormTambahRincian.php',
            data 	    :  {id_laboratorium: id_laboratorium},
            success     : function(data){
                $('#FormTambahRincian').html(data);
            }
        });
    });

    $(document).on('click', '.kembali_ke_detail', function () {

        // Tampilkan Modal Detail
        $('#ModalDetail').modal('show');

        // Sembunyikan Modal Tambah Rincian Modal Detail
        $('#ModalTambahRincian').modal('hide');
        $('#ModalHapusRincian').modal('hide');
    });

    // Proses Tambah Rincian
    $('#ProsesTambahRincian').submit(function(e){

        // Stop Submit Double
        e.preventDefault();

        // Ambil data form
        var formData = $(this).serialize();

        // Loading state
        $('#NotifikasiTambahRincian').html(
            '<div class="alert alert-info">Mengirim permintaan...</div>'
        );

        // Disable tombol submit sementara
        $('#tombol_tambah_rincian button[type="submit"]').prop('disabled', true);

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Laboratorium2/ProsesTambahRincian.php',
            data    : formData,
            dataType: 'json',

            success: function(response) {
                var status          = response.status;
                var message         = response.message;
                var id_laboratorium = response.id_laboratorium;

                // Apabila berhasil
                if(status=='success'){
                    //Bersihkan notifikasi
                    $('#NotifikasiTambahRincian').html('');

                    //Tutup modal
                    $('#ModalTambahRincian').modal('hide');

                    // Tampilkan Modal Detail
                    $('#ModalDetail').modal('show');

                    //Reload Modal Detail
                    ShowDetail(id_laboratorium);

                    // Reload Halaman Detail
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Laboratorium2/_DetailPemeriksaan.php',
                        data    : {id_laboratorium: id_laboratorium},
                        success: function(response) {
                            $('.detail_laboratorium').html(response);
                        }
                    });

                }else{
                    $('#NotifikasiTambahRincian').html('<div class="alert alert-danger"><small>'+message+'</small></div>');
                }
            }
        });
        $('#tombol_tambah_rincian button[type="submit"]').prop('disabled', false);
    });

    //---------------------------------------------------------------------------------------------------
    // Modal Hapus Rincian
    //---------------------------------------------------------------------------------------------------
    $(document).on('click', '.modal_hapus_rincian', function () {

        // Tampilkan Modal Hapus Rincian
        $('#ModalHapusRincian').modal('show');

        // Buka Form Rincian
        var id_laboratorium_rincian = $(this).data('id_laboratorium_rincian');
        var id_laboratorium = $(this).data('id_laboratorium');

        // Loading Form
        $('#FormHapusRincian').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusRincian').html('');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium2/FormHapusRincian.php',
            data 	    :  {id_laboratorium_rincian: id_laboratorium_rincian, id_laboratorium: id_laboratorium},
            success     : function(data){
                $('#FormHapusRincian').html(data);
            }
        });
    });

    // Proses Hapus Rincian
    $('#ProsesHapusRincian').submit(function(e){

        // Stop Submit Double
        e.preventDefault();

        // Ambil data form
        var formData = $(this).serialize();
        var id_laboratorium = $('#get_id_laboratorium').val;

        // Loading state
        $('#NotifikasiHapusRincian').html(
            '<div class="alert alert-info">Mengirim permintaan...</div>'
        );

        // Disable tombol submit sementara
        $('#tombol_hapus_rincian button[type="submit"]').prop('disabled', true);

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Laboratorium2/ProsesHapusRincian.php',
            data    : formData,
            dataType: 'json',

            success: function(response) {
                var status          = response.status;
                var message         = response.message;
                var id_laboratorium = response.id_laboratorium;

                // Apabila berhasil
                if(status=='success'){
                    //Bersihkan notifikasi
                    $('#NotifikasiHapusRincian').html('');

                    //Tutup modal
                    $('#ModalHapusRincian').modal('hide');

                    //Reload Modal Detail
                    ShowDetail(id_laboratorium);

                    // Reload Halaman Detail
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Laboratorium2/_DetailPemeriksaan.php',
                        data    : {id_laboratorium: id_laboratorium},
                        success: function(response) {
                            $('.detail_laboratorium').html(response);
                        }
                    });


                }else{
                    $('#NotifikasiHapusRincian').html('<div class="alert alert-danger"><small>'+message+'</small></div>');
                }
            }
        });
        $('#tombol_hapus_rincian button[type="submit"]').prop('disabled', false);
    });

    //---------------------------------------------------------------------------------------------------
    // Modal Edit Pemeriksaan
    //---------------------------------------------------------------------------------------------------
    $(document).on('click', '.modal_edit_pemeriksaan', function () {

        // Tampilkan Modal Edit Pemeriksaan
        $('#ModalEditPemeriksaan').modal('show');

        // Buka Form Rincian
        var id_laboratorium = $(this).data('id');

        // Loading Form
        $('#FormEditPemeriksaan').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditPemeriksaan').html('');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium2/FormEditPemeriksaan.php',
            data 	    :  {id_laboratorium: id_laboratorium},
            success     : function(data){
                $('#FormEditPemeriksaan').html(data);
                
                
                $('.select2').select2({
                    theme             : 'bootstrap-5',
                    width             : '100%',
                    dropdownParent    : $('#FormEditPemeriksaan'),
                    placeholder       : 'Cari diagnosis...',
                    minimumInputLength: 1,
                    ajax: {
                        url     : '_Page/Laboratorium2/ListDiagnosis.php',
                        type    : 'POST',
                        dataType: 'json',
                        delay   : 250,
                        data: function (params) {
                            return {
                                search: params.term,
                                page  : params.page || 1
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                results   : data.results,
                                pagination: {
                                    more: data.more
                                }
                            };
                        },
                        cache: true
                    }
                });
            }
        });
    });

    // Proses Edit Permintaan Pemeriksaan
    $('#ProsesEditPemeriksaan').submit(function(e){

        // Stop Submit Double
        e.preventDefault();

        // Ambil data form
        var formData = $(this).serialize();

        // Loading state
        $('#NotifikasiEditPemeriksaan').html(
            '<div class="alert alert-info">Mengirim permintaan...</div>'
        );

        // Disable tombol submit sementara
        $('#tombol_edit_pemeriksaan button[type="submit"]').prop('disabled', true);

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Laboratorium2/ProsesEditPemeriksaan.php',
            data    : formData,
            dataType: 'json',

            success: function(response) {
                var status          = response.status;
                var message         = response.message;
                var id_laboratorium = response.id_laboratorium;

                // Apabila berhasil
                if(status=='success'){
                    //Bersihkan notifikasi
                    $('#NotifikasiEditPemeriksaan').html('');

                    //Tutup modal
                    $('#ModalEditPemeriksaan').modal('hide');

                    Swal.fire({
                        title: 'Mantap!',
                        text: 'Ubah Permintaan Pemeriksaan Berhasil!',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })

                    //Reload Modal Detail
                    ShowLaboratorium();

                    // Reload Halaman Detail
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Laboratorium2/_DetailPemeriksaan.php',
                        data    : {id_laboratorium: id_laboratorium},
                        success: function(response) {
                            $('.detail_laboratorium').html(response);
                        }
                    });

                }else{
                    $('#NotifikasiEditPemeriksaan').html('<div class="alert alert-danger"><small>'+message+'</small></div>');
                }
            }
        });
        $('#tombol_edit_pemeriksaan button[type="submit"]').prop('disabled', false);
    });

    //---------------------------------------------------------------------------------------------------
    // HAPUS PEMERIKSAAN
    //---------------------------------------------------------------------------------------------------
    $(document).on('click', '.modal_hapus_pemeriksaan', function () {

        // Tampilkan Modal Hapus Rincian
        $('#ModalHapusPemeriksaan').modal('show');

        // Buka Form Rincian
        var id_laboratorium = $(this).data('id');

        // Loading Form
        $('#FormHapusPemeriksaan').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusPemeriksaan').html('');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium2/FormHapusPemeriksaan.php',
            data 	    :  {id_laboratorium: id_laboratorium},
            success     : function(data){
                $('#FormHapusPemeriksaan').html(data);
            }
        });
    });

    // Proses Hapus Pemeriksaan
    $('#ProsesHapusPemeriksaan').submit(function(e){

        // Stop Submit Double
        e.preventDefault();

        // Ambil data form
        var formData = $(this).serialize();

        // Loading state
        $('#NotifikasiHapusPemeriksaan').html(
            '<div class="alert alert-info">Mengirim permintaan...</div>'
        );

        // Disable tombol submit sementara
        $('#tombol_hapus_pemeriksaan button[type="submit"]').prop('disabled', true);

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Laboratorium2/ProsesHapusPemeriksaan.php',
            data    : formData,
            dataType: 'json',

            success: function(response) {
                var status          = response.status;
                var message         = response.message;
                
                // Apabila berhasil
                if(status=='success'){
                    //Bersihkan notifikasi
                    $('#NotifikasiHapusPemeriksaan').html('');

                    //Tutup modal
                    $('#ModalHapusPemeriksaan').modal('hide');

                    Swal.fire({
                        title: 'Mantap!',
                        text: 'Hapus Data Pemeriksaan Berhasil!',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })

                    //Reload Data Laboratorium
                    $('.data_laboratorium').show();
                    $('.tambah_laboratorium').hide();
                    $('.detail_laboratorium').hide();
                    ShowLaboratorium();

                }else{
                    $('#NotifikasiHapusPemeriksaan').html('<div class="alert alert-danger"><small>'+message+'</small></div>');
                }
            }
        });
        $('#tombol_hapus_pemeriksaan button[type="submit"]').prop('disabled', false);
    });

    //---------------------------------------------------------------------------------------------------
    // CETAK PERMINTAAN PEMERIKSAAN
    //---------------------------------------------------------------------------------------------------
    $(document).on('click', '.modal_cetak_pemeriksaan', function () {

        // Tampilkan Modal Hapus Rincian
        $('#ModalCetakPemeriksaan').modal('show');

        // Buka Form Rincian
        var id_laboratorium = $(this).data('id');

        // Loading Form
        $('#FormCetakPemeriksaan').html('Loading...');

        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium2/FormCetakPemeriksaan.php',
            data 	    :  {id_laboratorium: id_laboratorium},
            success     : function(data){
                $('#FormCetakPemeriksaan').html(data);
            }
        });
    });

});
