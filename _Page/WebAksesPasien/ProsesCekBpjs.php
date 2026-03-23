<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/PasienFunction.php";
    if(empty($_POST['no_bpjs'])){
        echo '<div class="alert alert-danger text-center" role="alert">Nomor BPJS Tidak Boleh Kosong!</div>';
    }else{
        $bpjs=$_POST['no_bpjs'];
        $DataPasien=getDataPasien('no_bpjs',$bpjs);
        if(empty($DataPasien['id_pasien'])){
            echo '<div class="alert alert-danger text-center" role="alert">BPJS Pasien Belum Terdaftar Di SIMRS</div>';
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
    <div class="table table-responsive pre-scrollable">
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
<?php }} ?>