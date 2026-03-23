<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap kode_sarana
    if(empty($_POST['kode_sarana'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Kode Sarana Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $kode_sarana=$_POST['kode_sarana'];
        //Setting
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $masterdata_url=getDataDetail($Conn,'setting_satusehat','status','Active','masterdata_url');
        $Token=GenerateTokenSatuSehat($Conn);
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak ada setting satu sehat yang aktiv';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Generate Token Gagal!';
                echo '  </div>';
                echo '</div>';
            }else{
                $GetDetailMsi=GetDetailMsi($masterdata_url,$Token,$kode_sarana);
                if(empty($GetDetailMsi)){
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          Tidak ada response dari satu sehat';
                    echo '      </div>';
                    echo '  </div>';
                }else{
                    $data = json_decode($GetDetailMsi, true);
                    $list=$data['data'];
                    if(empty(count($list))){
                        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center text-danger">';
                        echo '          Tidak ada data yang ditemukan';
                        echo '      </div>';
                        echo '  </div>';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center text-danger">';
                        echo '          <textarea class="form-control">'.$newJsonString .'</textarea>';
                        echo '      </div>';
                        echo '  </div>';
                    }else{
                        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
                        foreach($list as $list_msi){
                            $kode_satusehat=$list_msi['kode_satusehat'];
                            $kode_sarana=$list_msi['kode_sarana'];
                            $nama=$list_msi['nama'];
                            $telp=$list_msi['telp'];
                            $email=$list_msi['email'];
                            $website=$list_msi['website'];
                            //Alamat
                            $alamat=$list_msi['alamat'];
                            $provinsi=$list_msi['provinsi']['nama'];
                            $kabkota=$list_msi['kabkota']['nama'];
                            $kecamatan=$list_msi['kecamatan']['nama'];
                            $kelurahan=$list_msi['kelurahan']['nama'];
                            //Jenis Sarana
                            $jenis_sarana_kode=$list_msi['jenis_sarana']['kode'];
                            $jenis_sarana_nama=$list_msi['jenis_sarana']['nama'];
                            $jenis_sarana_nama_alt=$list_msi['jenis_sarana']['nama_alt'];
                            //Sub Jenis
                            $subjenis_kode=$list_msi['subjenis']['kode'];
                            $subjenis_nama=$list_msi['subjenis']['Nama'];
                            $subjenis_nama_alt=$list_msi['subjenis']['nama_alt'];
                            //Status
                            $status_sarana=$list_msi['status_sarana'];
                            $status_aktif=$list_msi['status_aktif'];
                            $code_without_checksum=$list_msi['code_without_checksum'];
                            $organization_id=$list_msi['organization_id'];
?>
    <div class="row mb-3">
        <div class="col-md-12">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="accordion-panel">
                    <div class="accordion-heading" role="tab" id="headingOne">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <dt>A. Informasi Umum</dt>
                            </a>
                        </h3>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
                        <div class="accordion-content accordion-desc">
                            <ol>
                                <li class="mb-2">
                                    Kode Satu Sehat : <code class="text-secondary"><?php echo $kode_satusehat; ?></code>
                                </li>
                                <li class="mb-2">
                                    Kode Sarana : <code class="text-secondary"><?php echo $kode_sarana; ?></code>
                                </li>
                                <li class="mb-2">
                                    Nama : <code class="text-secondary"><?php echo $nama; ?></code>
                                </li>
                                <li class="mb-2">
                                    Telp : <code class="text-secondary"><?php echo $telp; ?></code>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class="accordion-heading" role="tab" id="headingTwo">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <dt>B. Alamat</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Alamat : <code class="text-secondary"><?php echo $alamat; ?></code>
                            </li>
                            <li class="mb-2">
                                Provinsi : <code class="text-secondary"><?php echo $provinsi; ?></code>
                            </li>
                            <li class="mb-2">
                                Kabupaten : <code class="text-secondary"><?php echo $kabkota; ?></code>
                            </li>
                            <li class="mb-2">
                                Kecamatan : <code class="text-secondary"><?php echo $kecamatan; ?></code>
                            </li>
                            <li class="mb-2">
                                Ds/Kel : <code class="text-secondary"><?php echo $kelurahan; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingThree">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <dt>C. Jenis Sarana</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Kode : <code class="text-secondary"><?php echo $jenis_sarana_kode; ?></code>
                            </li>
                            <li class="mb-2">
                                Nama : <code class="text-secondary"><?php echo $jenis_sarana_nama; ?></code>
                            </li>
                            <li class="mb-2">
                                Alternatif : <code class="text-secondary"><?php echo $jenis_sarana_nama_alt; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingFour">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <dt>D.Sub Jenis</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Kode : <code class="text-secondary"><?php echo $subjenis_kode; ?></code>
                            </li>
                            <li class="mb-2">
                                Nama : <code class="text-secondary"><?php echo $subjenis_nama; ?></code>
                            </li>
                            <li class="mb-2">
                                Alternatif : <code class="text-secondary"><?php echo $subjenis_nama_alt; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-panel">
                <div class=" accordion-heading" role="tab" id="headingFive">
                    <h3 class="card-title accordion-title">
                        <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <dt>E. Rute Pemberian</dt>
                        </a>
                    </h3>
                </div>
                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                    <div class="accordion-content accordion-desc">
                        <ol>
                            <li class="mb-2">
                                Status : <code class="text-secondary"><?php echo $status_sarana; ?></code>
                            </li>
                            <li class="mb-2">
                                Aktif : <code class="text-secondary"><?php echo $status_aktif; ?></code>
                            </li>
                            <li class="mb-2">
                                ID Org : <code class="text-secondary"><?php echo $organization_id; ?></code>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }}}}}} ?>