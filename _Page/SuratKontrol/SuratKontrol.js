$('#DataSuratKontrol').load("_Page/SuratKontrol/DataSuratKontrolNull.php");
$('#SuratKontrolInfo').click(function(){
    $('#SuratKontrolInfo').removeClass("btn-primary");
    $('#SuratKontrolInfo').addClass("btn-inverse");
    $('#BuatSuratKontrol').removeClass("btn-inverse");
    $('#BuatSuratKontrol').addClass("btn-primary");
    $('#DataSpiBpjs').removeClass("btn-inverse");
    $('#DataSpiBpjs').addClass("btn-primary");
    $('#DataSuratKontrol').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SuratKontrol/DataSuratKontrolNull.php',
        success     : function(data){
            $('#DataSuratKontrol').html(data);
        }
    });
});
//Memilih halaman
$('#BuatSuratKontrol').click(function(){
    $('#SuratKontrolInfo').removeClass("btn-inverse");
    $('#SuratKontrolInfo').addClass("btn-primary");
    $('#BuatSuratKontrol').removeClass("btn-primary");
    $('#BuatSuratKontrol').addClass("btn-inverse");
    $('#DataSpiBpjs').removeClass("btn-inverse");
    $('#DataSpiBpjs').addClass("btn-primary");
    $('#DataSuratKontrol').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SuratKontrol/BuatSuratKontrol.php',
        success     : function(data){
            $('#DataSuratKontrol').html(data);
            //Kondisi ketika memilih jenis kontrol
            $('#JenisKontrol').change(function(){
                var JenisKontrol = $('#JenisKontrol').val();
                $('#NoIdentitas').html("Loading...");
                if(JenisKontrol=="1"){
                    $('#NoIdentitas').load("_Page/SuratKontrol/FormNoKartu.php");
                }else{
                    $('#NoIdentitas').load("_Page/SuratKontrol/FormNoSep.php");
                }
            });
            //Kondisi ketika form sep di click
            //Modal Rencana Kontrol
            $('#ModalCariSep').on('show.bs.modal', function (e) {
                $('#FormCariSep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/FormCariSep.php',
                    success     : function(data){
                        $('#FormCariSep').html(data);
                        //Mencari SEP
                        $('#CariSep').submit(function(){
                            var keyword = $('#keyword').val();
                            $('#FormCariSep').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/SuratKontrol/FormCariSep.php',
                                data 	    :  {keyword: keyword},
                                success     : function(data){
                                    $('#FormCariSep').html(data);
                                }
                            });
                        });
                    }
                });
            });
            $('#ModalKonfirmasiPilihSep').on('show.bs.modal', function (e) {
                var sep = $(e.relatedTarget).data('id');
                $('#KonfirmasiPilihSep').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/KonfirmasiPilihSep.php',
                    data        : {sep: sep},
                    success     : function(data){
                        $('#KonfirmasiPilihSep').html(data);
                        //Proses Konfirmasi Pilih SEP
                        $('#KonfirmasiYaSep').click(function(){
                            $('#noSEP').val(sep);
                            $('#ModalKonfirmasiPilihSep').modal('toggle');
                            $('#ModalCariSep').modal('toggle');
                        });
                    }
                });
            });
            $('#ModalKonfirmasiPilihBpjs').on('show.bs.modal', function (e) {
                var BPJS = $(e.relatedTarget).data('id');
                $('#KonfirmasiPilihBpjs').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/KonfirmasiPilihBpjs.php',
                    data        : {BPJS: BPJS},
                    success     : function(data){
                        $('#KonfirmasiPilihBpjs').html(data);
                        //Proses Konfirmasi Pilih SEP
                        $('#KonfirmasiYaBPJS').click(function(){
                            $('#noKartu').val(BPJS);
                            $('#ModalKonfirmasiPilihBpjs').modal('toggle');
                            $('#ModalCariSep').modal('toggle');
                        });
                    }
                });
            });
            //Modal cari Poli
            $('#ModalCariPoli').on('show.bs.modal', function (e) {
                var JenisKontrol=$('#JenisKontrol').val();
                if(JenisKontrol=="1"){
                    var Nomor=$('#noKartu').val();
                }else{
                    var Nomor=$('#noSEP').val();
                }
                var tglRencanaKontrol=$('#tglRencanaKontrol').val();
                $('#FormCariPoli').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/FormCariPoli.php',
                    data 	    :  {JenisKontrol: JenisKontrol, Nomor: Nomor, tglRencanaKontrol: tglRencanaKontrol},
                    success     : function(data){
                        $('#FormCariPoli').html(data);
                    }
                });
            });
            $('#ModalKonfirmasiPilihPoli').on('show.bs.modal', function (e) {
                var kodePoli = $(e.relatedTarget).data('id');
                $('#KonfirmasiPilihPoli').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/KonfirmasiPilihPoli.php',
                    data        : {kodePoli: kodePoli},
                    success     : function(data){
                        $('#KonfirmasiPilihPoli').html(data);
                        //Proses Konfirmasi Pilih SEP
                        $('#KonfirmasiPilihPoliYa').click(function(){
                            $('#poliKontrol').val(kodePoli);
                            $('#ModalKonfirmasiPilihPoli').modal('toggle');
                            $('#ModalCariPoli').modal('toggle');
                        });
                    }
                });
            });
            $('#ModalCariDokter').on('show.bs.modal', function (e) {
                var JenisKontrol=$('#JenisKontrol').val();
                var poliKontrol=$('#poliKontrol').val();
                var tglRencanaKontrol=$('#tglRencanaKontrol').val();
                $('#FormCariDokter').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/FormCariDokter.php',
                    data 	    :  {JenisKontrol: JenisKontrol, poliKontrol: poliKontrol, tglRencanaKontrol: tglRencanaKontrol},
                    success     : function(data){
                        $('#FormCariDokter').html(data);
                    }
                });
            });
            $('#ModalKonfirmasiPilihDokter').on('show.bs.modal', function (e) {
                var KodeDokter = $(e.relatedTarget).data('id');
                $('#KonfirmasiPilihDokter').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/KonfirmasiPilihDokter.php',
                    data        : {KodeDokter: KodeDokter},
                    success     : function(data){
                        $('#KonfirmasiPilihDokter').html(data);
                        //Proses Konfirmasi Pilih SEP
                        $('#KonfirmasiPilihDokterYa').click(function(){
                            $('#kodeDokter').val(KodeDokter);
                            $('#ModalKonfirmasiPilihDokter').modal('toggle');
                            $('#ModalCariDokter').modal('toggle');
                        });
                    }
                });
            });
            $('#ProsesInsertRencanaKontrol').submit(function(){
                var ProsesInsertRencanaKontrol = $('#ProsesInsertRencanaKontrol').serialize();
                $('#NotifikasiInsertRencanaKontrol').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/ProsesInsertRencanaKontrol.php',
                    data 	    :  ProsesInsertRencanaKontrol,
                    success     : function(data){
                        $('#NotifikasiInsertRencanaKontrol').html(data);
                        var NotifikasiInsertRencanaKontrolBerhasil=$('#NotifikasiInsertRencanaKontrolBerhasil').html();
                        if(NotifikasiInsertRencanaKontrolBerhasil=="Berhasil"){
                            $('#ProsesInsertRencanaKontrol').trigger("reset");
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Tambah Data Surat Kontrol/SPRI Berhasil',
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
$('#DataSpiBpjs').click(function(){
    $('#SuratKontrolInfo').removeClass("btn-inverse");
    $('#SuratKontrolInfo').addClass("btn-primary");
    $('#BuatSuratKontrol').removeClass("btn-inverse");
    $('#BuatSuratKontrol').addClass("btn-primary");
    $('#DataSpiBpjs').removeClass("btn-primary");
    $('#DataSpiBpjs').addClass("btn-inverse");
    $('#DataSuratKontrol').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SuratKontrol/DataSpiBpjs.php',
        success     : function(data){
            $('#DataSuratKontrol').html(data);
            //proses pencarian surat kontrol
            $('#ProsesCariSuratKontrol').submit(function(){
                var ProsesCariSuratKontrol = $('#ProsesCariSuratKontrol').serialize();
                $('#MenampilkanPencarianSuratKontrol').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SuratKontrol/ProsesCariSuratKontrol.php',
                    data 	    :  ProsesCariSuratKontrol,
                    success     : function(data){
                        $('#MenampilkanPencarianSuratKontrol').html(data);
                    }
                });
                //Detail SPRi
                $('#ModalDetailSpri').on('show.bs.modal', function (e) {
                    var noSuratKontrol = $(e.relatedTarget).data('id');
                    $('#DetailSpri').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/SuratKontrol/DetailSpri.php',
                        data        : {noSuratKontrol: noSuratKontrol},
                        success     : function(data){
                            $('#DetailSpri').html(data);
                        }
                    });
                });
                //Detail SPRi
                $('#ModalHaspusSuratKontrol').on('show.bs.modal', function (e) {
                    var noSuratKontrol = $(e.relatedTarget).data('id');
                    $('#KonfirmasiHapusSuratKontrol').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/SuratKontrol/KonfirmasiHapusSuratKontrol.php',
                        data        : {noSuratKontrol: noSuratKontrol},
                        success     : function(data){
                            $('#KonfirmasiHapusSuratKontrol').html(data);
                            //Proses Hapus
                            $('#KonfirmasiHapusSuratKontrolYa').click(function(){
                                $('#NotifikasiHapusSuratKontrol').html('Loading....');
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/SuratKontrol/ProsesHapusSuratKontrol.php',
                                    data        : {noSuratKontrol: noSuratKontrol},
                                    success     : function(data){
                                        $('#NotifikasiHapusSuratKontrol').html(data);
                                        var NotifikasiHapusSuratKontrolBerhasil=$('#NotifikasiHapusSuratKontrolBerhasil').html();
                                        if(NotifikasiHapusSuratKontrolBerhasil=="Berhasil"){
                                            $('#ModalHaspusSuratKontrol').modal('hide');
                                            $('#ModalDetailSpri').modal('hide');
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/ProsesCariSuratKontrol.php',
                                                data 	    :  ProsesCariSuratKontrol,
                                                success     : function(data){
                                                    $('#MenampilkanPencarianSuratKontrol').html(data);
                                                    Swal.fire({
                                                        title: 'Good Job!',
                                                        text: 'Hapus Surat Kontrol Berhasil',
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
                //Edit SPRi
                $('#ModalEditSpri').on('show.bs.modal', function (e) {
                    var noSuratKontrol = $(e.relatedTarget).data('id');
                    $('#KonfirmasiEditSpri').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/SuratKontrol/KonfirmasiEditSpri.php',
                        data        : {noSuratKontrol: noSuratKontrol},
                        success     : function(data){
                            $('#KonfirmasiEditSpri').html(data);
                            //Memulai edit
                            $('#KonfirmasiEditYa').click(function(){
                                $('#SuratKontrolInfo').removeClass("btn-inverse");
                                $('#SuratKontrolInfo').addClass("btn-primary");
                                $('#BuatSuratKontrol').removeClass("btn-inverse");
                                $('#BuatSuratKontrol').addClass("btn-primary");
                                $('#DataSpiBpjs').removeClass("btn-inverse");
                                $('#DataSpiBpjs').addClass("btn-primary");
                                //Modal hide
                                $('#ModalEditSpri').modal("hide");
                                $('#ModalDetailSpri').modal("hide");
                                var noSuratKontrol=$('#GetNoSpri').html();
                                $('#DataSuratKontrol').html("Loading...");
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/SuratKontrol/EditSuratKontrol.php',
                                    data        : {noSuratKontrol: noSuratKontrol},
                                    success     : function(data){
                                        $('#DataSuratKontrol').html(data);
                                        //Kondisi ketika memilih jenis kontrol
                                        $('#JenisKontrol').change(function(){
                                            var JenisKontrol = $('#JenisKontrol').val();
                                            $('#NoIdentitas').html("Loading...");
                                            if(JenisKontrol=="1"){
                                                $('#NoIdentitas').html("");
                                            }else{
                                                $('#NoIdentitas').load("_Page/SuratKontrol/FormNoSep.php");
                                            }
                                        });
                                        //Kondisi ketika form sep di click
                                        //Modal Rencana Kontrol
                                        $('#ModalCariSep').on('show.bs.modal', function (e) {
                                            $('#FormCariSep').html("Loading...");
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/FormCariSep.php',
                                                success     : function(data){
                                                    $('#FormCariSep').html(data);
                                                    //Mencari SEP
                                                    $('#CariSep').submit(function(){
                                                        var keyword = $('#keyword').val();
                                                        $('#FormCariSep').html("Loading...");
                                                        $.ajax({
                                                            type 	    : 'POST',
                                                            url 	    : '_Page/SuratKontrol/FormCariSep.php',
                                                            data 	    :  {keyword: keyword},
                                                            success     : function(data){
                                                                $('#FormCariSep').html(data);
                                                            }
                                                        });
                                                    });
                                                }
                                            });
                                        });
                                        $('#ModalKonfirmasiPilihSep').on('show.bs.modal', function (e) {
                                            var sep = $(e.relatedTarget).data('id');
                                            $('#KonfirmasiPilihSep').html("Loading...");
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/KonfirmasiPilihSep.php',
                                                data        : {sep: sep},
                                                success     : function(data){
                                                    $('#KonfirmasiPilihSep').html(data);
                                                    //Proses Konfirmasi Pilih SEP
                                                    $('#KonfirmasiYaSep').click(function(){
                                                        $('#noSEP').val(sep);
                                                        $('#ModalKonfirmasiPilihSep').modal('toggle');
                                                        $('#ModalCariSep').modal('toggle');
                                                    });
                                                }
                                            });
                                        });
                                        $('#ModalKonfirmasiPilihBpjs').on('show.bs.modal', function (e) {
                                            var BPJS = $(e.relatedTarget).data('id');
                                            $('#KonfirmasiPilihBpjs').html("Loading...");
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/KonfirmasiPilihBpjs.php',
                                                data        : {BPJS: BPJS},
                                                success     : function(data){
                                                    $('#KonfirmasiPilihBpjs').html(data);
                                                    //Proses Konfirmasi Pilih SEP
                                                    $('#KonfirmasiYaBPJS').click(function(){
                                                        $('#noKartu').val(BPJS);
                                                        $('#ModalKonfirmasiPilihBpjs').modal('toggle');
                                                        $('#ModalCariSep').modal('toggle');
                                                    });
                                                }
                                            });
                                        });
                                        //Modal cari Poli
                                        $('#ModalCariPoli').on('show.bs.modal', function (e) {
                                            var JenisKontrol=$('#JenisKontrol').val();
                                            if(JenisKontrol=="1"){
                                                var Nomor=$('#noKartu').val();
                                            }else{
                                                var Nomor=$('#noSEP').val();
                                            }
                                            var tglRencanaKontrol=$('#tglRencanaKontrol').val();
                                            $('#FormCariPoli').html("Loading...");
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/FormCariPoli.php',
                                                data 	    :  {JenisKontrol: JenisKontrol, Nomor: Nomor, tglRencanaKontrol: tglRencanaKontrol},
                                                success     : function(data){
                                                    $('#FormCariPoli').html(data);
                                                }
                                            });
                                        });
                                        $('#ModalKonfirmasiPilihPoli').on('show.bs.modal', function (e) {
                                            var kodePoli = $(e.relatedTarget).data('id');
                                            $('#KonfirmasiPilihPoli').html("Loading...");
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/KonfirmasiPilihPoli.php',
                                                data        : {kodePoli: kodePoli},
                                                success     : function(data){
                                                    $('#KonfirmasiPilihPoli').html(data);
                                                    //Proses Konfirmasi Pilih SEP
                                                    $('#KonfirmasiPilihPoliYa').click(function(){
                                                        $('#poliKontrol').val(kodePoli);
                                                        $('#ModalKonfirmasiPilihPoli').modal('toggle');
                                                        $('#ModalCariPoli').modal('toggle');
                                                    });
                                                }
                                            });
                                        });
                                        $('#ModalCariDokter').on('show.bs.modal', function (e) {
                                            var JenisKontrol=$('#JenisKontrol').val();
                                            var poliKontrol=$('#poliKontrol').val();
                                            var tglRencanaKontrol=$('#tglRencanaKontrol').val();
                                            $('#FormCariDokter').html("Loading...");
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/FormCariDokter.php',
                                                data 	    :  {JenisKontrol: JenisKontrol, poliKontrol: poliKontrol, tglRencanaKontrol: tglRencanaKontrol},
                                                success     : function(data){
                                                    $('#FormCariDokter').html(data);
                                                }
                                            });
                                        });
                                        $('#ModalKonfirmasiPilihDokter').on('show.bs.modal', function (e) {
                                            var KodeDokter = $(e.relatedTarget).data('id');
                                            $('#KonfirmasiPilihDokter').html("Loading...");
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/KonfirmasiPilihDokter.php',
                                                data        : {KodeDokter: KodeDokter},
                                                success     : function(data){
                                                    $('#KonfirmasiPilihDokter').html(data);
                                                    //Proses Konfirmasi Pilih SEP
                                                    $('#KonfirmasiPilihDokterYa').click(function(){
                                                        $('#kodeDokter').val(KodeDokter);
                                                        $('#ModalKonfirmasiPilihDokter').modal('toggle');
                                                        $('#ModalCariDokter').modal('toggle');
                                                    });
                                                }
                                            });
                                        });
                                        $('#ProsesEditRencanaKontrol').submit(function(){
                                            var ProsesEditRencanaKontrol = $('#ProsesEditRencanaKontrol').serialize();
                                            $('#NotifikasiEditRencanaKontrol').html("Loading...");
                                            $.ajax({
                                                type 	    : 'POST',
                                                url 	    : '_Page/SuratKontrol/ProsesEditRencanaKontrol.php',
                                                data 	    :  ProsesEditRencanaKontrol,
                                                success     : function(data){
                                                    $('#NotifikasiEditRencanaKontrol').html(data);
                                                    var NotifikasiEditRencanaKontrolBerhasil=$('#NotifikasiEditRencanaKontrolBerhasil').html();
                                                    if(NotifikasiEditRencanaKontrolBerhasil=="Berhasil"){
                                                        $('#ProsesEditRencanaKontrol').trigger("reset");
                                                        Swal.fire({
                                                            title: 'Good Job!',
                                                            text: 'Edit Surat Kontrol/SPRI Berhasil',
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
            });
        }
    });
});
