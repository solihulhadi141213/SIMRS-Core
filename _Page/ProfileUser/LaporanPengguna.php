<div class="row">
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 text-center mb-3">
                        <h4>
                            <i class="icofont-paper-plane"></i> Riwayat Laporan Anda
                        </h4>
                        <small>
                            Kirim laporan kesalahan sistem atau temuan error pada aplikasi.
                        </small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalKirimLaporanPengguna">
                            <i class="ti ti-email"></i> Kirim Laporan
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><dt>No</dt></th>
                                <th class="text-center"><dt>Tanggal</dt></th>
                                <th class="text-center"><dt>Laporan</dt></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $No=1;
                                $JumlahLaporanPengguna=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laporan_pengguna WHERE id_akses='$SessionIdAkses'"));
                                if(empty($JumlahLaporanPengguna)){
                                    echo '<tr>';
                                    echo '  <td colspan="3">Belum Ada Data Laporan Yang Dimuat</td>';
                                    echo '</tr>';
                                }else{
                                    $QryLaporanPengguna = mysqli_query($Conn, "SELECT*FROM laporan_pengguna ORDER BY id_laporan_pengguna DESC");
                                    while ($DataLaporanPengguna = mysqli_fetch_array($QryLaporanPengguna)) {
                                        $id_laporan_pengguna= $DataLaporanPengguna['id_laporan_pengguna'];
                                        $nama= $DataLaporanPengguna['nama'];
                                        $tanggal= $DataLaporanPengguna['tanggal'];
                                        $judul= $DataLaporanPengguna['judul'];
                                        $laporan= $DataLaporanPengguna['laporan'];
                                        $response= $DataLaporanPengguna['response'];
                                        //Jumlah Karakter Laporan
                                        $JumlahKarLaporan=strlen($laporan);
                                        if($JumlahKarLaporan>100){
                                            $laporan=substr($laporan,0,100);
                                            $Laporan="$laporan...";
                                        }else{
                                            $Laporan="$laporan";
                                        }
                                        //Format Tanggal
                                        $Strtotime=strtotime($tanggal);
                                        $TanggalSaja=date('d/m/Y',$Strtotime);
                                        $JamSaja=date('H:i:s T',$Strtotime);
                                        //Label Response
                                        if(empty($DataLaporanPengguna['response'])){
                                            $response='<span class="text-danger"><i class="ti ti-close"></i> Belum Ada Response</span>';
                                        }else{
                                            $response='<span class="text-success"><i class="ti ti-check"></i> Sudah Ada Response</span>';
                                        }
                            ?>
                                <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailLaporanPengguna" data-id="<?php echo "$id_laporan_pengguna";?>" onmousemove="this.style.cursor='pointer'">
                                    <td class="" align="center"><?php echo $No;?></td>
                                    <td class="" align="left"><?php echo "<dt>$TanggalSaja</dt><small>$JamSaja</small>";?></td>
                                    <td class="" align="left"><?php echo "<dt>$judul</dt><small>$Laporan<br>$response</small>";?></td>
                                </tr>
                            <?php
                                        $No++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <dt>Laporan Pengguna Lainnya</dt>
                        <small>
                            Lihat laporan dari pengguna lainnya yang mungkin sama.
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-body" id="TableLaporanPengguna">
                
            </div>
        </div>
    </div>
</div>