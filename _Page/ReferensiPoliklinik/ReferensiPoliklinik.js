// Tabel Poliklinik
function TabelPoliklinik() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_poliklinik');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiPoliklinik/TabelPoliklinik.php',
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


// Menampilkan Toast
function showToast(message, type = 'success') {
    let bgClass = type === 'success' ? 'bg-success' : 'bg-danger';

    let toastHtml = `
        <div class="toast align-items-center text-white ${bgClass} border-0 position-fixed top-0 end-0 m-3" 
            role="alert" 
            aria-live="assertive" 
            aria-atomic="true"
            style="z-index: 9999;">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    $('body').append(toastHtml);

    let toastEl = $('.toast').last()[0];
    let toast = new bootstrap.Toast(toastEl, {
        delay: 3000
    });

    toast.show();

    $(toastEl).on('hidden.bs.toast', function () {
        $(this).remove();
    });
}

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    TabelPoliklinik();

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiPoliklinik/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelPoliklinik();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelPoliklinik(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelPoliklinik(0);
    });

    // ====================================================================
    // TAMBAH POLIKLINIK
    // ====================================================================
    $('#ModalTambahPoliklinik').on('shown.bs.modal', function () {
        // Auto Focus
        $('#poliklinik').focus();

        // Hindari inisialisasi berulang
        if (!$('#kode').hasClass("select2-hidden-accessible")) {
            $('#kode').select2({
                theme             : 'bootstrap-5',
                placeholder       : 'Ketik atau pilih kode poli',
                tags              : true,
                allowClear        : true,
                selectOnClose     : true,
                width             : '100%',
                dropdownParent    : $('#ModalTambahPoliklinik'),

                ajax: {
                    url     : '_Page/ReferensiPoliklinik/GetKode.php',
                    type    : 'POST',
                    dataType: 'json',
                    delay   : 300,

                    data: function (params) {
                        return {
                            keyword: params.term,
                            page   : params.page || 1
                        };
                    },

                    processResults: function (data, params) {
                        return {
                            results: data.results || data,
                            pagination: {
                                more: data.pagination?.more || false
                            }
                        };
                    },

                    cache: true
                },

                createTag: function (params) {
                    let term = String(params.term || '').trim();

                    if (term === '') {
                        return null;
                    }

                    return {
                        id       : term,
                        text     : term + ' (Input Manual)',
                        newOption: true
                    };
                },

                insertTag: function (data, tag) {
                    data.unshift(tag);
                },

                language: {
                    noResults: function () {
                        return 'Kode poli tidak ditemukan. Tekan Enter untuk input manual.';
                    },
                    searching: function () {
                        return 'Mencari kode poli...';
                    },
                    inputTooShort: function () {
                        return 'Ketik kode atau nama poli.';
                    }
                }
            });
        }
    });


    // Submit Tambah Poliklinik
    $(document).on('submit', '#ProsesTambahPoliklinik', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahPoliklinik');
        let modal      = $('#ModalTambahPoliklinik');
        let notifikasi = $('#NotifikasiTambahPoliklinik');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url      : '_Page/ReferensiPoliklinik/ProsesTambahPoliklinik.php',
            type     : 'POST',
            data     : formData,
            dataType : 'json',

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    form[0].reset();

                    // Reset select2 kategori
                    $('#kategori').val(null).trigger('change');

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Poliklinik berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Reset Filter
                    let filterForm = $('#ProsesFilter');

                    if (filterForm.length) {
                        filterForm[0].reset();

                        // reset page ke halaman pertama
                        $('#page').val('1');

                        // reset field keyword dinamis
                        $('#FormFilter').html(`
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        `);

                        // reset select field
                        $('#keyword_by').val('');
                        $('#OrderBy').val('');
                        $('#ShortBy').val('DESC');
                        $('#batas').val('10');
                    }
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelPoliklinik();

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

    //==================================================================
    // DETAIL POLIKLINIK
    //==================================================================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Google Credential
        var id_poliklinik = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailPoliklinik').modal('show');

        // Loading Form
        $('#FormDetailPoliklinik').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiPoliklinik/FormDetailPoliklinik.php',
            data        : {id_poliklinik: id_poliklinik},
            success     : function(data){
                $('#FormDetailPoliklinik').html(data);
            }
        });
    });

    
    

    //==================================================================
    // EDIT POLIKLINIK
    //==================================================================
    $(document).on('click', '.modal_edit', function () {

        var id_poliklinik = $(this).data('id');

        $('#ModalEditPoliklinik').modal('show');
        $('#NotifikasiEditPoliklinik').html('');
        $('#FormEditPoliklinik').html('Loading...');

        $.ajax({
            type : 'POST',
            url  : '_Page/ReferensiPoliklinik/FormEditPoliklinik.php',
            data : {id_poliklinik: id_poliklinik},

            success: function(data){
                $('#FormEditPoliklinik').html(data);

                if ($('#kode_edit').length && !$('#kode_edit').hasClass("select2-hidden-accessible")) {
                    $('#kode_edit').select2({
                        theme             : 'bootstrap-5',
                        placeholder       : 'Ketik atau pilih kode poli',
                        tags              : true,
                        allowClear        : true,
                        selectOnClose     : true,
                        width             : '100%',
                        dropdownParent    : $('#ModalEditPoliklinik'),

                        ajax: {
                            url     : '_Page/ReferensiPoliklinik/GetKode.php',
                            type    : 'POST',
                            dataType: 'json',
                            delay   : 300,

                            data: function (params) {
                                return {
                                    keyword: params.term,
                                    page   : params.page || 1
                                };
                            },

                            processResults: function (data, params) {
                                return {
                                    results: data.results || data,
                                    pagination: {
                                        more: data.pagination?.more || false
                                    }
                                };
                            },

                            cache: true
                        },

                        createTag: function (params) {
                            let term = String(params.term || '').trim();

                            if (term === '') {
                                return null;
                            }

                            return {
                                id       : term,
                                text     : term + ' (Input Manual)',
                                newOption: true
                            };
                        },

                        insertTag: function (data, tag) {
                            data.unshift(tag);
                        },

                        language: {
                            noResults: function () {
                                return 'Kode poli tidak ditemukan. Tekan Enter untuk input manual.';
                            },
                            searching: function () {
                                return 'Mencari kode poli...';
                            },
                            inputTooShort: function () {
                                return 'Ketik kode atau nama poli.';
                            }
                        }
                    });
                }
            }
        });
    });

    // HANDLE SUBMIT EDIT POLIKLINIK
    $(document).on('submit', '#ProsesEditPoliklinik', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditPoliklinik');
        let modal      = $('#ModalEditPoliklinik');
        let notifikasi = $('#NotifikasiEditPoliklinik');

        // Simpan text tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url      : '_Page/ReferensiPoliklinik/ProsesEditPoliklinik.php',
            type     : 'POST',
            data     : formData,
            dataType : 'json',

            success: function (response) {

                // Kembalikan tombol
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Tutup modal
                    modal.modal('hide');

                    // Refresh tabel TANPA reset filter
                    TabelPoliklinik();

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Poliklinik berhasil',
                        showConfirmButton: false,
                        timer            : 1500,
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

    //==================================================================
    // HAPUS POLIKLINIK
    //==================================================================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap id
        var id_poliklinik = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusPoliklinik').modal('show');

        // Loading Form
        $('#FormHapusPoliklinik').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusPoliklinik').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiPoliklinik/FormHapusPoliklinik.php',
            data        : {id_poliklinik: id_poliklinik},
            success     : function(data){
                $('#FormHapusPoliklinik').html(data);
            }
        });
    });

    // Submit Hapus Akses Poliklinik
    $(document).on('submit', '#ProsesHapusPoliklinik', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusPoliklinik');
        let modal      = $('#ModalHapusPoliklinik');
        let notifikasi = $('#NotifikasiHapusPoliklinik');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ReferensiPoliklinik/ProsesHapusPoliklinik.php',
            type: 'POST',
            data: formData,
            dataType: 'json',

            success: function (response) {
                // tombol kembali normal
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // tutup modal
                    modal.modal('hide');

                    // toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus Poliklinik Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelPoliklinik();

                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(buttonText);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan pada server.
                    </div>
                `);
            }
        });
    });

});
