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
        echo '<div class="modal-footer bg-primary">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="fa fa-times"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $kodebooking=$_POST['KodeBooking'];
        $id_antrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'id_antrian');
        $NoAntrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'no_antrian');
?>
    <div class="modal-body">   
        <div class="row">
            <div class="col col-md-12 text-center">
                <div class="alert alert-info" role="alert">
                    <h3>No.Antrian : <?php echo $NoAntrian; ?> </h3>
                    <h3>Kode Booking : <?php echo $kodebooking; ?> </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 mb-3">
                <dt>Keterangan: </dt>
                <i>Checkin</i> pada antrian ini artinya bahwa pasien sudah melakukan konfirmasi kehadiran di lokasi. 
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12" id="NotifikasiCheckinAntrian">
                <span class="text-primary">Apakah anda yakin akan melakukan update CHECKIN untuk antrian ini?</span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col col-md col-12 text-center">
                <button type="button" class="btn btn-sm btn-success mr-2" id="KonfirmasiCheckin">
                    <i class="ti ti-check"></i> Ya, Update Checkin
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>