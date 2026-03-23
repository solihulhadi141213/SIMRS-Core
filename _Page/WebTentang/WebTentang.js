//Menangkap Data
var GetSejarah=$('#GetSejarah').html();
var GetVisi=$('#GetVisi').html();
var GetMisi=$('#GetMisi').html();
var GetLokasi=$('#GetLokasi').html();
//Menerapkan masing-masing data ke card
$('#web_sejarah').html(GetSejarah);
$('#web_visi').html(GetVisi);
$('#web_misi').html(GetMisi);
$('#web_lokasi').html(GetLokasi);
//Sejarah
$('#EditSejarah').click(function(){
    tinymce.init({
        selector: '#web_sejarah',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(GetSejarah);
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
    $('#NotifikasiUpdateSejarah').html('<span class="text-primary">Pastikan Konten Tentang sudah benar.</span>');
    $('#TombolEditSejarah').html('');
    $('#TombolSubmitSejarah').html('<button type="button" class="btn btn-md btn-primary" id="ProsesUpdateSejarah"><i class="ti-save"></i> Simpan</button>');
    //Ketika Disimpan
    $('#ProsesUpdateSejarah').click(function(){
        $('#NotifikasiUpdateSejarah').html('<span class="text-primary">Loading...</span>');
        var isiSejarah = tinymce.activeEditor.getContent();
        $.ajax({
            type    : 'POST',
            url     : "_Page/WebTentang/ProsesUpdateTentang.php",
            data    : { GetSejarah: isiSejarah, GetVisi: GetVisi, GetMisi: GetMisi, GetLokasi: GetLokasi},
            success: function(data) {
                $('#NotifikasiUpdateSejarah').html(data);
                var NotifikasiUpdateSejarahBerhasil=$('#NotifikasiUpdateTentangBerhasil').html();
                if(NotifikasiUpdateSejarahBerhasil=="Success"){
                    window.location.reload();
                }
            }
        });
    });
});
//Visi
$('#EditVisi').click(function(){
    tinymce.init({
        selector: '#web_visi',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(GetVisi);
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
    $('#NotifikasiUpdateVisi').html('<span class="text-primary">Pastikan Konten Tentang sudah benar.</span>');
    $('#TombolEditVisi').html('');
    $('#TombolSubmitVisi').html('<button type="button" class="btn btn-md btn-primary" id="ProsesUpdateVisi"><i class="ti-save"></i> Simpan</button>');
    //Ketika Disimpan
    $('#ProsesUpdateVisi').click(function(){
        $('#NotifikasiUpdateVisi').html('<span class="text-primary">Loading...</span>');
        var isiVisi = tinymce.activeEditor.getContent();
        $.ajax({
            type    : 'POST',
            url     : "_Page/WebTentang/ProsesUpdateTentang.php",
            data    : { GetSejarah: GetSejarah, GetVisi: isiVisi, GetMisi: GetMisi, GetLokasi: GetLokasi},
            success: function(data) {
                $('#NotifikasiUpdateVisi').html(data);
                var NotifikasiUpdateTentangBerhasil=$('#NotifikasiUpdateTentangBerhasil').html();
                if(NotifikasiUpdateTentangBerhasil=="Success"){
                    window.location.reload();
                }
            }
        });
    });
});
//Misi
$('#EditMisi').click(function(){
    tinymce.init({
        selector: '#web_misi',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(GetMisi);
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
    $('#NotifikasiUpdateMisi').html('<span class="text-primary">Pastikan Konten Tentang sudah benar.</span>');
    $('#TombolEditMisi').html('');
    $('#TombolSubmitMisi').html('<button type="button" class="btn btn-md btn-primary" id="ProsesUpdateMisi"><i class="ti-save"></i> Simpan</button>');
    //Ketika Disimpan
    $('#ProsesUpdateMisi').click(function(){
        $('#NotifikasiUpdateMisi').html('<span class="text-primary">Loading...</span>');
        var isiMisi = tinymce.activeEditor.getContent();
        $.ajax({
            type    : 'POST',
            url     : "_Page/WebTentang/ProsesUpdateTentang.php",
            data    : { GetSejarah: GetSejarah, GetVisi: GetVisi, GetMisi: isiMisi, GetLokasi: GetLokasi},
            success: function(data) {
                $('#NotifikasiUpdateMisi').html(data);
                var NotifikasiUpdateTentangBerhasil=$('#NotifikasiUpdateTentangBerhasil').html();
                if(NotifikasiUpdateTentangBerhasil=="Success"){
                    window.location.reload();
                }
            }
        });
    });
});
//Lokasi
$('#EditLokasi').click(function(){
    tinymce.init({
        selector: '#web_lokasi',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(GetLokasi);
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
    $('#NotifikasiUpdateLokasi').html('<span class="text-primary">Pastikan Konten Tentang sudah benar.</span>');
    $('#TombolEditLokasi').html('');
    $('#TombolSubmitLokasi').html('<button type="button" class="btn btn-md btn-primary" id="ProsesUpdateLokasi"><i class="ti-save"></i> Simpan</button>');
    //Ketika Disimpan
    $('#ProsesUpdateLokasi').click(function(){
        $('#NotifikasiUpdateLokasi').html('<span class="text-primary">Loading...</span>');
        var isiLokasi = tinymce.activeEditor.getContent();
        $.ajax({
            type    : 'POST',
            url     : "_Page/WebTentang/ProsesUpdateTentang.php",
            data    : { GetSejarah: GetSejarah, GetVisi: GetVisi, GetMisi: GetMisi, GetLokasi: isiLokasi},
            success: function(data) {
                $('#NotifikasiUpdateLokasi').html(data);
                var NotifikasiUpdateTentangBerhasil=$('#NotifikasiUpdateTentangBerhasil').html();
                if(NotifikasiUpdateTentangBerhasil=="Success"){
                    window.location.reload();
                }
            }
        });
    });
});


