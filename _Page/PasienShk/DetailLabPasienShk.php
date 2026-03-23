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
    if(empty($_POST['id_shk'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          ID SHK Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_shk=$_POST['id_shk'];
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center">';
        echo '          <button type="button" class="btn btn-sm btn-block btn-outline-primary" data-toggle="modal" data-target="#ModalTambahLabShk" data-id="'.$id_shk.'">';
        echo '              Tambah Lab Pasien SHK';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
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
?>

        <div class="row mb-3"> 
            <div class="col col-md-12">
                <div class="card">
                    <div class="card-header">
                        <dt><?php echo "ID.$id_hasil"; ?></dt>
                    </div>
                    <div class="card-body sub-title">
                        <div class="row mb-3">
                            <div class="col-md-6"><dt>ID Hasil</dt></div>
                            <div class="col-md-6"><?php echo "$id_hasil"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><dt>Jenis Pemeriksaan</dt></div>
                            <div class="col-md-6"><?php echo "$jenis_pemeriksaan. $nama_pemeriksaan"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><dt>Hasil Pemeriksaan</dt></div>
                            <div class="col-md-6"><?php echo "$hasil_pemeriksaan. $nama_hasil"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><dt>Layak Sample</dt></div>
                            <div class="col-md-6"><?php echo "$layak_sampel. $nama_layak"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><dt>Tgl Pemeriksaan</dt></div>
                            <div class="col-md-6"><?php echo "$tgl_periksa"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><dt>Tgl Hasil</dt></div>
                            <div class="col-md-6"><?php echo "$tgl_hasil"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><dt>Tgl Terima</dt></div>
                            <div class="col-md-6"><?php echo "$tgl_terima"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><dt>Tgl Lapor</dt></div>
                            <div class="col-md-6"><?php echo "$tgllapor"; ?></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="icon icon-btn">
                            <button type="button" class="btn btn-sm btn-icon btn-info" title="Edit Hasil Lab Pasien SHK" data-toggle="modal" data-target="#ModalEditLabPasienShk" data-id="<?php echo "$id_shk,$id_hasil"; ?>">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-danger" title="Hapus Hasil Lab Pasien SHK" data-toggle="modal" data-target="#ModalHapusLabPasienShk" data-id="<?php echo "$id_shk,$id_hasil"; ?>">
                                <i class="ti ti-close"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php }}}}}} ?>