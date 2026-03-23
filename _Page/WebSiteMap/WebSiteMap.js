$('#TabelSitemap').load("_Page/WebSiteMap/TabelSitemap.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelSitemap').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/TabelSitemap.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelSitemap').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelSitemap').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/TabelSitemap.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelSitemap').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Proses Tambah Sitemap
$('#ProsesTambahSitemap').submit(function(){
    var ProsesTambahSitemap = $('#ProsesTambahSitemap').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiTambahSitemap').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/ProsesTambahSitemap.php',
        data 	    :  ProsesTambahSitemap,
        success     : function(data){
            $('#NotifikasiTambahSitemap').html(data);
            var NotifikasiTambahSitemapBerhasil=$('#NotifikasiTambahSitemapBerhasil').html();
            if(NotifikasiTambahSitemapBerhasil=="Success"){
                $('#TabelSitemap').load("_Page/WebSiteMap/TabelSitemap.php");
                $('#ProsesTambahSitemap')[0].reset();
                $('#ModalTambahSitemap').modal('hide');
                Swal.fire({
                    title: 'Mantap!',
                    text: 'Tambah Sitemap Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Detail Sitemap
$('#ModalViewPage').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_sitemap = $(e.relatedTarget).data('id');
    $('#FormDetailSitemap').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/FormDetailSitemap.php',
        data 	    :  {id_web_sitemap: id_web_sitemap},
        success     : function(data){
            $('#FormDetailSitemap').html(data);
        }
    });
});
//Modal Edit Sitemap
$('#ModalEditSitemap').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_sitemap = $(e.relatedTarget).data('id');
    $('#FormEditSitemap').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/FormEditSitemap.php',
        data 	    :  {id_web_sitemap: id_web_sitemap},
        success     : function(data){
            $('#FormEditSitemap').html(data);
        }
    });
});
//Proses Edit Sitemap
$('#ProsesEditSitemap').submit(function(){
    var ProsesEditSitemap = $('#ProsesEditSitemap').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiEditSitemap').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/ProsesEditSitemap.php',
        data 	    :  ProsesEditSitemap,
        success     : function(data){
            $('#NotifikasiEditSitemap').html(data);
            var NotifikasiEditSitemapBerhasil=$('#NotifikasiEditSitemapBerhasil').html();
            if(NotifikasiEditSitemapBerhasil=="Success"){
                $('#TabelSitemap').load("_Page/WebSiteMap/TabelSitemap.php");
                $('#ProsesEditSitemap')[0].reset();
                $('#ModalEditSitemap').modal('hide');
                Swal.fire({
                    title: 'Mantap!',
                    text: 'Edit Sitemap Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Proses Edit Pesan
$('#ProsesEditPesan').submit(function(){
    var ProsesEditPesan = $('#ProsesEditPesan').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiEditPesan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/ProsesEditPesan.php',
        data 	    :  ProsesEditPesan,
        success     : function(data){
            $('#NotifikasiEditPesan').html(data);
            var NotifikasiEditPesanBerhasil=$('#NotifikasiEditPesanBerhasil').html();
            if(NotifikasiEditPesanBerhasil=="Success"){
                $('#TabelSitemap').load("_Page/WebSiteMap/TabelSitemap.php");
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
//Modal Hapus Sitemap
$('#ModalHapusSitemap').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_sitemap = $(e.relatedTarget).data('id');
    $('#FormHapusSitemap').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSiteMap/FormHapusSitemap.php',
        data 	    :  {id_web_sitemap: id_web_sitemap},
        success     : function(data){
            $('#FormHapusSitemap').html(data);
            $('#KonfirmasiSitemap').click(function(){
                $('#NotifikasiHapus').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSiteMap/ProsesHapus.php',
                    data 	    :  { id_web_sitemap: id_web_sitemap },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapus').html(data);
                        var NotifikasiHapusBerhasil=$('#NotifikasiHapusBerhasil').html();
                        if(NotifikasiHapusBerhasil=="Success"){
                            $('#TabelSitemap').load("_Page/WebSiteMap/TabelSitemap.php");
                            $('#ModalHapusSitemap').modal('hide');
                            Swal.fire({
                                title: 'Mantap!',
                                text: 'Hapus Sitemap Berhasil',
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