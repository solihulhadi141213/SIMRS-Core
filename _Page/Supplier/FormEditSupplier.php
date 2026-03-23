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
?>
                <input type="hidden" name="id_supplier" value="<?php echo $id_supplier; ?>">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nama"><dt>Nama Petugas</dt></label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama; ?>" required>
                        <small>Diisi dengan nama petugas/delegasi penanggung jawab</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="alamat"><dt>Alamat</dt></label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="alamat" id="alamat" value="<?php echo $alamat; ?>" class="form-control">
                        <small>Alamat perusahaan, cabang atau operasional</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kontak"><dt>Kontak</dt></label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="kontak" id="kontak" value="<?php echo $kontak; ?>" class="form-control" placeholder="62" required>
                        <small>Nomor kantor atau kontak pribadi penanggung jawab</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="email"><dt>Alamat Email</dt></label>
                    </div>
                    <div class="col-md-8">
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo "$email"; ?>" placeholder="email@domain.com">
                        <small>
                            * Sertakan Apabila Ada
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="company"><dt>Nama Perusahaan</dt></label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="company" id="company" class="form-control" value="<?php echo $company; ?>" required>
                        <small>Nama perusahan, badan hukum resmi yang sah</small>
                    </div>
                </div>
<?php
        }
    }
?>