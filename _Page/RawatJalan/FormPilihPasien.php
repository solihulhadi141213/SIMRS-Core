<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
?>
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th class="text-center"><dt>No</dt></th>
                <th class="text-center"><dt>No.RM</dt></th>
                <th class="text-center"><dt>No.NIK</dt></th>
                <th class="text-center"><dt>No.BPJS</dt></th>
                <th class="text-center"><dt>Nama Lengkap</dt></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY id_pasien DESC LIMIT $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' ORDER BY id_pasien DESC LIMIT $batas");
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_pasien= $data['id_pasien'];
                    $noRm=sprintf("%07d", $id_pasien);
                    $tanggal_daftar= $data['tanggal_daftar'];
                    $nik= $data['nik'];
                    $no_bpjs= $data['no_bpjs'];
                    $nama= $data['nama'];
                    $gender= $data['gender'];
                    $tempat_lahir= $data['tempat_lahir'];
                    $tanggal_lahir= $data['tanggal_lahir'];
                    $propinsi= $data['propinsi'];
                    $kabupaten= $data['kabupaten'];
                    $kecamatan= $data['kecamatan'];
                    $desa= $data['desa'];
                    $alamat= $data['alamat'];
                    $status= $data['status'];
                    $gambar= $data['gambar'];
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
                    <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalPilihPasien" data-id="<?php echo "$id_pasien";?>" onmousemove="this.style.cursor='pointer'">
                    <td class="" align="center"><?php echo "$no";?></td>
                    <td class="" align="left"><?php echo "$noRm";?></td>
                    <td class="" align="left"><?php echo "$nik";?></td>
                    <td class="" align="left"><?php echo "$no_bpjs";?></td>
                    <td class="" align="left"><?php echo "$nama";?></td>
                </tr>
            <?php
                $no++; }
            ?>
        </tbody>
    </table>
</div>