// Tabel Fitur
function TabelFitur() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_fitur');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/AksesFitur/TabelAksesFitur.php',
        data: ProsesFilter,
        success: function(data) {
            target.css('opacity', '0');

            setTimeout(function () {
                target.html(data)
                      .addClass('blur-loading')
                      .css('opacity', '1');

                setTimeout(function () {
                    target.removeClass('blur-loading');
                }, 200);
            }, 150);
        }
    });
}

// Tabel Pengguna
function TabelPengguna() {
    var FilterDaftarPengguna = $('#FilterDaftarPengguna').serialize();
    let target = $('#tabel_pengguna');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/AksesFitur/TabelPengguna.php',
        data: FilterDaftarPengguna,
        success: function(data) {
            target.css('opacity', '0');

            setTimeout(function () {
                target.html(data)
                      .addClass('blur-loading')
                      .css('opacity', '1');

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
    TabelFitur();

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesFitur/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelFitur();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelFitur(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelFitur(0);
    });

    // ====================================================================
    // TAMBAH FITUR AKSES
    // ====================================================================
    $('#ModalTambahFitur').on('shown.bs.modal', function () {
        // Auto Focus
        $('#nama_fitur').focus();

        // Hindari inisialisasi berulang
        if (!$('#kategori').hasClass("select2-hidden-accessible")) {
            $('#kategori').select2({
                theme             : 'bootstrap-5',
                placeholder       : 'Ketik atau pilih kategori',
                tags              : true,
                allowClear        : true,
                width             : '100%',
                dropdownParent    : $('#ModalTambahFitur'),

                ajax: {
                    url     : '_Page/AksesFitur/GetKategori.php',
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
                    let term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id       : term,
                        text     : term,
                        newOption: true
                    };
                }
            });
        }
    });

    // Generate Kode
    $(document).on('click', '#GenerateKode', function () {
        let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';

        for (let i = 0; i < 10; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        $('#kode').val(result);
    });

    // Submit Tambah Fitur
    $(document).on('submit', '#ProsesTambahFitur', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahFitur');
        let modal      = $('#ModalTambahFitur');
        let notifikasi = $('#NotifikasiTambahFitur');

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
            url      : '_Page/AksesFitur/ProsesTambahFitur.php',
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
                        title            : 'Tambah fitur akses berhasil',
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
                    TabelFitur();

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
    // DETAIL AKSES FITUR
    //==================================================================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Google Credential
        var id_akses_fitur = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailAksesFitur').modal('show');

        // Loading Form
        $('#FormDetailAksesFitur').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesFitur/FormDetailAksesFitur.php',
            data        : {id_akses_fitur: id_akses_fitur},
            success     : function(data){
                $('#FormDetailAksesFitur').html(data);
            }
        });
    });

    //==================================================================
    // DAFTAR PENGGUNA
    //==================================================================
    $(document).on('click', '.modal_akses_pengguna', function () {

        // Tangkap ID Google Credential
        var id_akses_fitur = $(this).data('id');

        // Munculkan Modal
        $('#ModalAksesPengguna').modal('show');

        // Auto Focus
        $('#keyword_pengguna').focus();

        // Tempelkan Halaman dan id_akses_fitur
        $('#page_pengguna').val('1');
        $('#put_id_akses_fitur').val(id_akses_fitur);

        // Tampilkan Data
        TabelPengguna();


    });

    // Submit Pencarian
    $(document).on('submit', '#FilterDaftarPengguna', function () {
        // Kembalikan Halaman
        $('#page_pengguna').val('1');

        // Tampilkan Data
        TabelPengguna();

    });

    // Pagging Pengguna
    $(document).on('click', '#next_page_pengguna', function() {
        var page_now = parseInt($('#page_pengguna').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_pengguna').val(next_page);
        TabelPengguna(0);
    });
    $(document).on('click', '#previous_page_pengguna', function() {
        var page_now = parseInt($('#page_pengguna').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_pengguna').val(next_page);
        TabelPengguna(0);
    });

    // HANDLE UBAH STATUS AKSES PENGGUNA
    $(document).on('click', '.ubah_status', function () {
        let button = $(this);

        let id_akses = button.data('id_akses');
        let id_akses_fitur = button.data('id_akses_fitur');
        let status = button.data('status');

        let buttonText = button.html();

        // Disable tombol yang dipilih + loading
        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            type: 'POST',
            url: '_Page/AksesFitur/ProsesUbahStatus.php',
            data: {
                id_akses: id_akses,
                id_akses_fitur: id_akses_fitur,
                status: status
            },
            dataType: 'JSON',
            success: function (response) {

                // Refresh tabel selalu
                TabelPengguna();
                
                // Tampilkan Ulang (Refresh Tabel)
                TabelFitur();

                // Jika gagal tampilkan toast
                if (response.success === false) {
                    showToast(response.message, 'danger');
                } else {
                    showToast(response.message, 'success');
                }
            },
            error: function () {
                TabelPengguna();
                showToast('Terjadi kesalahan pada server', 'danger');
            },
            complete: function () {
                button.prop('disabled', false);
                button.html(buttonText);
            }
        });
    });


    

    //==================================================================
    // EDIT AKSES FITUR
    //==================================================================
    $(document).on('click', '.modal_edit', function () {

        var id_akses_fitur = $(this).data('id');

        $('#ModalEditAksesFitur').modal('show');
        $('#NotifikasiEditAksesFitur').html('');
        $('#FormEditAksesFitur').html('Loading...');

        $.ajax({
            type : 'POST',
            url  : '_Page/AksesFitur/FormEditAksesFitur.php',
            data : {id_akses_fitur: id_akses_fitur},

            success: function(data){
                $('#FormEditAksesFitur').html(data);

                // Inisialisasi select2 setelah form tampil
                $('#kategori_edit').select2({
                    theme             : 'bootstrap-5',
                    placeholder       : 'Ketik atau pilih kategori',
                    tags              : true,
                    allowClear        : true,
                    width             : '100%',
                    dropdownParent    : $('#ModalEditAksesFitur'),

                    ajax: {
                        url     : '_Page/AksesFitur/GetKategori.php',
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
                                results: data.results || data
                            };
                        },

                        cache: true
                    },

                    createTag: function (params) {
                        let term = $.trim(params.term);

                        if (term === '') {
                            return null;
                        }

                        return {
                            id   : term,
                            text : term
                        };
                    }
                });
            }
        });
    });

    // Generate Kode
    $(document).on('click', '#GenerateKodeEdit', function () {
        let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';

        for (let i = 0; i < 10; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        $('#kode_edit').val(result);
    });

    // HANDLE SUBMIT EDIT AKSES FITUR
    $(document).on('submit', '#ProsesEditAksesFitur', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditAksesFitur');
        let modal      = $('#ModalEditAksesFitur');
        let notifikasi = $('#NotifikasiEditAksesFitur');

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
            url      : '_Page/AksesFitur/ProsesEditAksesFitur.php',
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
                    TabelFitur();

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit fitur akses berhasil',
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
    // HAPUS AKSES FITUR
    //==================================================================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap id
        var id_akses_fitur = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusAksesFitur').modal('show');

        // Loading Form
        $('#FormHapusAksesFitur').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusAksesFitur').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesFitur/FormHapusAksesFitur.php',
            data        : {id_akses_fitur: id_akses_fitur},
            success     : function(data){
                $('#FormHapusAksesFitur').html(data);
            }
        });
    });

    // Submit Hapus Akses Fitur
    $(document).on('submit', '#ProsesHapusAksesFitur', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusAksesFitur');
        let modal      = $('#ModalHapusAksesFitur');
        let notifikasi = $('#NotifikasiHapusAksesFitur');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/AksesFitur/ProsesHapusAksesFitur.php',
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
                        title            : 'Hapus Fitur Akses Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelFitur();

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