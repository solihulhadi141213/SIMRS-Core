// Tabel GeneralConsent
function TabelGeneralConsent() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_general_consent');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/GeneralConsent/TabelGeneralConsent.php',
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

// Menampilkan Data General Consent Berdasarkan ID Kunjungan
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

let signaturePadPasien = null;
let signaturePadPetugas = null;

// INIT SIGNATURE PAD
function initSignaturePad() {

    /// CANVAS PASIEN
    const canvasPasien = document.getElementById('signature-pad-pasien');

    if (canvasPasien) {

        signaturePadPasien = new SignaturePad(canvasPasien, {
            backgroundColor: 'rgb(255,255,255)'
        });

        resizeCanvas(canvasPasien, signaturePadPasien);

        // Clear
        $(document).off('click', '#clear-signature-pasien');

        $(document).on('click', '#clear-signature-pasien', function () {
            signaturePadPasien.clear();
        });
    }

    // CANVAS PETUGAS
    const canvasPetugas = document.getElementById('signature-pad-petugas');

    if (canvasPetugas) {

        signaturePadPetugas = new SignaturePad(canvasPetugas, {
            backgroundColor: 'rgb(255,255,255)'
        });

        resizeCanvas(canvasPetugas, signaturePadPetugas);

        // Clear
        $(document).off('click', '#clear-signature-petugas');

        $(document).on('click', '#clear-signature-petugas', function () {
            signaturePadPetugas.clear();
        });
    }
}

