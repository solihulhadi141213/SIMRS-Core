//Menampilkan Data Medication Pertama Kali
var FilterMedication = $('#FilterMedication').serialize();
var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
$('#MenampilkanTabelMedication').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Medication/TabelMedication.php',
    data 	    :  FilterMedication,
    success     : function(data){
        $('#MenampilkanTabelMedication').html(data);
    }
});
//Batas dan Pencarian
$('#FilterMedication').submit(function(){
    var FilterMedication = $('#FilterMedication').serialize();
    var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
    $('#MenampilkanTabelMedication').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/TabelMedication.php',
        data 	    :  FilterMedication,
        success     : function(data){
            $('#MenampilkanTabelMedication').html(data);
            $('#ModalFilter').modal('hide');
        }
    });
});
//Batas dan Pencarian
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Ketika Modal Pilih Obat Muncul
$('#ModalPilihObat').on('show.bs.modal', function (e) {
    var ProsesCariObat = $('#ProsesCariObat').serialize();
    $('#TabelPilihObat').load('<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/TabelPilihObat.php',
        data 	    :  ProsesCariObat,
        success     : function(data){
            $('#TabelPilihObat').html(data);
        }
    });
});
$('#ProsesCariObat').submit(function(){
    var ProsesCariObat = $('#ProsesCariObat').serialize();
    $('#TabelPilihObat').load('<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/TabelPilihObat.php',
        data 	    :  ProsesCariObat,
        success     : function(data){
            $('#TabelPilihObat').html(data);
        }
    });
});
//Ketika Modal Pilih Obat Muncul
$('#ModalPilihObat2').on('show.bs.modal', function (e) {
    var ProsesCariObat2 = $('#ProsesCariObat2').serialize();
    $('#TabelPilihObat2').load('<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/TabelPilihObat2.php',
        data 	    :  ProsesCariObat2,
        success     : function(data){
            $('#TabelPilihObat2').html(data);
        }
    });
});
$('#ProsesCariObat2').submit(function(){
    var ProsesCariObat2 = $('#ProsesCariObat2').serialize();
    $('#TabelPilihObat2').load('<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/TabelPilihObat2.php',
        data 	    :  ProsesCariObat2,
        success     : function(data){
            $('#TabelPilihObat2').html(data);
        }
    });
});
//Modal Pencarian Kfa
$('#ModalPencarianKfa').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    $('#PutIdObat').val(id_obat);
    var form = $('#ProsesPencarianKfa')[0];
    var data = new FormData(form);
    $('#HasilPencarianKfa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/HasilPencarianKfa.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#HasilPencarianKfa').html(data);
        }
    });
});
//Proses Pencarian KFA
$('#ProsesPencarianKfa').submit(function(){
    var form = $('#ProsesPencarianKfa')[0];
    var data = new FormData(form);
    $('#HasilPencarianKfa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/HasilPencarianKfa.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#HasilPencarianKfa').html(data);
        }
    });
});
//Modal Pencarian Kfa
$('#ModalPencarianKfa2').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    $('#PutIdObat2').val(id_obat);
    var form = $('#ProsesPencarianKfa2')[0];
    var data = new FormData(form);
    $('#HasilPencarianKfa2').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/HasilPencarianKfa2.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#HasilPencarianKfa2').html(data);
        }
    });
});
//Proses Pencarian KFA
$('#ProsesPencarianKfa2').submit(function(){
    var form = $('#ProsesPencarianKfa2')[0];
    var data = new FormData(form);
    $('#HasilPencarianKfa2').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/HasilPencarianKfa2.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#HasilPencarianKfa2').html(data);
        }
    });
});
//Kondisi Ketika 
$('#extension_type').change(function(){
    var extension_type=$('#extension_type').val();
    if(extension_type=="NC"){
        $('#extension_url').val('https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType');
        $('#extension_system').val('http://terminology.kemkes.go.id/CodeSystem/medication-type');
        $('#extension_code').val(extension_type);
        $('#extension_display').val('Non-compound');
    }else{
        if(extension_type=="SD"){
            $('#extension_url').val('https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType');
            $('#extension_system').val('http://terminology.kemkes.go.id/CodeSystem/medication-type');
            $('#extension_code').val(extension_type);
            $('#extension_display').val('Non-Gives of such doses');
        }else{
            if(extension_type=="EP"){
                $('#extension_url').val('https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType');
                $('#extension_system').val('http://terminology.kemkes.go.id/CodeSystem/medication-type');
                $('#extension_code').val(extension_type);
                $('#extension_display').val('Divide into equal parts');
            }else{
                $('#extension_url').val('');
                $('#extension_system').val('');
                $('#extension_code').val('');
                $('#extension_display').val('');
            }
        }
    }
});
//Kondisi ketika modal pencarian organization
$('#ModalCariOrganization').on('show.bs.modal', function (e) {
    var ProsesPencarianOrganization = $('#ProsesPencarianOrganization').serialize();
    $('#HasilPencarianOrganization').html('<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/TabelOrganization.php',
        data 	    :  ProsesPencarianOrganization,
        success     : function(data){
            $('#HasilPencarianOrganization').html(data);
        }
    });
});
$('#ProsesPencarianOrganization').submit(function(){
    var ProsesPencarianOrganization = $('#ProsesPencarianOrganization').serialize();
    $('#HasilPencarianOrganization').html('<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/TabelOrganization.php',
        data 	    :  ProsesPencarianOrganization,
        success     : function(data){
            $('#HasilPencarianOrganization').html(data);
        }
    });
});
//menangkap nama manufacture
var ManufacturerForm=$('#ManufacturerForm').html();
$('#keyword_organization').val(ManufacturerForm);

