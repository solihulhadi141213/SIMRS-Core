<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_radiologi_file
    if(empty($_POST['id_laboratorium_parameter'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Parameter Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_laboratorium_parameter=$_POST['id_laboratorium_parameter'];
        $parameter=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'parameter');
        $kategori_parameter=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'kategori_parameter');
        $tipe_data=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'tipe_data');
        $alternatif=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'alternatif');
        $nilai_rujukan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'nilai_rujukan');
        $nilai_kritis=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'nilai_kritis');
        $satuan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'satuan');
        $keterangan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'keterangan');
?>
    <input type="hidden" id="id_laboratorium_parameter" name="id_laboratorium_parameter" value="<?php echo "$id_laboratorium_parameter"; ?>">
    <div class="row">
        <div class="col-md-12 mb-4">
            <label for="parameter"><dt>Nama Parameter</dt></label>
            <input type="text"  class="form-control" id="parameter" name="parameter" value="<?php echo "$parameter"; ?>">
            <small>Nama Pemeriksaan  Lab</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <label for="kategori_parameter"><dt>Kategori Parameter</dt></label>
            <input type="text"  class="form-control" id="kategori_parameter" name="kategori_parameter" list="ListKategori" value="<?php echo "$kategori_parameter"; ?>">
            <datalist id="ListKategori">
                <?php
                    $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori_parameter FROM laboratorium_parameter ORDER BY kategori_parameter ASC");
                    while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                        $kategori_parameter_list= $DataKategori['kategori_parameter'];
                        echo '<option value="'.$kategori_parameter_list.'">';
                    }
                ?>
            </datalist>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="tipe_data"><dt>Tipe Data</dt></label>
            <select name="tipe_data" id="tipe_data" class="form-control">
                <option <?php if($tipe_data=="Number"){echo "selected";} ?> value="Number">Number</option>
                <option <?php if($tipe_data=="Text"){echo "selected";} ?> value="Text">Text</option>
            </select>
        </div>
        <div class="col-md-6 mb-4">
            <label for="satuan"><dt>Satuan</dt></label>
            <input type="text"  class="form-control" id="satuan" name="satuan" value="<?php echo "$satuan"; ?>">
            <small>Satuan Ukur (grm, %, ml, dll)</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="nilai_rujukan"><dt>Nilai Rujukan</dt></label>
            <input type="text"  class="form-control" id="nilai_rujukan" name="nilai_rujukan" value="<?php echo "$nilai_rujukan"; ?>">
            <small>Nilai standar batas normal</small>
        </div>
        <div class="col-md-6 mb-4">
            <label for="nilai_kritis"><dt>Nilai Kritis</dt></label>
            <input type="text"  class="form-control" id="nilai_kritis" name="nilai_kritis" value="<?php echo "$nilai_kritis"; ?>">
            <small>Nilai ambang batas dari nilai rujukan</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <label for="keterangan"><dt>Keterangan</dt></label>
            <textarea name="keterangan" id="keterangan" id="" cols="30" rows="3" class="form-control"><?php echo "$keterangan"; ?></textarea>
        </div>
    </div>
    <div class="row" id="ListFormAlternatif2">
        <?php
            //menampilkan alternatif jawaban
            if(!empty($alternatif)){
                $ambil_json =json_decode($alternatif, true);
                $string=count($ambil_json);
                for($i=0; $i<$string; $i++){
                    $ListAlternatif=$ambil_json[$i]['alternatif'];
                    echo '<div class="col-md-12"><div class="input-group"><input type="text" id="alternatif[]" name="alternatif[]" class="form-control" value="'.$ListAlternatif.'" placeholder="Alternatif Jawaban"><button type="button" class="btn btn-sm btn-danger" id="HapusForm2"><i class="ti ti-close"></i></button></div></div>';
                }
                
            }
        ?>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <button type="button" class="btn btn-sm btn btn-outline-info btn-block"  id="AddAlternate2">
                <i class="ti ti-plus"></i> Tambah Alternatif
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4" id="NotifikasiEditParameterLaboratorium">
            <span class="text-primary">Pastikan data parameter sudah sesuai</span>
        </div>
    </div>
<?php } ?>