<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan_composition'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          ID Composition Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-primary">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan_composition=$_POST['id_kunjungan_composition'];
        $id_pasien=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'id_pasien');
        $id_kunjungan=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'id_kunjungan');
        $id_composition=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'id_composition');
        $id_ihs_pasien=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'id_ihs_pasien');
        $status=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'status');
        $type_code=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'type_code');
        $type_display=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'type_display');
        $category_code=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'category_code');
        $category_display=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'category_display');
        $tanggal=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'tanggal');
        $id_ihs_practitioner=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'id_ihs_practitioner');
        $title=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'title');
        $ID_Org=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'ID_Org');
        $section_code=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'section_code');
        $section_display=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'section_display');
        $section_status=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'section_status');
        $section_div=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan_composition',$id_kunjungan_composition,'section_div');
?>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>No.RM</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$id_pasien"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>ID.Reg</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$id_kunjungan"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>ID.Composition</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$id_composition"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>ID.IHS Pasien</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$id_ihs_pasien"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>Status</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$status"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>Type</dt>
        </div>
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <small>Code</small>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$type_code"; ?></small>
        </div>
        <div class="col-md-4">
            <small>Display</small>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$type_display"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>Category</dt>
        </div>
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <small>Code</small>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$category_code"; ?></small>
        </div>
        <div class="col-md-4">
            <small>Display</small>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$category_display"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>Tanggal</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$tanggal"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>ID.practitioner</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$id_ihs_practitioner"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>Title</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$title"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>ID.Organization</dt>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$ID_Org"; ?></small>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-4">
            <dt>Section</dt>
        </div>
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <small>Code</small>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$section_code"; ?></small>
        </div>
        <div class="col-md-4">
            <small>Display</small>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$section_display"; ?></small>
        </div>
        <div class="col-md-4">
            <small>Status</small>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$section_status"; ?></small>
        </div>
        <div class="col-md-4">
            <small>DIV</small>
        </div>
        <div class="col-md-8">
            <small class="text-mutted"><?php echo "$section_div"; ?></small>
        </div>
    </div>
<?php } ?>