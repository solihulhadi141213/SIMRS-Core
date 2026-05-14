// Tabel Diagnosis
function TabelDiagnosis() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_diagnosis');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Diagnosis/TabelDiagnosis.php',
        data: ProsesFilter,
        success: function(data) {
            let wrapper = $('<div>').html(data);
            let rowHtml = wrapper.find('tr');
            let firstRow = rowHtml.first();
            let pageCount = parseInt(firstRow.attr('data-page-count'), 10);
            let currentPage = parseInt(firstRow.attr('data-current-page'), 10);

            if (isNaN(pageCount)) {
                pageCount = 0;
            }

            if (isNaN(currentPage)) {
                currentPage = 0;
            }

            target.css('opacity', '0');

            setTimeout(function () {
                target.html(rowHtml)
                      .addClass('blur-loading')
                      .css('opacity', '1');

                $('#page_info').html(currentPage + ' / ' + pageCount);
                $('#previous_page').prop('disabled', currentPage <= 1);
                $('#next_page').prop('disabled', currentPage <= 0 || currentPage >= pageCount);

                setTimeout(function () {
                    target.removeClass('blur-loading');
                }, 200);
            }, 150);
        }
    });
}

// Menampilkan Form Diagnosis
function ShowDiagnosis(id_kunjungan){
    // Tampilkan ModalDiagnosis
    $('#ModalDiagnosis').modal('show');

    // Loading FormDiagnosis
    $('#FormDiagnosis').html('Loading...');

    // Buka Form Diagnosis Dengan AJAX
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Diagnosis/FormDiagnosis.php',
        data        : {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormDiagnosis').html(data);
        }
    });
}

