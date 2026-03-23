$('#MenampilkanTabelPoliklinik').load("_Page/WebPoliklinik/TabelWebPoliklinik.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelPoliklinik').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebPoliklinik/TabelWebPoliklinik.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelPoliklinik').html(data);
        }
    });
});
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebPoliklinik/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelPoliklinik').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebPoliklinik/TabelWebPoliklinik.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelPoliklinik').html(data);
        }
    });
});
tinymce.init({
    selector: '#deskripsi',
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
$("#KlikProsesTambahPoliklinik").click(function(){
    $('#NotifikasiTambahPoliklinik').html('Loading..');
    var nama=$('#nama').val();
    var kode=$('#kode').val();
    var status=$('#status').val();
    var deskripsi = tinymce.activeEditor.getContent('#deskripsi');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebPoliklinik/ProsesTambahPoliklinik.php",
        data    : 
            { 
                nama: nama, 
                kode: kode, 
                status: status, 
                deskripsi: deskripsi 
            },
        success: function(data) {
            $('#NotifikasiTambahPoliklinik').html(data);
            var NotifikasiTambahPoliklinikBerhasil=$('#NotifikasiTambahPoliklinikBerhasil').html();
            if(NotifikasiTambahPoliklinikBerhasil=="Success"){
                window.location.replace("index.php?Page=WebPoliklinik");
            }
        }
    });
});

//Modal Tambah Poliklinik dari SIMRS
$('#ModalAddPoliklinik').on('show.bs.modal', function (e) {
    var Loading='Loading...';
    var id_poliklinik = $(e.relatedTarget).data('id');
    $('#NotifikasiTambahPoliklinikDariSimrs').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebPoliklinik/ProsesAddPoliklinikSimrs.php',
        data 	    :  {id_poliklinik: id_poliklinik},
        success     : function(data){
            $('#NotifikasiTambahPoliklinikDariSimrs').html(data);
            var NotifikasiTambahPoliklinikDariSimrsBerhasil=$('#NotifikasiTambahPoliklinikDariSimrsBerhasil').html();
            if(NotifikasiTambahPoliklinikDariSimrsBerhasil=="Success"){
                window.location.replace("index.php?Page=WebPoliklinik");
            }
        }
    });
});
//Modal Detail Poliklinik
$('#ModalDetailPoliklinik').on('show.bs.modal', function (e) {
    var Loading='Loading...';
    var id_poliklinik = $(e.relatedTarget).data('id');
    $('#FormDetailPoliklinik').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebPoliklinik/FormDetailPoliklinik.php',
        data 	    :  {id_poliklinik: id_poliklinik},
        success     : function(data){
            $('#FormDetailPoliklinik').html(data);
        }
    });
});
//Modal Delete Poliklinik
$('#ModalHapusPoliklinik').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_poliklinik = $(e.relatedTarget).data('id');
    $('#FormHapusPoliklinik').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebPoliklinik/FormHapusPoliklinik.php',
        data 	    :  {id_poliklinik: id_poliklinik},
        success     : function(data){
            $('#FormHapusPoliklinik').html(data);
            $('#KonfirmasiHapusPoliklinik').click(function(){
                $('#NotifikasiHapusPoliklinik').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebPoliklinik/ProsesHapusPoliklinik.php',
                    data 	    :  { id_poliklinik: id_poliklinik },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusPoliklinik').html(data);
                        var NotifikasiHapusPoliklinikBerhasil=$('#NotifikasiHapusPoliklinikBerhasil').html();
                        if(NotifikasiHapusPoliklinikBerhasil=="Success"){
                            window.location.replace("index.php?Page=WebPoliklinik");
                        }
                    }
                });
            });
        }
    });
});
$("#KlikProsesEditPoliklinik").click(function(){
    $('#NotifikasiEditPoliklinik').html('Loading..');
    var id_poliklinik=$('#id_poliklinik').val();
    var nama=$('#nama').val();
    var kode=$('#kode').val();
    var status=$('#status').val();
    var deskripsi = tinymce.activeEditor.getContent('#deskripsi');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebPoliklinik/ProsesEditPoliklinik.php",
        data    : 
            { 
                id_poliklinik: id_poliklinik, 
                nama: nama, 
                kode: kode, 
                status: status, 
                deskripsi: deskripsi 
            },
        success: function(data) {
            $('#NotifikasiEditPoliklinik').html(data);
            var NotifikasiEditPoliklinikBerhasil=$('#NotifikasiEditPoliklinikBerhasil').html();
            if(NotifikasiEditPoliklinikBerhasil=="Success"){
                window.location.replace("index.php?Page=WebPoliklinik");
            }
        }
    });
});