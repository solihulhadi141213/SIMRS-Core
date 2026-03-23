<?php
    //Jumlah Log
    $JumlahLogProfile=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$SessionIdAkses'"));
    $JumlahLogProfileFormat = "" . number_format($JumlahLogProfile,0,',','.');
    //Jumlah Laporan
    $JumlahLaporanPengguna=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE id_akses='$SessionIdAkses'"));
    $JumlahLaporanPenggunaFormat = "" . number_format($JumlahLaporanPengguna,0,',','.');
?>
<div class="row">
    <div class="col col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4><i class="ti-user"></i> My Profile</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-4 text-center">
                        <img src="assets/images/<?php echo $LinkGambar;?>" width="150px" height="150px" class="img-radius">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-block btn-outline-dark" data-toggle="modal" data-target="#ModalEditFoto">
                            <i class="ti-gallery"></i> Ubah Foto
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2 table table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>
                                        <dt>Daftar</dt>
                                    </td>
                                    <td>
                                        <?php echo "$SessionTanggal"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <dt>Nama</dt>
                                    </td>
                                    <td>
                                        <?php echo "$SessionNama"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <dt>Kontak</dt>
                                    </td>
                                    <td>
                                        <?php echo "$SessionKontak"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <dt>Email</dt>
                                    </td>
                                    <td>
                                        <?php echo "$SessionEmail"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <dt>Aktivitas</dt>
                                    </td>
                                    <td>
                                        <?php echo "$JumlahLogProfileFormat Record"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <dt>Laporan User</dt>
                                    </td>
                                    <td>
                                        <?php echo "$JumlahLaporanPenggunaFormat Record"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <dt>Updatetime</dt>
                                    </td>
                                    <td>
                                        <?php echo "$SessionUpdatetime"; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 mt-2 text-right">
                        <btton type="button" class="btn btn-round btn-sm btn-primary ml-2" data-toggle="modal" data-target="#ModalEditProfile">
                            <i class="ti-user"></i> Edit Profile
                        </btton>
                        <btton type="button" class="btn btn-round btn-sm btn-primary ml-2" data-toggle="modal" data-target="#ModalGantiPassword">
                            <i class="ti-pencil"></i> Ganti Password
                        </btton>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="ti ti-book"></i> Referensi Fitur</h4>
                <small class="text-muted">
                    Berikut ini adalah list fitur yang bisa anda akses
                </small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" align="center"><dt>NO</dt></th>
                                    <th><dt>FITUR</dt></th>
                                </tr>
                            </thead>
                            <tbody class="">
                                <?php
                                    //Arraykan Kategori
                                    $no=1;
                                    $QryRef = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref ORDER BY kategori ASC");
                                    while ($DataRef = mysqli_fetch_array($QryRef)) {
                                        $KategoriFitur= $DataRef['kategori'];
                                        echo '<tr>';
                                        echo '  <td align="center"><dt>'.$no.'</dt></td>';
                                        echo '  <td align="left"><dt>'.$KategoriFitur.'</dt></td>';
                                        echo '</tr>';
                                        //Buka Data Fitur Berdasarkan Kategori
                                        $no2=1;
                                        $QryRefAcc = mysqli_query($Conn, "SELECT * FROM akses_ref WHERE kategori='$KategoriFitur' ORDER BY id_akses_ref ASC");
                                        while ($DataRefAcc = mysqli_fetch_array($QryRefAcc)) {
                                            $id_akses_ref= $DataRefAcc['id_akses_ref'];
                                            $nama_fitur= $DataRefAcc['nama_fitur'];
                                            $kode= $DataRefAcc['kode'];
                                            $keterangan= $DataRefAcc['keterangan'];
                                            //Buka Data Akses
                                            $QryAksesAcc = mysqli_query($Conn,"SELECT * FROM akses_acc WHERE id_akses='$SessionIdAkses' AND id_akses_ref='$id_akses_ref'")or die(mysqli_error($Conn));
                                            $DataAksesAcc = mysqli_fetch_array($QryAksesAcc);
                                            if(empty($DataAksesAcc['id_akses_acc'])){
                                                $StatusAcc='<span class="text-danger"><i class="ti ti-close"></i></span>';
                                            }else{
                                                $StatusAcc=$DataAksesAcc['status'];
                                                if($StatusAcc=="Yes"){
                                                    $StatusAcc='<span class="text-success"><i class="ti ti-check"></i></span>';
                                                }else{
                                                    $StatusAcc='<span class="text-danger"><i class="ti ti-close"></i></span>';
                                                }
                                            }
                                            echo '<tr>';
                                            echo '  <td align="right">'.$StatusAcc.' '.$no.'.'.$no2.'</td>';
                                            echo '  <td align="left">'.$nama_fitur.'<br><small>'.$keterangan.'</small></td>';
                                            echo '</tr>';
                                            $no2++;
                                        }
                                        $no++;
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>