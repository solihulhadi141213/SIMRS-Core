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
        if(empty($_POST['PilihRuangan'])){
            $ruangan="";
            echo '<div class="col-xl-4 col-md-4">';
            echo '  <div class="card table-card">';
            echo '      <div class="card-body">';
            echo '          Pilih Ruangan Terlebih Dulu';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kelas=$_POST['PilihKelas'];
            $ruangan=$_POST['PilihRuangan'];
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND kelas='$kelas' AND ruangan='$ruangan'"));
            if(empty($jml_data)){
                echo '<div class="col-xl-4 col-md-4">';
                echo '  <div class="card table-card bg-danger">';
                echo '      <div class="card-body">';
                echo '          Belum Ada Data Tempat tidur';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND kelas='$kelas' AND ruangan='$ruangan' ORDER BY id_ruang_rawat DESC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_ruang_rawat = $data['id_ruang_rawat'];
                    $kelas = $data['kelas'];
                    $kodekelas = $data['kodekelas'];
                    $ruangan = $data['ruangan'];
                    $bed = $data['bed'];
                    $pria = $data['pria'];
                    $wanita = $data['wanita'];
                    $bebas = $data['bebas'];
                    $status = $data['status'];
                    $updatetime = $data['updatetime'];
                    //Inisiasi Gender
                    if($pria=="1"){
                        $Gender="Kusus Pria";
                    }else{
                        if($wanita=="1"){
                            $Gender="Kusus Wanita";
                        }else{
                            if($bebas=="1"){
                                $Gender="Bebas";
                            }else{
                                $Gender="";
                            }
                        }
                    }
                    $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE kelas='$kelas' AND ruangan='$ruangan' AND id_kasur='$id_ruang_rawat' AND status='Terdaftar'"));
                    if(!empty($JumlahPasien)){
                        $Terisi="Terisi";
                    }else{
                        $Terisi="Kosong";
                    }
?>
    <div class="col-xl-4 col-md-4">
        <div class="card table-card">
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-8">
                        <dt class="text-dark">
                            <?php echo "$bed"; ?>
                        </dt>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <small>Gender : <?php echo "$Gender"; ?></small><br>
                                <a href="javascript:void(0);" class="text text-primary" data-toggle="modal" data-target="#ModalPasienByBed" data-id="<?php echo "$kelas,$ruangan,$id_ruang_rawat"; ?>">
                                    <small>Pasien : <?php echo "$Terisi ($JumlahPasien Orang)"; ?></small>
                                </a><br>
                                <small>Updatetime : <?php echo "$updatetime"; ?></small><br>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4 text-center text-facebook">
                        <i class="icofont-stretcher icofont-3x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info">
                <button type="button" class="btn btn-sm btn-outline-dark btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalEditBed" data-id="<?php echo "$id_ruang_rawat"; ?>">
                    <i class="ti ti-pencil-alt"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-dark btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalHapusBed" data-id="<?php echo "$id_ruang_rawat"; ?>">
                    <i class="ti ti-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
<?php }}}} ?>