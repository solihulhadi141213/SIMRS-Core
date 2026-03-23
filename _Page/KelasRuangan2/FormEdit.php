<?php
    //Koneksi
    include "../../_Config/Connection.php";

    //tangkap ID
    if(empty($_POST['id_ruang_rawat'])){
        echo '<div clas="alert alert-danger">ID Kelas/Ruangan Tidak Boleh Kosong!</div>';
        exit;
    }

    //Buat Variabel
    $id_ruang_rawat = $_POST['id_ruang_rawat'];

    //Buka Data Dari Database
    $Qry = mysqli_query($Conn,"SELECT *  FROM ruang_rawat WHERE id_ruang_rawat='$id_ruang_rawat'")or die(mysqli_error($Conn));
    $Data = mysqli_fetch_array($Qry);

    //Apabila kategori tidak diemukan
    if(Empty($Data['kategori'])){
        echo '<div clas="alert alert-danger">Data yang anda pilih dari database tidak ditemukan!</div>';
        exit;
    }

    $kategori       = $Data['kategori'];
    $kodekelas      = $Data['kodekelas'];
    $kelas          = $Data['kelas'];

    //Tampilkan Data
    echo '
        <input type="hidden" name="id_ruang_rawat" value="'.$id_ruang_rawat.'">
        <input type="hidden" name="kategori" value="'.$kategori.'">
    ';

    //Menampilkan Detail Berdasarkan Kategori
    if($kategori=="bed"){
        $ruangan    = $Data['ruangan'];
        $bed        = $Data['bed'];
        
        // Buat Select Option Untuk Kelas
        $OptionKelas = '<option value="">Pilih</option>';
        $sql = "SELECT kodekelas, kelas FROM ruang_rawat WHERE kategori='kelas' ORDER BY kelas ASC";
        $result = $Conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $kode = htmlspecialchars($row['kodekelas'], ENT_QUOTES, 'UTF-8');
                $nama = htmlspecialchars($row['kelas'], ENT_QUOTES, 'UTF-8');
                if($nama==$kelas){
                    $OptionKelas .= "<option selected value='{$nama}'>{$nama}</option>";
                }else{
                    $OptionKelas .= "<option value='{$nama}'>{$nama}</option>";
                }
            }
        }

        // Buat Select Option Untuk Ruangan
        $OptionRuangan = '<option value="">Pilih</option>';
        $sql_ruangan = "SELECT ruangan FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas' ORDER BY ruangan ASC";
        $result_ruangan = $Conn->query($sql_ruangan);
        if ($result_ruangan && $result_ruangan->num_rows > 0) {
            while ($row_ruangan = $result_ruangan->fetch_assoc()) {
                $ruangan_list = htmlspecialchars($row_ruangan['ruangan'], ENT_QUOTES, 'UTF-8');
                if($ruangan==$ruangan_list){
                    $OptionRuangan .= "<option selected value='{$ruangan_list}'>{$ruangan_list}</option>";
                }else{
                    $OptionRuangan .= "<option value='{$ruangan_list}'>{$ruangan_list}</option>";
                }
            }
        }
        
        //Tampilkan Form
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <label class="kelas_tambah_option_edit">Kelas</label>
                    <select class="form-control" name="kelas" id="kelas_tambah_option_edit">
                        '.$OptionKelas.'
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="ruangan_tambah_option_edit">Ruangan</label>
                    <select class="form-control" name="ruangan" id="ruangan_tambah_option_edit">
                        '.$OptionRuangan.'
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="bed_edit">Tempat Tidur</label>
                    <input type="text" class="form-control" name="bed" id="bed_edit" value="'.$bed.'">
                </div>
            </div>
        ';
        //Routing Gender
        if(!empty($Data['pria'])){
            echo '
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="gender_edit">Gender Khusus</label>
                        <select class="form-control" name="gender" id="gender_edit">
                            <option value="Campur">Campur</option>
                            <option selected value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                </div>
            ';
        }
        if(!empty($Data['wanita'])){
            echo '
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="gender_edit">Gender Khusus</label>
                        <select class="form-control" name="gender" id="gender_edit">
                            <option value="Campur">Campur</option>
                            <option value="Pria">Pria</option>
                            <option selected value="Wanita">Wanita</option>
                        </select>
                    </div>
                </div>
            ';
        }
        if(!empty($Data['bebas'])){
            echo '
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="gender_edit">Gender Khusus</label>
                        <select class="form-control" name="gender" id="gender_edit">
                            <option selected value="Campur">Campur</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                </div>
            ';
        }

    }


    if($kategori=="ruangan"){
        // Buat Select Option Untuk Kelas
        $OptionKelas = '<option value="">Pilih</option>';
        $sql = "SELECT kodekelas, kelas FROM ruang_rawat WHERE kategori='kelas' ORDER BY kelas ASC";
        $result = $Conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $kode = htmlspecialchars($row['kodekelas'], ENT_QUOTES, 'UTF-8');
                $nama = htmlspecialchars($row['kelas'], ENT_QUOTES, 'UTF-8');
                if($nama==$kelas){
                    $OptionKelas .= "<option selected value='{$nama}'>{$nama}</option>";
                }else{
                    $OptionKelas .= "<option value='{$nama}'>{$nama}</option>";
                }
            }
        }

        $ruangan          = $Data['ruangan'];
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <label class="kelas_tambah_option_edit">Kelas</label>
                    <select class="form-control" name="kelas" id="kelas_tambah_option_edit">
                        '.$OptionKelas.'
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="ruangan_edit">Nama Ruangan</label>
                    <input type="text" class="form-control" name="ruangan" id="ruangan_edit" value="'.$ruangan.'">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    Mengubah informasi ruangan, akan mengubah semua informasi tempat tidur yang terhubung dengan ruangan ini.
                </div>
            </div>
        ';
    }
    if($kategori=="kelas"){
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <label class="kodekelas_edit">Kode Kelas</label>
                    <input type="text" class="form-control" name="kodekelas" id="kodekelas_edit" value="'.$kodekelas.'">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="kelas_tambah">Nama Kelas</label>
                    <input type="text" class="form-control" name="kelas" id="kelas_tambah" value="'.$kelas.'">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    Mengubah informasi kelas, akan mengubah semua informasi ruangan dan tempat tidur yang terhubung dengan kelas ini.
                </div>
            </div>
        ';
    }
?>