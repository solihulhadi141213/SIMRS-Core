//Modal Poliklinik Hfis
$('#ModalPoliklinikHfis').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TampilkanDataPoliklinikHfis').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Poliklinik/TabelPoliklinikHfis.php',
        success     : function(data){
            $('#TampilkanDataPoliklinikHfis').html(data);
        }
    });
});
//Modal Hapus Poliklinik
$('#ModalDeletePoliklinik').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_poliklinik = $(e.relatedTarget).data('id');
    $('#FormHapusPoliklinik').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Poliklinik/FormHapusPoliklinik.php',
        data        :  {id_poliklinik: id_poliklinik},
        success     : function(data){
            $('#FormHapusPoliklinik').html(data);
            //Konfirmasi Hapus Data Pasien
            $('#KonfirmasiHapusPoliklinik').click(function(){
                $('#NotifikasiHapusPoliklinik').html('Loading...');
                $.ajax({
                    url     : "_Page/Poliklinik/ProsesHapusPoliklinik.php",
                    method  : "POST",
                    data    :  {id_poliklinik: id_poliklinik},
                    success : function (data) {
                        $('#NotifikasiHapusPoliklinik').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiHapus=$('#NotifikasiHapus').html();
                        if(NotifikasiHapus=="Berhasil"){
                            window.location.replace("index.php?Page=Poliklinik");
                        }
                    }
                })
            });
        }
    });
});
//Ketika nama poli di ketik
$("#nama").keyup(function(){
    $('#ListNamaPoli').html('<option value="  ">');
    var nama=$('#nama').val();
    $.ajax({
        type    : 'POST',
        url     : "_Page/Poliklinik/CariReferensiNamaPoli.php",
        data    : {nama: nama },
        success: function(data) {
            $('#ListNamaPoli').html(data);
        }
    });
});
//Ketika kode poli di ketik
$("#kode").click(function(){
    $('#DataListKodePoli').html('<option value="  ">');
    var nama=$('#nama').val();
    $.ajax({
        type    : 'POST',
        url     : "_Page/Poliklinik/CariReferensiKodePoli.php",
        data    : {nama: nama },
        success: function(data) {
            $('#DataListKodePoli').html(data);
        }
    });
});
//Proses Tambah Poliklinik
$("#ClickSimpan").click(function(){
    $('#NotifikasiTambah').html('Loading..');
    var nama=$('#nama').val();
    var koordinator=$('#koordinator').val();
    var kode=$('#kode').val();
    var status=$('#status').val();
    var Deskripsi = tinymce.activeEditor.getContent();
    $.ajax({
        type    : 'POST',
        url     : "_Page/Poliklinik/ProsesTambahPoliklinik.php",
        data    : {nama: nama, koordinator: koordinator, kode: kode, status: status, Deskripsi: Deskripsi },
        success: function(data) {
            $('#NotifikasiTambah').html(data);
            var NotifikasiTambahBerhasil=$('#NotifikasiTambahBerhasil').html();
            if(NotifikasiTambahBerhasil=="Berhasil"){
                window.location.replace("index.php?Page=Poliklinik");
            }
        }
    });
});

$("#EditDeskripsi").click(function(){
    var IsiKonten=$('#IsiKonten').html();
    $('#IsiKonten').html('Loading..');
    $('#IsiKonten').html('<textarea name="deskripsi" id="deskripsi" cols="30" rows="10" required></textarea>');
    $('#EditDeskripsi').html('');
    $("#nama").attr("readonly", false);
    $("#koordinator").attr("readonly", false);
    $("#kode").attr("readonly", false);
    $("#status").attr("readonly", false);
    $("#ClickUpdate").attr("disabled", false);
    tinymce.init({
        selector: '#deskripsi',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(IsiKonten);
            });
        },
        selector: 'textarea',
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
        images_upload_url: '_Page/Poliklinik/PostAcceptor.php',
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
//Proses Edit Poliklinik
$("#ClickUpdate").click(function(){
    $('#NotifikasiEdit').html('Loading..');
    var id_poliklinik=$('#id_poliklinik').val();
    var nama=$('#nama').val();
    var koordinator=$('#koordinator').val();
    var kode=$('#kode').val();
    var status=$('#status').val();
    var deskripsi123 = tinymce.activeEditor.getContent('#deskripsi');
    $.ajax({
        type    : 'POST',
        url     : "_Page/Poliklinik/ProsesEditPoliklinik.php",
        data    : {id_poliklinik: id_poliklinik, nama: nama, koordinator: koordinator, kode: kode, status: status, deskripsi: deskripsi123 },
        success: function(data) {
            $('#NotifikasiEdit').html(data);
            var NotifikasiEditBerhasil=$('#NotifikasiEditBerhasil').html();
            if(NotifikasiEditBerhasil=="Berhasil"){
                window.location.replace("index.php?Page=Poliklinik");
            }
        }
    });
});
//Menampilkan text editor
