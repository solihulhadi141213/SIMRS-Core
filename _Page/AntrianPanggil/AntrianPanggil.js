function ListDokter(tanggal,id_poliklinik){
    $('#id_dokter').html('<option value="">Loading...</option>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AntrianPanggil/ListDokter.php',
        data 	    :  {tanggal: tanggal, id_poliklinik: id_poliklinik},
        success     : function(data){
            $('#id_dokter').html(data);
        }
    });
}
function ListPoliklinik(tanggal){
    $('#id_poliklinik').html('<option value="">Loading...</option>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AntrianPanggil/ListPoliklinik.php',
        data 	    :  {tanggal: tanggal},
        success     : function(data){
            $('#id_poliklinik').html(data);
            //Menangkap Kode Poli Jika Ada Dan Kemudian Menampilkan Dokter
            var id_poliklinik=$('#id_poliklinik').val();
            if(id_poliklinik!==""){
                ListDokter(tanggal,id_poliklinik);
            }
        }
    });
}
//Pertama kali tangkap tanggal
var tanggal=$('#tanggal').val();
//Tampilkan Poliklinik dengan function
ListPoliklinik(tanggal);

//Ketika tanggal diubah
$('#tanggal').change(function(){
    var tanggal=$('#tanggal').val();
    ListPoliklinik(tanggal);
});
//Ketika Poliklinik Diubah
$('#id_poliklinik').change(function(){
    var tanggal=$('#tanggal').val();
    var id_poliklinik=$('#id_poliklinik').val();
    ListDokter(tanggal,id_poliklinik);
});

//Ketika Data Ditampilkan
$('#PencarianAntrianPanggil').submit(function(){
    var PencarianAntrianPanggil = $('#PencarianAntrianPanggil').serialize();
    $('#MenampilkanDataAntrianPanggil').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AntrianPanggil/TabelAntrianPanggil.php',
        data 	    :  PencarianAntrianPanggil,
        success     : function(data){
            $('#MenampilkanDataAntrianPanggil').html(data);
        }
    });
});

//Ketika Modal Detail Antrian Muncul
$('#ModalDetailAntrian').on('show.bs.modal', function (e) {
    var id_antrian=$(e.relatedTarget).data('id');
    $('#FormDetailAntrian').html('Loading....');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AntrianPanggil/FormDetailAntrian.php',
        data        :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormDetailAntrian').html(data);
            $('#NotifikasiProsesKirimDataMonitor').html("");
            $('#NotifikasiProsesPemanggilan').html("");
        }
    });
});
function playQueueSound(noAntrian, kodePoli) {
    let numbers = parseNumberToAudio(noAntrian);

    // Antrian suara awal
    let audioQueue = ['_page/AntrianPanggil/Audio/bell.mp3', '_page/AntrianPanggil/Audio/nomor-antrian.mp3'];

    // Tambahkan suara angka ke dalam antrian
    audioQueue = audioQueue.concat(numbers);

    // Tambahkan suara "Silahkan Menuju" dan kode poli
    audioQueue.push('_page/AntrianPanggil/Audio/silahkan-menuju.mp3');
    audioQueue.push(`_page/AntrianPanggil/Audio/Tempat/${kodePoli}`);

    $('#NotifikasiProsesKirimDataMonitor').html('Memutar Audio..');

    // Putar audio dengan callback untuk menghapus notifikasi setelah selesai
    playAudioSequentially(audioQueue, function () {
        $('#NotifikasiProsesKirimDataMonitor').html(''); // Bersihkan notifikasi
    });
}

function parseNumberToAudio(number) {
    let audioParts = [];
    let num = parseInt(number);

    if (num >= 1000) {
        let ribu = Math.floor(num / 1000);
        audioParts.push(`_page/AntrianPanggil/Audio/${ribu}.mp3`);
        audioParts.push('_page/AntrianPanggil/Audio/ribu.mp3');
        num %= 1000;
    }
    if (num >= 100) {
        let ratus = Math.floor(num / 100);
        audioParts.push(`_page/AntrianPanggil/Audio/${ratus}.mp3`);
        audioParts.push('_page/AntrianPanggil/Audio/ratus.mp3');
        num %= 100;
    }
    if (num >= 20) {
        let puluh = Math.floor(num / 10);
        audioParts.push(`_page/AntrianPanggil/Audio/${puluh}.mp3`);
        audioParts.push('_page/AntrianPanggil/Audio/puluh.mp3');
        num %= 10;
    } else if (num >= 10) {
        audioParts.push(`_page/AntrianPanggil/Audio/${num}.mp3`);
        return audioParts;
    }
    if (num > 0) {
        audioParts.push(`_page/AntrianPanggil/Audio/${num}.mp3`);
    }

    return audioParts;
}

