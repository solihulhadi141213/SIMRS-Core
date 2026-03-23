<?php
    $now=date('Y-m-d H:i:s');
    $strtotime=strtotime($now);
    if(!empty($_POST['kategori_nakes_operasi'])){
        $kategori_nakes_operasi=$_POST['kategori_nakes_operasi'];
    }else{
        $kategori_nakes_operasi="";
    }
    if(!empty($_POST['nama_nakes_operasi'])){
        $nama_nakes_operasi=$_POST['nama_nakes_operasi'];
    }else{
        $nama_nakes_operasi="";
    }
    if(!empty($_POST['sip_nakes_operasi'])){
        $sip_nakes_operasi=$_POST['sip_nakes_operasi'];
    }else{
        $sip_nakes_operasi="";
    }
    if(!empty($_POST['kontak_nakes_operasi'])){
        $kontak_nakes_operasi=$_POST['kontak_nakes_operasi'];
    }else{
        $kontak_nakes_operasi="";
    }
    if(!empty($_POST['kategori_identitas_nakes_operasi'])){
        $kategori_identitas_nakes_operasi=$_POST['kategori_identitas_nakes_operasi'];
    }else{
        $kategori_identitas_nakes_operasi="";
    }
    if(!empty($_POST['nomor_identitas_nakes_operasi'])){
        $nomor_identitas_nakes_operasi=$_POST['nomor_identitas_nakes_operasi'];
    }else{
        $nomor_identitas_nakes_operasi="";
    }
    echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="BarisNakesOperasi'.$strtotime.'">';
    echo '  <div class="ms-2 me-auto">';
    echo '      <input type="hidden" id="KategoriNakesOperasi'.$strtotime.'" name="KategoriNakesOperasi[]" value="'.$kategori_nakes_operasi.'">';
    echo '      <input type="hidden" id="NamaNakesOperasi'.$strtotime.'" name="NamaNakesOperasi[]" value="'.$nama_nakes_operasi.'">';
    echo '      <input type="hidden" id="SipNakesOperasi'.$strtotime.'" name="SipNakesOperasi[]" value="'.$sip_nakes_operasi.'">';
    echo '      <input type="hidden" id="KontakNakesOperasi'.$strtotime.'" name="KontakNakesOperasi[]" value="'.$kontak_nakes_operasi.'">';
    echo '      <input type="hidden" id="KategoriIdentitasNakesOperasi'.$strtotime.'" name="KategoriIdentitasNakesOperasi[]" value="'.$kategori_identitas_nakes_operasi.'">';
    echo '      <input type="hidden" id="NomorIdentitasNakesOperasi'.$strtotime.'" name="NomorIdentitasNakesOperasi[]" value="'.$nomor_identitas_nakes_operasi.'">';
    echo '      <dt class="fw-bold">'.$kategori_nakes_operasi.'</dt>';
    echo '      <small>';
    echo '          <ul>';
    echo '              <li>'.$nama_nakes_operasi.'</li>';
    echo '              <li>SIP: <code class="text-secondary">'.$sip_nakes_operasi.'</code></li>';
    echo '              <li>Kontak: <code class="text-secondary">'.$kontak_nakes_operasi.'</code></li>';
    echo '              <li>Identitas: <code class="text-secondary">('.$kategori_identitas_nakes_operasi.') '.$nomor_identitas_nakes_operasi.'</code></li>';
    echo '          </ul>';
    echo '      </small>';
    echo '  </div>';
    echo '  <span class="icon-btn">';
    echo '      <button type="button" class="btn btn-icon btn-outline-danger" data-toggle="modal" data-target="#ModalHapusNakesOperasi" data-id="'.$strtotime.'">';
    echo '          <i class="ti ti-close"></i>';
    echo '      </button>';
    echo '  </span>';
    echo '</li>';
?>
