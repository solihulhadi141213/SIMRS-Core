<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_radiologi_file
    if(empty($_POST['id_radiologi_file'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Lampiran Radiologi Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_radiologi_file=$_POST['id_radiologi_file'];
        if(empty(getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'id_radiologi_file'))){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center mb-3">';
            echo '         ID Lampiran Tidak Valid.';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_akses=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'id_akses');
            $tanggal=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'tanggal');
            $internal_eksternal=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'internal_eksternal');
            $title=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'title');
            $deskripsi=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'deskripsi');
            $url_file=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'url_file');
            $filename=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'filename');
            if($internal_eksternal=="Internal"){
                $UrlGambar="assets/images/Radiologi/$filename";
            }else{
                $UrlGambar="$url_file";
            }
?>
    <input type="hidden" id="id_radiologi_file" name="id_radiologi_file" value="<?php echo "$id_radiologi_file";?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="title"><dt>Judul File</dt></label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo "$title"; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="deskripsi"><dt>Deskripsi</dt></label>
                <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control"><?php echo "$deskripsi"; ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <dt class="mb-3">Internal/Eksternal</dt>
                <div class="form-check ml-4">
                    <input class="form-check-input" <?php if($internal_eksternal=="Internal"){echo "checked";} ?> type="radio" name="internal_eksternal" id="GetInternal2" value="Internal">
                    <label class="form-check-label" for="GetInternal2">
                        Internal (Upload File)
                    </label>
                </div>
                <div class="form-check ml-4">
                    <input class="form-check-input" <?php if($internal_eksternal=="Eksternal"){echo "checked";} ?> type="radio" name="internal_eksternal" id="GetEksternal2" value="Eksternal">
                    <label class="form-check-label" for="GetEksternal2">
                        Eksternal (Dari URL/Link)
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="SwitchUrlAndFile2">
                <?php
                    if($internal_eksternal=="Internal"){
                        echo '<label for="filename"><dt>Upload File</dt></label>';
                        echo '<input type="file" id="filename" name="filename" class="form-control">';
                        echo '<small>Maskimal file 2 mb (JPG, JPEG, GIF & PNG)</small>';
                    }else{
                        echo '<label for="url_file"><dt>URL/Link File</dt></label>';
                        echo '<input type="url" id="url_file" name="url_file" class="form-control" placeholder="https://" value="'.$UrlGambar.'">';
                    }
                ?>
            </div>
        </div>
        <div class="row mb-4 mt-4">
            <div class="col-md-12" id="NotifikasiEditLampiran">
                <span class="text-primary">Pastikan Data Dan Informasi Pendaftaran Sudah Sesuai</span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <button type="submit" class="btn btn-md btn-success">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }} ?>