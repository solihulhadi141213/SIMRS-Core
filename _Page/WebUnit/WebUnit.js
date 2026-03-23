$('#TabelUnit').load("_Page/WebUnit/TabelUnit.php");
tinymce.init({
    selector: '#deskripsi_unit_instalasi',
    plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'table emoticons template paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
    'bullist numlist outdent indent | link image | print preview media fullscreen charmap | ' +
    'forecolor backcolor emoticons | help',
    menu: {
        favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
    },
    menubar: 'favs file edit view insert format tools table help',
    content_css: 'css/content.css',
    images_upload_url: '_Page/Bantuan/postAcceptor.php',
    images_upload_credentials: true,
    images_reuse_filename: true,
    image_title: true,
    /* enable automatic uploads of images represented by blob or data URIs*/
    automatic_uploads: true,
    /*
        URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
        images_upload_url: 'postAcceptor.php',
        here we add custom filepicker only to Image dialog
    */
    file_picker_types: 'image',
    /* and here's our custom image picker*/
    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        /*
        Note: In modern browsers input[type="file"] is functional without
        even adding it to the DOM, but that might not be the case in some older
        or quirky browsers like IE, so you might want to add it to the DOM
        just in case, and visually hide it. And do not forget do remove it
        once you do not need it anymore.
        */

        input.onchange = function () {
        var file = this.files[0];

        var reader = new FileReader();
        reader.onload = function () {
            /*
            Note: Now we need to register the blob in TinyMCEs image blob
            registry. In the next release this part hopefully won't be
            necessary, as we are looking to handle it internally.
            */
            var id = 'blobid' + (new Date()).getTime();
            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);

            /* call the callback and populate the Title field with the file name */
            cb(blobInfo.blobUri(), { title: file.name });
        };
        reader.readAsDataURL(file);
        };

        input.click();
    },
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});
//Proses Tambah Unit
$("#KonfirmasiTambahUnit").click(function(){
    $('#NotifikasiTambahUnit').html('Loading..');
    var nama_unit_instalasi=$('#nama_unit_instalasi').val();
    var deskripsi_unit_instalasi = tinymce.activeEditor.getContent('#deskripsi_unit_instalasi');
    var data = new FormData();
    data.append('file', $('#poster_unit_instalasi')[0].files[0]);
    //Encode Data base 64
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebUnit/EncodeBase64.php",
        data    : data,
        processData:false,
        contentType:false,
        success: function(data) {
            //Simpan ke database
            $.ajax({
                type    : 'POST',
                url     : "_Page/WebUnit/ProsesTambahUnit.php",
                data    : 
                    { 
                        nama_unit_instalasi: nama_unit_instalasi, 
                        deskripsi_unit_instalasi: deskripsi_unit_instalasi, 
                        poster_unit_instalasi: data 
                    },
                success: function(data) {
                    $('#NotifikasiTambahUnit').html(data);
                    var NotifikasiTambahUnitBerhasil=$('#NotifikasiTambahUnitBerhasil').html();
                    if(NotifikasiTambahUnitBerhasil=="Success"){
                        window.location.replace("index.php?Page=WebUnit");
                    }
                }
            });
        }
    });
});
//Modal Detail Unit
$('#ModalDetailUnit').on('show.bs.modal', function (e) {
    var Loading='Loading...';
    var id_unit_instalasi = $(e.relatedTarget).data('id');
    $('#FormDetailUnit').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormDetailUnit.php',
        data 	    :  {id_unit_instalasi: id_unit_instalasi},
        success     : function(data){
            $('#FormDetailUnit').html(data);
        }
    });
});
//Modal Hapus Unit
$('#ModalhapusUnit').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_unit_instalasi = $(e.relatedTarget).data('id');
    $('#FormHapusUnit').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormHapusUnit.php',
        data 	    :  {id_unit_instalasi: id_unit_instalasi},
        success     : function(data){
            $('#FormHapusUnit').html(data);
            $('#KonfirmasiHapusUnit').click(function(){
                $('#NotifikasiHapusUnit').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebUnit/ProsesHapusUnit.php',
                    data 	    :  { id_unit_instalasi: id_unit_instalasi },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusUnit').html(data);
                        var NotifikasiHapusUnitBerhasil=$('#NotifikasiHapusUnitBerhasil').html();
                        if(NotifikasiHapusUnitBerhasil=="Success"){
                            window.location.replace("index.php?Page=WebUnit");
                        }
                    }
                });
            });
        }
    });
});
//Proses Edit Unit
$("#KonfirmasiEditUnit").click(function(){
    $('#NotifikasiEditUnit').html('Loading..');
    var id_unit_instalasi=$('#id_unit_instalasi').val();
    var nama_unit_instalasi=$('#nama_unit_instalasi').val();
    var deskripsi_unit_instalasi = tinymce.activeEditor.getContent('#deskripsi_unit_instalasi');
    var data = new FormData();
    data.append('file', $('#poster_unit_instalasi')[0].files[0]);
    //Encode Data base 64
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebUnit/EncodeBase64.php",
        data    : data,
        processData:false,
        contentType:false,
        success: function(data) {
            //Simpan ke database
            $.ajax({
                type    : 'POST',
                url     : "_Page/WebUnit/ProsesEditUnit.php",
                data    : 
                    { 
                        id_unit_instalasi: id_unit_instalasi, 
                        nama_unit_instalasi: nama_unit_instalasi, 
                        deskripsi_unit_instalasi: deskripsi_unit_instalasi, 
                        poster_unit_instalasi: data 
                    },
                success: function(data) {
                    $('#NotifikasiEditUnit').html(data);
                    var NotifikasiEditUnitBerhasil=$('#NotifikasiEditUnitBerhasil').html();
                    if(NotifikasiEditUnitBerhasil=="Success"){
                        window.location.replace("index.php?Page=WebUnit");
                    }
                }
            });
        }
    });
});
//Modal Hapus Ruang Rawat
$('#ModalHapusRuangRawat').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var ruang_rawat = $(e.relatedTarget).data('id');
    $('#FormHapusRuang').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormHapusRuang.php',
        data 	    :  {ruang_rawat: ruang_rawat},
        success     : function(data){
            $('#FormHapusRuang').html(data);
            $('#KonfirmasiHapusRuang').click(function(){
                $('#NotifikasiHapusRuang').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebUnit/ProsesHapusRuang.php',
                    data 	    :  { ruang_rawat: ruang_rawat },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusRuang').html(data);
                        var NotifikasiHapusRuangBerhasil=$('#NotifikasiHapusRuangBerhasil').html();
                        if(NotifikasiHapusRuangBerhasil=="Success"){
                            $('#TabelRuangRawat').load("_Page/WebUnit/TabelRuangRawat.php");
                            $('#ModalHapusRuangRawat').modal('hide');
                            Swal.fire({
                                title: 'Mantap!',
                                text: 'Hapus Ruang Rawat Berhasil',
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
//Modal Tambah Galeri Unit
$('#ModalTambahGaleri').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_unit_instalasi = $(e.relatedTarget).data('id');
    $('#FormTambahGaleri').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormTambahGaleri.php',
        data 	    :  {id_unit_instalasi: id_unit_instalasi},
        success     : function(data){
            $('#FormTambahGaleri').html(data);
            //Proses Tambah Galeri
            $('#ProsesTambahGaleri').submit(function(){
                $('#NotifikasiTambahGaleri').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesTambahGaleri')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebUnit/ProsesTambahGaleri.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahGaleri').html(data);
                        var NotifikasiTambahGaleriBerhasil=$('#NotifikasiTambahGaleriBerhasil').html();
                        if(NotifikasiTambahGaleriBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Detail Galeri
$('#ModalDetailGaleri').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_galeri = $(e.relatedTarget).data('id');
    $('#FormDetailGaleri').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormDetailGaleri.php',
        data 	    :  {id_web_galeri: id_web_galeri},
        success     : function(data){
            $('#FormDetailGaleri').html(data);
        }
    });
});
//Modal Hapus Galeri
$('#ModalHapusGaleri').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_galeri = $(e.relatedTarget).data('id');
    $('#FormHapusGaleri').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEvent/FormHapusGaleri.php',
        data 	    :  {id_web_galeri: id_web_galeri},
        success     : function(data){
            $('#FormHapusGaleri').html(data);
            $('#KonfirmasiHapusGaleri').click(function(){
                $('#NotifikasiHapusGaleri').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebEvent/ProsesHapusGaleri.php',
                    data 	    :  { id_web_galeri: id_web_galeri },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusGaleri').html(data);
                        var NotifikasiHapusGaleriBerhasil=$('#NotifikasiHapusGaleriBerhasil').html();
                        if(NotifikasiHapusGaleriBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Edit Galeri
$('#ModalEditGaleri').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_galeri = $(e.relatedTarget).data('id');
    $('#FormEditGaleri').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormEditGaleri.php',
        data 	    :  {id_web_galeri: id_web_galeri},
        success     : function(data){
            $('#FormEditGaleri').html(data);
            //Proses Edit Galeri
            $('#ProsesEditGaleri').submit(function(){
                $('#NotifikasiEditGaleri').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesEditGaleri')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebUnit/ProsesEditGaleri.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditGaleri').html(data);
                        var NotifikasiEditGaleriBerhasil=$('#NotifikasiEditGaleriBerhasil').html();
                        if(NotifikasiEditGaleriBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Tambah Anggota Unit
$('#ModalTambahAnggota').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_unit_instalasi = $(e.relatedTarget).data('id');
    $('#FormTambahAnggota').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormTambahAnggota.php',
        data 	    :  {id_unit_instalasi: id_unit_instalasi},
        success     : function(data){
            $('#FormTambahAnggota').html(data);
            //Proses Tambah Anggota
            $('#ProsesTambahAnggota').submit(function(){
                $('#NotifikasiTambahAnggota').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesTambahAnggota')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebUnit/ProsesTambahAnggota.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahAnggota').html(data);
                        var NotifikasiTambahAnggotaBerhasil=$('#NotifikasiTambahAnggotaBerhasil').html();
                        if(NotifikasiTambahAnggotaBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Detail Anggota
$('#ModalDetailAnggota').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_unit_karyawan = $(e.relatedTarget).data('id');
    $('#FormDetailAnggota').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormDetailAnggota.php',
        data 	    :  {id_web_unit_karyawan: id_web_unit_karyawan},
        success     : function(data){
            $('#FormDetailAnggota').html(data);
        }
    });
});
//Modal Hapus Anggota
$('#ModalHapusAnggota').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_unit_karyawan = $(e.relatedTarget).data('id');
    $('#FormHapusAnggota').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormHapusAnggota.php',
        data 	    :  {id_web_unit_karyawan: id_web_unit_karyawan},
        success     : function(data){
            $('#FormHapusAnggota').html(data);
            $('#KonfirmasiHapusAnggota').click(function(){
                $('#NotifikasiHapusAnggota').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebUnit/ProsesHapusAnggota.php',
                    data 	    :  { id_web_unit_karyawan: id_web_unit_karyawan },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusAnggota').html(data);
                        var NotifikasiHapusAnggotaBerhasil=$('#NotifikasiHapusAnggotaBerhasil').html();
                        if(NotifikasiHapusAnggotaBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Edit Anggota Unit
$('#ModalEditAnggota').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_unit_karyawan = $(e.relatedTarget).data('id');
    $('#FormEditAnggota').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebUnit/FormEditAnggota.php',
        data 	    :  {id_web_unit_karyawan: id_web_unit_karyawan},
        success     : function(data){
            $('#FormEditAnggota').html(data);
            //Proses Edit Anggota
            $('#ProsesEditAnggota').submit(function(){
                $('#NotifikasiEditAnggota').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesEditAnggota')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebUnit/ProsesEditAnggota.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditAnggota').html(data);
                        var NotifikasiEditAnggotaBerhasil=$('#NotifikasiEditAnggotaBerhasil').html();
                        if(NotifikasiEditAnggotaBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});