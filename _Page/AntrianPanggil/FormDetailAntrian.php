<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Periksa Session
    if(empty($_SESSION['id_akses'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger mb-3">';
        echo '          Sesi Akses Sudah Berakhir, Silahkan Login Ulang!';
        echo '      </div>';
        echo '  </div>';
    }else{
        //Tangkap id_antrian
        if(empty($_POST['id_antrian'])){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger mb-3">';
            echo '          ID Antrian Tidak Boleh Kosong';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_antrian=$_POST['id_antrian'];
            //Buka Database Antrian
            $stmt = $Conn->prepare("SELECT * FROM antrian WHERE id_antrian = ?");
            $stmt->bind_param("s", $id_antrian);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            // Apabila Data Tidak Ditemukan
            if (!$row) {
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-center text-danger mb-3">';
                echo '          ID Antrian Tidak Valid Atau Tidak Ditemukan Pada Database';
                echo '      </div>';
                echo '  </div>';
            }else{
                // Ambil data dari hasil query
                $no_antrian     = htmlspecialchars($row['no_antrian']);
                $kodebooking    = htmlspecialchars($row['kodebooking']);
                $nama_pasien    = htmlspecialchars($row['nama_pasien']);
                $kodepoli       = htmlspecialchars($row['kodepoli']);
                $namapoli       = htmlspecialchars($row['namapoli']);
                $kode_dokter    = htmlspecialchars($row['kode_dokter']);
                $nama_dokter    = htmlspecialchars($row['nama_dokter']);
                $sumber_antrian = htmlspecialchars($row['sumber_antrian']);
?>
        <input type="hidden" name="Page" value="Antrian">
        <input type="hidden" name="Sub" value="DetailAntrian">
        <input type="hidden" name="id" value="<?php echo "$id_antrian"; ?>">
        <input type="hidden" name="no_antrian" id="no_antrian" value="<?php echo "$no_antrian"; ?>">
        <input type="hidden" name="kodepoli" id="kodepoli" value="<?php echo "$kodepoli"; ?>">
        <div class="row mb-3"> 
            <div class="col-md-12 text-center">
                No.Antrian<br>
                <h1><?php echo "$no_antrian"; ?></h1>
                <p>
                    <dt><?php echo "$namapoli ($kodepoli)"; ?></dt>
                    <?php echo "$nama_dokter"; ?>
                </p>
            </div>
        </div>
<?php }}} ?>