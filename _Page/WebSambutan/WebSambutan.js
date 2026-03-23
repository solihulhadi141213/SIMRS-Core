tinymce.init({
    selector: '#isi_sambutan',
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
$("#SimpanSambutan").click(function(){
    $('#NotifikasiSimpanSambutan').html('Loading..');
    var nama=$('#nama').val();
    var jabatan=$('#jabatan').val();
    var judul_sambutan=$('#judul_sambutan').val();
    var isi_sambutan = tinymce.activeEditor.getContent('#isi_sambutan');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebSambutan/ProsesSimpanSambutan.php",
        data    : 
            { 
                nama: nama, 
                jabatan: jabatan, 
                judul_sambutan: judul_sambutan, 
                isi_sambutan: isi_sambutan 
            },
        success: function(data) {
            $('#NotifikasiSimpanSambutan').html(data);
            var NotifikasiSimpanSambutanBerhasil=$('#NotifikasiSimpanSambutanBerhasil').html();
            if(NotifikasiSimpanSambutanBerhasil=="Success"){
                Swal.fire({
                    title: 'Mantap!',
                    text: 'Simpan Sambutan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
                $('#NotifikasiSimpanSambutan').html('<span class="test-primary">Pastikan data sambutan yang anda input sudah sesuai</span>');
            }
        }
    });
});
//Simpan Foto
$('#ProsesSimpanFoto').submit(function(){
    $('#NotifikasiSimpanFoto').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSimpanFoto')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSambutan/ProsesSimpanFoto.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanFoto').html(data);
            var NotifikasiSimpanFotoBerhasil=$('#NotifikasiSimpanFotoBerhasil').html();
            if(NotifikasiSimpanFotoBerhasil=="Success"){
                window.location.replace("index.php?Page=WebSambutan");
            }
        }
    });
});