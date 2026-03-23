<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    if(empty($_POST['Requester'])){
        echo '  <div class="row mb-3">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          Requester Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_ihs_practitioner=$_POST['Requester'];
        //Buka data practitioner
        $NamaPractitioner=getDataDetail($Conn,'referensi_practitioner','id_ihs_practitioner',$id_ihs_practitioner,'nama');
        if(empty($NamaPractitioner)){
            echo '  <div class="row mb-3">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Practitioner Tidak Valid';
            echo '      </div>';
            echo '  </div>';
        }else{
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4">';
            echo '      <label for="requester_referense">F.1.1.Reference</label>';
            echo '  </div>';
            echo '  <div class="col-md-8">';
            echo '      <input type="text" name="requester_referense" id="requester_referense" class="form-control" value="Practitioner/'.$id_ihs_practitioner.'">';
            echo '      <small>Requester Reference diisi dengan format : Practitioner/{id practitioner}</small>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4">';
            echo '      <label for="requester_display">F.1.2.Display</label>';
            echo '  </div>';
            echo '  <div class="col-md-8">';
            echo '      <input type="text" name="requester_display" id="requester_display" class="form-control" value="'.$NamaPractitioner.'">';
            echo '      <small>Nama lengkap practitioner sesuai IHS</small>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>