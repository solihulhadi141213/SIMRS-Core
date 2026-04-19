<div class="row mt-4 mb-4">
    <div class="col-12">
        <label for="id_akses_entitas">Entitas Akses</label>
        <select name="id_akses_entitas" id="id_akses_entitas" class="form-control">
            <option value="">Pilih</option>
            <?php
                // Connection 
                include "../../_Config/Connection.php";

                // Query data entitas akses
                $query = "SELECT id_akses_entitas, akses FROM akses_entitas ORDER BY akses ASC";
                $result = mysqli_query($Conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id   = htmlspecialchars($row['id_akses_entitas']);
                        $akses = htmlspecialchars($row['akses']);
                        echo "<option value='$id'>$akses</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada data entitas</option>";
                }
            ?>
        </select>
    </div>
</div>
<div class="row mt-4 mb-4" id="form_password">
    <div class="col-12">
        <label for="password_pengguna">Password</label>
        <div class="input-group">
            <input type="text" name="password_pengguna" id="password_pengguna" class="form-control">
            <button type="button" class="btn btn-sm btn-secondary" id="GeneratePassword">
                <i class="bi bi-arrow-left-right"></i> Generate
            </button>
        </div>
    </div>
</div>