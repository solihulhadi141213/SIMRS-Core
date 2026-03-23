$('#MenampilkanTabelPasien').load("_Page/Pasien/TabelPasien.php");
//Batas dan Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/TabelPasien.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelPasien').html(data);
        }
    });
});
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/TabelPasien.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelPasien').html(data);
        }
    });
});
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormKeywordPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormKeywordPasien.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeywordPasien').html(data);
        }
    });
});
//Tambah Pasien
$('#ModalTambahPasien').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTambahPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormTambahPasien.php',
        success     : function(data){
            $('#FormTambahPasien').html(data);
            
        }
    });
});
//Reload ID Pasien
$('#ReloadIdPasien').click(function(){
    $('#NotifikasiIdPasien').html("Loading..");
    $.ajax({
        type 	: 'POST',
        url 	: '_Page/Pasien/ReloadIdPasien.php',
        success : function(data){
            $('#GetIdpasien').val(data.replace(/\s/g, ''));
            $('#NotifikasiIdPasien').html("<i class='text-info'>Reload Selesai</i>");
        }
    });
});
//CekNikBpjs
$('#CekNikBpjs').click(function(){
    var nik=$('#nik').val();
    $('#HasilCekPeserta').html("Loading..");
    $.ajax({
        type 	: 'POST',
        url 	: '_Page/Pasien/ProsesCekPesertaNik.php',
        data    : {nik: nik},
        success : function(data){
            $('#HasilCekPeserta').html(data);
        }
    });
});
//CekNikBpjs
$('#CekNoKartuBpjs').click(function(){
    var no_bpjs=$('#no_bpjs').val();
    $('#HasilCekPeserta').html("Loading..");
    $.ajax({
        type 	: 'POST',
        url 	: '_Page/Pasien/ProsesCekPesertaKartu.php',
        data    : {no_bpjs: no_bpjs},
        success : function(data){
            $('#HasilCekPeserta').html(data);
        }
    });
});
//propinsi
$('#propinsi').change(function(){
    $('#desa').html("<option>Pilih</option>");
    $('#kecamatan').html("<option>Pilih</option>");
    $('#kabupaten').html("<option>Loading..</option>");
    var propinsi = $('#propinsi').val();
    $.ajax({
        type 	: 'POST',
        url 	: '_Page/Pasien/PilihKabupaten.php',
        data 	:  'propinsi='+ propinsi,
        success : function(data){
            $('#kabupaten').html(data);
        }
    });
});
//Kabupaten
$('#kabupaten').change(function(){
    $('#desa').html("<option>Pilih</option>");
    $('#kecamatan').html("<option>Loading..</option>");
    var kabupaten = $('#kabupaten').val();
    $.ajax({
        type 	: 'POST',
        url 	: '_Page/Pasien/PilihKecamatan.php',
        data 	:  'kabupaten='+ kabupaten,
        success : function(data){
            $('#kecamatan').html(data);
        }
    });
});
//Kecamatan
$('#kecamatan').change(function(){
    $('#desa').html("<option>Loading..</option>");
    var kecamatan = $('#kecamatan').val();
    $.ajax({
        type 	: 'POST',
        url 	: '_Page/Pasien/PilihDesa.php',
        data 	:  'kecamatan='+ kecamatan,
        success : function(data){
            $('#desa').html(data);
        }
    });
});
//Modal Konfirmasi Edit Pasien
$('#ModalKonfirmasiEditPasien').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormKonfirmasiEditPasien').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormKonfirmasiEditPasien.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormKonfirmasiEditPasien').html(data);
        }
    });
});
//Modal Detail Pasien
$('#ModalDetailPasien').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_pasien = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var posisi = pecah[6];
    var keyword_by = pecah[7];
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormDetailPasien.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormDetailPasien').html(data);
            //Edit Pasien
            $('#ModalEditPasien').on('show.bs.modal', function (e) {
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormEditPasien').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Pasien/FormEditPasien.php',
                    data 	    :  {id_pasien: id_pasien},
                    success     : function(data){
                        $('#FormEditPasien').html(data);
                        //CekNikBpjs
                        $('#CekNikBpjs2').click(function(){
                            var nik=$('#nik').val();
                            $('#HasilCekPeserta2').html("Loading..");
                            $.ajax({
                                type 	: 'POST',
                                url 	: '_Page/Pasien/ProsesCekPesertaNik.php',
                                data    : {nik: nik},
                                success : function(data){
                                    $('#HasilCekPeserta2').html(data);
                                }
                            });
                        });
                        //CekNikBpjs
                        $('#CekNoBpjs2').click(function(){
                            var no_bpjs=$('#no_bpjs').val();
                            $('#HasilCekPeserta2').html("Loading..");
                            $.ajax({
                                type 	: 'POST',
                                url 	: '_Page/Pasien/ProsesCekPesertaKartu.php',
                                data    : {no_bpjs: no_bpjs},
                                success : function(data){
                                    $('#HasilCekPeserta2').html(data);
                                }
                            });
                        });
                        //propinsi
                        $('#propinsi2').change(function(){
                            $('#desa2').html("<option>Pilih</option>");
                            $('#kecamatan2').html("<option>Pilih</option>");
                            $('#kabupaten2').html("<option>Loading..</option>");
                            var propinsi2 = $('#propinsi2').val();
                            $.ajax({
                                type 	: 'POST',
                                url 	: '_Page/Pasien/PilihKabupaten.php',
                                data 	:  'propinsi='+ propinsi2,
                                success : function(data){
                                    $('#kabupaten2').html(data);
                                }
                            });
                        });
                        //Kabupaten
                        $('#kabupaten2').change(function(){
                            $('#desa2').html("<option>Pilih</option>");
                            $('#kecamatan2').html("<option>Loading..</option>");
                            var kabupaten2 = $('#kabupaten2').val();
                            $.ajax({
                                type 	: 'POST',
                                url 	: '_Page/Pasien/PilihKecamatan.php',
                                data 	:  'kabupaten='+ kabupaten2,
                                success : function(data){
                                    $('#kecamatan2').html(data);
                                }
                            });
                        });
                        //Kecamatan
                        $('#kecamatan2').change(function(){
                            $('#desa2').html("<option>Loading..</option>");
                            var kecamatan2 = $('#kecamatan2').val();
                            $.ajax({
                                type 	: 'POST',
                                url 	: '_Page/Pasien/PilihDesa.php',
                                data 	:  'kecamatan='+ kecamatan2,
                                success : function(data){
                                    $('#desa2').html(data);
                                }
                            });
                        });
                    }
                });
            });
        }
    });
});
//Modal Export Pasien
$('#ModalExportPasien').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormExportPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormExportPasien.php',
        success     : function(data){
            $('#FormExportPasien').html(data);
        }
    });
});
//Modal Filter Tabel
$('#ModalFilterTabel').on('show.bs.modal', function (e) {
    var ColomName = $(e.relatedTarget).data('id');
    $('#FormFilterTabel').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormFilterTabel.php',
        data 	    :  {ColomName: ColomName},
        success     : function(data){
            $('#FormFilterTabel').html(data);
            $('#ProsesFilterTabel').submit(function(){
                var batas = $('#batas').val();
                var keyword_by = $('#keyword_by').val();
                var keyword = $('#keyword_short').val();
                var ShortBy = $('#ShortBy').val();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelPasien').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Pasien/TabelPasien.php',
                    data 	    :  {keyword_by: keyword_by, keyword: keyword, batas: batas, ShortBy: ShortBy},
                    success     : function(data){
                        $('#MenampilkanTabelPasien').html(data);
                    }
                });
            });
        }
    });
});
//Modal Pencarian pasien BPJS
$('#ModalPencarianPasienBPJS').on('show.bs.modal', function (e) {
    var PencarianPasienBpjs = $('#PencarianPasienBpjs').serialize();
    $('#FormHasilPencarianPasienBpjs').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
        data 	    :  PencarianPasienBpjs,
        success     : function(data){
            $('#FormHasilPencarianPasienBpjs').html(data);
        }
    });
});
//Apabila dasar Pencarian pasien satu sehat berubah
$('#DasarPencarianPasienSatuSehat').change(function(){
    var DasarPencarianPasienSatuSehat = $('#DasarPencarianPasienSatuSehat').val();
    $('#FormLanjutanPasienSatuSehat').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormLanjutanPencarianPasienSatuSehat.php',
        data 	    :  {DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat},
        success     : function(data){
            $('#FormLanjutanPasienSatuSehat').html(data);
        }
    });
});
//Modal Pencarian pasien Satu Sehat
$('#ModalPencarianpasienSatuSehat').on('show.bs.modal', function (e) {
    var PencarianPasienSatuSehat = $('#PencarianPasienSatuSehat').serialize();
    $('#FormHasilPencarianPasienSatuSehat').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
        data 	    :  PencarianPasienSatuSehat,
        success     : function(data){
            $('#FormHasilPencarianPasienSatuSehat').html(data);
        }
    });
});
//Modal Pencarian pasien BPJS
$('#ModalCekNikBpjs').on('show.bs.modal', function (e) {
    var nik = $('#nik').val();
    var DasarPencarianPasienBpjs="NIK";
    $('#FormCekNikBpjs').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
        data 	    :  {keyword: nik, DasarPencarianPasienBpjs: DasarPencarianPasienBpjs},
        success     : function(data){
            $('#FormCekNikBpjs').html(data);
        }
    });
});
//Modal Pencarian pasien BPJS
$('#ModalCekNokaBpjs').on('show.bs.modal', function (e) {
    var keyword = $('#no_bpjs').val();
    var DasarPencarianPasienBpjs="no_bpjs";
    $('#FormCekNokaBpjs').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
        data 	    :  {keyword: keyword, DasarPencarianPasienBpjs: DasarPencarianPasienBpjs},
        success     : function(data){
            $('#FormCekNokaBpjs').html(data);
        }
    });
});
//Modal Cek Nik Satu Sehat
$('#ModalCekNikSatuSehat').on('show.bs.modal', function (e) {
    var nik_pasien = $('#nik').val();
    var DasarPencarianPasienSatuSehat="NIK";
    $('#FormCekNikSatuSehat').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
        data 	    :  {nik_pasien: nik_pasien, DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat},
        success     : function(data){
            $('#FormCekNikSatuSehat').html(data);
        }
    });
});
//Modal Cek IHS
$('#ModalCekIhs').on('show.bs.modal', function (e) {
    var id_ihs = $('#id_ihs').val();
    var DasarPencarianPasienSatuSehat="ID Pasien";
    $('#FormCekIhs').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
        data 	    :  {IdPasien: id_ihs, DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat},
        success     : function(data){
            $('#FormCekIhs').html(data);
        }
    });
});
//Proses Tambah Pasien
$('#ProsesTambahPasien').submit(function(){
    $('#NotifikasiTambahPasien').html('Loading..');
    var form = $('#ProsesTambahPasien')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/ProsesTambahPasien.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahPasien').html(data);
            var NotifikasiTambahPasienBerhasil=$('#NotifikasiTambahPasienBerhasil').html();
            var UrlBack=$('#UrlBack').html();
            var URLBack2=UrlBack.replace(/&amp;/g, '&');
            if(NotifikasiTambahPasienBerhasil=="Success"){
                location.href = URLBack2;
            }
        }
    });
});
//Modal Creat IHS Pasien
$('#ModalCreatIhs').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormCreatIhs').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormCreatIhs.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormCreatIhs').html(data);
            //propinsi_ihs
            $('#propinsi_ihs').change(function(){
                $('#desa_ihs').html("<option>Pilih</option>");
                $('#kecamatan_ihs').html("<option>Pilih</option>");
                $('#kabupaten_ihs').html("<option>Loading..</option>");
                var keyword = $('#propinsi_ihs').val();
                var kategori ="Kota Kabupaten";
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Pasien/PilihWilayahIhs.php',
                    data 	:  {keyword: keyword, kategori: kategori},
                    success : function(data){
                        $('#kabupaten_ihs').html(data);
                    }
                });
            });
            //Kabupaten
            $('#kabupaten_ihs').change(function(){
                $('#desa_ihs').html("<option>Pilih</option>");
                $('#kecamatan_ihs').html("<option>Loading..</option>");
                var keyword = $('#kabupaten_ihs').val();
                var kategori ="Kecamatan";
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Pasien/PilihWilayahIhs.php',
                    data 	:  {keyword: keyword, kategori: kategori},
                    success : function(data){
                        $('#kecamatan_ihs').html(data);
                    }
                });
            });
            //Kecamatan
            $('#kecamatan_ihs').change(function(){
                $('#desa_ihs').html("<option>Loading..</option>");
                var keyword = $('#kecamatan_ihs').val();
                var kategori ="Kelurahan";
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Pasien/PilihWilayahIhs.php',
                    data 	:  {keyword: keyword, kategori: kategori},
                    success : function(data){
                        $('#desa_ihs').html(data);
                    }
                });
            });
            //Proses Creat IHS
            $('#ProsesCreatIhs').submit(function(){
                $('#NotifikasiCreatIhsPasien').html('Loading..');
                var form = $('#ProsesCreatIhs')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Pasien/ProsesCreatIhs.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiCreatIhsPasien').html(data);
                        var NotifikasiCreatIhsPasienBerhasil=$('#NotifikasiCreatIhsPasienBerhasil').html();
                        if(NotifikasiCreatIhsPasienBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//proses Upload Foto pasien
$('#ProsesUploadFotoPasien').submit(function(){
    $('#NotifikasiUploadFotoPasien').html('Loading..');
    var form = $('#ProsesUploadFotoPasien')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/ProsesUploadFotoPasien.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiUploadFotoPasien').html(data);
            var NotifikasiUploadFotoPasienBerhasil=$('#NotifikasiUploadFotoPasienBerhasil').html();
            if(NotifikasiUploadFotoPasienBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Hapus Foto Pasien
$('#ModalHapusFoto').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormHapusFoto').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHapusFoto.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormHapusFoto').html(data);
            //Proses Proses Hapus Foto
            $('#KonfirmasiHapusFoto').click(function(){
                $('#NotifikasiHapusFoto').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Pasien/ProsesHapusFoto.php',
                    data 	    :  {id_pasien: id_pasien},
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusFoto').html(data);
                        var NotifikasiHapusFotoBerhasil=$('#NotifikasiHapusFotoBerhasil').html();
                        if(NotifikasiHapusFotoBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//List Kunjungan
var GetIdPasien = $('#GetIdPasien').html();
var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
$('#MenampilkanTabelRiwayatKunjungan').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Pasien/TabelKunjunganPasien.php',
    data 	    :  {GetIdPasien: GetIdPasien},
    success     : function(data){
        $('#MenampilkanTabelRiwayatKunjungan').html(data);
    }
});
$('#ProsesEditPasien').submit(function(){
    $('#NotifikasiEditPasien').html('Loading..');
    var form = $('#ProsesEditPasien')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/ProsesEditPasien.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditPasien').html(data);
            var NotifikasiEditPasienBerhasil=$('#NotifikasiEditPasienBerhasil').html();
            var NotifikasiUrlForBack=$('#NotifikasiUrlForBack').html();
            if(NotifikasiEditPasienBerhasil=="Success"){
                var URLBack3=NotifikasiUrlForBack.replace(/&amp;/g, '&');
                if(NotifikasiEditPasienBerhasil=="Success"){
                    location.href = URLBack3;
                }
            }
        }
    });
});
//Modal Konfirmasi Tambah Kunjungan
$('#ModalKonfirmasiBuatKunjungan').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormKonfirmasiTambahKunjungan').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormKonfirmasiTambahKunjungan.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormKonfirmasiTambahKunjungan').html(data);
        }
    });
});
//Modal Detail IHS Pasien
$('#ModalDetailIhs').on('show.bs.modal', function (e) {
    var IdPasien = $(e.relatedTarget).data('id');
    var DasarPencarianPasienSatuSehat="ID Pasien";
    $('#FormDetailIHS').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
        data 	    :  {IdPasien: IdPasien, DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat},
        success     : function(data){
            $('#FormDetailIHS').html(data);
        }
    });
});
//Modal Detail NIK Pasien
$('#ModalDetailNik').on('show.bs.modal', function (e) {
    var nik_pasien = $(e.relatedTarget).data('id');
    var DasarPencarianPasienSatuSehat="NIK";
    var DasarPencarianPasienBpjs="NIK";
    $('#FormDetailNik').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormDetailNik.php',
        data 	    :  {nik: nik_pasien},
        success     : function(data){
            $('#FormDetailNik').html(data);
            $('#FormDetailNikByIhs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
                data 	    :  {DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat, nik_pasien: nik_pasien},
                success     : function(data){
                    $('#FormDetailNikByIhs').html(data);
                }
            });
            $('#FormDetailNikByBpjs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
                data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: nik_pasien},
                success     : function(data){
                    $('#FormDetailNikByBpjs').html(data);
                }
            });
        }
    });
});
//Modal Detail BPJS Pasien
$('#ModalDetailBpjs').on('show.bs.modal', function (e) {
    var no_bpjs = $(e.relatedTarget).data('id');
    var DasarPencarianPasienBpjs="Noka";
    $('#FormDetailBPJS').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
        data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: no_bpjs},
        success     : function(data){
            $('#FormDetailBPJS').html(data);
        }
    });
});
//
$('#ModalDetailKunjungan').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    var UrlBackPasien=$('#UrlBackPasien').val();
    $('#FormDetailKunjungan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan, UrlBackPasien: UrlBackPasien},
        success     : function(data){
            $('#FormDetailKunjungan').html(data);
        }
    });
});
//Menampilkan Riwayat SEP
$('#ProsesTampilkanHistorySep').submit(function(){
    $('#ListRiwayatSep').html('Loading..');
    var form = $('#ProsesTampilkanHistorySep')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/ListRiwayatSep.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#ListRiwayatSep').html(data);
        }
    });
});
//Modal Detail Sep
$('#ModalDetailSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#FormDetailSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/FormDetailSep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormDetailSep').html(data);
        }
    });
});

