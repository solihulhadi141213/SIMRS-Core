$('#MenampilkanTabelBantuan').load("_Page/WebBantuan/TabelBantuan.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelBantuan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebBantuan/TabelBantuan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelBantuan').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelBantuan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebBantuan/TabelBantuan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelBantuan').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebBantuan/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Modal Detail Bantuan
$('#ModalDetailBantuan').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_bantuan = $(e.relatedTarget).data('id');
    $('#DetailBantuan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebBantuan/DetailBantuan.php',
        data 	    :  {id_bantuan: id_bantuan},
        success     : function(data){
            $('#DetailBantuan').html(data);
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
$("#KlikProsesTambahBantuan").click(function(){
    $('#NotifikasiTambahBantuan').html('Loading..');
    var tanggal=$('#tanggal').val();
    var jam=$('#jam').val();
    var kategori=$('#kategori').val();
    var judul=$('#judul').val();
    var deskripsi = tinymce.activeEditor.getContent('#deskripsi');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebBantuan/ProsesBantuan.php",
        data    : 
            { 
                tanggal: tanggal, 
                jam: jam, 
                kategori: kategori, 
                judul: judul, 
                deskripsi: deskripsi
            },
        success: function(data) {
            $('#NotifikasiTambahBantuan').html(data);
            var NotifikasiTambahBantuanBerhasil=$('#NotifikasiTambahBantuanBerhasil').html();
            if(NotifikasiTambahBantuanBerhasil=="Success"){
                window.location.replace("index.php?Page=WebBantuan");
            }
        }
    });
});
$("#KlikProsesEditBantuan").click(function(){
    $('#NotifikasiEditBantuan').html('Loading..');
    var id_bantuan=$('#id_bantuan').val();
    var tanggal=$('#tanggal').val();
    var jam=$('#jam').val();
    var kategori=$('#kategori').val();
    var judul=$('#judul').val();
    var deskripsi = tinymce.activeEditor.getContent('#deskripsi');
    $.ajax({
        type    : 'POST',
        url     : "_Page/WebBantuan/ProsesEditBantuan.php",
        data    : 
            { 
                id_bantuan: id_bantuan, 
                tanggal: tanggal, 
                jam: jam, 
                kategori: kategori, 
                judul: judul, 
                deskripsi: deskripsi
            },
        success: function(data) {
            $('#NotifikasiEditBantuan').html(data);
            var NotifikasiEditBantuanBerhasil=$('#NotifikasiEditBantuanBerhasil').html();
            if(NotifikasiEditBantuanBerhasil=="Success"){
                window.location.replace("index.php?Page=WebBantuan");
            }
        }
    });
});
//Modal Hapus Bantuan
$('#ModalHapusBantuan').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_bantuan = $(e.relatedTarget).data('id');
    $('#FormHapusBantuan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebBantuan/FormHapusBantuan.php',
        data 	    :  {id_bantuan: id_bantuan},
        success     : function(data){
            $('#FormHapusBantuan').html(data);
            $('#KonfirmasiHapusBantuan').click(function(){
                $('#NotifikasiHapusBantuan').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebBantuan/ProsesHapusBantuan.php',
                    data 	    :  { id_bantuan: id_bantuan },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusBantuan').html(data);
                        var NotifikasiHapusBantuanBerhasil=$('#NotifikasiHapusBantuanBerhasil').html();
                        if(NotifikasiHapusBantuanBerhasil=="Success"){
                            window.location.replace("index.php?Page=WebBantuan");
                        }
                    }
                });
            });
        }
    });
});