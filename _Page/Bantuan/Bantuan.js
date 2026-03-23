//Menampilkan Data Bantuan Pertama Kali
var ProsesPencarian = $('#ProsesPencarian').serialize();
$('#TabelBantuan').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Bantuan/TabelBantuan.php',
    data 	    :  ProsesPencarian,
    success     : function(data){
        $('#TabelBantuan').html(data);
    }
});
//Kondisi Ketika Batas Data Diubah
$("#batas").change(function(){
    var ProsesPencarian = $('#ProsesPencarian').serialize();
    $('#TabelBantuan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Bantuan/TabelBantuan.php',
        data 	    :  ProsesPencarian,
        success     : function(data){
            $('#TabelBantuan').html(data);
        }
    });
});
//Kondisi ketika keyword_by diubah
$("#keyword_by").change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Bantuan/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Kondisi Ketika Proses Pencarian Dimulai
$("#ProsesPencarian").submit(function(){
    var ProsesPencarian = $('#ProsesPencarian').serialize();
    $('#TabelBantuan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Bantuan/TabelBantuan.php',
        data 	    :  ProsesPencarian,
        success     : function(data){
            $('#TabelBantuan').html(data);
        }
    });
});
//Kondisi ketika modal detail bantuan muncul
$('#ModalDetailBantuan').on('show.bs.modal', function (e) {
    var id_bantuan = $(e.relatedTarget).data('id');
    $('#FormDetailBantuan').html('<div class="row"><div class="col-md-12 text-center text-dark">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Bantuan/FormDetailBantuan.php',
        data        :  {id_bantuan: id_bantuan},
        success     : function(data){
            $('#FormDetailBantuan').html(data);
        }
    });
});
//Kondisi Ketika Form Tambah Muncul
$(document).ready(function() {
    $('.summernote').summernote();
});
//Proses Tambah Bantuan
$("#ProsesTambahBantuan").submit(function(){
    $('#NotifikasiTambahBantuan').html('Loading..');
    var judul=$('#judul').val();
    var tanggal=$('#tanggal').val();
    var kategori=$('#kategori').val();
    var status=$('#status').val();
    var summernote = $('.summernote').summernote('code');
    $.ajax({
        type    : 'POST',
        url     : "_Page/Bantuan/ProsesTambahBantuan.php",
        data    : {judul: judul, tanggal: tanggal, kategori: kategori, isi: summernote, status: status },
        success: function(data) {
            $('#NotifikasiTambahBantuan').html(data);
            var NotifikasiTambahBerhasil=$('#NotifikasiTambahBerhasil').html();
            if(NotifikasiTambahBerhasil=="Berhasil"){
                window.location.replace("index.php?Page=Bantuan");
            }
        }
    });
});
//Kondisi Ketika Ubah Bantuan Muncul
$('#ModalEditBantuan').on('show.bs.modal', function (e) {
    var id_bantuan = $(e.relatedTarget).data('id');
    $('#FormEditBantuan').html('<input type="hidden" name="id" value="'+id_bantuan+'">');
});
//Proses Edit Bantuan
$("#ProsesEditBantuan").submit(function(){
    $('#NotifikasiEditBantuan').html('Loading..');
    var id_bantuan=$('#GetIdBantuan').val();
    var judul=$('#judul').val();
    var tanggal=$('#tanggal').val();
    var kategori=$('#kategori').val();
    var status=$('#status').val();
    var summernote = $('.summernote').summernote('code');
    $.ajax({
        type    : 'POST',
        url     : "_Page/Bantuan/ProsesEditBantuan.php",
        data    : {id_bantuan: id_bantuan, judul: judul, tanggal: tanggal, kategori: kategori, isi: summernote, status: status },
        success: function(data) {
            $('#NotifikasiEditBantuan').html(data);
            var NotifikasiEditBantuanBerhasil=$('#NotifikasiEditBantuanBerhasil').html();
            if(NotifikasiEditBantuanBerhasil=="Berhasil"){
                window.location.replace("index.php?Page=Bantuan");
            }
        }
    });
});
//Modal Hapus Bantuan
$('#ModalDeleteBantuan').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_bantuan = $(e.relatedTarget).data('id');
    $('#FormHapusBantuan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Bantuan/FormHapusBantuan.php',
        data        :  {id_bantuan: id_bantuan},
        success     : function(data){
            $('#FormHapusBantuan').html(data);
        }
    });
});
//Ketika Proses Hapus bantuan
$('#ProsesHapusBantuan').submit(function(){
    var ProsesHapusBantuan = $('#ProsesHapusBantuan').serialize();
    $('#NotifikasiHapusBantuan').html('Loading...');
    $.ajax({
        url     : "_Page/Bantuan/ProsesHapusBantuan.php",
        method  : "POST",
        data    :  ProsesHapusBantuan,
        success : function (data) {
            $('#NotifikasiHapusBantuan').html(data);
            //Notifikasi Proses Hapus
            var NotifikasiHapus=$('#NotifikasiHapus').html();
            if(NotifikasiHapus=="Berhasil"){
                //Tampilkan Data
                var ProsesPencarian = $('#ProsesPencarian').serialize();
                $('#TabelBantuan').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Bantuan/TabelBantuan.php',
                    data 	    :  ProsesPencarian,
                    success     : function(data){
                        $('#TabelBantuan').html(data);
                    }
                });
                $('#ModalDeleteBantuan').modal('hide');
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Bantuan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
                $('#NotifikasiHapusBantuan').html('Apakah anda yakin akan menghapus data bantuan ini?');
            }
        }
    })
});

//HELP
//Ketika Tabel Help Muncul Pertama Kali
var ProsesPencarianHelp = $('#ProsesPencarianHelp').serialize();
$('#TabelHelp').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Bantuan/TabelHelp.php',
    data 	    :  ProsesPencarianHelp,
    success     : function(data){
        $('#TabelHelp').html(data);
    }
});

//Pencarian Help Dimulai
$("#ProsesPencarianHelp").submit(function(){
    var ProsesPencarianHelp = $('#ProsesPencarianHelp').serialize();
    $('#TabelHelp').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Bantuan/TabelHelp.php',
        data 	    :  ProsesPencarianHelp,
        success     : function(data){
            $('#TabelHelp').html(data);
        }
    });
});