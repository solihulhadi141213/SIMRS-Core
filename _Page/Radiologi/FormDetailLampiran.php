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
            $Strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y H:i T',$Strtotime);
?>
    <div class="row">
        <div class="col-md-12 mb-4">
            <img src="<?php echo "$UrlGambar"; ?>" width="100%">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <dt>Tanggal :</dt>
            <?php echo "$TanggalFormat"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <dt>Title File :</dt>
            <?php echo "$title"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <dt>Deskripsi :</dt>
            <?php echo "$deskripsi"; ?>
        </div>
    </div>
<?php }} ?>