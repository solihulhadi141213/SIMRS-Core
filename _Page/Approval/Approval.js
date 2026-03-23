var PencarianApproval = $('#PencarianApproval').serialize();
var Loading='<tr><td class="text-center text-danger" colspan="6">Loading..</td></tr>';
$('#TabelApproval').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Approval/TabelApproval.php',
    data 	    :  PencarianApproval,
    success     : function(data){
        $('#TabelApproval').html(data);
    }
});
//Proses Pencarian Approval
$('#PencarianApproval').submit(function(){
    var PencarianApproval = $('#PencarianApproval').serialize();
    var Loading='<tr><td class="text-center text-danger" colspan="6">Loading..</td></tr>';
    $('#TabelApproval').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Approval/TabelApproval.php',
        data 	    :  PencarianApproval,
        success     : function(data){
            $('#TabelApproval').html(data);
        }
    });
});
//Proses Kirim Approval
$('#ProsesKirimApproval').submit(function(){
    var ProsesKirimApproval = $('#ProsesKirimApproval').serialize();
    var Loading='<span class="text-primary">Loading...</span>';
    $('#NotifikasiTambahApproval').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Approval/ProsesTambahApproval.php',
        data 	    :  ProsesKirimApproval,
        success     : function(data){
            $('#NotifikasiTambahApproval').html(data);
            var NotifikasiTambahApprovalBerhasil= $('#NotifikasiTambahApprovalBerhasil').html();
            if(NotifikasiTambahApprovalBerhasil=="Success"){
                var PencarianApproval = $('#PencarianApproval').serialize();
                var Loading='<tr><td class="text-center text-danger" colspan="6">Loading..</td></tr>';
                $('#TabelApproval').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Approval/TabelApproval.php',
                    data 	    :  PencarianApproval,
                    success     : function(data){
                        $('#TabelApproval').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Kirim Approval Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
                $('#NotifikasiTambahApproval').html('<span class="text-primary">Pastikan Data Permintaan Approval Yang Anda kirim Sudah Benar</span>');
                $('#ModalTambahApproval').modal('hide');
                $("#ProsesKirimApproval")[0].reset();
            }
        }
    });
});
//Modal Update Approval
$('#ModalUpdateApprovalSimrs').on('show.bs.modal', function (e) {
    var id_approval = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center text-danger">Loading..</div></div>';
    $('#FormUpdateApprovalSimrs').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Approval/FormUpdateApprovalSimrs.php',
        data 	    :  {id_approval: id_approval},
        success     : function(data){
            $('#FormUpdateApprovalSimrs').html(data);
            $('#KonfirmasiUpdateApproval').click(function(){
                $('#NotifikasiUpdateApproval').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Approval/ProsesUpdateApproval.php',
                    data 	    :  { id_approval: id_approval },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiUpdateApproval').html(data);
                        var NotifikasiUpdateApprovalBerhasil=$('#NotifikasiUpdateApprovalBerhasil').html();
                        if(NotifikasiUpdateApprovalBerhasil=="Success"){
                            var PencarianApproval = $('#PencarianApproval').serialize();
                            var Loading='<tr><td class="text-center text-danger" colspan="6">Loading..</td></tr>';
                            $('#TabelApproval').html(Loading);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Approval/TabelApproval.php',
                                data 	    :  PencarianApproval,
                                success     : function(data){
                                    $('#TabelApproval').html(data);
                                }
                            });
                            $('#ModalUpdateApprovalSimrs').modal('hide');
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Update Approval Berhasil',
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
//Modal Detail Approval
$('#ModalDetailApprovalSimrs').on('show.bs.modal', function (e) {
    var id_approval = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center text-danger">Loading..</div></div>';
    $('#FormDetailApprovalSimrs').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Approval/FormDetailApprovalSimrs.php',
        data 	    :  {id_approval: id_approval},
        success     : function(data){
            $('#FormDetailApprovalSimrs').html(data);
        }
    });
});
//Modal Hapus Approval
$('#ModalHapusApprovalSimrs').on('show.bs.modal', function (e) {
    var id_approval = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center text-danger">Loading..</div></div>';
    $('#FormHapusApprovalSimrs').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Approval/FormHapusApprovalSimrs.php',
        data 	    :  {id_approval: id_approval},
        success     : function(data){
            $('#FormHapusApprovalSimrs').html(data);
            $('#KonfirmasiHapusApproval').click(function(){
                $('#NotifikasiHapusApproval').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Approval/ProsesHapusApproval.php',
                    data 	    :  { id_approval: id_approval },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusApproval').html(data);
                        var NotifikasiHapusApprovalBerhasil=$('#NotifikasiHapusApprovalBerhasil').html();
                        if(NotifikasiHapusApprovalBerhasil=="Success"){
                            var PencarianApproval = $('#PencarianApproval').serialize();
                            var Loading='<tr><td class="text-center text-danger" colspan="6">Loading..</td></tr>';
                            $('#TabelApproval').html(Loading);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Approval/TabelApproval.php',
                                data 	    :  PencarianApproval,
                                success     : function(data){
                                    $('#TabelApproval').html(data);
                                }
                            });
                            $('#ModalHapusApprovalSimrs').modal('hide');
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Approval Berhasil',
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