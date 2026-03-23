<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['id_referensi_organisasi'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger mb-3">';
        echo '          ID Organisasi Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-info">';
        echo '  <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_referensi_organisasi=$_POST['id_referensi_organisasi'];
        //Buka Detail Data
        $nama=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'nama');
        $identifier=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'identifier');
        $tipe=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'tipe');
        $email=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'email');
        $kontak=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'kontak');
        $part_of_ID=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'part_of_ID');
        $ID_Org=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'ID_Org');
        if(empty($part_of_ID)){
            $part_of_ID="Utama";
        }
?>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-6"><dt>Nama</dt></div>
            <div class="col-md-6"><small><?php echo "$nama"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><dt>Identifier</dt></div>
            <div class="col-md-6"><small><?php echo "$identifier"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><dt>Tipe</dt></div>
            <div class="col-md-6"><small><?php echo "$tipe"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><dt>Email</dt></div>
            <div class="col-md-6"><small><?php echo "$email"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><dt>Kontak</dt></div>
            <div class="col-md-6"><small><?php echo "$kontak"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><dt>ID ORG</dt></div>
            <div class="col-md-6"><small><?php echo "$ID_Org"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><dt>Part Of</dt></div>
            <div class="col-md-6"><small><?php echo "$part_of_ID"; ?></small></div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <a href="index.php?Page=Referensi&Sub=DetailOrganizationSimrs&id=<?php echo $id_referensi_organisasi; ?>" class="btn btn-sm btn btn-success">
            <i class="ti ti-more"></i> Selengkapnya
        </a>
        <button type="button" class="btn btn-sm btn btn-light" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>