//Modal POencarian Medication Form
$('#ModalCariMedicationForm').on('show.bs.modal', function (e) {
    var ProsesPencarianMedicationForm = $('#ProsesPencarianMedicationForm').serialize();
    $('#HasilPencarianMedicationForm').html('<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/TabelMedicationForm.php',
        data 	    :  ProsesPencarianMedicationForm,
        success     : function(data){
            $('#HasilPencarianMedicationForm').html(data);
        }
    });
});
//Ketika Kode KFA diketik pada form ingridient
$('#PutitemCodeableConcept').keyup(function(){
    var PutitemCodeableConcept = $('#PutitemCodeableConcept').val();
    $('#DataListKfa').html('<option value="Loading">');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/DataListKfa.php',
        data 	    :  {keyword: PutitemCodeableConcept},
        success     : function(data){
            $('#DataListKfa').html(data);
        }
    });
});
//Ketika Satuan Di Ketik
$('#PutNumeratorCode').keyup(function(){
    var PutNumeratorCode = $('#PutNumeratorCode').val();
    $('#ListUcum').html('<option value="Loading">');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/ListUcum.php',
        data 	    :  {keyword: PutNumeratorCode},
        success     : function(data){
            $('#ListUcum').html(data);
        }
    });
});
$('#PutDenominatorCode').keyup(function(){
    var PutDenominatorCode = $('#PutDenominatorCode').val();
    $('#ListDrugForm').html('<option value="Loading">');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/ListDrugForm.php',
        data 	    :  {keyword: PutDenominatorCode},
        success     : function(data){
            $('#ListDrugForm').html(data);
        }
    });
});
$('#PutNumeratorCode').dblclick(function(){
    var PutNumeratorCode = $('#PutNumeratorCode').val();
    $('#ListUcum').html('<option value="Loading">');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/ListUcum.php',
        data 	    :  {keyword: PutNumeratorCode},
        success     : function(data){
            $('#ListUcum').html(data);
        }
    });
});
$('#PutDenominatorCode').dblclick(function(){
    var PutDenominatorCode = $('#PutDenominatorCode').val();
    $('#ListDrugForm').html('<option value="Loading">');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/ListDrugForm.php',
        data 	    :  {keyword: PutDenominatorCode},
        success     : function(data){
            $('#ListDrugForm').html(data);
        }
    });
});
//Menambahkan Ingridient
var no =1;
//Multi Form Kontak Dokter
$('#ProsesTambahIngridient').submit(function(){
    var ProsesTambahIngridient=$('#ProsesTambahIngridient').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/ProsesTambahIngridient.php',
        data 	    :  ProsesTambahIngridient,
        success     : function(data){
            no++;
            $('#FormMultiIngredient').append(data);
            $('#ProsesTambahIngridient')[0].reset();
            $('#ModalTambahIngredient').modal('hide');
        }
    });
});
$(document).on('click', '.HapusFormIngridient', function(){
    var button_id = $(this).attr("id"); 
    $('#BarisIngridient'+button_id+'').remove();
});
//Modal Detail Ingridient
$('#ModalDetailIngridient').on('show.bs.modal', function (e) {
    var kfa_code = $(e.relatedTarget).data('id');
    $('#FormDetailIngridient').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/FormDetailIngridient.php',
        data 	    :  {kfa_code: kfa_code},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormDetailIngridient').html(data);
        }
    });
});
//Proses Tambah Medication
$('#ProsesTambahMedication').submit(function(){
    var kode_obat=$('#GetKodeObat').html();
    var ProsesTambahMedication=$('#ProsesTambahMedication').serialize();
    $('#NotifikasiTambahMedication').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/ProsesTambahMedication.php',
        data 	    :  ProsesTambahMedication,
        success     : function(data){
            $('#NotifikasiTambahMedication').html(data);
            var NotifikasiTambahMedicationBerhasil=$('#NotifikasiTambahMedicationBerhasil').html();
            if(NotifikasiTambahMedicationBerhasil=="Success"){
                location.href = 'index.php?Page=Medication&Sub=DetailMedication&kode='+kode_obat+'';
            }
        }
    });
});
//Modal Detail Medication
$('#ModalDetailMedicationLocal').on('show.bs.modal', function (e) {
    var id_obat_medication = $(e.relatedTarget).data('id');
    $('#FormDetailMedicationLocal').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/FormDetailMedicationLocal.php',
        data 	    :  {id_obat_medication: id_obat_medication},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormDetailMedicationLocal').html(data);
        }
    });
});
//Modal Detail Medication Satu Sehat
$('#ModalDetailMedicationSatuSehat').on('show.bs.modal', function (e) {
    var id_medication = $(e.relatedTarget).data('id');
    $('#FormDetailMedicationSatuSehat').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/FormDetailMedicationSatuSehat.php',
        data 	    :  {id_medication: id_medication},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormDetailMedicationSatuSehat').html(data);
        }
    });
});
//Modal Edit Medication
$('#ModalEditMedication').on('show.bs.modal', function (e) {
    var id_obat_medication = $(e.relatedTarget).data('id');
    $('#FormEditMedication').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/FormEditMedication.php',
        data 	    :  {id_obat_medication: id_obat_medication},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormEditMedication').html(data);
        }
    });
});
$('.HapusBarisIngridient').click(function(){
    var IdRow = $(this).attr('value');
    $('#BarisIngridient'+IdRow+'').remove();
});
//Proses Edit Medication
$('#ProsesEditMedication').submit(function(){
    var kode=$('#kode').val();
    var ProsesEditMedication=$('#ProsesEditMedication').serialize();
    $('#NotifikasiEditMedication').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Medication/ProsesEditMedication.php',
        data 	    :  ProsesEditMedication,
        success     : function(data){
            $('#NotifikasiEditMedication').html(data);
            var NotifikasiEditMedicationBerhasil=$('#NotifikasiEditMedicationBerhasil').html();
            if(NotifikasiEditMedicationBerhasil=="Success"){
                location.href = 'index.php?Page=Medication&Sub=DetailMedication&kode='+kode+'';
            }
        }
    });
});