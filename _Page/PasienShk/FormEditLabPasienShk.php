<?php
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Tangkap id_antrian
    //Tangkap GetContent
    if(empty($_POST['GetContent'])){
        echo '  <div class="text-danger">';
        echo '      ID SHK dan ID Hasil Tidak Boleh Kosong';
        echo '  </div>';
    }else{
        $GetContent=$_POST['GetContent'];
        //Pecah Kontnetn
        $Explode=explode(",", $GetContent);
        $id_shk=$Explode[0];
        $GetIdHasil=$Explode[1];
        //Validasi Data
        if(ctype_digit($id_shk)){
            echo '  <div class="text-danger">';
            echo '      ID SHK '.$id_shk.' Tidak Valid';
            echo '  </div>';
        }else{
            if(!preg_match("/^[0-9]*$/",$GetIdHasil)){
                echo '  <div class="text-danger">';
                echo '      ID Hasil Tidak Valid';
                echo '  </div>';
            }else{
                //Buka Data Pasien SHK
                $response=DetailLabPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$id_shk);
                if(empty($response)){
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 mb-3 text-center text-danger">';
                    echo '          Tidak ada Response Dari SIRS Online';
                    echo '      </div>';
                    echo '  </div>';
                }else{
                    $data = json_decode($response, true);
                    if(empty($data['shk'])){
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
                        echo '          Tidak ada Response Dari SIRS Online <br> Response: <textarea class="form-control">'.$response.'</textarea>';
                        echo '      </div>';
                        echo '  </div>';
                    }else{
                        if(empty($data['shk'])){
                            echo '  <div class="row">';
                            echo '      <div class="col-md-12 mb-3 text-center text-danger">';
                            echo '          Tidak ada hasil lab untuk pasien SHK tersebut';
                            echo '      </div>';
                            echo '  </div>';
                        }else{
                            if(!is_array($data['shk'])){
                                echo '  <div class="row">';
                                echo '      <div class="col-md-12 mb-3 text-center text-danger">';
                                echo '          '.$data['shk'].'';
                                echo '      </div>';
                                echo '  </div>';
                            }else{
                                $DataShk=count($data['shk']);
                                for($a=0; $a<$DataShk; $a++){
                                    $id_hasil = $data['shk'][$a]['id_hasil'];
                                    if($GetIdHasil==$id_hasil){
                                        $jenis_pemeriksaan = $data['shk'][$a]['jenis_pemeriksaan'];
                                        $nama_pemeriksaan = $data['shk'][$a]['nama_pemeriksaan'];
                                        $hasil_pemeriksaan = $data['shk'][$a]['hasil_pemeriksaan'];
                                        $nama_hasil = $data['shk'][$a]['nama_hasil'];
                                        $tgl_periksa = $data['shk'][$a]['tgl_periksa'];
                                        $tgl_hasil = $data['shk'][$a]['tgl_hasil'];
                                        $layak_sampel = $data['shk'][$a]['layak_sampel'];
                                        $id_layak = $data['shk'][$a]['id_layak'];
                                        $tgl_terima = $data['shk'][$a]['tgl_terima'];
                                        $tgllapor = $data['shk'][$a]['tgllapor'];
                                        if($hasil_pemeriksaan=="1"){
                                            $nama_hasil="TSH Normal (< 20 μU/mL)";
                                        }else{
                                            if($hasil_pemeriksaan=="2"){
                                                $nama_hasil="TSH Tinggi (? 20 μU/mL)";
                                            }else{
                                                if($hasil_pemeriksaan=="3"){
                                                    $nama_hasil="Positif (Serum FT4 di bawah normal, FT4 normal ATAU TSH >= 20µU/ml (2 kali pemeriksaan))";
                                                }else{
                                                    $nama_hasil="Negatif";
                                                }
                                            }
                                        }
                                        if($layak_sampel=="1"){
                                            $nama_layak="Sample Reject";
                                        }else{
                                            $nama_layak="Sample Layak Diperiksa";
                                        }
                                        //Explode tanggal
                                        $Explode2=explode(" ", $tgllapor);
                                        $tgllapor=$Explode2[0];
                                        $jamlapor=$Explode2[1];
                                        //String Tanpa spasi
                                        $id_shk = str_replace(' ', '', $id_shk);
?>
                            <input type="hidden" name="id_shk" value="<?php echo $id_shk; ?>">
                            <input type="hidden" name="id_hasil" value="<?php echo $id_hasil; ?>">
                            <div class="row mb-3"> 
                                <div class="col col-md-4">
                                    <label for="jenis_pemeriksaan">Jenis Pmeriksaan</label>
                                </div>
                                <div class="col col-md-8">
                                    <select name="jenis_pemeriksaan" id="jenis_pemeriksaan" class="form-control">
                                        <option <?php if($jenis_pemeriksaan==""){echo "selected";} ?> value="">Pilih</option>
                                        <option <?php if($jenis_pemeriksaan=="1"){echo "selected";} ?> value="1">Pemeriksaan TSH</option>
                                        <option <?php if($jenis_pemeriksaan=="2"){echo "selected";} ?> value="2">Pemeriksaan Tes Konfirmasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col col-md-4">
                                    <label for="hasil_pemeriksaan">Hasil Pmeriksaan</label>
                                </div>
                                <div class="col col-md-8" id="FormHasilPemeriksaan">
                                    <select name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control">
                                        <?php
                                            if($jenis_pemeriksaan=="1"){
                                        ?>
                                            <option <?php if($hasil_pemeriksaan==""){echo "selected";} ?> value="">Pilih</option>
                                            <option <?php if($hasil_pemeriksaan=="1"){echo "selected";} ?> value="1">TSH Normal (< 20 μU/mL)</option>
                                            <option <?php if($hasil_pemeriksaan=="2"){echo "selected";} ?> value="2">TSH Tinggi (? 20 μU/mL)</option>
                                        <?php }else{ ?>
                                            <option <?php if($hasil_pemeriksaan==""){echo "selected";} ?> value="">Pilih</option>
                                            <option <?php if($hasil_pemeriksaan=="3"){echo "selected";} ?> value="3">Positif (Serum FT4 di bawah normal, FT4 normal ATAU TSH >= 20µU/ml (2 kali pemeriksaan))</option>
                                            <option <?php if($hasil_pemeriksaan=="4"){echo "selected";} ?> value="4">Negatif</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col col-md-4">
                                    <label for="layak_sampel">Layak Sample</label>
                                </div>
                                <div class="col col-md-8">
                                    <select name="layak_sampel" id="layak_sampel" class="form-control">
                                        <option <?php if($layak_sampel==""){echo "selected";} ?> value="">Pilih</option>
                                        <option <?php if($layak_sampel=="1"){echo "selected";} ?> value="1">Sample Riject</option>
                                        <option <?php if($layak_sampel=="2"){echo "selected";} ?> value="2">Sample Layak Diperiksa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col col-md-4">
                                    <label for="tgl_periksa">Tgl. Periksa</label>
                                </div>
                                <div class="col col-md-8">
                                    <input type="date" class="form-control" name="tgl_periksa" id="tgl_periksa" value="<?php echo "$tgl_periksa"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col col-md-4">
                                    <label for="tgl_hasil">Tgl. Hasil</label>
                                </div>
                                <div class="col col-md-8">
                                    <input type="date" class="form-control" name="tgl_hasil" id="tgl_hasil" value="<?php echo "$tgl_hasil"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col col-md-4">
                                    <label for="tgl_terima">Tgl. Terima</label>
                                </div>
                                <div class="col col-md-8">
                                    <input type="date" class="form-control" name="tgl_terima" id="tgl_terima" value="<?php echo "$tgl_terima"; ?>">
                                </div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col col-md-4">
                                    <label for="tgllapor">Tgl. Lapor</label>
                                </div>
                                <div class="col col-md-4">
                                    <input type="date" class="form-control" name="tgllapor" id="tgllapor" value="<?php echo "$tgllapor"; ?>">
                                </div>
                                <div class="col col-md-4">
                                    <input type="time" class="form-control" name="jamlapor" id="jamlapor" value="<?php echo "$jamlapor"; ?>">
                                </div>
                            </div>
<?php }}}}}}}}} ?>