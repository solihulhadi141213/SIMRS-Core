$('#MenampilkanTabelRajal').load("_Page/RawatJalan/TabelRawatJalan.php");
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelRajal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/TabelRawatJalan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelRajal').html(data);
        }
    });
});
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelRajal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/TabelRawatJalan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelRajal').html(data);
            $('#ModalFilterKunjungan').modal('hide');
        }
    });
});
//Modal Detail Info Kunjungan
$('#ModalDetailInfoKunjungan').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormDetailInfoKunjungan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailInfoKunjungan.php',
        data        : {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormDetailInfoKunjungan').html(data);
        }
    });
});
//Modal Tambah Rajal
$('#ModalTambahRajal').on('show.bs.modal', function (e) {
    $('#FormPilihPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormPilihPasien.php',
        success     : function(data){
            $('#FormPilihPasien').html(data);
            $('#PencarianPasien').submit(function(){
                var PencarianPasien = $('#PencarianPasien').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormPilihPasien').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormPilihPasien.php',
                    data 	    :  PencarianPasien,
                    success     : function(data){
                        $('#FormPilihPasien').html(data);
                    }
                });
            });
        }
    });
});
//Modal Pilih Pasien
$('#ModalPilihPasien').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/KonfirmasiPilihPasien.php',
        data        : {id_pasien: id_pasien},
        success     : function(data){
            $('#KonfirmasiPilihPasien').html(data);
        }
    });
});
//Modal Detail Pasien
$('#ModalDetailPasien').on('show.bs.modal', function (e) {
    var id_pasien = $('#id_pasien').val();
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
//Modal Detail Pasien2
$('#ModalDetailPasien2').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#DetailPasien2').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailPasien.php',
        data        : {id_pasien: id_pasien},
        success     : function(data){
            $('#DetailPasien2').html(data);
        }
    });
});
//Modal Detail IHS
$('#ModalDetailIhs').on('show.bs.modal', function (e) {
    var id_ihs = $(e.relatedTarget).data('id');
    $('#FormDetailIhs').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailIhs.php',
        data        : {id_ihs: id_ihs},
        success     : function(data){
            $('#FormDetailIhs').html(data);
        }
    });
});
$('#ModalStatusKepesertaanNik').on('show.bs.modal', function (e) {
    var nik = $('#nik').val();
    $('#StatusKepesertaanNik').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/StatusKepesertaanNik.php',
        data        : {nik: nik},
        success     : function(data){
            $('#StatusKepesertaanNik').html(data);
        }
    });
});
$('#ModalDetailNik').on('show.bs.modal', function (e) {
    var nik = $(e.relatedTarget).data('id');
    var DasarPencarianPasienSatuSehat="NIK";
    var DasarPencarianPasienBpjs="NIK";
    $('#FormDetailNik').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormDetailNik.php',
        data 	    :  {nik: nik},
        success     : function(data){
            $('#FormDetailNik').html(data);
            $('#FormDetailNikByIhs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
                data 	    :  {DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat, nik_pasien: nik},
                success     : function(data){
                    $('#FormDetailNikByIhs').html(data);
                }
            });
            $('#FormDetailNikByBpjs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
                data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: nik},
                success     : function(data){
                    $('#FormDetailNikByBpjs').html(data);
                }
            });
        }
    });
});
$('#ModalDetailNik2').on('show.bs.modal', function (e) {
    var nik = $('#nik').val();
    var DasarPencarianPasienSatuSehat="NIK";
    var DasarPencarianPasienBpjs="NIK";
    $('#FormDetailNik2').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormDetailNik.php',
        data 	    :  {nik: nik},
        success     : function(data){
            $('#FormDetailNik2').html(data);
            $('#FormDetailNikByIhs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
                data 	    :  {DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat, nik_pasien: nik},
                success     : function(data){
                    $('#FormDetailNikByIhs').html(data);
                }
            });
            $('#FormDetailNikByBpjs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
                data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: nik},
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
$('#ModalStatusKepesertaanBPJS').on('show.bs.modal', function (e) {
    var no_bpjs = $('#no_bpjs').val();
    $('#StatusKepesertaanBPJS').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/StatusKepesertaanBPJS.php',
        data        : {no_bpjs: no_bpjs},
        success     : function(data){
            $('#StatusKepesertaanBPJS').html(data);
        }
    });
});
$('#ModalDetailBpjs2').on('show.bs.modal', function (e) {
    var no_bpjs = $('#no_bpjs').val();
    var DasarPencarianPasienBpjs="Noka";
    $('#FormDetailBPJS2').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
        data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: no_bpjs},
        success     : function(data){
            $('#FormDetailBPJS2').html(data);
        }
    });
});
//ModalCariSEP
$('#ModalCariSEP').on('show.bs.modal', function (e) {
    var NoSep = $('#NoSep').val();
    var no_bpjs = $('#no_bpjs').val();
    $('#FormCariSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/CariSEP.php',
        data        : {NoSep: NoSep, no_bpjs: no_bpjs},
        success     : function(data){
            $('#FormCariSep').html(data);
        }
    });
});
//ModalCariDiagnosa
$('#ModalCariDiagnosa').on('show.bs.modal', function (e) {
    $('#FormCariDiagnosa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariDiagnosa.php',
        success     : function(data){
            $('#FormCariDiagnosa').html(data);
            $('#PencarianDiagnosa').submit(function(){
                var PencarianDiagnosa = $('#PencarianDiagnosa').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormCariDiagnosa').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormCariDiagnosa.php',
                    data 	    :  PencarianDiagnosa,
                    success     : function(data){
                        $('#FormCariDiagnosa').html(data);
                    }
                });
            });
        }
    });
});
//Konfirmasi Pilih Diagnosa
$('#ModalKonfirmasiDiagnosa').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihDiagnosa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/KonfirmasiPilihDiagnosa.php',
        data        : {kode: kode},
        success     : function(data){
            $('#KonfirmasiPilihDiagnosa').html(data);
            $('#KonfirmasiYaDiagnosa').click(function(){
                $('#ModalKonfirmasiDiagnosa').modal('toggle');
                $('#ModalCariDiagnosa').modal('toggle');
                $('#DiagAwal').val(kode);
            });
        }
    });
});
//Modal Cari Antrian
$('#ModalCariAntrian').on('show.bs.modal', function (e) {
    var id_pasien = $('#id_pasien').val();
    $('#FormCariAntrian').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariAntrian.php',
        data        : {id_pasien: id_pasien},
        success     : function(data){
            $('#FormCariAntrian').html(data);
            $('#ProsesPilihIdAntrian').submit(function(){
                var ProsesPilihIdAntrian = $('#ProsesPilihIdAntrian').serialize();
                $('#NotifikasiPilihIdAntrian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesPilihIdAntrian.php',
                    data        : ProsesPilihIdAntrian,
                    success     : function(data){
                        $('#NotifikasiPilihIdAntrian').html(data);
                        var GetIdAntrian = $('#GetIdAntrian').val();
                        var GetNomorAntrian = $('#GetNomorAntrian').val();
                        var NotifikasiPilihAntrianBerhasil = $('#NotifikasiPilihAntrianBerhasil').html();
                        if(NotifikasiPilihAntrianBerhasil=="Pilih Antrian Berhasil"){
                            $('#id_antrian').val(GetIdAntrian);
                            $('#no_antrian').val(GetNomorAntrian);
                            $('#ModalCariAntrian').modal('hide');
                        }
                    }
                });
            });
        }
    });
});
$('#ModalCekIdAntrian').on('show.bs.modal', function (e) {
    var id_antrian = $('#id_antrian').val();
    $('#FormDetailAntrian').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormDetailAntrian.php',
        data        : {id_antrian: id_antrian},
        success     : function(data){
            $('#FormDetailAntrian').html(data);
        }
    });
});
//Modal Cari SEP
$('#ModalCariSep').on('show.bs.modal', function (e) {
    var no_bpjs = $('#no_bpjs').val();
    $('#KeywordNomorKartu').val(no_bpjs);
    $('#MulaiCariSep').click(function(){
        var KeywordNomorKartu = $('#KeywordNomorKartu').val();
        var TanggalAwalPencarianSep = $('#TanggalAwalPencarianSep').val();
        var TanggalAkhirPencarianSep = $('#TanggalAkhirPencarianSep').val();
        $('#FormHasilPencarianSep').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormCariSep.php',
            data 	    :  {KeywordNomorKartu: KeywordNomorKartu, TanggalAwalPencarianSep: TanggalAwalPencarianSep, TanggalAkhirPencarianSep: TanggalAkhirPencarianSep},
            success     : function(data){
                $('#FormHasilPencarianSep').html(data);
                $('#ProsesPilihSep').submit(function(){
                    var ProsesPilihSep = $('#ProsesPilihSep').serialize();
                    $('#NotifikasiTambahkanSepKeForm').html('Loading...');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ProsesPilihSep.php',
                        data        : ProsesPilihSep,
                        success     : function(data){
                            $('#NotifikasiTambahkanSepKeForm').html(data);
                            var GetNoSep = $('#GetNoSep').val();
                            var GetNoRujukan = $('#GetNoRujukan').val();
                            var NotifikasiTambahkanSepKeFormBerhasil = $('#NotifikasiTambahkanSepKeFormBerhasil').html();
                            if(NotifikasiTambahkanSepKeFormBerhasil=="Success"){
                                $('#sep').val(GetNoSep);
                                $('#noRujukan').val(GetNoRujukan);
                                $('#ModalCariSep').modal('hide');
                            }
                        }
                    });
                });
            }
        });
    });
});
$('#ModalCekNomorSep').on('show.bs.modal', function (e) {
    var sep = $('#sep').val();
    $('#FormCekSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCekSep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormCekSep').html(data);
        }
    });
});
//Modal Cari Rujukan
$('#ModalCariRujukan').on('show.bs.modal', function (e) {
    var no_bpjs = $('#no_bpjs').val();
    $('#KeywordNomorKartu2').val(no_bpjs);
    $('#MulaiCariRujukan').click(function(){
        var KeywordNomorKartu = $('#KeywordNomorKartu2').val();
        var SumberRujukan1 = $('#SumberRujukan1').val();
        var SumberRujukan2 = $('#SumberRujukan2').val();
        $('#FormHasilPencarianRujukan').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormHasilPencarianRujukan.php',
            data 	    :  {KeywordNomorKartu: KeywordNomorKartu, SumberRujukan1: SumberRujukan1, SumberRujukan2: SumberRujukan2},
            success     : function(data){
                $('#FormHasilPencarianRujukan').html(data);
                $('#ProsesPilihRujukan').submit(function(){
                    var ProsesPilihRujukan = $('#ProsesPilihRujukan').serialize();
                    $('#NotifikasiTambahkanRujukanKeForm').html('Loading...');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ProsesPilihRujukan.php',
                        data        : ProsesPilihRujukan,
                        success     : function(data){
                            $('#NotifikasiTambahkanRujukanKeForm').html(data);
                            var GetNoRujukan = $('#GetNoRujukan').val();
                            var PpkRujukan = $('#PpkRujukan').val();
                            var NotifikasiTambahkanRujukanKeFormBerhasil = $('#NotifikasiTambahkanRujukanKeFormBerhasil').html();
                            if(NotifikasiTambahkanRujukanKeFormBerhasil=="Success"){
                                $('#rujukan_dari').val(PpkRujukan);
                                $('#noRujukan').val(GetNoRujukan);
                                $('#ModalCariRujukan').modal('hide');
                            }
                        }
                    });
                });
            }
        });
    });
});
//Detail Rujukan
$('#ModalDetailRujukanMasukByRujukan').on('show.bs.modal', function (e) {
    var no_rujukan = $(e.relatedTarget).data('id');
    //Menulis Nilai Rujukan Ke Form
    $('#FormNomorRujukanByRujukan').val(no_rujukan);
    //Ketika Proses Pencarian Detail Rujukan Dilakukan
    $('#ProsesCariDetailRujukanByRujukan').submit(function(){
        var ProsesCariDetailRujukanByRujukan = $('#ProsesCariDetailRujukanByRujukan').serialize();
        $('#FormDetailRujukanMasukByRujukan').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/ProsesDetailRujukanMasukByRujukan.php',
            data 	    :  ProsesCariDetailRujukanByRujukan,
            success     : function(data){
                $('#FormDetailRujukanMasukByRujukan').html(data);
            }
        });
    });
});
$('#ModalDetailRujukanPendaftaranKunjungan').on('show.bs.modal', function (e) {
    var no_rujukan = $('#noRujukan').val();
    $('#DetailRujukanPendaftaranKunjungan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailRujukanPendaftaranKunjungan.php',
        data 	    :  {no_rujukan: no_rujukan},
        success     : function(data){
            $('#DetailRujukanPendaftaranKunjungan').html(data);
        }
    });
});
//ModalPPKAsal
$('#ModalPPKAsal').on('show.bs.modal', function (e) {
    $('#FormCariPPKAsal').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariPPKAsal.php',
        success     : function(data){
            $('#FormCariPPKAsal').html(data);
            $('#PencarianPPKAsal').submit(function(){
                var PencarianPPKAsal = $('#PencarianPPKAsal').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormCariPPKAsal').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormCariPPKAsal.php',
                    data 	    :  PencarianPPKAsal,
                    success     : function(data){
                        $('#FormCariPPKAsal').html(data);
                        //Konfirmasi
                        $('#ModalKonfirmasiPPK').on('show.bs.modal', function (e) {
                            var kode = $(e.relatedTarget).data('id');
                            $('#KonfirmasiPilihPPK').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/KonfirmasiPilihPPK.php',
                                data        : {kode: kode},
                                success     : function(data){
                                    $('#KonfirmasiPilihPPK').html(data);
                                    $('#KonfirmasiYaPPK').click(function(){
                                        $('#ModalPPKAsal').modal('toggle');
                                        $('#ModalKonfirmasiPPK').modal('toggle');
                                        $('#rujukan_dari').val(kode);
                                    });
                                }
                            });
                        });
                    }
                });
            });
        }
    });
});
//ModalPPKTujuan
$('#ModalPPKTujuan').on('show.bs.modal', function (e) {
    $('#FormCariPPKTujuan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariPPKTujuan.php',
        success     : function(data){
            $('#FormCariPPKTujuan').html(data);
            $('#PencarianPPKTujuan').submit(function(){
                var PencarianPPKTujuan = $('#PencarianPPKTujuan').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormCariPPKTujuan').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormCariPPKTujuan.php',
                    data 	    :  PencarianPPKTujuan,
                    success     : function(data){
                        $('#FormCariPPKTujuan').html(data);
                        //Konfirmasi
                        $('#ModalKonfirmasiPPK').on('show.bs.modal', function (e) {
                            var kode = $(e.relatedTarget).data('id');
                            $('#KonfirmasiPilihPPK').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/KonfirmasiPilihPPK.php',
                                data        : {kode: kode},
                                success     : function(data){
                                    $('#KonfirmasiPilihPPK').html(data);
                                    $('#KonfirmasiYaPPK').click(function(){
                                        $('#ModalPPKTujuan').modal('toggle');
                                        $('#ModalKonfirmasiPPK').modal('toggle');
                                        $('#rujukan_ke').val(kode);
                                    });
                                }
                            });
                        });
                    }
                });
            });
        }
    });
});
//Pencarian SPRI/SKDP Berdasarkan Nomor Kartu
$('#ModalCariSpriSkdpPendaftaranKunjungan').on('show.bs.modal', function (e) {
    var nomor_kartu=$('#no_bpjs').val();
    //Put Ke Form
    $('#PutNomorKartu').val(nomor_kartu);
    //Ketika mulai melakukan proses pencarian
    $('#ProsesPencarianSpriSkdpKunjungan').submit(function(){
        var ProsesPencarianSpriSkdpKunjungan = $('#ProsesPencarianSpriSkdpKunjungan').serialize();
        $('#FormCariSpriSkdpPendaftaranKunjungan').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/ProsesPencarianSpriSkdpKunjungan.php',
            data 	    :  ProsesPencarianSpriSkdpKunjungan,
            success     : function(data){
                $('#FormCariSpriSkdpPendaftaranKunjungan').html(data);
            }
        });
    });
});
//Detail SKDP/SPRI Pendaftaran Kunjungan
$('#ModalCekSkdpPendaftaranKunjungan').on('show.bs.modal', function (e) {
    var skdp=$('#skdp').val();
    $('#DetailSpriSkdpKunjungan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailSuratKontrolBySuratKontrol.php',
        data 	    :  {skdp: skdp},
        success     : function(data){
            $('#DetailSpriSkdpKunjungan').html(data);
        }
    });
});
//Detail SKDP/SPRI Detail Kunjungan
$('#ModalDetailSpriSkdp').on('show.bs.modal', function (e) {
    var skdp = $(e.relatedTarget).data('id');
    $('#DetailSpriSkdp').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailSuratKontrolBySuratKontrol.php',
        data 	    :  {skdp: skdp},
        success     : function(data){
            $('#DetailSpriSkdp').html(data);
        }
    });
});
//Menyimpan data kunjungan rajal
$('#ProsesTambahKunjungan').submit(function(){
    var ProsesTambahKunjungan = $('#ProsesTambahKunjungan').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiTambahKunjunganRajal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTambahKunjungan.php',
        data 	    :  ProsesTambahKunjungan,
        success     : function(data){
            $('#NotifikasiTambahKunjunganRajal').html(data);
            var NotifikasiKunjunganBerhasil=$('#NotifikasiKunjunganBerhasil').html();
            var NotifikasiUrlBack=$('#NotifikasiUrlBack').html();
            var URLBack=NotifikasiUrlBack.replace(/&amp;/g, '&');
            if(NotifikasiKunjunganBerhasil=="Success"){
                window.location.replace(URLBack);
            }
        }
    });
});
//Edit Kunjungan
$('#ModalEditKunjungan').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#KonfirmasiEditKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/KonfirmasiEditKunjungan.php',
        data        :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#KonfirmasiEditKunjungan').html(data);
        }
    });
});
//ProsesSimpanKunjungan
$('#ProsesEditKunjungan').submit(function(){
    var ProsesEditKunjungan = $('#ProsesEditKunjungan').serialize();
    $('#NotifikasiEditKunjunganRajal').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesEditKunjungan.php',
        data 	    :  ProsesEditKunjungan,
        success     : function(data){
            $('#NotifikasiEditKunjunganRajal').html(data);
            var NotifikasiEditKunjunganRajalBerhasil=$('#NotifikasiEditKunjunganRajalBerhasil').html();
            var NotifikasiUrlBack=$('#NotifikasiUrlBack').html();
            var URLBack=NotifikasiUrlBack.replace(/&amp;/g, '&');
            if(NotifikasiEditKunjunganRajalBerhasil=="Success"){
                window.location.replace(URLBack);
            }
        }
    });
});
//Modal Detail Pasien
$('#ModalDetailKunjungan').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var posisi = pecah[6];
    var keyword_by = pecah[7];
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#DetailKunjunganRajal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#DetailKunjunganRajal').html(data);
        }
    });
    //Hapus Kunjungan
    $('#ModalHapusKunjungan').on('show.bs.modal', function (e) {
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        $('#HapusKunjungan').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormHapusKunjungan.php',
            data        :  {id_kunjungan: id_kunjungan},
            success     : function(data){
                $('#HapusKunjungan').html(data);
                //Konfirmasi Hapus Data Kunjungan
                $('#KonfirmasiHapusKunjungan').click(function(){
                    $('#NotifikasiHapusKunjungan').html('Loading...');
                    $.ajax({
                        url     : "_Page/RawatJalan/ProsesHapusKunjungan.php",
                        method  : "POST",
                        data    :  {id_kunjungan: id_kunjungan},
                        success : function (data) {
                            $('#NotifikasiHapusKunjungan').html(data);
                            //Notifikasi Proses Hapus
                            var NotifikasiHapusKunjunganberhasil=$('#NotifikasiHapusKunjunganberhasil').html();
                            if(NotifikasiHapusKunjunganberhasil=="Berhasil"){
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/TabelRawatJalan.php',
                                    data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by},
                                    success     : function(data){
                                        $('#MenampilkanTabelRajal').html(data);
                                        $('#ModalHapusKunjungan').modal('toggle');
                                        $('#ModalDetailKunjungan').modal('toggle');
                                        Swal.fire({
                                            title: 'Good Job!',
                                            text: 'Hapus Data Kunjungan Berhasil',
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
   
    //Buat Sep
    $('#ModalBuatSEP').on('show.bs.modal', function (e) {
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        $('#KonfirmasiBuatSep').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/KonfirmasiBuatSep.php',
            data        :  {id_kunjungan: id_kunjungan},
            success     : function(data){
                $('#KonfirmasiBuatSep').html(data);
            }
        });
    });
    //Pengajuan Approval
    $('#ModalPengajuanApproval').on('show.bs.modal', function (e) {
        var no_bpjs = $(e.relatedTarget).data('id');
        $('#FormPengajuanApproval').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormPengajuanApproval.php',
            data        : {no_bpjs: no_bpjs},
            success     : function(data){
                $('#FormPengajuanApproval').html(data);
                $('#ProsesInputApproval').submit(function(){
                    var ProsesInputApproval = $('#ProsesInputApproval').serialize();
                    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                    $('#NotifikasiPengajuanApproval').html(Loading);
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ProsesInputApproval.php',
                        data 	    :  ProsesInputApproval,
                        success     : function(data){
                            $('#NotifikasiPengajuanApproval').html(data);
                            var NotifikasiPengajuanApprovalBerhasil=$('#NotifikasiPengajuanApprovalBerhasil').html();
                            if(NotifikasiPengajuanApprovalBerhasil=="Berhasil"){
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/DetailKunjunganRajal.php',
                                    data 	    :  {id_kunjungan: id_kunjungan},
                                    success     : function(data){
                                        $('#DetailKunjunganRajal').html(data);
                                        $('#ModalPengajuanApproval').modal('toggle');
                                    }
                                });
                                $('#DataPengajuanApproval').html("Loading...");
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/DataPengajuanApproval.php',
                                    data        : {no_bpjs: no_bpjs},
                                    success     : function(data){
                                        $('#DataPengajuanApproval').html(data);
                                    }
                                });
                            }
                        }
                    });
                });
            }
        });
    });
    //Data Pengajuan Approval
    $('#ModalDataApproval').on('show.bs.modal', function (e) {
        var no_bpjs = $(e.relatedTarget).data('id');
        $('#DataPengajuanApproval').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/DataPengajuanApproval.php',
            data        : {no_bpjs: no_bpjs},
            success     : function(data){
                $('#DataPengajuanApproval').html(data);
            }
        });
        //Hapus Approval
        $('#ModalHapusApproval').on('show.bs.modal', function (e) {
            var id_approval = $(e.relatedTarget).data('id');
            $('#FormHapusApproval').html("Loading...");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/FormHapusApproval.php',
                data        : {id_approval: id_approval},
                success     : function(data){
                    $('#FormHapusApproval').html(data);
                    $('#KonfirmasiHapusApproval').click(function(){
                        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                        $('#NotifikasiHapusApproval').html(Loading);
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/RawatJalan/ProsesHapusApproval.php',
                            data        : {id_approval: id_approval},
                            success     : function(data){
                                $('#NotifikasiHapusApproval').html(data);
                                var NotifikasiHapusApprovalBerhasil=$('#NotifikasiHapusApprovalBerhasil').html();
                                if(NotifikasiHapusApprovalBerhasil=="Berhasil"){
                                    $.ajax({
                                        type 	    : 'POST',
                                        url 	    : '_Page/RawatJalan/DataPengajuanApproval.php',
                                        data        : {no_bpjs: no_bpjs},
                                        success     : function(data){
                                            $('#DataPengajuanApproval').html(data);
                                            $('#ModalHapusApproval').modal('toggle');
                                        }
                                    });
                                }
                            }
                        });
                    });
                }
            });
        });
        //ModalApprove
        $('#ModalApprove').on('show.bs.modal', function (e) {
            var id_approval = $(e.relatedTarget).data('id');
            $('#FormKonfirmasiApproval').html("Loading...");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/FormApprove.php',
                data        : {id_approval: id_approval},
                success     : function(data){
                    $('#FormKonfirmasiApproval').html(data);
                    $('#KonfirmasiApprove').click(function(){
                        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                        $('#NotifikasiApprove').html(Loading);
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/RawatJalan/ProsesApprove.php',
                            data        : {id_approval: id_approval},
                            success     : function(data){
                                $('#NotifikasiApprove').html(data);
                                var NotifikasiApproveBerhasil=$('#NotifikasiApproveBerhasil').html();
                                if(NotifikasiApproveBerhasil=="Berhasil"){
                                    $.ajax({
                                        type 	    : 'POST',
                                        url 	    : '_Page/RawatJalan/DataPengajuanApproval.php',
                                        data        : {no_bpjs: no_bpjs},
                                        success     : function(data){
                                            $('#DataPengajuanApproval').html(data);
                                            $('#ModalApprove').modal('toggle');
                                        }
                                    });
                                }
                            }
                        });
                    });
                }
            });
        });
    });
    //Modal Update Status Pulang
    $('#ModalUpdateTanggalPulang').on('show.bs.modal', function (e) {
        var sep = $(e.relatedTarget).data('id');
        $('#FormUpdateTanggalPulang').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormUpdateTanggalPulang.php',
            data        : {sep: sep},
            success     : function(data){
                $('#FormUpdateTanggalPulang').html(data);
                //Proses Update Status Pulang
                $('#ProsesUpdateStatusPulang').submit(function(){
                    var ProsesUpdateStatusPulang = $('#ProsesUpdateStatusPulang').serialize();
                    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                    $('#NotifikasiUpdateStatusPulang').html(Loading);
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ProsesUpdateStatusPulang.php',
                        data 	    :  ProsesUpdateStatusPulang,
                        success     : function(data){
                            $('#NotifikasiUpdateStatusPulang').html(data);
                            var NotifikasiUpdateStatusPulangBerhasil=$('#NotifikasiUpdateStatusPulangBerhasil').html();
                            if(NotifikasiUpdateStatusPulangBerhasil=="Berhasil"){
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/TabelRawatJalan.php',
                                    data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by},
                                    success     : function(data){
                                        $('#MenampilkanTabelRajal').html(data);
                                        $('#ModalUpdateTanggalPulang').modal('toggle');
                                        $('#ModalDetailKunjungan').modal('toggle');
                                        Swal.fire({
                                            title: 'Good Job!',
                                            text: 'Update Status Pulang Berhasil',
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
    //Modal Rencana Kontrol
    $('#ModalInsertRencanaKontrol').on('show.bs.modal', function (e) {
        var sep = $(e.relatedTarget).data('id');
        $('#FormRencanaKontrol').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormRencanaKontrol.php',
            data        : {sep: sep},
            success     : function(data){
                $('#FormRencanaKontrol').html(data);
                //Proses Kirim dan Simpan Data rencana Kontrol
                $('#ProsesInsertRencanaKontrol').submit(function(){
                    var ProsesInsertRencanaKontrol = $('#ProsesInsertRencanaKontrol').serialize();
                    $('#NotifikasiInsertRencanaKontrol').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ProsesInsertRencanaKontrol.php',
                        data 	    :  ProsesInsertRencanaKontrol,
                        success     : function(data){
                            $('#NotifikasiInsertRencanaKontrol').html(data);
                            var ProsesInsertRencanaKontrolBerhasil=$('#ProsesInsertRencanaKontrolBerhasil').html();
                            if(ProsesInsertRencanaKontrolBerhasil=="Berhasil"){
                                $('#FormRencanaKontrol').html(data);
                            }
                        }
                    });
                });
            }
        });
    });
    //Modal SPRI
    $('#ModalInsertSpri').on('show.bs.modal', function (e) {
        var noKartu = $(e.relatedTarget).data('id');
        $('#FormInsertSpri').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormInsertSpri.php',
            data        : {noKartu: noKartu},
            success     : function(data){
                $('#FormInsertSpri').html(data);
                //Proses Kirim dan Simpan Data rencana Kontrol
                $('#ProsesInsertSpri').submit(function(){
                    var ProsesInsertSpri = $('#ProsesInsertSpri').serialize();
                    $('#NotifikasiInsertSpri').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ProsesInsertSpri.php',
                        data 	    :  ProsesInsertSpri,
                        success     : function(data){
                            $('#NotifikasiInsertSpri').html(data);
                            var NotifikasiInsertSpriBerhasil=$('#NotifikasiInsertSpriBerhasil').html();
                            if(NotifikasiInsertSpriBerhasil=="Berhasil"){
                                $('#FormInsertSpri').html(data);
                            }
                        }
                    });
                });
            }
        });
    });
    //Modal Cari SPRI
    $('#ModalCariSPRI').on('show.bs.modal', function (e) {
        var sep = $(e.relatedTarget).data('id');
        $('#FormCariSPRI').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormCariSPRI.php',
            data        : {sep: sep, id_kunjungan: id_kunjungan},
            success     : function(data){
                $('#FormCariSPRI').html(data);
                //Proses Pencarian
                $('#ProsesPencarianSpri').submit(function(){
                    var ProsesPencarianSpri = $('#ProsesPencarianSpri').serialize();
                    $('#HasilPencarianSpri').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ProsesPencarianSpri.php',
                        data 	    :  ProsesPencarianSpri,
                        success     : function(data){
                            $('#HasilPencarianSpri').html(data);
                        }
                    });
                });
            }
        });
    });
});
//Menyimpan data kunjungan rajal
$('#ProsesEditKunjungan').submit(function(){
    var ProsesEditKunjungan = $('#ProsesEditKunjungan').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiEditKunjunganRajal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesEditKunjungan.php',
        data 	    :  ProsesEditKunjungan,
        success     : function(data){
            $('#NotifikasiEditKunjunganRajal').html(data);
            var NotifikasiEditKunjunganRajalBerhasil=$('#NotifikasiEditKunjunganRajalBerhasil').html();
            if(NotifikasiEditKunjunganRajalBerhasil=="Berhasil"){
                window.location.replace("index.php?Page=RawatJalan");
            }
        }
    });
});
$('#ProsesBuatSep').submit(function(){
    var ProsesBuatSep = $('#ProsesBuatSep').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiBuatSep').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesBuatSep.php',
        data 	    :  ProsesBuatSep,
        success     : function(data){
            $('#NotifikasiBuatSep').html(data);
            var ProsesBuatSepBerhasil=$('#ProsesBuatSepBerhasil').html();
            if(ProsesBuatSepBerhasil=="Berhasil"){
                window.location.replace("index.php?Page=RawatJalan");
            }
        }
    });
});
$('#ModalCekKepesertaanByNik').on('show.bs.modal', function (e) {
    var nik = $(e.relatedTarget).data('id');
    $('#CekKepesertaanByNik').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/StatusKepesertaanNik.php',
        data        : {nik: nik},
        success     : function(data){
            $('#CekKepesertaanByNik').html(data);
        }
    });
});
$('#ModalCekKepesertaanByBpjs').on('show.bs.modal', function (e) {
    var no_bpjs = $(e.relatedTarget).data('id');
    $('#CekKepesertaanByBpjs').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/StatusKepesertaanBPJS.php',
        data        : {no_bpjs: no_bpjs},
        success     : function(data){
            $('#CekKepesertaanByBpjs').html(data);
            //Ketika tombol cek kepesertaan di click
            $('#ProsesCekFingerprint').click(function(){
                var NomorKartuPeserta = $('#NomorKartuPeserta').html();
                $('#HasilCekFingerprint').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/HasilCekFingerprint.php',
                    data 	    :  {NomorKartuPeserta: NomorKartuPeserta},
                    success     : function(data){
                        $('#HasilCekFingerprint').html(data);
                    }
                });
            });
        }
    });
});
$('#ModalDetailSepBySep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#FormDetailSepBySep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailSepBySep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormDetailSepBySep').html(data);
        }
    });
});
$('#ModalDetailSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#DetailSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailSep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#DetailSep').html(data);
        }
    });
});
$('#ModalEditSEP').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#FormEditSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditSep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormEditSep').html(data);
        }
    });
});
$('#ProsesEditSep').submit(function(){
    var ProsesEditSep = $('#ProsesEditSep').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiEditSep').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesEditSep.php',
        data 	    :  ProsesEditSep,
        success     : function(data){
            $('#NotifikasiEditSep').html(data);
            var ProsesEditSepBerhasil=$('#ProsesEditSepBerhasil').html();
            if(ProsesEditSepBerhasil=="Berhasil"){
                window.location.replace("index.php?Page=RawatJalan");
            }
        }
    });
});
$('#ModalHapusSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#FormHapusSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusSep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormHapusSep').html(data);
            $('#KonfirmasiHapusSep').click(function(){
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#NotifikasiHapusSep').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesHapusSep.php',
                    data        : {sep: sep},
                    success     : function(data){
                        $('#NotifikasiHapusSep').html(data);
                        var ProsesHapusSepBerhasil=$('#ProsesHapusSepBerhasil').html();
                        if(ProsesHapusSepBerhasil=="Berhasil"){
                            window.location.replace("index.php?Page=RawatJalan");
                        }
                    }
                });
            });
        }
    });
});
$('#ModalDataSepInternal').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#FormCariSepInternal').html("Loading...123");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariSepInternal.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormCariSepInternal').html(data);
        }
    });
});
$('#ModalHapusSepInternal').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#FormHapusSeInterna').html("Loading...123");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusSeInterna.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormHapusSeInterna').html(data);
            //Proses Hapus SEP Internal
            $('#ProsesHapusSepInternal').submit(function(){
                var ProsesHapusSepInternal = $('#ProsesHapusSepInternal').serialize();
                $('#NotifikasiHapusSep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesHapusSepInternal.php',
                    data 	    :  ProsesHapusSepInternal,
                    success     : function(data){
                        $('#NotifikasiHapusSep').html(data);
                        var ProsesHapusSepInternalBerhasil=$('#ProsesHapusSepInternalBerhasil').html();
                    }
                });
            });
        }
    });
});
$('#ModalCariDataSuplesi').on('show.bs.modal', function (e) {
    var noKartu = $(e.relatedTarget).data('id');
    $('#FormCariSuplesi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariSuplesi.php',
        data        : {noKartu: noKartu},
        success     : function(data){
            $('#FormCariSuplesi').html(data);
            //Proses pencarian
            $('#ProsesPencarianSupplesi').submit(function(){
                var ProsesPencarianSupplesi = $('#ProsesPencarianSupplesi').serialize();
                $('#HasilPencarianSuplesi').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesPencarianSupplesi.php',
                    data 	    :  ProsesPencarianSupplesi,
                    success     : function(data){
                        $('#HasilPencarianSuplesi').html(data);
                    }
                });
            });
        }
    });
    $('#CariDataSupplesi').click(function(){
        $('#FormCariSuplesi').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormCariSuplesi.php',
            data        : {noKartu: noKartu},
            success     : function(data){
                $('#FormCariSuplesi').html(data);
                $('#CariDataSupplesi').addClass('btn-inverse');
                $('#CariDataSupplesi').removeClass('btn-primary');
                $('#CariDataIndukKecelakaan').addClass('btn-primary');
                $('#CariDataIndukKecelakaan').removeClass('btn-inverse');
                //Proses pencarian
                $('#ProsesPencarianSupplesi').submit(function(){
                    var ProsesPencarianSupplesi = $('#ProsesPencarianSupplesi').serialize();
                    $('#HasilPencarianSuplesi').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ProsesPencarianSupplesi.php',
                        data 	    :  ProsesPencarianSupplesi,
                        success     : function(data){
                            $('#HasilPencarianSuplesi').html(data);
                        }
                    });
                });
            }
        });
    });
    $('#CariDataIndukKecelakaan').click(function(){
        $('#FormCariSuplesi').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormCariDataInduk.php',
            data        : {noKartu: noKartu},
            success     : function(data){
                $('#FormCariSuplesi').html(data);
                $('#CariDataSupplesi').addClass('btn-primary');
                $('#CariDataSupplesi').removeClass('btn-inverse');
                $('#CariDataIndukKecelakaan').addClass('btn-inverse');
                $('#CariDataIndukKecelakaan').removeClass('btn-primary');
            }
        });
    });
});
//Pencarian kode propinsi
$('#ModalCariPropinsi').on('show.bs.modal', function (e) {
    $('#FormCariPropinsi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariPropinsi.php',
        success     : function(data){
            $('#FormCariPropinsi').html(data);
        }
    });
});
$('#ModalAmbilPropinsi').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihPropinsi').html("Loading...");
    $('#KonfirmasiPilihPropinsi').html("Apakah anda yakin memilih propinsi Ini?");
    $('#KonfirmasiPilihPropinsiYa').click(function(){
        $('#kdPropinsi').val(kode);
        $('#ModalCariPropinsi').modal('hide');
        $('#ModalAmbilPropinsi').modal('hide');
    });
});
$('#ModdalCariKabupaten').on('show.bs.modal', function (e) {
    var kdPropinsi =$('#kdPropinsi').val();
    $('#FormCariKabupaten').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariKabupaten.php',
        data        :{kdPropinsi: kdPropinsi},
        success     : function(data){
            $('#FormCariKabupaten').html(data);
        }
    });
});
$('#ModalAmbilKabupaten').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihKabupaten').html("Loading...");
    $('#KonfirmasiPilihKabupaten').html("Apakah anda yakin memilih kabupaten Ini?");
    $('#KonfirmasiPilihKabupatenYa').click(function(){
        $('#kdKabupaten').val(kode);
        $('#ModdalCariKabupaten').modal('hide');
        $('#ModalAmbilKabupaten').modal('hide');
    });
});
$('#ModalcariKecamatan').on('show.bs.modal', function (e) {
    var kdKabupaten =$('#kdKabupaten').val();
    $('#FormCariKecamatan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariKecamatan.php',
        data        :{kdKabupaten: kdKabupaten},
        success     : function(data){
            $('#FormCariKecamatan').html(data);
        }
    });
});
$('#ModalAmbilKecamatan').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihKecamatan').html("Loading...");
    $('#KonfirmasiPilihKecamatan').html("Apakah anda yakin memilih Kecamatan Ini?");
    $('#KonfirmasiPilihKecamatanYa').click(function(){
        $('#kdKecamatan').val(kode);
        $('#ModalcariKecamatan').modal('hide');
        $('#ModalAmbilKecamatan').modal('hide');
    });
});
$('#ProsesPencarianEncounter').submit(function(){
    var ProsesPencarianEncounter = $('#ProsesPencarianEncounter').serialize();
    $('#FormHasilPencarianEncounter').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHasilPencarianEncounter.php',
        data        :ProsesPencarianEncounter,
        success     : function(data){
            $('#FormHasilPencarianEncounter').html(data);
        }
    });
});
$('#ModalCariEncounter').on('show.bs.modal', function (e) {
    var id_pasien = $('#id_pasien').val();
    $('#FormHasilCariEncounter').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHasilCariEncounter2.php',
        data        :{id_pasien: id_pasien},
        success     : function(data){
            $('#FormHasilCariEncounter').html(data);
        }
    });
});
//Form Tambah Encounter
$('#ModalTambahEncounter').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahEncounter').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahEncounter.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahEncounter').html(data);
            //Proses Tambah Encounter
            $('#ProsesTambahEncounter').submit(function(){
                var ProsesTambahEncounter = $('#ProsesTambahEncounter').serialize();
                $('#NotifikasiTambahEncounter').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesTambahEncounter.php',
                    data        :ProsesTambahEncounter,
                    success     : function(data){
                        $('#NotifikasiTambahEncounter').html(data);
                        var NotifikasiTambahEncounterBerhasil=$('#NotifikasiTambahEncounterBerhasil').html();
                        if(NotifikasiTambahEncounterBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
$('#ModalDetailEncounter').on('show.bs.modal', function (e) {
    var id_encounter = $(e.relatedTarget).data('id');
    $('#FormDetailEncounter').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailEncounter.php',
        data        :{id_encounter: id_encounter},
        success     : function(data){
            $('#FormDetailEncounter').html(data);
        }
    });
});
//Menampilkan detail encounter pada detail kunjungan
var GetIdEncounter =$('#GetIdEncounter').val();
$('#DetailEncounterKunjungan').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/FormDetailEncounter.php',
    data        :{id_encounter: GetIdEncounter},
    success     : function(data){
        $('#DetailEncounterKunjungan').html(data);
    }
});
//Form Edit Encounter
$('#ModalEditEncounter').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_encounter = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormEditEncounter').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditEncounter.php',
        data        :{id_encounter: id_encounter, id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditEncounter').html(data);
            //Proses Edit Encounter
            $('#ProsesEditEncounter').submit(function(){
                var ProsesEditEncounter = $('#ProsesEditEncounter').serialize();
                $('#NotifikasiEditEncounter').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesEditEncounter.php',
                    data        :ProsesEditEncounter,
                    success     : function(data){
                        $('#NotifikasiEditEncounter').html(data);
                        var NotifikasiEditEncounterBerhasil=$('#NotifikasiEditEncounterBerhasil').html();
                        if(NotifikasiEditEncounterBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Form Update Encounter
$('#ModalUpdateEncounter').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_encounter = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormUpdateEncounter').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormUpdateEncounter.php',
        data        :{id_encounter: id_encounter, id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormUpdateEncounter').html(data);
            //Proses Update Encounter
            $('#ProsesUpdateEncounter').submit(function(){
                var ProsesUpdateEncounter = $('#ProsesUpdateEncounter').serialize();
                $('#NotifikasiUpdateEncounter').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesUpdateEncounter.php',
                    data        :ProsesUpdateEncounter,
                    success     : function(data){
                        $('#NotifikasiUpdateEncounter').html(data);
                        var NotifikasiUpdateEncounterBerhasil=$('#NotifikasiUpdateEncounterBerhasil').html();
                        if(NotifikasiUpdateEncounterBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Form Tambah Condition
$('#ModalTambahCondition').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahCondition').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahCondition.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahCondition').html(data);
            //Ketika Check box di click
            $('#GenerateIdCondition').click(function(){
                if(document.getElementById('GenerateIdCondition').checked) {
                    $('#id_condition').val('');
                    $('#id_condition').prop('readonly', true);
                }else{
                    $('#id_condition').prop('readonly', false);
                }
            });
             //ketika Diagnosa di ketik
            $('#coding_system').keyup(function(){
                var coding_system = $('#coding_system').val();
                var panjang = coding_system.length;
                if(panjang>3){
                    $('#CodeSystemList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariDiagnosaList.php',
                        data        :   {keyword: coding_system},
                        success     : function(data){
                            $('#CodeSystemList').html(data);
                        }
                    });
                }
            });
            //Proses Tambah Condition
            $('#ProsesTambahCondition').submit(function(){
                var ProsesTambahCondition = $('#ProsesTambahCondition').serialize();
                $('#NotifikasiTambahCondition').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesTambahCondition.php',
                    data        :ProsesTambahCondition,
                    success     : function(data){
                        $('#NotifikasiTambahCondition').html(data);
                        var NotifikasiTambahConditionBerhasil=$('#NotifikasiTambahConditionBerhasil').html();
                        if(NotifikasiTambahConditionBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
$('#ModalDetailCondition').on('show.bs.modal', function (e) {
    var id_condition = $(e.relatedTarget).data('id');
    $('#FormDetailCondition').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailCondition.php',
        data        :{id_condition: id_condition},
        success     : function(data){
            $('#FormDetailCondition').html(data);
        }
    });
});
//Form Edit Condition
$('#ModalEditCondition').on('show.bs.modal', function (e) {
    var id_kunjungan_condition = $(e.relatedTarget).data('id');
    $('#FormEditCondition').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditCondition.php',
        data        :{id_kunjungan_condition: id_kunjungan_condition},
        success     : function(data){
            $('#FormEditCondition').html(data);
            //ketika Diagnosa di ketik
            $('#coding_system').keyup(function(){
                var coding_system = $('#coding_system').val();
                var panjang = coding_system.length;
                if(panjang>3){
                    $('#CodeSystemList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariDiagnosaList.php',
                        data        :   {keyword: coding_system},
                        success     : function(data){
                            $('#CodeSystemList').html(data);
                        }
                    });
                }
            });
            //Proses Edit Condition
            $('#ProsesEditCondition').submit(function(){
                var ProsesEditCondition = $('#ProsesEditCondition').serialize();
                $('#NotifikasiEditCondition').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesEditCondition.php',
                    data        :ProsesEditCondition,
                    success     : function(data){
                        $('#NotifikasiEditCondition').html(data);
                        var NotifikasiEditConditionBerhasil=$('#NotifikasiEditConditionBerhasil').html();
                        if(NotifikasiEditConditionBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//OBSERVATION TAB
var GetIdKunjungan = $('#GetIdKunjungan').val();
$('#ShowObservation').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/ShowObservation.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#ShowObservation').html(data);
    }
});
//Form Tambah Observation
$('#ModalTambahObservation').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahObservation').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahObservation.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahObservation').html(data);
            //Ketika Check box di click
            $('#GenerateIdObservation').click(function(){
                if(document.getElementById('GenerateIdObservation').checked) {
                    $('#id_observation').val('');
                    $('#id_observation').prop('readonly', true);
                }else{
                    $('#id_observation').prop('readonly', false);
                }
            });
            //ketika Loinc di ketik
            $('#CodeSystemLoinc').keyup(function(){
                var CodeSystemLoinc = $('#CodeSystemLoinc').val();
                var panjang = CodeSystemLoinc.length;
                if(panjang>3){
                    $('#CodeSystemList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariLoincList.php',
                        data        :   {keyword: CodeSystemLoinc},
                        success     : function(data){
                            $('#CodeSystemList').html(data);
                        }
                    });
                }
            });
            //CodeSystemLoinc Dipilih
            $('#CodeSystemLoinc').change(function(){
                var CodeSystemLoinc = $('#CodeSystemLoinc').val();
                $('#FormLanjutanObservation').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormLanjutanObservation.php',
                    data        :   {CodeSystemLoinc: CodeSystemLoinc},
                    success     : function(data){
                        $('#FormLanjutanObservation').html(data);
                    }
                });
            });
            //Proses Tambah Observation
            $('#ProsesTambahObservation').submit(function(){
                var ProsesTambahObservation= $('#ProsesTambahObservation').serialize();
                $('#NotifikasiTambahObservation').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesTambahObservation.php',
                    data        :ProsesTambahObservation,
                    success     : function(data){
                        $('#NotifikasiTambahObservation').html(data);
                        var NotifikasiTambahObservationBerhasil=$('#NotifikasiTambahObservationBerhasil').html();
                        if(NotifikasiTambahObservationBerhasil=="Success"){
                            //Sembunyikan Modal
                            $('#ModalTambahObservation').modal('hide');
                            $('#ShowObservation').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ShowObservation.php',
                                data        : {id_kunjungan: id_kunjungan},
                                success     : function(data){
                                    $('#ShowObservation').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Tambah Observation Berhasil',
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
$('#ModalDetailObservation').on('show.bs.modal', function (e) {
    var id_observation = $(e.relatedTarget).data('id');
    $('#FormDetailObservation').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailObservation.php',
        data        :{id_observation: id_observation},
        success     : function(data){
            $('#FormDetailObservation').html(data);
        }
    });
});
$('#ModalEditObservation').on('show.bs.modal', function (e) {
    var id_kunjungan_observation = $(e.relatedTarget).data('id');
    $('#FormEditObservation').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditObservation.php',
        data        :{id_kunjungan_observation: id_kunjungan_observation},
        success     : function(data){
            $('#FormEditObservation').html(data);
            //CodeSystemLoinc Dipilih
            $('#CodeSystemLoinc').change(function(){
                var CodeSystemLoinc = $('#CodeSystemLoinc').val();
                $('#FormLanjutanObservationEdit').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormLanjutanObservation.php',
                    data        :   {CodeSystemLoinc: CodeSystemLoinc},
                    success     : function(data){
                        $('#FormLanjutanObservationEdit').html(data);
                    }
                });
            });
            //Proses Edit Observation
            $('#ProsesEditObservation').submit(function(){
                var ProsesEditObservation= $('#ProsesEditObservation').serialize();
                $('#NotifikasiEditObservation').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesEditObservation.php',
                    data        :ProsesEditObservation,
                    success     : function(data){
                        $('#NotifikasiEditObservation').html(data);
                        var NotifikasiEditObservationBerhasil=$('#NotifikasiEditObservationBerhasil').html();
                        if(NotifikasiEditObservationBerhasil=="Success"){
                            //Sembunyikan Modal
                            $('#ModalEditObservation').modal('hide');
                            $('#ShowObservation').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ShowObservation.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#ShowObservation').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Observation Berhasil',
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
//COMPOSITION
$('#ShowComposition').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/ShowComposition.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#ShowComposition').html(data);
    }
});
//Form Tambah Composition
$('#ModalTambahComposition').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahComposition').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahComposition.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahComposition').html(data);
            //Ketika Check box di click
            $('#GenerateIdComposition').click(function(){
                if(document.getElementById('GenerateIdComposition').checked) {
                    $('#id_composition').val('');
                    $('#id_composition').prop('readonly', true);
                }else{
                    $('#id_composition').prop('readonly', false);
                }
            });
            //ketika Loinc di ketik
            $('#CodeSystemLoinc').keyup(function(){
                var CodeSystemLoinc = $('#CodeSystemLoinc').val();
                var panjang = CodeSystemLoinc.length;
                if(panjang>3){
                    $('#CodeSystemList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariLoincList.php',
                        data        :   {keyword: CodeSystemLoinc},
                        success     : function(data){
                            $('#CodeSystemList').html(data);
                        }
                    });
                }
            });
            //CodeSystemLoinc Dipilih
            $('#CodeSystemLoinc').change(function(){
                var CodeSystemLoinc = $('#CodeSystemLoinc').val();
                $('#FormLanjutanObservation').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormLanjutanObservation.php',
                    data        :   {CodeSystemLoinc: CodeSystemLoinc},
                    success     : function(data){
                        $('#FormLanjutanObservation').html(data);
                    }
                });
            });
            //Proses Tambah Composition
            $('#ProsesTambahComposition').submit(function(){
                var ProsesTambahComposition= $('#ProsesTambahComposition').serialize();
                $('#NotifikasiTambahComposition').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesTambahComposition.php',
                    data        :ProsesTambahComposition,
                    success     : function(data){
                        $('#NotifikasiTambahComposition').html(data);
                        var NotifikasiTambahCompositionBerhasil=$('#NotifikasiTambahCompositionBerhasil').html();
                        if(NotifikasiTambahCompositionBerhasil=="Success"){
                            //Sembunyikan Modal
                            $('#ModalTambahComposition').modal('hide');
                            $('#ShowComposition').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ShowComposition.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#ShowComposition').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Tambah Composition Berhasil',
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
$('#ModalDetailComposition').on('show.bs.modal', function (e) {
    var id_composition = $(e.relatedTarget).data('id');
    $('#FormDetailComposition').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailComposition.php',
        data        :{id_composition: id_composition},
        success     : function(data){
            $('#FormDetailComposition').html(data);
        }
    });
});
$('#ModalInfoComposition').on('show.bs.modal', function (e) {
    var id_kunjungan_composition = $(e.relatedTarget).data('id');
    $('#FormInfoComposition').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormInfoComposition.php',
        data        :{id_kunjungan_composition: id_kunjungan_composition},
        success     : function(data){
            $('#FormInfoComposition').html(data);
        }
    });
});
$('#ModalEditComposition').on('show.bs.modal', function (e) {
    var id_kunjungan_composition = $(e.relatedTarget).data('id');
    $('#FormEditComposition').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditComposition.php',
        data        :{id_kunjungan_composition: id_kunjungan_composition},
        success     : function(data){
            $('#FormEditComposition').html(data);
            //ketika Loinc di ketik
            $('#CodeSystemLoinc').keyup(function(){
                var CodeSystemLoinc = $('#CodeSystemLoinc').val();
                var panjang = CodeSystemLoinc.length;
                if(panjang>3){
                    $('#CodeSystemList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariLoincList.php',
                        data        :   {keyword: CodeSystemLoinc},
                        success     : function(data){
                            $('#CodeSystemList').html(data);
                        }
                    });
                }
            });
            //CodeSystemLoinc Dipilih
            $('#CodeSystemLoinc').change(function(){
                var CodeSystemLoinc = $('#CodeSystemLoinc').val();
                $('#FormLanjutanObservation').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormLanjutanObservation.php',
                    data        :   {CodeSystemLoinc: CodeSystemLoinc},
                    success     : function(data){
                        $('#FormLanjutanObservation').html(data);
                    }
                });
            });
            //Proses Edit Composition
            $('#ProsesEditComposition').submit(function(){
                var ProsesEditComposition= $('#ProsesEditComposition').serialize();
                $('#NotifikasiEditComposition').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesEditComposition.php',
                    data        :ProsesEditComposition,
                    success     : function(data){
                        $('#NotifikasiEditComposition').html(data);
                        var NotifikasiEditCompositionBerhasil=$('#NotifikasiEditCompositionBerhasil').html();
                        if(NotifikasiEditCompositionBerhasil=="Success"){
                            //Sembunyikan Modal
                            $('#ModalEditComposition').modal('hide');
                            $('#ShowComposition').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ShowComposition.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#ShowComposition').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Update Composition Berhasil',
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
$('#ModalHapusComposition').on('show.bs.modal', function (e) {
    var id_kunjungan_composition = $(e.relatedTarget).data('id');
    $('#FormHapusComposition').html("Loading...123");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusComposition.php',
        data        : {id_kunjungan_composition: id_kunjungan_composition},
        success     : function(data){
            $('#FormHapusComposition').html(data);
            //Proses Hapus Composition
            $('#KonfirmasiHapusComposition').click(function(){
                $('#NotifikasiHapusKunjunganComposition').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesHapusComposition.php',
                    data        : {id_kunjungan_composition: id_kunjungan_composition},
                    success     : function(data){
                        $('#NotifikasiHapusKunjunganComposition').html(data);
                        var NotifikasiHapusKunjunganCompositionBerhasil=$('#NotifikasiHapusKunjunganCompositionBerhasil').html();
                        if(NotifikasiHapusKunjunganCompositionBerhasil=="Success"){
                            //Sembunyikan Modal
                            $('#ModalHapusComposition').modal('hide');
                            $('#ShowComposition').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ShowComposition.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#ShowComposition').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Composition Berhasil',
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
//PROCEDUR
$('#ShowProcedur').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/ShowProcedur.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#ShowProcedur').html(data);
    }
});
//Klik Reload Procedure
$('#ReloadProcedure').click(function(){
    var GetIdKunjungan = $('#GetIdKunjungan').val();
    $('#ShowProcedur').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ShowProcedur.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#ShowProcedur').html(data);
        }
    });
});
//Form Tambah Procedure
$('#ModalTambahProcedur').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahProcedure').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahProcedure.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahProcedure').html(data);
            //Ketika Check box di click
            $('#GenerateIdProcedure').click(function(){
                if(document.getElementById('GenerateIdProcedure').checked) {
                    $('#id_procedure').val('');
                    $('#id_procedure').prop('readonly', true);
                }else{
                    $('#id_procedure').prop('readonly', false);
                }
            });
            //ketika category di ketik
            $('#category').keyup(function(){
                var category = $('#category').val();
                var panjang = category.length;
                if(panjang>3){
                    $('#CategoryList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariSnomedList.php',
                        data        :   {keyword: category},
                        success     : function(data){
                            $('#CategoryList').html(data);
                        }
                    });
                }
            });
            //ketika bodySite di ketik
            $('#bodySite').keyup(function(){
                var bodySite = $('#bodySite').val();
                var panjang = bodySite.length;
                if(panjang>3){
                    $('#bodySiteList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariSnomedList.php',
                        data        :   {keyword: bodySite},
                        success     : function(data){
                            $('#bodySiteList').html(data);
                        }
                    });
                }
            });
            //ketika code_procedure di ketik
            $('#code_procedure').keyup(function(){
                var ProsesTambahProcedure = $('#ProsesTambahProcedure').serialize();
                var code_procedure = $('#code_procedure').val();
                var panjang = code_procedure.length;
                if(panjang>3){
                    $('#code_procedure_list').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariProcedurList.php',
                        data        :   ProsesTambahProcedure,
                        success     : function(data){
                            $('#code_procedure_list').html(data);
                        }
                    });
                }
            });
            //ketika reasonCode di ketik
            $('#reasonCode').keyup(function(){
                var ProsesTambahProcedure = $('#ProsesTambahProcedure').serialize();
                var reasonCode = $('#reasonCode').val();
                var panjang = reasonCode.length;
                if(panjang>3){
                    $('#reasonCodeList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariDiagnosaList2.php',
                        data        :   ProsesTambahProcedure,
                        success     : function(data){
                            $('#reasonCodeList').html(data);
                        }
                    });
                }
            });
            //Proses Tambah Procedur
            $('#ProsesTambahProcedure').submit(function(){
                var ProsesTambahProcedure= $('#ProsesTambahProcedure').serialize();
                $('#NotifikasiTambahProcedure').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesTambahProcedure.php',
                    data        :ProsesTambahProcedure,
                    success     : function(data){
                        $('#NotifikasiTambahProcedure').html(data);
                        var NotifikasiTambahProcedureBerhasil=$('#NotifikasiTambahProcedureBerhasil').html();
                        if(NotifikasiTambahProcedureBerhasil=="Success"){
                            //Sembunyikan Modal
                            $('#ModalTambahProcedur').modal('hide');
                            $('#ShowProcedur').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ShowProcedur.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#ShowProcedur').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Tambah Procedure Berhasil',
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
$('#ModalDetailProcedure').on('show.bs.modal', function (e) {
    var resourceId = $(e.relatedTarget).data('id');
    $('#FormDetailProcedure').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailProcedure.php',
        data        :{resourceId: resourceId},
        success     : function(data){
            $('#FormDetailProcedure').html(data);
        }
    });
});
//Form Edit Procedure
$('#ModalEditProcedure').on('show.bs.modal', function (e) {
    var resourceId = $(e.relatedTarget).data('id');
    $('#FormEditProcedure').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditProcedure.php',
        data        :{resourceId: resourceId},
        success     : function(data){
            $('#FormEditProcedure').html(data);
            //ketika category di ketik
            $('#category').keyup(function(){
                var category = $('#category').val();
                var panjang = category.length;
                if(panjang>3){
                    $('#CategoryList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariSnomedList.php',
                        data        :   {keyword: category},
                        success     : function(data){
                            $('#CategoryList').html(data);
                        }
                    });
                }
            });
            //ketika bodySite di ketik
            $('#bodySite').keyup(function(){
                var bodySite = $('#bodySite').val();
                var panjang = bodySite.length;
                if(panjang>3){
                    $('#bodySiteList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariSnomedList.php',
                        data        :   {keyword: bodySite},
                        success     : function(data){
                            $('#bodySiteList').html(data);
                        }
                    });
                }
            });
            //ketika code_procedure di ketik
            $('#code_procedure').keyup(function(){
                var ProsesEditProcedure = $('#ProsesEditProcedure').serialize();
                var code_procedure = $('#code_procedure').val();
                var panjang = code_procedure.length;
                if(panjang>3){
                    $('#code_procedure_list').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariProcedurList.php',
                        data        :   ProsesEditProcedure,
                        success     : function(data){
                            $('#code_procedure_list').html(data);
                        }
                    });
                }
            });
            //ketika reasonCode di ketik
            $('#reasonCode').keyup(function(){
                var ProsesEditProcedure = $('#ProsesEditProcedure').serialize();
                var reasonCode = $('#reasonCode').val();
                var panjang = reasonCode.length;
                if(panjang>3){
                    $('#reasonCodeList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariDiagnosaList2.php',
                        data        :   ProsesEditProcedure,
                        success     : function(data){
                            $('#reasonCodeList').html(data);
                        }
                    });
                }
            });
            //Proses Edit Procedur
            $('#ProsesEditProcedure').submit(function(){
                var ProsesEditProcedure= $('#ProsesEditProcedure').serialize();
                $('#NotifikasiEditProcedure').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesEditProcedure.php',
                    data        :ProsesEditProcedure,
                    success     : function(data){
                        $('#NotifikasiEditProcedure').html(data);
                        var NotifikasiEditProcedureBerhasil=$('#NotifikasiEditProcedureBerhasil').html();
                        if(NotifikasiEditProcedureBerhasil=="Success"){
                            //Sembunyikan Modal
                            $('#ModalEditProcedure').modal('hide');
                            $('#ShowProcedur').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ShowProcedur.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#ShowProcedur').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Procedure Berhasil',
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
//MEDICATION 
//Menampilkan Medication Request Pertama Kali
$('#MenampilkanMedicationRequest').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/MedicationRequest.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#MenampilkanMedicationRequest').html(data);
    }
});
$('#ReloadMedicationRequest').click(function(){
    $('#MenampilkanMedicationRequest').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/MedicationRequest.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanMedicationRequest').html(data);
        }
    });
});
//Ketika Menampilkan Modal Tambah Medication Request
$('#ModalTambahMedicationRequest').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahMedicationRequest').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahMedicationRequest.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahMedicationRequest').html(data);
        }
    });
});
//Proses Tambah Medication Request
$('#ProsesTambahMedicationRequest').submit(function(){
    var ProsesTambahMedicationRequest = $('#ProsesTambahMedicationRequest').serialize();
    $('#NotifikasiTambahMedicationRequest').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTambahMedicationRequest.php',
        data        :ProsesTambahMedicationRequest,
        success     : function(data){
            $('#NotifikasiTambahMedicationRequest').html(data);
            var NotifikasiTambahMedicationRequestBerhasil=$('#NotifikasiTambahMedicationRequestBerhasil').html();
            if(NotifikasiTambahMedicationRequestBerhasil=="Success"){
                $('#ModalTambahMedicationRequest').modal('hide');
                $('#MenampilkanMedicationRequest').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/MedicationRequest.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#MenampilkanMedicationRequest').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Creat Medication Request Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Ketika Menampilkan Modal Detail Medication
$('#ModalDetailMedication').on('show.bs.modal', function (e) {
    var id_medication = $(e.relatedTarget).data('id');
    $('#FormDetailMedication').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailMedication.php',
        data        :   {id_medication: id_medication},
        success     : function(data){
            $('#FormDetailMedication').html(data);
        }
    });
});
//Ketika Menampilkan Modal Detail Medication Request
$('#ModalDetailMedicationRequest2').on('show.bs.modal', function (e) {
    var id_item_resep = $(e.relatedTarget).data('id');
    $('#FormDetailMedicationRequest2').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailMedicationRequest.php',
        data        :   {id_item_resep: id_item_resep},
        success     : function(data){
            $('#FormDetailMedicationRequest2').html(data);
        }
    });
});
//Ketika Menampilkan Modal Edit Medication Request
$('#ModalEditMedicationRequest').on('show.bs.modal', function (e) {
    var id_item_resep = $(e.relatedTarget).data('id');
    $('#FormEditMedicationRequest').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditMedicationRequest.php',
        data        :   {id_item_resep: id_item_resep},
        success     : function(data){
            $('#FormEditMedicationRequest').html(data);
            $('#NotifikasiEditMedicationRequest').html('<span class="text-primary">Pastikan data medication yang anda ubah sudah sesuai!</span>');
        }
    });
});
//Proses Edit Medication Request
$('#ProsesEditMedicationRequest').submit(function(){
    var ProsesEditMedicationRequest = $('#ProsesEditMedicationRequest').serialize();
    $('#NotifikasiEditMedicationRequest').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesEditMedicationRequest.php',
        data        :ProsesEditMedicationRequest,
        success     : function(data){
            $('#NotifikasiEditMedicationRequest').html(data);
            var NotifikasiEditMedicationRequestBerhasil=$('#NotifikasiEditMedicationRequestBerhasil').html();
            if(NotifikasiEditMedicationRequestBerhasil=="Success"){
                $('#ModalEditMedicationRequest').modal('hide');
                $('#MenampilkanMedicationRequest').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/MedicationRequest.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#MenampilkanMedicationRequest').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Update Medication Request Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//MEDICATION DISPENSE
//Menampilkan Medication Dispense Pertama Kali
$('#MenampilkanMedicationDispense').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/MedicationDispense.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#MenampilkanMedicationDispense').html(data);
    }
});
$('#ReloadMedicationDispense').click(function(){
    $('#MenampilkanMedicationDispense').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/MedicationDispense.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanMedicationDispense').html(data);
        }
    });
});
//Ketika Menampilkan Modal Tambah Medication Dispense
$('#ModalTambahMedicationDispense').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahMedicationDispense').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahMedicationDispense.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahMedicationDispense').html(data);
        }
    });
});
//Proses Tambah Medication Request
$('#ProsesTambahMedicationDispense').submit(function(){
    var ProsesTambahMedicationDispense = $('#ProsesTambahMedicationDispense').serialize();
    $('#NotifikasiTambahMedicationDispense').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTambahMedicationDispense.php',
        data        :ProsesTambahMedicationDispense,
        success     : function(data){
            $('#NotifikasiTambahMedicationDispense').html(data);
            var NotifikasiTambahMedicationDispenseBerhasil=$('#NotifikasiTambahMedicationDispenseBerhasil').html();
            if(NotifikasiTambahMedicationDispenseBerhasil=="Success"){
                $('#ModalTambahMedicationDispense').modal('hide');
                $('#MenampilkanMedicationRequest').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/MedicationDispense.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#MenampilkanMedicationRequest').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Buat Medication Dispense Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Ketika Menampilkan Modal Detail Medication Dispense
$('#ModalDetailMedicationDispense').on('show.bs.modal', function (e) {
    var id_kunjungan_med_dis = $(e.relatedTarget).data('id');
    $('#FormDetailMedicationDispense').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailMedicationDispense.php',
        data        :   {id_kunjungan_med_dis: id_kunjungan_med_dis},
        success     : function(data){
            $('#FormDetailMedicationDispense').html(data);
        }
    });
});
//Ketika Menampilkan Modal Edit Medication Dispense
$('#ModalEditMedicationDispense').on('show.bs.modal', function (e) {
    var id_kunjungan_med_dis = $(e.relatedTarget).data('id');
    $('#FormEditMedicationDispense').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditMedicationDispense.php',
        data        :   {id_kunjungan_med_dis: id_kunjungan_med_dis},
        success     : function(data){
            $('#FormEditMedicationDispense').html(data);
        }
    });
});
// ALERGI
// Menampilkan Alergi Berdasarkan ID IHS Pasien Pertama Kali
$('#MenampilkanAlergiByIdIhsPasien').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailAlergiByIdIhsPasien.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#MenampilkanAlergiByIdIhsPasien').html(data);
    }
});
$('#ReloadAlergiByIdIhsPasien').click(function(){
    $('#MenampilkanAlergiByIdIhsPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailAlergiByIdIhsPasien.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanAlergiByIdIhsPasien').html(data);
        }
    });
});
// Menampilkan Alergi Pertama Kali
$('#MenampilkanAllergyIntolerancKunjungan').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailAllergy.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#MenampilkanAllergyIntolerancKunjungan').html(data);
    }
});
$('#ReloadAllergyIntolerancKunjungan').click(function(){
    $('#MenampilkanAllergyIntolerancKunjungan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailAllergy.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanAllergyIntolerancKunjungan').html(data);
        }
    });
});
//Ketika Menampilkan Modal Tambah Alergi
$('#ModalTambahAllergyIntoleranc').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahAllergyIntoleranc').html("Loading...");
    $('#NotifikasiTambahAllergyIntoleranc').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahAllergyIntoleranc.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahAllergyIntoleranc').html(data);
            $('#NotifikasiTambahAllergyIntoleranc').html('Pastikan data yang anda input sudah benar');
        }
    });
});
//Proses Tambah Alergi
$('#ProsesTambahAllergyIntoleranc').submit(function(){
    var ProsesTambahAllergyIntoleranc = $('#ProsesTambahAllergyIntoleranc').serialize();
    $('#NotifikasiTambahAllergyIntoleranc').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTambahAllergyIntoleranc.php',
        data        :ProsesTambahAllergyIntoleranc,
        success     : function(data){
            $('#NotifikasiTambahAllergyIntoleranc').html(data);
            var NotifikasiTambahAllergyIntolerancBerhasil=$('#NotifikasiTambahAllergyIntolerancBerhasil').html();
            if(NotifikasiTambahAllergyIntolerancBerhasil=="Success"){
                $('#ModalTambahAllergyIntoleranc').modal('hide');
                $('#MenampilkanAllergyIntolerancKunjungan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailAllergy.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#MenampilkanAllergyIntolerancKunjungan').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Informasi Alergi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Ketika Menampilkan Modal Detail Alergi
$('#ModalDetailAlergi').on('show.bs.modal', function (e) {
    var id = $(e.relatedTarget).data('id');
    $('#FormDetailAllergyIntoleranc').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailAllergyIntoleranc.php',
        data        :   {id: id},
        success     : function(data){
            $('#FormDetailAllergyIntoleranc').html(data);
        }
    });
});
//Ketika Menampilkan Modal Edit Alergi
$('#ModalEditAllergyIntoleranc').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormEditAllergyIntoleranc').html("Loading...");
    $('#NotifikasiEditAllergyIntoleranc').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditAllergyIntoleranc.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditAllergyIntoleranc').html(data);
            $('#NotifikasiEditAllergyIntoleranc').html('Pastikan data yang anda input sudah benar');
        }
    });
});
//Proses Edit Alergi
$('#ProsesEditAllergyIntoleranc').submit(function(){
    var ProsesEditAllergyIntoleranc = $('#ProsesEditAllergyIntoleranc').serialize();
    $('#NotifikasiEditAllergyIntoleranc').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesEditAllergyIntoleranc.php',
        data        :ProsesEditAllergyIntoleranc,
        success     : function(data){
            $('#NotifikasiEditAllergyIntoleranc').html(data);
            var NotifikasiEditAllergyIntolerancBerhasil=$('#NotifikasiEditAllergyIntolerancBerhasil').html();
            if(NotifikasiEditAllergyIntolerancBerhasil=="Success"){
                $('#ModalEditAllergyIntoleranc').modal('hide');
                $('#MenampilkanAllergyIntolerancKunjungan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailAllergy.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#MenampilkanAllergyIntolerancKunjungan').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Edit Informasi Alergi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//ANTRIAN DALAM DELAIT KUNJUNGAN
$('#DetailAntrianKunjungan').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailAntrianKunjungan.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#DetailAntrianKunjungan').html(data);
    }
});
//GENERAL CONSENT
$('#ListGeneralConsent').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#ListGeneralConsent').html(data);
    }
});
//Modal Tambah General Consent
$('#ModalTambahGeneralConsent').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahGeneralConsent').html(data);
        }
    });
});
//Modal Tanda Tangan GeneralConsent
$('#ModalTandaTanganGeneralConsent').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var kategori = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormTandaTanganGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTandaTanganGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan, kategori: kategori},
        success     : function(data){
            $('#FormTandaTanganGeneralConsent').html(data);
        }
    });
});
//Proses Tanda Tangan General Consent
$('#ProsesTandaTanganGeneralConsent').submit(function(){
    var id_kunjungan = $('#id_kunjungan').val();
    var KategoriTandaTangan = $('#KategoriTandaTangan').val();
    var signature = signaturePad.toDataURL();
    $('#NotifikasiTandaTanganGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTandaTanganGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan, KategoriTandaTangan: KategoriTandaTangan, signature: signature},
        success     : function(data){
            $('#NotifikasiTandaTanganGeneralConsent').html(data);
            var NotifikasiTandaTanganGeneralConsentBerhasil=$('#NotifikasiTandaTanganGeneralConsentBerhasil').html();
            var NotifikasiUrlBack=$('#NotifikasiUrlBack').html();
            var URLBack=NotifikasiUrlBack.replace(/&amp;/g, '&');
            if(NotifikasiTandaTanganGeneralConsentBerhasil=="Success"){
                window.location.replace(URLBack);
            }
        }
    });
});
//Proses Menyimpan General Consent
$('#ProsesTambahGeneralConsent').submit(function(){
    var ProsesTambahGeneralConsent = $('#ProsesTambahGeneralConsent').serialize();
    $('#NotifikasiTambahGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTambahGeneralConsent.php',
        data        :ProsesTambahGeneralConsent,
        success     : function(data){
            $('#NotifikasiTambahGeneralConsent').html(data);
            var NotifikasiTambahGeneralConsentBerhasil=$('#NotifikasiTambahGeneralConsentBerhasil').html();
            if(NotifikasiTambahGeneralConsentBerhasil=="Success"){
                $('#ModalTambahGeneralConsent').modal('hide');
                $('#ListGeneralConsent').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#ListGeneralConsent').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah General Consent Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit General Consent
$('#ModalEditGeneralConsent').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormEditGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditGeneralConsent').html(data);
            //Proses Edit General Consent
            $('#ProsesEditGeneralConsent').submit(function(){
                var ProsesEditGeneralConsent = $('#ProsesEditGeneralConsent').serialize();
                $('#NotifikasiEditGeneralConsent').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesEditGeneralConsent.php',
                    data        :ProsesEditGeneralConsent,
                    success     : function(data){
                        $('#NotifikasiEditGeneralConsent').html(data);
                        var NotifikasiEditGeneralConsentBerhasil=$('#NotifikasiEditGeneralConsentBerhasil').html();
                        if(NotifikasiEditGeneralConsentBerhasil=="Success"){
                            $('#ModalEditGeneralConsent').modal('hide');
                            $('#ListGeneralConsent').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                                data        : {id_kunjungan: id_kunjungan},
                                success     : function(data){
                                    $('#ListGeneralConsent').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit General Consent Berhasil',
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
//Modal Hapus General Consent
$('#ModalHapusGeneralConsent').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormHapusGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormHapusGeneralConsent').html(data);
            //Proses Hapus General Consent
            $('#ProsesHapusGeneralConsent').submit(function(){
                $('#NotifikasiHapusGeneralConsent').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesHapusGeneralConsent.php',
                    data        :{id_kunjungan: id_kunjungan},
                    success     : function(data){
                        $('#NotifikasiHapusGeneralConsent').html(data);
                        var NotifikasiHapusGeneralConsentBerhasil=$('#NotifikasiHapusGeneralConsentBerhasil').html();
                        if(NotifikasiHapusGeneralConsentBerhasil=="Success"){
                            $('#ModalHapusGeneralConsent').modal('hide');
                            $('#ListGeneralConsent').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                                data        : {id_kunjungan: id_kunjungan},
                                success     : function(data){
                                    $('#ListGeneralConsent').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus General Consent Berhasil',
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
//Modal Cetak General Consent
$('#ModalCetakGeneralConsent').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakGeneralConsent').html(data);
        }
    });
});
//Fprm Tambah Privasi General Consent
$('#ModalTambahPrivasi').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahPrivasiGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahPrivasiGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahPrivasiGeneralConsent').html(data);
        }
    });
});
//Proses Menyimpan Privasi General Consent
$('#ProsesTambahPrivasiGeneralConsent').submit(function(){
    var ProsesTambahPrivasiGeneralConsent = $('#ProsesTambahPrivasiGeneralConsent').serialize();
    $('#NotifikasiTambahPrivasiGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTambahPrivasiGeneralConsent.php',
        data        :ProsesTambahPrivasiGeneralConsent,
        success     : function(data){
            $('#NotifikasiTambahPrivasiGeneralConsent').html(data);
            var NotifikasiTambahPrivasiGeneralConsentBerhasil=$('#NotifikasiTambahPrivasiGeneralConsentBerhasil').html();
            if(NotifikasiTambahPrivasiGeneralConsentBerhasil=="Success"){
                $('#ModalTambahPrivasi').modal('hide');
                $('#ListGeneralConsent').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#ListGeneralConsent').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Privasi General Consent Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Provasi General Consent
$('#ModalEditPrivasi').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_privasi = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormEditPrivasiGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditPrivasiGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan, id_privasi: id_privasi},
        success     : function(data){
            $('#FormEditPrivasiGeneralConsent').html(data);
            //Proses Menyimpan Privasi General Consent
            $('#ProsesEditPrivasiGeneralConsent').submit(function(){
                var ProsesEditPrivasiGeneralConsent = $('#ProsesEditPrivasiGeneralConsent').serialize();
                $('#NotifikasiEditPrivasiGeneralConsent').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesEditPrivasiGeneralConsent.php',
                    data        :ProsesEditPrivasiGeneralConsent,
                    success     : function(data){
                        $('#NotifikasiEditPrivasiGeneralConsent').html(data);
                        var NotifikasiEditPrivasiGeneralConsentBerhasil=$('#NotifikasiEditPrivasiGeneralConsentBerhasil').html();
                        if(NotifikasiEditPrivasiGeneralConsentBerhasil=="Success"){
                            $('#ModalEditPrivasi').modal('hide');
                            $('#ListGeneralConsent').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                                data        : {id_kunjungan: id_kunjungan},
                                success     : function(data){
                                    $('#ListGeneralConsent').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Privasi Pasien Berhasil',
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
//Modal Hapus Privasi General Consent
$('#ModalHapusPrivasi').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_privasi = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormHapusPrivasiGeneralConsent').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusPrivasiGeneralConsent.php',
        data        :{id_kunjungan: id_kunjungan, id_privasi: id_privasi},
        success     : function(data){
            $('#FormHapusPrivasiGeneralConsent').html(data);
            //Proses Menyimpan Privasi General Consent
            $('#ProsesHapusPrivasiGeneralConsent').submit(function(){
                $('#NotifikasiHapusPrivasiGeneralConsent').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesHapusPrivasiGeneralConsent.php',
                    data        :{id_kunjungan: id_kunjungan, id_privasi: id_privasi},
                    success     : function(data){
                        $('#NotifikasiHapusPrivasiGeneralConsent').html(data);
                        var NotifikasiHapusPrivasiGeneralConsentBerhasil=$('#NotifikasiHapusPrivasiGeneralConsentBerhasil').html();
                        if(NotifikasiHapusPrivasiGeneralConsentBerhasil=="Success"){
                            $('#ModalHapusPrivasi').modal('hide');
                            $('#ListGeneralConsent').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                                data        : {id_kunjungan: id_kunjungan},
                                success     : function(data){
                                    $('#ListGeneralConsent').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Privasi Pasien Berhasil',
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
//Modal Tambah Penerima Informasi
$('#ModalTambahPenerimaInformasi').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahPenerimaInformasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahPenerimaInformasi.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahPenerimaInformasi').html(data);
        }
    });
});
//Proses Tambah Penerima Informasi
$('#ProsesTambahPenerimaInformasi').submit(function(){
    var ProsesTambahPenerimaInformasi = $('#ProsesTambahPenerimaInformasi').serialize();
    $('#NotifikasiTambahPenerimaInformasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTambahPenerimaInformasi.php',
        data        :ProsesTambahPenerimaInformasi,
        success     : function(data){
            $('#NotifikasiTambahPenerimaInformasi').html(data);
            var NotifikasiTambahPenerimaInformasiBerhasil=$('#NotifikasiTambahPenerimaInformasiBerhasil').html();
            if(NotifikasiTambahPenerimaInformasiBerhasil=="Success"){
                $('#ModalTambahPenerimaInformasi').modal('hide');
                $('#ListGeneralConsent').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#ListGeneralConsent').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Penerima Informasi Pasien Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Penerima Informasi
$('#ModalEditPenerimaInformasi').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormEditPenerimaInformasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditPenerimaInformasi.php',
        data        :{id_kunjungan: id_kunjungan, id: id},
        success     : function(data){
            $('#FormEditPenerimaInformasi').html(data);
            //Proses Edit Penerima Informasi
            $('#ProsesEditPenerimaInformasi').submit(function(){
                var ProsesEditPenerimaInformasi = $('#ProsesEditPenerimaInformasi').serialize();
                $('#NotifikasiEditPenerimaInformasi').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesEditPenerimaInformasi.php',
                    data        :ProsesEditPenerimaInformasi,
                    success     : function(data){
                        $('#NotifikasiEditPenerimaInformasi').html(data);
                        var NotifikasiEditPenerimaInformasiBerhasil=$('#NotifikasiEditPenerimaInformasiBerhasil').html();
                        if(NotifikasiEditPenerimaInformasiBerhasil=="Success"){
                            $('#ModalEditPenerimaInformasi').modal('hide');
                            $('#ListGeneralConsent').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                                data        : {id_kunjungan: id_kunjungan},
                                success     : function(data){
                                    $('#ListGeneralConsent').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Penerima Pasien Berhasil',
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
//Modal Hapus Penerima Informasi
$('#ModalHapusPenerimaInformasi').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormHapusPenerimaInformasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusPenerimaInformasi.php',
        data        :{id_kunjungan: id_kunjungan, id: id},
        success     : function(data){
            $('#FormHapusPenerimaInformasi').html(data);
            //Proses Hapus Penerima Informasi General Consent
            $('#ProsesHapusPenerimaInformasiGeneralConsent').submit(function(){
                $('#NotifikasiHapusPenerimaInformasiGeneralConsent').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesHapusPenerimaInformasiGeneralConsent.php',
                    data        :{id_kunjungan: id_kunjungan, id: id},
                    success     : function(data){
                        $('#NotifikasiHapusPenerimaInformasiGeneralConsent').html(data);
                        var NotifikasiHapusPenerimaInformasiGeneralConsentBerhasil=$('#NotifikasiHapusPenerimaInformasiGeneralConsentBerhasil').html();
                        if(NotifikasiHapusPenerimaInformasiGeneralConsentBerhasil=="Success"){
                            $('#ModalHapusPenerimaInformasi').modal('hide');
                            $('#ListGeneralConsent').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ListGeneralConsent.php',
                                data        : {id_kunjungan: id_kunjungan},
                                success     : function(data){
                                    $('#ListGeneralConsent').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Penerima Informasi Pasien Berhasil',
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
//TRIASE IGD
$('#DetailTriaseDanIgd').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailTriaseDanIgd.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#DetailTriaseDanIgd').html(data);
    }
});
//Modal Tambah Triase IGD
$('#ModalTambahTriaseDanIgd').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahTriaseDanIgd').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahTriaseDanIgd.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahTriaseDanIgd').html(data);
            //Ketika Sarana Transportasi Lainnya
            $('#sarana_transportasi').change(function(){
                var sarana_transportasi = $('#sarana_transportasi').val();
                if(sarana_transportasi=="Lainnya"){
                    $("#keterangan_sarana_transportasi").attr("readonly", false);
                }else{
                    $("#keterangan_sarana_transportasi").attr("true", false);
                }
            });
            //Ketika surat_rujukan Ya
            $('#surat_rujukan').change(function(){
                var surat_rujukan = $('#surat_rujukan').val();
                if(surat_rujukan=="Ada"){
                    $("#asal_rujukan").attr("readonly", false);
                    $("#no_surat_rujukan").attr("readonly", false);
                }else{
                    $("#asal_rujukan").attr("readonly", true);
                    $("#no_surat_rujukan").attr("readonly", true);
                }
            });
            //Ketika Ada Nyeri
            $('#asesmen_nyeri').change(function(){
                var asesmen_nyeri=$('#asesmen_nyeri').val();
                $('#FormAsesmenNyeri').html("Loading...");
                if(asesmen_nyeri=="Ada"){
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/FormAsesmenNyeri.php',
                        success     : function(data){
                            $('#FormAsesmenNyeri').html(data);
                            //Ketika VAS di ubah
                            $('#skala_vas').change(function(){
                                var skala_vas=$('#skala_vas').val();
                                $('#ValueSkalaVas').html(skala_vas);
                            });
                            //Ketika NRS di ubah
                            $('#skala_nrs').change(function(){
                                var skala_nrs=$('#skala_nrs').val();
                                $('#ValueSkalaNrs').html(skala_nrs);
                            });
                            //Ketika VRS di ubah
                            $('#skala_vrs').change(function(){
                                var skala_vrs=$('#skala_vrs').val();
                                $('#ValueSkalaVrs').html(skala_vrs);
                            });
                        }
                    });
                }else{
                    $('#FormAsesmenNyeri').html("");
                }
            });
            //Ketika Assesmen Resiko Jatuh MFS
            $('#resikoi_jatuh_mfs1').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs2').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs3').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs4').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs5').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs6').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            //Ketika Assesmen Resiko Jatuh HDS
            $('#resikoi_jatuh_hds1').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds2').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds3').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds4').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds5').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds6').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds7').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            //Ketika Assesmen Resiko Jatuh EPFRA
            $('#resikoi_jatuh_epfra1').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra2').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra3').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra4').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra5').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra6').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra7').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra8').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra9').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
        }
    });
});
//Proses Tambah Trease IGD
$('#ProsesTambahTriaseDanIgd').submit(function(){
    var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
    $('#NotifikasiTambahTriaseDanIgd').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesTambahTriaseDanIgd.php',
        data        :ProsesTambahTriaseDanIgd,
        success     : function(data){
            $('#NotifikasiTambahTriaseDanIgd').html(data);
            var NotifikasiTambahTriaseDanIgdBerhasil=$('#NotifikasiTambahTriaseDanIgdBerhasil').html();
            if(NotifikasiTambahTriaseDanIgdBerhasil=="Success"){
                $('#ModalTambahTriaseDanIgd').modal('hide');
                $('#DetailTriaseDanIgd').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailTriaseDanIgd.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailTriaseDanIgd').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Triase pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Triase Dan Igd
$('#ModalEditTriaseDanIgd').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormEditTriaseDanIgd').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditTriaseDanIgd.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditTriaseDanIgd').html(data);
            //Ketika Sarana Transportasi Lainnya
            $('#sarana_transportasi').change(function(){
                var sarana_transportasi = $('#sarana_transportasi').val();
                if(sarana_transportasi=="Lainnya"){
                    $("#keterangan_sarana_transportasi").attr("readonly", false);
                }else{
                    $("#keterangan_sarana_transportasi").attr("true", false);
                }
            });
            //Ketika surat_rujukan Ya
            $('#surat_rujukan').change(function(){
                var surat_rujukan = $('#surat_rujukan').val();
                if(surat_rujukan=="Ada"){
                    $("#asal_rujukan").attr("readonly", false);
                    $("#no_surat_rujukan").attr("readonly", false);
                }else{
                    $("#asal_rujukan").attr("readonly", true);
                    $("#no_surat_rujukan").attr("readonly", true);
                }
            });
            //Ketika Ada Nyeri
            $('#asesmen_nyeri').change(function(){
                var asesmen_nyeri=$('#asesmen_nyeri').val();
                $('#FormAsesmenNyeri').html("Loading...");
                if(asesmen_nyeri=="Ada"){
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/FormAsesmenNyeri.php',
                        success     : function(data){
                            $('#FormAsesmenNyeri').html(data);
                            //Ketika VAS di ubah
                            $('#skala_vas').change(function(){
                                var skala_vas=$('#skala_vas').val();
                                $('#ValueSkalaVas').html(skala_vas);
                            });
                            //Ketika NRS di ubah
                            $('#skala_nrs').change(function(){
                                var skala_nrs=$('#skala_nrs').val();
                                $('#ValueSkalaNrs').html(skala_nrs);
                            });
                            //Ketika VRS di ubah
                            $('#skala_vrs').change(function(){
                                var skala_vrs=$('#skala_vrs').val();
                                $('#ValueSkalaVrs').html(skala_vrs);
                            });
                        }
                    });
                }else{
                    $('#FormAsesmenNyeri').html("");
                }
            });
            //Ketika Assesmen Resiko Jatuh MFS
            $('#resikoi_jatuh_mfs1').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs2').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs3').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs4').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs5').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_mfs6').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_mfs_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateMfs.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_mfs_skor_kategori').html(data);
                    }
                });
            });
            //Ketika Assesmen Resiko Jatuh HDS
            $('#resikoi_jatuh_hds1').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds2').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds3').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds4').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds5').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds6').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_hds7').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_hds_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateHds.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_hds_skor_kategori').html(data);
                    }
                });
            });
            //Ketika Assesmen Resiko Jatuh EPFRA
            $('#resikoi_jatuh_epfra1').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra2').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra3').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra4').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra5').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra6').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra7').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra8').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
            $('#resikoi_jatuh_epfra9').change(function(){
                var ProsesTambahTriaseDanIgd = $('#ProsesTambahTriaseDanIgd').serialize();
                $('#resikoi_jatuh_epfra_skor_kategori').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CalculateEpfa.php',
                    data        : ProsesTambahTriaseDanIgd,
                    success     : function(data){
                        $('#resikoi_jatuh_epfra_skor_kategori').html(data);
                    }
                });
            });
        }
    });
});
$('#ProsesEditTriaseDanIgd').submit(function(){
    var ProsesEditTriaseDanIgd = $('#ProsesEditTriaseDanIgd').serialize();
    $('#NotifikasiEditTriaseDanIgd').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ProsesEditTriaseDanIgd.php',
        data        :ProsesEditTriaseDanIgd,
        success     : function(data){
            $('#NotifikasiEditTriaseDanIgd').html(data);
            var NotifikasiEditTriaseDanIgdBerhasil=$('#NotifikasiEditTriaseDanIgdBerhasil').html();
            if(NotifikasiEditTriaseDanIgdBerhasil=="Success"){
                $('#ModalEditTriaseDanIgd').modal('hide');
                $('#DetailTriaseDanIgd').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailTriaseDanIgd.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailTriaseDanIgd').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Triase pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Triase IGD
$('#ModalHapusTriaseIgd').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormHapusTriaseIgd').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusTriaseIgd.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormHapusTriaseIgd').html(data);
            //Proses Hapus Triase IGD
            $('#ProsesHapusTriaseIgd').submit(function(){
                $('#NotifikasiHapusTriaseIgd').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesHapusTriaseIgd.php',
                    data        :{id_kunjungan: id_kunjungan},
                    success     : function(data){
                        $('#NotifikasiHapusTriaseIgd').html(data);
                        var NotifikasiHapusTriaseIgdBerhasil=$('#NotifikasiHapusTriaseIgdBerhasil').html();
                        if(NotifikasiHapusTriaseIgdBerhasil=="Success"){
                            $('#ModalHapusTriaseIgd').modal('hide');
                            $('#DetailTriaseDanIgd').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailTriaseDanIgd.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailTriaseDanIgd').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Triase IGD Berhasil',
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
//Modal Cetak Triase IGD
$('#ModalCetakTriaseIgd').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakTriaseIgd').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakTriaseIgd.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakTriaseIgd').html(data);
        }
    });
});
//ANAMNESIS
$('#DetailAnamnesis').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailAnamnesis.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#DetailAnamnesis').html(data);
    }
});
//Modal Tambah Anamnesis
$('#ModalTambahAnamnesis').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahAnamnesis').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahAnamnesis.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahAnamnesis').html(data);
        }
    });
});
//Proses Tambah Anamnesis
$('#ProsesTambahAnamnesis').submit(function(){
    var ProsesTambahAnamnesis = $('#ProsesTambahAnamnesis').serialize();
    $('#NotifikasiTambahAnamnesis').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahAnamnesis.php',
        data        :   ProsesTambahAnamnesis,
        success     :   function(data){
            $('#NotifikasiTambahAnamnesis').html(data);
            var NotifikasiTambahAnamnesisBerhasil=$('#NotifikasiTambahAnamnesisBerhasil').html();
            if(NotifikasiTambahAnamnesisBerhasil=="Success"){
                $('#ModalTambahAnamnesis').modal('hide');
                $('#DetailAnamnesis').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailAnamnesis.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailAnamnesis').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Anamnesis Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Rich Text
$('#ModalEditRichText').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var NamaData = pecah[0];
    var id_kunjungan = pecah[1];
    $('#FormRichText').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormRichText.php',
        data        :{id_kunjungan: id_kunjungan, NamaData: NamaData},
        success     : function(data){
            $('#FormRichText').html(data);
            $('#RichText').summernote({
                height: 300,
            });
        }
    });
});
//Proses Simpan RichText
$('#ProsesEditRichText').submit(function(){
    var PutIdKunjungan = $('#PutIdKunjungan').val();
    var NamaData = $('#NamaData').val();
    var RichText =  $('#RichText').summernote('code');
    $('#NotifikasiSimpanRichText').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditRichText.php',
        data        :   {PutIdKunjungan: PutIdKunjungan, NamaData: NamaData, RichText: RichText},
        success     :   function(data){
            $('#NotifikasiSimpanRichText').html(data);
            var NotifikasiSimpanRichTextBerhasil=$('#NotifikasiSimpanRichTextBerhasil').html();
            if(NotifikasiSimpanRichTextBerhasil=="Success"){
                $('#ModalEditRichText').modal('hide');
                $('#DetailAnamnesis').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailAnamnesis.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailAnamnesis').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Ubah Anamnesis Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Riwaya Alergi
$('#ModalEditRiwayaAlergi').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var kategori = pecah[1];
    $('#FormEditRiwayaAlergi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditRiwayaAlergi.php',
        data        :{id_kunjungan: id_kunjungan, kategori: kategori},
        success     : function(data){
            $('#FormEditRiwayaAlergi').html(data);
        }
    });
});
//Proses Edit Riwayat Alergy
$('#ProsesEditRiwayaAlergi').submit(function(){
    var ProsesEditRiwayaAlergi = $('#ProsesEditRiwayaAlergi').serialize();
    $('#NotifikasiEditRiwayaAlergi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditRiwayaAlergi.php',
        data        :   ProsesEditRiwayaAlergi,
        success     :   function(data){
            $('#NotifikasiEditRiwayaAlergi').html(data);
            var NotifikasiEditRiwayaAlergiBerhasil=$('#NotifikasiEditRiwayaAlergiBerhasil').html();
            if(NotifikasiEditRiwayaAlergiBerhasil=="Success"){
                $('#ModalEditRiwayaAlergi').modal('hide');
                $('#DetailAnamnesis').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailAnamnesis.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailAnamnesis').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Ubah Riwayat Alergy Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Anamnesis
$('#ModalEditAnamnesis').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormEditAnamnesis').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditAnamnesis.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditAnamnesis').html(data);
        }
    });
});
//Proses Edit Anamnesis
$('#ProsesEditAnamnesis').submit(function(){
    var ProsesEditAnamnesis = $('#ProsesEditAnamnesis').serialize();
    $('#NotifikasiEditAnamnesis').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditAnamnesis.php',
        data        :   ProsesEditAnamnesis,
        success     :   function(data){
            $('#NotifikasiEditAnamnesis').html(data);
            var NotifikasiEditAnamnesisBerhasil=$('#NotifikasiEditAnamnesisBerhasil').html();
            if(NotifikasiEditAnamnesisBerhasil=="Success"){
                $('#ModalEditAnamnesis').modal('hide');
                $('#DetailAnamnesis').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailAnamnesis.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailAnamnesis').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Ubah Anamnesis Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Cetak Anamnesis
$('#ModalCetakAnamnesis').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakAnamnesis').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakAnamnesis.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakAnamnesis').html(data);
        }
    });
});
//Modal Hapus Anamnesis
$('#ModalHapusAnamnesis').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormHapusAnamnesis').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusAnamnesis.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormHapusAnamnesis').html(data);
            //Proses Hapus Anamnesis
            $('#ProsesHapusAnamnesis').submit(function(){
                $('#NotifikasiHapusAnamnesis').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ProsesHapusAnamnesis.php',
                    data        :{id_kunjungan: id_kunjungan},
                    success     : function(data){
                        $('#NotifikasiHapusAnamnesis').html(data);
                        var NotifikasiHapusAnamnesisBerhasil=$('#NotifikasiHapusAnamnesisBerhasil').html();
                        if(NotifikasiHapusAnamnesisBerhasil=="Success"){
                            $('#ModalHapusAnamnesis').modal('hide');
                            $('#DetailAnamnesis').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailAnamnesis.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailAnamnesis').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Anamnesis Berhasil',
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
//PEMERIKSAAN DASAR DALAM DELAIT KUNJUNGAN
$('#DetailPemeriksaanDasar').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailPemeriksaanDasar.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#DetailPemeriksaanDasar').html(data);
    }
});
//Modal Edit Tanda Vital
$('#ModalEditTandaVitalPemeriksaanDasar').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormEditTandaVitalPemeriksaanDasar').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditTandaVitalPemeriksaanDasar.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditTandaVitalPemeriksaanDasar').html(data);
        }
    });
});
//Proses Tanda Vital
$('#ProsesEditTandaVitalPemeriksaanDasar').submit(function(){
    var ProsesEditTandaVitalPemeriksaanDasar = $('#ProsesEditTandaVitalPemeriksaanDasar').serialize();
    $('#NotifikasiEditTandaVital').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditTandaVitalPemeriksaanDasar.php',
        data        :   ProsesEditTandaVitalPemeriksaanDasar,
        success     :   function(data){
            $('#NotifikasiEditTandaVital').html(data);
            var NotifikasiEditTandaVitalBerhasil=$('#NotifikasiEditTandaVitalBerhasil').html();
            if(NotifikasiEditTandaVitalBerhasil=="Success"){
                $('#ModalEditTandaVitalPemeriksaanDasar').modal('hide');
                $('#DetailPemeriksaanDasar').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPemeriksaanDasar.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailPemeriksaanDasar').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Ubah Tanda Vital Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Tambah Pemeriksaan Dasar
$('#ModalTambahPemeriksaanDasar').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahPemeriksaanDasar').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahPemeriksaanDasar.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahPemeriksaanDasar').html(data);
        }
    });
});
//Proses Tambah Pemeriksaan Dasar
$('#ProsesTambahPemeriksaanDasar').submit(function(){
    var ProsesTambahPemeriksaanDasar = $('#ProsesTambahPemeriksaanDasar').serialize();
    $('#NotifikasiTambahPemeriksaanDasar').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahPemeriksaanDasar.php',
        data        :   ProsesTambahPemeriksaanDasar,
        success     :   function(data){
            $('#NotifikasiTambahPemeriksaanDasar').html(data);
            var NotifikasiTambahPemeriksaanDasarBerhasil=$('#NotifikasiTambahPemeriksaanDasarBerhasil').html();
            if(NotifikasiTambahPemeriksaanDasarBerhasil=="Success"){
                $('#ModalTambahPemeriksaanDasar').modal('hide');
                $('#DetailPemeriksaanDasar').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPemeriksaanDasar.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailPemeriksaanDasar').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Pemeriksaan Fisik Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Pemeriksaan Dasar
$('#ModalEditPemeriksaanDasar').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormEditPemeriksaanDasar').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditPemeriksaanDasar.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditPemeriksaanDasar').html(data);
        }
    });
});
//Proses Edit Pemeriksaan Dasar
$('#ProsesEditPemeriksaanDasar').submit(function(){
    var ProsesEditPemeriksaanDasar = $('#ProsesEditPemeriksaanDasar').serialize();
    $('#NotifikasiEditPemeriksaanDasar').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditPemeriksaanDasar.php',
        data        :   ProsesEditPemeriksaanDasar,
        success     :   function(data){
            $('#NotifikasiEditPemeriksaanDasar').html(data);
            var NotifikasiEditPemeriksaanDasarBerhasil=$('#NotifikasiEditPemeriksaanDasarBerhasil').html();
            if(NotifikasiEditPemeriksaanDasarBerhasil=="Success"){
                $('#ModalEditPemeriksaanDasar').modal('hide');
                $('#DetailPemeriksaanDasar').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPemeriksaanDasar.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailPemeriksaanDasar').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Pemeriksaan Fisik Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Pemeriksaan Dasar
$('#ModalHapusPemeriksaanDasar').on('show.bs.modal', function (e) {
    var IdKunjunganHapusPemeriksaanDasar = $(e.relatedTarget).data('id');
    $('#FormHapusPemeriksaanDasar').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusPemeriksaanDasar.php',
        data        :{id_kunjungan: IdKunjunganHapusPemeriksaanDasar},
        success     : function(data){
            $('#FormHapusPemeriksaanDasar').html(data);
            //Proses Hapus Pemeriksaan Dasar
            $('#ProsesHapusPemeriksaanDasar').submit(function(){
                $('#NotifikasiHapusPemeriksaanDasar').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusPemeriksaanDasar.php',
                    data        :   {id_kunjungan: IdKunjunganHapusPemeriksaanDasar},
                    success     :   function(data){
                        $('#NotifikasiHapusPemeriksaanDasar').html(data);
                        var NotifikasiHapusPemeriksaanDasarBerhasil=$('#NotifikasiHapusPemeriksaanDasarBerhasil').html();
                        if(NotifikasiHapusPemeriksaanDasarBerhasil=="Success"){
                            $('#DetailPemeriksaanDasar').html("Loading...");
                            $('#ModalHapusPemeriksaanDasar').modal('hide');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailPemeriksaanDasar.php',
                                data        : {id_kunjungan: IdKunjunganHapusPemeriksaanDasar},
                                success     : function(data){
                                    $('#DetailPemeriksaanDasar').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Pemeriksaan Dasar Berhasil',
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
//Modal Print Pemeriksaan Dasar
$('#ModalCetakPemeriksaanDasar').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakPemeriksaanDasar').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakPemeriksaanDasar.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakPemeriksaanDasar').html(data);
        }
    });
});
//Modal Edit Anatomi
$('#ModalEditAnatomi').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var KodeAnatomi = pecah[1];
    $('#FormEditAnatomi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditAnatomi.php',
        data        :{id_kunjungan: id_kunjungan, KodeAnatomi: KodeAnatomi},
        success     : function(data){
            $('#FormEditAnatomi').html(data);
            $('#EditPenejelasanAnatomi').summernote({
                height: 300,
            });
        }
    });
});
//Modal Hapus Anatomi
$('#ModalHapusAnatomi').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var KodeAnatomi = pecah[1];
    $('#FormHapusAnatomi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusAnatomi.php',
        data        :{id_kunjungan: id_kunjungan, KodeAnatomi: KodeAnatomi},
        success     : function(data){
            $('#FormHapusAnatomi').html(data);
        }
    });
});
//Proses Hapus Anatomi
$('#ProsesHapusAnatomi').submit(function(){
    var id_kunjungan = $('#IdKunjunganHapusAnatomiForm').val();
    var KodeAnatomi = $('#KodeAnatomiHapusAnatomiForm').val();
    $('#NotifikasiHapusAnatomi').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesHapusAnatomi.php',
        data        :   {id_kunjungan: id_kunjungan, KodeAnatomi: KodeAnatomi},
        success     :   function(data){
            $('#NotifikasiHapusAnatomi').html(data);
            var NotifikasiHapusAnatomiBerhasil=$('#NotifikasiHapusAnatomiBerhasil').html();
            if(NotifikasiHapusAnatomiBerhasil=="Success"){
                $('#DetailPemeriksaanDasar').html("Loading...");
                $('#ModalHapusAnatomi').modal('hide');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPemeriksaanDasar.php',
                    data        : {id_kunjungan: id_kunjungan},
                    success     : function(data){
                        $('#DetailPemeriksaanDasar').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Anatomi Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Pemeriksaan Fisik Umum
$('#ModalEditPemeriksaanFisikUmum').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var kategori = pecah[1];
    $('#FormEditPemeriksaanFisikUmum').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditPemeriksaanFisikUmum.php',
        data        :{id_kunjungan: id_kunjungan, kategori: kategori},
        success     : function(data){
            $('#FormEditPemeriksaanFisikUmum').html(data);
            $('#PemeriksaanFisikUmum').summernote({
                height: 300,
            });
        }
    });
});
//Proses Edit Pemeriksaan Fisik Umum
$('#ProsesEditPemeriksaanFisikUmum').submit(function(){
    var id_kunjungan = $('#IdKunjunganPemeriksaanFisikUmum').val();
    var kategori = $('#KategoriPemeriksaanFisikUmum').val();
    var PemeriksaanFisikUmum =  $('#PemeriksaanFisikUmum').summernote('code');
    $('#NotifikasiEditPemeriksaanFisikUmum').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditPemeriksaanFisikUmum.php',
        data        :   {id_kunjungan: id_kunjungan, kategori: kategori, PemeriksaanFisikUmum: PemeriksaanFisikUmum},
        success     :   function(data){
            $('#NotifikasiEditPemeriksaanFisikUmum').html(data);
            var NotifikasiEditPemeriksaanFisikUmumBerhasil=$('#NotifikasiEditPemeriksaanFisikUmumBerhasil').html();
            if(NotifikasiEditPemeriksaanFisikUmumBerhasil=="Success"){
                $('#DetailPemeriksaanDasar').html("Loading...");
                $('#ModalEditPemeriksaanFisikUmum').modal('hide');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPemeriksaanDasar.php',
                    data        : {id_kunjungan: id_kunjungan},
                    success     : function(data){
                        $('#DetailPemeriksaanDasar').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Ubah Penjelasan Pemeriksaan Fisik Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//PSIKOSOS
$('#DetailPsikosos').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailPsikosos.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#DetailPsikosos').html(data);
    }
});
//Modal Tambah Psikosos
$('#ModalTambahPsikosos').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahPsikosos').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahPsikosos.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahPsikosos').html(data);
        }
    });
});
//Proses Tambah Psikosos
$('#ProsesTambahPsikosos').submit(function(){
    var ProsesTambahPsikosos = $('#ProsesTambahPsikosos').serialize();
    $('#NotifikasiTambahPsikosos').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahPsikosos.php',
        data        :   ProsesTambahPsikosos,
        success     :   function(data){
            $('#NotifikasiTambahPsikosos').html(data);
            var NotifikasiTambahPsikososBerhasil=$('#NotifikasiTambahPsikososBerhasil').html();
            if(NotifikasiTambahPsikososBerhasil=="Success"){
                $('#ModalTambahPsikosos').modal('hide');
                $('#DetailPsikosos').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPsikosos.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailPsikosos').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Informasi Psikososial Pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Psikosos
$('#ModalEditPsikosos').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormEditPsikosos').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditPsikosos.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditPsikosos').html(data);
        }
    });
});
//Proses Edit Psikosos
$('#ProsesEditPsikosos').submit(function(){
    var ProsesEditPsikosos = $('#ProsesEditPsikosos').serialize();
    $('#NotifikasiEditPsikosos').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditPsikosos.php',
        data        :   ProsesEditPsikosos,
        success     :   function(data){
            $('#NotifikasiEditPsikosos').html(data);
            var NotifikasiEditPsikososBerhasil=$('#NotifikasiEditPsikososBerhasil').html();
            if(NotifikasiEditPsikososBerhasil=="Success"){
                $('#ModalEditPsikosos').modal('hide');
                $('#DetailPsikosos').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPsikosos.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailPsikosos').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Informasi Psikososial Pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Psikosos
$('#ModalHapusPsikosos').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormHapusPsikosos').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusPsikosos.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormHapusPsikosos').html(data);
            //Proses Hapus Psikosos
            $('#ProsesHapusPsikosos').submit(function(){
                $('#NotifikasiHapusPsikosos').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusPsikosos.php',
                    data        :   {id_kunjungan: id_kunjungan},
                    success     :   function(data){
                        $('#NotifikasiHapusPsikosos').html(data);
                        var NotifikasiHapusPsikososBerhasil=$('#NotifikasiHapusPsikososBerhasil').html();
                        if(NotifikasiHapusPsikososBerhasil=="Success"){
                            $('#DetailPsikosos').html("Loading...");
                            $('#ModalHapusPsikosos').modal('hide');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailPsikosos.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailPsikosos').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Informasi Psikososial Pasien Berhasil',
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
//Modal Print Psikosos
$('#ModalCetakPsikosos').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakPsikosos').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakPsikosos.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakPsikosos').html(data);
        }
    });
});
//SCREENING
$('#DetailScreening').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailScreening.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#DetailScreening').html(data);
    }
});
//Modal Tambah Screening
$('#ModalTambahScreening').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahScreening').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahScreening.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahScreening').html(data);
            //Kondisi Ketika Ada Decubitus
            $('#status_decubitus').change(function(){
                var status_decubitus=$('#status_decubitus').val();
                if(status_decubitus=="Ya"){
                    $("#keterangan_decubitus").prop('readonly', false);
                }else{
                    $("#keterangan_decubitus").prop('readonly', true);
                    $('#keterangan_decubitus').val("");
                }
            });
            //Kondisi Ketika Status Gizi Di Click
            $("#gizi1").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#gizi1a").prop('readonly', false);
                } else {
                    $("#gizi1a").prop('readonly', true);
                    $('#gizi1a').val("");
                }
            });
            $("#gizi2").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#gizi2a").prop('readonly', false);
                } else {
                    $("#gizi2a").prop('readonly', true);
                    $('#gizi2a').val("");
                }
            });
            $("#gizi3").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#gizi3a").prop('readonly', false);
                } else {
                    $("#gizi3a").prop('readonly', true);
                    $('#gizi3a').val("");
                }
            });
            $("#gizi4").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#gizi4a").prop('readonly', false);
                } else {
                    $("#gizi4a").prop('readonly', true);
                    $('#gizi4a').val("");
                }
            });
            $("#gizi5").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#gizi5a").prop('readonly', false);
                } else {
                    $("#gizi5a").prop('readonly', true);
                    $('#gizi5a').val("");
                }
            });
        }
    });
});
//Proses Tambah Screening
$('#ProsesTambahScreening').submit(function(){
    var ProsesTambahScreening = $('#ProsesTambahScreening').serialize();
    $('#NotifikasiTambahScreening').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahScreening.php',
        data        :   ProsesTambahScreening,
        success     :   function(data){
            $('#NotifikasiTambahScreening').html(data);
            var NotifikasiTambahScreeningBerhasil=$('#NotifikasiTambahScreeningBerhasil').html();
            if(NotifikasiTambahScreeningBerhasil=="Success"){
                $('#ModalTambahScreening').modal('hide');
                $('#DetailScreening').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailScreening.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailScreening').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Screening Pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Screening
$('#ModalEditScreening').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormEditScreening').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditScreening.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormEditScreening').html(data);
            //Kondisi Ketika Ada Decubitus
            $('#Edit_status_decubitus').change(function(){
                var status_decubitus=$('#Edit_status_decubitus').val();
                if(status_decubitus=="Ya"){
                    $("#Edit_keterangan_decubitus").prop('readonly', false);
                }else{
                    $("#Edit_keterangan_decubitus").prop('readonly', true);
                    $('#Edit_keterangan_decubitus').val("");
                }
            });
            //Kondisi Ketika Status Gizi Di Click
            $("#Edit_gizi1").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#Edit_gizi1a").prop('readonly', false);
                } else {
                    $("#Edit_gizi1a").prop('readonly', true);
                    $('#Edit_gizi1a').val("");
                }
            });
            $("#Edit_gizi2").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#Edit_gizi2a").prop('readonly', false);
                } else {
                    $("#Edit_gizi2a").prop('readonly', true);
                    $('#Edit_gizi2a').val("");
                }
            });
            $("#Edit_gizi3").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#Edit_gizi3a").prop('readonly', false);
                } else {
                    $("#Edit_gizi3a").prop('readonly', true);
                    $('#Edit_gizi3a').val("");
                }
            });
            $("#Edit_gizi4").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#Edit_gizi4a").prop('readonly', false);
                } else {
                    $("#Edit_gizi4a").prop('readonly', true);
                    $('#Edit_gizi4a').val("");
                }
            });
            $("#Edit_gizi5").on('change', function() {
                if ($(this).is(':checked')) {
                    $("#Edit_gizi5a").prop('readonly', false);
                } else {
                    $("#Edit_gizi5a").prop('readonly', true);
                    $('#Edit_gizi5a').val("");
                }
            });
        }
    });
});
//Proses Edit Screening
$('#ProsesEditScreening').submit(function(){
    var ProsesEditScreening = $('#ProsesEditScreening').serialize();
    $('#NotifikasiEditScreening').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditScreening.php',
        data        :   ProsesEditScreening,
        success     :   function(data){
            $('#NotifikasiEditScreening').html(data);
            var NotifikasiEditScreeningBerhasil=$('#NotifikasiEditScreeningBerhasil').html();
            if(NotifikasiEditScreeningBerhasil=="Success"){
                $('#ModalEditScreening').modal('hide');
                $('#DetailScreening').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailScreening.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailScreening').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Screening Pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Screening
$('#ModalHapusScreening').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormHapusScreening').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusScreening.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormHapusScreening').html(data);
            //Proses Hapus Screening
            $('#ProsesHapusScreening').submit(function(){
                $('#NotifikasiHapusScreening').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusScreening.php',
                    data        :   {id_kunjungan: id_kunjungan},
                    success     :   function(data){
                        $('#NotifikasiHapusScreening').html(data);
                        var NotifikasiHapusScreeningBerhasil=$('#NotifikasiHapusScreeningBerhasil').html();
                        if(NotifikasiHapusScreeningBerhasil=="Success"){
                            $('#ModalHapusScreening').modal('hide');
                            $('#DetailScreening').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailScreening.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailScreening').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Screening Pasien Berhasil',
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
//Modal Cetak Screening
$('#ModalCetakScreening').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakScreening').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakScreening.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakScreening').html(data);
        }
    });
});
//DIAGNOSA
$('#DetailDiagnosa').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/DetailDiagnosa.php',
    data        : {id_kunjungan: GetIdKunjungan},
    success     : function(data){
        $('#DetailDiagnosa').html(data);
    }
});
//Modal Tambah Diagnosa
$('#ModalTambahDiagnosa').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahDiagnosa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahDiagnosa.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahDiagnosa').html(data);
            //ketika Diagnosa di ketik
            $('#diagnosa').keyup(function(){
                var diagnosa = $('#diagnosa').val();
                var referensi= $('#referensi').val();
                var panjang = diagnosa.length;
                if(panjang>3){
                    $('#DiagnosaList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariDiagnosaList3.php',
                        data        :   {diagnosa: diagnosa, referensi: referensi},
                        success     : function(data){
                            $('#DiagnosaList').html(data);
                        }
                    });
                }
            });
        }
    });
});
//Proses Tambah Diagnosa
$('#ProsesTambahDiagnosa').submit(function(){
    var ProsesTambahDiagnosa = $('#ProsesTambahDiagnosa').serialize();
    $('#NotifikasiTambahDiagnosa').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahDiagnosa.php',
        data        :   ProsesTambahDiagnosa,
        success     :   function(data){
            $('#NotifikasiTambahDiagnosa').html(data);
            var NotifikasiTambahDiagnosaBerhasil=$('#NotifikasiTambahDiagnosaBerhasil').html();
            if(NotifikasiTambahDiagnosaBerhasil=="Success"){
                $('#ModalTambahDiagnosa').modal('hide');
                $('#DetailDiagnosa').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailDiagnosa.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailDiagnosa').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Diagnosa Pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Info Diagnosa
$('#ModalInfoDiagnosa').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var id_diagnosis_pasien = pecah[1];
    $('#FormInfoDiagnosa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormInfoDiagnosa.php',
        data        :{id_kunjungan: id_kunjungan, id_diagnosis_pasien: id_diagnosis_pasien},
        success     : function(data){
            $('#FormInfoDiagnosa').html(data);
        }
    });
});
//Modal Edit Diagnosa
$('#ModalEditDiagnosa').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var id_diagnosis_pasien = pecah[1];
    $('#FormEditDiagnosa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditDiagnosa.php',
        data        :{id_diagnosis_pasien: id_diagnosis_pasien},
        success     : function(data){
            $('#FormEditDiagnosa').html(data);
            //ketika Diagnosa di ketik
            $('#diagnosa').keyup(function(){
                var diagnosa = $('#diagnosa').val();
                var referensi= $('#referensi').val();
                var panjang = diagnosa.length;
                if(panjang>3){
                    $('#DiagnosaList').html('<option value="Loading..">');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/CariDiagnosaList3.php',
                        data        :   {diagnosa: diagnosa, referensi: referensi},
                        success     : function(data){
                            $('#DiagnosaList').html(data);
                        }
                    });
                }
            });
        }
    });
});
//Proses Edit Diagnosa
$('#ProsesEditDiagnosa').submit(function(){
    var ProsesEditDiagnosa = $('#ProsesEditDiagnosa').serialize();
    $('#NotifikasiEditDiagnosa').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditDiagnosa.php',
        data        :   ProsesEditDiagnosa,
        success     :   function(data){
            $('#NotifikasiEditDiagnosa').html(data);
            var NotifikasiEditDiagnosaBerhasil=$('#NotifikasiEditDiagnosaBerhasil').html();
            if(NotifikasiEditDiagnosaBerhasil=="Success"){
                $('#ModalEditDiagnosa').modal('hide');
                $('#DetailDiagnosa').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailDiagnosa.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailDiagnosa').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Diagnosa Pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Diagnosa
$('#ModalHapusDiagnosa').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var id_diagnosis_pasien = pecah[1];
    $('#FormHapusDiagnosa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusDiagnosa.php',
        data        :{id_diagnosis_pasien: id_diagnosis_pasien},
        success     : function(data){
            $('#FormHapusDiagnosa').html(data);
            //Proses Hapus Diagnosa
            $('#ProsesHapusDiagnosa').submit(function(){
                $('#NotfikasiHapusDiagnosa').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusDiagnosa.php',
                    data        :   {id_diagnosis_pasien: id_diagnosis_pasien},
                    success     :   function(data){
                        $('#NotfikasiHapusDiagnosa').html(data);
                        var NotfikasiHapusDiagnosaBerhasil=$('#NotfikasiHapusDiagnosaBerhasil').html();
                        if(NotfikasiHapusDiagnosaBerhasil=="Success"){
                            $('#ModalHapusDiagnosa').modal('hide');
                            $('#DetailDiagnosa').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailDiagnosa.php',
                                data        : {id_kunjungan: id_kunjungan},
                                success     : function(data){
                                    $('#DetailDiagnosa').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Diagnosa Pasien Berhasil',
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
//PERSETUJUAN DAN PENOLAKAN TINDAKAN
$('#TampilkanPersetujuanTindakan').click(function(){
    $('#DetailPersetujuanTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailPersetujuanTindakan.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#DetailPersetujuanTindakan').html(data);
        }
    });
});
//Modal Tambah Persetujuan Tindakan
$('#ModalTambahPersetujuanTindakan').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahPersetujuanTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahPersetujuanTindakan.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahPersetujuanTindakan').html(data);
        }
    });
});
//Proses Tambah Persetujuan Tindakan
$('#ProsesTambahPersetujuanTindakan').submit(function(){
    var ProsesTambahPersetujuanTindakan = $('#ProsesTambahPersetujuanTindakan').serialize();
    $('#NotifikasiTambahPersetujuanTindakan').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahPersetujuanTindakan.php',
        data        :   ProsesTambahPersetujuanTindakan,
        success     :   function(data){
            $('#NotifikasiTambahPersetujuanTindakan').html(data);
            var NotifikasiTambahPersetujuanTindakanBerhasil=$('#NotifikasiTambahPersetujuanTindakanBerhasil').html();
            if(NotifikasiTambahPersetujuanTindakanBerhasil=="Success"){
                $('#ModalTambahPersetujuanTindakan').modal('hide');
                $('#DetailPersetujuanTindakan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPersetujuanTindakan.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailPersetujuanTindakan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Persetujuan Tindakan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Persetujuan Tindakan
$('#ModalEditPersetujuanTindakan').on('show.bs.modal', function (e) {
    var id_persetujuan_tindakan = $(e.relatedTarget).data('id');
    $('#FormEditPersetujuanTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditPersetujuanTindakan.php',
        data        :{id_persetujuan_tindakan: id_persetujuan_tindakan},
        success     : function(data){
            $('#FormEditPersetujuanTindakan').html(data);
        }
    });
});
//Proses Edit Persetujuan Tindakan
$('#ProsesEditPersetujuanTindakan').submit(function(){
    var ProsesEditPersetujuanTindakan = $('#ProsesEditPersetujuanTindakan').serialize();
    $('#NotifikasiEditPersetujuanTindakan').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditPersetujuanTindakan.php',
        data        :   ProsesEditPersetujuanTindakan,
        success     :   function(data){
            $('#NotifikasiEditPersetujuanTindakan').html(data);
            var NotifikasiEditPersetujuanTindakanBerhasil=$('#NotifikasiEditPersetujuanTindakanBerhasil').html();
            if(NotifikasiEditPersetujuanTindakanBerhasil=="Success"){
                $('#ModalEditPersetujuanTindakan').modal('hide');
                $('#DetailPersetujuanTindakan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPersetujuanTindakan.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailPersetujuanTindakan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Persetujuan Tindakan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Persetujuan Tindakan
$('#ModalHapusPersetujuanTindakan').on('show.bs.modal', function (e) {
    var id_persetujuan_tindakan = $(e.relatedTarget).data('id');
    $('#FormHapusPersetujuanTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusPersetujuanTindakan.php',
        data        :{id_persetujuan_tindakan: id_persetujuan_tindakan},
        success     : function(data){
            $('#FormHapusPersetujuanTindakan').html(data);
            //Proses Hapus Persetujuan Tindakan
            $('#ProsesHapusPersetujuanTindakan').submit(function(){
                $('#NotifikasiHapusPersetujuanTindakan').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusPersetujuanTindakan.php',
                    data        :   {id_persetujuan_tindakan: id_persetujuan_tindakan},
                    success     :   function(data){
                        $('#NotifikasiHapusPersetujuanTindakan').html(data);
                        var NotifikasiHapusPersetujuanTindakanBerhasil=$('#NotifikasiHapusPersetujuanTindakanBerhasil').html();
                        if(NotifikasiHapusPersetujuanTindakanBerhasil=="Success"){
                            $('#ModalHapusPersetujuanTindakan').modal('hide');
                            $('#DetailPersetujuanTindakan').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailPersetujuanTindakan.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailPersetujuanTindakan').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Persetujuan Tindakan Berhasil',
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
//Modal Cetak Persetujuan Tindakan
$('#ModalCetakPersetujuanTindakan').on('show.bs.modal', function (e) {
    var id_persetujuan_tindakan = $(e.relatedTarget).data('id');
    $('#FormCetakPersetujuanTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakPersetujuanTindakan.php',
        data        :{id_persetujuan_tindakan: id_persetujuan_tindakan},
        success     : function(data){
            $('#FormCetakPersetujuanTindakan').html(data);
        }
    });
});
//TINDAKAN
$('#TampilkanTindakan').click(function(){
    $('#DetailTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailTindakan.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#DetailTindakan').html(data);
        }
    });
});
//Modal Tambah Tindakan
$('#ModalTambahTindakan').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahTindakan.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahTindakan').html(data);
        }
    });
});
//Proses Tambah Persetujuan Tindakan
$('#ProsesTambahTindakan').submit(function(){
    var ProsesTambahTindakan = $('#ProsesTambahTindakan').serialize();
    $('#NotifikasiTambahTindakan').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahTindakan.php',
        data        :   ProsesTambahTindakan,
        success     :   function(data){
            $('#NotifikasiTambahTindakan').html(data);
            var NotifikasiTambahTindakanBerhasil=$('#NotifikasiTambahTindakanBerhasil').html();
            if(NotifikasiTambahTindakanBerhasil=="Success"){
                $('#ModalTambahTindakan').modal('hide');
                $('#DetailTindakan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailTindakan.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailTindakan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Tindakan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Info Tindakan
$('#ModalInfoTindakan').on('show.bs.modal', function (e) {
    var id_tindakan = $(e.relatedTarget).data('id');
    $('#FormInfoTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormInfoTindakan.php',
        data        :{id_tindakan: id_tindakan},
        success     : function(data){
            $('#FormInfoTindakan').html(data);
        }
    });
});
//Modal Edit Tindakan
$('#ModalEditTindakan').on('show.bs.modal', function (e) {
    var id_tindakan = $(e.relatedTarget).data('id');
    $('#FormEditTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditTindakan.php',
        data        :{id_tindakan: id_tindakan},
        success     : function(data){
            $('#FormEditTindakan').html(data);
        }
    });
});
//Proses Edit Tindakan
$('#ProsesEditTindakan').submit(function(){
    var ProsesEditTindakan = $('#ProsesEditTindakan').serialize();
    $('#NotifikasiEditTindakan').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditTindakan.php',
        data        :   ProsesEditTindakan,
        success     :   function(data){
            $('#NotifikasiEditTindakan').html(data);
            var NotifikasiEditTindakanBerhasil=$('#NotifikasiEditTindakanBerhasil').html();
            if(NotifikasiEditTindakanBerhasil=="Success"){
                $('#ModalEditTindakan').modal('hide');
                $('#DetailTindakan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailTindakan.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailTindakan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Tindakan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Tindakan
$('#ModalHapusTindakan').on('show.bs.modal', function (e) {
    var id_tindakan = $(e.relatedTarget).data('id');
    $('#FormHapusTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusTindakan.php',
        data        :{id_tindakan: id_tindakan},
        success     : function(data){
            $('#FormHapusTindakan').html(data);
            //Proses Hapus Tindakan
            $('#ProsesHapusTindakan').submit(function(){
                $('#NotifikasiHapusTindakan').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusTindakan.php',
                    data        :   {id_tindakan: id_tindakan},
                    success     :   function(data){
                        $('#NotifikasiHapusTindakan').html(data);
                        var NotifikasiHapusTindakanBerhasil=$('#NotifikasiHapusTindakanBerhasil').html();
                        if(NotifikasiHapusTindakanBerhasil=="Success"){
                            $('#ModalHapusTindakan').modal('hide');
                            $('#DetailTindakan').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailTindakan.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailTindakan').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Tindakan Berhasil',
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
//Modal Cetak Tindakan
$('#ModalCetakTindakan').on('show.bs.modal', function (e) {
    var id_tindakan = $(e.relatedTarget).data('id');
    $('#FormCetakTindakan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakTindakan.php',
        data        :{id_tindakan: id_tindakan},
        success     : function(data){
            $('#FormCetakTindakan').html(data);
        }
    });
});
//RESEP OBAT
$('#TampilkanResep').click(function(){
    $('#DetailResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailResep.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#DetailResep').html(data);
        }
    });
});
//Modal Tambah Resep
$('#ModalTambahResep').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahResep.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahResep').html(data);
        }
    });
});
//Proses Tambah Resep
$('#ProsesTambahResep').submit(function(){
    var ProsesTambahResep = $('#ProsesTambahResep').serialize();
    $('#NotifikasiTambahResep').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahResep.php',
        data        :   ProsesTambahResep,
        success     :   function(data){
            $('#NotifikasiTambahResep').html(data);
            var NotifikasiTambahResepBerhasil=$('#NotifikasiTambahResepBerhasil').html();
            if(NotifikasiTambahResepBerhasil=="Success"){
                $('#ModalTambahResep').modal('hide');
                $('#DetailResep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailResep.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailResep').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Resep Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Add Obat Resep
$('#ModalTambahObatResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormTambahObatResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahObatResep.php',
        data        :{id_resep: id_resep},
        success     : function(data){
            $('#FormTambahObatResep').html(data);
        }
    });
});
//Proses Tambah Obat Resep
$('#ProsesTambahObatResep').submit(function(){
    var ProsesTambahObatResep = $('#ProsesTambahObatResep').serialize();
    $('#NotifikasiTambahObatResep').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahObatResep.php',
        data        :   ProsesTambahObatResep,
        success     :   function(data){
            $('#NotifikasiTambahObatResep').html(data);
            var NotifikasiTambahObatResepBerhasil=$('#NotifikasiTambahObatResepBerhasil').html();
            if(NotifikasiTambahObatResepBerhasil=="Success"){
                $('#ModalTambahObatResep').modal('hide');
                $('#DetailResep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailResep.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailResep').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Obat Resep Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Info Obat Resep
$('#ModalInfoObatResep').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id = pecah[0];
    var id_resep = pecah[1];
    $('#FormInfoObatResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormInfoObatResep.php',
        data        :{id_resep: id_resep, id: id},
        success     : function(data){
            $('#FormInfoObatResep').html(data);
        }
    });
});
//Modal Hapus Obat Resep
$('#ModalHapusObatResep').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id = pecah[0];
    var id_resep = pecah[1];
    $('#FormHapusObatResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusObatResep.php',
        data        :{id_resep: id_resep, id: id},
        success     : function(data){
            $('#FormHapusObatResep').html(data);
            //Proses Hapus Obat
            $('#ProsesHapusObatResep').submit(function(){
                $('#NotifikasiHapusObatResep').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusObatResep.php',
                    data        :{id_resep: id_resep, id: id},
                    success     :   function(data){
                        $('#NotifikasiHapusObatResep').html(data);
                        var NotifikasiHapusObatResepBerhasil=$('#NotifikasiHapusObatResepBerhasil').html();
                        if(NotifikasiHapusObatResepBerhasil=="Success"){
                            $('#ModalHapusObatResep').modal('hide');
                            $('#DetailResep').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailResep.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailResep').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Obat Resep Berhasil',
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
//Modal Edit Obat Resep
$('#ModalEditObatResep').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id = pecah[0];
    var id_resep = pecah[1];
    $('#FormEditObatResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditObatResep.php',
        data        :{id_resep: id_resep, id: id},
        success     : function(data){
            $('#FormEditObatResep').html(data);
        }
    });
});
//Proses Edit Obat Resep
$('#ProsesEditObatResep').submit(function(){
    var ProsesEditObatResep = $('#ProsesEditObatResep').serialize();
    $('#NotifikasiEditObatResep').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditObatResep.php',
        data        :   ProsesEditObatResep,
        success     :   function(data){
            $('#NotifikasiEditObatResep').html(data);
            var NotifikasiEditObatResepBerhasil=$('#NotifikasiEditObatResepBerhasil').html();
            if(NotifikasiEditObatResepBerhasil=="Success"){
                $('#ModalEditObatResep').modal('hide');
                $('#DetailResep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailResep.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailResep').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Obat Resep Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Catatan Resep
$('#ModalEditCatatanResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormEditCatatanResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditCatatanResep.php',
        data        :{id_resep: id_resep},
        success     : function(data){
            $('#FormEditCatatanResep').html(data);
            $('#CatatanResep').summernote({
                height: 300,
            });
        }
    });
});
//Proses Edit Catatan Resep
$('#ProsesEditCatatanResep').submit(function(){
    var id_resep = $('#GetIdResep').val();
    var CatatanResep =  $('#CatatanResep').summernote('code');
    $('#NotifikasiEditCatatanResep').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditCatatanResep.php',
        data        :   {id_resep: id_resep, CatatanResep: CatatanResep},
        success     :   function(data){
            $('#NotifikasiEditCatatanResep').html(data);
            var NotifikasiEditCatatanResepBerhasil=$('#NotifikasiEditCatatanResepBerhasil').html();
            if(NotifikasiEditCatatanResepBerhasil=="Success"){
                $('#ModalEditCatatanResep').modal('hide');
                $('#DetailResep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailResep.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailResep').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Catatan Resep Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Pengkajian Resep Resep
$('#ModalPengkajianResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormPengkajianResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormPengkajianResep.php',
        data        :{id_resep: id_resep},
        success     : function(data){
            $('#FormPengkajianResep').html(data);
        }
    });
});
//Proses Pengkajian Resep
$('#ProsesPengkajianResep').submit(function(){
    var ProsesPengkajianResep = $('#ProsesPengkajianResep').serialize();
    $('#NotifikasiPengkajianResep').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesPengkajianResep.php',
        data        :   ProsesPengkajianResep,
        success     :   function(data){
            $('#NotifikasiPengkajianResep').html(data);
            var NotifikasiPengkajianResepBerhasil=$('#NotifikasiPengkajianResepBerhasil').html();
            if(NotifikasiPengkajianResepBerhasil=="Success"){
                $('#ModalPengkajianResep').modal('hide');
                $('#DetailResep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailResep.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailResep').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Pengkajian Resep Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Status Resep
$('#ModalStatusResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormStatusResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormStatusResep.php',
        data        :{id_resep: id_resep},
        success     : function(data){
            $('#FormStatusResep').html(data);
        }
    });
});
//Proses Status Resep
$('#ProsesStatusResep').submit(function(){
    var ProsesStatusResep = $('#ProsesStatusResep').serialize();
    $('#NotifikasiStatusResep').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesStatusResep.php',
        data        :   ProsesStatusResep,
        success     :   function(data){
            $('#NotifikasiStatusResep').html(data);
            var NotifikasiStatusResepBerhasil=$('#NotifikasiStatusResepBerhasil').html();
            if(NotifikasiStatusResepBerhasil=="Success"){
                $('#ModalStatusResep').modal('hide');
                $('#DetailResep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailResep.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailResep').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Ubah Status Resep Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Resep
$('#ModalHapusResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormHapusResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusResep.php',
        data        :{id_resep: id_resep},
        success     : function(data){
            $('#FormHapusResep').html(data);
            //Proses Hapus Resep
            $('#ProsesHapusResep').submit(function(){
                $('#NotifikasiHapusResep').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusResep.php',
                    data        :{id_resep: id_resep},
                    success     :   function(data){
                        $('#NotifikasiHapusResep').html(data);
                        var NotifikasiHapusResepBerhasil=$('#NotifikasiHapusResepBerhasil').html();
                        if(NotifikasiHapusResepBerhasil=="Success"){
                            $('#ModalHapusResep').modal('hide');
                            $('#DetailResep').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailResep.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailResep').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Resep Berhasil',
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
//Modal Edit Resep
$('#ModalEditResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormEditResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditResep.php',
        data        :{id_resep: id_resep},
        success     : function(data){
            $('#FormEditResep').html(data);
        }
    });
});
//Proses Edit Resep
$('#ProsesEditResep').submit(function(){
    var ProsesEditResep = $('#ProsesEditResep').serialize();
    $('#NotifikasiEditResep').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditResep.php',
        data        :   ProsesEditResep,
        success     :   function(data){
            $('#NotifikasiEditResep').html(data);
            var NotifikasiEditResepBerhasil=$('#NotifikasiEditResepBerhasil').html();
            if(NotifikasiEditResepBerhasil=="Success"){
                $('#ModalEditResep').modal('hide');
                $('#DetailResep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailResep.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailResep').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Resep Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Cetak Resep
$('#ModalCetakResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormCetakResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakResep.php',
        data        :{id_resep: id_resep},
        success     : function(data){
            $('#FormCetakResep').html(data);
        }
    });
});
//RIWAYAT OBAT
$('#TampilkanRiwayatObat').click(function(){
    $('#DetailRiwayatObat').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailRiwayatObat.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#DetailRiwayatObat').html(data);
        }
    });
});
//Modal Tamab Riwayat Penggunaan Obat
$('#ModalTambahRiwayatObat').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahRiwayatObat').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahRiwayatObat.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahRiwayatObat').html(data);
        }
    });
});
//Proses Tambah Riwayat Penggunaan Obat
$('#ProsesTambahRiwayatObat').submit(function(){
    var ProsesTambahRiwayatObat = $('#ProsesTambahRiwayatObat').serialize();
    $('#NotifikasiTambahRiwayatObat').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahRiwayatObat.php',
        data        :   ProsesTambahRiwayatObat,
        success     :   function(data){
            $('#NotifikasiTambahRiwayatObat').html(data);
            var NotifikasiTambahRiwayatObatBerhasil=$('#NotifikasiTambahRiwayatObatBerhasil').html();
            if(NotifikasiTambahRiwayatObatBerhasil=="Success"){
                $('#ModalTambahRiwayatObat').modal('hide');
                $('#DetailRiwayatObat').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailRiwayatObat.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailRiwayatObat').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Riwayat Penggunaan Obat Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Info Riwayat Penggunaan Obat
$('#ModalInfoRiwayatObat').on('show.bs.modal', function (e) {
    var id_riwayat_penggunaan_obat = $(e.relatedTarget).data('id');
    $('#FormInfoRiwayatObat').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormInfoRiwayatObat.php',
        data        :{id_riwayat_penggunaan_obat: id_riwayat_penggunaan_obat},
        success     : function(data){
            $('#FormInfoRiwayatObat').html(data);
        }
    });
});
//Modal Edit Riwayat Penggunaan Obat
$('#ModalEditRiwayatObat').on('show.bs.modal', function (e) {
    var id_riwayat_penggunaan_obat = $(e.relatedTarget).data('id');
    $('#FormEditRiwayatObat').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditRiwayatObat.php',
        data        :{id_riwayat_penggunaan_obat: id_riwayat_penggunaan_obat},
        success     : function(data){
            $('#FormEditRiwayatObat').html(data);
        }
    });
});
//Proses Edit Riwayat Penggunaan Obat
$('#ProsesEditRiwayatObat').submit(function(){
    var ProsesEditRiwayatObat = $('#ProsesEditRiwayatObat').serialize();
    $('#NotifikasiEditRiwayatObat').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditRiwayatObat.php',
        data        :   ProsesEditRiwayatObat,
        success     :   function(data){
            $('#NotifikasiEditRiwayatObat').html(data);
            var NotifikasiEditRiwayatObatBerhasil=$('#NotifikasiEditRiwayatObatBerhasil').html();
            if(NotifikasiEditRiwayatObatBerhasil=="Success"){
                $('#ModalEditRiwayatObat').modal('hide');
                $('#DetailRiwayatObat').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailRiwayatObat.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailRiwayatObat').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Riwayat Penggunaan Obat Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Riwayat Penggunaan Obat
$('#ModalHapusRiwayatObat').on('show.bs.modal', function (e) {
    var id_riwayat_penggunaan_obat = $(e.relatedTarget).data('id');
    $('#FormHapusRiwayatObat').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusRiwayatObat.php',
        data        :{id_riwayat_penggunaan_obat: id_riwayat_penggunaan_obat},
        success     : function(data){
            $('#FormHapusRiwayatObat').html(data);
            //Proses Hapus Riwayat Penggunaan Obat
            $('#ProsesHapusRiwayatObat').submit(function(){
                $('#NotifikasiHapusRiwayatObat').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusRiwayatObat.php',
                    data        :   {id_riwayat_penggunaan_obat: id_riwayat_penggunaan_obat},
                    success     :   function(data){
                        $('#NotifikasiHapusRiwayatObat').html(data);
                        var NotifikasiHapusRiwayatObatBerhasil=$('#NotifikasiHapusRiwayatObatBerhasil').html();
                        if(NotifikasiHapusRiwayatObatBerhasil=="Success"){
                            $('#ModalHapusRiwayatObat').modal('hide');
                            $('#DetailRiwayatObat').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailRiwayatObat.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailRiwayatObat').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Riwayat Penggunaan Obat Berhasil',
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
//Modal Cetak Riwayat Obat
$('#ModalCetakRiwayatObat').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakRiwayatObat').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakRiwayatObat.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakRiwayatObat').html(data);
        }
    });
});
//PERENCANAAN PASIEN
$('#TampilkanPerencanaanPasien').click(function(){
    $('#DetailPerencanaanPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailPerencanaanPasien.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#DetailPerencanaanPasien').html(data);
        }
    });
});
//Modal Tulis Perencanaan Pasien
$('#ModalTulisPerencanaanPasien').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_kunjungan = pecah[0];
    var kategori_perencanaan = pecah[1];
    $('#FormTulisPerencanaanPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTulisPerencanaanPasien.php',
        data        :{id_kunjungan: id_kunjungan, kategori_perencanaan: kategori_perencanaan},
        success     : function(data){
            $('#FormTulisPerencanaanPasien').html(data);
            $('#isi_perencanaan_pasien').summernote({
                height: 300,
            });
        }
    });
});
//Proses Tulis Perencanaan Pasien
$('#ProsesTulisPerencanaanPasien').submit(function(){
    var PutIdKunjunganPerencanaan = $('#PutIdKunjunganPerencanaan').val();
    var kategori_perencanaan = $('#kategori_perencanaan').val();
    var isi_perencanaan_pasien =  $('#isi_perencanaan_pasien').summernote('code');
    $('#NotifikasiTulisPerencanaanPasien').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTulisPerencanaanPasien.php',
        data        :   {id_kunjungan: PutIdKunjunganPerencanaan, kategori_perencanaan: kategori_perencanaan, isi_perencanaan_pasien: isi_perencanaan_pasien},
        success     :   function(data){
            $('#NotifikasiTulisPerencanaanPasien').html(data);
            var NotifikasiTulisPerencanaanPasienBerhasil=$('#NotifikasiTulisPerencanaanPasienBerhasil').html();
            if(NotifikasiTulisPerencanaanPasienBerhasil=="Success"){
                $('#ModalTulisPerencanaanPasien').modal('hide');
                $('#DetailPerencanaanPasien').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailPerencanaanPasien.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailPerencanaanPasien').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tulis Perencanaan Pasien Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Perencanaan pasien
$('#ModalHapusPerencanaan').on('show.bs.modal', function (e) {
    var id_perencanaan_pasien = $(e.relatedTarget).data('id');
    $('#FormHapusPerencanaan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusPerencanaan.php',
        data        :{id_perencanaan_pasien: id_perencanaan_pasien},
        success     : function(data){
            $('#FormHapusPerencanaan').html(data);
            //Proses Hapus Perencanaan
            $('#ProsesHapusPerencanaan').submit(function(){
                $('#NotifikasiHapusPerencanaan').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusPerencanaan.php',
                    data        :   {id_perencanaan_pasien: id_perencanaan_pasien},
                    success     :   function(data){
                        $('#NotifikasiHapusPerencanaan').html(data);
                        var NotifikasiHapusPerencanaanBerhasil=$('#NotifikasiHapusPerencanaanBerhasil').html();
                        if(NotifikasiHapusPerencanaanBerhasil=="Success"){
                            $('#ModalHapusPerencanaan').modal('hide');
                            $('#DetailPerencanaanPasien').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailPerencanaanPasien.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailPerencanaanPasien').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Perencanaan Pasien Berhasil',
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
//Modal Cetak Perencanaan Pasien
$('#ModalCetakPerencanaan').on('show.bs.modal', function (e) {
    var id_perencanaan_pasien = $(e.relatedTarget).data('id');
    $('#FormCetakPerencanaan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakPerencanaan.php',
        data        :{id_perencanaan_pasien: id_perencanaan_pasien},
        success     : function(data){
            $('#FormCetakPerencanaan').html(data);
        }
    });
});
//KONSULTASI
$('#TampilkanKonsultasi').click(function(){
    $('#DetailKonsultasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailKonsultasi.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#DetailKonsultasi').html(data);
        }
    });
});
//Modal Tambah Konsultasi
$('#ModalTambahKonsuiltasi').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormTambahKonsuiltasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahKonsuiltasi.php',
        data        :{id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormTambahKonsuiltasi').html(data);
        }
    });
});
//Proses Tambah Konsultasi
$('#ProsesTambahKonsuiltasi').submit(function(){
    var ProsesTambahKonsuiltasi = $('#ProsesTambahKonsuiltasi').serialize();
    $('#NotifikasiTambahKonsuiltasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahKonsuiltasi.php',
        data        :   ProsesTambahKonsuiltasi,
        success     :   function(data){
            $('#NotifikasiTambahKonsuiltasi').html(data);
            var NotifikasiTambahKonsuiltasiBerhasil=$('#NotifikasiTambahKonsuiltasiBerhasil').html();
            if(NotifikasiTambahKonsuiltasiBerhasil=="Success"){
                $('#ModalTambahKonsuiltasi').modal('hide');
                $('#DetailKonsultasi').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailKonsultasi.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailKonsultasi').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Konsultasi Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Permintaan Konsultasi
$('#ModalPermintaanKonsultasi').on('show.bs.modal', function (e) {
    var id_konsultasi = $(e.relatedTarget).data('id');
    $('#FormPermintaanKonsultasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormPermintaanKonsultasi.php',
        data        :   {id_konsultasi: id_konsultasi},
        success     : function(data){
            $('#FormPermintaanKonsultasi').html(data);
            $('#diagnosa_kerja').summernote({
                height: 300,
            });
            $('#ikhtisar_klinis').summernote({
                height: 300,
            });
            $('#konsul_diminta').summernote({
                height: 300,
            });
        }
    });
});
//Proses Simpan Permintaan Konsultasi
$('#ProsesPermintaanKonsuiltasi').submit(function(){
    var PutIdKonsultasi = $('#PutIdKonsultasi').val();
    var diagnosa_kerja =  $('#diagnosa_kerja').summernote('code');
    var ikhtisar_klinis =  $('#ikhtisar_klinis').summernote('code');
    var konsul_diminta =  $('#konsul_diminta').summernote('code');
    $('#NotifikasiPermintaanKonsultasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesPermintaanKonsuiltasi.php',
        data        :   {PutIdKonsultasi: PutIdKonsultasi, diagnosa_kerja: diagnosa_kerja, ikhtisar_klinis: ikhtisar_klinis, konsul_diminta: konsul_diminta},
        success     :   function(data){
            $('#NotifikasiPermintaanKonsultasi').html(data);
            var NotifikasiPermintaanKonsultasiBerhasil=$('#NotifikasiPermintaanKonsultasiBerhasil').html();
            if(NotifikasiPermintaanKonsultasiBerhasil=="Success"){
                $('#ModalPermintaanKonsultasi').modal('hide');
                $('#DetailKonsultasi').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailKonsultasi.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailKonsultasi').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Ubah Permintaan Konsultasi Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Jawaban Konsultasi
$('#ModalJawabanKonsultasi').on('show.bs.modal', function (e) {
    var id_konsultasi = $(e.relatedTarget).data('id');
    $('#FormJawabanKonsultasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormJawabanKonsultasi.php',
        data        :   {id_konsultasi: id_konsultasi},
        success     : function(data){
            $('#FormJawabanKonsultasi').html(data);
            $('#penemuan').summernote({
                height: 300,
            });
            $('#diagnosa').summernote({
                height: 300,
            });
            $('#saran').summernote({
                height: 300,
            });
        }
    });
});
//Proses Simpan Jawaban Konsultasi
$('#ProsesJawabanKonsultasi').submit(function(){
    var PutIdKonsultasi = $('#PutIdKonsultasi').val();
    var tanggal_jawaban = $('#tanggal_jawaban').val();
    var jam_jawaban = $('#jam_jawaban').val();
    var penemuan =  $('#penemuan').summernote('code');
    var diagnosa =  $('#diagnosa').summernote('code');
    var saran =  $('#saran').summernote('code');
    $('#NotifikasiJawabanKonsultasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesJawabanKonsultasi.php',
        data        :   {PutIdKonsultasi: PutIdKonsultasi, tanggal_jawaban: tanggal_jawaban, jam_jawaban: jam_jawaban, penemuan: penemuan, diagnosa: diagnosa, saran: saran},
        success     :   function(data){
            $('#NotifikasiJawabanKonsultasi').html(data);
            var NotifikasiJawabanKonsultasiBerhasil=$('#NotifikasiJawabanKonsultasiBerhasil').html();
            if(NotifikasiJawabanKonsultasiBerhasil=="Success"){
                $('#ModalJawabanKonsultasi').modal('hide');
                $('#DetailKonsultasi').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailKonsultasi.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailKonsultasi').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Ubah Jawaban Konsultasi Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Konsultasi
$('#ModalHapusKonsultasi').on('show.bs.modal', function (e) {
    var id_konsultasi = $(e.relatedTarget).data('id');
    $('#FormHapusKonsultasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormHapusKonsultasi.php',
        data        :{id_konsultasi: id_konsultasi},
        success     : function(data){
            $('#FormHapusKonsultasi').html(data);
            //Proses Hapus Perencanaan
            $('#ProsesHapusKonsultasi').submit(function(){
                $('#NotifikasiHapusKonsultasi').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusKonsultasi.php',
                    data        :   {id_konsultasi: id_konsultasi},
                    success     :   function(data){
                        $('#NotifikasiHapusKonsultasi').html(data);
                        var NotifikasiHapusKonsultasiBerhasil=$('#NotifikasiHapusKonsultasiBerhasil').html();
                        if(NotifikasiHapusKonsultasiBerhasil=="Success"){
                            $('#ModalHapusKonsultasi').modal('hide');
                            $('#DetailKonsultasi').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/DetailKonsultasi.php',
                                data        : {id_kunjungan: GetIdKunjungan},
                                success     : function(data){
                                    $('#DetailKonsultasi').html(data);
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Konsultasi Berhasil',
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
//Modal Cetak Konsultasi
$('#ModalCetakKonsultasi').on('show.bs.modal', function (e) {
    var id_konsultasi = $(e.relatedTarget).data('id');
    $('#FormCetakKonsultasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakKonsultasi.php',
        data        :   {id_konsultasi: id_konsultasi},
        success     : function(data){
            $('#FormCetakKonsultasi').html(data);
        }
    });
});
//Modal Edit Konsultasi
$('#ModalEditKonsultasi').on('show.bs.modal', function (e) {
    var id_konsultasi = $(e.relatedTarget).data('id');
    $('#FormEditKonsultasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormEditKonsultasi.php',
        data        :{id_konsultasi: id_konsultasi},
        success     : function(data){
            $('#FormEditKonsultasi').html(data);
        }
    });
});
//Proses Edit Konsultasi
$('#ProsesEditKonsultasi').submit(function(){
    var ProsesEditKonsultasi = $('#ProsesEditKonsultasi').serialize();
    $('#NotifikasiEditKonsuiltasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesEditKonsultasi.php',
        data        :   ProsesEditKonsultasi,
        success     :   function(data){
            $('#NotifikasiEditKonsuiltasi').html(data);
            var NotifikasiEditKonsultasiBerhasil=$('#NotifikasiEditKonsultasiBerhasil').html();
            if(NotifikasiEditKonsultasiBerhasil=="Success"){
                $('#ModalEditKonsultasi').modal('hide');
                $('#DetailKonsultasi').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/DetailKonsultasi.php',
                    data        : {id_kunjungan: GetIdKunjungan},
                    success     : function(data){
                        $('#DetailKonsultasi').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Konsultasi Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//EDUKASI
$('#TampilkanEdukasi').click(function(){
    $('#DetailEdukasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailEdukasi.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#DetailEdukasi').html(data);
        }
    });
});
//Modal Kelola Edukasi
$('#ModalKelolaEdukasi').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormKelolaEdukasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormKelolaEdukasi.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormKelolaEdukasi').html(data);
        }
    });
});
//Ketika pertama kali halaman edukasi di inisiasi
var GetIdKunjunganEdukasi=$('#GetIdKunjunganEdukasi').val();
$('#KontenEdukasi').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/ListEdukasi.php',
    data        : {id_kunjungan: GetIdKunjunganEdukasi},
    success     : function(data){
        $('#KontenEdukasi').html(data);
        $("#ListEdukasi").removeClass("btn-outline-dark");
        $("#ListEdukasi").addClass("btn-dark");
    }
});
//Klik Tambah Edukasi
$('#TambahEdukasi').click(function(){
    $('#KontenEdukasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahEdukasi.php',
        data        : {id_kunjungan: GetIdKunjunganEdukasi},
        success     : function(data){
            $('#KontenEdukasi').html(data);
            $("#ListEdukasi").removeClass("btn-dark");
            $("#ListEdukasi").addClass("btn-outline-dark");
            $("#TambahEdukasi").removeClass("btn-outline-dark");
            $("#TambahEdukasi").addClass("btn-dark");
            $('#materi_edukasi').summernote({
                height: 300,
            });
        }
    });
});
//Klik Tambah Edukasi
$('#ListEdukasi').click(function(){
    $('#KontenEdukasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ListEdukasi.php',
        data        : {id_kunjungan: GetIdKunjunganEdukasi},
        success     : function(data){
            $('#KontenEdukasi').html(data);
            $("#ListEdukasi").removeClass("btn-outline-dark");
            $("#ListEdukasi").addClass("btn-dark");
            $("#TambahEdukasi").removeClass("btn-dark");
            $("#TambahEdukasi").addClass("btn-outline-dark");
        }
    });
});
//Modal Edit Edukasi
$('#ModalEditEdukasi').on('show.bs.modal', function (e) {
    var id_edukasi = $(e.relatedTarget).data('id');
    $('#FormKonfirmasiEditEdukasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/FormKonfirmasiEditEdukasi.php',
        data        :   {id_edukasi: id_edukasi},
        success     :   function(data){
            $('#FormKonfirmasiEditEdukasi').html(data);
            $('#SetujuEditEdukasi').click(function(){
                $('#KontenEdukasi').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormEditEdukasi.php',
                    data        : {id_edukasi: id_edukasi},
                    success     : function(data){
                        $('#KontenEdukasi').html(data);
                        $('#materi_edukasi').summernote({
                            height: 300,
                        });
                    }
                });
                $('#ModalEditEdukasi').modal('hide');
                $("#ListEdukasi").removeClass("btn-dark");
                $("#ListEdukasi").addClass("btn-outline-dark");
                $("#TambahEdukasi").removeClass("btn-dark");
                $("#TambahEdukasi").addClass("btn-outline-dark");
            });
        }
    });
});
//Modal Hapus Edukasi
$('#ModalHapusEdukasi').on('show.bs.modal', function (e) {
    var id_edukasi = $(e.relatedTarget).data('id');
    $('#FormHapusEdukasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/FormHapusEdukasi.php',
        data        :   {id_edukasi: id_edukasi},
        success     :   function(data){
            $('#FormHapusEdukasi').html(data);
            //Proses Hapus Edukasi
            $('#ProsesHapusEdukasi').submit(function(){
                $('#NotifikasiHapusEdukasi').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusEdukasi.php',
                    data        :   {id_edukasi: id_edukasi},
                    success     :   function(data){
                        $('#NotifikasiHapusEdukasi').html(data);
                        var NotifikasiHapusEdukasiBerhasil=$('#NotifikasiHapusEdukasiBerhasil').html();
                        if(NotifikasiHapusEdukasiBerhasil=="Success"){
                            $('#ModalHapusEdukasi').modal('hide');
                            $('#KontenEdukasi').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ListEdukasi.php',
                                data        : {id_kunjungan: GetIdKunjunganEdukasi},
                                success     : function(data){
                                    $('#KontenEdukasi').html(data);
                                    $("#ListEdukasi").removeClass("btn-outline-dark");
                                    $("#ListEdukasi").addClass("btn-dark");
                                    $("#TambahEdukasi").removeClass("btn-dark");
                                    $("#TambahEdukasi").addClass("btn-outline-dark");
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Edukasi Berhasil',
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
//Modal Cetak Edukasi Parsial
$('#ModalCetakEdukasiParsial').on('show.bs.modal', function (e) {
    var id_edukasi = $(e.relatedTarget).data('id');
    $('#FormCetakEdukasiParsial').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakEdukasiParsial.php',
        data        :   {id_edukasi: id_edukasi},
        success     : function(data){
            $('#FormCetakEdukasiParsial').html(data);
        }
    });
});
//Modal Cetak Edukasi All
$('#ModalCetakEdukasiAll').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakEdukasiAll').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakEdukasiAll.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakEdukasiAll').html(data);
        }
    });
});
//CPPT
$('#TampilkanCCPT').click(function(){
    $('#DetailCCPT').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailCCPT.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#DetailCCPT').html(data);
        }
    });
});
//Modal Kelola CPPT
$('#ModalKelolaCppt').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormKelolaCppt').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormKelolaCppt.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormKelolaCppt').html(data);
        }
    });
});
var GetIdKunjunganCppt=$('#GetIdKunjunganCppt').val();
$('#KontenCPPT').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/ListCPPT.php',
    data        : {id_kunjungan: GetIdKunjunganCppt},
    success     : function(data){
        $('#KontenCPPT').html(data);
        $("#ListCPPT").removeClass("btn-outline-dark");
        $("#ListCPPT").addClass("btn-dark");
    }
});
//Klik Tambah CPPT
$('#TambahCPPT').click(function(){
    $('#KontenCPPT').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormTambahCPPT.php',
        data        : {id_kunjungan: GetIdKunjunganCppt},
        success     : function(data){
            $('#KontenCPPT').html(data);
            $("#ListCPPT").removeClass("btn-dark");
            $("#ListCPPT").addClass("btn-outline-dark");
            $("#TambahCPPT").removeClass("btn-outline-dark");
            $("#TambahCPPT").addClass("btn-dark");
            $('#subjective').summernote({
                height: 200,
            });
            $('#objective').summernote({
                height: 200,
            });
            $('#assessment').summernote({
                height: 200,
            });
            $('#plan').summernote({
                height: 200,
            });
            $('#catatan').summernote({
                height: 200,
            });
        }
    });
});
//Klik List CPPT
$('#ListCPPT').click(function(){
    $('#KontenCPPT').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ListCPPT.php',
        data        : {id_kunjungan: GetIdKunjunganCppt},
        success     : function(data){
            $('#KontenCPPT').html(data);
            $("#ListCPPT").removeClass("btn-outline-dark");
            $("#ListCPPT").addClass("btn-dark");
            $("#TambahCPPT").removeClass("btn-dark");
            $("#TambahCPPT").addClass("btn-outline-dark");
        }
    });
});
//Modal Pencarian Dokter DPJP
$('#ModalCariDokter').on('show.bs.modal', function (e) {
    var KeywordPencarianDokterBpjp =$('#KeywordPencarianDokterBpjp').val();
    $('#HasilPencarianDokterDpjp').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/HasilPencarianDokterDpjp.php',
        data        :   {keyword: KeywordPencarianDokterBpjp},
        success     : function(data){
            $('#HasilPencarianDokterDpjp').html(data);
            //Ketika Dilakukan Proses Pencarian
            $('#ProsesCariDokter').submit(function(){
                var KeywordPencarianDokterBpjp =$('#KeywordPencarianDokterBpjp').val();
                $('#HasilPencarianDokterDpjp').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/HasilPencarianDokterDpjp.php',
                    data        : {keyword: KeywordPencarianDokterBpjp},
                    success     : function(data){
                        $('#HasilPencarianDokterDpjp').html(data);
                    }
                });
            });
        }
    });
});
//Modal Pencarian Nakes
$('#ModalCariNakesCppt').on('show.bs.modal', function (e) {
    var KeywordCariNakes =$('#KeywordCariNakes').val();
    $('#HasilPencarianNakesCppt').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/HasilPencarianNakesCppt.php',
        data        :   {keyword: KeywordCariNakes},
        success     : function(data){
            $('#HasilPencarianNakesCppt').html(data);
            //Ketika Dilakukan Proses Pencarian
            $('#ProsesCariNakes').submit(function(){
                var KeywordCariNakes =$('#KeywordCariNakes').val();
                $('#HasilPencarianNakesCppt').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/HasilPencarianNakesCppt.php',
                    data        : {keyword: KeywordCariNakes},
                    success     : function(data){
                        $('#HasilPencarianNakesCppt').html(data);
                    }
                });
            });
        }
    });
});
//Modal Cari Referensi Soap
$('#ModalCariReferensiSoap').on('show.bs.modal', function (e) {
    $('#FormCariReferensiSoap').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCariReferensiSoap.php',
        data        :   {id_kunjungan: GetIdKunjunganCppt},
        success     : function(data){
            $('#FormCariReferensiSoap').html(data);
        }
    });
});
//Modal Hapus Cppt
$('#ModalHapusCppt').on('show.bs.modal', function (e) {
    var id_cppt = $(e.relatedTarget).data('id');
    $('#FormHapusCppt').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/FormHapusCppt.php',
        data        :   {id_cppt: id_cppt},
        success     :   function(data){
            $('#FormHapusCppt').html(data);
            //Proses Hapus CPPT
            $('#ProsesHapusCppt').submit(function(){
                $('#NotifikasiHapusCppt').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusCppt.php',
                    data        :   {id_cppt: id_cppt},
                    success     :   function(data){
                        $('#NotifikasiHapusCppt').html(data);
                        var NotifikasiHapusCpptBerhasil=$('#NotifikasiHapusCpptBerhasil').html();
                        if(NotifikasiHapusCpptBerhasil=="Success"){
                            $('#ModalHapusCppt').modal('hide');
                            $('#KontenCPPT').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/ListCPPT.php',
                                data        : {id_kunjungan: GetIdKunjunganCppt},
                                success     : function(data){
                                    $('#KontenCPPT').html(data);
                                    $("#ListCPPT").removeClass("btn-outline-dark");
                                    $("#ListCPPT").addClass("btn-dark");
                                    $("#TambahCPPT").removeClass("btn-dark");
                                    $("#TambahCPPT").addClass("btn-outline-dark");
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus CPPT Berhasil',
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
//Modal Edit Cppt
$('#ModalEditCppt').on('show.bs.modal', function (e) {
    var id_cppt = $(e.relatedTarget).data('id');
    $('#FormEditCppt').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/FormKonfirmasiEditCppt.php',
        data        :   {id_cppt: id_cppt},
        success     :   function(data){
            $('#FormEditCppt').html(data);
            $('#SetujuEditCppt').click(function(){
                $('#KontenCPPT').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/FormEditCPPT.php',
                    data        : {id_cppt: id_cppt},
                    success     : function(data){
                        $('#KontenCPPT').html(data);
                        $("#ListCPPT").removeClass("btn-dark");
                        $("#ListCPPT").addClass("btn-outline-dark");
                        $("#TambahCPPT").removeClass("btn-dark");
                        $("#TambahCPPT").addClass("btn-outline-dark");
                        $('#subjective').summernote({
                            height: 200,
                        });
                        $('#objective').summernote({
                            height: 200,
                        });
                        $('#assessment').summernote({
                            height: 200,
                        });
                        $('#plan').summernote({
                            height: 200,
                        });
                        $('#catatan').summernote({
                            height: 200,
                        });
                    }
                });
                $('#ModalEditCppt').modal('hide');
            });
        }
    });
});
//Modal Cetak Cppt Parsial
$('#ModalCetakCpptParsial').on('show.bs.modal', function (e) {
    var id_cppt = $(e.relatedTarget).data('id');
    $('#FormCetakCpptParsial').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakCpptParsial.php',
        data        :   {id_cppt: id_cppt},
        success     : function(data){
            $('#FormCetakCpptParsial').html(data);
        }
    });
});
//Modal Cetak Cppt All
$('#ModalCetakCpptAll').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakCpptAll').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakCpptAll.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakCpptAll').html(data);
        }
    });
});
//OPERASI
$('#TampilkanOperasi').click(function(){
    $('#MenampilkanOperasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailOperasi.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanOperasi').html(data);
        }
    });
});
//Modal Kelola Operasi
$('#ModalKelolaOperasi').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormKelolaOperasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormKelolaOperasi.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormKelolaOperasi').html(data);
        }
    });
});
//Menampilkan Konten Operasi Pertama Kali
var GetIdKunjunganOperasi=$('#GetIdKunjunganOperasi').val();
//Modal Cari Jadwal Operasi
$('#ModalCariJadwalOperasi').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#ListJadwalOperasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/ListJadwalOperasi.php',
        data        :   {id_pasien: id_pasien},
        success     : function(data){
            $('#ListJadwalOperasi').html(data);
        }
    });
});
//Proses Tambah ID Jadwal Operasi
$('#ProsesTambahIdJadwalOperasi').submit(function(){
    var ProsesTambahIdJadwalOperasi = $('#ProsesTambahIdJadwalOperasi').serialize();
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahIdJadwalOperasi.php',
        data        :   ProsesTambahIdJadwalOperasi,
        success     :   function(data){
            $('#id_jadwal_operasi').val(data);
            $("#ListJadwalOperasi").html('');
            $('#ModalCariJadwalOperasi').modal('hide');
        }
    });
});
//Proses Tambah Nakes
$('#ProsesTambahNakesOperasi').submit(function(){
    var ProsesTambahNakesOperasi = $('#ProsesTambahNakesOperasi').serialize();
    $('#NotifikasiTambahNakesOperasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahNakesOperasi.php',
        data        :   ProsesTambahNakesOperasi,
        success     :   function(data){
            $('#FormListNakesOperasi').append(data);
            $("#ProsesTambahNakesOperasi").trigger("reset");
            $('#ModalTambahNakesOperasi').modal('hide');
            $('#NotifikasiTambahNakesOperasi').html('<span class="text-primary">Pastikan Informasi Nakes Operasi Sudah Lengkap Dan Benar!</span>');
        }
    });
});
//Modal Hapus Nakes Operasi
$('#ModalHapusNakesOperasi').on('show.bs.modal', function (e) {
    var button_id = $(e.relatedTarget).data('id');
    $('#KonfirmasiHapusNakesOperasi').click(function(){
        $('#BarisNakesOperasi'+button_id+'').remove();
        $('#ModalHapusNakesOperasi').modal('hide');
    });
});
//Pencarian Diagnosa Operasi
$('#PencarianDiagnosaOperasi').submit(function(){
    var PencarianDiagnosaOperasi = $('#PencarianDiagnosaOperasi').serialize();
    $('#HasilPencarianDiagnosaOperasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/HasilPencarianDiagnosaOperasi.php',
        data        :   PencarianDiagnosaOperasi,
        success     :   function(data){
            $('#HasilPencarianDiagnosaOperasi').html(data);
        }
    });
});
//Tambahkan Diagnosa Operasi
$('#TambahkanDiagnosaOperasi').click(function(){
    var PencarianDiagnosaOperasi = $('#PencarianDiagnosaOperasi').serialize();
    $('#NotifikasiTambahkanDiagnosaOperasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahkanDiagnosaOperasi.php',
        data        :   PencarianDiagnosaOperasi,
        success     :   function(data){
            $('#FormListDiagnosaOperasi').append(data);
            $("#PencarianDiagnosaOperasi").trigger("reset");
            $('#ModalTambahDiagnosaOperasi').modal('hide');
            $('#NotifikasiTambahkanDiagnosaOperasi').html('<span class="text-primary">Pasrikan anda sudah memilih diagnosa operasi.</span>');
        }
    });
});
//Modal Hapus Diagnosa Operasi
$('#ModalHapusDiagnosaOperasi').on('show.bs.modal', function (e) {
    var button_id = $(e.relatedTarget).data('id');
    $('#KonfirmasiHapusDiagnosaOperasi').click(function(){
        $('#BarisDiagnosaOperasi'+button_id+'').remove();
        $('#ModalHapusDiagnosaOperasi').modal('hide');
    });
});
//Pencarian Snomed Body Site
$('#body_site_operasi').keyup(function(){
    var body_site_operasi = $('#body_site_operasi').val();
    var characterCount = body_site_operasi.length;
    if(characterCount>3){
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/CariSnomedList.php',
            data        :   {keyword: body_site_operasi},
            success     :   function(data){
                $('#ListBodySiteOperasi').html(data);
            }
        });
    }
});
//Tambahkan Body Site
$('#ProsesTambahBodySite').submit(function(){
    var ProsesTambahBodySite = $('#ProsesTambahBodySite').serialize();
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahBodySiteOperasi.php',
        data        :   ProsesTambahBodySite,
        success     :   function(data){
            $('#FormListBodySiteOperasi').append(data);
            $("#ProsesTambahBodySite").trigger("reset");
            $('#ModalTambahBodySiteOperasi').modal('hide');
        }
    });
});
//Modal Hapus Body Site Operasi
$('#ModalHapusBodySiteOperasi').on('show.bs.modal', function (e) {
    var button_id = $(e.relatedTarget).data('id');
    $('#KonfirmasiHapusBodySiteOperasi').click(function(){
        $('#BarisBodySite'+button_id+'').remove();
        $('#ModalHapusBodySiteOperasi').modal('hide');
    });
});
//Pencarian Tindakan Operasi
$('#ProsesCariTindakanOperasi').submit(function(){
    var ProsesCariTindakanOperasi = $('#ProsesCariTindakanOperasi').serialize();
    $('#HasilPencarianTindakanOperasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/HasilPencarianTindakanOperasi.php',
        data        :   ProsesCariTindakanOperasi,
        success     :   function(data){
            $('#HasilPencarianTindakanOperasi').html(data);
        }
    });
});
//Tambahkan Tindakan Operasi
$('#TambahkanTindakanOperasi').click(function(){
    var ProsesCariTindakanOperasi = $('#ProsesCariTindakanOperasi').serialize();
    $('#NotifikasiTambahkanTindakanOperasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahkanTindakanOperasi.php',
        data        :   ProsesCariTindakanOperasi,
        success     :   function(data){
            $('#FormListTindakanOperasi').append(data);
            $("#ProsesCariTindakanOperasi").trigger("reset");
            $('#ModalTambahTindakanOperasi').modal('hide');
            $('#NotifikasiTambahkanTindakanOperasi').html('<span class="text-primary">Pasrikan anda sudah memilih tindakan operasi.</span>');
        }
    });
});
//Modal Tindakan Operasi
$('#ModalHapusTindakanOperasi').on('show.bs.modal', function (e) {
    var button_id = $(e.relatedTarget).data('id');
    $('#KonfirmasiHapusTindakanOperasi').click(function(){
        $('#BarisTindakanOperasi'+button_id+'').remove();
        $('#ModalHapusTindakanOperasi').modal('hide');
    });
});
//Tambahkan Instrumen Operasi
$('#ProsesTambahInstrumenOperasi').submit(function(){
    var InstrumenOperasi = $('#InstrumenOperasi').val();
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahkanInstrumenOperasi.php',
        data        :   {InstrumenOperasi: InstrumenOperasi},
        success     :   function(data){
            $('#FormListInstrumenOperasi').append(data);
            $("#ProsesTambahInstrumenOperasi").trigger("reset");
            $('#ModalTambahInstrumenOperasi').modal('hide');
        }
    });
});
//Modal Hapus Instrumen Operasi
$('#ModalHapusInstrumenOperasi').on('show.bs.modal', function (e) {
    var button_id = $(e.relatedTarget).data('id');
    $('#KonfirmasiHapusInstrumenOperasi').click(function(){
        $('#BarisInstrumenOperasi'+button_id+'').remove();
        $('#ModalHapusInstrumenOperasi').modal('hide');
    });
});
//Tambahkan Keterangan Dokter Operasi
$('#ProsesTambahKeteranganDokter').submit(function(){
    var ProsesTambahKeteranganDokter = $('#ProsesTambahKeteranganDokter').serialize();
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahKeteranganDokter.php',
        data        :   ProsesTambahKeteranganDokter,
        success     :   function(data){
            $('#FormListKeteranganDokterOperasi').append(data);
            $("#ProsesTambahKeteranganDokter").trigger("reset");
            $('#ModalTambahKeteranganDokter').modal('hide');
        }
    });
});
//Modal Hapus Keterangan Dokter Operasi
$('#ModalHapusKeteranganDokterOperasi').on('show.bs.modal', function (e) {
    var button_id = $(e.relatedTarget).data('id');
    $('#KonfirmasiHapusTindakanDokterOperasi').click(function(){
        $('#BarisTindakanOperasi'+button_id+'').remove();
        $('#ModalHapusKeteranganDokterOperasi').modal('hide');
    });
});
//Kondisi Ketika Klik Ttd Penanggung Jawab
$('#AddTtdPenanggungJawabOperasi').click(function(){
    var PutIdKunjunganOperasi = $('#PutIdKunjunganOperasi').html();
    $('#FormTtdPenanggungJawab').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/FormTtdPenanggungJawab.php',
        data        :   {id_kunjungan: PutIdKunjunganOperasi},
        success     :   function(data){
            $('#FormTtdPenanggungJawab').html(data);
        }
    });
});
//Kondisi Ketika Click TTD Nakes Operasi
$(".AddTtdNakesOperasi").click(function() {
    var id_nakes_operasi = $(this).attr('value');
    var PutIdKunjunganOperasi = $('#PutIdKunjunganOperasi').html();
    $('#FormTtdNakesOperasi'+id_nakes_operasi+'').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/FormTtdNakesOperasi.php',
        data        :   {id_kunjungan: PutIdKunjunganOperasi, id_nakes_operasi: id_nakes_operasi},
        success     :   function(data){
            $('#FormTtdNakesOperasi'+id_nakes_operasi+'').html(data);
        }
    });
});
//Proses Tambah Status Operasi
$('#ProsesTambahStatusOperasi').submit(function(){
    var ProsesTambahStatusOperasi = $('#ProsesTambahStatusOperasi').serialize();
    $('#NotifikasiTambahStatusOperasi').html('Loading..');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesTambahStatusOperasi.php',
        data        :   ProsesTambahStatusOperasi,
        success     :   function(data){
            $('#NotifikasiTambahStatusOperasi').html(data);
            var NotifikasiTambahStatusOperasiBerhasil = $('#NotifikasiTambahStatusOperasiBerhasil').html();
            var UrlBackOperasi = $('#UrlBackOperasi').html();
            var UrlBackOperasi=UrlBackOperasi.replace(/&amp;/g, '&');
            if(NotifikasiTambahStatusOperasiBerhasil=="Success"){
                window.location.replace(UrlBackOperasi);
            }
        }
    });
});
//Modal Hapus Operasi
$('#ModalHapusOperasi').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormHapusOperasi').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/FormHapusOperasi.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     :   function(data){
            $('#FormHapusOperasi').html(data);
            //Proses Hapus Operasi
            $('#ProsesHapusOperasi').submit(function(){
                $('#NotifikasiHapusOperasi').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusOperasi.php',
                    data        :   {id_kunjungan: id_kunjungan},
                    success     :   function(data){
                        $('#NotifikasiHapusOperasi').html(data);
                        var NotifikasiHapusOperasiBerhasil=$('#NotifikasiHapusOperasiBerhasil').html();
                        var UrlBackOperasi = $('#UrlBackOperasi').html();
                        var UrlBackOperasi=UrlBackOperasi.replace(/&amp;/g, '&');
                        if(NotifikasiHapusOperasiBerhasil=="Success"){
                            window.location.replace(UrlBackOperasi);
                        }
                    }
                });
            });
        }
    });
});
//Modal Cetak Operasi
$('#ModalCetakOperasi').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakOperasi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakOperasi.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakOperasi').html(data);
        }
    });
});
//RESUME
$('#TampilkanResume').click(function(){
    $('#MenampilkanDetailResume').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailResume.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanDetailResume').html(data);
        }
    });
});
//Konfirmasi Buat Resume
$('#ModalKonfirmasiBuatResume').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormKonfirmasiBuatResume').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormKonfirmasiBuatResume.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormKonfirmasiBuatResume').html(data);
        }
    });
});
//Menampilkan Konten Resume Pertama Kali
var GetIdKunjunganResume=$('#GetIdKunjunganResume').val();
$('#KontenResume').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/RawatJalan/PreviewResume.php',
    data        : {id_kunjungan: GetIdKunjunganResume},
    success     : function(data){
        $('#KontenResume').html(data);
        $("#FormResume").removeClass("btn-secondary");
        $("#FormResume").addClass("btn-outline-secondary");
        $("#DetailResume").removeClass("btn-outline-secondary");
        $("#DetailResume").addClass("btn-secondary");
    }
});
//Klik Form Resume
$('#FormResume').click(function(){
    $('#KontenResume').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormResume.php',
        data        : {id_kunjungan: GetIdKunjunganResume},
        success     : function(data){
            $('#KontenResume').html(data);
            $("#FormResume").removeClass("btn-outline-secondary");
            $("#FormResume").addClass("btn-secondary");
            $("#DetailResume").removeClass("btn-secondary");
            $("#DetailResume").addClass("btn-outline-secondary");
            $('#evaluasi').summernote({
                height: 200,
            });
            $('#nasehat').summernote({
                height: 200,
            });
            $('#terapi_pulang').summernote({
                height: 200,
            });
        }
    });
});
//Klik Detail Preview Resume
$('#DetailResume').click(function(){
    $('#KontenResume').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/PreviewResume.php',
        data        : {id_kunjungan: GetIdKunjunganResume},
        success     : function(data){
            $('#KontenResume').html(data);
            $("#FormResume").removeClass("btn-secondary");
            $("#FormResume").addClass("btn-outline-secondary");
            $("#DetailResume").removeClass("btn-outline-secondary");
            $("#DetailResume").addClass("btn-secondary");
        }
    });
});
//Modal Pencarian Dokter Resume
$('#ModalCariDokterResume').on('show.bs.modal', function (e) {
    var KeywordPencarianDokterResume =$('#KeywordPencarianDokterResume').val();
    $('#HasilPencarianDokterResume').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/HasilPencarianDokterDpjp.php',
        data        :   {keyword: KeywordPencarianDokterResume},
        success     : function(data){
            $('#HasilPencarianDokterResume').html(data);
            //Ketika Dilakukan Proses Pencarian
            $('#ProsesCariDokterResume').submit(function(){
                var KeywordPencarianDokterResume =$('#KeywordPencarianDokterResume').val();
                $('#HasilPencarianDokterResume').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/HasilPencarianDokterDpjp.php',
                    data        : {keyword: KeywordPencarianDokterResume},
                    success     : function(data){
                        $('#HasilPencarianDokterResume').html(data);
                    }
                });
            });
        }
    });
});
//Modal Pencarian Surat Kontrol
$('#ModalCariSuratKontrol').on('show.bs.modal', function (e) {
    var nomor_kartu_bpjs = $(e.relatedTarget).data('id');
    //Masukan Ke form Pencarian
    $('#KeywordNomorKartuCariSuratKontrol').val(nomor_kartu_bpjs);
    var ProsesCariSuratKontrol = $('#ProsesCariSuratKontrol').serialize();
    $('#HasilPencarianSuratKontrol').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/HasilPencarianSuratKontrol.php',
        data        :   ProsesCariSuratKontrol,
        success     : function(data){
            $('#HasilPencarianSuratKontrol').html(data);
            //Ketika Dilakukan Proses Pencarian
            $('#ProsesCariSuratKontrol').submit(function(){
                var ProsesCariSuratKontrol = $('#ProsesCariSuratKontrol').serialize();
                $('#HasilPencarianSuratKontrol').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/HasilPencarianSuratKontrol.php',
                    data        :   ProsesCariSuratKontrol,
                    success     : function(data){
                        $('#HasilPencarianSuratKontrol').html(data);
                    }
                });
            });
        }
    });
});
//ICare
$('#ProsesBukaIcare').submit(function(){
    var ProsesBukaIcare = $('#ProsesBukaIcare').serialize();
    $('#ButtonIcare').html('Loading...');
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/ProsesBukaIcare.php',
        data        :   ProsesBukaIcare,
        success     :   function(data){
            $('#MenampilkanDataIcare').html(data);
            $('#ButtonIcare').html('<i class="ti ti-reload"></i> Generate Link');
        }
    });
});
//Modal Hapus Resume
$('#ModalHapusResume').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormHapusResume').html("Loading...");
    $.ajax({
        type 	    :   'POST',
        url 	    :   '_Page/RawatJalan/FormHapusResume.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     :   function(data){
            $('#FormHapusResume').html(data);
            //Proses Hapus CPPT
            $('#ProsesHapusResume').submit(function(){
                $('#NotifikasiHapusResume').html('Loading...');
                $.ajax({
                    type 	    :   'POST',
                    url 	    :   '_Page/RawatJalan/ProsesHapusResume.php',
                    data        :   {id_kunjungan: id_kunjungan},
                    success     :   function(data){
                        $('#NotifikasiHapusResume').html(data);
                        var NotifikasiHapusResumeBerhasil=$('#NotifikasiHapusResumeBerhasil').html();
                        if(NotifikasiHapusResumeBerhasil=="Success"){
                            $('#ModalHapusResume').modal('hide');
                            $('#KontenResume').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/RawatJalan/PreviewResume.php',
                                data        : {id_kunjungan: GetIdKunjunganResume},
                                success     : function(data){
                                    $('#KontenResume').html(data);
                                    $("#FormResume").removeClass("btn-secondary");
                                    $("#FormResume").addClass("btn-outline-secondary");
                                    $("#DetailResume").removeClass("btn-outline-secondary");
                                    $("#DetailResume").addClass("btn-secondary");
                                }
                            });
                            //Tampilkan Swal
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Resume Berhasil',
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
//Modal Cetak Resume
$('#ModalCetakResume').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormCetakResume').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormCetakResume.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormCetakResume').html(data);
        }
    });
});
//LABORATORIUM
$('#TampilkanDetailLaboratorium').click(function(){
    $('#MenampilkanDetailLaboratorium').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailLaboratorium.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanDetailLaboratorium').html(data);
        }
    });
});
//Konfirmasi Permintaan Pemeriksaan Laboratorium
$('#ModalKelolaLaboratorium').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormPermintaanLaboratorium').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormPermintaanLaboratorium.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormPermintaanLaboratorium').html(data);
        }
    });
});
//Modal Detail Pemeriksaan Lab
$('#ModalDetailPemeriksaanLab').on('show.bs.modal', function (e) {
    var id_permintaan = $(e.relatedTarget).data('id');
    $('#FormDetailPemeriksaanLab').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailPemeriksaanLab.php',
        data        :   {id_permintaan: id_permintaan},
        success     : function(data){
            $('#FormDetailPemeriksaanLab').html(data);
        }
    });
});
//RADIOLOGI
$('#TampilkanDetailRadiologi').click(function(){
    $('#MenampilkanDetailRadiologi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailRadiologi.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanDetailRadiologi').html(data);
        }
    });
});
//Form Pemeriksaan Radiologi
$('#ModalPemeriksaanRadiologi').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormPemeriksaanRadiologi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormPemeriksaanRadiologi.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormPemeriksaanRadiologi').html(data);
        }
    });
});
//Form Pemeriksaan Radiologi
$('#ModalDetailPemeriksaanRadiologi').on('show.bs.modal', function (e) {
    var id_rad = $(e.relatedTarget).data('id');
    $('#FormDetailPemeriksaanRadiologi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailPemeriksaanRadiologi.php',
        data        :   {id_rad: id_rad},
        success     : function(data){
            $('#FormDetailPemeriksaanRadiologi').html(data);
        }
    });
});
//SEP
$('#TampilkanDetailSep').click(function(){
    $('#MenampilkanDetailSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/DetailSep2.php',
        data        : {id_kunjungan: GetIdKunjungan},
        success     : function(data){
            $('#MenampilkanDetailSep').html(data);
        }
    });
});
//Konfirmasi Buat SEP
$('#ModalKonfirmasiBuatSep').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormKonfirmasiBuatSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormKonfirmasiBuatSep.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormKonfirmasiBuatSep').html(data);
        }
    });
});
//Konfirmasi Edit SEP
$('#ModalKonfirmasiEditSep').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormKonfirmasiEditSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormKonfirmasiEditSep.php',
        data        :   {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormKonfirmasiEditSep').html(data);
        }
    });
});
//Konfirmasi Detail SEP
$('#ModalKonfirmasiDetailSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#FormKonfirmasiDetailSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormKonfirmasiDetailSep.php',
        data        :   {sep: sep},
        success     : function(data){
            $('#FormKonfirmasiDetailSep').html(data);
        }
    });
});
//FORM SIGNATURE PAD
// script di dalam ini akan dijalankan pertama kali saat dokumen dimuat
document.addEventListener('DOMContentLoaded', function () {
    resizeCanvas();
})
//script ini berfungsi untuk menyesuaikan tanda tangan dengan ukuran canvas
function resizeCanvas() {
    var ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}