// Validasi Tombol Submit Form Condition
function ValidasiButtonCondition(formSelector, buttonSelector) {
    let valid = true;
    let form  = $(formSelector);
    let total = form.find('[required]').length;

    form.find('[required]').each(function () {
        if ($.trim($(this).val()) === '') {
            valid = false;
            return false;
        }
    });

    $(buttonSelector).prop('disabled', total === 0 || !valid);
}

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    
    // Load Tabel
    TabelDiagnosis();

     //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelDiagnosis(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelDiagnosis(0);
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
            url 	    : '_Page/Diagnosis/FormFilter.php',
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
        TabelDiagnosis();
    });

    // Menampilkan Modal Diagnosis
    $(document).on('click', '.modal_diagnosis', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        ShowDiagnosis(id_kunjungan);

    });

    // Menampilkan Info Diagnosis
    $('#ModalInfo').on('shown.bs.modal', function () {
        $('#FormInfo').load('_Page/Diagnosis/InfoDiagnosis.php');
    });

    // Menampilkan Detail Kunjungan
    $(document).on('click', '.modal_detail_kunjungan', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Loading Form
        $('#FormDetailKunjungan').html('Loading...');

        // Show Modal
        $('#ModalDetailKunjungan').modal('show');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Kunjungan/FormDetailKunjungan.php',
            data        : {id_kunjungan : id_kunjungan},
            success     : function(data){
                $('#FormDetailKunjungan').html(data);
            }
        });

    });

    // Menampilkan Detail Pasien
    $(document).on('click', '.modal_detail_pasien', function () {
        
        // Tangkap id_pasien
        var id_pasien = $(this).data('id');

        // Loading Form
        $('#FormDetailPasien').html('Loading...');

        // Show Modal
        $('#ModalDetailPasien').modal('show');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Pasien/FormDetail.php',
            data        : {id_pasien : id_pasien},
            success     : function(data){
                $('#FormDetailPasien').html(data);
            }
        });

    });

    // ==================================================
    // TAMBAH DIAGNOSIS
    // ==================================================
    
    $(document).on('click', '.modal_tambah_diagnosis', function () {

        // Tangkap Data
        let id_kunjungan = $(this).data('id_kunjungan');
        let kategori     = $(this).data('kategori');

        // Reset
        $('#NotifikasiTambahDiagnosis').html('');
        $('#FormTambahDiagnosis').html('Loading...');

        // Tampilkan Modal
        $('#ModalTambahDiagnosis').modal('show');

        // LOAD FORM
        $.ajax({
            type: 'POST',
            url: '_Page/Diagnosis/FormTambahDiagnosis.php',
            data: {
                id_kunjungan: id_kunjungan,
                kategori: kategori
            },
            success: function(data){

                // Render Form
                $('#FormTambahDiagnosis').html(data);

                // DESTROY SELECT2 JIKA SUDAH ADA
                if ($('#id_dokter').hasClass('select2-hidden-accessible')) {
                    $('#id_dokter').select2('destroy');
                }

                if ($('#id_icd').hasClass('select2-hidden-accessible')) {
                    $('#id_icd').select2('destroy');
                }

                // SELECT2 DOKTER
                $('#id_dokter').select2({
                    theme         : 'bootstrap-5',
                    width         : '100%',
                    placeholder   : 'Pilih Dokter',
                    dropdownParent: $('#ModalTambahDiagnosis'),

                    ajax: {
                        url: '_Page/Diagnosis/ListDokter.php',
                        type: 'POST',
                        dataType: 'json',
                        delay: 250,

                        data: function(params) {

                            return {
                                search: params.term || '',
                                page: params.page || 1
                            };
                        },

                        processResults: function(data, params) {

                            params.page = params.page || 1;

                            return {
                                results: data.results,

                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },

                        cache: true
                    }
                });

                // SELECT2 ICD
                $('#id_icd').select2({
                    theme         : 'bootstrap-5',
                    width         : '100%',
                    placeholder   : 'Pilih ICD',
                    dropdownParent: $('#ModalTambahDiagnosis'),

                    ajax: {
                        url     : '_Page/Diagnosis/ListIcd.php',
                        type    : 'POST',
                        dataType: 'json',
                        delay   : 250,

                        data: function(params) {

                            return {
                                search: params.term || '',
                                page: params.page || 1,
                                icd_version: $('#icd_version').val()
                            };
                        },

                        processResults: function(data, params) {

                            params.page = params.page || 1;

                            return {
                                results: data.results,

                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },

                        cache: true
                    }
                });

            }
        });

    });

    // RESET ICD SAAT ICD VERSION BERUBAH
    // DELEGATED EVENT
    $(document).on('change', '#icd_version', function () {

        $('#id_icd').val(null).trigger('change');

    });

    // OPTIONAL
    // BERSIHKAN MODAL SAAT DITUTUP
    $('#ModalTambahDiagnosis').on('hidden.bs.modal', function () {

        $('#FormTambahDiagnosis').html('');
        $('#NotifikasiTambahDiagnosis').html('');

    });

    // Submit Tambah Diagnosis
    $(document).on('submit', '#ProsesTambahDiagnosis', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahDiagnosis');
        let modal      = $('#ModalTambahDiagnosis');
        let notifikasi = $('#NotifikasiTambahDiagnosis');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Diagnosis/ProsesTambahDiagnosis.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {
                    let id_kunjungan = response.id_kunjungan;
                    // Reset form
                    form[0].reset();
                    
                    // Reset Form select2
                    $('#id_dokter').val(null).trigger('change');
                    $('#id_icd').val(null).trigger('change');
                   
                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Diagnosis berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelDiagnosis();
                    ShowDiagnosis(id_kunjungan);

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

    // =============================================
    // DETAIL DIAGNOSIS
    // =============================================
    $(document).on('click', '.modal_detail_diagnosis', function () {
        
        // Tangkap id_diagnosis
        var id_diagnosis = $(this).data('id');

        // Loading Form
        $('#FormDetailDiagnosis').html('Loading...');

        // Show Modal
        $('#ModalDetailDiagnosis').modal('show');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Diagnosis/FormDetailDiagnosis.php',
            data        : {id_diagnosis : id_diagnosis},
            success     : function(data){
                $('#FormDetailDiagnosis').html(data);
            }
        });

    });

    // =============================================
    // EDIT DIAGNOSIS
    // =============================================
    $(document).on('click', '.modal_edit_diagnosis', function () {
        
        // Tangkap id_diagnosis
        var id_diagnosis = $(this).data('id');

        // Kosongkan Notifikasi
        $('#NotifikasiEditDiagnosis').html('');

        // Loading Form
        $('#FormEditDiagnosis').html('Loading...');

        // Show Modal
        $('#ModalEditDiagnosis').modal('show');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Diagnosis/FormEditDiagnosis.php',
            data        : {id_diagnosis : id_diagnosis},
            success     : function(data){
                $('#FormEditDiagnosis').html(data);

                if ($('#id_dokter_edit_diagnosis').hasClass('select2-hidden-accessible')) {
                    $('#id_dokter_edit_diagnosis').select2('destroy');
                }

                if ($('#id_icd_edit').hasClass('select2-hidden-accessible')) {
                    $('#id_icd_edit').select2('destroy');
                }

                $('#id_dokter_edit_diagnosis').select2({
                    theme         : 'bootstrap-5',
                    width         : '100%',
                    placeholder   : 'Pilih Dokter',
                    dropdownParent: $('#ModalEditDiagnosis'),

                    ajax: {
                        url     : '_Page/Diagnosis/ListDokter.php',
                        type    : 'POST',
                        dataType: 'json',
                        delay   : 250,

                        data: function(params) {
                            return {
                                search: params.term || '',
                                page  : params.page || 1
                            };
                        },

                        processResults: function(data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },

                        cache: true
                    }
                });

                $('#id_icd_edit').select2({
                    theme         : 'bootstrap-5',
                    width         : '100%',
                    placeholder   : 'Pilih ICD',
                    dropdownParent: $('#ModalEditDiagnosis'),

                    ajax: {
                        url     : '_Page/Diagnosis/ListIcd.php',
                        type    : 'POST',
                        dataType: 'json',
                        delay   : 250,

                        data: function(params) {
                            return {
                                search     : params.term || '',
                                page       : params.page || 1,
                                icd_version: $('#icd_version_edit').val()
                            };
                        },

                        processResults: function(data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },

                        cache: true
                    }
                });
            }
        });

    });

    // Reset ICD Edit Saat Versi ICD Berubah
    $(document).on('change', '#icd_version_edit', function () {
        $('#id_icd_edit').val(null).trigger('change');
    });

    // Bersihkan Modal Edit Saat Ditutup
    $('#ModalEditDiagnosis').on('hidden.bs.modal', function () {
        $('#FormEditDiagnosis').html('');
        $('#NotifikasiEditDiagnosis').html('');
    });

    // Submit Edit Diagnosis
    $(document).on('submit', '#ProsesEditDiagnosis', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditDiagnosis');
        let modal      = $('#ModalEditDiagnosis');
        let notifikasi = $('#NotifikasiEditDiagnosis');
        let buttonText = button.html();
        let formData   = new FormData(this);

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Diagnosis/ProsesEditDiagnosis.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {
                    let id_kunjungan = response.id_kunjungan;

                    notifikasi.html('');
                    modal.modal('hide');

                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Diagnosis berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    TabelDiagnosis();
                    ShowDiagnosis(id_kunjungan);
                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(buttonText);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });

    // =============================================
    // HAPUS DIAGNOSIS
    // =============================================
    $(document).on('click', '.modal_hapus_diagnosis', function () {
        
        // Tangkap id_diagnosis
        var id_diagnosis = $(this).data('id');

        // Loading Form
        $('#FormHapusDiagnosis').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusDiagnosis').html('');

        // Show Modal
        $('#ModalHapusDiagnosis').modal('show');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Diagnosis/FormHapusDiagnosis.php',
            data        : {id_diagnosis : id_diagnosis},
            success     : function(data){
                $('#FormHapusDiagnosis').html(data);
            }
        });

    });

    // Submit Edit Diagnosis
    $(document).on('submit', '#ProsesHapusDiagnosis', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusDiagnosis');
        let modal      = $('#ModalHapusDiagnosis');
        let notifikasi = $('#NotifikasiHapusDiagnosis');
        let buttonText = button.html();
        let formData   = new FormData(this);

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Diagnosis/ProsesHapusDiagnosis.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {
                    let id_kunjungan = response.id_kunjungan;

                    notifikasi.html('');
                    modal.modal('hide');

                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus Diagnosis berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    TabelDiagnosis();
                    ShowDiagnosis(id_kunjungan);
                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(buttonText);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });

    // =============================================
    // KIRIM CONDITION
    // =============================================
    $(document).on('click', '.modal_kirim_condition', function () {
        
        // Tangkap id_diagnosis
        var id_diagnosis = $(this).data('id');

        // Loading Form
        $('#FormKirimCondition').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiKirimCondition').html('');

        // Show Modal
        $('#ModalKirimCondition').modal('show');

        // Disable Button For Frist time
        $('#ButtonKirimCondition').prop('disabled', true);

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Diagnosis/FormKirimCondition.php',
            data        : {id_diagnosis : id_diagnosis},
            success     : function(data){
                $('#FormKirimCondition').html(data);
                ValidasiButtonCondition('#ProsesKirimCondition', '#ButtonKirimCondition');
            }
        });

    });

    // Enable Button Kirim Condition Ketika Semua Input Required Terisi
    $(document).on('input change', '#ProsesKirimCondition [required]', function () {
        ValidasiButtonCondition('#ProsesKirimCondition', '#ButtonKirimCondition');
    });

    // Submit Kirim Condition
    $(document).on('submit', '#ProsesKirimCondition', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonKirimCondition');
        let modal      = $('#ModalKirimCondition');
        let notifikasi = $('#NotifikasiKirimCondition');
        let buttonText = button.html();
        let formData   = new FormData(this);

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Diagnosis/ProsesKirimCondition.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {
                    let id_kunjungan = response.id_kunjungan;

                    notifikasi.html('');
                    modal.modal('hide');

                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Kirim Condition Ke SATUSEHAT Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    TabelDiagnosis();
                    ShowDiagnosis(id_kunjungan);
                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(buttonText);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });

    // =============================================
    // DETAIL CONDITION
    // =============================================
    $(document).on('click', '.modal_detail_condition', function () {
        
        // Tangkap id_condition
        var id_condition = $(this).data('id');

        // Loading Form
        $('#FormDetailCondition').html('Loading...');

        // Show Modal
        $('#ModalDetailCondition').modal('show');


        // Tampilkan Detail Condition Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Diagnosis/FormDetailCondition.php',
            data        : {id_condition : id_condition},
            success     : function(data){
                $('#FormDetailCondition').html(data);
            }
        });

    });

    // =============================================
    // EDIT CONDITION
    // =============================================
    $(document).on('click', '.modal_edit_condition', function () {
        
        // Tangkap id_condition
        var id_condition = $(this).data('id');

        // Remove Notification
        $('#NotifikasiEditCondition').html('');

        // Loading Form
        $('#FormEditCondition').html('Loading...');

        // Show Modal
        $('#ModalEditCondition').modal('show');

        // Disable Button For First Time
        $('#ButtonEditCondition').prop('disabled', true);

        // Show Form With AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Diagnosis/FormEditCondition.php',
            data        : {id_condition : id_condition},
            success     : function(data){
                $('#FormEditCondition').html(data);
                ValidasiButtonCondition('#ProsesEditCondition', '#ButtonEditCondition');
            }
        });

    });

    // Enable Button Edit Condition Ketika Semua Input Required Terisi
    $(document).on('input change', '#ProsesEditCondition [required]', function () {
        ValidasiButtonCondition('#ProsesEditCondition', '#ButtonEditCondition');
    });

    // Submit Edit Condition
    $(document).on('submit', '#ProsesEditCondition', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditCondition');
        let modal      = $('#ModalEditCondition');
        let notifikasi = $('#NotifikasiEditCondition');
        let buttonText = button.html();
        let formData   = new FormData(this);

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Diagnosis/ProsesEditCondition.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {
                    let id_kunjungan = response.id_kunjungan;

                    notifikasi.html('');
                    modal.modal('hide');

                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Condition Ke SATUSEHAT Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    TabelDiagnosis();
                    ShowDiagnosis(id_kunjungan);
                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(buttonText);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });


});
