function ShowRadiologi(){

    var ProsesFilter = $('#ProsesCariDataKunjunganPasien').serialize();
    var $container  = $('#ListRadiologi');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url: '_Page/Radiologi/TabelRadiologi.php',
        data: ProsesFilter,
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({opacity: 0.3}, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Tangkap Halaman dan Posisi
            let currentPage = $('#page_rad').val();
            let totalPages = $('#total_page').val();

            // Preview Button
            if (currentPage <= 1) {
                $('#prev_rad').prop('disabled', true).addClass('disabled');
            } else {
                $('#prev_rad').prop('disabled', false).removeClass('disabled');
            }

            // Next button
            if (currentPage >= totalPages) {
                $('#next_rad').prop('disabled', true).addClass('disabled');
            } else {
                $('#next_rad').prop('disabled', false).removeClass('disabled');
            }
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

function ShowDetail(id_radiologi){

    var $container  = $('#FormDetail');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url: '_Page/Radiologi/FormDetail.php',
        data: {id_radiologi: id_radiologi},
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({opacity: 0.3}, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Tangkap Halaman dan Posisi
            let currentPage = $('#page_rad').val();
            let totalPages = $('#total_page').val();

            // Preview Button
            if (currentPage <= 1) {
                $('#prev_rad').prop('disabled', true).addClass('disabled');
            } else {
                $('#prev_rad').prop('disabled', false).removeClass('disabled');
            }

            // Next button
            if (currentPage >= totalPages) {
                $('#next_rad').prop('disabled', true).addClass('disabled');
            } else {
                $('#next_rad').prop('disabled', false).removeClass('disabled');
            }
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

function ShowHapus(id_radiologi){

    var $container  = $('#FormHapus');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url: '_Page/Radiologi/FormHapus.php',
        data: {id_radiologi: id_radiologi},
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({opacity: 0.3}, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

function ShowDataKunjungan(){

    var ProsesFilter = $('#ProsesCariDataKunjunganPasien').serialize();
    var $container  = $('#ListDataKunjunganUntukDipilih');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url: '_Page/Radiologi/TabelKunjungan.php',
        data: ProsesFilter,
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({
                opacity: 0.3
            }, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

function ShowDataPemeriksaan(){

    var ProsesCariPermintaanPemeriksaan = $('#ProsesCariPermintaanPemeriksaan').serialize();
    var $container  = $('#ListDataPemeriksaan');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container.outerHeight();
    $container.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url : '_Page/Radiologi/TabelPemeriksaan.php',
        data: ProsesCariPermintaanPemeriksaan,
        beforeSend: function () {
            // Fade out halus
            $container.stop(true, true).animate({
                opacity: 0.3
            }, 150);
        },
        success: function (data) {
            // Ganti konten
            $container.html(data);
        },
        complete: function () {
            // Fade in kembali
            $container.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container.css('min-height', '');
            });
        }
    });
   
}

function ShowDataKlinis(){
    var ProsesCariKlinis = $('#ProsesCariKlinis').serialize();
    var $container2  = $('#ListKlinis');

    // Simpan tinggi awal untuk mencegah loncat
    var currentHeight = $container2.outerHeight();
    $container2.css('min-height', currentHeight + 'px');

    $.ajax({
        type: 'POST',
        url : '_Page/Radiologi/TabelKlinis.php',
        data: ProsesCariKlinis,
        beforeSend: function () {
            // Fade out halus
            $container2.stop(true, true).animate({opacity: 0.3}, 150);
        },
        success: function (data) {
            // Ganti konten
            $container2.html(data);
        },
        complete: function () {
            // Fade in kembali
            $container2.stop(true, true).animate({
                opacity: 1
            }, 200, function () {
                // Lepaskan tinggi setelah animasi selesai
                $container2.css('min-height', '');
            });
        }
    });
}

$(document).ready(function() {
    var DEV_DELAY = true;
    var delayTime = DEV_DELAY ? 1000 : 0;

    // Inisialisasi Data Pertama Kali
    ShowRadiologi();

    //Pagging Radiologi
    $(document).on('click', '#prev_rad', function() {
        var page_now = parseInt($('#page_rad').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_rad').val(next_page);
        ShowRadiologi(0);
    });
    $(document).on('click', '#next_rad', function() {
        var page_now = parseInt($('#page_rad').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_rad').val(next_page);
        ShowRadiologi(0);
    });

    $('#ProsesCariDataKunjunganPasien').submit(function(){
        $('#page_rad').val(1);
        ShowRadiologi();

        $('#ModalFilter').modal('hide');
    });

    //---------------------------------------------------------------------------------------------------
    // Detail Radiologi
    //---------------------------------------------------------------------------------------------------
    $('#ModalDetail').on('show.bs.modal', function (e) {

        // Get id_radiologi
        var id_radiologi = $(e.relatedTarget).data('id');

        // Loading
        $('#FormDetail').html('<div class="alert alert-dark text-center">Mengambil Data ..</div>');

        // Tampilkan Data Dengan function 'ShowDetail(id_radiologi)'
        ShowDetail(id_radiologi);
    });

    //---------------------------------------------------------------------------------------------------
    // Hapus Radiologi
    //---------------------------------------------------------------------------------------------------
    $('#ModalHapus').on('show.bs.modal', function (e) {

        // Get id_radiologi
        var id_radiologi = $(e.relatedTarget).data('id');

        // Sembunyikan Tombol
        $('#ButtonHapus').hide();

        // Loading
        $('#FormHapus').html('<div class="alert alert-dark text-center">Mengambil Data ..</div>');

        // Tampilkan Data Dengan function 'ShowDetail(id_radiologi)'
        ShowHapus(id_radiologi);
    });

    // Proses Hapus
    $('#ProsesHapus').submit(function(e){

        // Stop Submit Double
        e.preventDefault();

        // Ambil data form
        var formData = $(this).serialize();

        // Loading state
        $('#NotifikasiHapus').html(
            '<div class="alert alert-info">Mengirim permintaan...</div>'
        );

        // Disable tombol submit sementara
        $('#ProsesHapus button[type="submit"]').prop('disabled', true);

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Radiologi/ProsesHapus.php',
            data    : formData,

            success: function(response) {

                // Tampilkan response ke notifikasi
                $('#NotifikasiHapus').html(response);

                // Ambil status insert dari HTML response
                var status = $('#InsertNotif').html();

                // Jika BERHASIL
                if (status === "Berhasil") {
                    // Tutup Modal
                    $('#ModalHapus').modal('hide');

                    // Tampilkan Swal
                    Swal.fire({
                        title: 'Mantap!',
                        text: 'Hapus Radiologi Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    });

                    // Tampilkan Data
                    ShowRadiologi();

                }

                // Enable kembali tombol submit
                $('#ProsesHapus button[type="submit"]').prop('disabled', false);
            },

            error: function(xhr, status, error) {

                $('#NotifikasiHapus').html(
                    '<div class="alert alert-danger">AJAX Error: '+error+'</div>'
                );

                $('#ProsesHapus button[type="submit"]').prop('disabled', false);
            }
        });
    });

    // =================================================================================================
    // KUNJUNGAN
    // =================================================================================================
    //Ketika 'ModalKunjungan' Muncul
    $('#ModalPilihDataKunjungan').on('show.bs.modal', function (e) {
        // Tampilkan Data Dengan function 'ShowDataKunjungan()'
        ShowDataKunjungan();
    });

    //Pagging
    $(document).on('click', '#btn_next', function() {
        var page_now = parseInt($('#page_kunjungan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_kunjungan').val(next_page);
        ShowDataKunjungan(0);
    });
    $(document).on('click', '#btn_prev', function() {
        var page_now = parseInt($('#page_kunjungan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_kunjungan').val(next_page);
        ShowDataKunjungan(0);
    });

    $('#ProsesCariDataKunjunganPasien').submit(function(){
        $('#page_kunjungan').val(1);
       ShowDataKunjungan();
    });

    //Ketika 'pilih_kunjungan' di click
    $(document).on('click', '.pilih_kunjungan', function() {
        var id_kunjungan = $(this).data('id');

        var $wrapper = $('#WrapperTabelKunjungan');
        var $table   = $('#ListDataKunjunganUntukDipilih');

        // Tambahkan blur + overlay loading
        $table.addClass('loading-blur');

        if ($wrapper.find('.loading-overlay').length === 0) {
            $wrapper.append(`
                <div class="loading-overlay">
                    <i class="ti ti-loader ti-spin"></i> Memproses...
                </div>
            `);
        }
        setTimeout(function(){
            $.ajax({
                type    : 'POST',
                url     : '_Page/Radiologi/konfirmasi_kunjungan.php',
                data    : {id_kunjungan: id_kunjungan},
                dataType: "json",

                success : function(response){
                    console.log(response);

                    if(response.status === "Success"){
                        $('#id_pasien').val(response.id_pasien);
                        $('#id_kunjungan').val(id_kunjungan);
                        $('#nama').val(response.nama);
                        $('#tujuan_kunjungan').val(response.tujuan);
                        $('#jenis_pembayaran').val(response.pembayaran);
                        $('#asal_kiriman').val(response.asal_kiriman);
                        $('#dokter_pengirim').val(response.id_dokter);

                        $('#ModalPilihDataKunjungan').modal('hide');

                    } else {
                        $('#ModalPilihDataKunjungan').modal('hide');

                        Swal.fire({
                            title: 'Ooops!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Tutup'
                        });
                    }
                },

                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal menghubungi server.',
                        icon: 'error'
                    });
                },

                complete: function() {
                    // Hilangkan blur + overlay
                    $table.removeClass('loading-blur');
                    $wrapper.find('.loading-overlay').remove();
                }
            });
        }, delayTime);
    });


    // ===================================================================================
    // PEMERIKSAAN
    // ===================================================================================
    $('#ModalPilihPermintaanPemeriksaan').on('show.bs.modal', function (e) {
        // Tangkap modality
        var modality = $('#alat_pemeriksa').val();

        // Tempel Ke form 'modality'
        $('#modality').val(modality);

        // Reset Halaman
        $('#page_pemeriksaan').val(1);

        // Tampilkan Data Dengan function 'ShowDataPemeriksaan()'
        ShowDataPemeriksaan();
    });

    $('#ProsesCariPermintaanPemeriksaan').submit(function(){
        // Tangkap modality
        var modality = $('#alat_pemeriksa').val();

        // Tempel Ke form 'modality'
        $('#modality').val(modality);

        // Reset Halaman
        $('#page_pemeriksaan').val(1);

        // Tampilkan Fungsi
        ShowDataPemeriksaan();
    });

    //Pagging
    $(document).on('click', '#btn_next_pemeriksaan', function() {
        var page_now = parseInt($('#page_pemeriksaan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_pemeriksaan').val(next_page);

        // Tampilkan Fungsi
        ShowDataPemeriksaan(0);
    });
    $(document).on('click', '#btn_prev_pemeriksaan', function() {
        var page_now = parseInt($('#page_pemeriksaan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_pemeriksaan').val(next_page);

        // Tampilkan Fungsi
        ShowDataPemeriksaan(0);
    });

    //Ketika 'pilih_pemeriksaan' di click
    $(document).on('click', '.pilih_pemeriksaan', function() {
        var jsonText = $(this).attr('data-json');
        var data = JSON.parse(jsonText);

        console.log('Pemeriksaan dipilih:', data);

        // Render nama di select
        $('#permintaan_pemeriksaan').html(
            '<option value="'+data.id_pemeriksaan+'">'+data.nama_pemeriksaan+'</option>'
        );

        // SIMPAN JSON STRING UTUH KE HIDDEN INPUT
        $('#permintaan_pemeriksaan_value').val(JSON.stringify(data));

        $('#ModalPilihPermintaanPemeriksaan').modal('hide');
    });

    // ===================================================================================
    // KLINIS
    // ===================================================================================
    $('#ModalKlinis').on('show.bs.modal', function (e) {

        // Reset Halaman
        $('#page_klinis').val(1);

        // Tampilkan Data Dengan function 'ShowDataKlinis()'
        ShowDataKlinis();
    });

    $('#ProsesCariKlinis').submit(function(){
        // Reset Halaman
        $('#page_klinis').val(1);

        // Tampilkan Fungsi
        ShowDataKlinis();
    });

    //Pagging
    $(document).on('click', '#btn_next_klinis', function() {
        var page_now = parseInt($('#page_klinis').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_klinis').val(next_page);

        // Tampilkan Fungsi
        ShowDataKlinis(0);
    });
    $(document).on('click', '#btn_prev_klinis', function() {
        var page_now = parseInt($('#page_klinis').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_klinis').val(next_page);

        // Tampilkan Fungsi
        ShowDataKlinis(0);
    });

   $(document).on('click', '.pilih_klinis', function() {

        var jsonText = $(this).attr('data-json');
        if (!jsonText) {
            console.warn("JSON kosong");
            return;
        }

        var data = JSON.parse(jsonText);

        console.log("Klinis dipilih:", data);

        // 1️⃣ Simpan JSON ke hidden input
        $('#klinis_value').val(jsonText);

        // 2️⃣ Ambil ID & Nama
        var id   = data.id_master_klinis;
        var nama = data.nama_klinis;

        if (!id || !nama) {
            console.warn("Data klinis tidak lengkap");
            return;
        }

        // 3️⃣ Cek apakah sudah ada di select
        var exists = $('#select_klinis option[value="' + id + '"]').length > 0;

        if (!exists) {
            $('#select_klinis').append(
                $('<option>', {
                    value: id,
                    text: nama,
                    selected: true
                })
            );
        } else {
            // Jika sudah ada, cukup select
            $('#select_klinis').val(id);
        }

        // 4️⃣ Tutup modal
        $('#ModalKlinis').modal('hide');
    });

    
    // PROSES TAMBAH PENDAFTARAN RADIOLOGI
    $('#ProsesPendaftaranRadiologi').submit(function(e){

        // Stop Submit Double
        e.preventDefault();

        // Ambil data form
        var formData = $(this).serialize();

        // Loading state
        $('#NotifikasiPendaftaranRadiologi').html(
            '<div class="alert alert-info">Mengirim permintaan...</div>'
        );

        // Disable tombol submit sementara
        $('#ProsesPendaftaranRadiologi button[type="submit"]').prop('disabled', true);

        // AJAX Submit
        $.ajax({
            type    : 'POST',
            url     : '_Page/Radiologi/ProsesPendaftaranRadiologi.php',
            data    : formData,

            success: function(response) {

                // Tampilkan response ke notifikasi
                $('#NotifikasiPendaftaranRadiologi').html(response);

                // Ambil status insert dari HTML response
                var status = $('#InsertNotif').html();

                // Jika BERHASIL
                if (status === "Berhasil") {
                
                    Swal.fire({
                        title: 'Pendaftaran Radiologi Berhasil',
                        text: 'Silahkan pilih tindakan selanjutnya',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Kembali ke Radiologi',
                        cancelButtonText: 'Lanjut Input',
                        reverseButtons: true
                    }).then((result) => {

                        // Jika klik Kembali ke Radiologi
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?Page=Radiologi';
                        }

                        // Jika klik Lanjut Input
                        else {
                            location.reload();
                        }
                    });

                }

                // Enable kembali tombol submit
                $('#ProsesPendaftaranRadiologi button[type="submit"]').prop('disabled', false);
            },

            error: function(xhr, status, error) {

                $('#NotifikasiPendaftaranRadiologi').html(
                    '<div class="alert alert-danger">AJAX Error: '+error+'</div>'
                );

                $('#ProsesPendaftaranRadiologi button[type="submit"]').prop('disabled', false);
            }
        });
    });

});
