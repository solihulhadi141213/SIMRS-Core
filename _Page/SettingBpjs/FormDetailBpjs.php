<?php
    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Sesi Akses
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</div>';
        exit;
    }

    // Validasi input
    if (empty($_POST['id_setting_bpjs'])) {
        echo '<div class="alert alert-danger">ID tidak valid.</div>';
        exit;
    }

    $id = intval($_POST['id_setting_bpjs']);

    // Ambil data
    $stmt = $Conn->prepare("SELECT * FROM setting_bpjs WHERE id_setting_bpjs = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
        exit;
    }

    $data = $result->fetch_assoc();

    // Helper function untuk field
    function renderField($label, $value, $copy = false, $isUrl = false) {
        $valueDisplay = htmlspecialchars($value ?? '');

        // Style khusus URL panjang
        $style = $isUrl 
            ? 'style="white-space: nowrap; overflow-x: auto;"' 
            : '';

        echo '
        <div class="mb-3">
            <label class="form-label"><small>'.$label.'</small></label>
            <div class="input-group input-group-md">
                <input 
                    type="text" 
                    class="form-control bg-light" 
                    value="'.$valueDisplay.'" 
                    readonly 
                    '.$style.'
                >';

        // Tombol copy
        if ($copy && !empty($value)) {
            echo '
                <button 
                    class="btn btn-sm btn-secondary btn-copy" 
                    type="button"
                    data-copy="'.htmlspecialchars($value).'"
                    title="Copy"
                >
                    <i class="bi bi-clipboard"></i>
                </button>';
        }

        echo '
            </div>
        </div>';
    }
?>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-6">
            <?php renderField('Profil Pengaturan', $data['nama_setting_bpjs']); ?>
        </div>

        <div class="col-md-6">
            <?php renderField('Kode PPK', $data['kode_ppk'], true); ?>
        </div>

        <div class="col-md-6">
            <?php renderField('Cons ID', $data['consid'], true); ?>
        </div>

        <div class="col-md-6">
            <?php renderField('User Key (Vclaim)', $data['user_key'], true); ?>
        </div>

        <div class="col-md-6">
            <?php renderField('User Key (Antrol)', $data['user_key_antrol'], true); ?>
        </div>

        <div class="col-md-6">
            <?php renderField('Secret Key', $data['secret_key'], true); ?>
        </div>

        <div class="col-12">
            <?php renderField('URL Vclaim', $data['url_vclaim'], false, true); ?>
        </div>

        <div class="col-12">
            <?php renderField('URL Aplicare', $data['url_aplicare'], false, true); ?>
        </div>

        <div class="col-12">
            <?php renderField('URL Antrol', $data['url_antrol'], false, true); ?>
        </div>

        <div class="col-12">
            <?php renderField('URL iCare', $data['url_icare'], false, true); ?>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label class="form-label"><small>Status</small></label><br>
                <?php if ($data['status'] == 1) { ?>
                    <span class="badge bg-success">Aktif</span>
                <?php } else { ?>
                    <span class="badge bg-danger">Tidak Aktif</span>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

<!-- SCRIPT COPY -->
<script>
    $(document).off('click', '.btn-copy').on('click', '.btn-copy', function () {
        let text = $(this).data('copy');

        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Berhasil disalin',
                showConfirmButton: false,
                timer: 1500
            });
        }).catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal copy'
            });
        });
    });
</script>