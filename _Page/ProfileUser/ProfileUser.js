// Menampilkan Profile Saya
function ProfilSaya() {
    
    // Loading
    $('#content_my_profile').html('<div class="col-12 text-center">Loading...</div>');

    $.ajax({
        type: 'POST',
        url: '_Page/ProfileUser/FormProfile.php',
        success: function(data) {
            $('#content_my_profile').html(data);
        }
    });
}

// Ijin Akses
function TabelIjinAkses() {
    var ProsesFilterIjinAkses = $('#ProsesFilterIjinAkses').serialize();
    $.ajax({
        type   : 'POST',
        url    : '_Page/ProfileUser/TabelIjinAkses.php',
        data   : ProsesFilterIjinAkses,
        success: function(data) {
            $('#tabel_ijin_akses').html(data);
        }
    });
}

// Tabel Laporan Kesalahan
function TabelLaporanKesalahan() {
    var page = $('#page_laporan_kesalahan').val();
    $.ajax({
        type   : 'POST',
        url    : '_Page/ProfileUser/TabelLaporanKesalahan.php',
        data   : {page: page},
        success: function(data) {
            $('#TabelLaporanKesalahan').html(data);
        }
    });
}

//Menampilkan Data Pertama Kali
$(document).ready(function() {

    // Tampilkan Data Pertama Kali
    ProfilSaya();
    TabelIjinAkses();
    TabelLaporanKesalahan();

    // ============================================================
    // GANTI FOTO PROFILE - START
    // ============================================================
    $('#ModalEditFoto').on('show.bs.modal', function (e) {

        // Loading Form 'FormGantiFoto'
        $('#FormGantiFoto').html('Loading...');

        // Remove Notification Form 'NotifikasiGantiFoto'
        $('#NotifikasiGantiFoto').html('');

        // Show Form With Ajax 'FormGantiFoto'
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ProfileUser/FormGantiFoto.php',
            success     : function(data){
                $('#FormGantiFoto').html(data);
            }
        });
    });

    // Drag And Drop File
    // Cegah browser membuka file saat drag/drop
    $(document).on('dragenter dragover drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Saat file diarahkan ke area
    $(document).on('dragenter dragover', '.upload-area', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });

    // Saat file keluar dari area
    $(document).on('dragleave', '.upload-area', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });

    // Saat file dijatuhkan
    $(document).on('drop', '.upload-area', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $(this).removeClass('dragover');

        let files = e.originalEvent.dataTransfer.files;

        if (files.length > 0) {
            let input = document.getElementById('file_foto');

            let dt = new DataTransfer();
            dt.items.add(files[0]);

            input.files = dt.files;

            // trigger preview
            $(input).trigger('change');
        }
    });

    $(document).on('change', '#file_foto', function () {
        let file = this.files[0];

        if (file) {
            let reader = new FileReader();

            reader.onload = function (e) {
                $('#preview_foto').html(`
                    <img src="${e.target.result}" 
                        class="img-thumbnail"
                        style="max-height:200px; border-radius:12px;">
                `);
            };

            reader.readAsDataURL(file);
        }
    });

    //Proses Edit Foto
    $('#ProsesGantiFoto').submit(function(e){
        e.preventDefault();

        // Loading Notifikasi
        $('#NotifikasiGantiFoto').html('Loading..');

        // Tangkap Data
        var form = $('#ProsesGantiFoto')[0];
        var data = new FormData(form);

        // Kirim Data Dengan AJAX
        $.ajax({
            type       : 'POST',
            url        : '_Page/ProfileUser/ProsesGantiFoto.php',
            data       : data,
            cache      : false,
            processData: false,
            contentType: false,
            enctype    : 'multipart/form-data',
            dataType   : 'json',
            success     : function(response){
                var status  = response.status || 'error';
                var message = response.message || 'Terjadi kesalahan';
                
                // Jika Berhasil
                if (status === 'success') {
                    // Kosongkan Notifikasi
                    $('#NotifikasiGantiFoto').html('');

                    // Tutup Modal
                    $('#ModalEditFoto').modal('hide');
                    $('.modal-backdrop').remove();

                    // Tampilkan Toast
                    tampilkanToast('Foto Profile berhasil diperbarui', 'success');

                    // Reload Profile Saya
                    ProfilSaya();
                    
                } else {
                    $('#NotifikasiGantiFoto').html('<div class="alert alert-danger">' + message + '</div>');
                }
            }
        });
    });
    
    // ============================================================
    // EDIT PROFILE - START
    // ============================================================
    $('#ModalEditProfile').on('show.bs.modal', function (e) {
        // Loading
        $('#FormEditProfile').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditProfile').html('');

        // Tampilkan Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ProfileUser/FormEditProfile.php',
            success     : function(data){
                $('#FormEditProfile').html(data);
            }
        });
    });

    //Proses Edit Profile (delegated, form dimuat via AJAX)
    $(document).on('submit', '#ProsesEditProfile', function (e) {
        e.preventDefault();

        var $form    = $(this);
        var formData = $form.serialize();
        var $notif   = $('#NotifikasiEditProfile');
        var $btn     = $form.find('button[type="submit"]');

        $notif.html('Loading...');
        $btn.prop('disabled', true);

        $.ajax({
            type    : 'POST',
            url     : '_Page/ProfileUser/ProsesEditProfile.php',
            data    : formData,
            dataType: 'json',

            beforeSend: function () {
                $notif.html('<small>Loading...</small>');
            },

            success: function (response) {
                if (!response || typeof response !== 'object') {
                    $notif.html('<div class="alert alert-danger">Response tidak valid</div>');
                    return;
                }

                var status  = response.status || 'error';
                var message = response.message || 'Terjadi kesalahan';

                if (status === 'success') {
                    // Tutup Modal
                    $('#ModalEditProfile').modal('hide');
                    $('.modal-backdrop').remove();

                    // Tampilkan Toast
                    tampilkanToast('Profile berhasil diperbarui', 'success');

                    // Reload Profile Saya
                    ProfilSaya();
                    
                } else {
                    $notif.html('<div class="alert alert-danger">' + message + '</div>');
                }
            },

            error: function (xhr) {
                console.error('AJAX Error:', xhr.responseText);
                $notif.html('<div class="alert alert-danger">Server error / response tidak valid</div>');
            },

            complete: function () {
                $btn.prop('disabled', false);
            }
        });
    });

    // ============================================================
    // GANTI PASSWORD - START
    // ============================================================
    $('#ModalGantiPassword').on('show.bs.modal', function (e) {
        
        // Loading
        $('#FormGantiPassword').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiGantiPassword').html('');

        // Tampilkan Form Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ProfileUser/FormGantiPassword.php',
            success     : function(data){
                $('#FormGantiPassword').html(data);
            }
        });
    });

    $(document).on('click', '#TampilkanPasswordProfile', function () {
        if($(this).is(':checked')){
            $('#password1').attr('type','text');
            $('#password2').attr('type','text');
        }else{
            $('#password1').attr('type','password');
            $('#password2').attr('type','password');
        }
    });

    //Proses Edit Profile
    $(document).on('submit', '#ProsesGantiPassword', function (e) {
        e.preventDefault();

        // Tangkap Data Dari Form
        var ProsesGantiPassword = $('#ProsesGantiPassword').serialize();

        // Ambil Element Tombol
        var button_ganti_password = $('#button_ganti_password').html();

        // Loading Button
        $('#button_ganti_password').html('...');

        // Kirim Data Dengan Ajax
        $.ajax({
            type    : 'POST',
            url     : '_Page/ProfileUser/ProsesGantiPassword.php',
            data    : ProsesGantiPassword,
            dataType: 'JSON',
            success     : function(response){
                
                // Tangkap Status Dan Message
                var status = response.status;
                var message = response.message;

                // Jika Proses Berhasil
                if(status=='success'){
                    // Kosongkan Notifikasi
                    $('#NotifikasiGantiPassword').html('');

                    // Tutup Modal
                    $('#ModalGantiPassword').modal('hide');

                    // Tampilkan toast
                    tampilkanToast('Password berhasil diperbarui', 'success');
                }else{

                    // Jika Proses Gagal
                    $('#NotifikasiGantiPassword').html('<div class="alert alert-danger text-center">'+message+'</div>');
                }
            },
            error: function (xhr) {
                console.error('AJAX Error:', xhr.responseText);
                $('#NotifikasiGantiPassword').html('<div class="alert alert-danger">Server error / response tidak valid</div>');
            },
        });
        
        // Kembalikan Tombol
        $('#button_ganti_password').html(button_ganti_password);
    });

    // ============================================================
    // IJIN AKSES PENGGUNA - START
    // ============================================================

    // Ketika Click Filter Ijin Akses
    $('.modal_filter_ijin_akses').click(function(){
        // Tampilkan Modal
        $('#ModalFilterIjinAkses').modal('show');
    });

    // Ketyika Submit ProsesFilterIjinAkses
    $(document).on('submit', '#ProsesFilterIjinAkses', function (e) {
        e.preventDefault();
        // Kembalikan ke halaman 1
        $('#page_ijin_akses').val(1);

        // Tutup Modal
        $('#ModalFilterIjinAkses').modal('hide');

        // Muat Ulang TabelIjinAkses
        TabelIjinAkses();
    });

    // pagging TabelIjinAkses
     $(document).on('click', '#next_btn_ijin_akses', function() {
        var page_now = parseInt($('#page_ijin_akses').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_ijin_akses').val(next_page);
        TabelIjinAkses(0);
    });
    $(document).on('click', '#prev_btn_ijin_akses', function() {
        var page_now = parseInt($('#page_ijin_akses').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_ijin_akses').val(next_page);
        TabelIjinAkses(0);
    });

    // Menampilkan Modal List Ijin Akses
    $(document).on('click', '.show_own_fiture', function () {
        // Tangkap kategori
        var kategori = $(this).data('kategori');

        // Tampilkan modal
        $('#ModalListIjinAkses').modal('show');

        // Loading form
        $('#FormListIjinAkses').html('Loading...');

        $.ajax({
            type: 'POST',
            url: '_Page/ProfileUser/FormListIjinAkses.php',
            data: {
                kategori: kategori
            },
            success: function (data) {
                $('#FormListIjinAkses').html(data);
            }
        });
    });

    // ============================================================
    // LAPORAN PENGGUNA - START
    // ============================================================
    // Pagging Laporan Pengguna
    // Navigasi Ke Halaman Selanjutnya
    $(document).on('click', '#next_btn_laporan_kesalahan', function() {
        // Ambil nilai dari input hidden (pastikan ID ini ada di HTML Anda)
        var page_now = parseInt($('#page_laporan_kesalahan').val()) || 1; 
        var next_page = page_now + 1;
        
        // Update nilai input hidden
        $('#page_laporan_kesalahan').val(next_page);
        
        // Jalankan fungsi tampilkan tabel
        TabelLaporanKesalahan(); 
    });

    // Navigasi Ke Halaman Sebelumnya
    $(document).on('click', '#prev_btn_laporan_kesalahan', function() {
        var page_now = parseInt($('#page_laporan_kesalahan').val()) || 1;
        
        // PROTEKSI: Jangan biarkan halaman kurang dari 1
        if (page_now > 1) {
            var prev_page = page_now - 1;
            $('#page_laporan_kesalahan').val(prev_page);
            TabelLaporanKesalahan();
        }
    });
    // 1. Deklarasi variabel global agar bisa diakses di semua event
    let quillEditor = null;

    // 2. Fungsi Inisialisasi Quill (Hanya dijalankan sekali)
    function initQuill() {
        if (quillEditor === null) {
            quillEditor = new Quill('#isi_laporan_editor', {
                theme: 'snow',
                placeholder: 'Tuliskan laporan Anda...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link'],
                        ['clean']
                    ]
                }
            });
        }
    }

    // 3. Tampilkan modal
    $(document).on('click', '.kirim_laporan_pengguna', function () {
        $('#ModalLaporanPengguna').modal('show');
    });

    // 4. Saat modal tampil
    $('#ModalLaporanPengguna').on('shown.bs.modal', function () {
        // Jalankan inisialisasi jika belum ada
        initQuill();
        
        // Fokus ke judul laporan
        $('#judul_laporan').focus();
    });

    // 5. Submit form
    $(document).on('submit', '#ProsesLaporanPengguna', function (e) {
        e.preventDefault();

        // Validasi editor
        if (!quillEditor) {
            $('#NotifikasiLaporanPengguna').html(
                '<div class="alert alert-danger">Editor belum siap.</div>'
            );
            return;
        }

        // Ambil isi editor (HTML)
        let isiHtml = quillEditor.root.innerHTML;

        // Validasi isi editor kosong
        // Quill .getText() mengembalikan "\n" jika kosong, jadi kita trim
        if (quillEditor.getText().trim().length === 0) {
            $('#NotifikasiLaporanPengguna').html(
                '<div class="alert alert-danger">Isi laporan tidak boleh kosong.</div>'
            );
            return;
        }

        // Masukkan ke hidden input
        $('#isi_laporan').val(isiHtml);

        let formData = $(this).serialize();
        let $btn = $('#ButtonLaporanPengguna');
        let buttonText = $btn.html();

        $btn.prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

        $('#NotifikasiLaporanPengguna').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/ProfileUser/ProsesLaporanPengguna.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                $btn.prop('disabled', false).html(buttonText);

                let alertClass = response.status === 'success' ? 'alert-success' : 'alert-danger';

                $('#NotifikasiLaporanPengguna').html(
                    '<div class="alert ' + alertClass + '">' + response.message + '</div>'
                );

                if (response.status === 'success') {
                    // RESET HANYA JIKA BERHASIL
                    quillEditor.setContents([]); // Kosongkan editor
                    $('#ProsesLaporanPengguna')[0].reset(); // Reset form lainnya
                    $('#isi_laporan').val('');

                    setTimeout(function () {
                        $('#ModalLaporanPengguna').modal('hide');
                        // Pastikan fungsi ini tersedia di scope global Anda
                        if (typeof TabelLaporanKesalahan === "function") {
                            TabelLaporanKesalahan();
                        }
                    }, 500);
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html(buttonText);
                $('#NotifikasiLaporanPengguna').html(
                    '<div class="alert alert-danger">Server Error: ' + xhr.statusText + '</div>'
                );
            }
        });
    });

    // 6. Reset Notifikasi saja saat ditutup (Data teks tetap ada jika belum sukses)
    $('#ModalLaporanPengguna').on('hidden.bs.modal', function () {
        $('#NotifikasiLaporanPengguna').html('');
        // Kita TIDAK mereset form atau quill di sini sesuai permintaan Anda
    });

    // Modal Detail Laporan Kesalahan
    $(document).on('click', '.modal_detail_laporan_kesalahan', function () {

        // Tangkap id_akses_laporan
        var id_akses_laporan = $(this).data('id');

        // Tampilkann Modal
        $('#ModalDetailLaporanKesalahan').modal('show');

        // Loading Form
        $('#FormDetailLaporanKesalahan').html('Loading...');

        // Buka Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ProfileUser/FormDetailLaporanPengguna.php',
            data 	    :  {id_akses_laporan: id_akses_laporan},
            success     : function(data){
                $('#FormDetailLaporanKesalahan').html(data);
            }
        });
    });

    let quillEditorEdit = null;
    // EDIT LAPORAN PENGGUNA
    $(document).on('click', '.modal_edit_laporan_pengguna', function () {

        var id_akses_laporan = $(this).data('id');

        $('#ModalEditLaporanPengguna').modal('show');

        $('#NotifikasiEditLaporanPengguna').html('');
        $('#FormEditLaporanPengguna').html('Loading...');

        $.ajax({
            type: 'POST',
            url: '_Page/ProfileUser/FormEditLaporanPengguna.php',
            data: { id_akses_laporan: id_akses_laporan },
            success: function (data) {
                $('#FormEditLaporanPengguna').html(data);

                // Hapus editor lama jika ada
                if (quillEditorEdit !== null) {
                    quillEditorEdit = null;
                }

                // Inisialisasi Quill setelah form tampil
                quillEditorEdit = new Quill('#isi_laporan_editor_edit', {
                    theme: 'snow',
                    placeholder: 'Tuliskan isi laporan...',
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            ['blockquote', 'code-block'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                // Sinkronkan ke hidden input
                quillEditorEdit.on('text-change', function () {
                    $('#isi_laporan_edit').val(quillEditorEdit.root.innerHTML);
                });

                // Isi data awal dari hidden input
                let isiAwal = $('#isi_laporan_edit').val();
                quillEditorEdit.root.innerHTML = isiAwal;
            }
        });
    });

    // SUBMIT EDIT LAPORAN
    $(document).on('submit', '#ProsesEditLaporanPengguna', function (e) {
        e.preventDefault();

        // Sinkronkan isi Quill ke hidden input
        if (quillEditorEdit !== null) {
            $('#isi_laporan_edit').val(quillEditorEdit.root.innerHTML);
        }

        let formData = $(this).serialize();

        $('#ButtonEditLaporanPengguna')
            .prop('disabled', true)
            .html('<i class="spinner-border spinner-border-sm"></i> Menyimpan...');

        $('#NotifikasiEditLaporanPengguna').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/ProfileUser/ProsesEditLaporanPengguna.php',
            data: formData,
            success: function (response) {
                $('#NotifikasiEditLaporanPengguna').html(response);

                $('#ButtonEditLaporanPengguna')
                    .prop('disabled', false)
                    .html('<i class="ti-save"></i> Simpan');

                // Tutup modal jika sukses
                if (response.includes('success')) {
                    setTimeout(function () {
                        $('#ModalEditLaporanPengguna').modal('hide');

                        // Reset notifikasi modal
                        $('#NotifikasiEditLaporanPengguna').html('');

                        // Tampilkan toast sukses
                        tampilkanToast('Laporan berhasil diperbarui!', 'success');

                        // Optional: refresh list via AJAX
                        TabelLaporanKesalahan();
                    }, 700);
                }
            },
            error: function () {
                $('#NotifikasiEditLaporanPengguna').html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan saat mengirim data.
                    </div>
                `);

                $('#ButtonEditLaporanPengguna')
                    .prop('disabled', false)
                    .html('<i class="ti-save"></i> Simpan');
            }
        });
    });

    // HAPUS LAPORAN PENGGUNA
    $(document).on('click', '.modal_hapus_laporan_pengguna', function () {

        // Tangkap id_akses_laporan
        var id_akses_laporan = $(this).data('id');

        // Tampilkan Modal
        $('#ModalHapusLaporanPengguna').modal('show');

        // Clean Notification
        $('#NotifikasiHapusLaporanPengguna').html('');

        // Loading Form
        $('#FormHapusLaporanPengguna').html('Loading...');

        // Tampilkan Form Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ProfileUser/FormHapusLaporanPengguna.php',
            data 	    :  {id_akses_laporan: id_akses_laporan},
            success     : function(data){
                $('#FormHapusLaporanPengguna').html(data);
            }
        });
    });

    //Proses Hapus Laporan
    $(document).on('submit', '#ProsesHapusLaporanPengguna', function (e) {
        e.preventDefault();

        // Tangkap Data Dari Form
        var ProsesHapusLaporanPengguna = $('#ProsesHapusLaporanPengguna').serialize();

        // Ambil Element Tombol
        var button_hapus_laporan_pengguna = $('#button_hapus_laporan_pengguna').html();

        // Loading Button
        $('#button_hapus_laporan_pengguna').html('...');

        // Kirim Data Dengan Ajax
        $.ajax({
            type    : 'POST',
            url     : '_Page/ProfileUser/ProsesHapusLaporanPengguna.php',
            data    : ProsesHapusLaporanPengguna,
            dataType: 'JSON',
            success     : function(response){
                
                // Tangkap Status Dan Message
                var status = response.status;
                var message = response.message;

                // Jika Proses Berhasil
                if(status=='success'){
                    // Kosongkan Notifikasi
                    $('#NotifikasiHapusLaporanPengguna').html('');

                    // Tutup Modal
                    $('#ModalHapusLaporanPengguna').modal('hide');

                    // Load Data
                    TabelLaporanKesalahan();

                    // Tampilkan toast
                    tampilkanToast('Laporan Pengguna Berhasil Dihapus!', 'success');
                }else{

                    // Jika Proses Gagal
                    $('#NotifikasiHapusLaporanPengguna').html('<div class="alert alert-danger text-center">'+message+'</div>');
                }
            },
            error: function (xhr) {
                console.error('AJAX Error:', xhr.responseText);
                $('#NotifikasiHapusLaporanPengguna').html('<div class="alert alert-danger">Server error / response tidak valid</div>');
            },
        });
        
        // Kembalikan Tombol
        $('#button_hapus_laporan_pengguna').html(button_hapus_laporan_pengguna);
    });


});


