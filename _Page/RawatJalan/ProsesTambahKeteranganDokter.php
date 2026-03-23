<?php
    $now=date('Y-m-d H:i:s');
    $strtotime=strtotime($now);
    if(!empty($_POST['NamaKeteranganDokterOperasi'])){
        $NamaKeteranganDokterOperasi=$_POST['NamaKeteranganDokterOperasi'];
    }else{
        $NamaKeteranganDokterOperasi="";
    }
    if(!empty($_POST['KeteranganDokterOperasi'])){
        $KeteranganDokterOperasi=$_POST['KeteranganDokterOperasi'];
    }else{
        $KeteranganDokterOperasi="";
    }
    echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisTindakanOperasi'.$strtotime.'">';
    echo '  <div class="ms-2 me-auto">';
    echo '      <input type="hidden" id="GetNamaKeteranganDokterOperasi'.$strtotime.'" name="GetNamaKeteranganDokterOperasi[]" value="'.$NamaKeteranganDokterOperasi.'">';
    echo '      <input type="hidden" id="GetKeteranganDokterOperasi'.$strtotime.'" name="GetKeteranganDokterOperasi[]" value="'.$KeteranganDokterOperasi.'">';
    echo '      <dt class="fw-bold">'.$NamaKeteranganDokterOperasi.'</dt>';
    echo '      <small class="text-secondary">'.$KeteranganDokterOperasi.'</small>';
    echo '  </div>';
    echo '  <span class="icon-btn">';
    echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusKeteranganDokterOperasi" data-id="'.$strtotime.'">';
    echo '          <i class="ti ti-close"></i>';
    echo '      </button>';
    echo '  </span>';
    echo '</li>';
?>
