<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/PasienFunction.php";
    if(empty($_POST['nik'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger" role="alert">NIK Pasien Tidak Boleh Kosong!</div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $nik=$_POST['nik'];
        $DataPasien=getDataPasien('nik',$nik);
        if(empty($DataPasien['id_pasien'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger" role="alert">NIK Pasien Tidak Valid!</div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pasien= $DataPasien['id_pasien'];
            $tanggal_daftar= $DataPasien['tanggal_daftar'];
            $nik= $DataPasien['nik'];
            $no_bpjs= $DataPasien['no_bpjs'];
            $nama= $DataPasien['nama'];
            $gender= $DataPasien['gender'];
            $tempat_lahir= $DataPasien['tempat_lahir'];
            $tanggal_lahir= $DataPasien['tanggal_lahir'];
            $propinsi= $DataPasien['propinsi'];
            $kabupaten= $DataPasien['kabupaten'];
            $kecamatan= $DataPasien['kecamatan'];
            $desa= $DataPasien['desa'];
            $alamat= $DataPasien['alamat'];
            $kontak= $DataPasien['kontak'];
            $kontak_darurat= $DataPasien['kontak_darurat'];
            $penanggungjawab= $DataPasien['penanggungjawab'];
            $golongan_darah= $DataPasien['golongan_darah'];
            $perkawinan= $DataPasien['perkawinan'];
            $pekerjaan= $DataPasien['pekerjaan'];
            $status= $DataPasien['status'];
            $gambar= $DataPasien['gambar'];
            $updatetime= $DataPasien['updatetime'];
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
            if(empty($gambar)){
                $LinkGambar="avatar-blank.jpg";
            }else{
                $LinkGambar="pasien/$gambar";
            }
            //Inisiasi Status
            //Status ada yang aktiv dan meninggal

            if($status=="Aktiv"){
                $LabelData='<label class="label label-success"><i class="ti ti-check-box"></i> Aktiv</label>';
            }else{
                if($status=="Meninggal"){
                    $LabelData='<label class="label label-danger"><i class="icofont-close-squared"></i> Meninggal</label>';
                }else{
                    $LabelData='<label class="label label-info">'.$status.'</label>';
                }
            }
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="alert alert-info" role="alert">  
                Berikut ini adalah informasi pasien berdasarkan NIK dari SIMRS.
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 pre-scrollable">
            <div class="table table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><dt>No.RM</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$id_pasien"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>NIK</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$nik"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>BPJS</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$no_bpjs"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Tanggal Daftar</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$tanggal_daftar"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Nama Pasien</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$nama"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Propinsi</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$propinsi"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Kabupaten</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$kabupaten"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Kecamatan</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$kecamatan"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Desa</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$desa"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Alamat</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$alamat"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>TTL</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$tempat_lahir, $tanggal_lahir"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Kontak</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$kontak"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Golongan Darah</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$golongan_darah"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Jenis Kelamin</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$gender"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Status Perkawinan</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$perkawinan"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Pekerjaan</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$pekerjaan"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Status</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$LabelData"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Updatetime</dt></td>
                            <td><dt>:</dt></td>
                            <td>
                                <?php echo "$updatetime"; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php }} ?>