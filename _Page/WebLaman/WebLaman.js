$('#TabelLamanMandiri').load("_Page/WebLaman/TabelLamanMandiri.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelLamanMandiri').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLaman/TabelLamanMandiri.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelLamanMandiri').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelLamanMandiri').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLaman/TabelLamanMandiri.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelLamanMandiri').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLaman/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
tinymce.init({
    selector: '#isi_laman',
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
$("#KlikProsesTambahLaman").click(function(){
    $('#NotifikasiTambahLaman').html('Loading..');
    var penulis=$('#penulis').val();
    var tanggal=$('#tanggal').val();
    var jam=$('#jam').val();
    var judul=$('#judul').val();
    var isi_laman = tinymce.activeEditor.getContent('#isi_laman');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebLaman/ProsesTambahLaman.php",
        data    : 
            { 
                penulis: penulis, 
                tanggal: tanggal, 
                jam: jam, 
                judul: judul, 
                isi_laman: isi_laman
            },
        success: function(data) {
            $('#NotifikasiTambahLaman').html(data);
            var NotifikasiTambahLamanBerhasil=$('#NotifikasiTambahLamanBerhasil').html();
            if(NotifikasiTambahLamanBerhasil=="Success"){
                window.location.replace("index.php?Page=WebLaman");
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
$("#KlikProsesEditLaman").click(function(){
    $('#NotifikasiEditLaman').html('Loading..');
    var id_laman=$('#id_laman').val();
    var penulis=$('#penulis').val();
    var tanggal=$('#tanggal').val();
    var jam=$('#jam').val();
    var judul=$('#judul').val();
    var isi_laman = tinymce.activeEditor.getContent('#isi_laman');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebLaman/ProsesEditLaman.php",
        data    : 
            { 
                id_laman: id_laman, 
                penulis: penulis, 
                tanggal: tanggal, 
                jam: jam, 
                judul: judul, 
                isi_laman: isi_laman
            },
        success: function(data) {
            $('#NotifikasiEditLaman').html(data);
            var NotifikasiEditLamanBerhasil=$('#NotifikasiEditLamanBerhasil').html();
            if(NotifikasiEditLamanBerhasil=="Success"){
                window.location.replace("index.php?Page=WebLaman");
            }
        }
    });
});
//Modal Detail Laman
$('#ModalDetailLaman').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_laman = $(e.relatedTarget).data('id');
    $('#DetailLaman').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLaman/FormDetailLaman.php',
        data 	    :  {id_laman: id_laman},
        success     : function(data){
            $('#DetailLaman').html(data);
        }
    });
});
//Modal Hapus Laman
$('#ModalHapusLaman').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_laman = $(e.relatedTarget).data('id');
    $('#FormHapusLaman').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLaman/FormHapusLaman.php',
        data 	    :  {id_laman: id_laman},
        success     : function(data){
            $('#FormHapusLaman').html(data);
            $('#KonfirmasiHapusLaman').click(function(){
                $('#NotifikasiHapusLaman').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebLaman/ProsesHapusLaman.php',
                    data 	    :  { id_laman: id_laman },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusLaman').html(data);
                        var NotifikasiHapusLamanBerhasil=$('#NotifikasiHapusLamanBerhasil').html();
                        if(NotifikasiHapusLamanBerhasil=="Success"){
                            $('#ModalHapusLaman').modal('hide');
                            var BatasPencarian = $('#BatasPencarian').serialize();
                            var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                            $('#TabelLamanMandiri').html(Loading);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebLaman/TabelLamanMandiri.php',
                                data 	    :  BatasPencarian,
                                success     : function(data){
                                    $('#TabelLamanMandiri').html(data);
                                }
                            });
                            Swal.fire({
                                title: 'Mantap!',
                                text: 'Hapus Laman Berhasil',
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