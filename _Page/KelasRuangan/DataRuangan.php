<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap kelas
    if(empty($_POST['PilihKelas'])){
        $kelas="";
        echo '<div class="col-xl-4 col-md-4">';
        echo '  <div class="card table-card">';
        echo '      <div class="card-body">';
        echo '          Pilih Kelas Terlebih Dulu';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $kelas=$_POST['PilihKelas'];
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas'"));
        if(empty($jml_data)){
            echo '<div class="col-xl-4 col-md-4">';
            echo '  <div class="card table-card bg-danger">';
            echo '      <div class="card-body">';
            echo '          Belum Ada Data Ruangan';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE (kategori='ruangan') AND (kelas='$kelas') ORDER BY kelas ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_ruang_rawat = $data['id_ruang_rawat'];
                $KelasList = $data['kelas'];
                $kodekelas = $data['kodekelas'];
                $ruangan = $data['ruangan'];
                $status = $data['status'];
                $updatetime = $data['updatetime'];
                //menghitung jumlah ruangan
                $JumlahBed = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND kelas='$KelasList' AND ruangan='$ruangan'"));
                $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE kelas='$KelasList' AND ruangan='$ruangan' AND status='Terdaftar'"));

?>
    <div class="col-xl-4 col-md-4">
        <div class="card table-card">
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-8">
                        <dt class="text-dark">
                            <?php echo "$ruangan"; ?>
                        </dt>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <small>Kode : <?php echo "$kodekelas"; ?></small><br>
                                <small>Kelas : <?php echo "$KelasList"; ?></small><br>
                                <small>Status : <?php echo "$status"; ?></small><br>
                                <small>Tempat Tidur : <?php echo "$JumlahBed Bed"; ?></small><br>
                                <a href="javascript:void(0);" class="text text-primary" data-toggle="modal" data-target="#ModalPasienByRuangan" data-id="<?php echo "$KelasList,$ruangan"; ?>">
                                    <small>Pasien : <?php echo "$JumlahPasien Orang"; ?></small>
                                </a><br>
                                <small>Updatetime : <?php echo "$updatetime"; ?></small><br>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4 text-center text-facebook">
                        <i class="icofont-patient-bed icofont-3x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info">
                <button type="button" class="btn btn-sm btn-outline-dark btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalEditRuangan" data-id="<?php echo "$id_ruang_rawat"; ?>">
                    <i class="ti ti-pencil-alt"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-dark btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalHapusRuangan" data-id="<?php echo "$id_ruang_rawat"; ?>">
                    <i class="ti ti-trash"></i> Hapus
                </button>
                <button type="button" class="btn btn-sm btn-outline-dark btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalTampilkanBed" data-id="<?php echo "$ruangan"; ?>">
                    <i class="icofont-external"></i> Bed
                </button>
            </div>
        </div>
    </div>
<?php }}} ?>