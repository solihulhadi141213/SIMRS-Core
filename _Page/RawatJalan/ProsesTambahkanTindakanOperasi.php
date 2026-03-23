<?php
    $now=date('Y-m-d H:i:s');
    $strtotime=strtotime($now);
    if(!empty($_POST['PilihTindakanOperasi'])){
        $PilihTindakanOperasi=$_POST['PilihTindakanOperasi'];
    }else{
        $PilihTindakanOperasi="";
    }
    $Explode = explode("|" , $PilihTindakanOperasi);
    $KodeTindakan=$Explode[0];
    $NamaTindakan=$Explode[1];
    echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisTindakanOperasi'.$strtotime.'">';
    echo '  <div class="ms-2 me-auto">';
    echo '      <input type="hidden" id="KodeTindakan'.$strtotime.'" name="KodeTindakan[]" value="'.$KodeTindakan.'">';
    echo '      <input type="hidden" id="NamaTindakan'.$strtotime.'" name="NamaTindakan[]" value="'.$NamaTindakan.'">';
    echo '      <dt class="fw-bold">'.$KodeTindakan.'</dt>';
    echo '      '.$NamaTindakan.'';
    echo '  </div>';
    echo '  <span class="icon-btn">';
    echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusTindakanOperasi" data-id="'.$strtotime.'">';
    echo '          <i class="ti ti-close"></i>';
    echo '      </button>';
    echo '  </span>';
    echo '</li>';
?>
