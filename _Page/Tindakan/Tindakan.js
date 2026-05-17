

$(document).ready(function() {

    //-----------------------------------------
    // BLOCK FUNCTION
    //-----------------------------------------

    // Tabel Tindakan
    function TabelTindakan() {
        var ProsesFilter = $('#ProsesFilter').serialize();
        let target = $('#tabel_tindakan');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/Tindakan/TabelTindakan.php',
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

    // MENAMPILKAN DATA TINDAKAN
    function ShowTindakan(id_kunjungan){
        
        // Loading FormTindakan
        $('#FormTindakan').html('Loading...');

        // Buka Form Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Tindakan/FormTindakan.php',
            data        : {id_kunjungan: id_kunjungan},
            success     : function(data){
                $('#FormTindakan').html(data);
            }
        });
    }

    //-----------------------------------------
    // BLOCK EVENT
    //-----------------------------------------

    // MENAMPILKAN DATA PERTAMA KALI

    // Menampilkan table_view
    $('#table_view').show();

    // Sembunyikan Data View
    $('#detail_view').hide();

    TabelTindakan();

     //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelTindakan(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelTindakan(0);
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
            url 	    : '_Page/Tindakan/FormFilter.php',
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
        TabelTindakan();
    });

    // DETAIL KUNJUNGAN
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

    // DETAIL PASIEN
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

    // DETAIL TINDAKAN
    $(document).on('click', '.show_detail_tindakan', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Menampilkan table_view
        $('#table_view').hide();

        // Sembunyikan Data View
        $('#detail_view').show();

        ShowTindakan(id_kunjungan);

    });

    // TAMBAH TINDAKAN
    $(document).on('click', '.modal_tambah_tindakan', function () {
    
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahTindakan').html('');

        // Show Modal
        $('#ModalTambahTindakan').modal('show');
        
        // Loading Form
        $('#FormTambahTindakan').html('Loading...');

        // Ajax Form
        $.ajax({
            type  : 'POST',
            url   : '_Page/Tindakan/FormTambahTindakan.php',
            data  : {id_kunjungan : id_kunjungan},
            success : function(data){

                $('#FormTambahTindakan').html(data);

               // SELECT2 REFERENSI TINDAKAN
                $('#id_tindakan_referensi').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: $('#form_tindakan_referensi'),
                    placeholder: 'Cari tindakan...',
                    allowClear: true,
                    ajax: {
                        url: '_Page/Tindakan/ListReferensiTindakan.php',
                        type: 'POST',
                        dataType: 'json',
                        delay: 250,
                        data: function(params){
                            return {
                                search: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params){

                            params.page = params.page || 1;

                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },
                        cache: true
                    }
                });

                // SELECT2 ICD
                loadSelectIcd();

                // CHANGE REFERENSI TINDAKAN
                $('#id_tindakan_referensi').on('select2:select', function(e){

                    let data = e.params.data;

                    $('#kategori_tindakan')
                        .val(data.kategori_tindakan)
                        .prop('readonly', true);

                    $('#nama_tindakan')
                        .val(data.nama_tindakan)
                        .prop('readonly', true);

                    $('#lokasi_tubuh')
                        .val(data.lokasi_tubuh)
                        .prop('readonly', true);

                    // SET ICD9
                    if(data.icd9_code){

                        let newOption = new Option(
                            data.icd9_text,
                            data.icd9_code,
                            true,
                            true
                        );

                        $('#icd9_code')
                            .append(newOption)
                            .trigger('change');

                        $('#icd9_description').val(data.icd9_description);

                    }else{

                        $('#icd9_code').val(null).trigger('change');
                        $('#icd9_description').val('');
                    }

                    $('#icd9_code').prop('disabled', true);

                });

                // CLEAR REFERENSI
                $('#id_tindakan_referensi').on('select2:clear', function(){

                    $('#kategori_tindakan')
                        .val('')
                        .prop('readonly', false);

                    $('#nama_tindakan')
                        .val('')
                        .prop('readonly', false);

                    $('#lokasi_tubuh')
                        .val('')
                        .prop('readonly', false);

                    $('#icd9_code')
                        .val(null)
                        .trigger('change')
                        .prop('disabled', false);

                    $('#icd9_description').val('');

                });

                // GANTI JENIS ICD
                $('input[name="reson_reference"]').on('change', function(){

                    $('#reson_code').val(null).trigger('change');

                    $('#reson_code').select2('destroy');

                    loadSelectIcd();

                });

                // FUNGSI LOAD ICD
                function loadSelectIcd(){

                    $('#reson_code').select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        dropdownParent: $('#form_reson_code'),
                        placeholder: 'Cari ICD...',
                        allowClear: true,
                        ajax: {
                            url: '_Page/Tindakan/ListIcd10.php',
                            type: 'POST',
                            dataType: 'json',
                            delay: 250,
                            data: function(params){

                                return {
                                    search: params.term,
                                    page: params.page || 1,
                                    reson_reference: $('input[name="reson_reference"]:checked').val()
                                };
                            },
                            processResults: function(data, params){

                                params.page = params.page || 1;

                                return {
                                    results: data.results,
                                    pagination: {
                                        more: data.pagination.more
                                    }
                                };
                            },
                            cache: true
                        }
                    });

                }

                // SET DISPLAY ICD
                $('#reson_code').on('select2:select', function(e){
                    let data = e.params.data;
                    $('#reson_display').val(data.display);

                });

                $('#reson_code').on('select2:clear', function(){
                    $('#reson_display').val('');
                });

            }
        });
    });

    // Handdle Submit Tindakan
    $(document).on('submit', '#ProsesTambahTindakan', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahTindakan');
        let modal      = $('#ModalTambahTindakan');
        let notifikasi = $('#NotifikasiTambahTindakan');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/Tindakan/ProsesTambahTindakan.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // id_kunjungan
                let id_kunjungan = response.id_kunjungan;

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
                        title            : 'Tambah Referensi Tindakan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    ShowTindakan(id_kunjungan);

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

    // Reload Detail Tindakan
    $(document).on('click', '.reload_tindakan', function () {

        // Menampilkan table_view
        let id_kunjungan = $('#put_id_kunjungan').val();

        // Reload Data
        ShowTindakan(id_kunjungan);
    });


    // KEMBALI
    $(document).on('click', '.back_to_data', function () {

        // Menampilkan table_view
        $('#table_view').show();

        // Sembunyikan Data View
        $('#detail_view').hide();
        
        // Scroll ke atas halaman
        $('html, body').animate({
            scrollTop: 0
        }, 300);

    });

    // MODAL DETAIL
    $(document).on('click', '.modal_detail', function () {
        
        // Tangkap id_tindakan
        var id_tindakan = $(this).data('id');

        // Show Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Tindakan/FormDetail.php',
            data        : {id_tindakan : id_tindakan},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });

    // DAFTAR PERFORMER
    $(document).on('click', '.modal_performer', function () {
        
        // Tangkap id_tindakan
        var id_tindakan = $(this).data('id');

        // Show Modal
        $('#ModalPerformer').modal('show');

        // Loading Form
        $('#FormPerformer').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Tindakan/FormPerformer.php',
            data        : {id_tindakan : id_tindakan},
            success     : function(data){
                $('#FormPerformer').html(data);
            }
        });
    });

    // TAMBAH PERFORMER
    $(document).on('click', '.modal_tambah_perfomrer', function () {
        
        // Tangkap id_tindakan
        var id_tindakan = $(this).data('id');

        // Show Modal
        $('#ModalTambahPerformer').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahPerformer').html('');

        // Loading Form
        $('#FormTambahPerformer').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Tindakan/FormTambahPerformer.php',
            data        : {id_tindakan : id_tindakan},
            success     : function(data){
                $('#FormTambahPerformer').html(data);
            }
        });
    });

});
