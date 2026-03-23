var BatasPencarian = $('#BatasPencarian').serialize();
var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
$('#TabelAksesPasien').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebAksesPasien/TabelAksesPasien.php',
    data 	    :  BatasPencarian,
    success     : function(data){
        $('#TabelAksesPasien').html(data);
    }
});
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelAksesPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/TabelAksesPasien.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelAksesPasien').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelAksesPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/TabelAksesPasien.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelAksesPasien').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
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
//Modal Detail Pasien
$('#ModalDetailPasien').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_pasien = $(e.relatedTarget).data('id');
    $('#FormDetailpasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/FormDetailPasien.php',
        data 	    :  {id_web_pasien: id_web_pasien},
        success     : function(data){
            $('#FormDetailpasien').html(data);
        }
    });
});
//Proses Tambah Pasien
$('#ProsesTambahPasien').submit(function(){
    $('#NotifikasiTambahPasien').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahPasien')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/ProsesTambahPasien.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahPasien').html(data);
            var NotifikasiTambahPasienBerhasil=$('#NotifikasiTambahPasienBerhasil').html();
            if(NotifikasiTambahPasienBerhasil=="Success"){
                window.location.replace("index.php?Page=WebAksesPasien");
            }
        }
    });
});
//Proses Edit Pasien
$('#ProsesEditPasien').submit(function(){
    $('#NotifikasiEditPasien').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditPasien')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/ProsesEditPasien.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditPasien').html(data);
            var NotifikasiEditPasienBerhasil=$('#NotifikasiEditPasienBerhasil').html();
            if(NotifikasiEditPasienBerhasil=="Success"){
                window.location.replace("index.php?Page=WebAksesPasien");
            }
        }
    });
});
//Modal Hapus Pasien
$('#ModalHapusPasien').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_pasien = $(e.relatedTarget).data('id');
    $('#FormHapusPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/FormHapusPasien.php',
        data 	    :  {id_web_pasien: id_web_pasien},
        success     : function(data){
            $('#FormHapusPasien').html(data);
            //Konfirmasi Hapus Pasien
            $('#KonfirmasiHapusPasien').click(function(){
                $('#NotifikasiHapusHapus').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebAksesPasien/ProsesHapusPasien.php',
                    data 	    :  { id_web_pasien: id_web_pasien },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusHapus').html(data);
                        var NotifikasiHapusHapusBerhasil=$('#NotifikasiHapusHapusBerhasil').html();
                        if(NotifikasiHapusHapusBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapusPasien').modal('hide');
                            var BatasPencarian = $('#BatasPencarian').serialize();
                            var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                            $('#TabelAksesPasien').html(Loading);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebAksesPasien/TabelAksesPasien.php',
                                data 	    :  BatasPencarian,
                                success     : function(data){
                                    $('#TabelAksesPasien').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Pasien Berhasil',
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
//Modal Detail Nik
$('#ModalDetailNik').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var nik = $(e.relatedTarget).data('id');
    $('#FormDetailNik').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/FormDetailNik.php',
        data 	    :  {nik: nik},
        success     : function(data){
            $('#FormDetailNik').html(data);
            //Menampilkan Detail pasien Dari SIMRS
            $('#DetailDariSimrs').click(function(){
                $('#DetailPasienNik').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebAksesPasien/FormNikSimrs.php',
                    data 	    :  { nik: nik },
                    success     : function(data){
                        $('#DetailPasienNik').html(data);
                    }
                });
            });
            //Menampilkan Detail pasien Dari BPJS
            $('#DetailDariBpjs').click(function(){
                $('#DetailPasienNik').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebAksesPasien/FormNikBpjs.php',
                    data 	    :  { nik: nik },
                    success     : function(data){
                        $('#DetailPasienNik').html(data);
                    }
                });
            });
        }
    });
});
//Modal Detail Bpjs
$('#ModalDetailBpjs').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var bpjs = $(e.relatedTarget).data('id');
    $('#FormDetailBpjs').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/FormDetailBpjs.php',
        data 	    :  {bpjs: bpjs},
        success     : function(data){
            $('#FormDetailBpjs').html(data);
            //Menampilkan Detail pasien Dari SIMRS
            $('#DetailBpjsDariSimrs').click(function(){
                $('#DetailPasienBpjs').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebAksesPasien/FormKartuSimrs.php',
                    data 	    :  { bpjs: bpjs },
                    success     : function(data){
                        $('#DetailPasienBpjs').html(data);
                    }
                });
            });
            //Menampilkan Detail pasien Dari BPJS
            $('#DetailBpjsDariBpjs').click(function(){
                $('#DetailPasienBpjs').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebAksesPasien/FormKartuBpjs.php',
                    data 	    :  { bpjs: bpjs },
                    success     : function(data){
                        $('#DetailPasienBpjs').html(data);
                    }
                });
            });
        }
    });
});

