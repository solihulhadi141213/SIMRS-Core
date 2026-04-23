// Tabel Dokter
function TabelDokter() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_poliklinik');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiDokter/TabelDokter.php',
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

function buildManualTag(params, suffixText = ' (Input Manual)') {
    let term = String(params.term || '').trim();

    if (term === '') {
        return null;
    }

    return {
        id       : term,
        text     : term + suffixText,
        newOption: true
    };
}

function prependManualTag(data, tag) {
    data.unshift(tag);
}

let dokterKodeNoResultsMessage = 'Ketik kode atau nama dokter.';

function select2ManualLanguage(defaultText, searchingText) {
    return {
        noResults: function () {
            return defaultText;
        },
        searching: function () {
            return searchingText;
        },
        inputTooShort: function () {
            return searchingText;
        }
    };
}



// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    TabelDokter();

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiDokter/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelDokter();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelDokter(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelDokter(0);
    });

    // ====================================================================
    // TAMBAH DOKTER
    // ====================================================================
    $('#ModalTambahDokter').on('shown.bs.modal', function () {
        // Auto Focus
        $('#nama').focus();

        // Pencarian Kode Dokter Dari Bridging BPJS
        if (!$('#kode').hasClass("select2-hidden-accessible")) {
            $('#kode').select2({
                theme             : 'bootstrap-5',
                placeholder       : 'Ketik atau pilih kode dokter',
                tags              : true,
                allowClear        : true,
                selectOnClose     : true,
                width             : '100%',
                dropdownParent    : $('#ModalTambahDokter'),

                ajax: {
                    url     : '_Page/ReferensiDokter/GetKode.php',
                    type    : 'POST',
                    dataType: 'json',
                    delay   : 200,

                    data: function (params) {
                        return {
                            keyword: params.term,
                            page   : params.page || 1
                        };
                    },

                    processResults: function (data, params) {
                        dokterKodeNoResultsMessage = data.message || 'Kode dokter tidak ditemukan. Tekan Enter untuk input manual.';
                        console.log('GetKode Dokter Response:', data);

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
                    return buildManualTag(params);
                },
                insertTag: prependManualTag,
                language: {
                    noResults: function () {
                        return dokterKodeNoResultsMessage;
                    },
                    searching: function () {
                        return 'Mencari kode dokter...';
                    },
                    inputTooShort: function () {
                        return 'Ketik kode atau nama dokter.';
                    }
                }
            });
        }

        // SELECT2 KATEGORI
        if (!$('#kategori').hasClass("select2-hidden-accessible")) {
            $('#kategori').select2({
                theme             : 'bootstrap-5',
                placeholder       : 'Ketik atau pilih kategori',
                tags              : true,
                allowClear        : true,
                selectOnClose     : true,
                width             : '100%',
                dropdownParent    : $('#ModalTambahDokter'),

                ajax: {
                    url     : '_Page/ReferensiDokter/GetKategori.php',
                    type    : 'POST',
                    dataType: 'json',
                    delay   : 300,

                    data: function (params) {
                        return {
                            keyword: params.term,
                            page   : params.page || 1
                        };
                    },

                    processResults: function (data) {
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
                    return buildManualTag(params);
                },
                insertTag: prependManualTag,
                language: select2ManualLanguage(
                    'Kategori tidak ditemukan. Tekan Enter untuk input manual.',
                    'Mencari kategori dokter...'
                )
            });
        }
    });

    // PENCARIAN ID PRACTITIONER MENGGUNAKAN NIK
    $(document).on('click', '.modal_cari_practitioner', function () {
        
        // Tangkap NIK
        var nik = $('#no_identitas').val();

        // Hapus error sebelumnya
        $('#error_nik').remove();
        $('#no_identitas').removeClass('is-invalid');

        // Validasi NIK
        if(!nik || nik.trim() === ''){
            $('#no_identitas').addClass('is-invalid');
            $('#no_identitas').after(
                '<div id="error_nik" class="invalid-feedback">' +
                'Silahkan isi NIK terlebih dulu' +
                '</div>'
            );
            return;
        }

        // Jika valid maka tampilkan modal
        $('#ModalCariPractitioner').modal('show');

        // Loading Form
        $('#FormCariPractitioner').html('<div class="text-center"><small>Loading...</small></div>');

        // Kirim NIK dengan AJAX
        $.ajax({
            type: 'POST',
            url : '_Page/ReferensiDokter/IdPractitionerByNik.php',
            data: {nik : nik},
            success: function(data) {
                $('#FormCariPractitioner').html(data);
            },
            error: function(xhr){
                $('#FormCariPractitioner').html(
                    '<div class="text-danger text-center">' +
                    '<small>Terjadi kesalahan ('+xhr.status+')</small>' +
                    '</div>'
                );
            }
        });
    });

    // KETIKA NIK DI KETIK
    $(document).on('input', '#no_identitas', function(){

        let nik = $(this).val();

        if(nik && nik.trim() !== ''){
            $(this).removeClass('is-invalid');
            $('#error_nik').remove();
        }
    });


    // Submit Tambah Dokter
    $(document).on('submit', '#ProsesTambahDokter', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahDokter');
        let modal      = $('#ModalTambahDokter');
        let notifikasi = $('#NotifikasiTambahDokter');

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
            url        : '_Page/ReferensiDokter/ProsesTambahDokter.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    form[0].reset();

                    $('#kode').val(null).trigger('change');
                    $('#id_ihs_practitioner').val(null).trigger('change');
                    $('#kategori').val(null).trigger('change');
                    $('#kategori_identitas').val(null).trigger('change');

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Dokter berhasil',
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
                    TabelDokter();

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
    // DETAIL DOKTER
    //==================================================================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Google Credential
        var id_dokter = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailDokter').modal('show');

        // Loading Form
        $('#FormDetailDokter').html(`
            <div class="text-center p-3">
                <div class="spinner-border"></div>
            </div>
        `);

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiDokter/FormDetailDokter.php',
            data        : {id_dokter: id_dokter},
            success     : function(data){
                $('#FormDetailDokter').html(data);
            }
        });
    });

    //==================================================================
    // DETAIL PRACTITIONER
    //==================================================================
    $(document).on('click', '.modal_detail_ihs', function () {

        // Tangkap id
        var id_ihs_practitioner = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailPractitioner').modal('show');

        // Loading Form
        $('#FormDetailPractitioner').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiDokter/FormDetailPractitioner.php',
            data        : {id_ihs_practitioner: id_ihs_practitioner},
            success     : function(data){
                $('#FormDetailPractitioner').html(data);
            }
        });
    });

    //==================================================================
    // JADWAL DOKTER
    //==================================================================
    $(document).on('click', '.modal_jadwal', function () {

        // Tangkap id
        var id_dokter = $(this).data('id');

        // Munculkan Modal
        $('#ModalJadwalDokter').modal('show');

        // Loading Form
        $('#FormJadwalDokter').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiDokter/FormJadwalDokter.php',
            data        : {id_dokter: id_dokter},
            success     : function(data){
                $('#FormJadwalDokter').html(data);
            }
        });
    });
    
    //==================================================================
    // EDIT DOKTER
    //==================================================================
    $(document).on('click', '.modal_edit', function () {

        var id_dokter = $(this).data('id');

        $('#ModalEditDokter').modal('show');
        $('#NotifikasiEditDokter').html('');
        $('#FormEditDokter').html('Loading...');

        $.ajax({
            type : 'POST',
            url  : '_Page/ReferensiDokter/FormEditDokter.php',
            data : {id_dokter: id_dokter},

            success: function(data){
                $('#FormEditDokter').html(data);
            }
        });
    });

    // SAAT MODAL EDIT DIBUKA
    $('#ModalEditDokter').on('shown.bs.modal', function () {

        // INIT SELECT2 KODE
        $('#edit_kode').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ModalEditDokter'),
            tags: true,
            ajax: {
                url: '_Page/ReferensiDokter/GetKode.php',
                type: 'POST',
                dataType: 'json',
                delay: 200,
                data: params => ({
                    keyword: params.term,
                    page: params.page || 1
                }),
                processResults: data => ({
                    results: data.results || data
                })
            },
            createTag: buildManualTag,
            insertTag: prependManualTag
        });

        // PRESELECT KODE
        let oldKode = $('#old_kode').val();
        if (oldKode) {
            let option = new Option(oldKode, oldKode, true, true);
            $('#edit_kode').append(option).trigger('change');
        }

        // INIT SELECT2 KATEGORI
        $('#edit_kategori').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ModalEditDokter'),
            tags: true,
            ajax: {
                url: '_Page/ReferensiDokter/GetKategori.php',
                type: 'POST'
            },
            createTag: buildManualTag,
            insertTag: prependManualTag
        });

        // PRESELECT KATEGORI
        let oldKategori = $('#old_kategori').val();
        if (oldKategori) {
            let option = new Option(oldKategori, oldKategori, true, true);
            $('#edit_kategori').append(option).trigger('change');
        }
    });

    $(document).on('click', '.modal_cari_practitioner_edit', function () {

        let nik = $('#edit_no_identitas').val();

        $('#edit_no_identitas').removeClass('is-invalid');
        $('#error_nik_edit').remove();

        if (!nik) {
            $('#edit_no_identitas').addClass('is-invalid').after(
                '<div id="error_nik_edit" class="invalid-feedback">Isi NIK dulu</div>'
            );
            return;
        }

        $('#ModalCariPractitioner').modal('show');
        $('#FormCariPractitioner').html('Loading...');

        $.post('_Page/ReferensiDokter/IdPractitionerByNik.php', {nik}, function (res) {
            $('#FormCariPractitioner').html(res);
        });
    });

    // HANDLE SUBMIT EDIT DOKTER
    $(document).on('submit', '#ProsesEditDokter', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditDokter');
        let modal      = $('#ModalEditDokter');
        let notifikasi = $('#NotifikasiEditDokter');

        let buttonText = button.html();

        let formData = new FormData(this); // ✅ WAJIB

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url: '_Page/ReferensiDokter/ProsesEditDokter.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,   // ✅ WAJIB
            contentType: false,   // ✅ WAJIB

            success: function (response) {

                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    modal.modal('hide');
                    TabelDokter();

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Edit Dokter berhasil',
                        showConfirmButton: false,
                        timer: 1500
                    });

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

    //==================================================================
    // HAPUS DOKTER
    //==================================================================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap id
        var id_dokter = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusDokter').modal('show');

        // Loading Form
        $('#FormHapusDokter').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusDokter').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiDokter/FormHapusDokter.php',
            data        : {id_dokter: id_dokter},
            success     : function(data){
                $('#FormHapusDokter').html(data);
            }
        });
    });

    // Submit Hapus Akses Dokter
    $(document).on('submit', '#ProsesHapusDokter', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusDokter');
        let modal      = $('#ModalHapusDokter');
        let notifikasi = $('#NotifikasiHapusDokter');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ReferensiDokter/ProsesHapusDokter.php',
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
                        title            : 'Hapus Dokter Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelDokter();

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
