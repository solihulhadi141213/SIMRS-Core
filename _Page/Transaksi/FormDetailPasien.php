<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Pasien Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        $IdPasien=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'id_pasien');
        if(empty($IdPasien)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Pasien Tidak Valid Karena Tidak Ditemukan Pada Database';
            echo '  </div>';
            echo '</div>';
        }else{
            //Buka data Pasien
            $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
            $DataPasien = mysqli_fetch_array($QryPasien);
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
        <div class="row"> 
            <div class="col-md-12 table table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><dt>NO.RM</dt></td>
                            <td><small><?php echo $id_pasien; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>NAMA</dt></td>
                            <td><small><?php echo $nama; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>IHS</dt></td>
                            <td><small><?php echo $id_ihs; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>Daftar</dt></td>
                            <td><small><?php echo $tanggal_daftar; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>NIK</dt></td>
                            <td><small><?php echo $nik; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>NO.BPJS</dt></td>
                            <td><small><?php echo $no_bpjs; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>GENDER</dt></td>
                            <td><small><?php echo $labelGender; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>TEMPAT LAHIR</dt></td>
                            <td><small><?php echo $tempat_lahir; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>TANGGAL LAHIR</dt></td>
                            <td><small><?php echo $tanggal_lahir; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>ALAMAT</dt></td>
                            <td><small><?php echo $alamat; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>PROVINSI</dt></td>
                            <td><small><?php echo $propinsi; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>KABUPATEN</dt></td>
                            <td><small><?php echo $kabupaten; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>KECAMATAN</dt></td>
                            <td><small><?php echo $kecamatan; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>DESA</dt></td>
                            <td><small><?php echo $desa; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>KONTAK</dt></td>
                            <td><small><?php echo $kontak; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>KONTAK DARURAT</dt></td>
                            <td><small><?php echo $kontak_darurat; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>PENANGGUNG JAWAB</dt></td>
                            <td><small><?php echo $penanggungjawab; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>GOLONGAN DARAH</dt></td>
                            <td><small><?php echo $golongan_darah; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>PERNIKAHAN</dt></td>
                            <td><small><?php echo $perkawinan; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>PEKERJAAN</dt></td>
                            <td><small><?php echo $pekerjaan; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>PEKERJAAN</dt></td>
                            <td><small><?php echo $pekerjaan; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>FOTO</dt></td>
                            <td><small><?php echo $LinkGambar; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>UPDATETIME</dt></td>
                            <td><small><?php echo $updatetime; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>PETUGAS</dt></td>
                            <td><small><?php echo $nama_petugas; ?></small></td>
                        </tr>
                        <tr>
                            <td><dt>STATUS</dt></td>
                            <td><small><?php echo $LabelData; ?></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <a href="index.php?Page=Pasien&Sub=DetailPasien&id=<?php echo $id_pasien; ?>" class="btn btn-sm btn-round btn-block btn-primary">
                        Selengkapnya <i class="ti ti-more-alt"></i>
                    </a>
                </div>
            </div>
        </div>
<?php }} ?>