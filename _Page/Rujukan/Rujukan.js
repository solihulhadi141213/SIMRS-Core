$('#MenampilkanTabelRujukanInternal').load("_Page/Rujukan/TabelRujukanInternal.php");
$('#MenampilkanTabelRujukanKhusus').load("_Page/Rujukan/TabelRujukanKhusus.php");
//Batas dan Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelRujukanInternal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/TabelRujukanInternal.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelRujukanInternal').html(data);
        }
    });
});
//modal cari SEP
$('#ModalCariSep').on('show.bs.modal', function (e) {
    $('#FormPencarianSEP').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/FormPencarianSEP.php',
        success     : function(data){
            $('#FormPencarianSEP').html(data);
            //ketika melakukan pencarian SEp
            $('#ProsesPencarianSep').submit(function(){
                var ProsesPencarianSep = $('#ProsesPencarianSep').serialize();
                $('#FormPencarianSEP').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Rujukan/FormPencarianSEP.php',
                    data 	    :  ProsesPencarianSep,
                    success     : function(data){
                        $('#FormPencarianSEP').html(data);
                    }
                });
            });
        }
    });
});
$('#ModalPilihSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/KonfirmasiPilihSep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#KonfirmasiPilihSep').html(data);
            //KonfirmasiPilihSepYa
            $('#KonfirmasiPilihSepYa').click(function(){
                $('#noSep').val(sep);
                $('#ModalPilihSep').modal('toggle');
                $('#ModalCariSep').modal('toggle');
            });
        }
    });
});
//modal cari SEP
$('#ModalCariPpk').on('show.bs.modal', function (e) {
    $('#ProsesPencarianPpk').submit(function(){
        var ProsesPencarianPpk = $('#ProsesPencarianPpk').serialize();
        $('#FormPencarianPpk').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Rujukan/FormPencarianPpk.php',
            data 	    :  ProsesPencarianPpk,
            success     : function(data){
                $('#FormPencarianPpk').html(data);
            }
        });
    });
});
$('#ModalKonfirmasiPPK').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihPPK').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/KonfirmasiPilihPPK.php',
        data        : {kode: kode},
        success     : function(data){
            $('#KonfirmasiPilihPPK').html(data);
            //KonfirmasiPilihPPKYa
            $('#KonfirmasiPilihPPKYa').click(function(){
                $('#ppkDirujuk').val(kode);
                $('#ModalKonfirmasiPPK').modal('toggle');
                $('#ModalCariPpk').modal('toggle');
            });
        }
    });
});
//Pencarian Diagnosa
$('#ModalCariDiagnosa').on('show.bs.modal', function (e) {
    $('#PencarianDiagnosa').submit(function(){
        var PencarianDiagnosa = $('#PencarianDiagnosa').serialize();
        $('#FormPencarianDiagnosa').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Rujukan/FormPencarianDiagnosa.php',
            data 	    :  PencarianDiagnosa,
            success     : function(data){
                $('#FormPencarianDiagnosa').html(data);
            }
        });
    });
});
$('#ModalKonfirmasiDiagnosa').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihDiagnosa').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/KonfirmasiPilihDiagnosa.php',
        data        : {kode: kode},
        success     : function(data){
            $('#KonfirmasiPilihDiagnosa').html(data);
            //KonfirmasiPilihPPKYa
            $('#KonfirmasiPilihDiagnosaYa').click(function(){
                $('#diagRujukan').val(kode);
                $('#ModalKonfirmasiDiagnosa').modal('toggle');
                $('#ModalCariDiagnosa').modal('toggle');
            });
        }
    });
});

