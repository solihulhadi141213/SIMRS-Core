//Menampilkan Data Oksigen SIMRS pertama kali
var ProsesFilterOksigen = $('#ProsesFilterOksigen').serialize();
$('#MenampilkanTabelLaporanOksigen').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnlineOksigen/TabelOksigen.php',
    data 	    :  ProsesFilterOksigen,
    success     : function(data){
        $('#MenampilkanTabelLaporanOksigen').html(data);
    }
});
//keyword_by Filter Nakes berubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Proses Filter Oksigen
$('#ProsesFilterOksigen').submit(function(){
    var ProsesFilterOksigen = $('#ProsesFilterOksigen').serialize();
    $('#MenampilkanTabelLaporanOksigen').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/TabelOksigen.php',
        data 	    :  ProsesFilterOksigen,
        success     : function(data){
            $('#MenampilkanTabelLaporanOksigen').html(data);
            $('#ModalFilterOksigen').modal('hide');
        }
    });
});
//Modal Tambah Oksigen
$('#ModalTambahOksigen').on('show.bs.modal', function (e) {
    $('#NotifikasiTambahLaporanOksigen').html('Pastikan data yang anda input sudah benar');
});
//Ketika satuan Di ubah
$('#satuan').change(function(){
    var satuan = $('#satuan').val();
    var p_cair = $('#p_cair').val();
    var p_tabung_kecil = $('#p_tabung_kecil').val();
    var p_tabung_sedang = $('#p_tabung_sedang').val();
    var p_tabung_besar = $('#p_tabung_besar').val();
    var k_isi_cair = $('#k_isi_cair').val();
    var k_isi_tabung_kecil = $('#k_isi_tabung_kecil').val();
    var k_isi_tabung_sedang = $('#k_isi_tabung_sedang').val();
    var k_isi_tabung_besar = $('#k_isi_tabung_besar').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var p_cair2 =p_cair*VaktorPerkalian;
    var p_cair2 = Math.round(p_cair2);
    var p_tabung_kecil2 =p_tabung_kecil*VaktorPerkalian;
    var p_tabung_kecil2 = Math.round(p_tabung_kecil2);
    var p_tabung_sedang2 = p_tabung_sedang*VaktorPerkalian;
    var p_tabung_sedang2 = Math.round(p_tabung_sedang2);
    var p_tabung_besar2 = p_tabung_besar*VaktorPerkalian;
    var p_tabung_besar2 = Math.round(p_tabung_besar2);
    var k_isi_cair2 = k_isi_cair*VaktorPerkalian;
    var k_isi_cair2 = Math.round(k_isi_cair2);
    var k_isi_tabung_kecil2 = k_isi_tabung_kecil*VaktorPerkalian;
    var k_isi_tabung_kecil2 = Math.round(k_isi_tabung_kecil2);
    var k_isi_tabung_sedang2 = k_isi_tabung_sedang*VaktorPerkalian;
    var k_isi_tabung_sedang2 = Math.round(k_isi_tabung_sedang2);
    var k_isi_tabung_besar2 = k_isi_tabung_besar*VaktorPerkalian;
    var k_isi_tabung_besar2 = Math.round(k_isi_tabung_besar2);
    //Terapkan pada notifikasi
    $('#notif_p_cair').html('Satuan dalam M3 :'+p_cair2);
    $('#notif_p_tabung_kecil').html('Satuan dalam M3 :'+p_tabung_kecil2);
    $('#notif_p_tabung_sedang').html('Satuan dalam M3 :'+p_tabung_sedang2);
    $('#notif_p_tabung_besar').html('Satuan dalam M3 :'+p_tabung_besar2);
    $('#notif_k_isi_cair').html('Satuan dalam M3 :'+k_isi_cair2);
    $('#notif_k_isi_tabung_kecil').html('Satuan dalam M3 :'+k_isi_tabung_kecil2);
    $('#notif_k_isi_tabung_sedang').html('Satuan dalam M3 :'+k_isi_tabung_sedang2);
    $('#notif_k_isi_tabung_besar').html('Satuan dalam M3 :'+k_isi_tabung_besar2);
});
$('#p_cair').keyup(function(){
    var satuan = $('#satuan').val();
    var p_cair = $('#p_cair').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var p_cair =p_cair*VaktorPerkalian;
    var p_cair = Math.round(p_cair);
    //Terapkan pada notifikasi
    $('#notif_p_cair').html('Satuan dalam M3 :'+p_cair);
});
$('#p_tabung_kecil').keyup(function(){
    var satuan = $('#satuan').val();
    var p_tabung_kecil = $('#p_tabung_kecil').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var p_tabung_kecil =p_tabung_kecil*VaktorPerkalian;
    var p_tabung_kecil = Math.round(p_tabung_kecil);
    //Terapkan pada notifikasi
    $('#notif_p_tabung_kecil').html('Satuan dalam M3 :'+p_tabung_kecil);
});
$('#p_tabung_sedang').keyup(function(){
    var satuan = $('#satuan').val();
    var p_tabung_sedang = $('#p_tabung_sedang').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var p_tabung_sedang =p_tabung_sedang*VaktorPerkalian;
    var p_tabung_sedang = Math.round(p_tabung_sedang);
    //Terapkan pada notifikasi
    $('#notif_p_tabung_sedang').html('Satuan dalam M3 :'+p_tabung_sedang);
});
$('#p_tabung_besar').keyup(function(){
    var satuan = $('#satuan').val();
    var p_tabung_besar = $('#p_tabung_besar').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var p_tabung_besar =p_tabung_besar*VaktorPerkalian;
    var p_tabung_besar = Math.round(p_tabung_besar);
    //Terapkan pada notifikasi
    $('#notif_p_tabung_besar').html('Satuan dalam M3 :'+p_tabung_besar);
});
$('#k_isi_cair').keyup(function(){
    var satuan = $('#satuan').val();
    var k_isi_cair = $('#k_isi_cair').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var k_isi_cair =k_isi_cair*VaktorPerkalian;
    var k_isi_cair = Math.round(k_isi_cair);
    //Terapkan pada notifikasi
    $('#notif_k_isi_cair').html('Satuan dalam M3 :'+k_isi_cair);
});
$('#k_isi_tabung_kecil').keyup(function(){
    var satuan = $('#satuan').val();
    var k_isi_tabung_kecil = $('#k_isi_tabung_kecil').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var k_isi_tabung_kecil =k_isi_tabung_kecil*VaktorPerkalian;
    var k_isi_tabung_kecil = Math.round(k_isi_tabung_kecil);
    //Terapkan pada notifikasi
    $('#notif_k_isi_tabung_kecil').html('Satuan dalam M3 :'+k_isi_tabung_kecil);
});
$('#k_isi_tabung_sedang').keyup(function(){
    var satuan = $('#satuan').val();
    var k_isi_tabung_sedang = $('#k_isi_tabung_sedang').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var k_isi_tabung_sedang =k_isi_tabung_sedang*VaktorPerkalian;
    var k_isi_tabung_sedang = Math.round(k_isi_tabung_sedang);
    //Terapkan pada notifikasi
    $('#notif_k_isi_tabung_sedang').html('Satuan dalam M3 :'+k_isi_tabung_sedang);
});
$('#k_isi_tabung_besar').keyup(function(){
    var satuan = $('#satuan').val();
    var k_isi_tabung_besar = $('#k_isi_tabung_besar').val();
    //Mencari faktor perkalian
    var KonversiSatuan = {"M3": 1, "Liter": 0.897, "Kg": 0.78, "Ton": 788.86, "Galon": 3.04,};
    var VaktorPerkalian =KonversiSatuan[satuan];
    var k_isi_tabung_besar =k_isi_tabung_besar*VaktorPerkalian;
    var k_isi_tabung_besar = Math.round(k_isi_tabung_besar);
    //Terapkan pada notifikasi
    $('#notif_k_isi_tabung_besar').html('Satuan dalam M3 :'+k_isi_tabung_besar);
});
//Proses Tambah
$('#ProsesTambahOksigen').submit(function(){
    var ProsesTambahOksigen = $('#ProsesTambahOksigen').serialize();
    $('#NotifikasiTambahLaporanOksigen').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/ProsesTambahOksigen.php',
        data 	    :  ProsesTambahOksigen,
        success     : function(data){
            $('#NotifikasiTambahLaporanOksigen').html(data);
            var NotifikasiTambahLaporanOksigenBerhasil=$('#NotifikasiTambahLaporanOksigenBerhasil').html();
            if(NotifikasiTambahLaporanOksigenBerhasil=="Success"){
                //Reset Form
                $('#ProsesTambahOksigen')[0].reset();
                //Apabila berhasil Tutup Modal
                $('#ModalTambahOksigen').modal('hide');
                var ProsesFilterOksigen = $('#ProsesFilterOksigen').serialize();
                $('#MenampilkanTabelLaporanOksigen').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineOksigen/TabelOksigen.php',
                    data 	    :  ProsesFilterOksigen,
                    success     : function(data){
                        $('#MenampilkanTabelLaporanOksigen').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Laporan Oksigen Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Laporan Oksigen SIRS Online
$('#ModalDetailOksigenSirsOnline').on('show.bs.modal', function (e) {
    var tanggal = $(e.relatedTarget).data('id');
    $('#FormDetailOksigenSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/FormDetailOksigenSirsOnline.php',
        data 	    :  {tanggal: tanggal},
        success     : function(data){
            $('#FormDetailOksigenSirsOnline').html(data);
        }
    });
});
//Modal Detail Laporan Oksigen
$('#ModalDetailOksigen').on('show.bs.modal', function (e) {
    var id_sirs_online_task = $(e.relatedTarget).data('id');
    $('#FormDetailLaporanOksigen').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/FormDetailLaporanOksigen.php',
        data 	    :  {id_sirs_online_task: id_sirs_online_task},
        success     : function(data){
            $('#FormDetailLaporanOksigen').html(data);
        }
    });
});
//Modal Hapus Laporan Oksigen
$('#ModalHapusOksigen').on('show.bs.modal', function (e) {
    var id_sirs_online_task = $(e.relatedTarget).data('id');
    $('#FormHapusOksigen').html('Loading...');
    $('#NotifikasiHapusOksigen').html("");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/FormHapusOksigen.php',
        data 	    :  {id_sirs_online_task: id_sirs_online_task},
        success     : function(data){
            $('#FormHapusOksigen').html(data);
        }
    });
});
//Proses Hapus
$('#ProsesHapusLaporanOksigen').submit(function(){
    var ProsesHapusLaporanOksigen = $('#ProsesHapusLaporanOksigen').serialize();
    $('#NotifikasiHapusOksigen').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/ProsesHapusLaporanOksigen.php',
        data 	    :  ProsesHapusLaporanOksigen,
        success     : function(data){
            $('#NotifikasiHapusOksigen').html(data);
            var NotifikasiHapusOksigenBerhasil=$('#NotifikasiHapusOksigenBerhasil').html();
            if(NotifikasiHapusOksigenBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalHapusOksigen').modal('hide');
                var ProsesFilterOksigen = $('#ProsesFilterOksigen').serialize();
                $('#MenampilkanTabelLaporanOksigen').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineOksigen/TabelOksigen.php',
                    data 	    :  ProsesFilterOksigen,
                    success     : function(data){
                        $('#MenampilkanTabelLaporanOksigen').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Laporan Oksigen Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Laporan Oksigen
$('#ModalEditOksigen').on('show.bs.modal', function (e) {
    var id_sirs_online_task = $(e.relatedTarget).data('id');
    $('#FormEditOksigen').html('Loading...');
    $('#NotifikasiEditLaporanOksigen').html("Pastikan perubahan data yang anda lakukan sudah benar");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/FormEditOksigen.php',
        data 	    :  {id_sirs_online_task: id_sirs_online_task},
        success     : function(data){
            $('#FormEditOksigen').html(data);
        }
    });
});
//Proses Edit Laporan Oksigen
$('#ProsesEditOksigen').submit(function(){
    var ProsesEditOksigen = $('#ProsesEditOksigen').serialize();
    $('#NotifikasiEditLaporanOksigen').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineOksigen/ProsesEditOksigen.php',
        data 	    :  ProsesEditOksigen,
        success     : function(data){
            $('#NotifikasiEditLaporanOksigen').html(data);
            var NotifikasiEditLaporanOksigenBerhasil=$('#NotifikasiEditLaporanOksigenBerhasil').html();
            if(NotifikasiEditLaporanOksigenBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalEditOksigen').modal('hide');
                var ProsesFilterOksigen = $('#ProsesFilterOksigen').serialize();
                $('#MenampilkanTabelLaporanOksigen').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineOksigen/TabelOksigen.php',
                    data 	    :  ProsesFilterOksigen,
                    success     : function(data){
                        $('#MenampilkanTabelLaporanOksigen').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Update Laporan Oksigen Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});