// RESIZE CANVAS
function resizeCanvas(canvas, signaturePad) {

    const ratio = Math.max(window.devicePixelRatio || 1, 1);

    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;

    canvas.getContext("2d").scale(ratio, ratio);

    signaturePad.clear();
}

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {

    // Hide Form View
    $('#form_view').hide();

    // Hide Detail View
    $('#detail_view').hide();

    // Show Data View
    $('#table_view').show();
    
    // Load Tabel
    TabelGeneralConsent();

     //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelGeneralConsent(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelGeneralConsent(0);
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
        TabelGeneralConsent();
    });

    // ===============================================================
    // DETAIL KUNJUNGAN & DETAIL PASIEN
    // ===============================================================

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

    // ===============================================================
    // MODAL GENERAL CONSENT
    // ===============================================================
    $(document).on('click', '.modal_general_consent', function () {
        
        // Tangkap id_pasien
        var id_kunjungan = $(this).data('id');

        // Loading Form
        $('#FormGeneralConsent').html('Loading...');

        // Show Modal
        $('#ModalGeneralConsent').modal('show');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/GeneralConsent/FormGeneralConsent.php',
            data        : {id_kunjungan : id_kunjungan},
            success     : function(data){
                $('#FormGeneralConsent').html(data);
            }
        });
    });

    // ===============================================================
    // BUAT GENERAL CONSENT
    // ===============================================================
    $(document).on('click', '.tambah_general_consent', function () {
        
        // Tangkap id_pasien
        var id_kunjungan = $(this).data('id');

        // Show Form View
        $('#form_view').show();

        // Hide Data View
        $('#table_view').hide();

        // Hide Detail View
        $('#detail_view').hide();

        // Hide Modal
        $('#ModalGeneralConsent').modal('hide');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahGeneralConsent').html('');

        // Tampilkan Form Tambah General Consent
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/GeneralConsent/FormTambahGeneralConsent.php',
            data        : {id_kunjungan : id_kunjungan},
            success     : function(data){
                $('#FormTambahGeneralConsent').html(data);

                // INIT SIGNATURE PAD
                initSignaturePad();
            }
        });
    });

    // HANDLE PERUBAHAN PENANDATANGAN
    $(document).on('change', 'input[name="penandatangan_tipe"]', function () {

        // Ambil value radio button
        let penandatangan_tipe = $(this).val();

        // Ambil id kunjungan & pasien
        let id_kunjungan = $('input[name="id_kunjungan"]').val();
        let id_pasien    = $('input[name="id_pasien"]').val();

        // Reset form terlebih dahulu
        $('#penandatangan_nama').val('');
        $('#penandatangan_nik').val('');

        // AJAX
        $.ajax({
            url: '_Page/GeneralConsent/penanggung_jawab.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id_kunjungan: id_kunjungan,
                id_pasien: id_pasien,
                penandatangan_tipe: penandatangan_tipe
            },
            beforeSend: function () {
                // Optional loading state
                $('#penandatangan_nama').prop('disabled', true);
                $('#penandatangan_nik').prop('disabled', true);
            },
            success: function (response) {
                // Jika sukses
                if (response.success == true) {
                    $('#penandatangan_nama').val(response.penandatangan_nama);
                    $('#penandatangan_nik').val(response.penandatangan_nik);
                } else {
                    // Jika gagal / data tidak ditemukan
                    $('#penandatangan_nama').val('');
                    $('#penandatangan_nik').val('');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Tidak Ditemukan',
                        text: response.message,
                        confirmButtonText: 'Tutup'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Tidak dapat mengambil data penanggung jawab.',
                    confirmButtonText: 'Tutup'
                });
            },
            complete: function () {
                // Aktifkan kembali form
                $('#penandatangan_nama').prop('disabled', false);
                $('#penandatangan_nik').prop('disabled', false);

            }
        });
    });

    // ===============================================================
    // SUBMIT TAMBAH GENERAL CONSENT
    // ===============================================================
    $(document).on('submit', '#ProsesTambahGeneralConsent', function (e) {

        e.preventDefault();

        // ===========================================================
        // AMBIL FORM DATA
        // ===========================================================
        let formData = new FormData(this);

        // ===========================================================
        // AMBIL TANDA TANGAN BASE64
        // ===========================================================
        if (signaturePadPasien) {
            formData.set(
                'penandatangan_ttd',
                signaturePadPasien.toDataURL()
            );
        }

        if (signaturePadPetugas) {
            formData.set(
                'petugas_edukasi_ttd',
                signaturePadPetugas.toDataURL()
            );
        }

        // ===========================================================
        // AJAX SUBMIT
        // ===========================================================
        $.ajax({
            url: '_Page/GeneralConsent/ProsesTambahGeneralConsent.php',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,

            beforeSend: function () {

                // Kosongkan notifikasi
                $('#NotifikasiTambahGeneralConsent').html('');

                // Disable button submit
                $('#ProsesTambahGeneralConsent button[type="submit"]')
                    .prop('disabled', true)
                    .html('<i class="spinner-border spinner-border-sm"></i> Menyimpan...');

            },

            success: function (response) {

                // ===================================================
                // SUCCESS
                // ===================================================
                if (response.status == 'success') {

                    // Toast Sweet Alert
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'General Consent berhasil dibuat',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    // Reset form
                    $('#ProsesTambahGeneralConsent')[0].reset();

                    // Clear signature pasien
                    if (signaturePadPasien) {
                        signaturePadPasien.clear();
                    }

                    // Clear signature petugas
                    if (signaturePadPetugas) {
                        signaturePadPetugas.clear();
                    }

                    // Kembali ke table view
                    $('#form_view').hide();
                    $('#detail_view').hide();
                    $('#table_view').show();

                    // Optional reload data
                    TabelGeneralConsent();

                } else {

                    // ===================================================
                    // FAILED
                    // ===================================================
                    $('#NotifikasiTambahGeneralConsent').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);

                }

            },

            error: function (xhr, status, error) {

                console.log(error);

                $('#NotifikasiTambahGeneralConsent').html(`
                    <div class="alert alert-danger">
                        <small>
                            Terjadi kesalahan pada server.
                        </small>
                    </div>
                `);

            },

            complete: function () {

                // Enable button submit
                $('#ProsesTambahGeneralConsent button[type="submit"]')
                    .prop('disabled', false)
                    .html('<i class="bi bi-save"></i> Simpan');

            }
        });

    });

    // ===============================================================
    // HAPUS GENERAL CONSENT
    // ===============================================================
    $(document).on('click', '.modal_hapus_general_consent', function () {
        
        // Tangkap id_general_consent
        var id_general_consent = $(this).data('id');

        // Show Modal
        $('#ModalHapusGeneralConsent').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusGeneralConsent').html('');

        // Loading Form
        $('#FormHapusGeneralConsent').html('');

        // Disable Button For First time
        $('#ButtonHapusGeneralConsent').prop('disabled', true);

        // Tampilkan Form Tambah General Consent
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/GeneralConsent/FormHapusGeneralConsent.php',
            data        : {id_general_consent : id_general_consent},
            success     : function(data){
                $('#FormHapusGeneralConsent').html(data);
            }
        });
    });

    // Submit Hapus General Consent
    $(document).on('submit', '#ProsesHapusGeneralConsent', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusGeneralConsent');
        let modal      = $('#ModalHapusGeneralConsent');
        let notifikasi = $('#NotifikasiHapusGeneralConsent');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/GeneralConsent/ProsesHapusGeneralConsent.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal Form Hapus
                    modal.modal('hide');

                    // Tutup Modal Detail
                    $('#ModalGeneralConsent').modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus General Consent Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelGeneralConsent();

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

    // ===============================================================
    // MODAL KIRIM CONSENT
    // ===============================================================
    $(document).on('click', '.modal_kirim_consent', function () {
        
        // Tangkap id_general_consent
        var id_general_consent = $(this).data('id');

        // Show Modal
        $('#ModalKirimConsent').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiKirimConsent').html('');

        // Loading Form
        $('#FormKirimConsent').html('');

        // Disable Button For First time
        $('#ButtonKirimConsent').prop('disabled', true);

        // Tampilkan Form Tambah General Consent
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/GeneralConsent/FormKirimConsent.php',
            data        : {id_general_consent : id_general_consent},
            success     : function(data){
                $('#FormKirimConsent').html(data);
            }
        });
    });

    // Submit Kirim Consent
    $(document).on('submit', '#ProsesKirimConsent', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonKirimConsent');
        let modal      = $('#ModalKirimConsent');
        let notifikasi = $('#NotifikasiKirimConsent');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/GeneralConsent/ProsesKirimConsent.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal Form Hapus
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Kirim Consent Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelGeneralConsent();

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

    $(document).on('click', '.modal_detail_consent', function () {
        
        // Tangkap id_general_consent
        var id_general_consent = $(this).data('id');

        // Show Modal
        $('#ModalDetailConsent').modal('show');

        // Loading Form
        $('#FormDetailConsent').html('');

        // Tampilkan Form Tambah General Consent
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/GeneralConsent/FormDetailConsent.php',
            data        : {id_general_consent : id_general_consent},
            success     : function(data){
                $('#FormDetailConsent').html(data);
            }
        });
    });

    // Click Kembali
    $(document).on('click', '.button_kembali', function () {
        
        // hide Form View
        $('#form_view').hide();

        // hide Detail View
        $('#detail_view').hide();

        // show Data View
        $('#table_view').show();

    });

});