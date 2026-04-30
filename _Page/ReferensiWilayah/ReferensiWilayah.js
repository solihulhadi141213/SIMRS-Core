// Tabel Wilayah
function TabelWilayah() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_wilayah');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiWilayah/TabelWilayah.php',
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

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    TabelWilayah();

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelWilayah();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelWilayah(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelWilayah(0);
    });

    // ====================================================================
    // TAMBAH WILAYAH
    // ====================================================================

    // HANDLE FORM province
    $('#province').select2({
        dropdownParent: $('#ModalTambahWilayah'),
        theme         : 'bootstrap-5',
        placeholder   : "- Pilih Provinsi -",
        allowClear    : true,
        tags          : true,

        ajax: {
            url     : "_Page/ReferensiWilayah/GetProvinsi.php",
            type    : "POST",
            dataType: "json",
            delay   : 250,
            data    : function (params) {
                return {
                    keyword: params.term || '',
                    page   : params.page || 1
                };
            },
            processResults: function (data, params) {
                return {
                    results   : data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            }
        }
    });

    $('#province').on('select2:select', function (e) {

        // tetap aktifkan level berikutnya
        $('#regency').prop('disabled', false);
        $('#tipe_level2').prop('disabled', false);
        $('#kode_mendagri_2').prop('disabled', false);
    });
    
    $('#province').on('select2:clear', function () {
        // reset semua bawahnya
        $('#regency').val(null).trigger('change').prop('disabled', true);
        $('#subdistrict').val(null).trigger('change').prop('disabled', true);
        $('#village').val(null).trigger('change').prop('disabled', true);

        $('#tipe_level2').prop('disabled', true).val('');
        $('#tipe_level4').prop('disabled', true).val('');

        $('#kode_mendagri_2').val('').prop('disabled', true);
        $('#kode_mendagri_3').val('').prop('disabled', true);
        $('#kode_mendagri_4').val('').prop('disabled', true);
    });

    $(document).on('click', '#search_kode_mendagri_1', function() {
        var province = $('#province').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/GetKodeProvinsi.php',
            dataType    : 'JSON',
            data        : {province: province},
            success     : function(response){
                let status = response.status;
                let kode_mendagri_1 = response.kode;
                if(status=='success'){
                    $('#kode_mendagri_1').val(kode_mendagri_1);
                }else{
                    $('#notifikasi_kode_mendagri_1').html('<small class="text-warning"><i class="bi bi-exclamation-circle"></i> Kode Tidak Ditemukan</small>');
                }
            }
        });
    });

    // HANDLE FORM regency
    $('#regency').select2({
        dropdownParent: $('#ModalTambahWilayah'),
        theme         : 'bootstrap-5',
        placeholder   : "- Pilih Kabupaten / Kota -",
        allowClear    : true,
        tags          : true,

        ajax: {
            url     : "_Page/ReferensiWilayah/GetKabupaten.php",
            type    : "POST",
            dataType: "json",
            delay   : 250,

            data: function (params) {
                return {
                    keyword : params.term || '',
                    page    : params.page || 1,
                    province: $('#province').val() // 🔥 FIX
                };
            },

            processResults: function (data, params) {
                return {
                    results   : data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            }
        }
    });

     $('#regency').on('select2:select', function (e) {

        // tetap aktifkan level berikutnya
        $('#subdistrict').prop('disabled', false);
        $('#kode_mendagri_3').prop('disabled', false);
    });
    
    $('#regency').on('select2:clear', function () {
        // reset semua bawahnya
        $('#subdistrict').val(null).trigger('change').prop('disabled', true);
        $('#village').val(null).trigger('change').prop('disabled', true);

        $('#tipe_level4').prop('disabled', true).val('');

        $('#kode_mendagri_3').val('').prop('disabled', true);
        $('#kode_mendagri_4').val('').prop('disabled', true);
    });

    $(document).on('click', '#search_kode_mendagri_2', function() {
        var province = $('#province').val();
        var regency = $('#regency').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/GetKodeKabupaten.php',
            dataType    : 'JSON',
            data        : {province: province, regency: regency},
            success     : function(response){
                let status = response.status;
                let kode_mendagri_2 = response.kode;
                if(status=='success'){
                    $('#kode_mendagri_2').val(kode_mendagri_2);
                }else{
                    $('#notifikasi_kode_mendagri_2').html('<small class="text-warning"><i class="bi bi-exclamation-circle"></i> Kode Tidak Ditemukan</small>');
                }
            }
        });
    });

    // HANDLE FORM subdistrict
    $('#subdistrict').select2({
        dropdownParent: $('#ModalTambahWilayah'),
        theme         : 'bootstrap-5',
        placeholder   : "- Pilih Kecamatan -",
        allowClear    : true,
        tags          : true,

        ajax: {
            url     : "_Page/ReferensiWilayah/GetKecamatan.php",
            type    : "POST",
            dataType: "json",
            delay   : 250,

            data: function (params) {
                return {
                    keyword : params.term || '',
                    page    : params.page || 1,
                    province: $('#province').val(),
                    regency : $('#regency').val()
                };
            },

            processResults: function (data, params) {
                return {
                    results   : data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            }
        }
    });

     $('#subdistrict').on('select2:select', function (e) {

        // tetap aktifkan level berikutnya
        $('#tipe_level4').prop('disabled', false);
        $('#village').prop('disabled', false);
        $('#kode_mendagri_4').prop('disabled', false);
    });
    
    $('#subdistrict').on('select2:clear', function () {
        // reset semua bawahnya
        $('#village').val(null).trigger('change').prop('disabled', true);
        $('#tipe_level4').prop('disabled', true).val('');
        $('#kode_mendagri_4').val('').prop('disabled', true);
    });

    $(document).on('click', '#search_kode_mendagri_3', function() {
        var province = $('#province').val();
        var regency = $('#regency').val();
        var subdistrict = $('#subdistrict').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/GetKodeKecamatan.php',
            dataType    : 'JSON',
            data        : {province: province, regency: regency, subdistrict: subdistrict},
            success     : function(response){
                let status = response.status;
                let kode_mendagri_3 = response.kode;
                if(status=='success'){
                    $('#kode_mendagri_3').val(kode_mendagri_3);
                }else{
                    $('#notifikasi_kode_mendagri_3').html('<small class="text-warning"><i class="bi bi-exclamation-circle"></i> Kode Tidak Ditemukan</small>');
                }
            }
        });
    });

    // HANDLE FORM subdistrict
    $(document).on('click', '#search_kode_mendagri_4', function() {
        var province    = $('#province').val();
        var regency     = $('#regency').val();
        var subdistrict = $('#subdistrict').val();
        var village     = $('#village').val();
        $.ajax({
            type    : 'POST',
            url     : '_Page/ReferensiWilayah/GetKodeDesa.php',
            dataType: 'JSON',
            data    : {province: province, regency: regency, subdistrict: subdistrict, village: village},
            success : function(response){
                let status          = response.status;
                let kode_mendagri_4 = response.kode;
                if(status=='success'){
                    $('#kode_mendagri_4').val(kode_mendagri_4);
                }else{
                    $('#notifikasi_kode_mendagri_4').html('<small class="text-warning"><i class="bi bi-exclamation-circle"></i> Kode Tidak Ditemukan</small>');
                }
            }
        });
    });

    // Submit Tambah Wilayah
    $(document).on('submit', '#ProsesTambahWilayah', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahWilayah');
        let modal      = $('#ModalTambahWilayah');
        let notifikasi = $('#NotifikasiTambahWilayah');

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
            url      : '_Page/ReferensiWilayah/ProsesTambahWilayah.php',
            type     : 'POST',
            data     : formData,
            dataType : 'json',

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Wilayah berhasil',
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
                    TabelWilayah();

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
    // DOWNLOAD WILAYAH
    //==================================================================
    $(document).on('click', '.modal_download', function () {

        $('#ModalDownload').modal('show');
        $('#NotifikasiDownload').html('');
        $('#FormDownload').html('Loading...');

        $.ajax({
            type: 'POST',
            url : '_Page/ReferensiWilayah/FormDownload.php',

            success: function(data){
                $('#FormDownload').html(data);
            },

            error: function(){
                $('#FormDownload').html(`
                    <div class="alert alert-danger text-center">
                        <small>Gagal memuat form download</small>
                    </div>
                `);
            }
        });
    });

    // Submit download
    $(document).on('submit', '#ProsesDownload', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // langsung redirect ke file generate
        window.open('_Page/ReferensiWilayah/ProsesDownload.php?' + formData, '_blank');
    });

    //==================================================================
    // IMPORT / UPLOAD WILAYAH
    //==================================================================
    // OPEN MODAL (RESET STATE)
    $(document).on('click', '.modal_upload', function () {

        $('#ModalUpload').modal('show');

        // reset form
        $('#ProsesUpload')[0].reset();

        // reset progress
        $('#progressContainer').addClass('d-none');
        $('#progressBar').css('width', '0%').text('0%');
        $('#progressText').text('Menunggu proses...');
        $('#NotifikasiUpload').html('');

        $('#ButtonUpload').prop('disabled', false);
    });


    // PROSES CHUNK
    function prosesChunk(id_upload) {

        $.ajax({
            url: '_Page/ReferensiWilayah/ProsesChunk.php',
            type: 'POST',
            data: {id_upload: id_upload},
            dataType: 'json',

            success: function(res) {

                let persen = res.progress || 0;

                $('#progressBar')
                    .css('width', persen + '%')
                    .text(persen + '%');

                $('#progressText').text('Memproses data... ' + persen + '%');

                if (res.status === 'lanjut') {

                    // kasih jeda biar UI smooth
                    setTimeout(function () {
                        prosesChunk(id_upload);
                    }, 150);

                } else if (res.status === 'selesai') {

                    $('#progressBar')
                        .removeClass('progress-bar-animated')
                        .addClass('bg-success')
                        .text('100%');

                    $('#progressText').text('Selesai');

                    Swal.fire({
                        icon: 'success',
                        title: 'Upload selesai',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#ButtonUpload').prop('disabled', false);

                    TabelWilayah();
                    $('#ModalUpload').modal('hide');

                } else {

                    $('#progressText').text('Terjadi kesalahan');
                    $('#ButtonUpload').prop('disabled', false);
                }
            },

            error: function(xhr) {
                console.log(xhr.responseText);

                $('#progressText').text('Error server');
                $('#ButtonUpload').prop('disabled', false);
            }
        });
    }


    // SUBMIT UPLOAD
    $(document).on('submit', '#ProsesUpload', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        // validasi file kosong
        if (!$('#file_upload').val()) {
            $('#NotifikasiUpload').html(`
                <div class="alert alert-danger">File belum dipilih</div>
            `);
            return;
        }

        $('#ButtonUpload').prop('disabled', true);

        // tampilkan progress
        $('#progressContainer').removeClass('d-none');
        $('#progressText').text('Uploading file...');

        $.ajax({
            url: '_Page/ReferensiWilayah/UploadFile.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function(res) {

                if (res.status === 'success') {

                    $('#progressText').text('File uploaded, memulai proses...');

                    // mulai chunk
                    prosesChunk(res.id_upload);

                } else {

                    $('#NotifikasiUpload').html(`
                        <div class="alert alert-danger">${res.message}</div>
                    `);

                    $('#ButtonUpload').prop('disabled', false);
                    $('#progressContainer').addClass('d-none');
                }
            },

            error: function(xhr) {

                console.log(xhr.responseText);

                $('#NotifikasiUpload').html(`
                    <div class="alert alert-danger">Server error</div>
                `);

                $('#ButtonUpload').prop('disabled', false);
                $('#progressContainer').addClass('d-none');
            }
        });
    });

    //==================================================================
    // DETAIL WILAYAH
    //==================================================================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Google Credential
        var id_wilayah = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailWilayah').modal('show');

        // Loading Form
        $('#FormDetailWilayah').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/FormDetailWilayah.php',
            data        : {id_wilayah: id_wilayah},
            success     : function(data){
                $('#FormDetailWilayah').html(data);
            }
        });
    });

    //==================================================================
    // DESA
    //==================================================================

    // Modal Edit Desa
    $(document).on('click', '.modal_edit_desa', function () {

        //Catch id_wilayah
        var id_wilayah = $(this).data('id');
        
        // Show Modal
        $('#ModalEditDesa').modal('show');

        // Clear Notification
        $('#NotifikasiEditDesa').html('');

        // Loading Form
        $('#FormEditDesa').html('Loading...');

        $.ajax({
            type : 'POST',
            url  : '_Page/ReferensiWilayah/FormEditDesa.php',
            data : {id_wilayah: id_wilayah},
            success: function(data){
                $('#FormEditDesa').html(data);
            }
        });
    });

    $(document).on('submit', '#ProsesEditDesa', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditDesa');
        let modal      = $('#ModalEditDesa');
        let notifikasi = $('#NotifikasiEditDesa');

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
            url      : '_Page/ReferensiWilayah/ProsesEditDesa.php',
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
                    TabelWilayah();

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Wilayah berhasil',
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

    // Modal Hapus Desa
    $(document).on('click', '.modal_hapus_desa', function () {

        // Tangkap id
        var id_wilayah = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusDesa').modal('show');

        // Loading Form
        $('#FormHapusDesa').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusDesa').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/FormHapusDesa.php',
            data        : {id_wilayah: id_wilayah},
            success     : function(data){
                $('#FormHapusDesa').html(data);
            }
        });
    });

    // Submit Hapus Desa
    $(document).on('submit', '#ProsesHapusDesa', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusDesa');
        let modal      = $('#ModalHapusDesa');
        let notifikasi = $('#NotifikasiHapusDesa');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ReferensiWilayah/ProsesHapusDesa.php',
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
                        title            : 'Hapus Wilayah Desa/Kelurahan Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelWilayah();

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
    // KECAMATAN
    //==================================================================
    // Modal Edit Desa
    $(document).on('click', '.modal_edit_kecamatan', function () {

        //Catch id_wilayah
        var id_wilayah = $(this).data('id');
        
        // Show Modal
        $('#ModalEditKecamatan').modal('show');

        // Clear Notification
        $('#NotifikasiEditKecamatan').html('');

        // Loading Form
        $('#FormEditKecamatan').html('Loading...');

        $.ajax({
            type : 'POST',
            url  : '_Page/ReferensiWilayah/FormEditKecamatan.php',
            data : {id_wilayah: id_wilayah},
            success: function(data){
                $('#FormEditKecamatan').html(data);
            }
        });
    });

    $(document).on('submit', '#ProsesEditKecamatan', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditKecamatan');
        let modal      = $('#ModalEditKecamatan');
        let notifikasi = $('#NotifikasiEditKecamatan');

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
            url      : '_Page/ReferensiWilayah/ProsesEditKecamatan.php',
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
                    TabelWilayah();

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Wilayah berhasil',
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

    // Modal Hapus Kecamatan
    $(document).on('click', '.modal_hapus_kecamatan', function () {

        // Tangkap id
        var id_wilayah = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusKecamatan').modal('show');

        // Loading Form
        $('#FormHapusKecamatan').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikassiHapusKecamatan').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/FormHapusKecamatan.php',
            data        : {id_wilayah: id_wilayah},
            success     : function(data){
                $('#FormHapusKecamatan').html(data);
            }
        });
    });

    // Submit Hapus Desa
    $(document).on('submit', '#ProsesHapusKecamatan', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusKecamatan');
        let modal      = $('#ModalHapusKecamatan');
        let notifikasi = $('#NotifikassiHapusKecamatan');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ReferensiWilayah/ProsesHapusKecamatan.php',
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
                        title            : 'Hapus Wilayah Kecamatan Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelWilayah();

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
    // KABUPATEN / KOTA
    //==================================================================
    // Modal Edit
    $(document).on('click', '.modal_edit_kabupaten', function () {

        //Catch id_wilayah
        var id_wilayah = $(this).data('id');
        
        // Show Modal
        $('#ModalEditKabupaten').modal('show');

        // Clear Notification
        $('#NotifikasiEditKabupaten').html('');

        // Loading Form
        $('#FormEditKabupaten').html('Loading...');

        $.ajax({
            type : 'POST',
            url  : '_Page/ReferensiWilayah/FormEditKabupaten.php',
            data : {id_wilayah: id_wilayah},
            success: function(data){
                $('#FormEditKabupaten').html(data);
            }
        });
    });

    $(document).on('submit', '#ProsesEditKabupaten', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditKabupaten');
        let modal      = $('#ModalEditKabupaten');
        let notifikasi = $('#NotifikasiEditKabupaten');

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
            url      : '_Page/ReferensiWilayah/ProsesEditKabupaten.php',
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
                    TabelWilayah();

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Wilayah berhasil',
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

    // Modal Hapus
    $(document).on('click', '.modal_hapus_kabupaten', function () {

        // Tangkap id
        var id_wilayah = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusKabupaten').modal('show');

        // Loading Form
        $('#FormHapusKabupaten').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusKabupaten').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/FormHapusKabupaten.php',
            data        : {id_wilayah: id_wilayah},
            success     : function(data){
                $('#FormHapusKabupaten').html(data);
            }
        });
    });

    // Submit Hapus Desa
    $(document).on('submit', '#ProsesHapusKabupaten', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusKabupaten');
        let modal      = $('#ModalHapusKabupaten');
        let notifikasi = $('#NotifikasiHapusKabupaten');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ReferensiWilayah/ProsesHapusKabupaten.php',
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
                        title            : 'Hapus Wilayah Kabupaten/Kota Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelWilayah();

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
    // PROVINSI
    //==================================================================
    // Modal Edit
    $(document).on('click', '.modal_edit_provinsi', function () {

        //Catch id_wilayah
        var id_wilayah = $(this).data('id');
        
        // Show Modal
        $('#ModalEditProvinsi').modal('show');

        // Clear Notification
        $('#NotifikasiEditProvinsi').html('');

        // Loading Form
        $('#FormEditProvinsi').html('Loading...');

        $.ajax({
            type : 'POST',
            url  : '_Page/ReferensiWilayah/FormEditProvinsi.php',
            data : {id_wilayah: id_wilayah},
            success: function(data){
                $('#FormEditProvinsi').html(data);
            }
        });
    });

    $(document).on('submit', '#ProsesEditProvinsi', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditProvinsi');
        let modal      = $('#ModalEditProvinsi');
        let notifikasi = $('#NotifikasiEditProvinsi');

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
            url      : '_Page/ReferensiWilayah/ProsesEditProvinsi.php',
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
                    TabelWilayah();

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Wilayah berhasil',
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

    // Modal Hapus
    $(document).on('click', '.modal_hapus_provinsi', function () {

        // Tangkap id
        var id_wilayah = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusProvinsi').modal('show');

        // Loading Form
        $('#FormHapusProvinsi').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusProvinsi').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayah/FormHapusProvinsi.php',
            data        : {id_wilayah: id_wilayah},
            success     : function(data){
                $('#FormHapusProvinsi').html(data);
            }
        });
    });

    // Submit Hapus Desa
    $(document).on('submit', '#ProsesHapusProvinsi', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusProvinsi');
        let modal      = $('#ModalHapusProvinsi');
        let notifikasi = $('#NotifikasiHapusProvinsi');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ReferensiWilayah/ProsesHapusProvinsi.php',
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
                        title            : 'Hapus Wilayah Provinsi Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelWilayah();

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