function playAudioSequentially(audioQueue, callback = null) {
    if (audioQueue.length === 0) {
        if (callback) callback(); // Panggil callback jika semua audio selesai
        return;
    }

    let audio = new Audio(audioQueue.shift());
    audio.play();

    audio.onended = function() {
        playAudioSequentially(audioQueue, callback);
    };
}
//Ketika Tombol Panggil Di Click
$('.panggil-antrian').click(function(){
    var no_antrian = $('#no_antrian').val();
    var kode_akses = $('#kode_akses_get').val();
    var title = $('#title_monitor').val();
    var sub_title = $('#sub_title_monitor').val();
    var kodepoli = $('#kode_loket').val();

    // Tampilkan notifikasi proses sedang berjalan
    $('#NotifikasiProsesKirimDataMonitor').html('Loading...');

    // Lakukan AJAX request
    $.ajax({
        type: 'POST',
        url: '_Page/AntrianPanggil/ProsesKirimDataMonitor.php',
        data: {
            no_antrian: no_antrian,
            kode_akses: kode_akses,
            title: title,
            sub_title: sub_title
        },
        success: function(data) {
            $('#NotifikasiProsesKirimDataMonitor').html(data);

            // Periksa jika proses kirim data berhasil
            var NotifikasiKirimDataMonitorBerhasil = $('#NotifikasiKirimDataMonitorBerhasil').html();
            if (NotifikasiKirimDataMonitorBerhasil === "Success") {
                // Panggil fungsi untuk memainkan suara
                playQueueSound(no_antrian, kodepoli);
            }
        }
    });
});

//Kondisi Ketika Memunculkan Dan menyembunyikan Konten
$(document).ready(function () {
    // Sembunyikan form-body-koneksi dan form-footer-koneksi saat pertama kali
    $('#form-body-koneksi, #form-footer-koneksi').hide();

    // Event listener untuk tombol dengan class form-show
    $(document).on('click', '.form-show', function () {
        // Tampilkan form-body-koneksi dan form-footer-koneksi
        $('#form-body-koneksi, #form-footer-koneksi').slideDown();

        // Ubah class tombol menjadi form-hide
        $(this).removeClass('form-show').addClass('form-hide');

        // Ubah ikon tombol menjadi arrow-up
        $(this).find('i').removeClass('ti-arrow-circle-down').addClass('ti-arrow-circle-up');
    });

    // Event listener untuk tombol dengan class form-hide
    $(document).on('click', '.form-hide', function () {
        // Sembunyikan form-body-koneksi dan form-footer-koneksi
        $('#form-body-koneksi, #form-footer-koneksi').slideUp();

        // Ubah class tombol menjadi form-show
        $(this).removeClass('form-hide').addClass('form-show');

        // Ubah ikon tombol menjadi arrow-down
        $(this).find('i').removeClass('ti-arrow-circle-up').addClass('ti-arrow-circle-down');
    });
});

// Modal Setting Koneksi Monitor Muncul
$('#ModalSettingKoneksiMonitor').on('show.bs.modal', function (e) {
    $('#FormSettingKoneksiMonitor').html('Loading...');
    $('#NotifikasiSimpanSettingKoneksiMonitor').html('');

    $.ajax({
        type: 'POST',
        url: '_Page/AntrianPanggil/FormSettingKoneksiMonitor.php',
        success: function (data) {
            $('#FormSettingKoneksiMonitor').html(data);

            // Ambil nilai base_url_monitor setelah konten dimuat
            var base_url_monitor = $('#base_url_monitor').val();

            // Periksa apakah base_url_monitor kosong atau tidak ada
            if (!base_url_monitor || base_url_monitor.trim() === '') {
                $('#ButtonSimpanSettingKoneksiMonitor').hide();
            } else {
                $('#ButtonSimpanSettingKoneksiMonitor').show(); // Pastikan tombol ditampilkan jika parameter ditemukan
            }
        },
        error: function (xhr, status, error) {
            $('#FormSettingKoneksiMonitor').html('<p class="text-danger">Gagal memuat data. Silakan coba lagi.</p>');
            console.error('AJAX Error:', status, error);
        }
    });
});

