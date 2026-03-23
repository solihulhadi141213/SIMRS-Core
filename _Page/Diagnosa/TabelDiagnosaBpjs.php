<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../vendor/autoload.php";
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //keyword
    if(empty($_POST['keyword'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Silahkan Masukan Kata Kunci Pencarian Terlebih Dulu';
        echo '  </div>';
        echo '</div>';
    }else{
        //kategori
        if(empty($_POST['kategori'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Silahkan Pilih Kategori Pencarian Terlebih Dulu';
            echo '  </div>';
            echo '</div>';
        }else{
            $kategori=$_POST['kategori'];
            $keyword=$_POST['keyword'];
            //Cek Pengaturan BPJS
            $IdSettingBridging=getDataDetail($Conn,'bridging','status','Aktiv','id_bridging');
            if(empty($IdSettingBridging)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Tidak Ada Pengaturan Koneksi Bridging';
                echo '  </div>';
                echo '</div>';
            }else{
                $consid=getDataDetail($Conn,'bridging','status','Aktiv','consid');
                $user_key=getDataDetail($Conn,'bridging','status','Aktiv','user_key');
                $secret_key=getDataDetail($Conn,'bridging','status','Aktiv','secret_key');
                $kode_ppk=getDataDetail($Conn,'bridging','status','Aktiv','kode_ppk');
                $url_vclaim=getDataDetail($Conn,'bridging','status','Aktiv','url_vclaim');
                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                $key="$consid$secret_key$timestamp";
                if($kategori=="Diagnosa"){
                    $ResponseData=referensiDiagnosaVclaim($url_vclaim,$consid,$secret_key,$user_key,$keyword);
                }else{
                    $ResponseData=referensiProcedurVclaim($url_vclaim,$consid,$secret_key,$user_key,$keyword);
                }
                if(empty($ResponseData)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      Terjadi Kesalahan Pada Saat Koneksi Bridging (Response Tidak Ada)';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $ambil_json =json_decode($ResponseData, true);
                    if(empty($ambil_json["metaData"]["code"])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger">';
                        echo '      Terjadi Kesalahan Pada Saat Koneksi Bridging (Response Code Tidak Ada)';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if($ambil_json["metaData"]["code"]!=="200"){
                            $message=$ambil_json["metaData"]["message"];
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center text-danger">';
                            echo '      message: '.$message.'';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            if(empty($ambil_json["response"])){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center text-danger">';
                                echo '      message: '.$message.'';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $string=$ambil_json["response"];
                                if($kategori=="Diagnosa"){
                                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                    $key="$consid$secret_key$timestamp";
                                    $FileDeskripsi=stringDecrypt("$key", "$string");
                                    $FileDekompresi=decompress("$FileDeskripsi");
                                    $FileDekompresiJson =json_decode($FileDekompresi, true);
                                    if(empty($FileDekompresiJson['diagnosa'])){
                                        $diagnosa="";
                                    }else{
                                        $diagnosa=$FileDekompresiJson['diagnosa'];
                                    }
                                    
                                }else{
                                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                    $key="$consid$secret_key$timestamp";
                                    $FileDeskripsi=stringDecrypt("$key", "$string");
                                    $FileDekompresi=decompress("$FileDeskripsi");
                                    $FileDekompresiJson =json_decode($FileDekompresi, true);
                                    if(empty($FileDekompresiJson['procedure'])){
                                        $diagnosa="";
                                    }else{
                                        $diagnosa=$FileDekompresiJson['procedure'];
                                    }
                                }
                                if(empty($diagnosa)){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      Data Tidak Ditemukan!';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    $JumlahDiagnosa=count($diagnosa);
?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>NO</dt></th>
                            <th class="text-center"><dt>Kode</dt></th>
                            <th class="text-center"><dt>Deskripsi</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(empty($JumlahDiagnosa)){
                                echo '<tr>';
                                echo '  <td colspan="3" class="text-center">';
                                echo '      Data Tidak Ditemukan';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $no = 1;
                                //KONDISI PENGATURAN MASING FILTER
                                foreach($diagnosa as $data_list){
                                    if($kategori=="Diagnosa"){
                                        $kode= $data_list['kode'];
                                        $name= $data_list['nama'];
                                    }else{
                                        $kode= $data_list['kode'];
                                        $name= $data_list['nama'];
                                    }
                        ?>
                            <tr>
                                <td class="" align="center"><?php echo "$no";?></td>
                                <td class="" align="left"><?php echo $kode;?></td>
                                <td class="" align="left"><?php echo $name;?></td>
                            </tr>
                        <?php
                            $no++; }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php }}}}}}}}} ?>