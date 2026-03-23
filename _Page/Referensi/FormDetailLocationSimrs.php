<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['id_referensi_location'])){
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
        $id_referensi_location=$_POST['id_referensi_location'];
        //Buka Detail Data
        $id_location=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'id_location');
        $nama=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'nama');
        $kode=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'kode');
        $deskripsi=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'deskripsi');
        $status=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'status');
        $mode=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'mode');
        $kontak=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'kontak');
        $fax=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'fax');
        $email=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'email');
        $url=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'url');
        $address_use=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'address_use');
        $address_line=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'address_line');
        $address_city=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'address_city');
        $address_postalCode=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'address_postalCode');
        $physicalType_code=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'physicalType_code');
        $physicalType_display=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'physicalType_display');
        $longitude=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'longitude');
        $latitude=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'latitude');
        $longitude=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'longitude');
        $altitude=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'altitude');
        $managingOrganization=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'managingOrganization');
?>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-4"><dt>ID Location</dt></div>
            <div class="col-md-8"><small><?php echo "$id_location"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Nama</dt></div>
            <div class="col-md-8"><small><?php echo "$nama"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Kode</dt></div>
            <div class="col-md-8"><small><?php echo "$kode"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Deskripsi</dt></div>
            <div class="col-md-8"><small><?php echo "$deskripsi"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Status</dt></div>
            <div class="col-md-8"><small><?php echo "$status"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Mode</dt></div>
            <div class="col-md-8"><small><?php echo "$mode"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Kontak</dt></div>
            <div class="col-md-8"><small><?php echo "$kontak"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Fax</dt></div>
            <div class="col-md-8"><small><?php echo "$fax"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Email</dt></div>
            <div class="col-md-8"><small><?php echo "$email"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>URL/Web</dt></div>
            <div class="col-md-8"><small><?php echo "$url"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Address</dt></div>
            <div class="col-md-8"><small><?php echo "Use: $address_use"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt></dt></div>
            <div class="col-md-8"><small><?php echo "Line: $address_line"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt></dt></div>
            <div class="col-md-8"><small><?php echo "City: $address_city"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt></dt></div>
            <div class="col-md-8"><small><?php echo "Postal Code: $address_postalCode"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Physical Type</dt></div>
            <div class="col-md-8"><small><?php echo "Code: $physicalType_code"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt></dt></div>
            <div class="col-md-8"><small><?php echo "Display: $physicalType_display"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Position</dt></div>
            <div class="col-md-8"><small><?php echo "Longitude: $longitude"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt></dt></div>
            <div class="col-md-8"><small><?php echo "Latitude: $latitude"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt></dt></div>
            <div class="col-md-8"><small><?php echo "Longitude: $longitude"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt></dt></div>
            <div class="col-md-8"><small><?php echo "Altitude: $altitude"; ?></small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><dt>Organization</dt></div>
            <div class="col-md-8"><small><?php echo "$managingOrganization"; ?></small></div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <a href="index.php?Page=Referensi&Sub=DetailLocation&id=<?php echo $id_referensi_location; ?>" class="btn btn-sm btn btn-success">
            <i class="ti ti-more"></i> Selengkapnya
        </a>
        <button type="button" class="btn btn-sm btn btn-light" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>