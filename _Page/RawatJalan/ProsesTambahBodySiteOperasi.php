<?php
    $now=date('Y-m-d H:i:s');
    $strtotime=strtotime($now);
    if(!empty($_POST['body_site_operasi'])){
        $body_site_operasi=$_POST['body_site_operasi'];
    }else{
        $body_site_operasi="";
    }
    if(!empty($_POST['keterangan_body_site'])){
        $keterangan_body_site=$_POST['keterangan_body_site'];
    }else{
        $keterangan_body_site="";
    }
    echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisBodySite'.$strtotime.'">';
    echo '  <div class="ms-2 me-auto">';
    echo '      <input type="hidden" id="BodySiteOperasi'.$strtotime.'" name="BodySiteOperasi[]" value="'.$body_site_operasi.'">';
    echo '      <input type="hidden" id="KeteranganBodySiteOperasi'.$strtotime.'" name="KeteranganBodySiteOperasi[]" value="'.$keterangan_body_site.'">';
    echo '      <dt class="fw-bold">'.$body_site_operasi.'</dt>';
    echo '      <small>';
    echo '          <ul>';
    echo '              <li>'.$keterangan_body_site.'</li>';
    echo '          </ul>';
    echo '      </small>';
    echo '  </div>';
    echo '  <span class="icon-btn">';
    echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusBodySiteOperasi" data-id="'.$strtotime.'">';
    echo '          <i class="ti ti-close"></i>';
    echo '      </button>';
    echo '  </span>';
    echo '</li>';
?>
