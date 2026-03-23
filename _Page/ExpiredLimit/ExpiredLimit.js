//Membaca parameter pertama kali
var CategoryData = $('#CategoryData').val();
var GetPutPage = $('#GetPutPage').val();
if(CategoryData=="ExpiredItem"){
    var BatasExpiredLimit = $('#BatasExpiredLimit').serialize();
    $('#TabelExpiredLimit').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ExpiredLimit/TabelExpiredItem.php',
        data 	    :  BatasExpiredLimit,
        success     : function(data){
            $('#TabelExpiredLimit').html(data);
        }
    });
}else{
    var BatasExpiredLimit = $('#BatasExpiredLimit').serialize();
    $('#TabelExpiredLimit').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ExpiredLimit/TabelLimitItem.php',
        data 	    :  BatasExpiredLimit,
        success     : function(data){
            $('#TabelExpiredLimit').html(data);
        }
    });
}
//Ketika Batas Diubah
$('#batas').change(function(){
    var BatasExpiredLimit = $('#BatasExpiredLimit').serialize();
    if(CategoryData=="ExpiredItem"){
        $('#TabelExpiredLimit').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ExpiredLimit/TabelExpiredItem.php',
            data 	    :  BatasExpiredLimit,
            success     : function(data){
                $('#TabelExpiredLimit').html(data);
            }
        });
    }else{
        $('#TabelExpiredLimit').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ExpiredLimit/TabelLimitItem.php',
            data 	    :  BatasExpiredLimit,
            success     : function(data){
                $('#TabelExpiredLimit').html(data);
            }
        });
    }
});
//Ketika Pencarian Dilakukan
$('#BatasExpiredLimit').submit(function(){
    var BatasExpiredLimit = $('#BatasExpiredLimit').serialize();
    if(CategoryData=="ExpiredItem"){
        $('#TabelExpiredLimit').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ExpiredLimit/TabelExpiredItem.php',
            data 	    :  BatasExpiredLimit,
            success     : function(data){
                $('#TabelExpiredLimit').html(data);
            }
        });
    }else{
        $('#TabelExpiredLimit').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ExpiredLimit/TabelLimitItem.php',
            data 	    :  BatasExpiredLimit,
            success     : function(data){
                $('#TabelExpiredLimit').html(data);
            }
        });
    }
});
//Ketika Dasar Pencarian Diubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ExpiredLimit/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});

//ketika modal edit expired muncul
$('#ModalEditExpiredItem').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_obat_expired = pecah[0];
    var page = pecah[1];
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiEditExpired').html('<span>Pastikan informasi data expired item sudah sesuai dengan benar.</span>');
    $('#FormEditExpiredItem').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ExpiredLimit/FormEditExpiredItem.php',
        data 	    :  {id_obat_expired: id_obat_expired, page: page},
        success     : function(data){
            $('#FormEditExpiredItem').html(data);
        }
    });
});
//Simpan edit expired
$('#ProsesEditExpiredItem').submit(function(){
    var ProsesEditExpiredItem = $('#ProsesEditExpiredItem').serialize();
    $('#NotifikasiEditExpired').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ExpiredLimit/ProsesEditExpiredItem.php',
        data 	    :  ProsesEditExpiredItem,
        success     : function(data){
            $('#NotifikasiEditExpired').html(data);
            var NotifikasiEditExpiredBerhasil=$('#NotifikasiEditExpiredBerhasil').html();
            if(NotifikasiEditExpiredBerhasil=="Success"){
                var batas=$('#batas').val();
                var keyword=$('#keyword').val();
                var keyword_by=$('#keyword_by').val();
                $.ajax({
                    url     : "_Page/ExpiredLimit/TabelExpiredItem.php",
                    method  : "POST",
                    data 	:  { page: GetPutPage, batas: batas, keyword: keyword,  keyword_by: keyword_by },
                    success: function (data) {
                        $('#TabelExpiredLimit').html(data);
                    }
                })
                //Sembunyikan modal
                $('#ModalEditExpiredItem').modal('hide');
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Edit Expired Item Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Kondisi Ketika Modal Hapus Expired Item Muncul
$('#ModalHapusExpiredItem').on('show.bs.modal', function (e) {
    var id_obat_expired = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiHapusExpiredItem').html('<span class="text-primary">Apakah anda yakin akan menghapus data ini?</span>');
    $('#FormHapusExpiredItem').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ExpiredLimit/FormHapusExpiredItem.php',
        data 	    :  {id_obat_expired: id_obat_expired},
        success     : function(data){
            $('#FormHapusExpiredItem').html(data);
        }
    });
});
//Kondisi Ketika Proses Hapus Dimulai
$('#ProsesHapusExpiredItem').submit(function(){
    var ProsesHapusExpiredItem = $('#ProsesHapusExpiredItem').serialize();
    $('#NotifikasiHapusExpiredItem').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ExpiredLimit/ProsesHapusExpiredItem.php',
        data 	    :  ProsesHapusExpiredItem,
        success     : function(data){
            $('#NotifikasiHapusExpiredItem').html(data);
            var NotifikasiHapusExpiredItemBerhasil=$('#NotifikasiHapusExpiredItemBerhasil').html();
            if(NotifikasiHapusExpiredItemBerhasil=="Success"){
                var GetPutPage = $('#GetPutPage').val();
                var batas=$('#batas').val();
                var keyword=$('#keyword').val();
                var keyword_by=$('#keyword_by').val();
                $.ajax({
                    url     : "_Page/ExpiredLimit/TabelExpiredItem.php",
                    method  : "POST",
                    data 	:  { page: GetPutPage, batas: batas, keyword: keyword,  keyword_by: keyword_by },
                    success: function (data) {
                        $('#TabelExpiredLimit').html(data);
                    }
                })
                //Sembunyikan modal
                $('#ModalHapusExpiredItem').modal('hide');
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Hapus Expired Item Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Kondisi Ketika Detail Item Obat Muncul
$('#ModalDetailObat').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
    $('#FormDetailItem').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ExpiredLimit/FormDetailItem.php',
        data 	    :  {id_obat: id_obat},
        success     : function(data){
            $('#FormDetailItem').html(data);
        }
    });
});
//Kondisi Ketika Modal Cetak Data Muncul
$('#ModalCetakExpiredItem').on('show.bs.modal', function (e) {
    var CategoryData = $('#CategoryData').val();
    if(CategoryData=="ExpiredItem"){
        $("#ExpiredItem").prop("checked", true);
        $("#LimitItem").prop("checked", false);
    }else{
        $("#ExpiredItem").prop("checked", false);
        $("#LimitItem").prop("checked", true);
    }
});
