// Tabel Laboratorium
function TabelLaboratorium() {

    // Target And Filter
    let target = $('#tabel_laboratorium');
    let data   = $('#ProsesFilter').serialize();

    target.addClass('blur-loading');

    $.ajax({
        type    : 'POST',
        url     : '_Page/Laboratorium/TabelLaboratorium.php',
        data    : data,
        dataType: 'JSON',
        success : function(response) {

            if(response.status === "success"){

                target.fadeOut(150, function () {
                    target.html(response.html).fadeIn(150);
                });

                // Update info page
                $('#page_info').html('Page ' + response.page + ' Of ' + response.total_page);

                // Handle tombol
                $('#prev_button').prop('disabled', response.page <= 1);
                $('#next_button').prop('disabled', response.page >= response.total_page);

            }else{
                target.html(response.html);
            }

            target.removeClass('blur-loading');
        }
    });
}

// Referensi Pemeriksaan
function TabelReferensiPemeriksaan() {

    // Target And Filter
    let target = $('#tabel_referensi_pemeriksaan');
    target.addClass('blur-loading');

    $.ajax({
        type    : 'POST',
        url     : '_Page/Laboratorium/TabelReferensiPemeriksaan.php',
        dataType: 'JSON',
        success : function(response) {

            if(response.status === "success"){

                target.fadeOut(150, function () {
                    target.html(response.html).fadeIn(150);
                });

            }else{
                target.html(response.html);
            }

            target.removeClass('blur-loading');
        }
    });
}

// Tabel Pasien
function TabelPasien() {

    // Target And Filter
    let target = $('#tabel_pasien');
    let data   = $('#PencarianPasien').serialize();

    target.addClass('blur-loading');

    $.ajax({
        type    : 'POST',
        url     : '_Page/Laboratorium/TabelPasien.php',
        data    : data,
        dataType: 'JSON',
        success : function(response) {

            if(response.status === "success"){

                target.fadeOut(150, function () {
                    target.html(response.html).fadeIn(150);
                });

                // Update info page
                $('#page_info_pasien').html('Page ' + response.page + ' Of ' + response.total_page);

                // Handle tombol
                $('#prev_button_pasien').prop('disabled', response.page <= 1);
                $('#next_button_pasien').prop('disabled', response.page >= response.total_page);

            }else{
                target.html(response.html);
            }

            target.removeClass('blur-loading');
        }
    });
}

// Tabel Pasien
function TabelKunjungan(id_pasien) {

    // Tempelkan 'id_pasien' pada 'put_id_pasien'
    $('#put_id_pasien').val(id_pasien);

    // Target And Filter
    let target          = $('#tabel_kunjungan');
    let FilterKunjungan = $('#FilterKunjungan').serialize();

    target.addClass('blur-loading');

    $.ajax({
        type    : 'POST',
        url     : '_Page/Laboratorium/TabelKunjungan.php',
        data    : FilterKunjungan,
        dataType: 'JSON',
        success : function(response) {

            if(response.status === "success"){

                target.fadeOut(150, function () {
                    target.html(response.html).fadeIn(150);
                });

                // Update info page
                $('#page_info_kunjungan').html('Page ' + response.page + ' Of ' + response.total_page);

                // Handle tombol
                $('#prev_button_kunjungan').prop('disabled', response.page <= 1);
                $('#next_button_kunjungan').prop('disabled', response.page >= response.total_page);

            }else{
                target.html(response.html);
            }

            target.removeClass('blur-loading');
        }
    });
}

// Tabel Dokter
function TabelDokter() {

    // Target And Filter
    let target = $('#tabel_dokter');
    let data   = $('#PencarianDokter').serialize();

    target.addClass('blur-loading');

    $.ajax({
        type    : 'POST',
        url     : '_Page/Laboratorium/TabelDokter.php',
        data    : data,
        dataType: 'JSON',
        success : function(response) {

            if(response.status === "success"){

                target.fadeOut(150, function () {
                    target.html(response.html).fadeIn(150);
                });

                // Update info page
                $('#page_info_dokter').html('Page ' + response.page + ' Of ' + response.total_page);

                // Handle tombol
                $('#prev_button_dokter').prop('disabled', response.page <= 1);
                $('#next_button_dokter').prop('disabled', response.page >= response.total_page);

            }else{
                target.html(response.html);
            }

            target.removeClass('blur-loading');
        }
    });
}

