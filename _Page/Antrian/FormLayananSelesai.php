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
            echo '          Nomor Antrian Tidak Boleh Kosong!.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-danger">';
            echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '      <i class="fa fa-times"></i> Tutup';
            echo '  </button>';
            echo '</div>';
        }else{
            $kodebooking=$_POST['KodeBooking'];
            $GetNomorAntrian=$_POST['GetNomorAntrian'];
            //Buka data Antrian
            $id_antrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'id_antrian');
            $id_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_kunjungan');
?>
    <div class="modal-body">   
        <div class="row mb-3">
            <div class="col col-md-12 text-center">
                <div class="alert alert-info" role="alert">
                    <h3><?php echo "$GetNomorAntrian"; ?> </h3>
                    <span class="text-dark">Kode Booking : <?php echo $kodebooking; ?></span>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">
                <dt>Keterangan</dt>
                Dengan melakukan update data ini maka semua layanan telah selesai.
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12" id="NotifikasiLayananSelesai">
                <span class="text-primary">
                    Apakah anda yakin melakukan update Task ID ini?
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col col-md col-12 text-center">
                <button type="button" class="btn btn-sm btn-success mr-2" id="KonfirmasiLayananSelesai">
                    <i class="ti ti-check"></i> Ya, Update
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php }} ?>