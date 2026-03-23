<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_dokter
    if(empty($_POST['id_dokter'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Dokter Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        $kode=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kode');
        if(empty($kode)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Dokter Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            //Buka data Pasien
            $id_ihs_practitioner=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'id_ihs_practitioner');
            $nama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'nama');
            $kategori=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kategori');
            $kategori_identitas=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kategori_identitas');
            $no_identitas=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'no_identitas');
            $alamat=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'alamat');
            $kontak=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kontak');
            $email=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'email');
            $SIP=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'SIP');
            $status=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'status');
            $foto=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'foto');
            //ID IHS
            if(empty($id_ihs_practitioner)){
                $id_ihs_practitioner='<span class="text-danger">None</span>';
            }else{
                $id_ihs_practitioner='<span class="text-dark">'.$id_ihs_practitioner.'</span>';
            }
            //kategori_identitas
            if(empty($kategori_identitas)){
                $kategori_identitas='<span class="text-danger">None</span>';
            }else{
                $kategori_identitas='<span class="text-dark">'.$kategori_identitas.'</span>';
            }
            //no_identitas
            if(empty($no_identitas)){
                $no_identitas='<span class="text-danger">None</span>';
            }else{
                $no_identitas='<span class="text-dark">'.$no_identitas.'</span>';
            }
            //alamat
            if(empty($alamat)){
                $alamat='<span class="text-danger">None</span>';
            }else{
                $alamat='<span class="text-dark">'.$alamat.'</span>';
            }
            //kontak
            if(empty($kontak)){
                $kontak='<span class="text-danger">None</span>';
            }else{
                $kontak='<span class="text-dark">'.$kontak.'</span>';
            }
            //email
            if(empty($email)){
                $email='<span class="text-danger">None</span>';
            }else{
                $email='<span class="text-dark">'.$email.'</span>';
            }
            //SIP
            if(empty($SIP)){
                $SIP='<span class="text-danger">None</span>';
            }else{
                $SIP='<span class="text-dark">'.$SIP.'</span>';
            }
            //Foto
            if(empty($foto)){
                $LinkGambar="avatar-blank.jpg";
            }else{
                $LinkGambar="Dokter/$foto";
            }
?>
    <?php
        if(!empty($foto)){
            echo '<div class="row mb-3"> ';
            echo '  <div class="col col-md-12 text-center">';
            echo '      <img src="assets/images/Dokter/'.$foto.'" alt="" width="200em" height="200em" class="img img-circle">';
            echo '  </div>';
            echo '</div>';
            
        }
    ?>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>Kode Dokter</dt></div>
        <div class="col col-md-7"><?php echo $kode; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>ID IHS</dt></div>
        <div class="col col-md-7"><?php echo $id_ihs_practitioner; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>Nama</dt></div>
        <div class="col col-md-7"><?php echo $nama; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>Kategori</dt></div>
        <div class="col col-md-7"><?php echo $kategori; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>Kategori Identitas</dt></div>
        <div class="col col-md-7"><?php echo $kategori_identitas; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>Nomor Identitas</dt></div>
        <div class="col col-md-7"><?php echo $no_identitas; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>Alamat</dt></div>
        <div class="col col-md-7"><?php echo "$alamat"; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>No.Kontak</dt></div>
        <div class="col col-md-7"><?php echo "$kontak"; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>Email</dt></div>
        <div class="col col-md-7"><?php echo "$email"; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>SIP</dt></div>
        <div class="col col-md-7"><?php echo "$SIP"; ?></div>
    </div>
    <div class="row mt-2"> 
        <div class="col col-md-5"><dt>Status</dt></div>
        <div class="col col-md-7"><?php echo "$status"; ?></div>
    </div>
<?php }} ?>