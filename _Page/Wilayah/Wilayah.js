$('#MenampilkanTabelWilayahInternal').load("_Page/Wilayah/TabelWilayahInternal.php");
//Ketika Mulai/Submit Pencarian
$('#BatasPencarianInternal').submit(function(){
    var BatasPencarianInternal = $('#BatasPencarianInternal').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelWilayahInternal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Wilayah/TabelWilayahInternal.php',
        data 	    :  BatasPencarianInternal,
        success     : function(data){
            $('#MenampilkanTabelWilayahInternal').html(data);
        }
    });
});
//Kondisi Pertama kali data BPJS inisiasi
$('#GetDataPropinsi').html('Loading..');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Wilayah/TabelListPropinsi.php',
    success     : function(data){
        $('#GetDataPropinsi').html(data);
    }
});
//Modal Tambah Wilayah
$('#ModalGetKabupaten').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var KodePropinsi = pecah[0];
    var NamaPropinsi = pecah[1];
    $('#KonfirmasiKabupaten').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Wilayah/KonfirmasiKabupaten.php',
        data        : {KodePropinsi: KodePropinsi},
        success     : function(data){
            $('#KonfirmasiKabupaten').html(data);
            $('#NamaPropinsi').html(NamaPropinsi);
            //konfirmasi data kabupaten
            $('#KonfirmasiTampilkanKabupaten').click(function(){
                $('#GetDataKabupaten').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/TabelListKabupaten.php',
                    data        : {KodePropinsi: KodePropinsi},
                    success     : function(data){
                        $('#GetDataKabupaten').html(data);
                        $('#ModalGetKabupaten').modal('hide');
                    }
                });
            });
        }
    });
});
$('#ModalGetKecamatan').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var KodeKabupaten = pecah[0];
    var NamaKabupaten = pecah[1];
    $('#KonfirmasiKecamatan').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Wilayah/KonfirmasiKecamatan.php',
        data        : {KodeKabupaten: KodeKabupaten},
        success     : function(data){
            $('#KonfirmasiKecamatan').html(data);
            $('#NamaKabupaten').html(NamaKabupaten);
            //konfirmasi data kecamatan
            $('#KonfirmasiTampilkanKecamatan').click(function(){
                $('#GetDataKecamatan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/TabelListKecamatan.php',
                    data        : {KodeKabupaten: KodeKabupaten},
                    success     : function(data){
                        $('#GetDataKecamatan').html(data);
                        $('#ModalGetKecamatan').modal('hide');
                    }
                });
            });
        }
    });
});