//Ketika select tipe rujukan
$('#tipeRujukan').change(function(){
    var TipeRujukan=$('#tipeRujukan').val();
    if(TipeRujukan=="2"){
        $('#poliRujukan').val('');
        $("#poliRujukan").attr("readonly", true); 
    }else{
        $("#poliRujukan").attr("readonly", false);
    }
});
//Pencarian Poli
$('#ModalCariPoli').on('show.bs.modal', function (e) {
    //Kondisi memilih polilinik
    $('#PilihPoliklinik').click(function(){
        $("#PilihPoliklinik").addClass("btn-primary");
        $("#PilihPoliklinik").removeClass("btn-secondary");
        $("#PilihSpesialistik").addClass("btn-secondary");
        $("#PilihSpesialistik").removeClass("btn-primary");
        $("#PilihSarana").addClass("btn-secondary");
        $("#PilihSarana").removeClass("btn-primary");
        //Add Halaman
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Rujukan/FormCariPoliklinik.php',
            success     : function(data){
                $('#FormPencarianPoli').html(data);
                //memulai pencarian poliklinik
                $('#ProsesPencarianPoliklinik').submit(function(){
                    var ProsesPencarianPoliklinik = $('#ProsesPencarianPoliklinik').serialize();
                    $('#FormPencarianPoli').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Rujukan/ProsesPencarianPoliklinik.php',
                        data 	    :  ProsesPencarianPoliklinik,
                        success     : function(data){
                            $('#FormPencarianPoli').html(data);
                        }
                    });
                });
            }
        });
    });
    //Kondisi memilih Spesialistik
    $('#PilihSpesialistik').click(function(){
        $("#PilihPoliklinik").addClass("btn-secondary");
        $("#PilihPoliklinik").removeClass("btn-primary");
        $("#PilihSpesialistik").addClass("btn-primary");
        $("#PilihSpesialistik").removeClass("btn-secondary");
        $("#PilihSarana").addClass("btn-secondary");
        $("#PilihSarana").removeClass("btn-primary");
        //menangkap tanggal dan kode ppk
        var ppkDirujuk=$('#ppkDirujuk').val();
        var tglRujukan=$('#tglRujukan').val();
        //Add Halaman
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Rujukan/FormCariSpesialistik.php',
            success     : function(data){
                $('#FormPencarianPoli').html(data);
                //menempelkan pada form
                $('#kodePpkRujukan').val(ppkDirujuk);
                $('#tanggalRujukan').val(tglRujukan);
                //memulai pencarian poliklinik
                $('#ProsesPencarianSpesialistik').submit(function(){
                    var ProsesPencarianSpesialistik = $('#ProsesPencarianSpesialistik').serialize();
                    $('#FormPencarianPoli').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Rujukan/ProsesPencarianSpesialistik.php',
                        data 	    :  ProsesPencarianSpesialistik,
                        success     : function(data){
                            $('#FormPencarianPoli').html(data);
                        }
                    });
                });

            }
        });
    });
    //Kondisi memilih Sarana
    $('#PilihSarana').click(function(){
        $("#PilihPoliklinik").addClass("btn-secondary");
        $("#PilihPoliklinik").removeClass("btn-primary");
        $("#PilihSpesialistik").addClass("btn-secondary");
        $("#PilihSpesialistik").removeClass("btn-primary");
        $("#PilihSarana").addClass("btn-primary");
        $("#PilihSarana").removeClass("btn-secondary");
        //menangkap tanggal dan kode ppk
        var ppkDirujuk=$('#ppkDirujuk').val();
        //Add Halaman
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Rujukan/FormCariSarana.php',
            success     : function(data){
                $('#FormPencarianPoli').html(data);
                //menempelkan pada form
                $('#kodePpkRujukan').val(ppkDirujuk);
                
                //memulai pencarian Sarana
                $('#ProsesPencarianSarana').submit(function(){
                    var ProsesPencarianSarana = $('#ProsesPencarianSarana').serialize();
                    $('#FormPencarianPoli').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Rujukan/ProsesPencarianSarana.php',
                        data 	    :  ProsesPencarianSarana,
                        success     : function(data){
                            $('#FormPencarianPoli').html(data);
                        }
                    });
                });
            }
        });
    });
});
$('#ModalKonfirmasiPoli').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('id');
    $('#KonfirmasiPilihPoli').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/KonfirmasiPilihPoli.php',
        data        : {kode: kode},
        success     : function(data){
            $('#KonfirmasiPilihPoli').html(data);
            //KonfirmasiPilihPPKYa
            $('#KonfirmasiPilihPoliYa').click(function(){
                $('#poliRujukan').val(kode);
                $('#ModalKonfirmasiPoli').modal('toggle');
                $('#ModalCariPoli').modal('toggle');
            });
        }
    });
});
//Proses Buat Rujukan
$('#ProsesBuatRujukan').submit(function(){
    var ProsesBuatRujukan = $('#ProsesBuatRujukan').serialize();
    $('#NotifikasiBuatRujukan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/ProsesBuatRujukan.php',
        data 	    :  ProsesBuatRujukan,
        success     : function(data){
            $('#NotifikasiBuatRujukan').html(data);
            var NotifikasiBuatRujukanBerhasil=$('#NotifikasiBuatRujukanBerhasil').html();
            if(NotifikasiBuatRujukanBerhasil=="Berhasil"){
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Buat Rujukan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//ketika dasar pencarian berubah
$('#SearchBy').change(function(){
    var SearchBy = $('#SearchBy').val();
    if(SearchBy=="NoKartu"){
        $('#DasarPencarianRujukan').html('No.Kartu');
    }else{
        if(SearchBy=="NoRujukan"){
            $('#DasarPencarianRujukan').html('No.Rujukan');
        }else{
            $('#DasarPencarianRujukan').html('Keyword');
        }
    }
});
//memulai pencarian rujukan BPJS
$('#ProsesPencarianRujukanBpjs').submit(function(){
    var ProsesPencarianRujukanBpjs = $('#ProsesPencarianRujukanBpjs').serialize();
    $('#MenampilkanTabelRujukanBpjs').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/ProsesPencarianRujukanBpjs.php',
        data 	    :  ProsesPencarianRujukanBpjs,
        success     : function(data){
            $('#MenampilkanTabelRujukanBpjs').html(data);
        }
    });
});
$('#ModalDetailRujukanInternal').on('show.bs.modal', function (e) {
    var id_rujukan = $(e.relatedTarget).data('id');
    $('#FormDetailRujukanInternal').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/FormDetailRujukanInternal.php',
        data        : {id_rujukan: id_rujukan},
        success     : function(data){
            $('#FormDetailRujukanInternal').html(data);
            $('#ModalKonfirmasiEditRujukan').on('show.bs.modal', function (e) {
                var IdRujukan = $(e.relatedTarget).data('id');
                $('#KonfirmasiEditRujukan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Rujukan/KonfirmasiEditRujukan.php',
                    data        : {IdRujukan: IdRujukan},
                    success     : function(data){
                        $('#KonfirmasiEditRujukan').html(data);
                    }
                });
            });
        }
    });
});
//Proses Edit Rujukan
$('#ProsesEditRujukan').submit(function(){
    var ProsesEditRujukan = $('#ProsesEditRujukan').serialize();
    $('#NotifikasiEditRujukan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/ProsesEditRujukan.php',
        data 	    :  ProsesEditRujukan,
        success     : function(data){
            $('#NotifikasiEditRujukan').html(data);
            var NotifikasiEditRujukanBerhasil=$('#NotifikasiEditRujukanBerhasil').html();
            if(NotifikasiEditRujukanBerhasil=="Berhasil"){
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Rujukan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
$('#ModalKonfirmasiHapusRujukan').on('show.bs.modal', function (e) {
    var noRujukan = $(e.relatedTarget).data('id');
    $('#KonfirmasiHapusRujukan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/KonfirmasiHapusRujukan.php',
        data        : {noRujukan: noRujukan},
        success     : function(data){
            $('#KonfirmasiHapusRujukan').html(data);
            $('#KonfirmasiHapusYa').click(function(){
                $('#NotifikasiHapusRujukan').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Rujukan/ProsesHapusRujukan.php',
                    data        : {noRujukan: noRujukan},
                    success     : function(data){
                        $('#NotifikasiHapusRujukan').html(data);
                        var NotifikasiHapusRujukanBerhasil=$('#NotifikasiHapusRujukanBerhasil').html();
                        if(NotifikasiHapusRujukanBerhasil=="Berhasil"){
                            window.location.replace("index.php?Page=Rujukan&Sub=RujukanInternal");
                        }
                    }
                });
            });
        }
    });
});

$('#ClickTampilkanDiagnosaDanProcedur').click(function(){
    $('#TampilkanDataDiagnosaDanProcedur').html('Loading...');
    var NoRujukanKhusus=$('#NoRujukan').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/TabelDiagnosaDanProcedur.php',
        data 	    :  {NoRujukanKhusus: NoRujukanKhusus},
        success     : function(data){
            $('#TampilkanDataDiagnosaDanProcedur').html(data);
        }
    });
});
$('#ModalCariDiagnosaProcedur').on('show.bs.modal', function (e) {
    var kategoriPencarian = $('#kategori').val();
    $('#FormPencarianDiagnosaProcedur').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/FormPencarianDiagnosaProcedur.php',
        data        : {kategoriPencarian: kategoriPencarian},
        success     : function(data){
            $('#FormPencarianDiagnosaProcedur').html(data);
            $('#ProsesPencarianProcedur').submit(function(){
                var ProsesPencarianProcedur = $('#ProsesPencarianProcedur').serialize();
                $('#HasilPencarianDiagnosaProcedur').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Rujukan/ProsesPencarianProcedur.php',
                    data 	    :  ProsesPencarianProcedur,
                    success     : function(data){
                        $('#HasilPencarianDiagnosaProcedur').html(data);
                    }
                });
            });
            $('#ProsesPencarianDiagnosa').submit(function(){
                var ProsesPencarianDiagnosa = $('#ProsesPencarianDiagnosa').serialize();
                $('#HasilPencarianDiagnosaProcedur').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Rujukan/ProsesPencarianDiagnosa.php',
                    data 	    :  ProsesPencarianDiagnosa,
                    success     : function(data){
                        $('#HasilPencarianDiagnosaProcedur').html(data);
                    }
                });
            });
        }
    });
});

