<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row mb-3">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Akses Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        $id_pasien= $DataPasien['id_pasien'];
        $noRm=sprintf("%07d", $id_pasien);
        $tanggal_daftar= $DataPasien['tanggal_daftar'];
        if(!empty($DataPasien['id_ihs'])){
            $id_ihs= $DataPasien['id_ihs'];
        }else{
            $id_ihs='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['nik'])){
            $nik= $DataPasien['nik'];
        }else{
            $nik='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['no_bpjs'])){
            $no_bpjs= $DataPasien['no_bpjs'];
        }else{
            $no_bpjs='<span class="text-danger">Tidak Ada</span>';
        }
        $nama= $DataPasien['nama'];
        if(!empty($DataPasien['gender'])){
            $gender= $DataPasien['gender'];
            //Inisiasi gender 
            if($gender=="Laki-laki"){
                $labelGender='<label class="label label-info">Male</label>';
            }else{
                if($gender=="Perempuan"){
                    $labelGender='<label class="label label-primary">Female</label>';
                }else{
                    $labelGender='<label class="label label-danger">None</label>';
                }
            }
        }else{
            $gender="";
            $labelGender='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['tempat_lahir'])){
            $tempat_lahir= $DataPasien['tempat_lahir'];
        }else{
            $tempat_lahir='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['tanggal_lahir'])){
            $tanggal_lahir= $DataPasien['tanggal_lahir'];
            $strtotime= strtotime($tanggal_lahir);
            $tanggal_lahir=date('d/m/Y', $strtotime);
        }else{
            $tanggal_lahir='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['propinsi'])){
            $propinsi= $DataPasien['propinsi'];
        }else{
            $propinsi='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['kabupaten'])){
            $kabupaten= $DataPasien['kabupaten'];
        }else{
            $kabupaten='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['kecamatan'])){
            $kecamatan= $DataPasien['kecamatan'];
        }else{
            $kecamatan='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['desa'])){
            $desa= $DataPasien['desa'];
        }else{
            $desa='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['alamat'])){
            $alamat= $DataPasien['alamat'];
        }else{
            $alamat='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['kontak'])){
            $kontak= $DataPasien['kontak'];
        }else{
            $kontak='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['kontak_darurat'])){
            $kontak_darurat= $DataPasien['kontak_darurat'];
        }else{
            $kontak_darurat='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['penanggungjawab'])){
            $penanggungjawab= $DataPasien['penanggungjawab'];
        }else{
            $penanggungjawab='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['golongan_darah'])){
            $golongan_darah= $DataPasien['golongan_darah'];
        }else{
            $golongan_darah='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['perkawinan'])){
            $perkawinan= $DataPasien['perkawinan'];
        }else{
            $perkawinan='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['pekerjaan'])){
            $pekerjaan= $DataPasien['pekerjaan'];
        }else{
            $pekerjaan='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['gambar'])){
            $gambar= $DataPasien['gambar'];
            $LinkGambar='<a href="../../assets/images/pasien/'.$gambar.'" target="_blank">'.$gambar.' <i class="ti ti-new-window"></i></a>';
        }else{
            $gambar="";
            $LinkGambar='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['updatetime'])){
            $updatetime= $DataPasien['updatetime'];
            $strtotime=strtotime($updatetime);
            $updatetime=date('d/m/Y H:i',$strtotime);
        }else{
            $updatetime='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['status'])){
            $status= $DataPasien['status'];
            if($status=="Aktiv"){
                $LabelData='<label class="label label-success"><i class="ti ti-check-box"></i> Aktiv</label>';
            }else{
                if($status=="Meninggal"){
                    $LabelData='<label class="label label-danger"><i class="icofont-close-squared"></i> Meninggal</label>';
                }else{
                    $LabelData='<label class="label label-info">'.$status.'</label>';
                }
            }
        }else{
            $status='Tidak Diketahui';
            $LabelData='<label class="label label-danger">'.$status.'</label>';
        }
        if(!empty($DataPasien['nama_petugas'])){
            $nama_petugas= $DataPasien['nama_petugas'];
        }else{
            $nama_petugas='<span class="text-danger">Tidak Diketahui</span>';
        }
?>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>NO.RM</dt></div>
        <div class="col-md-6"><small><?php echo $id_pasien; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Nama</dt></div>
        <div class="col-md-6"><small><?php echo $nama; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>ID IHS</dt></div>
        <div class="col-md-6"><small><?php echo $id_ihs; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Tgl.Daftar</dt></div>
        <div class="col-md-6"><small><?php echo $tanggal_daftar; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>NIK</dt></div>
        <div class="col-md-6"><small><?php echo $nik; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>NO.BPJS</dt></div>
        <div class="col-md-6"><small><?php echo $no_bpjs; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Gender</dt></div>
        <div class="col-md-6"><small><?php echo $labelGender; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Tempat Lahir</dt></div>
        <div class="col-md-6"><small><?php echo $tempat_lahir; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Tanggal Lahir</dt></div>
        <div class="col-md-6"><small><?php echo $tanggal_lahir; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Alamat</dt></div>
        <div class="col-md-6"><small><?php echo $alamat; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Provinsi</dt></div>
        <div class="col-md-6"><small><?php echo $propinsi; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Kabupaten</dt></div>
        <div class="col-md-6"><small><?php echo $kabupaten; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Kecamatan</dt></div>
        <div class="col-md-6"><small><?php echo $kecamatan; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Desa</dt></div>
        <div class="col-md-6"><small><?php echo $desa; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Kontak</dt></div>
        <div class="col-md-6"><small><?php echo $kontak; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Kontak Darurat</dt></div>
        <div class="col-md-6"><small><?php echo $kontak_darurat; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Penanggung Jawab</dt></div>
        <div class="col-md-6"><small><?php echo $penanggungjawab; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Golongan Darah</dt></div>
        <div class="col-md-6"><small><?php echo $golongan_darah; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Status Pernikahan</dt></div>
        <div class="col-md-6"><small><?php echo $perkawinan; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Pekerjaan/Profesi</dt></div>
        <div class="col-md-6"><small><?php echo $pekerjaan; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Foto Pasien</dt></div>
        <div class="col-md-6"><small><?php echo $LinkGambar; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Update Time</dt></div>
        <div class="col-md-6"><small><?php echo $updatetime; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Petugas</dt></div>
        <div class="col-md-6"><small><?php echo $nama_petugas; ?></small></div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6"><dt>Status</dt></div>
        <div class="col-md-6"><small><?php echo $LabelData; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="index.php?Page=Pasien&Sub=DetailPasien&id=<?php echo $id_pasien; ?>" class="btn btn-block btn-sm btn-outline-primary">
                Selengkapnya <i class="ti ti-more-alt"></i>
            </a>
        </div>
    </div>
<?php } ?>