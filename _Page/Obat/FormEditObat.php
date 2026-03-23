<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_obat
    if(empty($_POST['id_obat'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Obat/Alkes Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        $id_obat=getDataDetail($Conn,'obat','id_obat',$id_obat,'id_obat');
        //Buka data obat
        if(empty($id_obat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Obat/Alkes Tidak Valid!';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
            $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
            $kelompok=getDataDetail($Conn,'obat','id_obat',$id_obat,'kelompok');
            $kategori=getDataDetail($Conn,'obat','id_obat',$id_obat,'kategori');
            $satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
            $isi=getDataDetail($Conn,'obat','id_obat',$id_obat,'isi');
            $stok=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
            $harga=getDataDetail($Conn,'obat','id_obat',$id_obat,'harga');
            $stok_min=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok_min');
            $keterangan=getDataDetail($Conn,'obat','id_obat',$id_obat,'keterangan');
            $tanggal=getDataDetail($Conn,'obat','id_obat',$id_obat,'tanggal');
            $updatetime=getDataDetail($Conn,'obat','id_obat',$id_obat,'updatetime');
?>
    <input type="hidden" name="id_obat" value="<?php echo "$id_obat"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kode2">Kode</label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" name="kode" id="kode2" class="form-control" required value="<?php echo $kode;?>">
                <button type="button" class="btn btn-sm btn-outline-secondary" title="Generate Kode Baru" id="GenerateKodeObatBaru2">
                    <i class="ti ti-reload"></i>
                </button>
            </div>
            <small>
                <i>Apabila anda memilih melakukan genertae kode, maka sistem akan membutakan kode 16 digit angka acak</i>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nama_obat">Nama/Merek</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nama_obat" id="nama_obat" class="form-control" required value="<?php echo $nama;?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kelompok">Kelompok</label>
        </div>
        <div class="col-md-8">
            <select name="kelompok" id="kelompok" class="form-control">
                <option <?php if($kelompok=="Obat"){echo "selected";} ?> value="Obat">Obat</option>
                <option <?php if($kelompok=="Alkes"){echo "selected";} ?> value="Alkes">Alkes</option>
                <option <?php if($kelompok=="Lainnya"){echo "selected";} ?>  value="Lainnya">Lainnya</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kategori">Kategori</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kategori" id="kategori" list="DataListKategori" class="form-control" value="<?php echo $kategori;?>" required>
            <datalist id="DataListKategori">
                <option value="a">
                <?php
                    $QryKategori=mysqli_query($Conn, "SELECT DISTINCT kategori FROM obat")or die(mysqli_error($Conn));
                    while($HasilKategori=mysqli_fetch_array($QryKategori)){
                        echo '<option value="'.$HasilKategori['kategori'].'">';
                    }
                ?>
            </datalist>
            <small>Informasi/keterangan group data obat</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="satuan">Satuan</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="satuan" id="satuan" list="DataListSatuan" class="form-control" value="<?php echo $satuan;?>">
            <datalist id="DataListSatuan">
                <option value="a">
                <?php
                    $QrySatuan=mysqli_query($Conn, "SELECT DISTINCT satuan FROM obat")or die(mysqli_error($Conn));
                    while($HasilSatuan=mysqli_fetch_array($QrySatuan)){
                        echo '<option value="'.$HasilSatuan['satuan'].'">';
                    }
                ?>
            </datalist>
            <small>
                Untuk mempermudah penggunaan fitur multi satuan, kami merekomendasikan menggunakan satuan terkecil yang digunakan.
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="isi">Isi/Kemasan</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="0" step="1" name="isi" id="isi" class="form-control" value="<?php echo $isi;?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="stok">Stok</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="0" step="1" name="stok" id="stok" class="form-control" value="<?php echo $stok;?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="stok_min">Stok Minimum</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="0" step="1" name="stok_min" id="stok_min" class="form-control" value="<?php echo $stok_min;?>">
            <small>Ketika stok berada di ambang stok minimum maka sistem akan memberikan informasi.</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="harga">Harga Beli</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="0" step="1" name="harga" id="harga" class="form-control" value="<?php echo $harga;?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="">Multi Harga</label>
        </div>
    </div>
    <?php
        //Jumlah Kategori
        $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_kategori_harga"));
        if(empty($JumlahKategori)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 text-danger">';
            echo '      Tidak Ada Data Kategori Harga';
            echo '  </div>';
            echo '</div>';
        }else{
            $query = mysqli_query($Conn, "SELECT*FROM obat_kategori_harga ORDER BY kategori_harga ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_kategori_harga= $data['id_kategori_harga'];
                $kategori_harga= $data['kategori_harga'];
                $keterangan= $data['keterangan'];
                //Buka Multi Harga Bersangkutan
                $QryView = mysqli_query($Conn,"SELECT * FROM obat_harga WHERE id_kategori_harga='$id_kategori_harga' AND id_obat='$id_obat'")or die(mysqli_error($Conn));
                $DataView = mysqli_fetch_array($QryView);
                if(!empty($DataView['harga'])){
                    $harga_multi = $DataView['harga'];
                }else{
                    $harga_multi ="0";
                }
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-4"><label for="MultiHarga'.$id_kategori_harga.'"></label>'.$kategori_harga.'</div>';
                echo '  <div class="col-md-8">';
                echo '      <input type="number" id="MultiHarga'.$id_kategori_harga.'" name="MultiHarga'.$id_kategori_harga.'" class="form-control" value="'.$harga_multi.'">';
                echo '      <small class="text-secondary">'.$keterangan.'</small>';
                echo '  </div>';
                echo '</div>';
            }
        }
    ?>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="keterangan">Keterangan/Catatan</label>
        </div>
        <div class="col-md-8">
            <textarea name="keterangan" id="keterangan" class="form-control"><?php echo $keterangan;?></textarea>
            <small>Sertakan catatan/keterangan penting</small>
        </div>
    </div>
<?php }} ?>