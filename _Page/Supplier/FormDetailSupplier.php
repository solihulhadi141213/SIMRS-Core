<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_supplier
    if(empty($_POST['id_supplier'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Supplier Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_supplier=$_POST['id_supplier'];
        $IdSupplier=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'id_supplier');
        if(empty($IdSupplier)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Supplier Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            //Buka data Pasien
            $nama=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'nama');
            $alamat=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'alamat');
            $kontak=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'kontak');
            $email=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'email');
            $company=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'company');
            //email
            if(empty($email)){
                $email='<span class="text-danger">Tidak Ada</span>';
            }else{
                $email='<span class="text-dark">'.$email.'</span>';
            }
?>
    <div class="row mb-2"> 
        <div class="col col-md-5"><dt>Nama Petugas</dt></div>
        <div class="col col-md-7"><?php echo $nama; ?></div>
    </div>
    <div class="row mb-2"> 
        <div class="col col-md-5"><dt>Alamat</dt></div>
        <div class="col col-md-7"><?php echo $alamat; ?></div>
    </div>
    <div class="row mb-2"> 
        <div class="col col-md-5"><dt>Kontak</dt></div>
        <div class="col col-md-7"><?php echo $kontak; ?></div>
    </div>
    <div class="row mb-2"> 
        <div class="col col-md-5"><dt>Email</dt></div>
        <div class="col col-md-7"><?php echo $email; ?></div>
    </div>
    <div class="row mb-2"> 
        <div class="col col-md-5"><dt>Perusahaan</dt></div>
        <div class="col col-md-7"><?php echo $company; ?></div>
    </div>
<?php }} ?>