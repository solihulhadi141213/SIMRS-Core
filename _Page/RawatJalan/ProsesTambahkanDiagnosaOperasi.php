<?php
    $now=date('Y-m-d H:i:s');
    $strtotime=strtotime($now);
    if(!empty($_POST['kategori_diagnosa'])){
        $kategori_diagnosa=$_POST['kategori_diagnosa'];
    }else{
        $kategori_diagnosa="";
    }
    if(!empty($_POST['PilihDiagnosaOperasi'])){
        $PilihDiagnosaOperasi=$_POST['PilihDiagnosaOperasi'];
    }else{
        $PilihDiagnosaOperasi="";
    }
    $Explode = explode("|" , $PilihDiagnosaOperasi);
    $KodeDiagnosa=$Explode[0];
    $NamaDiagnosa=$Explode[1];
    echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisDiagnosaOperasi'.$strtotime.'">';
    echo '  <div class="ms-2 me-auto">';
    echo '      <input type="hidden" id="KategoriDiagnosaOperasi'.$strtotime.'" name="KategoriDiagnosaOperasi[]" value="'.$kategori_diagnosa.'">';
    echo '      <input type="hidden" id="KodeDiagnosaOperasi'.$strtotime.'" name="KodeDiagnosaOperasi[]" value="'.$KodeDiagnosa.'">';
    echo '      <input type="hidden" id="NamaDiagnosaOperasi'.$strtotime.'" name="NamaDiagnosaOperasi[]" value="'.$NamaDiagnosa.'">';
    echo '      <dt class="fw-bold">'.$kategori_diagnosa.'</dt>';
    echo '      '.$KodeDiagnosa.'';
    echo '      <small>';
    echo '          <ul>';
    echo '              <li>'.$NamaDiagnosa.'</li>';
    echo '          </ul>';
    echo '      </small>';
    echo '  </div>';
    echo '  <span class="icon-btn">';
    echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusDiagnosaOperasi" data-id="'.$strtotime.'">';
    echo '          <i class="ti ti-close"></i>';
    echo '      </button>';
    echo '  </span>';
    echo '</li>';
?>
