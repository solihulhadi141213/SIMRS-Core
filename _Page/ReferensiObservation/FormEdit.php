<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI id_observation_reference
    if (empty($_POST['id_observation_reference'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Referensi Tindakan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_observation_reference = validateAndSanitizeInput($_POST['id_observation_reference']);

    // Buka Data Referensi Tindakan
    $sql  = "SELECT * FROM observation_reference WHERE id_observation_reference = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_observation_reference);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data Referensi Tindakan Tidak Ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Tutup Statment
    $stmt->close();

    // MAPPING DATA
    $id_observation_reference = $Data['id_observation_reference'] ?? null;
    $category_name            = $Data['category_name'] ?? '-';
    $category_code            = $Data['category_code'] ?? '-';
    $category_display         = $Data['category_display'] ?? '-';
    $category_system          = $Data['category_system'] ?? '-';
    $observation_name         = $Data['observation_name'] ?? '-';
    $observation_code         = $Data['observation_code'] ?? '-';
    $observation_display      = $Data['observation_display'] ?? '-';
    $observation_system       = $Data['observation_system'] ?? '-';
    $result_type              = $Data['result_type'] ?? '-';
    $unit_name                = $Data['unit_name'] ?? '-';
    $unit_code                = $Data['unit_code'] ?? '-';
    $unit_display             = $Data['unit_display'] ?? '-';
    $unit_system              = $Data['unit_system'] ?? '-';
?>
<input type="hidden" name="id_observation_reference" value="<?php echo $id_observation_reference; ?>">
<div class="form_category_edit mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>A. Kategori Observasi</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4">
            <label for="category_name_edit"><small>Kategori Observasi</small></label>
        </div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <select name="category_name" id="category_name_edit" class="form-control" required>
                <option <?php if($category_name==""){echo "selected";} ?> value                  = "">Pilih</option>
                <option <?php if($category_name=="Riwayat Sosial"){echo "selected";} ?> value    = "Riwayat Sosial">Riwayat Sosial (Social History)</option>
                <option <?php if($category_name=="Tanda Vital"){echo "selected";} ?> value       = "Tanda Vital">Tanda Vital (Vital Signs)</option>
                <option <?php if($category_name=="Pencitraan Medis"){echo "selected";} ?> value  = "Pencitraan Medis">Pencitraan Medis (Imaging)</option>
                <option <?php if($category_name=="Laboratorium"){echo "selected";} ?> value      = "Laboratorium">Laboratorium (Laboratory)</option>
                <option <?php if($category_name=="Tindakan Medis"){echo "selected";} ?> value    = "Tindakan Medis">Tindakan Medis (Procedure)</option>
                <option <?php if($category_name=="Asesmen"){echo "selected";} ?> value           = "Asesmen">Asesmen (Survey)</option>
                <option <?php if($category_name=="Pemeriksaan Fisik"){echo "selected";} ?> value = "Pemeriksaan Fisik">Pemeriksaan Fisik (Exam)</option>
                <option <?php if($category_name=="Response Terapi"){echo "selected";} ?> value   = "Response Terapi">Response Terapi (Therapy)</option>
                <option <?php if($category_name=="Aktivitas"){echo "selected";} ?> value         = "Aktivitas">Aktivitas (Activity)</option>
                <option <?php if($category_name=="Gejala"){echo "selected";} ?> value            = "Gejala">Gejala (Symptom)</option>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="category_code_edit"><small><i>Code</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="category_code" id="category_code_edit" class="form-control" value="<?php echo $category_code; ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="category_display_edit"><small><i>Display</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="category_display" id="category_display_edit" class="form-control" value="<?php echo $category_display; ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="category_system_edit"><small><i>System</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="category_system" id="category_system_edit" class="form-control" value="<?php echo $category_system; ?>">
        </div>
    </div>
</div>

<div class="form_observation_edit mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>B. Nama/Jenis Observasi</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="observation_name_edit"><small>Nama Observasi</small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="observation_name" id="observation_name_edit" class="form-control" value="<?php echo $observation_name; ?>" required>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="observation_code_edit"><small><i>Code</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="observation_code" id="observation_code_edit" class="form-control" value="<?php echo $observation_code; ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="observation_display_edit"><small><i>Display</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="observation_display" id="observation_display_edit" class="form-control" value="<?php echo $observation_display; ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="observation_system_edit"><small><i>System</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="observation_system" id="observation_system_edit" class="form-control" value="<?php echo $observation_system; ?>">
        </div>
    </div>
</div>

<div class="form_result_type_edit mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>D. Tipe Hasil (<i>Result Type</i>)</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="result_type_edit"><small><i>Result Type</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <select name="result_type" id="result_type_edit" class="form-control" required>
                <option <?php if($result_type==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($result_type=="Numeric"){echo "selected";} ?> value="Numeric">Numeric</option>
                <option <?php if($result_type=="Decimal"){echo "selected";} ?> value="Decimal">Decimal</option>
                <option <?php if($result_type=="Coded"){echo "selected";} ?> value="Coded">Coded</option>
                <option <?php if($result_type=="Text"){echo "selected";} ?> value="Text">Text</option>
                <option <?php if($result_type=="Boolean"){echo "selected";} ?> value="Boolean">Boolean</option>
            </select>
        </div>
    </div>
</div>

<div class="form_result_coded_edit mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>C. Alternatif Jawaban (<i>Coded</i>)</b></small>
        </div>
    </div>
    <div class="row mb-2 mt-3">
        <div class="col-12">
            <button type="button" class="btn btn-sm btn-info w-100" id="TambahCodedEdit">
                <i class="bi bi-plus"></i> Tambah
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div id="WrapperResultCodedEdit">
                <!-- Form Coded akan muncul disini -->
                <?php
                    // Apabila result_type adalah Coded
                    if($result_type=="Coded"){
                        if(!empty($Data['result_coded'])){
                            $result_coded = $Data['result_coded'];
                            $result_coded_arry = json_decode($result_coded, true);

                            foreach ($result_coded_arry as $result_coded_list){
                                $label = $result_coded_list ['label'];
                                $value = $result_coded_list ['value'];

                                echo '
                                    <div class="item-coded-edit mb-2">
                                        <div class="input-group">
                                            <input type="text" name="label[]" class="form-control" placeholder="Label" value="'.$label.'">
                                            <input type="text" name="value[]" class="form-control" placeholder="Value" value="'.$value.'">
                                            <button type="button" 
                                                class="btn btn-outline-danger HapusCodedEdit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                ';
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form_satuan_unit_edit mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>C. Satuan (<i>Unit</i>)</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="unit_name_edit"><small>Satuan (Unit)</small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <select name="unit_name" id="unit_name_edit" class="form-control" value="<?php echo $unit_name; ?>">
                <option value="">Pilih</option>
                <?php
                    if(!empty($unit_name)){
                        echo '<option value="'.$unit_name.'" selected>'.$unit_name.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="unit_code_edit"><small><i>Code</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="unit_code" id="unit_code_edit" class="form-control" value="<?php echo $unit_code; ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="unit_display_edit"><small><i>Display</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="unit_display" id="unit_display_edit" class="form-control" value="<?php echo $unit_display; ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><label for="unit_system_edit"><small><i>System</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7">
            <input type="text" name="unit_system" id="unit_system_edit" class="form-control" value="<?php echo $unit_system; ?>">
        </div>
    </div>
</div>