$('#ClickTambahDiagnosaSekarang').click(function(){
    var NoRujukan = $('#NoRujukan').val();
    var kategori = $('#kategori').val();
    var kode = $('#kode').val();
    $('#NotifikasiTambahDiagnosaSekarang').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/ProsesTambahDiagnosa.php',
        data 	    :  {NoRujukan: NoRujukan, kategori: kategori, kode: kode},
        success     : function(data){
            $('#NotifikasiTambahDiagnosa').html(data);
            var NotifikasiTambahDiagnosasisBerhasil=$('#NotifikasiTambahDiagnosasisBerhasil').html();
            Swal.fire({
                title: 'Sipp!!',
                text: 'Tambah Diagnosa Berhasil',
                icon: 'success',
                confirmButtonText: 'Tutup'
            })
        }
    });
});
//Buat rujukan khusus
$('#ProsesBuatRujukanKhusus').submit(function(){
    var ProsesBuatRujukanKhusus = $('#ProsesBuatRujukanKhusus').serialize();
    $('#NotifikasiBuatRujukanKhusus').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Rujukan/ProsesBuatRujukanKhusus.php',
        data 	    :  ProsesBuatRujukanKhusus,
        success     : function(data){
            $('#NotifikasiBuatRujukanKhusus').html(data);
            var NotifikasiBuatRujukanKhususBerhasil=$('#NotifikasiBuatRujukanKhususBerhasil').html();
            if(NotifikasiBuatRujukanKhususBerhasil=="Berhasil"){
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Buat Rujukan Khusus Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});

