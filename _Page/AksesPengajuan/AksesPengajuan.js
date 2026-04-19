// Tabel Akses
function TabelAksesPengajuan() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_akses_pengajuan');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/AksesPengajuan/TabelAksesPengajuan.php',
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

// Show Count Pengajuan Akses
function CountPengajuanAkses() {

    // Loading
    $('#jumlah_total').html('Loading...');
    $('#jumlah_pending').html('Loading...');
    $('#jumlah_ditolak').html('Loading...');
    $('#jumlah_diterima').html('Loading...');

    $('.dashboard_problem').html('');

    $.ajax({
        type    : 'POST',
        url     : '_Page/AksesPengajuan/CountPengajuanAkses.php',
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

            let total    = response.metadata.total ?? 0;
            let pending  = response.metadata.pending ?? 0;
            let ditolak  = response.metadata.ditolak ?? 0;
            let diterima = response.metadata.diterima ?? 0;

            // Set nilai
            $('#jumlah_total').html(total);
            $('#jumlah_pending').html(pending);
            $('#jumlah_ditolak').html(ditolak);
            $('#jumlah_diterima').html(diterima);
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
    TabelAksesPengajuan();
    CountPengajuanAkses();

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
        TabelAksesPengajuan();
        CountPengajuanAkses();

    });

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesPengajuan/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelAksesPengajuan();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelAksesPengajuan(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelAksesPengajuan(0);
    });

    // ========================
    // DETAIL AKSES PENGAJUAN
    // ========================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Google Credential
        var id_akses_pengajuan = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailAksesPengajuan').modal('show');

        // Loading Form
        $('#FormDetailAksesPengajuan').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesPengajuan/FormDetailAksesPengajuan.php',
            data        : {id_akses_pengajuan: id_akses_pengajuan},
            success     : function(data){
                $('#FormDetailAksesPengajuan').html(data);
            }
        });
    });

    // ==========================================
    // HUBUNGKAN AKUN
    // ==========================================
    $(document).on('click', '.modal_hubungkan_akun', function () {

        // Tangkap ID Google Credential
        var id_akses_pengajuan = $(this).data('id');

        // Munculkan Modal
        $('#ModalHubungkanAkun').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHubungkanAkun').html('');

        // Loading Form
        $('#FormHubungkanAkun').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesPengajuan/FormHubungkanAkun.php',
            data        : {id_akses_pengajuan: id_akses_pengajuan},
            success     : function(data){
                $('#FormHubungkanAkun').html(data);
            }
        });
    });
    
    // Inisiaslisasai Select2 Untuk id_akses
    $(document).on('shown.bs.modal', '#ModalHubungkanAkun', function () {

        $('#id_akses').select2({
            theme         : 'bootstrap-5',
            dropdownParent: $('#FormHubungkanAkun'),
            width         : '100%',
            placeholder   : 'Pilih atau cari akun...',
            allowClear    : true,

            ajax: {
                url: '_Page/AksesPengajuan/SearchAkses.php',
                type: 'POST',
                dataType: 'json',
                delay: 250,

                data: function (params) {
                    return {
                        search: params.term || '', // kosong tetap kirim
                        page: params.page || 1
                    };
                },

                processResults: function (response) {
                    return {
                        results: response.results,
                        pagination: {
                            more: response.pagination.more
                        }
                    };
                },

                cache: true
                
            },

            templateResult: function (data) {
                if (!data.id) return data.text;

                return $(`
                    <div>
                        <div><strong>${data.text.split(' - ')[0]}</strong></div>
                        <small class="text-muted">${data.text.split(' - ')[1]}</small>
                    </div>
                `);
            },
            templateSelection: function (data) {
                return data.text;
            }
        });

    });

    // Submit Hubungkan Akun
    $(document).on('submit', '#ProsesHubungkanAkun', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHubungkanAkun');
        let modal      = $('#ModalHubungkanAkun');
        let notifikasi = $('#NotifikasiHubungkanAkun');

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
            url      : '_Page/AksesPengajuan/ProsesHubungkanAkun.php',
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
                        title            : 'Hubungkan Akun Pengguna Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang Tabel Tanpa Reset Filter
                    TabelAksesPengajuan();
                    CountPengajuanAkses();

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

    // ==========================================
    // EDIT PENGAJUAN AKSES
    // ==========================================
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID Google Credential
        var id_akses_pengajuan = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditPengajuanAkses').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEditPengajuanAkses').html('');

        // Loading Form
        $('#FormEditPengajuanAkses').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesPengajuan/FormEditPengajuanAkses.php',
            data        : {id_akses_pengajuan: id_akses_pengajuan},
            success     : function(data){
                $('#FormEditPengajuanAkses').html(data);

                // Trigger hitung awal
                $('#alamat_edit').trigger('input');
                $('#deskripsi_edit').trigger('input');
            }
        });
    });

    // CHARACTER COUNTER
    function updateCounter(el, target, max) {
        let length = el.val().length;

        target.text(`(${length} / ${max})`);

        if (length > max * 0.8) {
            target.removeClass().addClass('text-warning');
        } else {
            target.removeClass().addClass('text-muted');
        }

        if (length >= max) {
            target.removeClass().addClass('text-danger');
        }
    }

    // alamat
    $(document).on('input', '#alamat_edit', function () {
        updateCounter($(this), $('#jumlah_karakter_alamat'), 200);
    });

    // deskripsi
    $(document).on('input', '#deskripsi_edit', function () {
        updateCounter($(this), $('#jumlah_karakter_deskripsi'), 200);
    });

    // Submit Pengajuan Akses
    $(document).on('submit', '#ProsesEditPengajuanAkses', function (e) {
        e.preventDefault();

        let form       = this;
        let formData   = new FormData(form); // ✅ pakai ini saja
        let button     = $('#ButtonEditPengajuanAkses');
        let modal      = $('#ModalEditPengajuanAkses');
        let notifikasi = $('#NotifikasiEditPengajuanAkses');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url         : '_Page/AksesPengajuan/ProsesEditPengajuanAkses.php',
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
                        title            : 'Update Pengajuan Akses Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    TabelAksesPengajuan();
                    CountPengajuanAkses();

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
    // TERIMA/TOLAK
    // ==========================================
    $(document).on('click', '.modal_terima_tolak', function () {

        // Tangkap ID Google Credential
        var id_akses_pengajuan = $(this).data('id');

        // Munculkan Modal
        $('#ModalTerimaTolakPengajuan').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiTerimaTolakPengajuan').html('');

        // Loading Form
        $('#FormTerimaTolakPengajuan').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesPengajuan/FormTerimaTolakPengajuan.php',
            data        : {id_akses_pengajuan: id_akses_pengajuan},
            success     : function(data){
                $('#FormTerimaTolakPengajuan').html(data);
            }
        });
    });

    // Saat Modal Muncul Disable tombol submit
    $(document).on('shown.bs.modal', '#ModalTerimaTolakPengajuan', function () {
        $('#ButtonTerimaTolakPengajuan').prop('disabled', true);
    });

    // Handdle Perubahan Status
    $(document).on('change', '#status_pengajuan', function () {
        // Tangkap Status
        let status = $(this).val();

        // Reset dulu
        $('#form_lanjutan').html('');
        
        // Routing Akses Diterima / Ditolak
        if (status === 'Diterima') {
            $('#form_lanjutan').load('_Page/AksesPengajuan/FormAksesDiterima.php');
        } else if (status === 'Ditolak') {
            $('#form_lanjutan').load('_Page/AksesPengajuan/FormAksesDitolak.php');
        }

        // Enable tombol jika sudah pilih
        if (status) {
            $('#ButtonTerimaTolakPengajuan').prop('disabled', false);
        } else {
            $('#ButtonTerimaTolakPengajuan').prop('disabled', true);
        }

    });

    // Generate Password
    $(document).on('click', '#GeneratePassword', function () {

        let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let password = '';

        for (let i = 0; i < 8; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        $('#password_pengguna').val(password);

    });

    // Submit Update Status Permintaan
    $(document).on('submit', '#ProsesTerimaTolakPengajuan', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTerimaTolakPengajuan');
        let modal      = $('#ModalTerimaTolakPengajuan');
        let notifikasi = $('#NotifikasiTerimaTolakPengajuan');

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
            url      : '_Page/AksesPengajuan/ProsesTerimaTolakPengajuan.php',
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
                        title            : 'Update Status Pengajuan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang Tabel Tanpa Reset Filter
                    TabelAksesPengajuan();
                    CountPengajuanAkses();

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

    // ==========================================
    // MODAL HAPUS PENGAJUAN AKSES
    // ==========================================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID Google Credential
        var id_akses_pengajuan = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusPengajuanAkses').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusPengajuanAkses').html('');

        // Loading Form
        $('#FormHapusPengajuanAkses').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesPengajuan/FormHapusPengajuanAkses.php',
            data        : {id_akses_pengajuan: id_akses_pengajuan},
            success     : function(data){
                $('#FormHapusPengajuanAkses').html(data);
            }
        });
    });

    // Submit Hapus Akses
    $(document).on('submit', '#ProsesHapusPengajuanAkses', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusPengajuanAkses');
        let modal      = $('#ModalHapusPengajuanAkses');
        let notifikasi = $('#NotifikasiHapusPengajuanAkses');

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
            url      : '_Page/AksesPengajuan/ProsesHapusPengajuanAkses.php',
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
                        title            : 'Hapus Pengajuan Akses Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang Tabel Tanpa Reset Filter
                    TabelAksesPengajuan();
                    CountPengajuanAkses();

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