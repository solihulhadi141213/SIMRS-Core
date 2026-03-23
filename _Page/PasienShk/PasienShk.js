//Menampilkan Data Pasien SHK Pertama Kali
var ProsesFilterPasienShk = $('#ProsesFilterPasienShk').serialize();
$('#MenampilkanTabelPasienShk').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/PasienShk/TabelPasienShk.php',
    data 	    :  ProsesFilterPasienShk,
    success     : function(data){
        $('#MenampilkanTabelPasienShk').html(data);
    }
});
//keyword_by Diubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormFilter').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormFilter.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormFilter').html(data);
        }
    });
});
//ProsesFilterPasienShk
$('#ProsesFilterPasienShk').submit(function(){
    var ProsesFilterPasienShk = $('#ProsesFilterPasienShk').serialize();
    $('#MenampilkanTabelPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/TabelPasienShk.php',
        data 	    :  ProsesFilterPasienShk,
        success     : function(data){
            $('#MenampilkanTabelPasienShk').html(data);
        }
    });
});
//Ketika Kabupaten Di ketik
$('#kabkota').keyup(function(){
    var provinsi = $('#provinsi').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/list_kabupaten.php',
        data 	    :  {provinsi: provinsi},
        success     : function(data){
            $('#list_kabupaten').html(data);
        }
    });
});
//Ketika Kabupaten Di Double Click
$('#kabkota').dblclick(function(){
    var provinsi = $('#provinsi').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/list_kabupaten.php',
        data 	    :  {provinsi: provinsi},
        success     : function(data){
            $('#list_kabupaten').html(data);
        }
    });
});
//Ketika Kecamatan Di ketik
$('#kecamatan').keyup(function(){
    var kabkota = $('#kabkota').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/list_kecamatan.php',
        data 	    :  {kabupaten: kabkota},
        success     : function(data){
            $('#list_kecamatan').html(data);
        }
    });
});
//Ketika Kecamatan Di Double Click
$('#kecamatan').dblclick(function(){
    var kabkota = $('#kabkota').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/list_kecamatan.php',
        data 	    :  {kabupaten: kabkota},
        success     : function(data){
            $('#list_kecamatan').html(data);
        }
    });
});
//Ketika modal pencarian faskes muncul
$('#ModalCariFaskes').on('show.bs.modal', function (e) {
    var jenis_fasyankes=$('#jenis_fasyankes').val();
    $('#tipe_faskes_ppk').val(jenis_fasyankes);
});
//Proses Pencarian faskes
$('#ProsesCariFaskes').submit(function(){
    var ProsesCariFaskes=$('#ProsesCariFaskes').serialize();
    $('#ListFaskes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesCariFaskes.php',
        data 	    :  ProsesCariFaskes,
        success     : function(data){
            $('#ListFaskes').html(data);
        }
    });
});
//Ketika modal pencarian Pasien Ibu
$('#ModalCariPasienIbu').on('show.bs.modal', function (e) {
    var ProsesCariPasienIbu=$('#ProsesCariPasienIbu').serialize();
    $('#ListPasienIbu').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesCariPasienIbu.php',
        data 	    :  ProsesCariPasienIbu,
        success     : function(data){
            $('#ListPasienIbu').html(data);
        }
    });
});
//Proses Pencarian Pasien Ibu
$('#ProsesCariPasienIbu').submit(function(){
    var ProsesCariPasienIbu=$('#ProsesCariPasienIbu').serialize();
    $('#ListPasienIbu').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesCariPasienIbu.php',
        data 	    :  ProsesCariPasienIbu,
        success     : function(data){
            $('#ListPasienIbu').html(data);
        }
    });
});
//Ketika modal pencarian Pasien Anak
$('#ModalCariPasienAnak').on('show.bs.modal', function (e) {
    var ProsesCariPasienAnak=$('#ProsesCariPasienAnak').serialize();
    $('#ListPasienAnak').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesCariPasienAnak.php',
        data 	    :  ProsesCariPasienAnak,
        success     : function(data){
            $('#ListPasienAnak').html(data);
        }
    });
});
//Proses Pencarian Pasien Anak
$('#ProsesCariPasienAnak').submit(function(){
    var ProsesCariPasienAnak=$('#ProsesCariPasienAnak').serialize();
    $('#ListPasienAnak').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesCariPasienAnak.php',
        data 	    :  ProsesCariPasienAnak,
        success     : function(data){
            $('#ListPasienAnak').html(data);
        }
    });
});
//Ketika modal Cek Alamat Pasien Muncul
$('#ModalCekAlamatPasien').on('show.bs.modal', function (e) {
    var id_pasien_ibu=$('#id_pasien_ibu').val();
    $('#FormInformasiAlamatPasien').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormInformasiAlamatPasien.php',
        data 	    :  {id_pasien: id_pasien_ibu},
        success     : function(data){
            $('#FormInformasiAlamatPasien').html(data);
        }
    });
});
//Ketika Radio Button berubah
$("input[name='generate_id_shk']").change(function(){
    var selectedValue = $("input[name='generate_id_shk']:checked").val();
    if(selectedValue=="Yes") {
        $('#id_shk').val("");
        $('#id_shk').prop('readonly', true);
    }else{
        $('#id_shk').prop('readonly', false);
    }
});
//Proses Simpan Pasien SHK
$('#ProsesTambahPasienShk').submit(function(){
    var ProsesTambahPasienShk=$('#ProsesTambahPasienShk').serialize();
    $('#NotifikasiTambahPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesTambahPasienShk.php',
        data 	    :  ProsesTambahPasienShk,
        success     : function(data){
            $('#NotifikasiTambahPasienShk').html(data);
            var NotifikasiTambahPasienShkBerhasil=$('#NotifikasiTambahPasienShkBerhasil').html();
            var UrlBack=$('#UrlBack').html();
            var URLBack2=UrlBack.replace(/&amp;/g, '&');
            if(NotifikasiTambahPasienShkBerhasil=="Success"){
                location.href = URLBack2;
            }
        }
    });
});
//Modal Detail Pasien Shk Sirs Online
$('#ModalDetailPasienShkSirsOnline').on('show.bs.modal', function (e) {
    var id_shk = $(e.relatedTarget).data('id');
    $('#FormDetailPasienShkSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormDetailPasienShkSirsOnline.php',
        data 	    :  {id_shk: id_shk},
        success     : function(data){
            $('#FormDetailPasienShkSirsOnline').html(data);
        }
    });
});
//Modal Detail Pasien Shk
$('#ModalDetailPasienShk').on('show.bs.modal', function (e) {
    var id_pasien_shk = $(e.relatedTarget).data('id');
    $('#FormDetailPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormDetailPasienShk.php',
        data 	    :  {id_pasien_shk: id_pasien_shk},
        success     : function(data){
            $('#FormDetailPasienShk').html(data);
        }
    });
});
//Modal Edit Pasien Shk
$('#ModalEditPasienShk').on('show.bs.modal', function (e) {
    var id_pasien_shk = $(e.relatedTarget).data('id');
    $('#FormEditPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormEditPasienShk.php',
        data 	    :  {id_pasien_shk: id_pasien_shk},
        success     : function(data){
            $('#FormEditPasienShk').html(data);
        }
    });
});
//Proses Edit Pasien SHK
$('#ProsesEditPasienShk').submit(function(){
    var ProsesEditPasienShk=$('#ProsesEditPasienShk').serialize();
    $('#NotifikasiEditPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesEditPasienShk.php',
        data 	    :  ProsesEditPasienShk,
        success     : function(data){
            $('#NotifikasiEditPasienShk').html(data);
            var NotifikasiEditPasienShkBerhasil=$('#NotifikasiEditPasienShkBerhasil').html();
            var UrlBack=$('#UrlBack').html();
            var URLBack2=UrlBack.replace(/&amp;/g, '&');
            if(NotifikasiEditPasienShkBerhasil=="Success"){
                location.href = URLBack2;
            }
        }
    });
});
//Modal Hapus Pasien Shk
$('#ModalHapusPasienShk').on('show.bs.modal', function (e) {
    var id_pasien_shk = $(e.relatedTarget).data('id');
    $('#FormHapusPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormHapusPasienShk.php',
        data 	    :  {id_pasien_shk: id_pasien_shk},
        success     : function(data){
            $('#FormHapusPasienShk').html(data);
            $('#NotifikasiHapusPasienShk').html('Pastikan anda memilih data yang benar untuk dihapus.');
        }
    });
});
//Proses Hapus Pasien SHK
$('#ProsesHapusPasienShk').submit(function(){
    var ProsesHapusPasienShk=$('#ProsesHapusPasienShk').serialize();
    $('#NotifikasiHapusPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesHapusPasienShk.php',
        data 	    :  ProsesHapusPasienShk,
        success     : function(data){
            $('#NotifikasiHapusPasienShk').html(data);
            var NotifikasiHapusPasienShkBerhhasil=$('#NotifikasiHapusPasienShkBerhhasil').html();
            if(NotifikasiHapusPasienShkBerhhasil=="Success"){
                location.href = "index.php?Page=PasienShk";
            }
        }
    });
});
//Ketika Tombol Tampilkan Di Click
$('#TombolTampilkanLabPasienShk').click(function(){
    var GetNilaiIdShk=$('#GetNilaiIdShk').html();
    var TombolTampilkanLabPasienShk=$('#TombolTampilkanLabPasienShk').html();
    if(TombolTampilkanLabPasienShk=='<i class="ti ti-angle-down"></i> Tampilkan'){
        //Tampilkan
        $('#TombolTampilkanLabPasienShk').html('<i class="ti ti-close"></i> Sembunyikan');
        $('#TombolTampilkanLabPasienShk').removeClass('btn-info');
        $('#TombolTampilkanLabPasienShk').addClass('btn-secondary');
        $('#TampilkanLabPasienShk').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PasienShk/DetailLabPasienShk.php',
            data 	    :  {id_shk: GetNilaiIdShk},
            success     : function(data){
                $('#TampilkanLabPasienShk').html(data);
            }
        });
    }else{
        //Sembunyikan
        $('#TombolTampilkanLabPasienShk').html('<i class="ti ti-angle-down"></i> Tampilkan');
        $('#TombolTampilkanLabPasienShk').addClass('btn-info');
        $('#TombolTampilkanLabPasienShk').removeClass('btn-secondary');
        $('#TampilkanLabPasienShk').html('<div class="row"><div class="col-md-12 text-center">Silahkan Klik Tombol <i class="text-info">Tampilkan</i> Untuk Menampilkan Data Hasil Lab Pasian SHK</div></div>');
    }
});
//Modal Tambah Hasil Lab Pasien SHK
$('#ModalTambahLabShk').on('show.bs.modal', function (e) {
    var GetNilaiIdShk=$('#GetNilaiIdShk').html();
    $('#put_id_shk').val(GetNilaiIdShk);
    $('#NotifikasiTambahHasilLabPasienShk').html('Pastikan Bahwa Data Hasil Lab Yang Anda Input Sudah Benar');
});
//Ketika jenis pemeriksaan di ubah
$('#jenis_pemeriksaan').change(function(){
    var jenis_pemeriksaan=$('#jenis_pemeriksaan').val();
    $('#FormHasilPemeriksaan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormHasilPemeriksaan.php',
        data 	    :  {jenis_pemeriksaan: jenis_pemeriksaan},
        success     : function(data){
            $('#FormHasilPemeriksaan').html(data);
        }
    });
});
//Proses Simpan Hasil Lab Pasien SHK
$('#ProsesTambahLabShk').submit(function(){
    var ProsesTambahLabShk=$('#ProsesTambahLabShk').serialize();
    var GetNilaiIdShk=$('#GetNilaiIdShk').html();
    $('#NotifikasiTambahHasilLabPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesTambahLabShk.php',
        data 	    :  ProsesTambahLabShk,
        success     : function(data){
            $('#NotifikasiTambahHasilLabPasienShk').html(data);
            var NotifikasiTambahHasilLabPasienShkBerhasil=$('#NotifikasiTambahHasilLabPasienShkBerhasil').html();
            if(NotifikasiTambahHasilLabPasienShkBerhasil=="Success"){
                $('#ModalTambahLabShk').modal('hide');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/PasienShk/DetailLabPasienShk.php',
                    data 	    :  {id_shk: GetNilaiIdShk},
                    success     : function(data){
                        $('#TampilkanLabPasienShk').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Lab Pasien SHK Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Hapus Lab Pasien Shk
$('#ModalHapusLabPasienShk').on('show.bs.modal', function (e) {
    var GetContent = $(e.relatedTarget).data('id');
    $('#FormHapusLabPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormHapusLabPasienShk.php',
        data 	    :  {GetContent: GetContent},
        success     : function(data){
            $('#FormHapusLabPasienShk').html(data);
            $('#NotifikasiHapusLabPasienShk').html('');
        }
    });
});
//Proses Hapus Pasien SHK
$('#ProsesHapusLabPasienShk').submit(function(){
    var ProsesHapusLabPasienShk=$('#ProsesHapusLabPasienShk').serialize();
    $('#NotifikasiHapusLabPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesHapusLabPasienShk.php',
        data 	    :  ProsesHapusLabPasienShk,
        success     : function(data){
            $('#NotifikasiHapusLabPasienShk').html(data);
            var NotifikasiHapusLabPasienShkBerhhasil=$('#NotifikasiHapusLabPasienShkBerhhasil').html();
            if(NotifikasiHapusLabPasienShkBerhhasil=="Success"){
                var GetNilaiIdShk=$('#GetNilaiIdShk').html();
                $('#ModalHapusLabPasienShk').modal('hide');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/PasienShk/DetailLabPasienShk.php',
                    data 	    :  {id_shk: GetNilaiIdShk},
                    success     : function(data){
                        $('#TampilkanLabPasienShk').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Lab Pasien SHK Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Lab Pasien Shk
$('#ModalEditLabPasienShk').on('show.bs.modal', function (e) {
    var GetContent = $(e.relatedTarget).data('id');
    $('#FormEditLabPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormEditLabPasienShk.php',
        data 	    :  {GetContent: GetContent},
        success     : function(data){
            $('#FormEditLabPasienShk').html(data);
            $('#NotifikasiEditHasilLabPasienShk').html('');
        }
    });
});
//Proses Hapus Lab Pasien SHK
$('#ProsesEditLabPasienShk').submit(function(){
    var ProsesEditLabPasienShk=$('#ProsesEditLabPasienShk').serialize();
    $('#NotifikasiEditHasilLabPasienShk').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/ProsesEditLabPasienShk.php',
        data 	    :  ProsesEditLabPasienShk,
        success     : function(data){
            $('#NotifikasiEditHasilLabPasienShk').html(data);
            var NotifikasiEditHasilLabPasienShkBerhasil=$('#NotifikasiEditHasilLabPasienShkBerhasil').html();
            if(NotifikasiEditHasilLabPasienShkBerhasil=="Success"){
                var GetNilaiIdShk=$('#GetNilaiIdShk').html();
                $('#ModalEditLabPasienShk').modal('hide');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/PasienShk/DetailLabPasienShk.php',
                    data 	    :  {id_shk: GetNilaiIdShk},
                    success     : function(data){
                        $('#TampilkanLabPasienShk').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Edit Lab Pasien SHK Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Pasien
$('#ModalDetailPasienByRm').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormDetailPasienByRm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/PasienShk/FormDetailPasienByRm.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormDetailPasienByRm').html(data);
        }
    });
});
