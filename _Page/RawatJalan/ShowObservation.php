<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap id_kunjungan_observation
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span></div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_kunjungan_observation=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan',$id_kunjungan,'id_kunjungan_observation');
        if(empty($id_kunjungan_observation)){
            echo '<div class="row mb-3 mt-3">';
            echo '  <div class="col-md-12">';
            echo '      <button type="button" class="btn btn-sm btn-block btn-outline-dark" data-toggle="modal" data-target="#ModalTambahObservation" data-id="'.$id_kunjungan.'">';
            echo '          <i class="ti ti-plus"></i> Tambah Observation';
            echo '      </button>';
            echo '  </div>';
            echo '</div>';
        }else{
            echo '<div class="row mb-3 mt-3">';
            echo '  <div class="col-md-12">';
            echo '      <button type="button" class="btn btn-sm btn-block btn-outline-dark" data-toggle="modal" data-target="#ModalTambahObservation" data-id="'.$id_kunjungan.'">';
            echo '          <i class="ti ti-plus"></i> Tambah Observation';
            echo '      </button>';
            echo '  </div>';
            echo '</div>';
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM kunjungan_observation WHERE id_kunjungan='$id_kunjungan' ORDER BY id_kunjungan_observation DESC");
            while ($data = mysqli_fetch_array($query)) {
                $id_kunjungan_observation= $data['id_kunjungan_observation'];
                $observation_display= $data['observation_display'];
                if(empty($data['id_observation'])){
                    $IhsObservation='<span class="text-danger">Tidak Ada</span>';
                }else{
                    $IhsObservation='<a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalDetailObservation" data-id="'.$data['id_observation'].'">'.$data['id_observation'].' <i class="ti ti-new-window"></i></a>';
                }
                $observation_display= $data['observation_display'];
                $status= $data['status'];
                $observation_code= $data['observation_code'];
                $tipe_value= $data['tipe_value'];
                $raw_value= $data['raw_value'];
                $decodedData = json_decode($raw_value, true);
                if($tipe_value=="valueQuantity"){
                    $value = $decodedData['value'];
                    $unit = $decodedData['unit'];
                    $system = $decodedData['system'];
                    $code = $decodedData['code'];
                }else{
                    $codingArray = $decodedData['coding'];
                    $system = $codingArray[0]['system'];
                    $code = $codingArray[0]['code'];
                    $display = $codingArray[0]['display'];

                }
                echo '<div class="row mt-3">';
                echo '  <div class="col-md-12">';
                echo '      <dt class="row">';
                echo '          <div class="col-md-12">';
                echo '              <dt>';
                echo '                  '.$no.' '.$observation_display.' ';
                echo '              </dt>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row">';
                echo '          <div class="col-md-4">IHS Observation</div>';
                echo '          <div class="col-md-8">'.$IhsObservation.'</div>';
                echo '      </div>';
                echo '      <div class="row">';
                echo '          <div class="col-md-4">Status</div>';
                echo '          <div class="col-md-8">'.$status.'</div>';
                echo '      </div>';
                echo '      <div class="row">';
                echo '          <div class="col-md-4">Observation Code</div>';
                echo '          <div class="col-md-8">'.$observation_code.'</div>';
                echo '      </div>';
                echo '      <div class="row">';
                echo '          <div class="col-md-4">Value Type</div>';
                echo '          <div class="col-md-8">'.$tipe_value.'</div>';
                echo '      </div>';
                if($tipe_value=="valueQuantity"){
                    echo '<div class="row">';
                    echo '  <div class="col-md-4">Value</div>';
                    echo '  <div class="col-md-8">'.$value.'</div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '  <div class="col-md-4">Unit</div>';
                    echo '  <div class="col-md-8">'.$unit.'</div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '  <div class="col-md-4">Code</div>';
                    echo '  <div class="col-md-8">'.$code.'</div>';
                    echo '</div>';
                }else{
                    echo '<div class="row">';
                    echo '  <div class="col-md-4">Value Code</div>';
                    echo '  <div class="col-md-8">'.$code.'</div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '  <div class="col-md-4">Value Display</div>';
                    echo '  <div class="col-md-8">'.$display.'</div>';
                    echo '</div>';
                }
                echo '      <div class="row">';
                echo '          <div class="col-md-4">Action</div>';
                echo '          <div class="col-md-8"><a href="javascript:void(0);" class="text-success" title="Edit Observation" data-toggle="modal" data-target="#ModalEditObservation" data-id="'.$data['id_kunjungan_observation'].'"><i class="ti ti-pencil-alt"></i> Edit Observation</a></div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>