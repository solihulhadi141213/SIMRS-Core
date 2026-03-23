<?php
    //Koneksi
    include "../../_Config/Connection.php";

    //Tangkap kategori_tambah
    if(empty($_POST['kategori_tambah'])){
        $kategori_tambah    = "";
    }else{
        $kategori_tambah    = $_POST['kategori_tambah'];
    }

    //Form Mode Kelas
    if($kategori_tambah=="kelas"){
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <label class="kodekelas_tambah">Kode Kelas</label>
                    <input type="text" class="form-control" name="kodekelas" id="kodekelas_tambah">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="kelas_tambah">Nama Kelas</label>
                    <input type="text" class="form-control" name="kelas" id="kelas_tambah">
                </div>
            </div>
        ';
    }else{
         if($kategori_tambah=="ruangan"){
            // Buat variabel kosong
            $OptionKelas = '<option value="">Pilih</option>';

            // Ambil data kelas
            $sql = "SELECT kodekelas, kelas FROM ruang_rawat WHERE kategori='kelas' ORDER BY kelas ASC";
            $result = $Conn->query($sql);

            // Loop hasil query dan tambahkan ke variabel
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $kode = htmlspecialchars($row['kodekelas'], ENT_QUOTES, 'UTF-8');
                    $nama = htmlspecialchars($row['kelas'], ENT_QUOTES, 'UTF-8');
                    $OptionKelas .= "<option value='{$kode}'>{$nama}</option>";
                }
            }
            echo '
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="kodekelas_tambah_option">Kelas</label>
                        <select class="form-control" name="kodekelas" id="kodekelas_tambah_option">
                            '.$OptionKelas.'
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="ruangan_tambah">Nama Ruangan</label>
                        <input type="text" class="form-control" name="ruangan" id="ruangan_tambah">
                    </div>
                </div>
            ';
        }else{
            if($kategori_tambah=="bed"){
                // Buat variabel kosong
                $OptionKelas = '<option value="">Pilih</option>';

                // Ambil data kelas
                $sql = "SELECT kodekelas, kelas FROM ruang_rawat WHERE kategori='kelas' ORDER BY kelas ASC";
                $result = $Conn->query($sql);

                // Loop hasil query dan tambahkan ke variabel
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $kode = htmlspecialchars($row['kodekelas'], ENT_QUOTES, 'UTF-8');
                        $nama = htmlspecialchars($row['kelas'], ENT_QUOTES, 'UTF-8');
                        $OptionKelas .= "<option value='{$nama}'>{$nama}</option>";
                    }
                }
                echo '
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="kelas_tambah_option">Kelas</label>
                            <select class="form-control" name="kelas" id="kelas_tambah_option">
                                '.$OptionKelas.'
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="ruangan_tambah_option">Ruangan</label>
                            <select class="form-control" name="ruangan" id="ruangan_tambah_option">
                               <option>Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="bed_tambah">Tempat Tidur</label>
                            <input type="text" class="form-control" name="bed" id="bed_tambah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="gender">Gender Khusus</label>
                            <select class="form-control" name="gender" id="gender">
                               <option value="Campur">Campur</option>
                               <option value="Pria">Pria</option>
                               <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                    </div>
                ';
            }else{
                
            }
        }
    }
?>