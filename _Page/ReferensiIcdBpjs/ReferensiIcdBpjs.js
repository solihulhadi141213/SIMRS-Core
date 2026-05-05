// Tabel ICD BPJS
function TabelIcdBpjs() {

    let prosesFilter = $('#ProsesFilterIcdBpjs').serialize();
    let target = $('#tabel_icd_bpjs');

    // Efek loading
    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiIcdBpjs/TabelIcdBpjs.php',
        data: prosesFilter,

        success: function(response) {

            target.css('opacity', '0');

            setTimeout(function () {

                target.html(response)
                      .css('opacity', '1');

                setTimeout(function () {
                    target.removeClass('blur-loading');
                }, 200);

            }, 150);
        },

        error: function(xhr, status, error) {

            target.html(`
                <tr>
                    <td colspan="5" class="text-center">
                        <small class="text-danger">
                            Terjadi kesalahan AJAX : ${error}
                        </small>
                    </td>
                </tr>
            `);

            target.removeClass('blur-loading');
            target.css('opacity', '1');
        }
    });
}

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {

    // Fokus Ke Keyword
    $('#keyword').focus();

    // Tampilkam Data
    TabelIcdBpjs();

    // Ketika Submit ProsesFilterIcdBpjs
     $(document).on('submit', '#ProsesFilterIcdBpjs', function (e) {
        e.preventDefault();

        TabelIcdBpjs();

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

    // TAMBAH ICD
    $(document).on('click', '.modal_tambah_icd', function () {

        let icd = $(this).data('icd');
        let kode = $(this).data('kode');
        let nama = $(this).data('nama');

        $('#icd_add').val(icd);
        $('#kode_add').val(kode);
        $('#short_des_add').val(nama);
        $('#long_des_add').val(nama);

        // Show Modal
        $('#ModalTambahIcd').modal('show');

    });
    
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

                    TabelIcdBpjs();

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