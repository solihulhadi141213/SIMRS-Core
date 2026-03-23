$('#MenampilkanTabelEvent').load("_Page/WebEvent/TabelWebEvent.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelEvent').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEvent/TabelWebEvent.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelEvent').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEvent/FormKeyword.php',
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
    $('#MenampilkanTabelEvent').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEvent/TabelWebEvent.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelEvent').html(data);
        }
    });
});

tinymce.init({
    selector: '#deskripsi_event',
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

$("#KlikProsesTambahAlbumEvent").click(function(){
    $('#NotifikasiTambahEvent').html('Loading..');
    var nama_event=$('#nama_event').val();
    var kategori_event=$('#kategori_event').val();
    var tanggal_event=$('#tanggal_event').val();
    var jam_event=$('#jam_event').val();
    var deskripsi_event = tinymce.activeEditor.getContent('#deskripsi_event');
    var data = new FormData();
    data.append('file', $('#poster_event')[0].files[0]);
    //Encode Data base 64
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebEvent/EncodeBase64.php",
        data    : data,
        processData:false,
        contentType:false,
        success: function(data) {
            //Simpan ke database
            $.ajax({
                type    : 'POST',
                url     : "_Page/WebEvent/ProsesTambahEvent.php",
                data    : 
                    { 
                        nama_event: nama_event, 
                        kategori_event: kategori_event, 
                        tanggal_event: tanggal_event, 
                        jam_event: jam_event, 
                        deskripsi_event: deskripsi_event, 
                        poster_event: data 
                    },
                success: function(data) {
                    $('#NotifikasiTambahEvent').html(data);
                    var NotifikasiTambahEventBerhasil=$('#NotifikasiTambahEventBerhasil').html();
                    if(NotifikasiTambahEventBerhasil=="Success"){
                        window.location.replace("index.php?Page=WebEvent");
                    }
                }
            });
        }
    });
});
$("#KlikProsesEditAlbumEvent").click(function(){
    $('#NotifikasiEditEvent').html('Loading..');
    var id_web_event=$('#id_web_event').val();
    var nama_event=$('#nama_event').val();
    var kategori_event=$('#kategori_event').val();
    var tanggal_event=$('#tanggal_event').val();
    var jam_event=$('#jam_event').val();
    var deskripsi_event = tinymce.activeEditor.getContent('#deskripsi_event');
    var data = new FormData();
    data.append('file', $('#poster_event')[0].files[0]);
    //Encode Data base 64
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebEvent/EncodeBase64.php",
        data    : data,
        processData:false,
        contentType:false,
        success: function(data) {
            //Simpan ke database
            $.ajax({
                type    : 'POST',
                url     : "_Page/WebEvent/ProsesEditEvent.php",
                data    : 
                    { 
                        id_web_event: id_web_event, 
                        nama_event: nama_event, 
                        kategori_event: kategori_event, 
                        tanggal_event: tanggal_event, 
                        jam_event: jam_event, 
                        deskripsi_event: deskripsi_event, 
                        poster_event: data 
                    },
                success: function(data) {
                    $('#NotifikasiEditEvent').html(data);
                    var NotifikasiEditEventBerhasil=$('#NotifikasiEditEventBerhasil').html();
                    if(NotifikasiEditEventBerhasil=="Success"){
                        window.location.replace("index.php?Page=WebEvent");
                    }
                }
            });
        }
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
//Modal Hapus Event
$('#ModalHapusEvent').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_event = $(e.relatedTarget).data('id');
    $('#FormHapusEvent').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEvent/FormHapusEvent.php',
        data 	    :  {id_web_event: id_web_event},
        success     : function(data){
            $('#FormHapusEvent').html(data);
            $('#KonfirmasiHapusEvent').click(function(){
                $('#NotifikasiHapusEvent').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebEvent/ProsesHapusEvent.php',
                    data 	    :  { id_web_event: id_web_event },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusEvent').html(data);
                        var NotifikasiHapusEventBerhasil=$('#NotifikasiHapusEventBerhasil').html();
                        if(NotifikasiHapusEventBerhasil=="Success"){
                            window.location.replace("index.php?Page=WebEvent");
                        }
                    }
                });
            });
        }
    });
});
//Modal Detail Event
$('#ModalDetailEvent').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_event = $(e.relatedTarget).data('id');
    $('#FormDetailArtikel').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEvent/FormDetailArtikel.php',
        data 	    :  {id_web_event: id_web_event},
        success     : function(data){
            $('#FormDetailArtikel').html(data);
        }
    });
});
//Modal Tambah Galeri Event
$('#ModalTambahGaleri').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_event = $(e.relatedTarget).data('id');
    $('#FormTambahGaleri').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEvent/FormTambahGaleri.php',
        data 	    :  {id_web_event: id_web_event},
        success     : function(data){
            $('#FormTambahGaleri').html(data);
            //Proses Tambah Galeri
            $('#ProsesTambahGaleri').submit(function(){
                $('#NotifikasiTambahGaleri').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesTambahGaleri')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebEvent/ProsesTambahGaleri.php',
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
        url 	    : '_Page/WebEvent/FormDetailGaleri.php',
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