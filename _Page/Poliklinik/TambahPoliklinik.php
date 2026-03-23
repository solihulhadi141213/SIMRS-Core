<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="index.php?Page=Poliklinik&Sub=TambahPoliklinik" class="h5"><i class="icofont-icu"></i> Tambah Poliklinik</a></h5>
                    <p class="m-b-0">Tambah Data Poliklinik, Kode Poliklinik dan Pernyataan Pelayanan</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="index.php?Page=Poliklinik" class="btn btn-md btn-inverse mr-2 mt-2">
                    <i class="ti-arrow-circle-left text-white"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesTambahPoliklinik" autocomplete="off">
                            <div class="card">
                                <div class="card-header">
                                    <h5><dt> Form Tambah Poliklinik</dt></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col col-md-4">
                                            <label for="nama"><dt>Kode-Nama Poliklinik</dt></label>
                                            <input type="text" name="nama" id="nama" list="ListNamaPoli" class="form-control">
                                            <datalist id="ListNamaPoli"></datalist>
                                            <small>Contoh Format: OBG-OBGYN</small>
                                        </div>
                                        <div class="col col-md-4">
                                            <label for="koordinator"><dt>Koordinator</dt></label>
                                            <input type="text" name="koordinator" id="koordinator" class="form-control">
                                        </div>
                                        <div class="col col-md-4">
                                            <label for="status"><dt>Status</dt></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="Aktif">Aktif</option>
                                                <option value="Non-Aktif">Non-Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col col-md-12">
                                            <label for="Deskripsi"><dt>Deskripsi</dt></label>
                                            <textarea name="Deskripsi" id="Deskripsi" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col col-md-12" id="NotifikasiTambah">
                                            <span class="text-primary">
                                                <dt>Keterangan : </dt> Pastikan Data Poliklinik Yang Anda Input Sudah Benar!
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-md btn-primary" id="ClickSimpan">
                                        <i class="ti-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>
<script>
    tinymce.init({
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
</script>