//Simpan Data Setting Koneksi Monitor
$('#ProsesSimpanSettingKoneksiMonitor').submit(function (e) {
    e.preventDefault(); 
    // Mencegah form melakukan submit default
    var ProsesSimpanSettingKoneksiMonitor = $('#ProsesSimpanSettingKoneksiMonitor').serialize();
    $('#NotifikasiSimpanSettingKoneksiMonitor').html('Loading...');
    $.ajax({
        url     : "_Page/AntrianPanggil/ProsesSimpanSettingKoneksiMonitor.php",
        method  : "POST",
        data    : ProsesSimpanSettingKoneksiMonitor,
        success: function (data) {
            $('#NotifikasiSimpanSettingKoneksiMonitor').html(data);
            var NotifikasiSimpanSettingKoneksiMonitorBerhasil = $('#NotifikasiSimpanSettingKoneksiMonitorBerhasil').html();
            if (NotifikasiSimpanSettingKoneksiMonitorBerhasil == "Success") {
                //Tutup Modal
                $('#ModalSettingKoneksiMonitor').modal('hide');
                //Tampilkan Swal
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pengaturan Koneksi Monitor Antrian Berhasil Disimpan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }
        }
    });
});

// Modal Credential Koneksi Monitor Muncul
function ShowTambahCredential() {
    $.ajax({
        type: 'POST',
        url: '_Page/AntrianPanggil/FormTambahCredential.php',
        success: function (data) {
            $('.form-tambah-credential').html(data);
        }
    });
}
function ShowFormListCredential() {
    $.ajax({
        type: 'POST',
        url: '_Page/AntrianPanggil/FormListCredential.php',
        success: function (data) {
            $('#FormListCredential').html(data);
        }
    });
}
$('#ModalCredentialMonitor').on('show.bs.modal', function (e) {
    $('.form-tambah-credential').html('Loading...');
    $('#FormListCredential').html('Loading..');
    ShowTambahCredential();
    ShowFormListCredential();
});

//Proses Tambah Credential
$('#ProsesTambahCredential').submit(function (e) {
    e.preventDefault(); 
    // Mencegah form melakukan submit default
    var ProsesTambahCredential = $('#ProsesTambahCredential').serialize();
    $('#NotifikasiTambahCredential').html('Loading...');
    $.ajax({
        url     : "_Page/AntrianPanggil/ProsesTambahCredential.php",
        method  : "POST",
        data    : ProsesTambahCredential,
        success: function (data) {
            $('#NotifikasiTambahCredential').html(data);
            var NotifikasiTambahCredentialBerhasil = $('#NotifikasiTambahCredentialBerhasil').html();
            if (NotifikasiTambahCredentialBerhasil == "Success") {
                $('#NotifikasiTambahCredential').html('');
                ShowFormListCredential();
                $('#ProsesTambahCredential')[0].reset();
            }
        }
    });
});

//Edit Credential Monitor
$('#ModalEditCredential').on('show.bs.modal', function (e) {
    var kode_akses=$(e.relatedTarget).data('id');
    $('#FormEditCredential').html('Loading....');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AntrianPanggil/FormEditCredential.php',
        data        :  {kode_akses: kode_akses},
        success     : function(data){
            $('#FormEditCredential').html(data);
            $('#NotifikasiEditCredential').html("");
        }
    });
});
//Proses Edit Credential
$('#ProsesEditCredential').submit(function (e) {
    e.preventDefault(); 
    // Mencegah form melakukan submit default
    var ProsesEditCredential = $('#ProsesEditCredential').serialize();
    $('#NotifikasiEditCredential').html('Loading...');
    $.ajax({
        url     : "_Page/AntrianPanggil/ProsesEditCredential.php",
        method  : "POST",
        data    : ProsesEditCredential,
        success: function (data) {
            $('#NotifikasiEditCredential').html(data);
            var NotifikasiEditCredentialBerhasil = $('#NotifikasiEditCredentialBerhasil').html();
            if (NotifikasiEditCredentialBerhasil == "Success") {
                $('#NotifikasiEditCredential').html('');
                ShowFormListCredential();
                //Tutup Modal
                $('#ModalEditCredential').modal('hide');
            }
        }
    });
});

