// ====================================================================
// FUNCTION BLOCK
// Semua Function Jquery/Javascript Di Tulias Pada Block Ini
// ====================================================================

// Tabel Encounter
function TabelEncounter() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_encounter');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Encounter/TabelEncounter.php',
        data: ProsesFilter,
        success: function (data) {
            let wrapper     = $('<div>').html(data);
            let rowHtml     = wrapper.find('tr');
            let firstRow    = rowHtml.first();
            let pageCount   = parseInt(firstRow.attr('data-page-count'), 10);
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

// Function Export
const modalExportEncounter = $('#ModalExport');

function currentYearEncounter() {
    return new Date().getFullYear();
}

function buildExportLanjutan(periode) {
    const year = currentYearEncounter();
    if (periode === 'Semua') {
        $('#FormLanjutanExport').empty();
        return;
    }
    if (periode === 'Tahun') {
        $('#FormLanjutanExport').html(
            '<div class="row mb-3">' +
                '<div class="col-12">' +
                    '<label><small>Tahun</small></label>' +
                    '<input type="number" name="tahun" id="tahun_export" class="form-control" value="' + year + '" min="2000" max="2100">' +
                '</div>' +
            '</div>'
        );
        return;
    }
    if (periode === 'Bulan') {
        let options = '';
        const names = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        for (let m = 1; m <= 12; m++) {
            const val = String(m).padStart(2, '0');
            options += '<option value="' + val + '">' + names[m - 1] + '</option>';
        }
        $('#FormLanjutanExport').html(
            '<div class="row mb-3">' +
                '<div class="col-12">' +
                    '<label><small>Tahun</small></label>' +
                    '<input type="number" name="tahun" id="tahun_export" class="form-control" value="' + year + '" min="2000" max="2100">' +
                '</div>' +
            '</div>' +
            '<div class="row mb-3">' +
                '<div class="col-12">' +
                    '<label><small>Bulan</small></label>' +
                    '<select name="bulan" id="bulan_export" class="form-control">' + options + '</select>' +
                '</div>' +
            '</div>'
        );
        return;
    }
    if (periode === 'Periodik') {
        $('#FormLanjutanExport').html(
            '<div class="row mb-3">' +
                '<div class="col-6">' +
                    '<label><small>Periode Awal</small></label>' +
                    '<input type="date" name="periode_awal" id="periode_awal_export" class="form-control">' +
                '</div>' +
                '<div class="col-6">' +
                    '<label><small>Periode Akhir</small></label>' +
                    '<input type="date" name="periode_akhir" id="periode_akhir_export" class="form-control">' +
                '</div>' +
            '</div>'
        );
        return;
    }
    $('#FormLanjutanExport').empty();
}

function countExportEncounter() {
    const periode = $('#periode_data').val() || 'Semua';
    const data = { mode: 'count', periode_data: periode };
    $('#FormLanjutanExport').find('input, select').each(function () {
        if (this.name) {
            data[this.name] = $(this).val();
        }
    });
    $.ajax({
        type    : 'POST',
        url     : '_Page/Encounter/ProsesExport.php',
        data    : data,
        dataType: 'json'
    }).done(function (response) {
        const jumlah = response && typeof response.jumlah !== 'undefined' ? parseInt(response.jumlah, 10) : 0;
        if (jumlah > 0) {
            $('#NotifikasiJumlahData').html('<div class="alert alert-info mb-0"><small>Jumlah data encounter yang akan diexport: <b>' + jumlah + '</b></small></div>');
            $('#ButtonExport').prop('disabled', false);
        } else {
            $('#NotifikasiJumlahData').html('<div class="alert alert-warning mb-0"><small>Tidak ada data encounter pada periode tersebut.</small></div>');
            $('#ButtonExport').prop('disabled', true);
        }
    }).fail(function () {
        $('#NotifikasiJumlahData').html('<div class="alert alert-danger mb-0"><small>Gagal menghitung jumlah data encounter.</small></div>');
        $('#ButtonExport').prop('disabled', true);
    });
}

    

// ====================================================================
// EVENT BLOCK
// Semua Script Javascript / Jquery Event Handler Ditulis Disini
// ====================================================================
$(document).ready(function () {
    // Load Tabel Pada Saat Pertama Kali
    TabelEncounter();

    //Pagging
    $(document).on('click', '#next_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelEncounter(0);
    });
    $(document).on('click', '#previous_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelEncounter(0);
    });

    // Auto Focus Keyword
    $('#ModalFilter').on('shown.bs.modal', function () {
        $('#keyword_form').focus();
    });

    // Keyword By
    $('#keyword_by').change(function () {
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type: 'POST',
            url: '_Page/Encounter/FormFilter.php',
            data: { keyword_by: keyword_by },
            success: function (data) {
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Pencarian Kunjungan
    $('#ProsesFilter').submit(function () {

        // Reset Page
        $('#page_filter').val('1');

        // Hidden Modal
        $('#ModalFilter').modal('hide');

        // Reload Function
        TabelEncounter();
    });

    // ==============================
    // DETAIL PASIEN
    // ==============================
    $(document).on('click', '.modal_detail_pasien', function () {

        // Tangkap id_pasien
        var id_pasien = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailPasien').modal('show');

        // Loading Form
        $('#FormDetailPasien').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Pasien/FormDetail.php',
            data: { id_pasien: id_pasien },
            success: function (data) {
                $('#FormDetailPasien').html(data);
            }
        });
    });

    // ==============================
    // DETAIL IHS
    // ==============================
    $(document).on('click', '.modal_detail_ihs', function () {

        // Tangkap id_ihs
        var id_ihs = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailIhs').modal('show');

        // Loading Form
        $('#FormDetailIhs').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Pasien/FormDetailIhs.php',
            data: { id_ihs: id_ihs },
            success: function (data) {
                $('#FormDetailIhs').html(data);
            }
        });
    });

    // ==============================
    // DETAIL KUNJUNGAN
    // ==============================
    $(document).on('click', '.modal_detail_kunjungan', function () {

        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailKunjungan').modal('show');

        // Loading Form
        $('#FormDetailKunjungan').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Kunjungan/FormDetailKunjungan.php',
            data: { id_kunjungan: id_kunjungan },
            success: function (data) {
                $('#FormDetailKunjungan').html(data);
            }
        });
    });

    // ==============================
    // TAMBAH ENCOUNTER
    // ==============================
    $(document).on('click', '.modal_tambah', function () {

        // AMBIL ID KUNJUNGAN
        const id_kunjungan = $(this).data('id');

        // VALIDASI ID KUNJUNGAN
        if (!id_kunjungan) {
            showToast('error', 'ID Kunjungan tidak ditemukan');
            return;
        }

        // TAMPILKAN MODAL
        $('#ModalTambah').modal('show');

        // Ketika Modal Muncul, Disable button dulu
        $("#ButtonTambah").prop("disabled", true);

        // RESET FORM DAN NOTIFIKASI
        $('#FormTambah').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 text-muted small">
                    Memuat form...
                </div>
            </div>
        `);

        $('#NotifikasiTambah').html('');

        // REQUEST AJAX
        $.ajax({
            type    : 'POST',
            url     : '_Page/Encounter/FormTambah.php',
            data    : {id_kunjungan: id_kunjungan},
            dataType: 'JSON',
            timeout : 30000,
            success : function (response) {

                // Buat variabel response agar lebih ringkas saat digunakan
                var status   = response.status;
                var message  = response.message;
                var htmlForm = response.htmlForm;

                // Tampilkan seluruh syarat validasi dari response server
                if (status === 'success' || status === 'validation_error') {

                    // Pengiriman hanya dapat dilakukan jika seluruh syarat validasi terpenuhi
                    $("#ButtonTambah").prop("disabled", status !== 'success');

                    // Kosongkan Notifikasi
                    $('#NotifikasiTambah').html('');

                    // Tempelkan Komponen HTML ke Form
                    $('#FormTambah').html(htmlForm);
                } else {
                    // Tampilkan error request yang bukan hasil validasi syarat
                    $('#FormTambah').html(
                        `
                            <div class="alert alert-danger">
                                <small>
                                    <b>Opsss!</b><br>
                                    <small>${message}</small>
                                </small>
                            </div>
                        `
                    );
                }
            },
            error: function (xhr, status, error) {

                // ERROR AJAX
                let message = 'Terjadi kesalahan saat memuat form.';
                if (status === 'timeout') {
                    message = 'Request timeout. Silakan coba kembali.';
                } else if (status === 'parsererror') {
                    message = 'Response server bukan JSON yang valid.';
                } else if (xhr.status === 404) {
                    message = 'File FormTambah.php tidak ditemukan.';
                } else if (xhr.status === 500) {
                    message = 'Terjadi kesalahan internal server.';
                } else if (status === 'abort') {
                    return;
                }

                $('#FormTambah').html('');
                $('#NotifikasiTambah').html(`
                    <div class="alert alert-danger text-canger alert-dismissible fade show" role="alert">
                        <b>OPSS!</b>
                        <small>${message}</small>
                    </div>
                `);
                console.error('AJAX FormTambah Error:', {
                    status  : status,
                    error   : error,
                    httpCode: xhr.status,
                    response: xhr.responseText
                });
            }
        });
    });


    // Handdle Submit Referensi Encounter
    $(document).on('submit', '#ProsesTambah', function (e) {
        e.preventDefault();

        let button     = $('#ButtonTambah');
        let modal      = $('#ModalTambah');
        let notifikasi = $('#NotifikasiTambah');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/Encounter/ProsesTambah.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'JSON',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Pengiriman Encounter SATUSEHAT Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEncounter();

                } else {

                    // Tampilkan error
                    notifikasi.html('<div class="alert alert-danger"><small></small></div>');
                    notifikasi.find('small').text(response.message || 'Pengiriman Encounter gagal.');
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

    // ==============================
    // DETAIL
    // ==============================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap id_encounter
        var id_encounter = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Encounter/FormDetail.php',
            data: { id_encounter: id_encounter },
            success: function (data) {
                $('#FormDetail').html(data);
            }
        });
    });

    // ==============================
    // EDIT ENCOUNTER
    // ==============================
    $(document).on('click', '.modal_edit', function () {

        // AMBIL id_encounter
        const id_encounter = $(this).data('id');

        // VALIDASI ID Encounter
        if (!id_encounter) {
            showToast('error', 'ID Encounter tidak ditemukan');
            return;
        }

        // TAMPILKAN MODAL
        $('#ModalEdit').modal('show');

        // Ketika Modal Muncul, Disable button dulu
        $("#ButtonEdit").prop("disabled", true);

        // RESET FORM DAN NOTIFIKASI
        $('#FormEdit').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 text-muted small">
                    Memuat form...
                </div>
            </div>
        `);

        $('#NotifikasiEdit').html('');

        // REQUEST AJAX
        $.ajax({
            type    : 'POST',
            url     : '_Page/Encounter/FormEdit.php',
            data    : {id_encounter: id_encounter},
            dataType: 'JSON',
            timeout : 30000,
            success : function (response) {

                // Buat variabel response agar lebih ringkas saat digunakan
                var status   = response.status;
                var message  = response.message;
                var htmlForm = response.htmlForm;

                // Tampilkan seluruh syarat validasi dari response server
                if (status === 'success' || status === 'validation_error') {

                    // Pengiriman hanya dapat dilakukan jika seluruh syarat validasi terpenuhi
                    $("#ButtonEdit").prop("disabled", status !== 'success');

                    // Kosongkan Notifikasi
                    $('#NotifikasiEdit').html('');

                    // Tempelkan Komponen HTML ke Form
                    $('#FormEdit').html(htmlForm);
                } else {
                    // Tampilkan error request yang bukan hasil validasi syarat
                    $('#FormEdit').html('<div class="alert alert-danger"><small></small></div>');
                    $('#FormEdit').find('small').text(message || 'Form edit Encounter gagal dimuat.');
                }
            },
            error: function (xhr, status, error) {

                // ERROR AJAX
                let message = 'Terjadi kesalahan saat memuat form.';
                if (status === 'timeout') {
                    message = 'Request timeout. Silakan coba kembali.';
                } else if (status === 'parsererror') {
                    message = 'Response server bukan JSON yang valid.';
                } else if (xhr.status === 404) {
                    message = 'File FormEdit.php tidak ditemukan.';
                } else if (xhr.status === 500) {
                    message = 'Terjadi kesalahan internal server.';
                } else if (status === 'abort') {
                    return;
                }

                $('#FormEdit').html('');
                $('#NotifikasiEdit').html('<div class="alert alert-danger text-canger alert-dismissible fade show" role="alert"><b>OPSS!</b> <small></small></div>');
                $('#NotifikasiEdit').find('small').text(message);
                console.error('AJAX Form Edit Error:', {
                    status  : status,
                    error   : error,
                    httpCode: xhr.status,
                    response: xhr.responseText
                });
            }
        });
    });


    // Handdle Submit Proses Edit
    $(document).on('submit', '#ProsesEdit', function (e) {
        e.preventDefault();

        let button     = $('#ButtonEdit');
        let modal      = $('#ModalEdit');
        let notifikasi = $('#NotifikasiEdit');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/Encounter/ProsesEdit.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'JSON',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Perubahan Encounter SATUSEHAT Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEncounter();

                } else {

                    // Tampilkan error
                    notifikasi.html('<div class="alert alert-danger"><small></small></div>');
                    notifikasi.find('small').text(response.message || 'Pengiriman Encounter gagal.');
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


    //------------------------------------
    // EXPORT DATA
    //------------------------------------
    // Saat modal export muncul pertama kali
    modalExportEncounter.on('shown.bs.modal', function () {
        $('#periode_data').val('Semua');
        buildExportLanjutan('Semua');
        countExportEncounter();
    });

    // Saat periode_data diubah
    $(document).on('change', '#periode_data', function () {
        const periode = $(this).val();
        buildExportLanjutan(periode);
        countExportEncounter();
    });

    // Hitung ulang saat input lanjutan berubah
    $(document).on('change', '#FormLanjutanExport input, #FormLanjutanExport select', function () {
        countExportEncounter();
    });

});
    

    
