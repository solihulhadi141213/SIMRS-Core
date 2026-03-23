<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_radiologi_sig
    if(empty($_POST['id_radiologi_sig'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Varifikasi Radiologi Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_radiologi_sig=$_POST['id_radiologi_sig'];
        if(empty(getDataDetail($Conn,'radiologi_sig','id_radiologi_sig',$id_radiologi_sig,'id_radiologi_sig'))){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center mb-3">';
            echo '         ID Verifikasi Tidak Valid.';
            echo '      </div>';
            echo '  </div>';
        }else{
            $tanggal=getDataDetail($Conn,'radiologi_sig','id_radiologi_sig',$id_radiologi_sig,'tanggal');
            $nama=getDataDetail($Conn,'radiologi_sig','id_radiologi_sig',$id_radiologi_sig,'nama');
            $kategori=getDataDetail($Conn,'radiologi_sig','id_radiologi_sig',$id_radiologi_sig,'kategori');
            $signature=getDataDetail($Conn,'radiologi_sig','id_radiologi_sig',$id_radiologi_sig,'signature');
?>
    <div class="row">
        <div class="col-md-12">
            <img src="<?php echo 'data:image/png;base64,' . $signature . ''; ?>" width="100%">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td>TANGGAL</td>
                        <td>:</td>
                        <td><?php echo "$tanggal"; ?></td>
                    </tr>
                    <tr>
                        <td>NAMA</td>
                        <td>:</td>
                        <td><?php echo "$nama"; ?></td>
                    </tr>
                    <tr>
                        <td>KATEGORI</td>
                        <td>:</td>
                        <td><?php echo "$kategori"; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php }} ?>