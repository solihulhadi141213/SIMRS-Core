$(document).ready(function () {
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

    

    // ====================================================================
    // EVENT BLOCK
    // Semua Script Javascript / Jquery Event Handler Ditulis Disini
    // ====================================================================

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
    // TAMBAH IMUNISASI
    // ==============================

    // Ketika Modal Tambah Muncul
    $('#ModalTambah').on('shown.bs.modal', function () {

        // Fokus otomatis 'id_pasien'
        $('#id_pasien').focus();

        // Isi tanggal dan jam pemberian dengan waktu sekarang (sesuai timezone user)
        $.ajax({
            type: 'GET',
            url: '_Page/Encounter/datetime_now.php',
            dataType: 'json',
            success: function (response) {
                if (response && response.status === 'success') {
                    if (response.tanggal) {
                        $('#tanggal_pemberian').val(response.tanggal);
                    }
                    if (response.jam) {
                        $('#jam_pemberian').val(response.jam);
                    }
                }
            }
        });

    });

    // Handdle Submit Referensi Imunisasi
    $(document).on('submit', '#ProsesTambah', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambah');
        let modal = $('#ModalTambah');
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
            url: '_Page/Encounter/ProsesTambah.php',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Reset form
                    $('#ProsesTambah')[0].reset();

                    // Reset Select2
                    $('#id_pasien').val(null).trigger('change');
                    $('#id_kunjungan').val(null).trigger('change');
                    $('#id_imunisasi_referensi').val(null).trigger('change');
                    $('#id_body_site').val(null).trigger('change');
                    $('#id_praktisi').val(null).trigger('change');

                    // Reset preview body site
                    $('#body_site_preview').html('');


                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tambah Referensi Imunisasi Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    // Reset Filter Kembali Ke halaman 1 (Belulum)
                    $('#ProsesFilter')[0].reset();
                    $('#page_filter').val(1);

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEncounter();

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

    // ==============================
    // DETAIL
    // ==============================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap id_imunisasi
        var id_imunisasi = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Encounter/FormDetail.php',
            data: { id_imunisasi: id_imunisasi },
            success: function (data) {
                $('#FormDetail').html(data);
            }
        });
    });

    // ==============================
    // EDIT
    // ==============================
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID
        var id_imunisasi = $(this).data('id');

        // Munculkan Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Encounter/FormEdit.php',
            data: { id_imunisasi: id_imunisasi },
            success: function (data) {
                $('#FormEdit').html(data);
                InitSelect2FormEdit();
            }
        });
    });

    // Handdle Submit Edit Referensi Tindakan
    $(document).on('submit', '#ProsesEdit', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonEdit');
        let modal = $('#ModalEdit');
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
            url: '_Page/Encounter/ProsesEdit.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
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
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Edit Imunisasi Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEncounter();

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

    // ==============================
    // HAPUS
    // ==============================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID dan Kategori
        var id_imunisasi = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Encounter/FormHapus.php',
            data: { id_imunisasi: id_imunisasi },
            success: function (data) {
                $('#FormHapus').html(data);
            }
        });
    });

    // Handdle Submit Hapus Referensi Tindakan
    $(document).on('submit', '#ProsesHapus', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapus');
        let modal      = $('#ModalHapus');
        let notifikasi = $('#NotifikasiHapus');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/Encounter/ProsesHapus.php',
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

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Hapus Imunisasi Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEncounter();

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

    // ==============================
    // HAPUS
    // ==============================

});
    //------------------------------------
    // EXPORT DATA IMUNISASI
    //------------------------------------
    const modalExportImunisasi = $('#ModalExport');

    function currentYearImunisasi() {
        return new Date().getFullYear();
    }

    function buildExportLanjutan(periode) {
        const year = currentYearImunisasi();
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

    function countExportImunisasi() {
        const periode = $('#periode_data').val() || 'Semua';
        const data = { mode: 'count', periode_data: periode };
        $('#FormLanjutanExport').find('input, select').each(function () {
            if (this.name) {
                data[this.name] = $(this).val();
            }
        });
        $.ajax({
            type: 'POST',
            url: '_Page/Encounter/ProsesExport.php',
            data: data,
            dataType: 'json'
        }).done(function (response) {
            const jumlah = response && typeof response.jumlah !== 'undefined' ? parseInt(response.jumlah, 10) : 0;
            if (jumlah > 0) {
                $('#NotifikasiJumlahData').html('<div class="alert alert-info mb-0"><small>Jumlah data imunisasi yang akan diexport: <b>' + jumlah + '</b></small></div>');
                $('#ButtonExport').prop('disabled', false);
            } else {
                $('#NotifikasiJumlahData').html('<div class="alert alert-warning mb-0"><small>Tidak ada data imunisasi pada periode tersebut.</small></div>');
                $('#ButtonExport').prop('disabled', true);
            }
        }).fail(function () {
            $('#NotifikasiJumlahData').html('<div class="alert alert-danger mb-0"><small>Gagal menghitung jumlah data imunisasi.</small></div>');
            $('#ButtonExport').prop('disabled', true);
        });
    }

    // Saat modal export muncul pertama kali
    modalExportImunisasi.on('shown.bs.modal', function () {
        $('#periode_data').val('Semua');
        buildExportLanjutan('Semua');
        countExportImunisasi();
    });

    // Saat periode_data diubah
    $(document).on('change', '#periode_data', function () {
        const periode = $(this).val();
        buildExportLanjutan(periode);
        countExportImunisasi();
    });

    // Hitung ulang saat input lanjutan berubah
    $(document).on('change', '#FormLanjutanExport input, #FormLanjutanExport select', function () {
        countExportImunisasi();
    });


