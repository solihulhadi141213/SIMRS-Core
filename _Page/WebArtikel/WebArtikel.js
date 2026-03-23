$('#MenampilkanTabelArtikel').load("_Page/WebArtikel/TabelWebArtikel.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelArtikel').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArtikel/TabelWebArtikel.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelArtikel').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelArtikel').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArtikel/TabelWebArtikel.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelArtikel').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArtikel/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
tinymce.init({
    selector: '#artikel_isi',
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
$("#KlikProsesTambahArtikel").click(function(){
    $('#NotifikasiTambahArtikel').html('Loading..');
    var artikel_judul=$('#artikel_judul').val();
    var artikel_kategori=$('#artikel_kategori').val();
    var artikel_tanggal=$('#artikel_tanggal').val();
    var artikel_jam=$('#artikel_jam').val();
    var artikel_penulis=$('#artikel_penulis').val();
    var artikel_ringkasan=$('#artikel_ringkasan').val();
    var artikel_status=$('#artikel_status').val();
    var artikel_isi = tinymce.activeEditor.getContent('#artikel_isi');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebArtikel/ProsesTambahArtikel.php",
        data    : 
            { 
                artikel_judul: artikel_judul, 
                artikel_kategori: artikel_kategori, 
                artikel_tanggal: artikel_tanggal, 
                artikel_jam: artikel_jam, 
                artikel_penulis: artikel_penulis, 
                artikel_ringkasan: artikel_ringkasan, 
                artikel_status: artikel_status, 
                artikel_isi: artikel_isi 
            },
        success: function(data) {
            $('#NotifikasiTambahArtikel').html(data);
            var NotifikasiTambahArtikelBerhasil=$('#NotifikasiTambahArtikelBerhasil').html();
            if(NotifikasiTambahArtikelBerhasil=="Success"){
                window.location.replace("index.php?Page=WebArtikel");
            }
        }
    });
});

var KontentIsiArtikel=$('#artikel_isi_edit').html();
$("#MulaiEditArtikel").click(function(){
    $('#artikel_judul').attr('readonly', false);
    $('#artikel_kategori').attr('readonly', false);
    $('#artikel_tanggal').attr('readonly', false);
    $('#artikel_jam').attr('readonly', false);
    $('#artikel_penulis').attr('readonly', false);
    $('#artikel_ringkasan').attr('readonly', false);
    $('#artikel_status').attr('disabled', false);
    tinymce.init({
        selector: '#artikel_isi_edit',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(KontentIsiArtikel);
            });
        },
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
});
$("#KlikProsesEditArtikel").click(function(){
    $('#NotifikasiEditArtikel').html('Loading..');
    var id_web_artikel=$('#id_web_artikel').val();
    var artikel_judul=$('#artikel_judul').val();
    var artikel_kategori=$('#artikel_kategori').val();
    var artikel_tanggal=$('#artikel_tanggal').val();
    var artikel_jam=$('#artikel_jam').val();
    var artikel_penulis=$('#artikel_penulis').val();
    var artikel_ringkasan=$('#artikel_ringkasan').val();
    var artikel_status=$('#artikel_status').val();
    var artikel_isi = tinymce.activeEditor.getContent('#artikel_isi_edit');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebArtikel/ProsesEditArtikel.php",
        data    : 
            { 
                id_web_artikel: id_web_artikel, 
                artikel_judul: artikel_judul, 
                artikel_kategori: artikel_kategori, 
                artikel_tanggal: artikel_tanggal, 
                artikel_jam: artikel_jam, 
                artikel_penulis: artikel_penulis, 
                artikel_ringkasan: artikel_ringkasan, 
                artikel_status: artikel_status, 
                artikel_isi: artikel_isi 
            },
        success: function(data) {
            $('#NotifikasiEditArtikel').html(data);
            var NotifikasiEditArtikelBerhasil=$('#NotifikasiEditArtikelBerhasil').html();
            if(NotifikasiEditArtikelBerhasil=="Success"){
                window.location.replace("index.php?Page=WebArtikel");
            }
        }
    });
});
//Modal Detail Artikel
$('#ModalDetailArtikel').on('show.bs.modal', function (e) {
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    var id_web_artikel = $(e.relatedTarget).data('id');
    $('#DetailArtikel').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArtikel/DetailArtikel.php',
        data 	    :  {id_web_artikel: id_web_artikel},
        success     : function(data){
            $('#DetailArtikel').html(data);
        }
    });
});
//Modal Delete Met Tag
$('#ModalHapustArtikel').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_artikel = $(e.relatedTarget).data('id');
    $('#FormHapusArtikel').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArtikel/FormHapusArtikel.php',
        data 	    :  {id_web_artikel: id_web_artikel},
        success     : function(data){
            $('#FormHapusArtikel').html(data);
            $('#KonfirmasiHapusArtikel').click(function(){
                $('#NotifikasiHapusArtikel').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebArtikel/ProsesHapusArtikel.php',
                    data 	    :  { id_web_artikel: id_web_artikel },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusArtikel').html(data);
                        var NotifikasiHapusArtikelBerhasil=$('#NotifikasiHapusArtikelBerhasil').html();
                        if(NotifikasiHapusArtikelBerhasil=="Success"){
                            window.location.replace("index.php?Page=WebArtikel");
                        }
                    }
                });
            });
        }
    });
});