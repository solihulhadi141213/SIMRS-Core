<?php
include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "../../_Config/SimrsFunction.php";

date_default_timezone_set('Asia/Jakarta');

// VALIDASI SESSION
if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger"><small>Sesi akses berakhir!</small></div>';
    exit;
}

// VALIDASI
if (empty($_POST['id_alergi'])) {
    echo '<div class="alert alert-danger"><small>ID alergi tidak boleh kosong!</small></div>';
    exit;
}

$id_alergi = validateAndSanitizeInput($_POST['id_alergi']);

// QUERY
$sql = "
    SELECT *
    FROM alergi
    WHERE id_alergi = ?
";

$stmt = $Conn->prepare($sql);
$stmt->bind_param("s", $id_alergi);
$stmt->execute();

$result = $stmt->get_result();
$data   = $result->fetch_assoc();

if (empty($data)) {
    echo '<div class="alert alert-danger"><small>Data alergi tidak ditemukan!</small></div>';
    exit;
}

// MAPPING
$id_pasien           = $data['id_pasien'];
$id_kunjungan        = $data['id_kunjungan'];
$id_alergi_alergen   = $data['id_alergi_alergen'];
$kategori_alergen    = $data['kategori_alergen'];
$nama_alergen        = $data['nama_alergen'];
$clinical_status     = $data['clinical_status'];
$id_praktisi         = $data['id_praktisi'];
$nama_praktisi       = $data['nama_praktisi'];
$keterangan_alergi   = $data['keterangan_alergi'];
?>

<input type="hidden" name="id_alergi" value="<?php echo $id_alergi; ?>">
<input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan; ?>">
<input type="hidden" name="manual_alergen" id="manual_alergen_edit">

<div class="row mb-3">
    <div class="col-12">
        <label>Kategori Alergen</label>

        <select name="kategori_alergen" id="kategori_alergen_edit" class="form-select">
            <option value="Food" <?php if($kategori_alergen=="Food"){echo "selected";} ?>>Food</option>
            <option value="Medication" <?php if($kategori_alergen=="Medication"){echo "selected";} ?>>Medication</option>
            <option value="Environment" <?php if($kategori_alergen=="Environment"){echo "selected";} ?>>Environment</option>
            <option value="Biologic" <?php if($kategori_alergen=="Biologic"){echo "selected";} ?>>Biologic</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">

        <label>Jenis Alergen</label>

        <select name="id_alergi_alergen" id="id_alergi_alergen_edit" class="form-select">

            <?php
                if(!empty($id_alergi_alergen)){
                    echo '
                        <option value="'.$id_alergi_alergen.'" selected>
                            '.$nama_alergen.'
                        </option>
                    ';
                }else{
                    echo '
                        <option value="'.$nama_alergen.'" selected>
                            '.$nama_alergen.'
                        </option>
                    ';
                }
            ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">

        <label>Status Klinis</label>

        <select name="clinical_status" class="form-select">

            <option value="active" <?php if($clinical_status=="active"){echo "selected";} ?>>
                Active
            </option>

            <option value="inactive" <?php if($clinical_status=="inactive"){echo "selected";} ?>>
                Inactive
            </option>

            <option value="resolved" <?php if($clinical_status=="resolved"){echo "selected";} ?>>
                Resolved
            </option>

        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">

        <label>Praktisi</label>

        <select name="id_praktisi" id="id_praktisi_edit" class="form-select">

            <?php
                if(!empty($id_praktisi)){
                    echo '
                        <option value="'.$id_praktisi.'" selected>
                            '.$nama_praktisi.'
                        </option>
                    ';
                }
            ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">

        <label>Keterangan/Reaksi</label>

        <textarea name="keterangan_alergi" class="form-control"><?php echo $keterangan_alergi; ?></textarea>

    </div>
</div>

<script>

$(document).ready(function () {

    // SELECT2 ALERGEN
    $('#id_alergi_alergen_edit').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#ModalEdit'),
        placeholder: 'Pilih atau ketik alergen',
        tags: true,

        ajax: {

            url: '_Page/Alergi/SelectAlergen.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,

            data: function(params){

                return {
                    search: params.term,
                    kategori_alergen: $('#kategori_alergen_edit').val(),
                    page: params.page || 1
                };
            },

            processResults: function(data, params){

                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            }
        }
    });

    // INPUT MANUAL
    $('#id_alergi_alergen_edit').on('select2:select', function(e){

        let data = e.params.data;

        if(data.newTag){
            $('#manual_alergen_edit').val(data.text);
        }else{
            $('#manual_alergen_edit').val('');
        }
    });

    // RELOAD KATEGORI
    $('#kategori_alergen_edit').on('change', function(){

        $('#id_alergi_alergen_edit')
            .val(null)
            .trigger('change');
    });

    // SELECT2 PRAKTISI
    $('#id_praktisi_edit').select2({

        theme: 'bootstrap-5',
        dropdownParent: $('#ModalEdit'),
        placeholder: 'Pilih Praktisi',

        ajax: {

            url: '_Page/Alergi/SelectPraktisi.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,

            data: function(params){

                return {
                    search: params.term,
                    page: params.page || 1
                };
            },

            processResults: function(data, params){

                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            }
        }
    });

});

</script>