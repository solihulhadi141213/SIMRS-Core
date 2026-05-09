// Tabel Pasien
function TabelPasien() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_pasien');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Pasien/TabelPasien.php',
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

// Show Select Option Province
function loadProvince() {
    $.ajax({
        url: '_Page/Pasien/GetProvince.php',
        type: 'GET',
        success: function (res) {
            $('#province').html(res);
        }
    });
}

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    TabelPasien();

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelPasien(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelPasien(0);
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
            url 	    : '_Page/Pasien/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Pencarian/Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelPasien();
        $('#ModalFilter').modal('hide');
    });
    // ==============================
    // TAMBAH PASIEN
    // ==============================
    
    // Auto Focus Keyword
    $('#ModalTambah').on('shown.bs.modal', function () {
        $('#nik').focus();
    });

    //Mode No RM Manual
    $('#id_pasien_manual').on('change', function () {
        if ($(this).is(':checked')) {
            $('#id_pasien').prop('disabled', false).removeClass('bg-secondary-subtle');
        } else {
            $('#id_pasien').prop('disabled', true).addClass('bg-secondary-subtle').val('');
        }
    });

    // Pasien Anak Relasi Ibu
    $('#pasien_anak').on('change', function () {
        if ($(this).is(':checked')) {
            $('#id_pasien_relasi').prop('disabled', false).removeClass('bg-danger-subtle');

            // INIT SELECT2
            $('#id_pasien_relasi').select2({
                theme             : 'bootstrap-5',
                dropdownParent    : $('#ModalTambah'),
                placeholder       : 'Cari No.RM / Nama Pasien',
                minimumInputLength: 0,
                ajax              : {
                    url     : '_Page/Pasien/SearchPasien.php',
                    type    : 'POST',
                    dataType: 'json',
                    delay   : 250,
                    data    : function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });

        } else {
            $('#id_pasien_relasi').prop('disabled', true)
                .addClass('bg-danger-subtle')
                .val(null)
                .trigger('change');
        }
    });

    // Ketika RM Ibu Dipilih
    $(document).on('change', '#id_pasien_relasi', function () {

        let id_pasien = $(this).val();

        // Kosongkan jika tidak ada pilihan
        if (!id_pasien) {
            return;
        }

        $.ajax({
            url      : '_Page/Pasien/GetDetailPasien.php',
            type     : 'POST',
            dataType : 'json',
            data     : {
                id_pasien: id_pasien
            },

            success: function (response) {

                if (response.status == 'success') {

                    let data = response.metadata;

                    // =====================================================
                    // AUTO ISI NAMA PASIEN ANAK
                    // =====================================================
                    // Contoh:
                    // UYU YULIANTI -> BAYI NY. UYU YULIANTI

                    $('#nama').val(''+data.nama+' (BY)');

                    // =====================================================
                    // AUTO ISI ALAMAT
                    // =====================================================
                    $('#province').val(data.province).trigger('change');

                    // Tunggu regency load
                    setTimeout(function () {

                        $('#regency').val(data.regency).trigger('change');

                        setTimeout(function () {

                            $('#subdistrict').val(data.subdistrict).trigger('change');

                            setTimeout(function () {

                                $('#village').val(data.village).trigger('change');

                            }, 500);

                        }, 500);

                    }, 500);

                    $('#street').val(data.street);
                    $('#postal_code').val(data.postal_code);
                    $('#kontak').val(data.kontak);

                } else {

                    Swal.fire({
                        icon : 'warning',
                        title: 'Oops!',
                        text : response.message
                    });

                }
            },

            error: function () {

                Swal.fire({
                    icon : 'error',
                    title: 'Server Error',
                    text : 'Terjadi kesalahan pada server.'
                });

            }
        });
    });

    // Function Untuk Menampilkan Notifikasi
    function showNotif(message) {
        $('#NotifikasiTambah').html(`
            <div class="alert alert-danger alert-dismissible fade show">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
    }

    // ==============================
    // 3 & 4. CARI NIK (SATUSEHAT & BPJS)
    // ==============================
    $('.cari_nik_pasien_satusehat').on('click', function () {

        let nik = $('#nik').val();

        if (nik=='') {
            // Jika NIK Kosong Maka Tampilkan Notifikasi Di Bawah Form
            $('#notifikasi_cari_pasien_by_nik').html('<small>Isi NIK Pasien Terlebih Dulu Untuk Pencarian</small>');
        }else{

            // Tampilkan Modal
            $('#ModalCariNikSatuSehat').modal('show');

            // Pencarian NIK Dari Resource Satusehat
            $.ajax({
                url     : '_Page/Pasien/ProsesCariNikSatusehat.php',
                type    : 'POST',
                data    : {nik: nik},
                dataType: 'JSON',
                success: function (response) {
                    let status = response.status;
                    let message = response.message;

                    if(status=='Success'){
                        var id     = response.metadata.id;
                        var name   = response.metadata.name;
                        var nik_ss = response.metadata.nik;
                        $('#DisplayCariNikSatuSehat').show(); // Show Display
                        $('#NotifikasiCariNikSatuSehat').hide(); // Hide Notify
                        $('.put_ihs_pasien').html(id);
                        $('.put_nama_pasien').html(name);
                        $('.put_nik_pasien').html(nik_ss);
                        $('#ButtonTerapkanIhsPasien').prop('disabled', false);

                        // Jika ButtonTerapkanIhsPasien di click
                        $('#ButtonTerapkanIhsPasien').on('click', function () {
                            // Tambahkan IHS Pasien Ke form
                            $('#id_ihs').val(id);

                            // Tutup Modal
                            $('#ModalCariNikSatuSehat').modal('hide');
                        });
                    }else{
                        $('#DisplayCariNikSatuSehat').hide();
                        $('#NotifikasiCariNikSatuSehat').show();
                        $('#NotifikasiCariNikSatuSehat').html(message);
                        $('#ButtonTerapkanIhsPasien').prop('disabled', true);
                    }

                    // Bersihkan Notifikasi
                    $('#notifikasi_cari_pasien_by_nik').html('');
                }
            });
        }

    });

    $('.cari_nik_pasien_bpjs').on('click', function () {

        let nik = $('#nik').val();

        if (nik=='') {
            // Jika NIK Kosong Maka Tampilkan Notifikasi Di Bawah Form
            $('#notifikasi_cari_pasien_by_nik').html('<small>Isi NIK Pasien Terlebih Dulu Untuk Pencarian</small>');
        }else{

            // Tampilkan Modal
            $('#ModalCariNikBpjs').modal('show');

            // Pencarian NIK Dari Resource Satusehat
            $.ajax({
                url     : '_Page/Pasien/ProsesCariNikBpjs.php',
                type    : 'POST',
                data    : {nik: nik},
                dataType: 'JSON',
                success: function (response) {
                    let status = response.status;
                    let message = response.message;

                    if(status=='Success'){
                        var noKartu   = response.metadata.noKartu;
                        var nama      = response.metadata.nama;
                        var sex       = response.metadata.sex;
                        var noTelepon = response.metadata.noTelepon;
                        var nik_bpjs  = response.metadata.nik_bpjs;
                        var tglLahir  = response.metadata.tglLahir;
                        var raw       = response.metadata.raw;

                        // Routing Gender
                        var Gender = '';
                        if(sex=='L'){
                            var Gender = 'Laki-laki';
                        }else{
                            var Gender = 'Perempuan';
                        }

                        // Tampilkan Informasi dan Sembunyikan Notif
                        $('#DisplayCariNikBpjs').show(); // Show Display
                        $('#NotifikasiCariNikBpjs').hide(); // Hide Notify

                        // Tempelkan Ke Info Modal
                        $('.put_nomor_kartu_bpjs').html(noKartu);
                        $('.put_nama_pasien_bpjs').html(nama);
                        $('.put_nik_pasien').html(nik_bpjs);
                        $('.put_tanggal_lahir').html(tglLahir);
                        $('.put_noTelepon').html(noTelepon);
                        $('.put_sex').html(sex);
                        $('.put_raw').html(raw);

                        // Enable Button
                        $('#ButtonTerapkanPasienBpjs').prop('disabled', false);

                        // Jika ButtonTerapkanIhsPasien di click
                        $('#ButtonTerapkanPasienBpjs').on('click', function () {
                            // Tambahkan Data Ke form
                            $('#no_bpjs').val(noKartu);
                            $('#nama').val(nama);
                            $('#kontak').val(noTelepon);
                            $('#gender').val(Gender);
                            $('#tanggal_lahir').val(tglLahir);

                            // Tutup Modal
                            $('#ModalCariNikBpjs').modal('hide');

                            // Bersihkan Notifikasi
                            $('#notifikasi_cari_pasien_by_nik').html('');
                        });
                    }else{
                        $('#DisplayCariNikBpjs').hide();
                        $('#NotifikasiCariNikBpjs').show();
                        $('#NotifikasiCariNikBpjs').html(message);
                        $('#ButtonTerapkanPasienBpjs').prop('disabled', true);
                    }
                }
            });
        }

    });

    // ==============================
    // 5. CARI IHS SATUSEHAT
    // ==============================
    $('.cari_ihs_pasien_satusehat').on('click', function () {
        
        // Tangkap id_ihs dari form
        let id_ihs = $('#id_ihs').val();

        // Jika id_ihs kosong
        if (id_ihs === '') {
            $('#notifikasi_cari_pasien_by_ihs').html('<small class="text-danger">Isi IHS Pasien Terlebih Dulu Untuk Pencarian</small>');
        }else{

            // Tampilkan modal
            $('#ModalCariIhsPasien').modal('show');

            // Buka Data Dengan AJAX
            $.ajax({
                url     : '_Page/Pasien/ProsesCariIhsSatuSehat.php',
                type    : 'POST',
                dataType: 'JSON',
                data    : { id_ihs: id_ihs },
                success : function (response) {
                    let status = response.status;
                    let message = response.message;

                    if(status=='Success'){

                        // Tangkap Data
                        var id     = response.metadata.id;
                        var name   = response.metadata.name;
                        var nik_ss = response.metadata.nik;
                        var raw    = response.metadata.raw;

                        // Switch Data Dan Notifikasi
                        $('#DisplayCariIhs').show(); // Show Display
                        $('#NotifikasiCariIhs').hide(); // Hide Notify

                        // Tampilkan Data
                        $('.put_ihs_pasien').html(id);
                        $('.put_nama_pasien').html(name);
                        $('.put_nik_pasien').html(nik_ss);

                        // Tampilkan Raw
                        $('.put_raw').html(raw);
                    }else{
                        // Switch Data Dan Notifikasi
                        $('#DisplayCariIhs').hide();
                        $('#NotifikasiCariIhs').show();
                        $('#NotifikasiCariIhs').html(message);
                    }

                    // Bersihkan Notifikasi
                    $('#notifikasi_cari_pasien_by_ihs').html('');
                }
            });
        }

    });

    // ==============================
    // 6. CARI NO BPJS
    // ==============================
    $('.cari_no_bpjs').on('click', function () {

        let no_bpjs = $('#no_bpjs').val();

        if (no_bpjs=='') {
            // Jika NIK Kosong Maka Tampilkan Notifikasi Di Bawah Form
            $('#notifikasi_cari_no_bpjs').html('<small>Isi NIK Pasien Terlebih Dulu Untuk Pencarian</small>');
        }else{

            // Kosongkan Notifikasi
            $('#notifikasi_cari_no_bpjs').html('');

            // Tampilkan Modal
            $('#ModalCariNoBpjs').modal('show');

            // Pencarian NIK Dari Resource Satusehat
            $.ajax({
                url     : '_Page/Pasien/ProsesCariNoBpjs.php',
                type    : 'POST',
                data    : {no_bpjs: no_bpjs},
                dataType: 'JSON',
                success: function (response) {
                    let status = response.status;
                    let message = response.message;

                    if(status=='Success'){
                        var nik_bpjs   = response.metadata.nik_bpjs;
                        var noKartu   = response.metadata.noKartu;
                        var nama      = response.metadata.nama;
                        var sex       = response.metadata.sex;
                        var noTelepon = response.metadata.noTelepon;
                        var nik_bpjs  = response.metadata.nik_bpjs;
                        var tglLahir  = response.metadata.tglLahir;
                        var raw       = response.metadata.raw;

                        // Routing Gender
                        var Gender = '';
                        if(sex=='L'){
                            var Gender = 'Laki-laki';
                        }else{
                            var Gender = 'Perempuan';
                        }

                        // Tampilkan Informasi dan Sembunyikan Notif
                        $('#DisplayCariNoBpjs').show(); // Show Display
                        $('#NotifikasiCariNoBpjs').hide(); // Hide Notify

                        // Tempelkan Ke Info Modal
                        $('.put_nomor_kartu_bpjs').html(noKartu);
                        $('.put_nama_pasien_bpjs').html(nama);
                        $('.put_nik_pasien').html(nik_bpjs);
                        $('.put_tanggal_lahir').html(tglLahir);
                        $('.put_noTelepon').html(noTelepon);
                        $('.put_sex').html(sex);
                        $('.put_raw').html(raw);

                        // Enable Button
                        $('#ButtonTerapkanPasienNoBpjs').prop('disabled', false);

                        // Jika ButtonTerapkanIhsPasien di click
                        $('#ButtonTerapkanPasienNoBpjs').on('click', function () {
                            // Tambahkan Data Ke form
                            $('#nik').val(nik_bpjs);
                            $('#nama').val(nama);
                            $('#kontak').val(noTelepon);
                            $('#gender').val(Gender);
                            $('#tanggal_lahir').val(tglLahir);

                            // Tutup Modal
                            $('#ModalCariNoBpjs').modal('hide');

                            // Bersihkan Notifikasi
                            $('#notifikasi_cari_no_bpjs').html('');
                        });
                    }else{
                        $('#DisplayCariNoBpjs').hide();
                        $('#NotifikasiCariNoBpjs').show();
                        $('#NotifikasiCariNoBpjs').html(message);
                        $('#ButtonTerapkanPasienNoBpjs').prop('disabled', true);
                    }
                }
            });
        }

    });

    // Load Select Option Provinsi Pertama Kali
    loadProvince();

    // Province -> Regency
    $('#province').on('change', function () {
        let province = $(this).val();

        $('#regency').html('<option>Loading...</option>');

        $.ajax({
            url: '_Page/Pasien/GetRegency.php',
            type: 'POST',
            data: { province: province },
            success: function (res) {
                $('#regency').html(res);
                $('#subdistrict').html('<option value="">Pilih</option>');
                $('#village').html('<option value="">Pilih</option>');
            }
        });
    });

    // Regency -> Subdistrict
    $('#regency').on('change', function () {
        let regency = $(this).val();

        $('#subdistrict').html('<option>Loading...</option>');

        $.ajax({
            url: '_Page/Pasien/GetSubdistrict.php',
            type: 'POST',
            data: { regency: regency },
            success: function (res) {
                $('#subdistrict').html(res);
                $('#village').html('<option value="">Pilih</option>');
            }
        });
    });

    // Subdistrict -> Village
    $('#subdistrict').on('change', function () {
        let subdistrict = $(this).val();

        $('#village').html('<option>Loading...</option>');

        $.ajax({
            url: '_Page/Pasien/GetVillage.php',
            type: 'POST',
            data: { subdistrict: subdistrict },
            success: function (res) {
                $('#village').html(res);
            }
        });
    });

    // Check Pernyataan
    $('#pernyataan_petugas').on('change', function () {
        if ($(this).is(':checked')) {
            $('#ButtonTambah').prop('disabled', false);
        } else {
            $('#ButtonTambah').prop('disabled', true);
        }
    });

    // Submit Tambah Pasien
    $(document).on('submit', '#ProsesTambah', function (e) {
        e.preventDefault();

        let form       = $(this);
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
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Pasien/ProsesTambahPasien.php',
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

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Pasien Berhasil',
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
                    TabelPasien();

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
    // DETAIL PASIEN
    // ==============================
    $(document).on('click', '.modal_detail', function () {

        // Ambil ID Pasien
        let id_pasien = $(this).data('id');

        // Validasi
        if (!id_pasien) {
            console.error('ID Pasien tidak ditemukan');
            return;
        }

        // Loading View
        $('#FormDetail')
            .html(`
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                    <div>
                        <small class="text-muted">Memuat detail pasien...</small>
                    </div>
                </div>
            `)
            .css({
                opacity: 0,
                filter: 'blur(6px)'
            });

        // Tampilkan Modal
        $('#ModalDetail').modal('show');

        // Smooth Loading Animation
        $('#FormDetail').animate({
            opacity: 1
        }, 200);

        // AJAX
        $.ajax({
            url: '_Page/Pasien/FormDetail.php',
            type: 'POST',
            data: {
                id_pasien: id_pasien
            },
            timeout: 10000,

            success: function (response) {

                // Fade Out Sebelum Replace
                $('#FormDetail').animate({
                    opacity: 0
                }, 120, function () {

                    // Replace Content
                    $(this)
                        .html(response)
                        .css({
                            filter: 'blur(6px)',
                            opacity: 0
                        });

                    // Fade In + Blur Clear
                    $({
                        blur: 6
                    }).animate({
                        blur: 0
                    }, {
                        duration: 250,

                        step: function () {
                            $('#FormDetail').css('filter', `blur(${this.blur}px)`);
                        }
                    });

                    $('#FormDetail').animate({
                        opacity: 1
                    }, 250);
                });
            },

            error: function (xhr, status, error) {

                console.error(error);

                $('#FormDetail').html(`
                    <div class="alert alert-danger mb-0">
                        <small>
                            Gagal memuat detail pasien!<br>
                            Status : ${status}
                        </small>
                    </div>
                `).css({
                    opacity: 1,
                    filter: 'blur(0)'
                });
            }
        });
    });

    // ==============================
    // UBAH STATUS
    // ==============================
    $(document).on('click', '.modal_ubah_status', function () {
        
        // Ambil ID Pasien
        let id_pasien = $(this).data('id');

        // Bersihkan Notifikasi
        $('#NotifikasiUbahStatus').html('');

        // Tampilkan Modal
        $('#ModalUbahStatus').modal('show');

        // Loading Form
        $('#FormUbahStatus').html('Loading...');

        // Tampilkan Form Edit Dengan Ajax
        $.ajax({
            url: '_Page/Pasien/FormUbahStatus.php',
            type: 'POST',
            data: { id_pasien: id_pasien },
            success: function (res) {
                $('#FormUbahStatus').html(res);
            }
        });

    });

    // Submit Ubah Status
    $(document).on('submit', '#ProsesUbahStatus', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonUbahStatus');
        let modal      = $('#ModalUbahStatus');
        let notifikasi = $('#NotifikasiUbahStatus');

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
            url        : '_Page/Pasien/ProsesUbahStatus.php',
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
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Ubah Status Pasien Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelPasien();

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
    // EDIT PASIEN
    // ==============================
    $(document).on('click', '.modal_edit', function () {
        
        // Ambil ID Pasien
        let id_pasien = $(this).data('id');

        // Bersihkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Tampilkan Modal
        $('#ModalEdit').modal('show');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Form Edit Dengan Ajax
        $.ajax({
            url: '_Page/Pasien/FormEdit.php',
            type: 'POST',
            data: { id_pasien: id_pasien },
            success: function (res) {
                $('#FormEdit').html(res);
            }
        });

    });

    // Submit Edit Pasien
    $(document).on('submit', '#ProsesEdit', function (e) {
        e.preventDefault();

        let form       = $(this);
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
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Pasien/ProsesEdit.php',
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
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Pasien Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelPasien();

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
    // HAPUS PASIEN
    // ==============================
    $(document).on('click', '.modal_hapus', function () {

        // Ambil ID Pasien
        let id_pasien = $(this).data('id');

        // Reset
        $('#NotifikasiHapus').html('');
        $('#ButtonHapus').prop('disabled', true);

        // Tampilkan Modal
        $('#ModalHapus').modal('show');

        // Loading
        $('#FormHapus').html('Loading...');

        // Ajax
        $.ajax({
            url: '_Page/Pasien/FormHapus.php',
            type: 'POST',
            data: { id_pasien: id_pasien },
            success: function (res) {
                $('#FormHapus').html(res);
            }
        });

    });

    $(document).on('change', '#pernyataan_petugas_penghapus', function () {

        if ($(this).is(':checked')) {
            $('#ButtonHapus').prop('disabled', false);
        } else {
            $('#ButtonHapus').prop('disabled', true);
        }

    });

    // Submit Hapus Pasien
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
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Pasien/ProsesHapus.php',
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
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus Pasien Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelPasien();

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
    // EXPORT/DOWNLOAD PASIEN
    // ==============================
    $(document).on('click', '.modal_download', function () {
        
        // Bersihkan Notifikasi
        $('#NotifikasiExport').html('');

        // Tampilkan Modal
        $('#ModalExport').modal('show');

        // Periksa Ijin Akses Dengan Ajax
        $.ajax({
            url     : '_Page/Pasien/CekIjinDownload.php',
            dataType: 'JSON',
            success: function (response) {
                let status = response.status;
                if(status==true){
                    $('#ButtonExport').prop('disabled', false);
                    $('#NotifikasiDownload').html('<div class="alert alert-info"><small>Output data yang dihasilkan dalam bentuk CSV. Semakin besar data pasien yang ada pada database akan membutuhkan waktu lebih lama.</small></div>');
                }else{
                    $('#ButtonExport').prop('disabled', true);
                    $('#NotifikasiDownload').html('<div class="alert alert-danger"><small>Anda Tidak Memiliki Ijin Untuk Melakukan Download Data Pasien.</small></div>');
                }
            }
        });

    });

    // Reset Form Export Saat Modal Dibuka
    $('#ModalExport').on('shown.bs.modal', function () {

        $('#periode_data').val('Semua').trigger('change');

    });

    // Enable / Disable Periode
    $('#periode_data').on('change', function () {

        let value = $(this).val();

        if (value === 'Periode') {

            $('#periode_awal')
                .prop('disabled', false)
                .attr('required', true);

            $('#periode_akhir')
                .prop('disabled', false)
                .attr('required', true);

        } else {

            $('#periode_awal')
                .prop('disabled', true)
                .removeAttr('required')
                .val('');

            $('#periode_akhir')
                .prop('disabled', true)
                .removeAttr('required')
                .val('');
        }
    });

    // Submit Export Pasien
    $(document).on('submit', '#ProsesExport', function (e) {
        e.preventDefault();

        let button = $('#ButtonExport');
        let buttonText = button.html();

        // Loading Button
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Exporting...
        `);

        // Ambil Data Form
        let formData = $(this).serialize();

        // Download File CSV
        window.open('_Page/Pasien/ProsesExportPasien.php?' + formData, '_blank');

        // Restore Button
        setTimeout(function () {
            button.prop('disabled', false).html(buttonText);
        }, 1500);
    });

    
    // ==============================
    // IMPORT/UPLOAD PASIEN
    // ==============================
    $(document).on('click', '#ButtonModalImport', function () {

        // Reset Form
        $('#ProsesImport')[0].reset();

        // Reset Notifikasi
        $('#NotifikasiUpload').html('');

        // Reset Progress
        $('#ProgressUploadWrapper').addClass('d-none');

        $('#ProgressUpload')
            .css('width', '0%')
            .html('0%');

        // Disable Button
        $('#ButtonUpload').prop('disabled', true);

        // Tampilkan Modal
        $('#ModalImport').modal('show');
    });

    // ENABLE BUTTON JIKA FILE DIPILIH
    $(document).on('change', '#file_pasien', function () {

        let file = $(this).val();

        if (file !== '') {

            $('#ButtonUpload').prop('disabled', false);

        } else {

            $('#ButtonUpload').prop('disabled', true);

        }
    });

    // SUBMIT IMPORT PASIEN
    $(document).on('submit', '#ProsesImport', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonUpload');
        let progress   = $('#ProgressUpload');
        let wrapper    = $('#ProgressUploadWrapper');
        let notifikasi = $('#NotifikasiUpload');

        // =====================================================
        // FORM DATA
        // =====================================================
        let formData = new FormData(this);

        // =====================================================
        // RESET NOTIFIKASI
        // =====================================================
        notifikasi.html('');

        // =====================================================
        // TAMPILKAN PROGRESS
        // =====================================================
        wrapper.removeClass('d-none');

        progress
            .css('width', '0%')
            .html('0%');

        // =====================================================
        // DISABLE BUTTON
        // =====================================================
        button.prop('disabled', true);

        // Simpan text awal
        let buttonHtml = button.html();

        button.html(`
            <span class="spinner-border spinner-border-sm"></span>
            Processing...
        `);

        // =====================================================
        // AJAX
        // =====================================================
        $.ajax({

            url: '_Page/Pasien/ProsesImport.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',

            // =================================================
            // PROGRESS UPLOAD
            // =================================================
            xhr: function () {

                let xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener('progress', function (e) {

                    if (e.lengthComputable) {

                        let percent = Math.round((e.loaded / e.total) * 100);

                        progress
                            .css('width', percent + '%')
                            .html(percent + '%');
                    }

                }, false);

                return xhr;
            },

            // =================================================
            // SUCCESS
            // =================================================
            success: function (result) {

                button.html(buttonHtml);
                button.prop('disabled', false);

                progress
                    .removeClass('bg-danger')
                    .addClass('bg-success');

                progress
                    .css('width', '100%')
                    .html('100%');

                // =============================================
                // TABLE RESULT
                // =============================================
                let html = `
                    <div class="alert alert-info mb-3">
                        ${result.message}
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>ID Pasien</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                $.each(result.detail, function(i, item){

                    let badge = '';

                    if(item.status == 'INSERT'){
                        badge = '<span class="badge bg-success">INSERT</span>';
                    }else if(item.status == 'UPDATE'){
                        badge = '<span class="badge bg-primary">UPDATE</span>';
                    }else{
                        badge = '<span class="badge bg-danger">GAGAL</span>';
                    }

                    html += `
                        <tr>
                            <td>${item.no}</td>
                            <td>${item.id_pasien ?? '-'}</td>
                            <td>${item.nama ?? '-'}</td>
                            <td>${badge}</td>
                            <td>${item.keterangan}</td>
                        </tr>
                    `;
                });

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                notifikasi.html(html);

                // Reload Data
                if (typeof ShowDataPasien === 'function') {
                    ShowDataPasien();
                }
            },

            // =================================================
            // ERROR
            // =================================================
            error: function (xhr) {

                button.html(buttonHtml);
                button.prop('disabled', false);

                progress
                    .removeClass('bg-success')
                    .addClass('bg-danger');

                notifikasi.html(`
                    <div class="alert alert-danger">
                        <b>Terjadi Kesalahan!</b><br>
                        ${xhr.responseText}
                    </div>
                `);
            }
        });
    });

    // ==============================
    // DETAIL NIK
    // ==============================
    $(document).on('click', '.modal_detail_nik', function () {
        
        // Ambil nik
        let nik = $(this).data('id');

        // Tampilkan Modal
        $('#ModalDetailNik').modal('show');

        // Loading Form
        $('#FormDetailNik').html('Loading...');

        // Tampilkan Form Edit Dengan Ajax
        $.ajax({
            url: '_Page/Pasien/FormDetailNik.php',
            type: 'POST',
            data: { nik: nik },
            success: function (res) {
                $('#FormDetailNik').html(res);
            }
        });

    });

    // ==============================
    // DETAIL BPJS
    // ==============================
    $(document).on('click', '.modal_detail_bpjs', function () {
        
        // Ambil no_bpjs
        let no_bpjs = $(this).data('id');

        // Tampilkan Modal
        $('#ModalDetailBpjs').modal('show');

        // Loading Form
        $('#FormDetailBpjs').html('Loading...');

        // Tampilkan Form Edit Dengan Ajax
        $.ajax({
            url: '_Page/Pasien/FormDetailBpjs.php',
            type: 'POST',
            data: { no_bpjs: no_bpjs },
            success: function (res) {
                $('#FormDetailBpjs').html(res);
            }
        });

    });

    // ==============================
    // DETAIL IHS
    // ==============================
    $(document).on('click', '.modal_detail_ihs', function () {
        
        // Ambil no_bpjs
        let id_ihs = $(this).data('id');

        // Tampilkan Modal
        $('#ModalDetailIhs').modal('show');

        // Loading Form
        $('#FormDetailIhs').html('Loading...');

        // Tampilkan Form Edit Dengan Ajax
        $.ajax({
            url: '_Page/Pasien/FormDetailIhs.php',
            type: 'POST',
            data: { id_ihs: id_ihs },
            success: function (res) {
                $('#FormDetailIhs').html(res);
            }
        });

    });

    // ==============================
    // Edit Nomor Identitas pasien
    // ==============================
    $(document).on('click', '.modal_edit_identitas_pasien', function () {

        // Ambil id_pasien
        let id_pasien = $(this).data('id');
        let field = $(this).data('field');

        // Loading Form
        $('#FormEditIdentitasPasien').html('Loading...');

        // Tampilkan Modal
        $('#ModalEditIdentitasPasien').modal('show');

        // Ajax Form
        $.ajax({
            url: '_Page/Pasien/FormEditIdentitasPasien.php',
            type: 'POST',
            data: {
                id_pasien: id_pasien,
                field: field
            },
            success: function (res) {
                $('#FormEditIdentitasPasien').html(res);
            }
        });

    });

    // Setelah modal benar-benar tampil
    $('#ModalEditIdentitasPasien').on('shown.bs.modal', function () {
        $('#value_field').trigger('focus');
    });

    // Submit Edit Identitas Pasien
    $(document).on('submit', '#ProsesEditIdentitasPasien', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditIdentitasPasien');
        let modal      = $('#ModalEditIdentitasPasien');
        let notifikasi = $('#NotifikasiEditIdentitasPasien');

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
            url        : '_Page/Pasien/ProsesEditIdentitasPasien.php',
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
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Identitas Pasien Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelPasien();

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
