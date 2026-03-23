var BatasPencarian = $('#BatasPencarian').serialize();
var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
$('#TabelKunjunganPasien').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebKunjungan/TabelKunjunganPasien.php',
    data 	    :  BatasPencarian,
    success     : function(data){
        $('#TabelKunjunganPasien').html(data);
    }
});
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelKunjunganPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/TabelKunjunganPasien.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelKunjunganPasien').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelKunjunganPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/TabelKunjunganPasien.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelKunjunganPasien').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//List Pasien
var ProsesCariPasien = $('#ProsesCariPasien').serialize();
var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
$('#ListPasien').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebKunjungan/ListPasien.php',
    data 	    :  ProsesCariPasien,
    success     : function(data){
        $('#ListPasien').html(data);
    }
});

$('#ProsesCariPasien').submit(function(){
    var ProsesCariPasien = $('#ProsesCariPasien').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#ListPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/ListPasien.php',
        data 	    :  ProsesCariPasien,
        success     : function(data){
            $('#ListPasien').html(data);
        }
    });
});
//Ketika Kode Poli Dipilih
$('#kodepoli').change(function(){
    var kodepoli = $('#kodepoli').val();
    var Loading='<option value="">Loading...</option>';
    $('#jam_kunjungan').html('<option value="">Pilih</option>');
    $('#kode_dokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/PilihDokter.php',
        data 	    :  {kodepoli: kodepoli},
        success     : function(data){
            $('#kode_dokter').html(data);
        }
    });
});
//Ketika kode_dokter Dipilih
$('#kode_dokter').change(function(){
    var tanggal_kunjungan = $('#tanggal_kunjungan').val();
    var kode_dokter = $('#kode_dokter').val();
    var Loading='<option value="">Loading...</option>';
    $('#jam_kunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/PilihJamKunjungan.php',
        data 	    :  {tanggal_kunjungan: tanggal_kunjungan, kode_dokter: kode_dokter},
        success     : function(data){
            $('#jam_kunjungan').html(data);
        }
    });
});
//Simpan Kunjungan Pasien
$('#ProsesTambahKunjungan').submit(function(){
    $('#NotifikasiTambahKunjungan').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahKunjungan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/ProsesTambahKunjungan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahKunjungan').html(data);
            var NotifikasiTambahKunjunganBerhasil=$('#NotifikasiTambahKunjunganBerhasil').html();
            if(NotifikasiTambahKunjunganBerhasil=="Success"){
                window.location.replace("index.php?Page=WebKunjungan");
            }
        }
    });
});
//Edit Kunjungan Pasien
$('#ProsesEditKunjungan').submit(function(){
    $('#NotifikasiEditKunjungan').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditKunjungan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/ProsesEditKunjungan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditKunjungan').html(data);
            var NotifikasiEditKunjunganBerhasil=$('#NotifikasiEditKunjunganBerhasil').html();
            if(NotifikasiEditKunjunganBerhasil=="Success"){
                window.location.replace("index.php?Page=WebKunjungan");
            }
        }
    });
});
//Modal Detail Kunjungan
$('#ModalDetailKunjungan').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormDetailKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/FormDetailKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormDetailKunjungan').html(data);
        }
    });
});
//Modal Hapus Kunjungan
$('#ModalHapusKunjungan').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormHapusKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/FormHapusKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormHapusKunjungan').html(data);
            //Konfirmasi Hapus Kunjungan
            $('#KonfirmasiHapusKunjungan').click(function(){
                $('#NotifikasiHapusKunjungan').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebKunjungan/ProsesHapusKunjungan.php',
                    data 	    :  { id_kunjungan: id_kunjungan },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusKunjungan').html(data);
                        var NotifikasiHapusKunjunganBerhasil=$('#NotifikasiHapusKunjunganBerhasil').html();
                        if(NotifikasiHapusKunjunganBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapusKunjungan').modal('hide');
                            var BatasPencarian = $('#BatasPencarian').serialize();
                            var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                            $('#TabelKunjunganPasien').html(Loading);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebKunjungan/TabelKunjunganPasien.php',
                                data 	    :  BatasPencarian,
                                success     : function(data){
                                    $('#TabelKunjunganPasien').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Kunjungan Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                        }
                    }
                });
            });
        }
    });
});
//Modal Add To Antrian
$('#ModalAddToAntrian').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormAddToAntrian').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/FormAddToAntrian.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormAddToAntrian').html(data);
            //Edit Kunjungan Pasien
        $('#ProsesAddToAntrian').submit(function(){
            $('#NotifikasiAddToAntrian').html('<span class="text-primary">Loading...</span>');
            var form = $('#ProsesAddToAntrian')[0];
            var data = new FormData(form);
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/WebKunjungan/ProsesAddToAntrian.php',
                data 	    :  data,
                cache       : false,
                processData : false,
                contentType : false,
                enctype     : 'multipart/form-data',
                success     : function(data){
                    $('#NotifikasiAddToAntrian').html(data);
                    var NotifikasiAddToAntrianBerhasil=$('#NotifikasiAddToAntrianBerhasil').html();
                    if(NotifikasiAddToAntrianBerhasil=="Success"){
                        location.reload();
                    }
                }
            });
        });
        }
    });
});
//Modal Riwayat Task ID
$('#ModalRiwayatTaskId').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_antrian = $(e.relatedTarget).data('id');
    $('#FormRiwayatTaskId').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/FormRiwayatTaskId.php',
        data 	    :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormRiwayatTaskId').html(data);
        }
    });
});
//Modal Hapus Antrian
$('#ModalHapusAntrian').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_antrian = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormHapusAntrian').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/FormHapusAntrian.php',
        data 	    :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormHapusAntrian').html(data);
            //Konfirmasi Hapus Antrian
            $('#KonfirmasiHapusAntrian').click(function(){
                $('#NotifikasiHapusAntrian').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebKunjungan/ProsesHapusAntrian.php',
                    data 	    :  { id_antrian: id_antrian, id_kunjungan: id_kunjungan },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusAntrian').html(data);
                        var NotifikasiHapusAntrianBerhasil=$('#NotifikasiHapusAntrianBerhasil').html();
                        if(NotifikasiHapusAntrianBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Detail Pasien
$('#ModalDetailPasien').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_pasien = $(e.relatedTarget).data('id');
    $('#FormDetailpasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebKunjungan/FormDetailPasien.php',
        data 	    :  {id_web_pasien: id_web_pasien},
        success     : function(data){
            $('#FormDetailpasien').html(data);
        }
    });
});
//Modal Detail RM
$('#ModalDetailRm').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormDetailRm').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/FormDetailRm.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormDetailRm').html(data);
        }
    });
});