// Tabel Diagnosis
function TabelDiagnosis() {

    // Target And Filter
    let target = $('#tabel_diagnosis');
    let data   = $('#PencarianDiagnosis').serialize();

    target.addClass('blur-loading');

    $.ajax({
        type    : 'POST',
        url     : '_Page/Laboratorium/TabelDiagnosis.php',
        data    : data,
        dataType: 'JSON',
        success : function(response) {

            if(response.status === "success"){

                target.fadeOut(150, function () {
                    target.html(response.html).fadeIn(150);
                });

                // Update info page
                $('#page_info_diagnosis').html('Page ' + response.page + ' Of ' + response.total_page);

                // Handle tombol
                $('#prev_button_diagnosis').prop('disabled', response.page <= 1);
                $('#next_button_diagnosis').prop('disabled', response.page >= response.total_page);

            }else{
                target.html(response.html);
            }

            target.removeClass('blur-loading');
        }
    });
}

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {

    // Tampilkan Tabel
    $('#table_view').show();

    // Sembunyikan Detail View
    $('#detail_view').hide();

    // Sembunyikan Form Tambah
    $('#registration_view').hide();

    // Load Tabel
    TabelLaboratorium();

    //Pagging
    $(document).on('click', '#next_button', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelLaboratorium(0);
    });
    $(document).on('click', '#prev_button', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelLaboratorium(0);
    });

    // Auto Focus Keyword
    $('#ModalFilter').on('shown.bs.modal', function () {
        $('#keyword_form').focus();
    });

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Kunjungan/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Pencarian Kunjungan
    $('#ProsesFilter').submit(function(){

        // Reset Page
        $('#page_filter').val('1');

        // Hidden Modal
        $('#ModalFilter').modal('hide');

        // Reload Function
        TabelLaboratorium();
    });
    
    // ====================================================================
    //TAMBAH LABORATORIUM
    // ====================================================================
    //Ketika Tombol '.tambah_laboratorium' di click
    $(document).on('click', '.tambah_laboratorium', function () {
        
        // Tempelkan Tabel
        $('#table_view').hide();

        // Sembunyikan Detail View
        $('#detail_view').hide();

        // Sembunyikan Form Tambah
        $('#registration_view').show();

        // Reset Form
        $('#ProsesTambahLaboratorium')[0].reset();

        TabelReferensiPemeriksaan();

    });

     // Select All Sub 2
    $(document).on('change', '.cehck_all_sub', function () {

        var category = $(this).data('category');
        var checked  = $(this).is(':checked');

        $('.checkbox_pemeriksaan').each(function () {

            if ($(this).data('category') === category) {
                $(this).prop('checked', checked);
            }

        });

    });

    //Ketika Tombol .back_to_table_view di click
    $(document).on('click', '.back_to_table_view', function () {
        
        // Tempelkan Tabel
        $('#table_view').show();

        // Sembunyikan Detail View
        $('#detail_view').hide();

        // Sembunyikan Form Tambah
        $('#registration_view').hide();

    });

    //---------------------------------------------- Pasien
    //Ketika Tombol '.pilih-pasien' di click
    $(document).on('click', '.pilih-pasien', function () {
        
        // Reset Halaman 'page_pasien'
        $('page_pasien').val('1');

        // Reset Keyword 'keyword_pasien'
        $('keyword_pasien').val('');
        
        // Tampilkan Modal
        $('#ModalPasien').modal('show');

        // Loading 'tabel_pasien'
        TabelPasien();
    });

    // Ketika ModalPasien sudah benar-benar tampil
    $('#ModalPasien').on('shown.bs.modal', function () {
        $('#keyword_pasien').trigger('focus').select();
    });

    //Pagging Pasien
    $(document).on('click', '#next_button_pasien', function() {
        var page_now = parseInt($('#page_pasien').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_pasien').val(next_page);
        TabelPasien(0);
    });
    $(document).on('click', '#prev_button_pasien', function() {
        var page_now = parseInt($('#page_pasien').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_pasien').val(next_page);
        TabelPasien(0);
    });

    // Pencarian Pasien
    $('#PencarianPasien').submit(function(){

        // Reset Page
        $('#page_pasien').val('1');

        // Reload Function
        TabelPasien();
    });

    // Pasien dipilih
    $(document).on('click', '.current_pasien', function () {
        
        // Tangkap data
        var id_pasien     = $(this).data('id_pasien');
        var nama          = $(this).data('nama');
        var gender        = $(this).data('gender');
        var tanggal_lahir = $(this).data('tanggal_lahir');
        var id_ihs        = $(this).data('id_ihs');
        
        // Tampilkan Modal
        $('#ModalPasien').modal('hide');

        // Tempelkan Data Ke Form Pasien
        $('#id_pasien').val(id_pasien);
        $('#nama').val(nama);
        $('#gender').val(gender);
        $('#tanggal_lahir').val(tanggal_lahir);
        $('#ihs_pasien').val(id_ihs);

        // Kosongkan Kunjungan
        $('#id_kunjungan').val('');
        $('#tujuan').val('');
        $('#pembayaran').val('');
        $('#unit').val('');
        $('#id_encounter').val('');
    });

    //---------------------------------------------- Kunjungan

    //Ketika Tombol '.pilih-kunjungan' di click
    $(document).on('click', '.pilih-kunjungan', function () {
        
        // Tangkap 'id_pasien'
        var id_pasien = $('#id_pasien').val();

        // Reset Halaman
        $('#page_kunjungan').val('1');

        // Tampilkan 'ModalKunjungan'
        $('#ModalKunjungan').modal('show');

        // Loading 'tabel_pasien'
        TabelKunjungan(id_pasien);
    });

    //Pagging Kunjungan
    $(document).on('click', '#next_button_kunjungan', function() {
        var id_pasien = $('#id_pasien').val();
        var page_now = parseInt($('#page_kunjungan').val(), 10); 
        var next_page = page_now + 1;
        $('#page_kunjungan').val(next_page);
        TabelKunjungan(id_pasien);
    });
    $(document).on('click', '#prev_button_pasien', function() {
        var id_pasien = $('#id_pasien').val();
        var page_now = parseInt($('#page_kunjungan').val(), 10); 
        var next_page = page_now - 1;
        $('#page_kunjungan').val(next_page);
        TabelKunjungan(id_pasien);
    });

    // Kunjungan dipilih
    $(document).on('click', '.current_kunjungan', function () {
        
        // Tangkap data
        var id_kunjungan      = $(this).data('id_kunjungan');
        var id_encounter      = $(this).data('id_encounter');
        var tujuan            = $(this).data('tujuan');
        var pembayaran_metode = $(this).data('pembayaran_metode');
        var unit_instalasi    = $(this).data('unit_instalasi');
        
        // Tutup Modal
        $('#ModalKunjungan').modal('hide');

        // Tempelkan Data Ke Form Kunjungan
        $('#id_kunjungan').val(id_kunjungan);
        $('#tujuan').val(tujuan);
        $('#pembayaran').val(pembayaran_metode);
        $('#unit').val(unit_instalasi);
        $('#id_encounter').val(id_encounter);
    });

    //--------------------------------------- Dokter

    //Ketika Tombol '.pilih-dokter' di click
    $(document).on('click', '.pilih-dokter', function () {
        
        // Reset Halaman
       $('page_dokter').val('1');

       // Reset Keyword
       $('keyword_dokter').val('');
        
        // Tampilkan Modal
        $('#ModalDokter').modal('show');

        // Loading 'tabel_pasien'
        TabelDokter();
    });

    // Ketika ModalDokter sudah benar-benar tampil
    $('#ModalDokter').on('shown.bs.modal', function () {
        $('#keyword_dokter').trigger('focus').select();
    });

    // Pencarian Dokter
    $('#PencarianDokter').submit(function(){

        // Reset Page
        $('#page_dokter').val('1');

        // Reload Function
        TabelDokter();
    });

    //Pagging Pasien
    $(document).on('click', '#next_button_dokter', function() {
        var page_now = parseInt($('#page_dokter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_dokter').val(next_page);
        TabelDokter(0);
    });
    $(document).on('click', '#prev_button_dokter', function() {
        var page_now = parseInt($('#page_dokter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_dokter').val(next_page);
        TabelDokter(0);
    });

    // Dokter dipilih
    $(document).on('click', '.current_dokter', function () {
        
        // Tangkap data
        var nama_dokter_pengirim = $(this).data('nama');
        var kode_dokter_pengirim = $(this).data('kode');
        var ihs_dokter_pengirim  = $(this).data('id_ihs_practitioner');
       
        // Tutup Modal
        $('#ModalDokter').modal('hide');

        // Tempelkan Data Ke Form Pasien
        $('#nama_dokter_pengirim').val(nama_dokter_pengirim);
        $('#kode_dokter_pengirim').val(kode_dokter_pengirim);
        $('#ihs_dokter_pengirim').val(ihs_dokter_pengirim);
       
    });

    //--------------------------------------- Diagnosis

    //Ketika Tombol '.pilih-diagnosis' di click
    $(document).on('click', '.pilih-diagnosis', function () {
        
        // Reset Halaman
       $('page_diagnosis').val('1');

       // Reset Keyword
       $('keyword_diagnosis').val('');
        
        // Tampilkan Modal
        $('#ModalDiagnosis').modal('show');

        // Load Data (Function)
        TabelDiagnosis();
    });

    // Ketika ModalDiagnosis sudah benar-benar tampil
    $('#ModalDiagnosis').on('shown.bs.modal', function () {
        $('#keyword_diagnosis').trigger('focus').select();
    });

    // Pencarian Diagnosis
    $('#PencarianDiagnosis').submit(function(){

        // Reset Page
        $('#page_diagnosis').val('1');

        // Reload Function
        TabelDiagnosis();
    });

    //Pagging Diagnosis
    $(document).on('click', '#next_button_diagnosis', function() {
        var page_now = parseInt($('#page_diagnosis').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_diagnosis').val(next_page);
        TabelDiagnosis(0);
    });
    $(document).on('click', '#prev_button_diagnosis', function() {
        var page_now = parseInt($('#page_diagnosis').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_diagnosis').val(next_page);
        TabelDiagnosis(0);
    });

    // Dokter dipilih
    $(document).on('click', '.current_diagnosis', function () {
        
        // Tangkap data
        var nama_diagnosis = $(this).data('nama');
        var kode_diagnosis = $(this).data('kode');
        var system_diagnosis  = 'http://hl7.org/fhir/sid/icd-10';
       
        // Tutup Modal
        $('#ModalDiagnosis').modal('hide');

        // Tempelkan Data Ke Form Diagnosis
        $('#nama_diagnosis').val(nama_diagnosis);
        $('#kode_diagnosis').val(kode_diagnosis);
        $('#system_diagnosis').val(system_diagnosis);
       
    });

    // Handdle Submit 'ProsesTambahLaboratorium'
    $(document).on('submit', '#ProsesTambahLaboratorium', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahLaboratorium');
        let notifikasi = $('#NotifikasiTambahLaboratorium');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/Laboratorium/ProsesTambah.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {
                
                // Status & message
                var status = response.status;
                var message = response.message;

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                // Jika Berhasil
                if (response.status === 'success') {
                    // Reset Form Tambah
                    $('#ProsesTambahLaboratorium')[0].reset();

                    // Reset Form Filter Lab
                    $('#ProsesFilter')[0].reset();

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tampilkan Tabel
                    $('#table_view').show();

                    // Sembunyikan Detail View
                    $('#detail_view').hide();

                    // Sembunyikan Form Tambah
                    $('#registration_view').hide();

                    // Load Tabel
                    TabelLaboratorium();

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Kirim Permintaan Laboratorium Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                } else {

                    // Tampilkan error
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {

                // Kembalikan tombol
                button.prop('disabled', false).html(buttonText);

                // Error server
                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });


    // ====================================================================
    //  DETAIL LABORATORIUM
    // ====================================================================
    //Ketika Tombol '.modal_detail' di click
    $(document).on('click', '.modal_detail', function () {
        
        // Tangkap id_laboratorium
        var id_laboratorium = $(this).data('id');
        
        // Tampilkan Modal
        $('#ModalDetail').modal('show');

        // Loading 'FormDetail'
        $('#FormDetail').html('Loading...');

        // Buka Detail dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium/FormDetail.php',
            data        : {id_laboratorium: id_laboratorium},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });
});