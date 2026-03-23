<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap no_bpjs
    if(empty($_POST['no_bpjs'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data No BPJS Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $no_bpjs=$_POST['no_bpjs'];
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 pre-scrollable"> 
            <div class="col-md-12">
                <div class="table table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="2"><dt>Data Pengajuan Approval</dt></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                $query = mysqli_query($Conn, "SELECT*FROM approval WHERE noKartu='$no_bpjs' ORDER BY id_approval DESC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_approval = $data['id_approval'];
                                    $id_akses = $data['id_akses'];
                                    $noKartu = $data['noKartu'];
                                    $tglSep = $data['tglSep'];
                                    $keterangan = $data['keterangan'];
                                    $status = $data['status'];
                                    echo '<tr>';
                                    echo '  <td class="text-left"><dt>'.$tglSep.'</dt><small>'.$keterangan.'</small></td>';
                                    echo '  <td class="text-center">';
                                    if($status=="Acc"){
                                        echo '      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalHapusApproval" data-id="'.$id_approval.'">';
                                        echo '          <i class="ti ti-close"></i>';
                                        echo '      </button>';
                                    }else{
                                        echo '      <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalApprove" data-id="'.$id_approval.'">';
                                        echo '          <i class="ti ti-check-box"></i>';
                                        echo '      </button>';
                                    }
                                    echo '  </td>';
                                    echo '</tr>';
                                $no++;}
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12 mb-3">
                <button type="button" class="btn btn-md btn-primary mt-2 ml-2" data-toggle="modal" data-target="#ModalPengajuanApproval" data-id="<?php echo "$no_bpjs";?>">
                    <i class="icofont-wall-clock"></i> Pengajuan Approval
                </button>
                <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>