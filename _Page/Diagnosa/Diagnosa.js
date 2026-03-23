$('#MenampilkanDataDiagnosa').load("_Page/Diagnosa/TabelDiagnosa.php");
$('#BatasPencarianSimrs').submit(function(){
    var BatasPencarianSimrs = $('#BatasPencarianSimrs').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanDataDiagnosa').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Diagnosa/TabelDiagnosa.php',
        data 	    :  BatasPencarianSimrs,
        success     : function(data){
            $('#MenampilkanDataDiagnosa').html(data);
        }
    });
});
//Tambah Diagnosa
$('#ModalTambahDiagnosa').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTambahDiagnosa').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Diagnosa/FormTambahDiagnosa.php',
        success     : function(data){
            $('#FormTambahDiagnosa').html(data);
            $('#ProsesTambahDiagnosa').submit(function(){
                e.preventDefault();
                $('#NotifikasiTambahDiagnosa').html('Loading..');
                var form = $('#ProsesTambahDiagnosa')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Diagnosa/ProsesTambahDiagnosa.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahDiagnosa').html(data);
                        var NotifikasiTambahDiagnosaBerhasil=$('#NotifikasiTambahDiagnosaBerhasil').html();
                        if(NotifikasiTambahDiagnosaBerhasil=="Berhasil"){
                            $('#MenampilkanDataDiagnosa').load("_Page/Diagnosa/TabelDiagnosa.php");
                            $('#ModalTambahDiagnosa').modal("hide");
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Tambah Diagnosa Berhasil',
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
//Modal Detail Diagnosa
$('#ModalDetailDiagnosa').on('show.bs.modal', function (e) {
    //data-id
    var DataId = $(e.relatedTarget).data('id');
    //Explode
    var DataIdExplode = DataId.split(",");
    var IdDiagnosa = DataIdExplode[0];
    var keyword = DataIdExplode[1];
    var batas = DataIdExplode[2];
    var ShortBy = DataIdExplode[3];
    var OrderBy = DataIdExplode[4];
    var page = DataIdExplode[5];
    var version = DataIdExplode[6];
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailDiagnosa').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Diagnosa/DetailDiagnosa.php',
        data 	    :  {IdDiagnosa: IdDiagnosa},
        success     : function(data){
            $('#FormDetailDiagnosa').html(data);
            //Modal Edit Diagnosa
            $('#ModalEditDiagnosa').on('show.bs.modal', function (e) {
                //data-id
                var id_diagnosa = $(e.relatedTarget).data('id');
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormEditDiagnosa').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Diagnosa/FormEditDiagnosa.php',
                    data 	    :  {id_diagnosa: id_diagnosa},
                    success     : function(data){
                        $('#FormEditDiagnosa').html(data);
                        //Simpan edit diagnosa
                        $('#ProsesEditDiagnosa').submit(function(){
                            //serialize
                            var form = $('#ProsesEditDiagnosa')[0];
                            var data = new FormData(form);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Diagnosa/ProsesEditDiagnosa.php',
                                data 	    :  data,
                                cache       : false,
                                processData : false,
                                contentType : false,
                                enctype     : 'multipart/form-data',
                                success     : function(data){
                                    $('#NotifikasiEditDiagnosa').html(data);
                                    var NotifikasiEditDiagnosaBerhasil=$('#NotifikasiEditDiagnosaBerhasil').html();
                                    if(NotifikasiEditDiagnosaBerhasil=="Berhasil"){
                                        $('#MenampilkanDataDiagnosa').html('Loading...');
                                        $.ajax({
                                            url     : "_Page/Diagnosa/TabelDiagnosa.php",
                                            method  : "POST",
                                            data 	:  { page: page, batas: batas, keyword: keyword, version: version, OrderBy: OrderBy, ShortBy: ShortBy },
                                            success: function (data) {
                                                $('#MenampilkanDataDiagnosa').html(data);
                                            }
                                        })
                                        $('#ModalDetailDiagnosa').modal("hide");
                                        $('#ModalEditDiagnosa').modal("hide");
                                        Swal.fire({
                                            title: 'Good Job!',
                                            text: 'Edit Diagnosa Berhasil',
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
            //Modal Hapus Diagnosa
            $('#ModalHapusDiagnosa').on('show.bs.modal', function (e) {
                //data-id
                var id_diagnosa = $(e.relatedTarget).data('id');
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormHapusDiagnosa').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Diagnosa/FormHapusDiagnosa.php',
                    data 	    :  {id_diagnosa: id_diagnosa},
                    success     : function(data){
                        $('#FormHapusDiagnosa').html(data);
                        //Simpan edit diagnosa
                        $('#KonfirmasiHapusDiagnosa').click(function(){
                            $('#NotifikasiHapusDiagnosa').html(Loading);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Diagnosa/ProsesHapusDiagnosa.php',
                                data 	    :  {id_diagnosa: id_diagnosa},
                                success     : function(data){
                                    $('#NotifikasiHapusDiagnosa').html(data);
                                    var NotifikasiHapusDiagnosaBerhasil=$('#NotifikasiHapusDiagnosaBerhasil').html();
                                    if(NotifikasiHapusDiagnosaBerhasil=="Berhasil"){
                                        $('#MenampilkanDataDiagnosa').html('Loading...');
                                        $.ajax({
                                            url     : "_Page/Diagnosa/TabelDiagnosa.php",
                                            method  : "POST",
                                            data 	:  { page: page, batas: batas, keyword: keyword, version: version, OrderBy: OrderBy, ShortBy: ShortBy },
                                            success: function (data) {
                                                $('#MenampilkanDataDiagnosa').html(data);
                                            }
                                        })
                                        $('#ModalDetailDiagnosa').modal("hide");
                                        $('#ModalHapusDiagnosa').modal("hide");
                                        Swal.fire({
                                            title: 'Good Job!',
                                            text: 'Hapus Diagnosa Berhasil',
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
        }
    });
});
//Modal Filter Tabel
$('#ModalFilterTabel').on('show.bs.modal', function (e) {
    var ColomName = $(e.relatedTarget).data('id');
    $('#FormFilterTabel').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Diagnosa/FormFilterTabel.php',
        data 	    :  {ColomName: ColomName},
        success     : function(data){
            $('#FormFilterTabel').html(data);
            $('#ProsesFilterTabel').submit(function(){
                var batas = $('#batas').val();
                var keyword_by = $('#keyword_by').val();
                var keyword = $('#keyword_short').val();
                var ShortBy = $('#ShortBy').val();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanDataDiagnosa').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Diagnosa/TabelDiagnosa.php',
                    data 	    :  {keyword_by: keyword_by, keyword: keyword, batas: batas, ShortBy: ShortBy},
                    success     : function(data){
                        $('#MenampilkanDataDiagnosa').html(data);
                    }
                });
            });
        }
    });
});

//DIAGNOSA BPJS
//Ketika Proses Pencarian Dmulai
$('#BatasPencarianDiagnosaBpjs').submit(function(){
    var BatasPencarianDiagnosaBpjs = $('#BatasPencarianDiagnosaBpjs').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanDataBpjs').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Diagnosa/TabelDiagnosaBpjs.php',
        data 	    :  BatasPencarianDiagnosaBpjs,
        success     : function(data){
            $('#MenampilkanDataBpjs').html(data);
        }
    });
});