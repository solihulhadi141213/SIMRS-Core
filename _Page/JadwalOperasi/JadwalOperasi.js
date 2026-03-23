//Menampilkan Jadwal Operasi Pertama Kali
var BatasPencarian = $('#BatasPencarian').serialize();
var Loading='Loading...';
$('#MenampilkanJadwalOperasi').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/JadwalOperasi/TabelJadwalOperasi.php',
    data 	    :  BatasPencarian,
    success     : function(data){
        $('#MenampilkanJadwalOperasi').html(data);
    }
});
//Ketika Merubah Data Jumlah Yang Ditampilkan
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='Loading...';
    $('#MenampilkanJadwalOperasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/TabelJadwalOperasi.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanJadwalOperasi').html(data);
        }
    });
});
//Ketika keyword_by diubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
            $('#keyword').keyup(function(){
                var keyword = $('#keyword').val();
                var characterCount = keyword.length;
                if(characterCount>3){
                    $('#ListKeyword').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/JadwalOperasi/DataListKeyword.php',
                        data 	    :  {keyword_by: keyword_by, keyword: keyword},
                        success     : function(data){
                            $('#ListKeyword').html(data);
                        }
                    });
                }
            });
        }
    });
});
//Ketika Mulai Pencarian Data Operasi
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='Loading...';
    $('#MenampilkanJadwalOperasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/TabelJadwalOperasi.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanJadwalOperasi').html(data);
        }
    });
});
//Ketika Modal Pencarian Pasien Muncul Pertama Kali
$('#ModalCaripasien').on('show.bs.modal', function (e) {
    var ProsesPencarianPasien = $('#ProsesPencarianPasien').serialize();
    $('#FormHasilPencarianPasien').html('<div class="row"><div class="col-md-12 text-center">Loading..</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormDataPasien.php',
        data 	    :  ProsesPencarianPasien,
        success     : function(data){
            $('#FormHasilPencarianPasien').html(data);
        }
    });
});
//Ketika Dilakukan Pencarian Pasien
$('#ProsesPencarianPasien').submit(function(){
    var ProsesPencarianPasien = $('#ProsesPencarianPasien').serialize();
    var Loading='Loading...';
    $('#FormHasilPencarianPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormDataPasien.php',
        data 	    :  ProsesPencarianPasien,
        success     : function(data){
            $('#FormHasilPencarianPasien').html(data);
        }
    });
});
//Proses Tambah Operasi
$('#ProsesTambahJadwalOperasi').submit(function(){
    var ProsesTambahJadwalOperasi = $('#ProsesTambahJadwalOperasi').serialize();
    $('#NotifikasiTambahJadwalOperasi').html('Loading...');
    $.ajax({
        url     : "_Page/JadwalOperasi/ProsesTambahJadwalOperasi.php",
        method  : "POST",
        data    :  ProsesTambahJadwalOperasi,
        success : function (data) {
            $('#NotifikasiTambahJadwalOperasi').html(data);
            //Notifikasi Proses Hapus
            var NotifikasiTambahJadwalOperasiBerhasil=$('#NotifikasiTambahJadwalOperasiBerhasil').html();
            if(NotifikasiTambahJadwalOperasiBerhasil=="Success"){
                window.location.href='index.php?Page=JadwalOperasi';
            }
        }
    })
});
//Modal detail Jadwal Operasi
$('#ModalDetailJadwalOperasi').on('show.bs.modal', function (e) {
    var id_operasi = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailJadwalOperasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormDetailJadwalOperasi.php',
        data 	    :  {id_operasi: id_operasi},
        success     : function(data){
            $('#FormDetailJadwalOperasi').html(data);
        }
    });
});
//Modal Update Status Jadwal
$('#ModalUpdateStatusJadwal').on('show.bs.modal', function (e) {
    var id_operasi = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormUpdateStatusJadwal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormUpdateStatusJadwal.php',
        data 	    :  {id_operasi: id_operasi},
        success     : function(data){
            $('#FormUpdateStatusJadwal').html(data);
        }
    });
});
//Proses Edit Operasi
$('#ProsesUpdateStatusJadwal').submit(function(){
    var ProsesUpdateStatusJadwal = $('#ProsesUpdateStatusJadwal').serialize();
    $('#NotifikasiUpdateJadwalOperasi').html('Loading...');
    $.ajax({
        url     : "_Page/JadwalOperasi/ProsesUpdateStatusJadwal.php",
        method  : "POST",
        data    :  ProsesUpdateStatusJadwal,
        success : function (data) {
            $('#NotifikasiUpdateJadwalOperasi').html(data);
            //Notifikasi Proses Hapus
            var NotifikasiUpdateJadwalOperasiBerhasil=$('#NotifikasiUpdateJadwalOperasiBerhasil').html();
            if(NotifikasiUpdateJadwalOperasiBerhasil=="Success"){
                location.reload();
            }
        }
    })
});
//Modal Laporan Operasi
$('#ModalLaporanOperasi').on('show.bs.modal', function (e) {
    var id_operasi = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormLaporanOperasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormLaporanOperasi.php',
        data 	    :  {id_operasi: id_operasi},
        success     : function(data){
            $('#FormLaporanOperasi').html(data);
        }
    });
});
//Modal Edit Operasi
$('#ModalEditJadwalOperasi').on('show.bs.modal', function (e) {
    var id_operasi = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormEditJadwalOperasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormEditJadwalOperasi.php',
        data 	    :  {id_operasi: id_operasi},
        success     : function(data){
            $('#FormEditJadwalOperasi').html(data);
        }
    });
});
//Proses Edit Operasi
$('#ProsesEditJadwalOperasi').submit(function(){
    var ProsesEditJadwalOperasi = $('#ProsesEditJadwalOperasi').serialize();
    $('#NotifikasiEditJadwalOperasi').html('Loading...');
    $.ajax({
        url     : "_Page/JadwalOperasi/ProsesEditJadwalOperasi.php",
        method  : "POST",
        data    :  ProsesEditJadwalOperasi,
        success : function (data) {
            $('#NotifikasiEditJadwalOperasi').html(data);
            //Notifikasi Proses Hapus
            var NotifikasiEditJadwalOperasiBerhasil=$('#NotifikasiEditJadwalOperasiBerhasil').html();
            var UrlBack=$('#UrlBack').html();
            var UrlBack=UrlBack.replace(/&amp;/g, '&');
            if(NotifikasiEditJadwalOperasiBerhasil=="Success"){
                window.location.href=UrlBack;
            }
        }
    })
});
//Modal delete jadwal operasi
$('#ModalHapusJadwalOperasi').on('show.bs.modal', function (e) {
    var id_operasi = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDeleteJadwalOperasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormDeleteJadwalOperasi.php',
        data        :   {id_operasi: id_operasi},
        success     : function(data){
            $('#FormDeleteJadwalOperasi').html(data);
        }
    });
});
//Konfirmasi Hapus Jadwal Operasi
$('#ProsesHapusJadwalOperasi').submit(function(){
    var ProsesHapusJadwalOperasi = $('#ProsesHapusJadwalOperasi').serialize();
    $('#NotifikasiHapusJadwalOperasi').html('Loading...');
    $.ajax({
        url     : "_Page/JadwalOperasi/ProsesHapusJadwalOperasi.php",
        method  : "POST",
        data    :  ProsesHapusJadwalOperasi,
        success : function (data) {
            $('#NotifikasiHapusJadwalOperasi').html(data);
            //Notifikasi Proses Hapus Jadwal Operasi
            var NotifikasiHapusJadwalOperasiBerhasil=$('#NotifikasiHapusJadwalOperasiBerhasil').html();
            if(NotifikasiHapusJadwalOperasiBerhasil=="Success"){
                window.location.href='index.php?Page=JadwalOperasi';
            }
        }
    })
});
//Modal jadwal operasi selesai
$('#ModalOperasiSelesai').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormSelesaiJadwalOperasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormSelesaiJadwalOperasi.php',
        success     : function(data){
            $('#FormSelesaiJadwalOperasi').html(data);
            //Konfirmasi Hapus Jadwal Operasi
            $('#KonfirmasiSelesaiOperasi').click(function(){
                $('#NotifikasiJadwalOperasiSelesai').html('Loading...');
                $.ajax({
                    url     : "_Page/JadwalOperasi/ProsesSelesaiJadwalOperasi.php",
                    method  : "POST",
                    data    :  {id_operasi: id_operasi},
                    success : function (data) {
                        $('#NotifikasiJadwalOperasiSelesai').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiJadwalOperasiSelesaiBerhasil=$('#NotifikasiJadwalOperasiSelesaiBerhasil').html();
                        if(NotifikasiJadwalOperasiSelesaiBerhasil=="Update Jadwal Berhasil"){
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/JadwalOperasi/TabelJadwalOperasi.php',
                                data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by, tanggal: tanggal},
                                success     : function(data){
                                    $('#MenampilkanJadwalOperasi').html(data);
                                    $('#ModalDetailJadwalOperasi').modal('toggle');
                                    $('#ModalOperasiSelesai').modal('toggle');
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Proses Update Jadwal Operasi Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                        }
                    }
                })
            });
        }
    });
});
//Modal Undo Operasi
$('#ModalUndoOperasi').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormUndoJadwalOperasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalOperasi/FormUndoJadwalOperasi.php',
        success     : function(data){
            $('#FormUndoJadwalOperasi').html(data);
            //Konfirmasi Undo Jadwal Operasi
            $('#KonfirmasiUndoJadwalOperasi').click(function(){
                $('#NotifikasiUndoJadwalOperasi').html('Loading...');
                $.ajax({
                    url     : "_Page/JadwalOperasi/ProsesUndoJadwalOperasi.php",
                    method  : "POST",
                    data    :  {id_operasi: id_operasi},
                    success : function (data) {
                        $('#NotifikasiUndoJadwalOperasi').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiUndoJadwalOperasiBerhasil=$('#NotifikasiUndoJadwalOperasiBerhasil').html();
                        if(NotifikasiUndoJadwalOperasiBerhasil=="Undo Jadwal Berhasil"){
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/JadwalOperasi/TabelJadwalOperasi.php',
                                data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by, tanggal: tanggal},
                                success     : function(data){
                                    $('#MenampilkanJadwalOperasi').html(data);
                                    $('#ModalDetailJadwalOperasi').modal('toggle');
                                    $('#ModalUndoOperasi').modal('toggle');
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Proses Undo Jadwal Operasi Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                        }
                    }
                })
            });
        }
    });
});

//Ketika Proses Pencarian Tindakan Dilakukan
$('#ProsesPencarianTindakan').submit(function(){
    var ProsesPencarianTindakan = $('#ProsesPencarianTindakan').serialize();
    $('#ListHasilPencarianTindakan').html('Loading...');
    $.ajax({
        url     : "_Page/JadwalOperasi/ProsesPencarianTindakan.php",
        method  : "POST",
        data    :  ProsesPencarianTindakan,
        success : function (data) {
            $('#ListHasilPencarianTindakan').html(data);
        }
    })
});
//Modal Detail Pasien
$('#ModalDetailPasien').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormDetailPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailPasien.php',
        data        : {id_pasien: id_pasien},
        success     : function(data){
            $('#FormDetailPasien').html(data);
        }
    });
});