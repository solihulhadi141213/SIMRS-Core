// Fungsi untuk menampilkan Data
function TabelJadwalDokter(Hari) {
    
    let target = $('#tabel_jadwal_dokter');

    target.addClass('blur-loading');

    $.ajax({
        type   : 'POST',
        url    : '_Page/ReferensiJadwalDokter/TabelJadwalDokter.php',
        data   : {Hari: Hari},
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

// Fungsi untuk Menghiutng Jadwal Pada Masing-masing Hari
function calculate_jadwal_by_day() {

    // Loading
    $('.pilih_hari').html('...');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiJadwalDokter/CalculateJadwal.php',
        dataType: 'text', // ⛔ jangan langsung JSON, kita validasi manual

        success: function (res) {

            let response;

            // ✅ VALIDASI JSON
            try {
                response = JSON.parse(res);
            } catch (e) {
                console.error('Response bukan JSON:', res);

                $('#show_error_notification').html(`
                    <div class="alert alert-danger">
                        <small>Response tidak valid (bukan JSON)</small>
                    </div>
                `);

                $('.pilih_hari').html('Error');
                return;
            }

            // ✅ VALIDASI STRUKTUR
            if (!response || response.status !== 'success' || !response.metadata) {
                $('#show_error_notification').html(`
                    <div class="alert alert-danger">
                        <small>Format response tidak sesuai</small>
                    </div>
                `);
                $('.pilih_hari').html('Error');
                return;
            }

            let m = response.metadata;

            $('#button_senin').html(`Senin (${m.Senin})`);
            $('#button_selasa').html(`Selasa (${m.Selasa})`);
            $('#button_rabu').html(`Rabu (${m.Rabu})`);
            $('#button_kamis').html(`Kamis (${m.Kamis})`);
            $('#button_jumat').html(`Jumat (${m.Jumat})`);
            $('#button_sabtu').html(`Sabtu (${m.Sabtu})`);
            $('#button_minggu').html(`Minggu (${m.Minggu})`);
        },

        error: function (xhr) {
            console.error('AJAX ERROR:', xhr.responseText);

            $('#show_error_notification').html(`
                <div class="alert alert-danger">
                    <small>Gagal mengambil data dari server</small>
                </div>
            `);

            $('.pilih_hari').html('Error');
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

//Function Khusus Edit
function initSelect2Edit() {

    // Dokter
    $('#edit_id_dokter').select2({
        dropdownParent: $('#ModalEditJadwalDokter'),
        theme: 'bootstrap-5',
        ajax: {
            url: '_Page/ReferensiJadwalDokter/ListDokter.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: params => ({ search: params.term }),
            processResults: data => ({ results: data })
        }
    });

    // Poliklinik
    $('#edit_id_poliklinik').select2({
        dropdownParent: $('#ModalEditJadwalDokter'),
        theme: 'bootstrap-5',
        ajax: {
            url: '_Page/ReferensiJadwalDokter/ListPoliklinik.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: params => ({ search: params.term }),
            processResults: data => ({ results: data })
        }
    });

    // SET DEFAULT VALUE (INI KUNCI UTAMA)
    let dokter_id   = $('#edit_id_dokter').data('selected-id');
    let dokter_text = $('#edit_id_dokter').data('selected-text');

    let poli_id     = $('#edit_id_poliklinik').data('selected-id');
    let poli_text   = $('#edit_id_poliklinik').data('selected-text');

    if (dokter_id) {
        let option = new Option(dokter_text, dokter_id, true, true);
        $('#edit_id_dokter').append(option).trigger('change');
    }

    if (poli_id) {
        let option = new Option(poli_text, poli_id, true, true);
        $('#edit_id_poliklinik').append(option).trigger('change');
    }
}

// Fungsi set tombol aktif
function setActiveHari(Hari) {
    $('.pilih_hari').removeClass('btn-primary active').addClass('btn-outline-secondary');
    $('.pilih_hari[data-id="' + Hari + '"]').removeClass('btn-outline-secondary').addClass('btn-primary active');
}


// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    let Hari = 'Senin'; // default awal
    $('#hari').val(Hari);

    // Load pertama
    calculate_jadwal_by_day();
    TabelJadwalDokter(Hari);
    setActiveHari(Hari);

    // Klik tombol hari
    $('.pilih_hari').on('click', function () {
        let hariDipilih = $(this).data('id');
        setActiveHari(hariDipilih);
        TabelJadwalDokter(hariDipilih);
        $('#hari').val(hariDipilih);
    });

    // Select Dokter
    $('#id_dokter').select2({
        dropdownParent: $('#ModalTambahJadwal'),
        theme: 'bootstrap-5',
        placeholder: 'Pilih Dokter',
        allowClear: true,
        ajax: {
            url: '_Page/ReferensiJadwalDokter/ListDokter.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term // keyword pencarian
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    // Select Poliklinik
    $('#id_poliklinik').select2({
        dropdownParent: $('#ModalTambahJadwal'),
        theme: 'bootstrap-5',
        placeholder: 'Pilih Poliklinik',
        allowClear: true,
        ajax: {
            url: '_Page/ReferensiJadwalDokter/ListPoliklinik.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });


    // Submit Tambah jadwal Dokter
    $(document).on('submit', '#ProsesTambahJadwal', function (e) {
        e.preventDefault();
        let HariPilih = $('#hari').val();
        let form       = $(this);
        let button     = $('#ButtonTambahJadwal');
        let modal      = $('#ModalTambahJadwal');
        let notifikasi = $('#NotifikasiTambahJadwal');

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
            url        : '_Page/ReferensiJadwalDokter/ProsesTambahJadwal.php',
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

                    // Reset Form Select2
                    $('#id_dokter').val(null).trigger('change');
                    $('#id_poliklinik').val(null).trigger('change');

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Jadwal berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    calculate_jadwal_by_day();
                    TabelJadwalDokter(HariPilih);

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
    // DETAIL JADWAL DOKTER
    //==================================================================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Google Credential
        var id_jadwal = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailJadwal').modal('show');

        // Loading Form
        $('#FormDetailJadwal').html(`
            <div class="text-center p-3">
                <div class="spinner-border"></div>
            </div>
        `);

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiJadwalDokter/FormDetailJadwal.php',
            data        : {id_jadwal: id_jadwal},
            success     : function(data){
                $('#FormDetailJadwal').html(data);
            }
        });
    });
    
    //==================================================================
    // EDIT JADWAL DOKTER
    //==================================================================
    $(document).on('click', '.modal_edit', function () {

        let id_jadwal = $(this).data('id');

        $('#ModalEditJadwalDokter').modal('show');
        $('#NotifikasiEditJadwalDokter').html('');

        $('#FormEditJadwalDokter').html(`
            <div class="text-center p-3">
                <div class="spinner-border"></div>
            </div>
        `);

        $.ajax({
            type : 'POST',
            url  : '_Page/ReferensiJadwalDokter/FormEditJadwalDokter.php',
            data : {id_jadwal: id_jadwal},

            success: function(data){
                $('#FormEditJadwalDokter').html(data);

                // INIT SELECT2 SETELAH HTML MASUK
                initSelect2Edit();
            }
        });
    });

    
    // HANDLE SUBMIT EDIT JADWAL DOKTER
    $(document).on('submit', '#ProsesEditJadwalDokter', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditJadwalDokter');
        let modal      = $('#ModalEditJadwalDokter');
        let notifikasi = $('#NotifikasiEditJadwalDokter');
        let HariPilih = $('.pilih_hari.active').data('id');

        let buttonText = button.html();

        let formData = new FormData(this); // ✅ WAJIB

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url: '_Page/ReferensiJadwalDokter/ProsesEditJadwalDokter.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,   // ✅ WAJIB
            contentType: false,   // ✅ WAJIB

            success: function (response) {

                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    modal.modal('hide');
                    TabelJadwalDokter(HariPilih);

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Edit Jadwal Dokter Berhasil',
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
    // HAPUS JADWAL DOKTER
    //==================================================================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap id
        var id_jadwal = $(this).data('id');
        let HariPilih = $('#hari').val();

        // Munculkan Modal
        $('#ModalHapusJadwalDokter').modal('show');

        // Loading Form
        $('#FormHapusJadwalDokter').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusJadwalDokter').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiJadwalDokter/FormHapusJadwalDokter.php',
            data        : {id_jadwal: id_jadwal},
            success     : function(data){
                $('#FormHapusJadwalDokter').html(data);
            }
        });
    });

    // Submit Hapus
    $(document).on('submit', '#ProsesHapusJadwalDokter', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusJadwalDokter');
        let modal      = $('#ModalHapusJadwalDokter');
        let notifikasi = $('#NotifikasiHapusJadwalDokter');
        let HariPilih = $('.pilih_hari.active').data('id');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ReferensiJadwalDokter/ProsesHapusJadwalDokter.php',
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
                        title            : 'Hapus Jadwal Dokter Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    calculate_jadwal_by_day();
                    TabelJadwalDokter(HariPilih);

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

    //==================================================================
    // MODAL HFIZ
    //==================================================================
    $(document).on('click', '.modal_jadwal_hfiz', function () {

        // Munculkan Modal
        $('#ModalJadwalHfiz').modal('show');

    });

    // kode_poli
    $('#kode_poli').select2({
        dropdownParent: $('#ModalJadwalHfiz'),
        theme: 'bootstrap-5',
        ajax: {
            url           : '_Page/ReferensiJadwalDokter/ListPoliklinik.php',
            type          : 'POST',
            dataType      : 'json',
            delay         : 250,
            data          : params => ({ search: params.term }),
            processResults: data => ({ results: data })
        }
    });

    // Ketika Submit Pencarian
    $(document).on('submit', '#ProsesJadwalHfiz', function (e) {
        e.preventDefault();

        // Tangkap data Dari Form
        var ProsesJadwalHfiz = $('#ProsesJadwalHfiz').serialize();

        // Loading
        $('#FormJadwalHfiz').html('<div class="row"><div class="col-12 text-center">Loading...</div></div>');
        
        // Tampilkan Data Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiJadwalDokter/FormJadwalHfiz.php',
            data        : ProsesJadwalHfiz,
            success     : function(data){
                $('#FormJadwalHfiz').html(data);
            }
        });

    });

    //==================================================================
    // UPDATE HFIZ
    //==================================================================
    $(document).on('click', '.modal_update_jadwal_hfiz', function () {

        // Munculkan Modal
        $('#ModalUpdateJadwalHfiz').modal('show');

        // Kosongkan data
        $('#DataUpdateJadwalHfiz').html('<div class="alert alert-warning text-center"><small>Silahkan tampilkan jadwal berdasarkan poliklinik dan dokter, kemudian update ke HFIZ</small></div>');

        // Kosongkan Notifikasi
        $('#NotifikasiUpdateJadwalHfiz').html('');
    });

    // Ketika 'ModalUpdateJadwalHfiz' Muncul
    $('#ModalUpdateJadwalHfiz').on('show.bs.modal', function (e) {

        // Form poliklinik_update
        $('#poliklinik_update').select2({
            dropdownParent: $('#ModalUpdateJadwalHfiz'),
            theme: 'bootstrap-5',
            ajax: {
                url           : '_Page/ReferensiJadwalDokter/ListPoliklinik.php',
                type          : 'POST',
                dataType      : 'json',
                delay         : 250,
                data          : params => ({ search: params.term }),
                processResults: data => ({ results: data })
            }
        });

        // Form dokter_update
        $('#dokter_update').select2({
            dropdownParent: $('#ModalUpdateJadwalHfiz'),
            theme: 'bootstrap-5',
            placeholder: 'Pilih Dokter',
            allowClear: true,
            ajax: {
                url: '_Page/ReferensiJadwalDokter/ListDokter.php',
                type: 'POST',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term // keyword pencarian
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });

    // Click 'show_jadwal' 
    $(document).on('click', '#show_jadwal', function () {

        // Tangkap Data Dari Form
        var id_poliklinik = $('#poliklinik_update').val();
        var id_dokter     = $('#dokter_update').val();

        // Kosongkan data
        $('#DataUpdateJadwalHfiz').html('Loading...');
        
        // Kirim Data Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiJadwalDokter/DataUpdateJadwalHfiz.php',
            data        : {id_poliklinik: id_poliklinik, id_dokter: id_dokter},
            success     : function(data){
                $('#DataUpdateJadwalHfiz').html(data);
            }
        });
    });


    // Submit 'ProsesUpdateJadwalHfiz'
    $(document).on('submit', '#ProsesUpdateJadwalHfiz', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonUpdateJadwalHfiz');
        let modal      = $('#ModalUpdateJadwalHfiz');
        let notifikasi = $('#NotifikasiUpdateJadwalHfiz');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url     : '_Page/ReferensiJadwalDokter/ProsesUpdateJadwalHfiz.php',
            type    : 'POST',
            data    : formData,
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
                        title            : 'Update Jadwal HFIZ Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

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
