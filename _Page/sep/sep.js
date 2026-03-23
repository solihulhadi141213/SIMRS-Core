//Menampilkan Data SEP PErtama Kali
var ProsesPencarianSep = $('#ProsesPencarianSep').serialize();
$('#MenampilkanTabelSep').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center text-danger">Loading...</div></div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/sep/TabelSep.php',
    data 	    :  ProsesPencarianSep,
    success     : function(data){
        $('#MenampilkanTabelSep').html(data);
    }
});
//Ketika Di Proses Pencarian
$('#ProsesPencarianSep').submit(function(){
    var ProsesPencarianSep = $('#ProsesPencarianSep').serialize();
    $('#MenampilkanTabelSep').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center text-danger">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/TabelSep.php',
        data 	    :  ProsesPencarianSep,
        success     : function(data){
            $('#MenampilkanTabelSep').html(data);
        }
    });
});
//Proses Pencarian Nomor SEP
$('#ProsesPencarianNomorSep').submit(function(){
    $('#ModalPencarianNomorSep').modal('show');
    var KeywordNomorSep = $('#KeywordNomorSep').val();
    $('#FormPencarianNomorSep').html('<div class="row"><div class="col-md-12 text-center text-dark">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/FormDetailSep.php',
        data 	    :  {sep: KeywordNomorSep},
        success     : function(data){
            $('#FormPencarianNomorSep').html(data);
        }
    });
});
//Menampilkan Pencarian Pasien Untuk Dibuatkan SEP
$('#ModalBuatSep').on('show.bs.modal', function (e) {
    $('#FormPilihPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/ListPasien.php',
        success     : function(data){
            $('#FormPilihPasien').html(data);
            $('#PencarianPasien').submit(function(){
                var PencarianPasien = $('#PencarianPasien').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormPilihPasien').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/sep/ListPasien.php',
                    data 	    :  PencarianPasien,
                    success     : function(data){
                        $('#FormPilihPasien').html(data);
                    }
                });
            });
        }
    });
});
//Modal Pilih Kunjungan
$('#ModalPilihKunjungan').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#ListKunjungan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/ListKunjungan.php',
        data        : {id_pasien: id_pasien},
        success     : function(data){
            $('#ListKunjungan').html(data);
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
//Modal Pencarian Rujukan
$('#ModalCariRujukan').on('show.bs.modal', function (e) {
    var no_bpjs=$('#no_bpjs').val();
    var noRujukan=$('#noRujukan').val();
    //Memasukan parameter pada form
    $('#PutNoRujukan').val(noRujukan);
    $('#PutNoKartu').val(no_bpjs);
    if(noRujukan!==""){
        $("#DasarPencarianRujukan1").prop("checked", true);
        $("#DasarPencarianRujukan2").prop("checked", false);
        $("#PutNoRujukan").prop("readonly", false);
        $("#PutNoKartu").prop("readonly", true);
    }else{
        if(no_bpjs!==""){
            $("#DasarPencarianRujukan1").prop("checked", false);
            $("#DasarPencarianRujukan2").prop("checked", true);
            $("#PutNoRujukan").prop("readonly", true);
            $("#PutNoKartu").prop("readonly", false);
        }else{
            $("#DasarPencarianRujukan1").prop("checked", false);
            $("#DasarPencarianRujukan2").prop("checked", false);
            $("#PutNoRujukan").prop("readonly", true);
            $("#PutNoKartu").prop("readonly", true);
        }
    }
});
//Event ketika dipilih pencarian berdasarkan nomoir rujukan
$("input[name='DasarPencarianRujukan']").change(function() {
    var selectedValue = $("input[name='DasarPencarianRujukan']:checked").val();
    if(selectedValue=="no_rujukan"){
        $("#PutNoRujukan").prop("readonly", false);
        $("#PutNoKartu").prop("readonly", true);
    }
    if(selectedValue=="no_kartu"){
        $("#PutNoRujukan").prop("readonly", true);
        $("#PutNoKartu").prop("readonly", false);
    }
});
//Event Ketika Informasi Laka Lantas Diubah
$("input[name='lakaLantas']").change(function() {
    var selectedValue = $("input[name='lakaLantas']:checked").val();
    if(selectedValue=="0"){
        $("#noLP").prop("disabled", true);
        $("#tglKejadian").prop("disabled", true);
        $("#keterangan").prop("disabled", true);
        $("input[name='suplesi']").prop("disabled", true);
        $("#noSepSuplesi").prop("disabled", true);
        $("#kdPropinsi").prop("disabled", true);
        $("#kdKabupaten").prop("disabled", true);
        $("#kdKecamatan").prop("disabled", true);
    }
    if(selectedValue!=="0"){
        $("#noLP").prop("disabled", false);
        $("#tglKejadian").prop("disabled", false);
        $("#keterangan").prop("disabled", false);
        $("input[name='suplesi']").prop("disabled", false);
        $("#noSepSuplesi").prop("disabled", false);
        $("#kdPropinsi").prop("disabled", false);
        $("#kdKabupaten").prop("disabled", false);
        $("#kdKecamatan").prop("disabled", false);
    }
});
//Modal Pencarian Rujukan
$('#ModalPencarianPpkPerujuk').on('show.bs.modal', function (e) {
    var rujukan_dari=$('#rujukan_dari').val();
    //Memasukan parameter pada form
    $('#KeywordPencarianPpk').val(rujukan_dari);
    //Melakukan Proses Pencarian Pertama Kali
    var ProsesPencarianPpkPerujuk=$('#ProsesPencarianPpkPerujuk').serialize();
    $('#HasilPencarianPpkPerujuk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/ProsesPencarianPpkPerujuk.php',
        data 	    :  ProsesPencarianPpkPerujuk,
        success     : function(data){
            $('#HasilPencarianPpkPerujuk').html(data);
        }
    });
});
//Proses Pencarian PPK Perujuk
$('#ProsesPencarianPpkPerujuk').submit(function(){
    var ProsesPencarianPpkPerujuk=$('#ProsesPencarianPpkPerujuk').serialize();
    $('#HasilPencarianPpkPerujuk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/ProsesPencarianPpkPerujuk.php',
        data 	    :  ProsesPencarianPpkPerujuk,
        success     : function(data){
            $('#HasilPencarianPpkPerujuk').html(data);
        }
    });
});
//Proses Pencarian Rujukan
$('#ProsesPencarianRujukan').submit(function(){
    var ProsesPencarianRujukan = $('#ProsesPencarianRujukan').serialize();
    var Loading='<a href="javascript:void(0);" class="list-group-item list-group-item-action">Loading...</a>';
    $('#HasilPencarianRujukan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/ProsesPencarianRujukan.php',
        data 	    :  ProsesPencarianRujukan,
        success     : function(data){
            $('#HasilPencarianRujukan').html(data);
        }
    });
});
//Ketika modal pencarian SKDP dan SPRI
$('#ModalPencarianSpriSkdp').on('show.bs.modal', function (e) {
    var noSurat=$('#noSurat').val();
    var no_bpjs=$('#no_bpjs').val();
    //Memasukan parameter pada form pencarian pada modal
    $('#KeywordByNomorSuratKontrol').val(noSurat);
    $('#KeywordByNomorKartuBpjs').val(no_bpjs);
});
//Ketika Mode Pencarian SKDP SPRI Berubah
$("input[name='ModePencarianSpriSkdp']").change(function() {
    var selectedValue = $("input[name='ModePencarianSpriSkdp']:checked").val();
    if(selectedValue=="nomor_surat_kontrol"){
        $("#KeywordByNomorSuratKontrol").prop("disabled", false);
        $("#KeywordByNomorKartuBpjs").prop("disabled", true);
        $("#TanggalPencarianSpriSkdp").prop("disabled", true);
    }
    if(selectedValue=="nomor_kartu_bpjs"){
        $("#KeywordByNomorSuratKontrol").prop("disabled", true);
        $("#KeywordByNomorKartuBpjs").prop("disabled", false);
        $("#TanggalPencarianSpriSkdp").prop("disabled", false);
    }
});
//Proses Pencarian SKDP SPRI
$('#ProsesPencarianSpriSkdp').submit(function(){
    var ProsesPencarianSpriSkdp = $('#ProsesPencarianSpriSkdp').serialize();
    var Loading='<div class="list-group-item list-group-item-action">Loading...</div>';
    $('#HasilPencarianSpriSkdp').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/ProsesPencarianSpriSkdp.php',
        data 	    :  ProsesPencarianSpriSkdp,
        success     : function(data){
            $('#HasilPencarianSpriSkdp').html(data);
        }
    });
});
//Modal Pencarian Diagnosa
$('#ModalCariDiagnosa').on('show.bs.modal', function (e) {
    var diagAwal=$('#diagAwal').val();
    //Memasukan parameter pada form
    $('#KeywordDiagnosa').val(diagAwal);
});
//Proses Pencarian Diagnosa
$('#ProsesCariDiagnosa').submit(function(){
    var ProsesCariDiagnosa = $('#ProsesCariDiagnosa').serialize();
    var Loading='<div class="list-group-item list-group-item-action">Loading...</div>';
    $('#HasilPencarianDiagnosa').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/ProsesCariDiagnosa.php',
        data 	    :  ProsesCariDiagnosa,
        success     : function(data){
            $('#HasilPencarianDiagnosa').html(data);
        }
    });
});
//Ketika Kelas Rawat Naik Diubah
$("#klsRawatNaik").change(function() {
    var klsRawatNaik = $("#klsRawatNaik").val();
    if(klsRawatNaik==""){
        $("#pembiayaan").prop("disabled", true);
        $("#penanggungJawab").prop("disabled", true);
    }
    if(klsRawatNaik!==""){
        $("#pembiayaan").prop("disabled", false);
        $("#penanggungJawab").prop("disabled", false);
    }
});
//Kondisi Awal
var tujuanKunj=$("#tujuanKunj").val();
if(tujuanKunj=="0"){
    $("#flagProcedure").prop("disabled", true);
    $("#kdPenunjang").prop("disabled", true);
    //Add Value
    $("#flagProcedure").val("0");
    $("#kdPenunjang").val("0");
}else{
    $("#flagProcedure").prop("disabled", false);
    $("#kdPenunjang").prop("disabled", false);
}
//Ketika Tujuan Kunjungan Diubah
$("#tujuanKunj").change(function() {
    var tujuanKunj=$("#tujuanKunj").val();
    if(tujuanKunj=="0"){
        $("#flagProcedure").prop("disabled", true);
        $("#kdPenunjang").prop("disabled", true);
        //Add Value
        $("#flagProcedure").val("0");
        $("#kdPenunjang").val("0");
    }else{
        $("#flagProcedure").prop("disabled", false);
        $("#kdPenunjang").prop("disabled", false);
    }
});
//Ketika jnsPelayanan Diubah
$("#jnsPelayanan").change(function() {
    var jnsPelayanan=$("#jnsPelayanan").val();
    if(jnsPelayanan=="1"){
        $("#dpjpLayan").prop("disabled", true);
    }else{
        $("#dpjpLayan").prop("disabled", false);
    }
});
//Proses Buat SEP
$('#ProsesBuatSep').submit(function(){
    var ProsesBuatSep = $('#ProsesBuatSep').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiBuatSep').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/ProsesBuatSep.php',
        data 	    :  ProsesBuatSep,
        success     : function(data){
            $('#NotifikasiBuatSep').html(data);
            var NotifikasiBuatSepBerhasil=$('#NotifikasiBuatSepBerhasil').html();
            var UrlBackBuatSep=$('#UrlBackBuatSep').html();
            var UrlBackBuatSep=UrlBackBuatSep.replace(/&amp;/g, '&');
            if(NotifikasiBuatSepBerhasil=="Success"){
                window.location.replace(UrlBackBuatSep);
            }
        }
    });
});
//Modal Edit Sep
$('#ModalEditSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    var GetUrlBackDetailSep=$('#GetUrlBackDetailSep').val();
    $('#FormEditSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/KonfirmasiEditSep.php',
        data        : {sep: sep, GetUrlBackDetailSep: GetUrlBackDetailSep},
        success     : function(data){
            $('#FormEditSep').html(data);
        }
    });
});
//Modal Cetak Sep
$('#ModalCetakSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#noSepCetak').val(sep);
});
//Modal Hapus Sep
$('#ModalHapusSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    var GetUrlBackDetailSep=$('#GetUrlBackDetailSep').val();
    $('#FormHapusSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/FormHapusSep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormHapusSep').html(data);
            $('#KonfirmasiHapusSep').click(function(){
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#NotifikasiHapusSep').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/sep/ProsesHapusSep.php',
                    data        : {sep: sep},
                    success     : function(data){
                        $('#NotifikasiHapusSep').html(data);
                        var NotifikasiHapusSepBerhasil=$('#NotifikasiHapusSepBerhasil').html();
                        if(NotifikasiHapusSepBerhasil=="Success"){
                            window.location.replace(GetUrlBackDetailSep);
                        }
                    }
                });
            });
        }
    });
});
//DETAIL SEP
// Ketika Menampilkan Detail Kunjungan
$('#ModalDetailKunjungan').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#DetailKunjunganRajal').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#DetailKunjunganRajal').html(data);
        }
    });
});
// Ketika Menampilkan Detail Pasien
$('#ModalDetailPasien').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#DetailPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailPasien.php',
        data        : {id_pasien: id_pasien},
        success     : function(data){
            $('#DetailPasien').html(data);
        }
    });
});
//SUBPAGE SEP
//Ketika Menampilkan Sub Page SEP Internal
$('#MenampilkanSepInternal').click(function(){
    var sep = $('#GetValueSep').html();
    var Loading='<p><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></p>';
    $('#SubPageSepInternal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/SubPageSepInternal.php',
        data 	    :  {sep: sep},
        success     : function(data){
            $('#SubPageSepInternal').html(data);
        }
    });
});
//Ketika Menampilkan Sub Page Lembar Pengajuan Klaim
$('#MenampilkanLembarPengajuanKlaim').click(function(){
    var InfoLpk = $('#InputLembarPengajuanKlaim').val();
    var pecah = InfoLpk.split(",");
    var KodeJenisPelayanan = pecah[0];
    var RealTglSep = pecah[1];
    var sep = pecah[2];
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/SubPageLembarPengajuanKlaim.php',
        data 	    :  {KodeJenisPelayanan: KodeJenisPelayanan, RealTglSep: RealTglSep, sep: sep},
        success     : function(data){
            $('#SubPageLembarPengajuanKlaim').html(data);
        }
    });
});
//Ketika Menampilkan Sub Page Fingerprint
$('#MenampilkanFingerprint').click(function(){
    var GetDataFingerprint = $('#GetDataFingerprint').val();
    var pecah = GetDataFingerprint.split(",");
    var TanggalPelayanan = pecah[0];
    var noKartuPeserta = pecah[1];
    var Loading='<p><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></p>';
    $('#SubPageFingerprint').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/SubPageFingerprint.php',
        data 	    :  {TanggalPelayanan: TanggalPelayanan, noKartuPeserta: noKartuPeserta},
        success     : function(data){
            $('#SubPageFingerprint').html(data);
        }
    });
});