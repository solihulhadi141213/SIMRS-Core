// ====================================================================
// TABEL WILAYAH DENGAN TRANSISI BLUR
// ====================================================================
function ShowProvinsi(keyword) {

    // Tambahkan efek transisi jika belum ada
    if ($('#StyleBlurTransition').length === 0) {
        $('head').append(`
            <style id="StyleBlurTransition">
                #DataWilayahBpjs{
                    transition: all 0.35s ease;
                }

                .blur-loading{
                    opacity: 0.4;
                    filter: blur(4px);
                    transform: scale(0.98);
                    pointer-events: none;
                }

                .blur-show{
                    opacity: 1;
                    filter: blur(0px);
                    transform: scale(1);
                }
            </style>
        `);
    }

    // Efek loading
    $('#DataWilayahBpjs')
        .removeClass('blur-show')
        .addClass('blur-loading');

    // Loading sementara
    $('#DataWilayahBpjs').html(`
        <div class="col-12 text-center">
            <div class="card">
                <div class="card-body">
                    <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                    Loading...
                </div>
            </div>
        </div>
    `);

    // AJAX
    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiWilayahBpjs/TabelProvinsi.php',
        data : {keyword: keyword},

        success: function(data) {

            // Fade + blur transition
            $('#DataWilayahBpjs').fadeOut(150, function(){

                $('#DataWilayahBpjs')
                    .html(data)
                    .removeClass('blur-loading')
                    .addClass('blur-show')
                    .fadeIn(250);

            });
        },

        error: function() {
            $('#DataWilayahBpjs')
                .removeClass('blur-loading')
                .addClass('blur-show')
                .html(`
                    <div class="col-12">
                        <div class="alert alert-danger text-center">
                            Terjadi kesalahan saat memuat data.
                        </div>
                    </div>
                `);
        }
    });
}

function ShowKabupaten(){

    // Tangkap Data Dari Form
    var ProsesFilterKabupaten = $('#ProsesFilterKabupaten').serialize();

    // Loading TabelKabupaten
    $('#TabelKabupaten').html('<tr><td colspan="6" class="text-center"><small>Loading...</small></td></tr>');
    
    // Tampilkan Data Dengan AJAX
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ReferensiWilayahBpjs/TabelKabupaten.php',
        data        : ProsesFilterKabupaten,
        success     : function(data){
            $('#TabelKabupaten').html(data);
            $('#keyword_kabupaten').focus();
        }
    });
}

function ShowKecamatan(){

    // Tangkap Data Dari Form
    var ProsesFilterKecamatan = $('#ProsesFilterKecamatan').serialize();

    // Loading TabelKecamatan
    $('#TabelKecamatan').html('<tr><td colspan="8" class="text-center"><small>Loading...</small></td></tr>');
    
    // Tampilkan Data Dengan AJAX
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ReferensiWilayahBpjs/TabelKecamatan.php',
        data        : ProsesFilterKecamatan,
        success     : function(data){
            $('#TabelKecamatan').html(data);
            $('#keyword_kecamatan').focus();
        }
    });
}

// ====================================================================
// MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {

    // Tampilkan data
    ShowProvinsi();

    // Autofocus pencarian
    $('#keyword').focus();

    // Ketika Submit pencarian
    $('#ProsesFilter').submit(function(){
        var keyword = $('#keyword').val();
       ShowProvinsi(keyword);
    });

    //KABUPATEN
    $(document).on('click', '.modal_kabupaten', function() {

        // Tangkap Variabel
        var nama_prov         = $(this).data('nama_prov');
        var kode_prov         = $(this).data('kode_prov');
        var keyword_kabupaten = "";

        // Buka Modal
        $('#ModalKabupaten').modal('show');

        // Tempelkan Nilai Ke Form
        $('#nama_prov').val(nama_prov);
        $('#kode_prov').val(kode_prov);
        $('#keyword_kabupaten').val(keyword_kabupaten);

        // Tampilkan Data Dengan Function
        ShowKabupaten();
    });

    // Ketika submit pencarian
    $('#ProsesFilterKabupaten').submit(function(){
        ShowKabupaten();
    });

    //KECAMATAN
    $(document).on('click', '.modal_kecamatan', function() {

        // Tangkap Variabel
        var nama_prov         = $(this).data('nama_prov');
        var kode_prov         = $(this).data('kode_prov');
        var nama_kab         = $(this).data('nama_kab');
        var kode_kab         = $(this).data('kode_kab');
        var keyword_kecamatan = "";

        // Buka Modal
        $('#ModalKecamatan').modal('show');

        // Tempelkan Nilai Ke Form
        $('#nama_prov2').val(nama_prov);
        $('#kode_prov2').val(kode_prov);
        $('#nama_kab').val(nama_kab);
        $('#kode_kab').val(kode_kab);
        $('#keyword_kecamatan').val(keyword_kecamatan);

        // Tampilkan Data Dengan Function
        ShowKecamatan();
    });

    // Ketika submit pencarian
    $('#ProsesFilterKecamatan').submit(function(){
        ShowKecamatan();
    });

    // ================
    // TAMBAH KE SIMRS
    // ================
    $(document).on('click', '.modal_tambah_simrs', function() {

        // Tangkap Variabel
        var nama_prov         = $(this).data('nama_prov');
        var kode_prov         = $(this).data('kode_prov');
        var nama_kab         = $(this).data('nama_kab');
        var kode_kab         = $(this).data('kode_kab');
        var nama_kec         = $(this).data('nama_kec');
        var kode_kec         = $(this).data('kode_kec');
       
        // Buka Modal
        $('#ModalTambahSimrs').modal('show');
        
        // Loading Form
        $('#FormTambahSimrs').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahSimrs').html('');
        
        // Tampilkan Data Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayahBpjs/FormTambahSimrs.php',
            data        : {
                nama_prov: nama_prov, 
                kode_prov: kode_prov, 
                nama_kab: nama_kab, 
                kode_kab: kode_kab, 
                nama_kec: nama_kec, 
                kode_kec: kode_kec
            },
            success     : function(data){
                $('#FormTambahSimrs').html(data);
            }
        });
    });

    // Jika province change
    $(document).on('click', '#province', function() {
        var province = $(this).val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayahBpjs/option_regency.php',
            data        : {province: province},
            success     : function(data){
                $('#regency').html(data);
            }
        });
    });

    // Jika regency change
    $(document).on('click', '#regency', function() {
        var regency = $(this).val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiWilayahBpjs/option_subdistrict.php',
            data        : {regency: regency},
            success     : function(data){
                $('#subdistrict').html(data);
            }
        });
    });

    // Submit Tambah Wilayah
    $(document).on('submit', '#ProsesTambahSimrs', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahSimrs');
        let modal      = $('#ModalTambahSimrs');
        let notifikasi = $('#NotifikasiTambahSimrs');

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
            url      : '_Page/ReferensiWilayahBpjs/ProsesTambahSimrs.php',
            type     : 'POST',
            data     : formData,
            dataType : 'json',

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup Modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Wilayah Ke SIMRS Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    // Provinsi
                    ShowProvinsi();

                    // Reload Kabupaten
                    ShowKabupaten();

                    // Kecamatan
                    ShowKecamatan();

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