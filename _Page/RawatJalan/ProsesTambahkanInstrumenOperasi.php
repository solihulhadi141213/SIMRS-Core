<?php
    $now=date('Y-m-d H:i:s');
    $strtotime=strtotime($now);
    if(!empty($_POST['InstrumenOperasi'])){
        $InstrumenOperasi=$_POST['InstrumenOperasi'];
    }else{
        $InstrumenOperasi="";
    }
    echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisInstrumenOperasi'.$strtotime.'">';
    echo '  <div class="ms-2 me-auto">';
    echo '      <input type="hidden" id="GetInstrumenOperasi'.$strtotime.'" name="GetInstrumenOperasi[]" value="'.$InstrumenOperasi.'">';
    echo '      '.$InstrumenOperasi.'';
    echo '  </div>';
    echo '  <span class="icon-btn">';
    echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusInstrumenOperasi" data-id="'.$strtotime.'">';
    echo '          <i class="ti ti-close"></i>';
    echo '      </button>';
    echo '  </span>';
    echo '</li>';
?>
