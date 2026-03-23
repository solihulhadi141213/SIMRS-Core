<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_laboratorium_sample'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Spesimen Tidak Boleh Kosonng!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_laboratorium_parameter'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      ID Paramter Tidak Boleh Kosonng!';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_laboratorium_sample=$_POST['id_laboratorium_sample'];
            $id_laboratorium_parameter=$_POST['id_laboratorium_parameter'];
            //Buka data id_lab
            $id_lab=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'id_lab');
            //Buka id_permintaan
            $id_permintaan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_lab',$id_lab,'id_permintaan');
            //Buka data pasien dan kunjungan
            $id_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_pasien');
            $id_kunjungan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_kunjungan');
            //Buka data parameter
            $parameter=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'parameter');
            $kategori_parameter=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'kategori_parameter');
            $tipe_data=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'tipe_data');
            $alternatif=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'alternatif');
            $nilai_rujukan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'nilai_rujukan');
            $nilai_kritis=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'nilai_kritis');
            $satuan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'satuan');
            $keterangan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'keterangan');
            //Format Data
            if($tipe_data=="Text"){
                $Format="text";
            }else{
                if($tipe_data=="Number"){
                    $Format="number";
                }else{
                    $Format="text";
                }
            }
            //Hasil Pemeriksaan
            $QryHasilPemeriksaan = mysqli_query($Conn,"SELECT * FROM laboratorium_rincian WHERE id_lab='$id_lab' AND id_permintaan='$id_permintaan' AND id_laboratorium_sample='$id_laboratorium_sample' AND parameter='$parameter' AND kategori_parameter='$kategori_parameter'")or die(mysqli_error($Conn));
            $DataHasilPemeriksaan = mysqli_fetch_array($QryHasilPemeriksaan);
            if(!empty($DataHasilPemeriksaan['id_rincian_lab'])){
                $id_rincian_lab= $DataHasilPemeriksaan['id_rincian_lab'];
                $hasil= $DataHasilPemeriksaan['hasil'];
                $interpertasi= $DataHasilPemeriksaan['interpertasi'];
                $keterangan= $DataHasilPemeriksaan['keterangan'];
            }else{
                $id_rincian_lab="";
                $hasil="";
                $interpertasi="";
                $keterangan="";
            }
            
?>
    <input type="hidden" id="id_laboratorium_sample" name="id_laboratorium_sample" value="<?php echo "$id_laboratorium_sample"; ?>">
    <input type="hidden" id="id_laboratorium_parameter" name="id_laboratorium_parameter" value="<?php echo "$id_laboratorium_parameter"; ?>">
    <input type="hidden" id="id_lab" name="id_lab" value="<?php echo "$id_lab"; ?>">
    <input type="hidden" id="id_permintaan" name="id_permintaan" value="<?php echo "$id_permintaan"; ?>">
    <input type="hidden" id="id_pasien" name="id_pasien" value="<?php echo "$id_pasien"; ?>">
    <input type="hidden" id="id_kunjungan" name="id_kunjungan" value="<?php echo "$id_kunjungan"; ?>">
    <input type="hidden" id="id_rincian_lab" name="id_rincian_lab" value="<?php echo "$id_rincian_lab"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="parameter"><dt>Parameter</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly id="parameter" name="parameter" class="form-control" value="<?php echo "$parameter"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kategori_parameter"><dt>Kategori</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly id="kategori_parameter" name="kategori_parameter" class="form-control" value="<?php echo "$kategori_parameter"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nilai_kritis"><dt>Nilai Kritis</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly id="nilai_kritis" name="nilai_kritis" class="form-control" value="<?php echo "$nilai_kritis"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nilai_rujukan"><dt>Nilai Rujukan</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly id="nilai_rujukan" name="nilai_rujukan" class="form-control" value="<?php echo "$nilai_rujukan"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil"><dt>Hasil</dt></label>
        </div>
        <div class="col-md-8">
            <?php
                if(empty($alternatif)){
                    echo '<input type="'.$Format.'" id="hasil" name="hasil" class="form-control" value="'.$hasil.'">';
                }else{
                    $JsonData =json_decode($alternatif, true);
                    $JumlahBaris=count($JsonData);
                    echo '<select id="hasil" name="hasil" class="form-control">';
                    if(!empty($JumlahBaris)){
                        foreach($JsonData as $Value){
                            $ListAlternatif=$Value['alternatif'];
                            if($ListAlternatif==$hasil){
                                echo '  <option selected value="'.$ListAlternatif.'">'.$ListAlternatif.'</option>';
                            }else{
                                echo '  <option value="'.$ListAlternatif.'">'.$ListAlternatif.'</option>';
                            }
                        }
                    }else{
                        echo '  <option value="">Tidak Ada Alternatif</option>';
                    }
                    echo '</select>';
                }
            ?>
            <small>
                <?php
                    if(!empty($satuan)){
                        echo "($satuan)";
                    }
                ?>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="interpertasi"><dt>Interpertasi</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" id="interpertasi" name="interpertasi" class="form-control" value="<?php echo "$interpertasi"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="keterangan"><dt>Keterangan</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" id="keterangan" name="keterangan" class="form-control" value="<?php echo "$keterangan"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12" id="NotifikasiTambahHasilPemeriksaan">
            <span class="text-primary">Pastikan data hasil pemeriksaan yang anda isi sudah sesuai!</span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <?php if(!empty($DataHasilPemeriksaan['id_rincian_lab'])){ ?>
                <button type="button" class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#ModalHapusHasilPemeriksaan" data-id="<?php echo "$id_rincian_lab"; ?>">
                    <i class="ti ti-trash"></i> Hapus hasil Pemeriksaan
                </button>
            <?php } ?>
        </div>
    </div>
<?php }} ?>