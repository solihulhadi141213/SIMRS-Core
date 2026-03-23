$('#TabelFooterMenu').load("_Page/WebFooter/TabelFooterMenu.php");
//Ketika kategori Berubah
$('#GetKategori').change(function(){
    var GetKategori = $('#GetKategori').val();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelFooterMenu').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFooter/TabelFooterMenu.php',
        data 	    :  {kategori: GetKategori},
        success     : function(data){
            $('#TabelFooterMenu').html(data);
        }
    });
});
//Proses Tambah Footer Menu
$('#ProsesTambahFooterMenu').submit(function(){
    var ProsesTambahFooterMenu = $('#ProsesTambahFooterMenu').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiTambahFooterMenu').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFooter/ProsesTambahFooterMenu.php',
        data 	    :  ProsesTambahFooterMenu,
        success     : function(data){
            $('#NotifikasiTambahFooterMenu').html(data);
            var NotifikasiTambahFooterMenuBerhasil=$('#NotifikasiTambahFooterMenuBerhasil').html();
            if(NotifikasiTambahFooterMenuBerhasil=="Success"){
                $('#TabelFooterMenu').load("_Page/WebFooter/TabelFooterMenu.php");
                $('#ProsesTambahFooterMenu')[0].reset();
                $('#ModalTambahFooterMenu').modal('hide');
                Swal.fire({
                    title: 'Mantap!',
                    text: 'Tambah Footer Menu Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit FooterMenu
$('#ModalEditFooterMenu').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_menu = $(e.relatedTarget).data('id');
    $('#FormEditFooterMenu').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFooter/FormEditFooterMenu.php',
        data 	    :  {id_web_menu: id_web_menu},
        success     : function(data){
            $('#FormEditFooterMenu').html(data);
        }
    });
});
//Proses Edit Sitemap
$('#ProsesEditFooterMenu').submit(function(){
    var ProsesEditFooterMenu = $('#ProsesEditFooterMenu').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiEditFooterMenu').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFooter/ProsesEditFooterMenu.php',
        data 	    :  ProsesEditFooterMenu,
        success     : function(data){
            $('#NotifikasiEditFooterMenu').html(data);
            var NotifikasiEditFooterMenuBerhasil=$('#NotifikasiEditFooterMenuBerhasil').html();
            if(NotifikasiEditFooterMenuBerhasil=="Success"){
                $('#TabelFooterMenu').load("_Page/WebFooter/TabelFooterMenu.php");
                $('#ModalEditFooterMenu').modal('hide');
                Swal.fire({
                    title: 'Mantap!',
                    text: 'Edit Footer Menu Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Footer Menu
$('#ModalHapusFooterMenu').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_menu = $(e.relatedTarget).data('id');
    $('#FormHapusFooterMenu').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFooter/FormHapusFooterMenu.php',
        data 	    :  {id_web_menu: id_web_menu},
        success     : function(data){
            $('#FormHapusFooterMenu').html(data);
            $('#KonfirmasiHapusFooterMenu').click(function(){
                $('#NotifikasiHapusFooterMenu').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebFooter/ProsesHapusFooterMenu.php',
                    data 	    :  { id_web_menu: id_web_menu },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusFooterMenu').html(data);
                        var NotifikasiHapusFooterMenuBerhasil=$('#NotifikasiHapusFooterMenuBerhasil').html();
                        if(NotifikasiHapusFooterMenuBerhasil=="Success"){
                            $('#TabelFooterMenu').load("_Page/WebFooter/TabelFooterMenu.php");
                            $('#ModalHapusFooterMenu').modal('hide');
                            Swal.fire({
                                title: 'Mantap!',
                                text: 'Hapus Footer Menu Berhasil',
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