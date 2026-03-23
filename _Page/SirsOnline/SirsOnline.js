//Menampilkan Data Nakes
var ProsesFilterNakes = $('#ProsesFilterNakes').serialize();
$('#MenampilkanTabelSdm').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnline/TabelNakes.php',
    data 	    :  ProsesFilterNakes,
    success     : function(data){
        $('#MenampilkanTabelSdm').html(data);
    }
});
//keyword_by Filter Nakes berubah
$('#keyword_by_nakes').change(function(){
    var keyword_by_nakes = $('#keyword_by_nakes').val();
    $('#FormKeywordNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormKeywordNakes.php',
        data 	    :  {keyword_by_nakes: keyword_by_nakes},
        success     : function(data){
            $('#FormKeywordNakes').html(data);
        }
    });
});
//Proses Filter Nakes
$('#ProsesFilterNakes').submit(function(){
    var ProsesFilterNakes = $('#ProsesFilterNakes').serialize();
    $('#MenampilkanTabelSdm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/TabelNakes.php',
        data 	    :  ProsesFilterNakes,
        success     : function(data){
            $('#MenampilkanTabelSdm').html(data);
            $('#ModalFilterNakes').modal('hide');
            //Evaluasi Tombol
            $('#TampilkanNakesSimrs').removeClass('btn-outline-info');
            $('#TampilkanNakesSimrs').addClass('btn-info');
            $('#TampilkanNakesSirsOnline').addClass('btn-outline-info');
            $('#TampilkanNakesSirsOnline').removeClass('btn-info');
        }
    });
});
//Modal Pilih Practitioner
$('#ModalPilihPractitioner').on('show.bs.modal', function (e) {
    var keyword_practitioner = $('#keyword_practitioner').val();
    $('#ListDataPractitioner').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ListDataPractitioner.php',
        data 	    :  {keyword: keyword_practitioner},
        success     : function(data){
            $('#ListDataPractitioner').html(data);
        }
    });
});
//CariPractitioner
$('#ProsesCariPractitioner').submit(function(){
    var keyword_practitioner = $('#keyword_practitioner').val();
    $('#ListDataPractitioner').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ListDataPractitioner.php',
        data 	    :  {keyword: keyword_practitioner},
        success     : function(data){
            $('#ListDataPractitioner').html(data);
        }
    });
});
//Modal Pilih Dokter
$('#ModalPilihDokter').on('show.bs.modal', function (e) {
    var keyword_dokter = $('#keyword_dokter').val();
    $('#ListDataDokter').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ListDataDokter.php',
        data 	    :  {keyword: keyword_dokter},
        success     : function(data){
            $('#ListDataDokter').html(data);
        }
    });
});
//Cari Referensi Dokter
$('#ProsesCariReferensiDokter').submit(function(){
    var keyword_dokter = $('#keyword_dokter').val();
    $('#ListDataDokter').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ListDataDokter.php',
        data 	    :  {keyword: keyword_dokter},
        success     : function(data){
            $('#ListDataDokter').html(data);
        }
    });
});
//Modal Tambah Nakes
$('#ModalTambahNakes').on('show.bs.modal', function (e) {
    var sumber_data = $(e.relatedTarget).data('id');
    $('#FormTambahNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormTambahNakes.php',
        data 	    :  {sumber_data: sumber_data},
        success     : function(data){
            $('#FormTambahNakes').html(data);
            $('#ModalPilihPractitioner').modal('hide');
            $('#ModalPilihDokter').modal('hide');
            $('#NotifikasiTambahNakes').html('Pastikan data Nakes yang anda input sudah benar.');
        }
    });
});
//Proses Tambah Nakes
$('#ProsesTambahNakes').submit(function(){
    var ProsesTambahNakes = $('#ProsesTambahNakes').serialize();
    $('#NotifikasiTambahNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesTambahNakes.php',
        data 	    :  ProsesTambahNakes,
        success     : function(data){
            $('#NotifikasiTambahNakes').html(data);
            var NotifikasiTambahNakesBerhasil=$('#NotifikasiTambahNakesBerhasil').html();
            if(NotifikasiTambahNakesBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalTambahNakes').modal('hide');
                //Tampilkan Data Terbaru
                $('#MenampilkanTabelSdm').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/TabelNakes.php',
                    success     : function(data){
                        $('#MenampilkanTabelSdm').html(data);
                       //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Nakes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
                //Evaluasi Tombol
                $('#TampilkanNakesSimrs').removeClass('btn-outline-info');
                $('#TampilkanNakesSimrs').addClass('btn-info');
                $('#TampilkanNakesSirsOnline').addClass('btn-outline-info');
                $('#TampilkanNakesSirsOnline').removeClass('btn-info');
            }
        }
    });
});
//Modal Detail Nakes
$('#ModalDetailNakes').on('show.bs.modal', function (e) {
    var id_nakes = $(e.relatedTarget).data('id');
    $('#FormDetailNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormDetailNakes.php',
        data 	    :  {id_nakes: id_nakes},
        success     : function(data){
            $('#FormDetailNakes').html(data);
        }
    });
});
//Modal Edit Nakes
$('#ModalEditnakes').on('show.bs.modal', function (e) {
    var id_nakes = $(e.relatedTarget).data('id');
    $('#FormEditNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormEditNakes.php',
        data 	    :  {id_nakes: id_nakes},
        success     : function(data){
            $('#FormEditNakes').html(data);
            $('#NotifikasiEditNakes').html('Pastikan data Nakes yang anda ubah sudah benar.');
        }
    });
});
//Proses Edit Nakes
$('#ProsesEdithNakes').submit(function(){
    var ProsesEdithNakes = $('#ProsesEdithNakes').serialize();
    $('#NotifikasiEditNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesEdithNakes.php',
        data 	    :  ProsesEdithNakes,
        success     : function(data){
            $('#NotifikasiEditNakes').html(data);
            var NotifikasiEditNakesBerhasil=$('#NotifikasiEditNakesBerhasil').html();
            if(NotifikasiEditNakesBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalEditnakes').modal('hide');
                //Tampilkan Data Terbaru
                $('#MenampilkanTabelSdm').html('Loading...');
                var ProsesFilterNakes = $('#ProsesFilterNakes').serialize();
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/TabelNakes.php',
                    data 	    :  ProsesFilterNakes,
                    success     : function(data){
                        $('#MenampilkanTabelSdm').html(data);
                       //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Edit Nakes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
                //Evaluasi Tombol
                $('#TampilkanNakesSimrs').removeClass('btn-outline-info');
                $('#TampilkanNakesSimrs').addClass('btn-info');
                $('#TampilkanNakesSirsOnline').addClass('btn-outline-info');
                $('#TampilkanNakesSirsOnline').removeClass('btn-info');
            }
        }
    });
});
//Modal Hapus Nakes
$('#ModalHapusNakes').on('show.bs.modal', function (e) {
    var id_nakes = $(e.relatedTarget).data('id');
    $('#FormHapusNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormHapusNakes.php',
        data 	    :  {id_nakes: id_nakes},
        success     : function(data){
            $('#FormHapusNakes').html(data);
            //Proses Edit Nakes
            $('#ProsesHapusNakes').submit(function(){
                var ProsesHapusNakes = $('#ProsesHapusNakes').serialize();
                $('#NotifikasiHapusNakes').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/ProsesHapusNakes.php',
                    data 	    :  ProsesHapusNakes,
                    success     : function(data){
                        $('#NotifikasiHapusNakes').html(data);
                        var NotifikasiHapusNakesBerhasil=$('#NotifikasiHapusNakesBerhasil').html();
                        if(NotifikasiHapusNakesBerhasil=="Success"){
                            //Apabila berhasil Tutup Modal
                            $('#ModalHapusNakes').modal('hide');
                            //Tampilkan Data Terbaru
                            $('#MenampilkanTabelSdm').html('Loading...');
                            var ProsesFilterNakes = $('#ProsesFilterNakes').serialize();
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/SirsOnline/TabelNakes.php',
                                data 	    :  ProsesFilterNakes,
                                success     : function(data){
                                    $('#MenampilkanTabelSdm').html(data);
                                //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Nakes Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                            //Evaluasi Tombol
                            $('#TampilkanNakesSimrs').removeClass('btn-outline-info');
                            $('#TampilkanNakesSimrs').addClass('btn-info');
                            $('#TampilkanNakesSirsOnline').addClass('btn-outline-info');
                            $('#TampilkanNakesSirsOnline').removeClass('btn-info');
                        }
                    }
                });
            });
        }
    });
});
//Tampilkan Nakes Sirs Online
$('#TampilkanNakesSirsOnline').click(function(){
    $('#MenampilkanTabelSdm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/TabelNakesSirsOnline.php',
        success     : function(data){
            $('#MenampilkanTabelSdm').html(data);
            //Evaluasi Tombol
            $('#TampilkanNakesSirsOnline').removeClass('btn-outline-info');
            $('#TampilkanNakesSirsOnline').addClass('btn-info');
            $('#TampilkanNakesSimrs').addClass('btn-outline-info');
            $('#TampilkanNakesSimrs').removeClass('btn-info');
        }
    });
});
//Tampilkan Nakes Simrs
$('#TampilkanNakesSimrs').click(function(){
    var ProsesFilterNakes = $('#ProsesFilterNakes').serialize();
    $('#MenampilkanTabelSdm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/TabelNakes.php',
        data 	    :  ProsesFilterNakes,
        success     : function(data){
            $('#MenampilkanTabelSdm').html(data);
            //Evaluasi Tombol
            $('#TampilkanNakesSimrs').removeClass('btn-outline-info');
            $('#TampilkanNakesSimrs').addClass('btn-info');
            $('#TampilkanNakesSirsOnline').addClass('btn-outline-info');
            $('#TampilkanNakesSirsOnline').removeClass('btn-info');
        }
    });
});
//Modal Creat Nakes
$('#ModalCreatSdm').on('show.bs.modal', function (e) {
    var id_kebutuhan = $(e.relatedTarget).data('id');
    $('#FormCreatSdm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormCreatSdm.php',
        data 	    :  {id_kebutuhan: id_kebutuhan},
        success     : function(data){
            $('#FormCreatSdm').html(data);
            $('#NotifikasiCreatSdm').html('Pastikan data nakes yang anda input sudah sesuai');
        }
    });
});
//Proses Creat Nakes
$('#ProsesCreatSdm').submit(function(){
    var ProsesCreatSdm = $('#ProsesCreatSdm').serialize();
    $('#NotifikasiCreatSdm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesCreatSdm.php',
        data 	    :  ProsesCreatSdm,
        success     : function(data){
            $('#NotifikasiCreatSdm').html(data);
            var NotifikasiCreatSdmBerhasil=$('#NotifikasiCreatSdmBerhasil').html();
            if(NotifikasiCreatSdmBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalCreatSdm').modal('hide');
                //Tampilkan Data Terbaru
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Creat Nakes Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
                $('#MenampilkanTabelSdm').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/TabelNakesSirsOnline.php',
                    success     : function(data){
                        $('#MenampilkanTabelSdm').html(data);
                        //Evaluasi Tombol
                        $('#TampilkanNakesSirsOnline').removeClass('btn-outline-info');
                        $('#TampilkanNakesSirsOnline').addClass('btn-info');
                        $('#TampilkanNakesSimrs').addClass('btn-outline-info');
                        $('#TampilkanNakesSimrs').removeClass('btn-info');
                    }
                });
            }
        }
    });
});
//Modal Update Nakes
$('#ModalUpdateSdm').on('show.bs.modal', function (e) {
    var id_kebutuhan = $(e.relatedTarget).data('id');
    $('#FormUpdateSdm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormUpdateSdm.php',
        data 	    :  {id_kebutuhan: id_kebutuhan},
        success     : function(data){
            $('#FormUpdateSdm').html(data);
            $('#NotifikasiUpdateSdm').html('Pastikan data nakes yang anda input sudah sesuai');
        }
    });
});
//Proses Update Nakes
$('#ProsesUpdateSdm').submit(function(){
    var ProsesUpdateSdm = $('#ProsesUpdateSdm').serialize();
    $('#NotifikasiUpdateSdm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesUpdateSdm.php',
        data 	    :  ProsesUpdateSdm,
        success     : function(data){
            $('#NotifikasiUpdateSdm').html(data);
            var NotifikasiUpdateSdmBerhasil=$('#NotifikasiUpdateSdmBerhasil').html();
            if(NotifikasiUpdateSdmBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalUpdateSdm').modal('hide');
                //Tampilkan Data Terbaru
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Update Nakes Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
                $('#MenampilkanTabelSdm').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/TabelNakesSirsOnline.php',
                    success     : function(data){
                        $('#MenampilkanTabelSdm').html(data);
                        //Evaluasi Tombol
                        $('#TampilkanNakesSirsOnline').removeClass('btn-outline-info');
                        $('#TampilkanNakesSirsOnline').addClass('btn-info');
                        $('#TampilkanNakesSimrs').addClass('btn-outline-info');
                        $('#TampilkanNakesSimrs').removeClass('btn-info');
                    }
                });
            }
        }
    });
});
$('#MenampilkanDataPcrnakes').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnline/TabelPcrNakes.php',
    success     : function(data){
        $('#MenampilkanDataPcrnakes').html(data);
    }
});
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKataKunci').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormKataKunciPcrNakes.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKataKunci').html(data);
        }
    });
});
$('#BatasDataPcrNakes').submit(function(){
    var BatasDataPcrNakes = $('#BatasDataPcrNakes').serialize();
    $('#MenampilkanDataPcrnakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/TabelPcrNakes.php',
        data 	    :  BatasDataPcrNakes,
        success     : function(data){
            $('#MenampilkanDataPcrnakes').html(data);
            $('#ModalPencarianPcrNakes').modal('hide');
        }
    });
});
//Kondisi ketika dilakukan pencarian data PCR Nakes Sirs Online
$('#PencarianPcrNakes').submit(function(){
    var PencarianPcrNakes = $('#PencarianPcrNakes').serialize();
    $('#MenampilkanDataPcrnakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/TabelPcrNakesSirsOnline.php',
        data 	    :  PencarianPcrNakes,
        success     : function(data){
            $('#MenampilkanDataPcrnakes').html(data);
        }
    });
});
//Modal Tambah Pcr Nakes Muncul
$('#ModalTambahHasilPcrNakes').on('show.bs.modal', function (e) {
    $('#ModalPilihNakesUntukPcr').modal('hide');
    var id_nakes = $(e.relatedTarget).data('id');
    $('#FormTambahHasilPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormTambahHasilPcrNakes.php',
        data 	    :  {id_nakes: id_nakes},
        success     : function(data){
            $('#FormTambahHasilPcrNakes').html(data);
            $('#NotifikasiTambahHasilPcrNakes').html('Pastikan data hasil PCR Nakes yang anda input sudah benar.');
        }
    });
});
//Tambah Hasil PCR Nakes
$('#ProsesTambahHasilPcrNakes').submit(function(){
    var ProsesTambahHasilPcrNakes = $('#ProsesTambahHasilPcrNakes').serialize();
    $('#NotifikasiTambahHasilPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesTambahHasilPcrNakes.php',
        data 	    :  ProsesTambahHasilPcrNakes,
        success     : function(data){
            $('#NotifikasiTambahHasilPcrNakes').html(data);
            var NotifikasiTambahHasilPcrNakesBerhasil=$('#NotifikasiTambahHasilPcrNakesBerhasil').html();
            if(NotifikasiTambahHasilPcrNakesBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalTambahHasilPcrNakes').modal('hide');
                $('#ProsesTambahHasilPcrNakes')[0].reset();
                //Tampilkan Data Terbaru
                $('#MenampilkanDataPcrnakes').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/TabelPcrNakes.php',
                    success     : function(data){
                        $('#MenampilkanDataPcrnakes').html(data);
                       //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Hasil PCR Nakes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Hasil PCR Nakes
$('#ModalDetailHasilPcrNakes').on('show.bs.modal', function (e) {
    var id_nakes_pcr = $(e.relatedTarget).data('id');
    $('#DetailHasilPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/DetailHasilPcrNakes.php',
        data 	    :  {id_nakes_pcr: id_nakes_pcr},
        success     : function(data){
            $('#DetailHasilPcrNakes').html(data);
        }
    });
});
//Modal Edit Hasil PCR Nakes
$('#ModalEditHasilPcrNakes').on('show.bs.modal', function (e) {
    var id_nakes_pcr = $(e.relatedTarget).data('id');
    $('#FormEditHasilPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormEditHasilPcrNakes.php',
        data 	    :  {id_nakes_pcr: id_nakes_pcr},
        success     : function(data){
            $('#FormEditHasilPcrNakes').html(data);
        }
    });
});
//Edit Hasil PCR Nakes
$('#ProsesEditHasilPcrNakes').submit(function(){
    var ProsesEditHasilPcrNakes = $('#ProsesEditHasilPcrNakes').serialize();
    $('#NotifikasiEditHasilPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesEditHasilPcrNakes.php',
        data 	    :  ProsesEditHasilPcrNakes,
        success     : function(data){
            $('#NotifikasiEditHasilPcrNakes').html(data);
            var NotifikasiEditHasilPcrNakesBerhasil=$('#NotifikasiEditHasilPcrNakesBerhasil').html();
            if(NotifikasiEditHasilPcrNakesBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalEditHasilPcrNakes').modal('hide');
                //Tampilkan Data Terbaru
                var BatasDataPcrNakes = $('#BatasDataPcrNakes').serialize();
                $('#MenampilkanDataPcrnakes').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/TabelPcrNakes.php',
                    data 	    :  BatasDataPcrNakes,
                    success     : function(data){
                        $('#MenampilkanDataPcrnakes').html(data);
                       //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Edit Hasil PCR Nakes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Hapus Hasil PCR Nakews
$('#ModalHapusHasilPcrNakes').on('show.bs.modal', function (e) {
    var id_nakes_pcr = $(e.relatedTarget).data('id');
    $('#FormHapusHasilPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormHapusHasilPcrNakes.php',
        data 	    :  {id_nakes_pcr: id_nakes_pcr},
        success     : function(data){
            $('#FormHapusHasilPcrNakes').html(data);
        }
    });
});
//Hapus Hasil PCR Nakes
$('#ProsesHapusHasilPcrNakes').submit(function(){
    var ProsesHapusHasilPcrNakes = $('#ProsesHapusHasilPcrNakes').serialize();
    $('#NotifikasiHapusHasilPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesHapusHasilPcrNakes.php',
        data 	    :  ProsesHapusHasilPcrNakes,
        success     : function(data){
            $('#NotifikasiHapusHasilPcrNakes').html(data);
            var NotifikasiHapusHasilPcrNakesBerhasil=$('#NotifikasiHapusHasilPcrNakesBerhasil').html();
            if(NotifikasiHapusHasilPcrNakesBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalHapusHasilPcrNakes').modal('hide');
                //Tampilkan Data Terbaru
                var BatasDataPcrNakes = $('#BatasDataPcrNakes').serialize();
                $('#MenampilkanDataPcrnakes').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/TabelPcrNakes.php',
                    data 	    :  BatasDataPcrNakes,
                    success     : function(data){
                        $('#MenampilkanDataPcrnakes').html(data);
                       //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Hasil PCR Nakes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Filter Laporan PCR Nakes
$('#ProsesFilterLaporanPcrNakes').click(function(){
    var TanggalLaporanPcrNakes = $('#TanggalLaporanPcrNakes').val();
    $('#HasilFilterLaporanPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesFilterLaporanPcrNakes.php',
        data 	    :  {TanggalLaporanPcrNakes: TanggalLaporanPcrNakes},
        success     : function(data){
            $('#HasilFilterLaporanPcrNakes').html(data);
        }
    });
});
//Tambah PCR Nakes
$('#ProsesLaporanPcrNakes').submit(function(){
    var ProsesLaporanPcrNakes = $('#ProsesLaporanPcrNakes').serialize();
    $('#NotifikasiKirimLaporanPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesTambahPcrNakes.php',
        data 	    :  ProsesLaporanPcrNakes,
        success     : function(data){
            $('#NotifikasiKirimLaporanPcrNakes').html(data);
            var NotifikasiTambahPcrNakesBerhasil=$('#NotifikasiTambahPcrNakesBerhasil').html();
            if(NotifikasiTambahPcrNakesBerhasil=="Success"){
                //Tutup Modal
                $('#ModalLaporanPcrNakes').modal('hide');
                //Tampilkan Data PCR Nakes
                var PencarianPcrNakes = $('#PencarianPcrNakes').serialize();
                $('#MenampilkanDataPcrnakes').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnline/TabelPcrNakesSirsOnline.php',
                    data 	    :  PencarianPcrNakes,
                    success     : function(data){
                        $('#MenampilkanDataPcrnakes').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Laporan PCR Nakes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail PCR Nakes
$('#ModalDetailPcrNakes').on('show.bs.modal', function (e) {
    var id_pcr_nakes = $(e.relatedTarget).data('id');
    $('#DetailPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/DetailPcrNakes.php',
        data 	    :  {id_pcr_nakes: id_pcr_nakes},
        success     : function(data){
            $('#DetailPcrNakes').html(data);
        }
    });
});
//Modal Detail PCR Nakes
$('#ModalDetailPcrNakesSirsOnline').on('show.bs.modal', function (e) {
    var tanggal = $(e.relatedTarget).data('id');
    $('#DetailPcrNakesSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/DetailPcrNakesSirsOnline.php',
        data 	    :  {tanggal: tanggal},
        success     : function(data){
            $('#DetailPcrNakesSirsOnline').html(data);
        }
    });
});
//Modal Edit PCR Nakes
$('#ModalEditPcrNakes').on('show.bs.modal', function (e) {
    var id_pcr_nakes = $(e.relatedTarget).data('id');
    $('#FormEditPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormEditPcrNakes.php',
        data 	    :  {id_pcr_nakes: id_pcr_nakes},
        success     : function(data){
            $('#FormEditPcrNakes').html(data);
        }
    });
});
//Proses Edit PCR Nakes
$('#ProsesEditPcrNakes').submit(function(){
    var ProsesEditPcrNakes = $('#ProsesEditPcrNakes').serialize();
    $('#NotifikasiEditPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesEditPcrNakes.php',
        data 	    :  ProsesEditPcrNakes,
        success     : function(data){
            $('#NotifikasiEditPcrNakes').html(data);
            var NotifikasiEditPcrNakesBerhasil=$('#NotifikasiEditPcrNakesBerhasil').html();
            if(NotifikasiEditPcrNakesBerhasil=="Success"){
                window.location.href='index.php?Page=SirsOnline&Sub=PcrNakes';
            }
        }
    });
});
//Modal Edit PCR Nakes Sirs Online
$('#ModalEditPcrNakesSirsOnline').on('show.bs.modal', function (e) {
    var tanggal = $(e.relatedTarget).data('id');
    $('#FormEditPcrNakesSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormEditPcrNakesSirsOnline.php',
        data 	    :  {tanggal: tanggal},
        success     : function(data){
            $('#FormEditPcrNakesSirsOnline').html(data);
        }
    });
});
//Proses Edit PCR Nakes Sirs Online
$('#ProsesEditPcrNakesSirsOnline').submit(function(){
    var ProsesEditPcrNakesSirsOnline = $('#ProsesEditPcrNakesSirsOnline').serialize();
    $('#NotifikasiEditPcrNakesSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesEditPcrNakesSirsOnline.php',
        data 	    :  ProsesEditPcrNakesSirsOnline,
        success     : function(data){
            $('#NotifikasiEditPcrNakesSirsOnline').html(data);
            var NotifikasiEditPcrNakesSirsOnlineBerhasil=$('#NotifikasiEditPcrNakesSirsOnlineBerhasil').html();
            if(NotifikasiEditPcrNakesSirsOnlineBerhasil=="Success"){
                window.location.href='index.php?Page=SirsOnline&Sub=PcrNakes';
            }
        }
    });
});
//Modal Hapus PCR Nakews
$('#ModalHapusPcrNakes').on('show.bs.modal', function (e) {
    var id_pcr_nakes = $(e.relatedTarget).data('id');
    $('#FormHapusPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormHapusPcrNakes.php',
        data 	    :  {id_pcr_nakes: id_pcr_nakes},
        success     : function(data){
            $('#FormHapusPcrNakes').html(data);
        }
    });
});
//Proses Hapus PCR Nakes Sirs Online
$('#ProsesHapusPcrNakes').submit(function(){
    var ProsesHapusPcrNakes = $('#ProsesHapusPcrNakes').serialize();
    $('#NotifikasiHapusPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesHapusPcrNakes.php',
        data 	    :  ProsesHapusPcrNakes,
        success     : function(data){
            $('#NotifikasiHapusPcrNakes').html(data);
            var NotifikasiHapusPcrNakesBerhasil=$('#NotifikasiHapusPcrNakesBerhasil').html();
            if(NotifikasiHapusPcrNakesBerhasil=="Success"){
                window.location.href='index.php?Page=SirsOnline&Sub=PcrNakes';
            }
        }
    });
});
//Modal Copy PCR Nakews
$('#ModalCopyPcrNakes').on('show.bs.modal', function (e) {
    var tanggal = $(e.relatedTarget).data('id');
    $('#FormCopyPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/FormCopyPcrNakes.php',
        data 	    :  {tanggal: tanggal},
        success     : function(data){
            $('#FormCopyPcrNakes').html(data);
        }
    });
});
//Proses Copy PCR Nakes Sirs Online
$('#ProsesCopyPcrNakes').submit(function(){
    var ProsesCopyPcrNakes = $('#ProsesCopyPcrNakes').serialize();
    $('#FormCopyPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/ProsesCopyPcrNakes.php',
        data 	    :  ProsesCopyPcrNakes,
        success     : function(data){
            $('#FormCopyPcrNakes').html(data);
            var NotifikasiCopyPcrNakesBerhasil=$('#NotifikasiCopyPcrNakesBerhasil').html();
            if(NotifikasiCopyPcrNakesBerhasil=="Success"){
                window.location.href='index.php?Page=SirsOnline&Sub=PcrNakes';
            }
        }
    });
});

//NAKES TERINFEKSI
//Menampilkan nakes terinfeksi
var ProsesFilterNakesTerinfeksi = $('#ProsesFilterNakesTerinfeksi').serialize();
$('#MenampilkanTabelNakesTerinfeksi').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnline/TabelNakesTerinfeksi.php',
    data 	    :  ProsesFilterNakesTerinfeksi,
    success     : function(data){
        $('#MenampilkanTabelNakesTerinfeksi').html(data);
    }
});

//Modal Pilih Nakes Untuk PCR
$('#ModalPilihNakesUntukPcr').on('show.bs.modal', function (e) {
    var ProsesCariNakesUntukPcr = $('#ProsesCariNakesUntukPcr').serialize();
    $('#TabelNakesUntukPcr').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/TabelNakesUntukPcr.php',
        data 	    :  ProsesCariNakesUntukPcr,
        success     : function(data){
            $('#TabelNakesUntukPcr').html(data);
        }
    });
});
$('#ProsesCariNakesUntukPcr').submit(function(){
    var ProsesCariNakesUntukPcr = $('#ProsesCariNakesUntukPcr').serialize();
    $('#TabelNakesUntukPcr').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnline/TabelNakesUntukPcr.php',
        data 	    :  ProsesCariNakesUntukPcr,
        success     : function(data){
            $('#TabelNakesUntukPcr').html(data);
        }
    });
});