<?php
// Hitung ringkasan dengan query agregasi agar lebih ringan
$JumlahLogProfile = (int) mysqli_fetch_assoc(
    mysqli_query($Conn, "SELECT COUNT(*) AS total FROM log WHERE id_akses='$SessionIdAkses'")
)['total'];
$JumlahLogProfileFormat = number_format($JumlahLogProfile, 0, ',', '.');

$JumlahLaporanPengguna = (int) mysqli_fetch_assoc(
    mysqli_query($Conn, "SELECT COUNT(*) AS total FROM laporan_pengguna WHERE id_akses='$SessionIdAkses'")
)['total'];
$JumlahLaporanPenggunaFormat = number_format($JumlahLaporanPengguna, 0, ',', '.');

// Ambil seluruh fitur + status akses dalam satu query untuk menghindari N+1
$featuresByCategory = [];
$qryFitur = mysqli_query(
    $Conn,
    "SELECT ar.kategori,
            ar.id_akses_ref,
            ar.nama_fitur,
            ar.keterangan,
            COALESCE(aa.status, 'No') AS status
     FROM akses_ref ar
     LEFT JOIN akses_acc aa
       ON aa.id_akses = '$SessionIdAkses' AND aa.id_akses_ref = ar.id_akses_ref
     ORDER BY ar.kategori ASC, ar.id_akses_ref ASC"
);

while ($row = mysqli_fetch_assoc($qryFitur)) {
    $featuresByCategory[$row['kategori']][] = $row;
}
?>
<div class="row">
    <div class="col col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4>
                            <i class="bi bi-person-circle"></i> Profil Saya
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 mb-4 text-center">
                        <img src="assets/images/<?php echo $LinkGambar;?>" width="150px" height="150px" class="img-radius">
                    </div>
                </div>
                <?php
                    echo '
                        <div class="row mb-2 mt-3">
                            <div class="col-5"><small>Tanggal Daftar</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <small class="text text-muted">'.date('d/m/Y H:i', strtotime($SessionTanggal)).'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Nama</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <small class="text text-muted">'.$SessionNama.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Kontak</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <small class="text text-muted">'.$SessionKontak.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Email</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <small class="text text-muted">'.$SessionEmail.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Aktivitas</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <small class="text text-muted">'.$JumlahLogProfileFormat.' Record</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Laporan User</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <small class="text text-muted">'.$JumlahLaporanPenggunaFormat.' Record</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Updatetime</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6">
                                <small class="text text-muted">'.$SessionUpdatetime.'</small>
                            </div>
                        </div>
                    ';
                ?>
            </div>
            <div class="card-footer">
                <div class="row mb-3">
                    <div class="col-md-12 icon-btn text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalEditFoto" title="Ubah Foto Profile">
                            <i class="bi bi-image"></i>
                        </button>
                        <button type="button" class="btn btn-round btn-sm btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalEditProfile" title="Edit Profile">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-round btn-sm btn-icon btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalGantiPassword" title="Ganti Password">
                            <i class="bi bi-lock"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="bi bi-list-check"></i> Fitur Yang Bisa Diakses
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" style="max-height: 600px; overflow-y: auto;">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" align="center"><b><small>No</small></b></th>
                                        <th><b><small>Fitur</small></b></th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    <?php
                                        $no = 1;
                                        foreach ($featuresByCategory as $kategori => $fiturList) {
                                            echo '<tr>';
                                            echo '  <td align="center"><b><small>'.$no.'</small></b></td>';
                                            echo '  <td align="left"><b><small>'.htmlspecialchars($kategori).'</small></b></td>';
                                            echo '</tr>';

                                            $no2 = 1;
                                            foreach ($fiturList as $fitur) {
                                                $statusIcon = ($fitur['status'] === 'Yes')
                                                    ? '<span class="text-success"><i class="ti ti-check"></i></span>'
                                                    : '<span class="text-danger"><i class="ti ti-close"></i></span>';

                                                echo '<tr>';
                                                echo '  <td align="right"><small>'.$statusIcon.' '.$no.'.'.$no2.'</small></td>';
                                                echo '  <td align="left"><small>'.htmlspecialchars($fitur['nama_fitur']).'<br><small>'.htmlspecialchars($fitur['keterangan']).'</small></small></td>';
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
</div>