//Modal Tambah Wilayah
$('#ModalTambahWilayah').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTambahWilayah').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Wilayah/FormTambahWilayah.php',
        success     : function(data){
            $('#FormTambahWilayah').html(data);
            //kabupaten keyup
            $('#kabupaten').keyup(function(){
                var propinsi = $('#propinsi').val();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Wilayah/PilihKabupaten.php',
                    data 	:  'propinsi='+ propinsi,
                    success : function(data){
                        $('#DataListKabupaten').html(data);
                    }
                });
            });
            //kecamatan keyup
            $('#kecamatan').keyup(function(){
                var kabupaten = $('#kabupaten').val();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Wilayah/PilihKecamatan.php',
                    data 	:  'kabupaten='+ kabupaten,
                    success : function(data){
                        $('#DataListKecamatan').html(data);
                    }
                });
            });
            //desa keyup
            $('#desa').keyup(function(){
                var kecamatan = $('#kecamatan').val();
                $.ajax({
                    type 	: 'POST',
                    url 	: '_Page/Wilayah/PilihDesa.php',
                    data 	:  'kecamatan='+ kecamatan,
                    success : function(data){
                        $('#DataListDesa').html(data);
                    }
                });
            });
            $('#ProsesTambahWilayah').submit(function(){
                e.preventDefault();
                $('#NotifikasiTambahWilayah').html('Loading..');
                var form = $('#ProsesTambahWilayah')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/ProsesTambahWilayah.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahWilayah').html(data);
                        var NotifikasiTambahWilayahBerhasil=$('#NotifikasiTambahWilayahBerhasil').html();
                        if(NotifikasiTambahWilayahBerhasil=="Berhasil"){
                            $('#MenampilkanTabelWilayahInternal').load("_Page/Wilayah/TabelWilayahInternal.php");
                            $('#ModalTambahWilayah').modal("hide");
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Tambah Wilayah Baru Berhasil',
                                icon: 'success',
                                confirmButtonText: 'Tutup'
                            })
                        }
                    }
                });
            });
        }
    });
});
//Modal Detail Wilayah
$('#ModalDetailWilayah').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_wilayah = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var posisi = pecah[6];
    var keyword_by = pecah[7];
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailWilayah').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Wilayah/FormDetailWilayah.php',
        data        : {id_wilayah: id_wilayah},
        success     : function(data){
            $('#FormDetailWilayah').html(data);
            //Kondisi ketika Edit Wilayah
            $('#ModalEditWilayah').on('show.bs.modal', function (e) {
                $('#FormEditWilayah').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/FormEditWilayah.php',
                    data        :  {id_wilayah: id_wilayah},
                    success     : function(data){
                        $('#FormEditWilayah').html(data);
                        //Konfirmasi Edit Data Pasien
                        $('#ProsesEditWilayah').submit(function(){
                            $('#NotifikasiEditWilayah').html('Loading...');
                            var form = $('#ProsesEditWilayah')[0];
                            var data = new FormData(form);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Wilayah/ProsesEditWilayah.php',
                                data 	    :  data,
                                cache       : false,
                                processData : false,
                                contentType : false,
                                enctype     : 'multipart/form-data',
                                success     : function(data){
                                    $('#NotifikasiEditWilayah').html(data);
                                    var NotifikasiEditWilyah=$('#NotifikasiEditWilyah').html();
                                    if(NotifikasiEditWilyah=="Berhasil"){
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/Wilayah/TabelWilayahInternal.php',
                                            data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by},
                                            success     : function(data){
                                                $('#MenampilkanTabelWilayahInternal').html(data);
                                                $('#ModalEditWilayah').modal("toggle");
                                                $('#ModalDetailWilayah').modal('toggle');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Edit Data Wilayah Berhasil',
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
            //Kondisi ketika delete wilayah
            $('#ModalDeleteWilayah').on('show.bs.modal', function (e) {
                $('#FormDeleteWilayah').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/FormDeleteWilayah.php',
                    data        :  {id_wilayah: id_wilayah},
                    success     : function(data){
                        $('#FormDeleteWilayah').html(data);
                        //Konfirmasi Hapus Data Pasien
                        $('#KonfirmasiHapusWilayah').click(function(){
                            $('#NotifikasiHapusWilayah').html('Loading...');
                            $.ajax({
                                url     : "_Page/Wilayah/ProsesHapusWilayah.php",
                                method  : "POST",
                                data    :  {id_wilayah: id_wilayah},
                                success : function (data) {
                                    $('#NotifikasiHapusWilayah').html(data);
                                    //Notifikasi Proses Hapus
                                    var NotifikasiHapus=$('#NotifikasiHapus').html();
                                    if(NotifikasiHapus=="Berhasil"){
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/Wilayah/TabelWilayahInternal.php',
                                            data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by},
                                            success     : function(data){
                                                $('#MenampilkanTabelWilayahInternal').html(data);
                                                $('#ModalDeleteWilayah').modal('toggle');
                                                $('#ModalDetailWilayah').modal('toggle');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Hapus Data Wilayah Berhasil',
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
        }
    });
});
//Modal Filter Tabel
$('#ModalFilterTabel').on('show.bs.modal', function (e) {
    var ColomName = $(e.relatedTarget).data('id');
    $('#FormFilterTabel').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Wilayah/FormFilterTabel.php',
        data 	    :  {ColomName: ColomName},
        success     : function(data){
            $('#FormFilterTabel').html(data);
            $('#ProsesFilterTabel').submit(function(){
                var batas = $('#batas').val();
                var keyword_by = $('#keyword_by').val();
                var keyword = $('#keyword_short').val();
                var ShortBy = $('#ShortBy').val();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelWilayahInternal').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/TabelWilayahInternal.php',
                    data 	    :  {keyword_by: keyword_by, keyword: keyword, batas: batas, ShortBy: ShortBy},
                    success     : function(data){
                        $('#MenampilkanTabelWilayahInternal').html(data);
                    }
                });
            });
        }
    });
});

//MENDAGRI
$('#MenampilkanTabelWilayahMendagri').load("_Page/Wilayah/TabelWilayahMendagri.php");
//Ketika Mulai/Submit Pencarian
$('#BatasPencarianMendagri').submit(function(){
    var BatasPencarianMendagri = $('#BatasPencarianMendagri').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelWilayahMendagri').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Wilayah/TabelWilayahMendagri.php',
        data 	    :  BatasPencarianMendagri,
        success     : function(data){
            $('#MenampilkanTabelWilayahMendagri').html(data);
        }
    });
});
//Modal Detail Wilayah Mendagri
$('#ModalDetailWilayahMendagri').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_wilayah_mendagri = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var posisi = pecah[6];
    var keyword_by = pecah[7];
    var kategori = pecah[8];
    $('#FormDetailWilayahMendagri').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Wilayah/FormDetailWilayahMendagri.php',
        data        : {id_wilayah_mendagri: id_wilayah_mendagri},
        success     : function(data){
            $('#FormDetailWilayahMendagri').html(data);
            //Ketika Menampilkan Kabupaten
            $('#TampilkanKabupaten').click(function(){
                var GetKodeWilayahMendagri = $('#GetKodeWilayahMendagri').html();
                var keyword_by = 'kode';
                var kategori = 'Kota Kabupaten';
                $('#MenampilkanTabelWilayahMendagri').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/TabelWilayahMendagri.php',
                    data 	    :  {keyword: GetKodeWilayahMendagri, kategori: kategori, keyword_by, keyword_by: keyword_by,},
                    success     : function(data){
                        $('#MenampilkanTabelWilayahMendagri').html(data);
                        $('#ModalDetailWilayahMendagri').modal('hide');
                    }
                });
            });
            //Ketika Menampilkan Kecamatan
            $('#TampilkanKecamatan').click(function(){
                var GetKodeWilayahMendagri = $('#GetKodeWilayahMendagri').html();
                var keyword_by = 'kode';
                var kategori = 'Kecamatan';
                $('#MenampilkanTabelWilayahMendagri').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/TabelWilayahMendagri.php',
                    data 	    :  {keyword: GetKodeWilayahMendagri, kategori: kategori, keyword_by, keyword_by: keyword_by,},
                    success     : function(data){
                        $('#MenampilkanTabelWilayahMendagri').html(data);
                        $('#ModalDetailWilayahMendagri').modal('hide');
                    }
                });
            });
            //Ketika Menampilkan Desa
            $('#TampilkanDesa').click(function(){
                var GetKodeWilayahMendagri = $('#GetKodeWilayahMendagri').html();
                var keyword_by = 'kode';
                var kategori = 'Kelurahan';
                $('#MenampilkanTabelWilayahMendagri').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Wilayah/TabelWilayahMendagri.php',
                    data 	    :  {keyword: GetKodeWilayahMendagri, kategori: kategori, keyword_by, keyword_by: keyword_by,},
                    success     : function(data){
                        $('#MenampilkanTabelWilayahMendagri').html(data);
                        $('#ModalDetailWilayahMendagri').modal('hide');
                    }
                });
            });
        }
    });
});