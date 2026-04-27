
// Tabel ICD
function TabelIcd() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_icd');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiIcd/TabelIcd.php',
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

    
    // Default Load ICD
    let default_version = 'ICD10';
    $('#icd_version').val(default_version);
    $('#icd').val(default_version);

    // Tabel ICD
    TabelIcd();

    // Ketika Versi Dipilih dari dropdown
    $(document).on('click', '.version_icd', function() {

        var version_icd = $(this).data('id');

        // 1. Update tombol dropdown
        $('.version_title').html('<i class="bi bi-chevron-down"></i> ' + version_icd);

        // 2. Isi ke form FILTER
        $('#icd_version').val(version_icd);

        // 3. Isi ke form TAMBAH
        $('#icd').val(version_icd);

        // 4. Reset halaman (pagination)
        $('#page_filter').val('1');

        // 5. Reload tabel
        TabelIcd();
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelIcd();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelIcd(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelIcd(0);
    });

    // TAMBAH ICD
    
    // Submit Tambah ICD
    $(document).on('submit', '#ProsesTambahIcd', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahIcd');
        let modal      = $('#ModalTambahIcd');
        let notifikasi = $('#NotifikasiTambahIcd');

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
            url        : '_Page/ReferensiIcd/ProsesTambahIcd.php',
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
                        title            : 'Tambah ICD Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // reset page ke halaman pertama
                    $('#page').val('1');

                    // reset select field
                    $('#keyword').val('');
                    $('#keyword_by').val('');
                    $('#OrderBy').val('');
                    $('#ShortBy').val('DESC');
                    $('#batas').val('10');

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelIcd();

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

    // DETAIL ICD
    $(document).on('click', '.modal_detail', function () {

        let id_icd = $(this).data('id');

        $('#ModalDetailIcd').modal('show');
        $('#FormDetailIcd').html('Loading...');

        $.ajax({
            type: 'POST',
            url : '_Page/ReferensiIcd/FormDetailIcd.php',
            data: { id_icd: id_icd },
            success: function(data){
                $('#FormDetailIcd').html(data);
            }
        });
    });

    // EDIT ICD
    $(document).on('click', '.modal_edit', function () {

        var id_icd = $(this).data('id');

        $('#ModalEditIcd').modal('show');
        $('#NotifikasiEditIcd').html('');
        $('#FormEditIcd').html('Loading...');

        $.ajax({
            type : 'POST',
            url  : '_Page/ReferensiIcd/FormEditIcd.php',
            data : {id_icd: id_icd},

            success: function(data){
                $('#FormEditIcd').html(data);
            }
        });
    });

    // Submit Edit ICD
    $(document).on('submit', '#ProsesEditIcd', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditIcd');
        let modal      = $('#ModalEditIcd');
        let notifikasi = $('#NotifikasiEditIcd');

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
            url        : '_Page/ReferensiIcd/ProsesEditIcd.php',
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
                        title            : 'Edit ICD Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelIcd();

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

    // HAPUS ICD
    $(document).on('click', '.modal_delete', function () {

        let id_icd = $(this).data('id');

        $('#ModalHapusIcd').modal('show');
        $('#NotifikasiHapusIcd').html('');
        $('#FormHapusIcd').html('Loading...');

        $.ajax({
            type: 'POST',
            url : '_Page/ReferensiIcd/FormHapusIcd.php',
            data: { id_icd: id_icd },

            success: function(data){
                $('#FormHapusIcd').html(data);
            }
        });
    });

    // Submit Hapus ICD
    $(document).on('submit', '#ProsesHapusIcd', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusIcd');
        let modal      = $('#ModalHapusIcd');
        let notifikasi = $('#NotifikasiHapusIcd');

        let buttonText = button.html();
        let formData   = new FormData(this);

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiIcd/ProsesHapusIcd.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    modal.modal('hide');

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data ICD berhasil dihapus',
                        showConfirmButton: false,
                        timer: 1200
                    });

                    TabelIcd();

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

    // DOWNLOAD ICD
    $(document).on('click', '.modal_download', function () {

        $('#ModalDownload').modal('show');
        $('#NotifikasiDownload').html('');
        $('#FormDownload').html('Loading...');

        $.ajax({
            type: 'POST',
            url : '_Page/ReferensiIcd/FormDownload.php',

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
        window.open('_Page/ReferensiIcd/ProsesDownload.php?' + formData, '_blank');
    });

    // UPLOAD ICD

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
            url: '_Page/ReferensiIcd/ProsesChunk.php',
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

                    TabelIcd();
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
            url: '_Page/ReferensiIcd/UploadFile.php',
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
});