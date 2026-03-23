<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap Nomor Antrian
    if(empty($_POST['KodeBooking'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          Kode Booking Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-danger">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="fa fa-times"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        if(empty($_POST['GetNomorAntrian'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Nomor Urut Antrian Tidak Boleh Kosong!.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-danger">';
            echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '      <i class="fa fa-times"></i> Tutup';
            echo '  </button>';
            echo '</div>';
        }else{
            $GetNomorAntrian=$_POST['GetNomorAntrian'];
            $kodebooking=$_POST['KodeBooking'];
            $id_antrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'id_antrian');
            $Explode = explode("-" , $GetNomorAntrian);
            $no_antrian=$Explode[1];
?>
        <audio id="suarabel_poli" src="_Page/Antrian/rekaman/Airport_Bell.mp3"></audio>
        <audio id="suarabelnomorurut_poli" src="_Page/Antrian/rekaman/nomor-antrian.wav"  ></audio> 
        <audio id="SuaraNomorPoli" src="_Page/Antrian/rekaman/<?php echo $no_antrian;?>.wav"  ></audio> 
        <div class="modal-body">   
            <div class="row mb-3">
                <div class="col col-md-12 text-center">
                    <div class="alert alert-info" role="alert">
                        <h3><?php echo $GetNomorAntrian; ?> </h3>
                        <span class="text-dark">Kode Booking : <?php echo $kodebooking; ?></span><br>
                        Silahkan tekan tombol play untuk memanggil antrian!
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <button type="button" class="btn btn-sm btn-block btn-outline-primary" id="PlayPoli" value="<?php echo $no_antrian; ?>">
                        <i class="fa fa-play"></i> Panggil Antrian
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12" id="NotifikasiProsesUpdatePanggilAntrianPoli">
                    <span class="text-primary">
                        Pastikan pasien hadir ketika pemanggilan antrian di poliklinik.
                    </span>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-primary">
            <div class="row">
                <div class="col col-md col-12 text-center">
                    <button type="button" class="btn btn-sm btn-success mr-2" id="UpdatePanggilAntrianPoli">
                        <i class="ti ti-check"></i> Update Antrian Poli
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
<?php 
        }
    } 
?>