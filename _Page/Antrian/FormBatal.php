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
        $kodebooking=$_POST['KodeBooking'];
        $id_antrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'id_antrian');
?>
    <form action="javascript:void(0);" id="ProsesBatalkanAntrian">
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kodebookingantrian">Kode Booking</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="kodebookingantrian" name="kodebookingantrian" value="<?php echo $kodebooking; ?>">
                </div>
            </div>   
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_antrian">ID Antrian</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="id_antrian" name="id_antrian" value="<?php echo $id_antrian; ?>">
                </div>
            </div>   
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="keterangan_pembatalan">Keterangan/Alasan</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="keterangan_pembatalan" name="keterangan_pembatalan">
                </div>
            </div> 
            <div class="row mb-3">
                <div class="col-md-12" id="NotifikasiBatalAntrian">
                    <?php
                        if(!empty($id_antrian)){
                            echo '<small class="text-success">Sistem akan melakukan update status antrian pada database antrian berdasarkan ID: '.$id_antrian.'</small>';
                        }else{
                            echo '<small class="text-danger">Data tersebut tidak terdaftar pada database antrian. Sistem hanya akan melakukan pembatalan pada service BPJS</small>';
                        }
                    ?>
                </div>
            </div> 
        </div>
        <div class="modal-footer bg-danger">
            <div class="row">
                <div class="col col-md col-12 text-center">
                    <button type="submit" class="btn btn-sm btn-primary mr-2">
                        <i class="ti ti-check"></i> Ya, Batalkan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>