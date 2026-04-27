<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger text-center"><small>Sesi berakhir!</small></div>';
        exit;
    }

    if (empty($_POST['id_icd'])) {
        echo '<div class="alert alert-danger text-center"><small>ID tidak valid!</small></div>';
        exit;
    }

    $id_icd = (int) $_POST['id_icd'];

    $sql = "SELECT kode, short_des, long_des, icd FROM icd WHERE id_icd = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_icd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger text-center"><small>Data tidak ditemukan!</small></div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    $kode = htmlspecialchars($data['kode']);
    $short_des = htmlspecialchars($data['short_des']);
    $long_des = htmlspecialchars($data['long_des']);
    $icd = htmlspecialchars($data['icd']);

?>

<input type="hidden" name="id_icd" value="<?php echo $id_icd; ?>">
<div class="row mb-2">
    <div class="col-4"><small>ICD / Version</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text text-muted"><?php echo $icd; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode ICD</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text text-muted"><?php echo $kode; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Short Description</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text text-muted"><?php echo $short_des; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Long Description</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text text-muted"><?php echo $long_des; ?></small>
    </div>
</div>

<div class="alert alert-danger text-center">
    <small>
        Data yang dihapus tidak dapat dikembalikan!<br>
        <b>Apakah Anda Yakin Akan Menghapus Data Tersebut?</b>
    </small>
</div>