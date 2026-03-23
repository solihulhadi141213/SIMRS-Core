//Modal Detail ID Organisasi
$('#ModalTambahOrganisasi').on('show.bs.modal', function (e) {
    var ID_Org = $(e.relatedTarget).data('id');
    $('#part_of_ID').val(ID_Org);
});
$('input[type="radio"][name="ID_Org"]').change(function(){
    // Mendapatkan nilai radio button yang dipilih
    var selectedOption = $('input[type="radio"][name="ID_Org"]:checked').val();
    if(selectedOption=="Tidak"){
        $('#id_organization').removeAttr('readonly');
    }else{
        $('#id_organization').attr('readonly', true);
    }
});
//Proses Tambah Organisasi
$('#ProsesTambahOrganisasi').submit(function(){
    $('#NotifikasiTambahOrganisasi').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahOrganisasi')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/ProsesTambahOrganisasi.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahOrganisasi').html(data);
            var NotifikasiTambahOrganisasiBerhasil=$('#NotifikasiTambahOrganisasiBerhasil').html();
            if(NotifikasiTambahOrganisasiBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Edit Organisasi
$('#ModalEditOrganisasi').on('show.bs.modal', function (e) {
    var id_referensi_organisasi = $(e.relatedTarget).data('id');
    $('#FormEditOrganisasi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormEditOrganisasi.php',
        data 	    :  {id_referensi_organisasi: id_referensi_organisasi},
        success     : function(data){
            $('#FormEditOrganisasi').html(data);
            $('input[type="radio"][name="ID_Org2"]').change(function(){
                // Mendapatkan nilai radio button yang dipilih
                var selectedOption = $('input[type="radio"][name="ID_Org2"]:checked').val();
                if(selectedOption=="Tidak"){
                    $('#id_organization2').removeAttr('readonly');
                }else{
                    $('#id_organization2').attr('readonly', true);
                }
            });
            //Proses Edit Organisasi
            $('#ProsesEditOrganisasi').submit(function(){
                $('#NotifikasiEditOrganisasi').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesEditOrganisasi')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Referensi/ProsesEditOrganisasi.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditOrganisasi').html(data);
                        var NotifikasiEditOrganisasiBerhasil=$('#NotifikasiEditOrganisasiBerhasil').html();
                        if(NotifikasiEditOrganisasiBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Hapus Organisasi
$('#ModalHapusOrganisasi').on('show.bs.modal', function (e) {
    var id_referensi_organisasi = $(e.relatedTarget).data('id');
    $('#FormhapusOrganisasi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormhapusOrganisasi.php',
        data 	    :  {id_referensi_organisasi: id_referensi_organisasi},
        success     : function(data){
            $('#FormhapusOrganisasi').html(data);
            $('#KonfirmasiHapusOrganisasi').click(function(){
                $('#NotifikasiHapusOrganisasi').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Referensi/ProsesHapusOrganisasi.php',
                    data 	    :  { id_referensi_organisasi: id_referensi_organisasi },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusOrganisasi').html(data);
                        var NotifikasiHapusOrganisasiBerhasil=$('#NotifikasiHapusOrganisasiBerhasil').html();
                        if(NotifikasiHapusOrganisasiBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Proses Pencarian Organisasi
$('#ProsewsCariOrganisasiSatuSehat').submit(function(){
    $('#HasilPencarianOrganisasi').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsewsCariOrganisasiSatuSehat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/ProsewsCariOrganisasiSatuSehat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#HasilPencarianOrganisasi').html(data);
        }
    });
});
//Modal Detail ID Organisasi
$('#ModalDetailOrgId').on('show.bs.modal', function (e) {
    var ID_Org = $(e.relatedTarget).data('id');
    $('#FormDetailOrgId').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormDetailOrgId.php',
        data 	    :  {ID_Org: ID_Org},
        success     : function(data){
            $('#FormDetailOrgId').html(data);
        }
    });
});
//Modal List Sub Organisasi
$('#ModalDetailOrganisasiSimrs').on('show.bs.modal', function (e) {
    var id_referensi_organisasi = $(e.relatedTarget).data('id');
    $('#FormDetailOrganisasiSimrs').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormDetailOrganisasiSimrs.php',
        data 	    :  {id_referensi_organisasi: id_referensi_organisasi},
        success     : function(data){
            $('#FormDetailOrganisasiSimrs').html(data);
        }
    });
});
//Ketika Form Data Di Click
$('#SubOrganisasiDariSimrs').click(function(){
    $('#HasilPencarianOrganisasi').html('Loading...');
    var data_form="SIMRS";
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormListSubOrganization.php',
        data 	    :  {ID_Org: ID_Org, data_form: data_form},
        success     : function(data){
            $('#FormListSubOrganization').html(data);
        }
    });
});
$('#SubOrganisasiDariSatuSehat').click(function(){
    $('#HasilPencarianOrganisasi').html('Loading...');
    var data_form="Satu Sehat";
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormListSubOrganization.php',
        data 	    :  {ID_Org: ID_Org, data_form: data_form},
        success     : function(data){
            $('#FormListSubOrganization').html(data);
        }
    });
});

//LOCATION
//Proses Tambah Location
$('#ProsesTambahLocation').submit(function(){
    $('#NotifikasiTambahLocation').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahLocation')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/ProsesTambahLocation.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahLocation').html(data);
            var NotifikasiTambahLocationBerhasil=$('#NotifikasiTambahLocationBerhasil').html();
            if(NotifikasiTambahLocationBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Proses Pencarian Location
$('#ProsesCariLocation').submit(function(){
    $('#HasilPencarianLocation').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesCariLocation')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/ProsesCariLocation.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#HasilPencarianLocation').html(data);
        }
    });
});
//Modal Detail ID Location
$('#ModalDetailLocationSatuSehat').on('show.bs.modal', function (e) {
    var id_location = $(e.relatedTarget).data('id');
    $('#FormDetailLocationSatuSehat').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormDetailLocationSatuSehat.php',
        data 	    :  {id_location: id_location},
        success     : function(data){
            $('#FormDetailLocationSatuSehat').html(data);
        }
    });
});
//Modal Detail ID Location SIMRS
$('#ModalDetailLocationSimrs').on('show.bs.modal', function (e) {
    var id_referensi_location = $(e.relatedTarget).data('id');
    $('#FormDetailLocationSimrs').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormDetailLocationSimrs.php',
        data 	    :  {id_referensi_location: id_referensi_location},
        success     : function(data){
            $('#FormDetailLocationSimrs').html(data);
        }
    });
});
//Modal Edit Location
$('#ModalEditLocation').on('show.bs.modal', function (e) {
    var id_referensi_location = $(e.relatedTarget).data('id');
    $('#FormEditLocation').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormEditLocation.php',
        data 	    :  {id_referensi_location: id_referensi_location},
        success     : function(data){
            $('#FormEditLocation').html(data);
            //Ketika Update Satu sehat di Uncheck
            $('#UpdateLocationToSatuSehat').change(function() {
                // Jika checkbox tidak tercentang, hapus atribut readonly
                if (!$(this).prop('checked')) {
                    $('#id_location').removeAttr('readonly');
                } else {
                    // Jika checkbox tercentang, tambahkan atribut readonly
                    $('#id_location').attr('readonly', true);
                }
            });
            //Proses Edit
            $('#ProsesEditLocation').submit(function(){
                $('#NotifikasiEditLocation').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesEditLocation')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Referensi/ProsesEditLocation.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditLocation').html(data);
                        var NotifikasiEditLocationBerhasil=$('#NotifikasiEditLocationBerhasil').html();
                        if(NotifikasiEditLocationBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Hapus Location
$('#ModalHapusLocation').on('show.bs.modal', function (e) {
    var id_referensi_location = $(e.relatedTarget).data('id');
    $('#FormHapusLocation').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormHapusLocation.php',
        data 	    :  {id_referensi_location: id_referensi_location},
        success     : function(data){
            $('#FormHapusLocation').html(data);
            $('#KonfirmasiHapusLocation').click(function(){
                $('#NotifikasiHapusLocation').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Referensi/ProsesHapusLocation.php',
                    data 	    :  { id_referensi_location: id_referensi_location },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusLocation').html(data);
                        var NotifikasiHapusLocationBerhasil=$('#NotifikasiHapusLocationBerhasil').html();
                        if(NotifikasiHapusLocationBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});

//PRACTITIONER
//Menampilkan Data Practitioner Dari SIMRS
var ProsesPencarianPractitionerSimrs =$('#ProsesPencarianPractitionerSimrs').serialize();
$('#TabelPractitionerSimrs').html('Loading..');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Referensi/TabelPractitionerSimrs.php',
    data 	    :  ProsesPencarianPractitionerSimrs,
    enctype     : 'multipart/form-data',
    success     : function(data){
        $('#TabelPractitionerSimrs').html(data);
    }
});
//Proses Pencarian Data
$('#ProsesPencarianPractitionerSimrs').submit(function(){
    var ProsesPencarianPractitionerSimrs =$('#ProsesPencarianPractitionerSimrs').serialize();
    $('#TabelPractitionerSimrs').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/TabelPractitionerSimrs.php',
        data 	    :  ProsesPencarianPractitionerSimrs,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelPractitionerSimrs').html(data);
        }
    });
});
$('#batas_practitioner').change(function(){
    var ProsesPencarianPractitionerSimrs =$('#ProsesPencarianPractitionerSimrs').serialize();
    $('#TabelPractitionerSimrs').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/TabelPractitionerSimrs.php',
        data 	    :  ProsesPencarianPractitionerSimrs,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelPractitionerSimrs').html(data);
        }
    });
});
$('#keyword_by_practitioner').change(function(){
    var keyword_by_practitioner =$('#keyword_by_practitioner').val();
    $('#FormPencarianPractitionerSimrs').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormPencarianPractitionerSimrs.php',
        data 	    :  {keyword_by_practitioner: keyword_by_practitioner},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormPencarianPractitionerSimrs').html(data);
        }
    });
});
//Ketika proses Tambah Practitioner Dimulai
$('#ProsesTambahPractitioner').submit(function(){
    var ProsesTambahPractitioner =$('#ProsesTambahPractitioner').serialize();
    $('#NotifikasiTambahPractitioner').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/ProsesTambahPractitioner.php',
        data 	    :  ProsesTambahPractitioner,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahPractitioner').html(data);
            var NotifikasiTambahPractitionerBerhasil=$('#NotifikasiTambahPractitionerBerhasil').html();
            if(NotifikasiTambahPractitionerBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Ketika Mode Pencarian Dipilih
$('#kategori_pencarian_practitioner').change(function(){
    var kategori_pencarian_practitioner =$('#kategori_pencarian_practitioner').val();
    if(kategori_pencarian_practitioner==""){
        $('#FormPencarianPractitioner').html('');
        $("#TombolPractitioner").prop("disabled", true);
        $('#TombolPractitioner').removeClass('btn-primary')
        $('#TombolPractitioner').addClass('btn-secondary')
    }else{
        $('#FormPencarianPractitioner').html('Loading..');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Referensi/FormPencarianPractitioner.php',
            data 	    :  { kategori_pencarian_practitioner: kategori_pencarian_practitioner },
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#FormPencarianPractitioner').html(data);
                $("#TombolPractitioner").prop("disabled", false);
                $('#TombolPractitioner').removeClass('btn-secondary')
                $('#TombolPractitioner').addClass('btn-primary')
            }
        });
    }
});
//Ketika Proses Pencarian Dimulai
$('#ModalPencarianPractitionerSatuSehat').on('show.bs.modal', function (e) {
    $('#FormHasilPencarianPractitionerSatuSehat').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesPencarianPractitioner')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/ProsesPencarianPractitioner.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormHasilPencarianPractitionerSatuSehat').html(data);
        }
    });
});
//Modal Detail Practitioner By Id
$('#ModalDetailPractitionerById').on('show.bs.modal', function (e) {
    var id_practitioner = $(e.relatedTarget).data('id');
    var kategori_pencarian_practitioner="id_practitioner";
    $('#FormDetailPractitionerSatuSehat').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/ProsesPencarianPractitioner.php',
        data 	    :  {kategori_pencarian_practitioner: kategori_pencarian_practitioner, id_practitioner: id_practitioner},
        success     : function(data){
            $('#FormDetailPractitionerSatuSehat').html(data);
        }
    });
});
//Modal Detail Practitioner By Nik
$('#ModalDetailPractitionerByNik').on('show.bs.modal', function (e) {
    var nik = $(e.relatedTarget).data('id');
    var kategori_pencarian_practitioner="NIK";
    $('#FormDetailPractitionerSatuSehatNik').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/ProsesPencarianPractitioner.php',
        data 	    :  {kategori_pencarian_practitioner: kategori_pencarian_practitioner, nik: nik},
        success     : function(data){
            $('#FormDetailPractitionerSatuSehatNik').html(data);
        }
    });
});
//Modal Edit Practitioner
$('#ModalEditPractitioner').on('show.bs.modal', function (e) {
    var id_practitioner = $(e.relatedTarget).data('id');
    $('#FormEditPractitioner').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormEditPractitioner.php',
        data 	    :  {id_practitioner: id_practitioner},
        success     : function(data){
            $('#FormEditPractitioner').html(data);
            //Proses Edit Practitioner
            $('#ProsesEditPractitioner').submit(function(){
                var ProsesEditPractitioner =$('#ProsesEditPractitioner').serialize();
                $('#NotifikasiEditPractitioner').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Referensi/ProsesEditPractitioner.php',
                    data 	    :  ProsesEditPractitioner,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditPractitioner').html(data);
                        var NotifikasiEditPractitionerBerhasil=$('#NotifikasiEditPractitionerBerhasil').html();
                        if(NotifikasiEditPractitionerBerhasil=="Success"){
                            //tutup Modal
                            $('#ModalEditPractitioner').modal('hide');
                            var ProsesPencarianPractitionerSimrs =$('#ProsesPencarianPractitionerSimrs').serialize();
                            $('#TabelPractitionerSimrs').html('Loading..');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Referensi/TabelPractitionerSimrs.php',
                                data 	    :  ProsesPencarianPractitionerSimrs,
                                enctype     : 'multipart/form-data',
                                success     : function(data){
                                    $('#TabelPractitionerSimrs').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Practitioner Berhasil',
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
//Modal Hapus Practitioner
$('#ModalHapusPractitioner').on('show.bs.modal', function (e) {
    var id_practitioner = $(e.relatedTarget).data('id');
    $('#FormHapusPractitioner').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormHapusPractitioner.php',
        data 	    :  {id_practitioner: id_practitioner},
        success     : function(data){
            $('#FormHapusPractitioner').html(data);
            //Proses Edit Practitioner
            $('#KonfirmasiHapusPractitioner').click(function(){
                $('#NotifikasiHapusPractitioner').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Referensi/ProsesHapusPractitioner.php',
                    data 	    :  {id_practitioner: id_practitioner},
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusPractitioner').html(data);
                        var NotifikasiHapusPractitionerBerhasil=$('#NotifikasiHapusPractitionerBerhasil').html();
                        if(NotifikasiHapusPractitionerBerhasil=="Success"){
                            //tutup Modal
                            $('#ModalHapusPractitioner').modal('hide');
                            var ProsesPencarianPractitionerSimrs =$('#ProsesPencarianPractitionerSimrs').serialize();
                            $('#TabelPractitionerSimrs').html('Loading..');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Referensi/TabelPractitionerSimrs.php',
                                data 	    :  ProsesPencarianPractitionerSimrs,
                                enctype     : 'multipart/form-data',
                                success     : function(data){
                                    $('#TabelPractitionerSimrs').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Practitioner Berhasil',
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
//LOINC
var BatasPencarianLoinc=$('#BatasPencarianLoinc').serialize();
$('#TabelLoinc').html('Loading..');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Referensi/TabelLoinc.php',
    data 	    :  BatasPencarianLoinc,
    enctype     : 'multipart/form-data',
    success     : function(data){
        $('#TabelLoinc').html(data);
    }
});
//Pencarian
$('#BatasPencarianLoinc').submit(function(){
    var BatasPencarianLoinc=$('#BatasPencarianLoinc').serialize();
    $('#TabelLoinc').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/TabelLoinc.php',
        data 	    :  BatasPencarianLoinc,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelLoinc').html(data);
        }
    });
});
//Detail Loinc
$('#ModalDetailLoinc').on('show.bs.modal', function (e) {
    var loinc_num = $(e.relatedTarget).data('id');
    $('#FormDetailLoinc').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormDetailLoinc.php',
        data 	    :  {loinc_num: loinc_num},
        success     : function(data){
            $('#FormDetailLoinc').html(data);
        }
    });
});

//SNOMED
//Inisiasi
var BatasPencarianSnomed=$('#BatasPencarianSnomed').serialize();
$('#TabelSnomed').html('Loading..');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Referensi/TabelSnomed.php',
    data 	    :  BatasPencarianSnomed,
    enctype     : 'multipart/form-data',
    success     : function(data){
        $('#TabelSnomed').html(data);
    }
});
//Pencarian
$('#BatasPencarianSnomed').submit(function(){
    var BatasPencarianSnomed=$('#BatasPencarianSnomed').serialize();
    $('#TabelSnomed').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/TabelSnomed.php',
        data 	    :  BatasPencarianSnomed,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelSnomed').html(data);
        }
    });
});
//Detail Snomed
$('#ModalDetailSnomed').on('show.bs.modal', function (e) {
    var conceptId = $(e.relatedTarget).data('id');
    $('#FormDetailSnomed').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormDetailSnomed.php',
        data 	    :  {conceptId: conceptId},
        success     : function(data){
            $('#FormDetailSnomed').html(data);
        }
    });
});