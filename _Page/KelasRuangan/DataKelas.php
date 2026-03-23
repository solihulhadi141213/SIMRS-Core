<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='kelas'"));
    if(empty($jml_data)){
        echo '<div class="col-xl-4 col-md-4">';
        echo '  <div class="card table-card bg-danger">';
        echo '      <div class="card-body">';
        echo '          Belum Ada Data Kelas';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(!empty($_POST['keyword'])){
            $keyword=$_POST['keyword'];
            $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE (kategori='kelas') AND (kodekelas like '%$keyword%' OR kelas like '%$keyword%') ORDER BY kelas ASC");
        }else{
            $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='kelas' ORDER BY kelas ASC");
        }
        
        while ($data = mysqli_fetch_array($query)) {
            $id_ruang_rawat = $data['id_ruang_rawat'];
            $kelas = $data['kelas'];
            $kodekelas = $data['kodekelas'];
            $updatetime = $data['updatetime'];
            //menghitung jumlah ruangan
            $JumlahRuangan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas'"));
            $JumlahBed = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND kelas='$kelas'"));
            $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE kelas='$kelas' AND status='Terdaftar'"));

?>
    <div class="col-xl-4 col-md-4">
        <div class="card table-card">
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-8">
                        <dt class="text-dark">
                            <?php echo "$kelas"; ?>
                        </dt>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <small>Kode : <?php echo "$kodekelas"; ?></small><br>
                                <small>Ruangan : <?php echo "$JumlahRuangan Ruangan"; ?></small><br>
                                <small>Tempat Tidur : <?php echo "$JumlahBed Bed"; ?></small><br>
                                <a href="javascript:void(0);" class="text text-primary" data-toggle="modal" data-target="#ModalPasienByKelas" data-id="<?php echo "$kelas"; ?>">
                                    <small>Pasien : <?php echo "$JumlahPasien Orang"; ?></small>
                                </a>
                                <br>
                                <small>Updatetime : <?php echo "$updatetime"; ?></small><br>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4 text-center text-facebook">
                        <i class="icofont-hospital icofont-3x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info">
                <button type="button" class="btn btn-sm btn-outline-dark btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalEditKelas" data-id="<?php echo "$id_ruang_rawat"; ?>">
                    <i class="ti ti-pencil-alt"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-dark btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalHapusKelas" data-id="<?php echo "$id_ruang_rawat"; ?>">
                    <i class="ti ti-trash"></i> Hapus
                </button>
                <button type="button" class="btn btn-sm btn-outline-dark btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalTampilkanRuangan" data-id="<?php echo "$kelas"; ?>">
                    <i class="icofont-external"></i> Ruangan
                </button>
            </div>
        </div>
    </div>
<?php }} ?>