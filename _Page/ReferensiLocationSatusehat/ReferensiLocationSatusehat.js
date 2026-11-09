// =========================================================================================
/** BLOCK FUNCTION */
// Agar Rapih maka semua function disimpan pada block ini
// =========================================================================================

/** Menampilkan Data Berdasarkan Filter */
function TabelLocation() {

    // Menangkap Data Dari Form Filter
    var ProsesFilter = $('#ProsesFilter').serialize();

    // Tujuan Ajax
    let target = $('#tabel_locatiohn');

    target.addClass('blur-loading');

    $.ajax({
        type   : 'POST',
        url    : '_Page/ReferensiLocationSatusehat/TabelReferensiLocationSatusehat.php',
        data   : ProsesFilter,
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



// =========================================================================================
// BLOCK EVENT HANDLER
// Semua event dan handler disimpan pada block ini
// =========================================================================================
$(document).ready(function () {
    
    // Tampilkan data antrean pertama kali.
    TabelLocation();

    // Auto Focus Keyword
    $('#ModalFilter').on('shown.bs.modal', function () {
        $('#keyword_form').focus();
    });

    // Submit Pencarian/Filter
    $('#ProsesFilter').submit(function () {
        $('#page_filter').val("1");
        TabelLocation();
        $('#ModalFilter').modal('hide');
    });

    // ===============================
    // TAMBAH LOCATION
    // ===============================
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
            url        : '_Page/ReferensiLocationSatusehat/ProsesTambah.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                // Jika Response Berhasil 'success'
                if (response.status === 'success') {

                    // Reset form tambah
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
                        title            : 'Tambah location Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Reset Filter
                    let filterForm = $('#ProsesFilter');

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelLocation();

                } else {

                    // Tampilkan error
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small></small>
                        </div>
                    `).find('small').text(response.message || 'Location gagal dibuat.');
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

    // ===============================
    // DETAIL LOCATION
    // ===============================
    $(document).on('click', '.modal_detail', function () {

        // Ambil ID id_location
        let id_location = $(this).data('id');

        // Validasi
        if (!id_location) {
            console.error('ID location tidak boleh kosong');
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
            url    : '_Page/ReferensiLocationSatusehat/FormDetail.php',
            type   : 'POST',
            data   : {id_location: id_location},
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
                            Gagal memuat detail!<br>
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

    // ===============================
    // EDIT LOCATION
    // ===============================

    // Menampilkan Form Edit
    $(document).on('click', '.modal_edit', function () {

        // Ambil ID id_location
        let id_location = $(this).data('id');

        // Loading View
        $('#FormEdit')
            .html(`
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                    <div>
                        <small class="text-muted">Memuat Form...</small>
                    </div>
                </div>
            `)
            .css({
                opacity: 0,
                filter: 'blur(6px)'
            });

        // Tampilkan Modal
        $('#ModalEdit').modal('show');

        // Tombol Edit dalam kondisi disable saat modal pertama kali muncul
        $('#ButtonEdit').prop('disabled', true);

        // Smooth Loading Animation
        $('#FormEdit').animate({
            opacity: 1
        }, 200);

        // AJAX
        $.ajax({
            url    : '_Page/ReferensiLocationSatusehat/FormEdit.php',
            type   : 'POST',
            dataType   : 'json',
            data   : {id_location: id_location},
            timeout: 10000,
            success: function (response) {

                var status       = response.status;
                var message      = response.message;
                var EditFormHtml = response.EditFormHtml;

                if (status === 'success' && typeof EditFormHtml === 'string') {
                    // Fade Out Sebelum Replace
                    $('#FormEdit').animate({
                        opacity: 0
                    }, 120, function () {

                        // Replace Content
                        $(this)
                            .html(EditFormHtml)
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
                                $('#FormEdit').css('filter', `blur(${this.blur}px)`);
                            }
                        });

                        $('#FormEdit').animate({
                            opacity: 1
                        }, 250);
                    });

                    // Enable tombol edit setelah form berhasil dimuat
                    $('#ButtonEdit').prop('disabled', false);
                } else {
                    // Tampilkan pesan kesalahan pada FormEdit
                    $('#FormEdit').html(
                        $('<div class="alert alert-danger mb-0"><small></small></div>')
                            .find('small')
                            .text(message || 'Gagal memuat form edit Location.')
                            .end()
                    ).css({
                        opacity: 1,
                        filter: 'blur(0)'
                    });
                }
            },

            error: function (xhr, status, error) {

                console.error(error);

                $('#FormEdit').html(`
                    <div class="alert alert-danger mb-0">
                        <small>
                            Gagal memuat detail!<br>
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

    // Submit Edit
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
            url        : '_Page/ReferensiLocationSatusehat/ProsesEdit.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                // Jika Response Berhasil 'success'
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
                        title            : 'Edit location Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelLocation();

                } else {

                    // Tampilkan error
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small></small>
                        </div>
                    `).find('small').text(response.message || 'Terjadi kesalahan pada saat edit location.');
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

    // ===============================
    // STATUS LOCATION
    // ===============================
    $(document).on('click', '.modal_status', function () {
        let id_location = $(this).data('id');
        if (!id_location) {
            console.error('ID location tidak boleh kosong');
            return;
        }

        $('#FormStatus').html(`
            <div class="text-center py-4">
                <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                <div><small class="text-muted">Memuat form status...</small></div>
            </div>
        `);
        $('#NotifikasiStatus').html('');
        $('#ButtonStatus').prop('disabled', true);
        $('#ModalStatus').modal('show');

        $.ajax({
            url: '_Page/ReferensiLocationSatusehat/FormStatus.php',
            type: 'POST',
            dataType: 'json',
            data: {id_location: id_location},
            timeout: 10000,
            success: function (response) {
                if (response.status === 'success' && typeof response.FormStatusHtml === 'string') {
                    $('#FormStatus').html(response.FormStatusHtml);
                    $('#ButtonStatus').prop('disabled', false);
                } else {
                    $('#FormStatus').html(
                        $('<div class="alert alert-danger mb-0"><small></small></div>')
                            .find('small')
                            .text(response.message || 'Gagal memuat form status Location.')
                            .end()
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                $('#FormStatus').html(
                    $('<div class="alert alert-danger mb-0"><small></small></div>')
                        .find('small')
                        .text('Gagal memuat form status Location. Status: ' + status)
                        .end()
                );
            }
        });
    });

    // Submit perubahan status Location
    $(document).on('submit', '#ProsesStatus', function (e) {
        e.preventDefault();

        let button = $('#ButtonStatus');
        let modal = $('#ModalStatus');
        let notifikasi = $('#NotifikasiStatus');
        let buttonText = button.html();
        let formData = new FormData(this);

        notifikasi.html('');
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url: '_Page/ReferensiLocationSatusehat/ProsesStatus.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (response) {
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {
                    notifikasi.html('');
                    modal.modal('hide');

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Status location berhasil diperbarui',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });
                    TabelLocation();
                } else {
                    notifikasi.html(
                        $('<div class="alert alert-danger"><small></small></div>')
                            .find('small')
                            .text(response.message || 'Gagal memperbarui status Location.')
                            .end()
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                button.prop('disabled', false).html(buttonText);
                notifikasi.html(
                    $('<div class="alert alert-danger"><small></small></div>')
                        .find('small')
                        .text('Terjadi kesalahan saat memperbarui status Location. Status: ' + status)
                        .end()
                );
            }
        });
    });

    // ===============================
    // DEFAULT LOCATION
    // ===============================
    $(document).on('click', '.modal_default', function () {
        let id_location = $(this).data('id');
        if (!id_location) {
            console.error('ID location tidak boleh kosong');
            return;
        }

        $('#FormDefault').html(`
            <div class="text-center py-4">
                <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                <div><small class="text-muted">Memuat form status...</small></div>
            </div>
        `);
        $('#NotifikasiDefault').html('');
        $('#ButtonDefault').prop('disabled', true);
        $('#ModalDefault').modal('show');

        $.ajax({
            url     : '_Page/ReferensiLocationSatusehat/FormDefault.php',
            type    : 'POST',
            dataType: 'json',
            data    : {id_location: id_location},
            timeout : 10000,
            success : function (response) {
                if (response.status === 'success' && typeof response.FormDefaultHtml === 'string') {
                    $('#FormDefault').html(response.FormDefaultHtml);
                    $('#ButtonDefault').prop('disabled', false);
                } else {
                    $('#FormDefault').html(
                        $('<div class="alert alert-danger mb-0"><small></small></div>')
                            .find('small')
                            .text(response.message || 'Gagal memuat form Default Location.')
                            .end()
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                $('#FormStatus').html(
                    $('<div class="alert alert-danger mb-0"><small></small></div>')
                        .find('small')
                        .text('Gagal memuat form status Location. Status: ' + status)
                        .end()
                );
            }
        });
    });

    // Submit Default Location
    $(document).on('submit', '#ProsesDefault', function (e) {
        e.preventDefault();

        let button = $('#ButtonDefault');
        let modal = $('#ModalDefault');
        let notifikasi = $('#NotifikasiDefault');
        let buttonText = button.html();
        let formData = new FormData(this);

        notifikasi.html('');
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiLocationSatusehat/ProsesDefault.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,
            success    : function (response) {
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {
                    notifikasi.html('');
                    modal.modal('hide');

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Default location berhasil diperbarui',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });
                    TabelLocation();
                } else {
                    notifikasi.html(
                        $('<div class="alert alert-danger"><small></small></div>')
                            .find('small')
                            .text(response.message || 'Gagal memperbarui Default Location.')
                            .end()
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                button.prop('disabled', false).html(buttonText);
                notifikasi.html(
                    $('<div class="alert alert-danger"><small></small></div>')
                        .find('small')
                        .text('Terjadi kesalahan saat memperbarui Default Location. Status: ' + status)
                        .end()
                );
            }
        });
    });

});