//Modal Hapus Credential Monitor
$('#ModalHapusCredential').on('show.bs.modal', function (e) {
    var kode_akses=$(e.relatedTarget).data('id');
    $('#FormHapusCredential').html('Loading....');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AntrianPanggil/FormHapusCredential.php',
        data        :  {kode_akses: kode_akses},
        success     : function(data){
            $('#FormHapusCredential').html(data);
            $('#NotifikasiHapusCredential').html("");
        }
    });
});

//Proses Hapus Credential
$('#ProsesHapusCredential').submit(function (e) {
    e.preventDefault(); 
    // Mencegah form melakukan submit default
    var ProsesHapusCredential = $('#ProsesHapusCredential').serialize();
    $('#NotifikasiHapusCredential').html('Loading...');
    $.ajax({
        url     : "_Page/AntrianPanggil/ProsesHapusCredential.php",
        method  : "POST",
        data    : ProsesHapusCredential,
        success: function (data) {
            $('#NotifikasiHapusCredential').html(data);
            var NotifikasiHapusCredentialBerhasil = $('#NotifikasiHapusCredentialBerhasil').html();
            if (NotifikasiHapusCredentialBerhasil == "Success") {
                $('#NotifikasiHapusCredential').html('');
                ShowFormListCredential();
                //Tutup Modal
                $('#ModalHapusCredential').modal('hide');
            }
        }
    });
});

//Modal Detail Credential
$('#ModalDetailCredential').on('show.bs.modal', function (e) {
    var kode_akses=$('#kode_akses_get').val();
    $('#FormDetailCredential').html('Loading....');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AntrianPanggil/FormDetailCredential.php',
        data        :  {kode_akses: kode_akses},
        success     : function(data){
            $('#FormDetailCredential').html(data);
        }
    });
});

//Proses Generate Link Monitor
$('#GenerateLinkMonitor').click(function (e) {
    // Menangkap Kode Akses
    var kode_akses = $('#kode_akses_get').val();
    $.ajax({
        url     : "_Page/AntrianPanggil/ProsesGenerateLinkMonitor.php",
        method  : "POST",
        data    : {kode_akses: kode_akses},
        success: function (data) {
            $('#link_monitor').val(data);
        }
    });
});

//Proses Hapus Credential
$('#ProsesKoneksiMonitorAntrian').submit(function (e) {
    e.preventDefault(); 
    // Mencegah form melakukan submit default
    var ProsesKoneksiMonitorAntrian = $('#ProsesKoneksiMonitorAntrian').serialize();
    $('#NotifikasiKoneksiMonitorAntrian').html('Loading...');
    $.ajax({
        url     : "_Page/AntrianPanggil/ProsesEditCredential.php",
        method  : "POST",
        data    : ProsesKoneksiMonitorAntrian,
        success: function (data) {
            $('#NotifikasiKoneksiMonitorAntrian').html(data);
            var NotifikasiKoneksiMonitorAntrianBerhasil = $('#NotifikasiEditCredentialBerhasil').html();
            if (NotifikasiKoneksiMonitorAntrianBerhasil == "Success") {
                $('#NotifikasiKoneksiMonitorAntrian').html('');
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Perubahan Berhasil Disimpan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }
        }
    });
});

//Ketika Cek Sound Tempat Panggil Di Click
$('#CekSoundTempatPanggil').click(function (e) {
    e.preventDefault();

    // Menangkap file audio yang dipilih dari dropdown
    var file_name_audio = $('#kode_loket').val();
    var directory = "_Page/AntrianPanggil/Audio/Tempat/";
    var button = $(this);

    // Periksa apakah file audio telah dipilih
    if (file_name_audio) {
        // Ubah teks tombol menjadi "Playing..."
        button.html("Playing...");

        // Buat elemen audio
        var audio = new Audio(directory + file_name_audio);

        // Putar audio
        audio.play();

        // Ketika audio selesai diputar, kembalikan tombol ke teks semula
        audio.onended = function () {
            button.html("Cek Sound");
        };

        // Jika terjadi error saat memutar audio
        audio.onerror = function () {
            button.html("Cek Sound");
            alert("File audio tidak ditemukan atau terjadi kesalahan saat memutar audio.");
        };
    } else {
        alert("Silakan pilih file audio terlebih dahulu.");
    }
});