var canvas = document.getElementById('signature-pad');
context = canvas.getContext('2d');
function make_base(){
    var higthImg="100";
    var widthImg="100";
    base_image = new Image();
    base_image.src = 'https://initu.id/wp-content/uploads/2017/09/Keajaiban-Anatomi-Tubuh-Manusia-Jika-Anda-Mengerti-Maka-Tidak-Layak-Sombong.jpg';
    base_image.onload = function(){
        context.drawImage(base_image, 0, 0, higthImg, widthImg);
    }
}
// warna dasar signaturepad
var signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgba(255, 255, 255)',
});
// saat addImage
document.getElementById('addImage').addEventListener('click', function () {
    make_base();
});
//saat tombol clear diklik maka akan menghilangkan seluruh tanda tangan
document.getElementById('clear').addEventListener('click', function () {
    signaturePad.clear();
});
//saat tombol undo diklik maka akan mengembalikan tanda tangan sebelumnya
document.getElementById('undo').addEventListener('click', function () {
    var data = signaturePad.toData();
    if (data) {
        data.pop(); // remove the last dot or line
        signaturePad.fromData(data);
    }
});
//saat tombol change color diklik maka akan merubah warna pena
document.getElementById('change-color').addEventListener('click', function () {
    //jika warna pena biru maka buat menjadi hitam dan sebaliknya
    if(signaturePad.penColor == "rgba(0, 0, 255, 1)"){
        signaturePad.penColor = "rgba(0, 0, 0, 1)";
    }else{
        signaturePad.penColor = "rgba(0, 0, 255, 1)";
    }
})


