// Tabel Akses
function TabelLaporanKesalahan() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_laporan_kesalahan');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/LaporanKesalahan/TabelLaporanKesalahan.php',
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

// Show Count Laporan Pengguna
function CountLaporanKesalahan() {

    // Loading
    $('#jumlah_semua').html('Loading...');
    $('#jumlah_terkirim').html('Loading...');
    $('#jumlah_dibaca').html('Loading...');
    $('#jumlah_selesai').html('Loading...');

    $('.dashboard_problem').html('');

    $.ajax({
        type    : 'POST',
        url     : '_Page/LaporanKesalahan/CountLaporanKesalahan.php',
        dataType: 'JSON',

        success: function(response) {

            // Validasi dasar
            if (!response || typeof response !== 'object') {
                showError('Response tidak valid dari server');
                return;
            }

            if (response.status !== 'success') {
                showError(response.message || 'Terjadi kesalahan');
                return;
            }

            if (!response.metadata) {
                showError('Metadata tidak ditemukan');
                return;
            }

            let semua    = response.metadata.semua ?? 0;
            let terkirim = response.metadata.terkirim ?? 0;
            let dibaca   = response.metadata.dibaca ?? 0;
            let selesai  = response.metadata.selesai ?? 0;

            // Set nilai
            $('#jumlah_semua').html(semua);
            $('#jumlah_terkirim').html(terkirim);
            $('#jumlah_dibaca').html(dibaca);
            $('#jumlah_selesai').html(selesai);
        },

        error: function(xhr, status, error) {
            showError('AJAX Error: ' + error);
        }
    });

    // Function tampilkan error
    function showError(message) {
        $('.dashboard_problem').html(`
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger">${message}</div>
                </div>
            </div>
        `);
    }
}

