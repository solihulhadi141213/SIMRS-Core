<div class="row">
    <div class="col-md-6 mb-3">
        <label for="kategori">Kategori</label>
        <select name="kategori" id="" class="form-control">
            <option value="">All</option>
            <?php
                include "../../_Config/Connection.php";
                $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM obat ORDER BY kategori ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $kategori= $data['kategori'];
                    echo '<option value="'.$kategori.'">'.$kategori.'</option>';
                }
            ?>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="satuan">Satuan</label>
        <select name="satuan" id="" class="form-control">
            <option value="">All</option>
            <?php
                $query2 = mysqli_query($Conn, "SELECT DISTINCT satuan FROM obat ORDER BY satuan ASC");
                while ($data2 = mysqli_fetch_array($query2)) {
                    $satuan= $data2['satuan'];
                    echo '<option value="'.$satuan.'">'.$satuan.'</option>';
                }
            ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="keyword_by">Keyword By</label>
        <select name="keyword_by" id="" class="form-control">
            <option value="">All</option>
            <option value="kode">Kode Obat</option>
            <option value="nama_obat">Nama Obat</option>
            <option value="isi">Isi/Konversi</option>
            <option value="stok">Stok</option>
            <option value="harga_1">Harga Beli</option>
            <option value="harga_2">Harga Eceran</option>
            <option value="harga_3">Harga Grosir</option>
            <option value="harga_4">Harga Medis</option>
            <option value="stok_min">Minimum Stok</option>
            <option value="updatetime">Last Update</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="OrderBy">Order By</label>
        <select name="OrderBy" id="" class="form-control">
            <option value="">ID</option>
            <option value="kode">Kode Obat</option>
            <option value="nama_obat">Nama Obat</option>
            <option value="isi">Isi/Konversi</option>
            <option value="stok">Stok</option>
            <option value="harga_1">Harga Beli</option>
            <option value="harga_2">Harga Eceran</option>
            <option value="harga_3">Harga Grosir</option>
            <option value="harga_4">Harga Medis</option>
            <option value="stok_min">Minimum Stok</option>
            <option value="updatetime">Last Update</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="ShortBy">Short By</label>
        <select name="ShortBy" id="" class="form-control">
            <option value="ASC">ASC</option>
            <option value="DESC">DESC</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="format">Format</label>
        <select name="format" id="" class="form-control">
            <option value="HTML">HTML</option>
            <option value="PDF">PDF</option>
            <option value="Excel">Excel</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="keyword">Keyword</label>
        <input type="text" name="keyword" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3" id="NotifikasiFilterObat">
        <span class="text-primary">Apakah anda yakin akan melakukan filter data obat?</span>
    </div>
</div>