$('#TabelHubungiAdmin').load("_Page/WebHubungiAdmin/TabelHubungiAdmin.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelHubungiAdmin').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebHubungiAdmin/TabelHubungiAdmin.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelHubungiAdmin').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelHubungiAdmin').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebHubungiAdmin/TabelHubungiAdmin.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelHubungiAdmin').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebHubungiAdmin/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Modal Detail Pesan
$('#ModalDetailPesan').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_pesan = $(e.relatedTarget).data('id');
    $('#FormDetailPesan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebHubungiAdmin/FormDetailPesan.php',
        data 	    :  {id_pesan: id_pesan},
        success     : function(data){
            $('#FormDetailPesan').html(data);
        }
    });
});
//Modal Edit Pesan
$('#ModalEditPesan').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_pesan = $(e.relatedTarget).data('id');
    $('#FormEditPesan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebHubungiAdmin/FormEditPesan.php',
        data 	    :  {id_pesan: id_pesan},
        success     : function(data){
            $('#FormEditPesan').html(data);
            //Proses Edit Pesan
            $('#ProsesEditPesan').submit(function(){
                var ProsesEditPesan = $('#ProsesEditPesan').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#NotifikasiEditPesan').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebHubungiAdmin/ProsesEditPesan.php',
                    data 	    :  ProsesEditPesan,
                    success     : function(data){
                        $('#NotifikasiEditPesan').html(data);
                        var NotifikasiEditPesanBerhasil=$('#NotifikasiEditPesanBerhasil').html();
                        if(NotifikasiEditPesanBerhasil=="Success"){
                            $('#TabelHubungiAdmin').load("_Page/WebHubungiAdmin/TabelHubungiAdmin.php");
                            $('#ModalEditPesan').modal('hide');
                            Swal.fire({
                                title: 'Mantap!',
                                text: 'Edit Pesan Berhasil',
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
//Modal Hapus Pesan
$('#ModalHapusPesan').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_pesan = $(e.relatedTarget).data('id');
    $('#FormHapusPesan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebHubungiAdmin/FormHapusPesan.php',
        data 	    :  {id_pesan: id_pesan},
        success     : function(data){
            $('#FormHapusPesan').html(data);
            $('#KonfirmasiHapus').click(function(){
                $('#NotifikasiHapus').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebHubungiAdmin/ProsesHapus.php',
                    data 	    :  { id_pesan: id_pesan },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapus').html(data);
                        var NotifikasiHapusBerhasil=$('#NotifikasiHapusBerhasil').html();
                        if(NotifikasiHapusBerhasil=="Success"){
                            $('#TabelHubungiAdmin').load("_Page/WebHubungiAdmin/TabelHubungiAdmin.php");
                            $('#ModalHapusPesan').modal('hide');
                            Swal.fire({
                                title: 'Mantap!',
                                text: 'Hapus Pesan Berhasil',
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