$(document).ready(function() {

    // Menampilkan Data Pertama Kali
    TabelLaporanKesalahan();
    CountLaporanKesalahan();

    // Ketika Dashboard Status Di Click
    $(document).on('click', '.filter_status', function () {

        let keyword_by = 'status';
        let keyword    = $(this).data('id') || '';

        // Normalisasi
        if (keyword.toLowerCase() === "semua") {
            keyword = "";
        }

        // Set value
        $('#keyword_by').val(keyword_by);
        $('#FormFilter').html('<input type="text" name="keyword" id="keyword" class="form-control" value="'+keyword+'">');

        // Reset pagination (opsional)
        if ($('#page').length) {
            $('#page').val(1);
        }

        // Reload data
        TabelLaporanKesalahan();
        CountLaporanKesalahan();

    });

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/LaporanKesalahan/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelLaporanKesalahan();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelLaporanKesalahan(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelLaporanKesalahan(0);
    });

    // ========================
    // DETAIL LAPORAN KESALAHAN
    // ========================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Google Credential
        var id_akses_laporan = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailLaporanKesalahan').modal('show');

        // Loading Form
        $('#FormDetailLaporanKesalahan').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/LaporanKesalahan/FormDetailLaporanKesalahan.php',
            data        : {id_akses_laporan: id_akses_laporan},
            success     : function(data){
                $('#FormDetailLaporanKesalahan').html(data);
            }
        });
    });

    // ==========================================
    // TANDAI SUDAH DIBACA
    // ==========================================
    $(document).on('click', '.modal_tandai_baca', function () {

        // Tangkap ID Google Credential
        var id_akses_laporan = $(this).data('id');

        // Munculkan Modal
        $('#ModalTandaiSudahDibaca').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiTandaiSudahDibaca').html('');

        // Loading Form
        $('#FormTandaiSudahDibaca').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/LaporanKesalahan/FormTandaiSudahDibaca.php',
            data        : {id_akses_laporan: id_akses_laporan},
            success     : function(data){
                $('#FormTandaiSudahDibaca').html(data);
            }
        });
    });

    // Submit Tandai Sudah Dibaca
    $(document).on('submit', '#ProsesTandaiSudahDibaca', function (e) {
        e.preventDefault();

        let form       = this;
        let formData   = new FormData(form); // ✅ pakai ini saja
        let button     = $('#ButtonTandaiSudahDibaca');
        let modal      = $('#ModalTandaiSudahDibaca');
        let notifikasi = $('#NotifikasiTandaiSudahDibaca');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url         : '_Page/LaporanKesalahan/ProsesTandaiSudahDibaca.php',
            type        : 'POST',
            data        : formData,
            processData : false, // WAJIB untuk FormData
            contentType : false, // WAJIB untuk FormData
            dataType    : 'json',

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    notifikasi.html('');

                    modal.modal('hide');

                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tandai Sudah Dibaca Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    TabelLaporanKesalahan();
                    CountLaporanKesalahan();

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

    // ==========================================
    // KIRIM RESPONSE
    // ==========================================
    
    // Global Quill
    let quillResponse = null;

    // Open Modal
    $(document).on('click', '.modal_response', function () {

        let id_akses_laporan = $(this).data('id');

        $('#ModalKirimResponse').modal('show');
        $('#NotifikasiKirimResponse').html('');
        $('#FormKirimResponse').html('Loading...');

        $.ajax({
            type: 'POST',
            url: '_Page/LaporanKesalahan/FormKirimResponse.php',
            data: { id_akses_laporan: id_akses_laporan },
            success: function (html) {

                $('#FormKirimResponse').html(html);

                // 🔥 DESTROY INSTANCE LAMA (PENTING!)
                if (quillResponse !== null) {
                    quillResponse = null;
                }

                // 🔥 INIT QUILL (PASTIKAN ELEMENT SUDAH ADA)
                setTimeout(() => {
                    const el = document.getElementById('quill_editor');

                    if (el) {
                        quillResponse = new Quill('#quill_editor', {
                            theme: 'snow',
                            placeholder: 'Tulis response disini...',
                            modules: {
                                toolbar: [
                                    [{ header: [1,2,3,false] }],
                                    ['bold','italic','underline'],
                                    ['link'],
                                    [{ list: 'ordered' }, { list: 'bullet' }]
                                ]
                            }
                        });
                    }
                }, 300);
            }
        });
    });


    // Submit Response
    $(document).on('submit', '#ProsesKirimResponse', function (e) {
        e.preventDefault();

        let form       = this;
        let button     = $('#ButtonKirimResponse');
        let modal      = $('#ModalKirimResponse');
        let notifikasi = $('#NotifikasiKirimResponse');

        let buttonText = button.html();
        notifikasi.html('');

        // 🔥 pastikan quill ada
        if (!quillResponse) {
            notifikasi.html(`
                <div class="alert alert-danger">
                    <small>Editor belum siap</small>
                </div>
            `);
            return;
        }

        // 🔥 ambil isi quill
        let html = quillResponse.root.innerHTML;

        // DEBUG (opsional, bantu cek)
        console.log('ISI QUILL:', html);

        // validasi
        if (html.trim() === '' || html === '<p><br></p>') {
            notifikasi.html(`
                <div class="alert alert-danger">
                    <small>Response tidak boleh kosong</small>
                </div>
            `);
            return;
        }

        // 🔥 SET VALUE DULU
        $('#response_hidden').val(html);

        // 🔥 BARU bikin FormData
        let formData = new FormData(form);

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url         : '_Page/LaporanKesalahan/ProsesKirimResponse.php',
            type        : 'POST',
            data        : formData,
            processData : false,
            contentType : false,
            dataType    : 'json',

            success: function (response) {

                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    modal.modal('hide');

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Response berhasil dikirim',
                        showConfirmButton: false,
                        timer: 1200
                    });

                    TabelLaporanKesalahan();
                    CountLaporanKesalahan();

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
                        <small>Terjadi kesalahan server</small>
                    </div>
                `);
            }
        });
    });

    // ==========================================
    // MODAL HAPUS LAPORAN KESALAHAN
    // ==========================================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID
        var id_akses_laporan = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusLaporanKesalahan').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusLaporanKesalahan').html('');

        // Loading Form
        $('#FormHapusLaporanKesalahan').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/LaporanKesalahan/FormHapusLaporanKesalahan.php',
            data        : {id_akses_laporan: id_akses_laporan},
            success     : function(data){
                $('#FormHapusLaporanKesalahan').html(data);
            }
        });
    });

    // Submit Hapus
    $(document).on('submit', '#ProsesHapusLaporanKesalahan', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusLaporanKesalahan');
        let modal      = $('#ModalHapusLaporanKesalahan');
        let notifikasi = $('#NotifikasiHapusLaporanKesalahan');

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
            url      : '_Page/LaporanKesalahan/ProsesHapusLaporanKesalahan.php',
            type     : 'POST',
            data     : formData,
            dataType : 'json',

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
                        title            : 'Hapus Laporan Pengguna Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang Tabel Tanpa Reset Filter
                    TabelLaporanKesalahan();
                    CountLaporanKesalahan();

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
});