//Menampilkan Consent pertama kali
var id_patient=$('#id_patient').val();
$('#MenampilkanStatusConsent').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Pasien/FormDetailConsent.php',
    data        : {id_patient: id_patient},
    success     : function(data){
        $('#MenampilkanStatusConsent').html(data);
    }
});
//Kondisi Ketika Di reload
$('#ReloadConsent').click(function(){
    var id_patient=$('#id_patient').val();
    $('#MenampilkanStatusConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormDetailConsent.php',
        data        : {id_patient: id_patient},
        success     : function(data){
            $('#MenampilkanStatusConsent').html(data);
        }
    });
});
//Modal Update Consent
$('#ModalUpdateConsent').on('show.bs.modal', function (e) {
    var id_patient = $(e.relatedTarget).data('id');
    $('#FormUpdateConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormUpdateConsent.php',
        data        : {id_patient: id_patient},
        success     : function(data){
            $('#FormUpdateConsent').html(data);
            $('#NotifikasiUpdateConsent').html('Pastikan Data Informasi Consent Yang Anda Kirim Sudah Sesuai');
        }
    });
});
//Proses Update Consent
$('#ProsesUpdateConsent').submit(function(){
    var id_patient=$('#id_patient').val();
    var ProsesUpdateConsent=$('#ProsesUpdateConsent').serialize();
    $('#NotifikasiUpdateConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/ProsesUpdateConsent.php',
        data        : ProsesUpdateConsent,
        success     : function(data){
            $('#NotifikasiUpdateConsent').html(data);
            var NotifikasiUpdateConsentBerhasil=$('#NotifikasiUpdateConsentBerhasil').html();
            if(NotifikasiUpdateConsentBerhasil=="Success"){
                $('#MenampilkanStatusConsent').html("Loading...");
                $('#ModalUpdateConsent').modal("hide");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Pasien/FormDetailConsent.php',
                    data        : {id_patient: id_patient},
                    success     : function(data){
                        $('#MenampilkanStatusConsent').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Update Consent Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});

//Hapus Pasien
$('#ModalHapusPasien').on('show.bs.modal', function (e) {
    var id_pasien=$(e.relatedTarget).data('id');
    $('#FormHapusPasien').html('Loading....');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHapusPasien.php',
        data        :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormHapusPasien').html(data);
            $('#NotifikasiHapusPasien').html("");
            $('#ButtonHapusPasien').html('<i class="ti-check-box"></i> Ya, Hapus');
        }
    });
});
//Konfirmasi Hapus Data Pasien
$('#ProsesHapusPasien').submit(function (e) {
    e.preventDefault(); 
    // Mencegah form melakukan submit default
    var ProsesHapusPasien = $('#ProsesHapusPasien').serialize();
    $('#NotifikasiHapusPasien').html('Loading...');
    $.ajax({
        url: "_Page/Pasien/ProsesHapusPasien.php",
        method: "POST",
        data: ProsesHapusPasien,
        success: function (data) {
            $('#NotifikasiHapusPasien').html(data);
            var NotifikasiHapusPasienBerhasil = $('#NotifikasiHapusPasienBerhasil').html();
            if (NotifikasiHapusPasienBerhasil == "Success") {
                //Tutup Modal
                $('#ModalHapusPasien').modal('hide');
                //Tampilkan Swal
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data pasien berhasil dihapus.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Arahkan ke halaman yang diinginkan
                        window.location.href = "index.php?Page=Pasien";
                    }
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menghapus data pasien.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function () {
            Swal.fire({
                title: 'Error!',
                text: 'Gagal menghubungi server.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});