//Modal Detail Kontak
$('#ModalDetailKontak').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var kontak = $(e.relatedTarget).data('id');
    $('#FormDetailKontak').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/FormDetailKontak.php',
        data 	    :  {kontak: kontak},
        success     : function(data){
            $('#FormDetailKontak').html(data);
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
        url 	    : '_Page/WebAksesPasien/FormDetailKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormDetailKunjungan').html(data);
        }
    });
});
//Tambah Pasien
$('#ModalTambahPasien').on('show.bs.modal', function (e) {
    var id_web_pasien = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTambahPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebAksesPasien/FormTambahPasienRm.php',
        data 	    :  {id_web_pasien: id_web_pasien},
        success     : function(data){
            $('#FormTambahPasien').html(data);
            
            //Reload ID Pasien
            $('#ReloadIdPasien').click(function(){
                $('#id_pasien').val("Loading..");
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/WebAksesPasien/ReloadIdPasien.php',
                    success : function(data){
                        $('#id_pasien').val(data.replace(/\s/g, ''));
                    }
                });
            });
            //CekNik
            $('#CekNik').click(function(){
                var nik=$('#nik').val();
                var CekNik=$('#CekNik').val();
                if(CekNik=="Tampilkan"){
                    $('#CekNik').val('Sembunyikan');
                    $('#CekNik').html('<i class="ti ti-angle-up"></i>');
                    $('#HasilCekNik').html("Loading..");
                    $.ajax({
                        type 	: 'POST',
                        url 	: '_Page/WebAksesPasien/ProsesCekNik.php',
                        data    : {nik: nik},
                        success : function(data){
                            $('#HasilCekNik').html(data);
                        }
                    });
                }else{
                    $('#CekNik').val('Tampilkan');
                    $('#CekNik').html('<i class="ti ti-angle-down"></i>');
                    $('#HasilCekNik').html("");
                }
            });
            //CekNikBpjs
            $('#CekBpjs').click(function(){
                var no_bpjs=$('#no_bpjs').val();
                var CekBpjs=$('#CekBpjs').val();
                if(CekBpjs=="Tampilkan"){
                    $('#CekBpjs').val('Sembunyikan');
                    $('#CekBpjs').html('<i class="ti ti-angle-up"></i>');
                    $('#HasilCekBpjs').html("Loading..");
                    $.ajax({
                        type 	: 'POST',
                        url 	: '_Page/WebAksesPasien/ProsesCekBpjs.php',
                        data    : {no_bpjs: no_bpjs},
                        success : function(data){
                            $('#HasilCekBpjs').html(data);
                        }
                    });
                }else{
                    $('#CekBpjs').val('Tampilkan');
                    $('#CekBpjs').html('<i class="ti ti-angle-down"></i>');
                    $('#HasilCekBpjs').html("");
                }
                
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
            //Proses Tambah Data Pasien Ke SIMRS
            $('#ProsesTambahPasien').submit(function(){
                e.preventDefault();
                $('#NotifikasiTambahPasien').html('Loading..');
                var form = $('#ProsesTambahPasien')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebAksesPasien/ProsesTambahPasienRm.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahPasien').html(data);
                        var NotifikasiTambahPasienBerhasil=$('#NotifikasiTambahPasienBerhasil').html();
                        if(NotifikasiTambahPasienBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});