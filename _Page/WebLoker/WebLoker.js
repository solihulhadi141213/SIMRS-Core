$('#TabelLoker').load("_Page/WebLoker/TabelLoker.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelLoker').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLoker/TabelLoker.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelLoker').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLoker/FormKeyword.php',
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
    $('#TabelLoker').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLoker/TabelLoker.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelLoker').html(data);
        }
    });
});

tinymce.init({
    selector: '#deskripsi_loker',
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
$("#KlikProsesTambahLoker").click(function(){
    $('#NotifikasiTambahLoker').html('Loading..');
    var tanggal_expired=$('#tanggal_expired').val();
    var jam_expired=$('#jam_expired').val();
    var jumlah_loker=$('#jumlah_loker').val();
    var status_loker=$('#status_loker').val();
    var posisi_jabatan=$('#posisi_jabatan').val();
    var deskripsi_loker = tinymce.activeEditor.getContent('#deskripsi_loker');
    var pengumuman ="";
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebLoker/ProsesTambahLoker.php",
        data    : 
            { 
                tanggal_expired: tanggal_expired, 
                jam_expired: jam_expired, 
                jumlah_loker: jumlah_loker, 
                status_loker: status_loker, 
                posisi_jabatan: posisi_jabatan, 
                deskripsi_loker: deskripsi_loker, 
                pengumuman: pengumuman
            },
        success: function(data) {
            $('#NotifikasiTambahLoker').html(data);
            var NotifikasiTambahLokerBerhasil=$('#NotifikasiTambahLokerBerhasil').html();
            if(NotifikasiTambahLokerBerhasil=="Success"){
                window.location.replace("index.php?Page=WebLoker");
            }
        }
    });
});
$("#KlikProsesEditLoker").click(function(){
    $('#NotifikasiEditLoker').html('Loading..');
    var id_loker=$('#id_loker').val();
    var tanggal_expired=$('#tanggal_expired').val();
    var jam_expired=$('#jam_expired').val();
    var jumlah_loker=$('#jumlah_loker').val();
    var status_loker=$('#status_loker').val();
    var posisi_jabatan=$('#posisi_jabatan').val();
    var deskripsi_loker = tinymce.activeEditor.getContent('#deskripsi_loker');
    var pengumuman ="";
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebLoker/ProsesEditLoker.php",
        data    : 
            { 
                id_loker: id_loker, 
                tanggal_expired: tanggal_expired, 
                jam_expired: jam_expired, 
                jumlah_loker: jumlah_loker, 
                status_loker: status_loker, 
                posisi_jabatan: posisi_jabatan, 
                deskripsi_loker: deskripsi_loker, 
                pengumuman: pengumuman
            },
        success: function(data) {
            $('#NotifikasiEditLoker').html(data);
            var NotifikasiEditLokerBerhasil=$('#NotifikasiEditLokerBerhasil').html();
            if(NotifikasiEditLokerBerhasil=="Success"){
                window.location.replace("index.php?Page=WebLoker");
            }
        }
    });
});
//Modal Hapus Loker
$('#ModalHapusLoker').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_loker = $(e.relatedTarget).data('id');
    $('#FormHapusLoker').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebLoker/FormHapusLoker.php',
        data 	    :  {id_loker: id_loker},
        success     : function(data){
            $('#FormHapusLoker').html(data);
            $('#KonfirmasiHapusLoker').click(function(){
                $('#NotifikasiHapusLoker').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebLoker/ProsesHapusLoker.php',
                    data 	    :  { id_loker: id_loker },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusLoker').html(data);
                        var NotifikasiHapusLokerBerhasil=$('#NotifikasiHapusLokerBerhasil').html();
                        if(NotifikasiHapusLokerBerhasil=="Success"){
                            window.location.replace("index.php?Page=WebLoker");
                        }
                    }
                });
            });
        }
    });
});