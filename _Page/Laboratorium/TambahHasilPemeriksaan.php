<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <?php
                        if(empty($_GET['id_permintaan'])){
                            echo '<div class="col-12">';
                            echo '  <div class="card-body">';
                            echo '      <div class="row mb-4">';
                            echo '          <div class="col-12 text-danger text-center">';
                            echo '              ID Permintaan Tidak Boleh Kosong';
                            echo '          </div>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            if(empty($_GET['id_laboratorium_sample'])){
                                echo '<div class="col-12">';
                                echo '  <div class="card-body">';
                                echo '      <div class="row mb-4">';
                                echo '          <div class="col-12 text-danger text-center">';
                                echo '              ID Spesimen Tidak Boleh Kosong';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                if(empty($_GET['id_lab'])){
                                    echo '<div class="col-12">';
                                    echo '  <div class="card-body">';
                                    echo '      <div class="row mb-4">';
                                    echo '          <div class="col-12 text-danger text-center">';
                                    echo '              ID Lab Tidak Boleh Kosong';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    $id_permintaan=$_GET['id_permintaan'];
                                    $id_laboratorium_sample=$_GET['id_laboratorium_sample'];
                                    $id_lab=$_GET['id_lab'];
                                    //Informasi Permintaan
                                    $id_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_pasien');
                                    $id_kunjungan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_kunjungan');
                                    $id_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_dokter');
                                    $tujuan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tujuan');
                                    $nama_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_pasien');
                                    $nama_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_dokter');
                                    $tanggal=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tanggal');
                                    $faskes=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'faskes');
                                    $unit=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'unit');
                                    $prioritas=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'prioritas');
                                    $diagnosis=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'diagnosis');
                                    $keterangan_permintaan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_permintaan');
                                    $nama_signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_signature');
                                    $signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'signature');
                                    $status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'status');
                                    $keterangan_status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_status');
                                    //Pecahkan tanggal
                                    $strtotime=strtotime($tanggal);
                                    $Tanggal=date('d/m/Y H:i T',$strtotime);
                                    //Informasi Spesimen
                                    $waktu_pengambilan=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'waktu_pengambilan');
                                    $sumber=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'sumber');
                                    $lokasi_pengambilan=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'lokasi_pengambilan');
                                    $jumlah_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'jumlah_sample');
                                    $volume_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'volume_sample');
                                    $metode=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'metode');
                                    $kondisi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'kondisi');
                                    $waktu_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'waktu_fiksasi');
                                    $cairan_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'cairan_fiksasi');
                                    $volume_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'volume_fiksasi');
                                    $petugas_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_sample');
                                    $petugas_pengantar=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_pengantar');
                                    $petugas_penerima=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_penerima');
                                    $status=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'status');
                                    //Jumlah Parameter
                                    $JumlahParameter = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_parameter"));
                    ?>
                        <div class="col-xl-8 col-12">
                            <div class="card table-card">
                                <form action="">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-12 mb-3 card-title text-center">
                                                <h4 class="text-dark">
                                                    <i class="icofont-prescription"></i> Form Hasil Pemeriksaan
                                                </h4>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <a href="index.php?Page=Laboratorium&Sub=DetailPermintaanLab&id=<?php echo "$id_permintaan"; ?>" class="btn btn-sm btn-block btn-secondary" title="Edit Data Permintaan Lab">
                                                    <i class="ti ti-arrow-circle-left text-white"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><dt>No</dt></th>
                                                    <th class="text-center"><dt>Parameter</dt></th>
                                                    <th class="text-center"><dt>Hasil</dt></th>
                                                    <th class="text-center"><dt>Interpertasi</dt></th>
                                                    <th class="text-center"><dt>Keterangan</dt></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if(empty($JumlahParameter)){
                                                        echo '<tr>';
                                                        echo '  <td colspan="5" align="center">Tidak Ada Data Parameter Yang Ditampilkan</td>';
                                                        echo '</tr>';
                                                    }else{
                                                        $no1 = 1;
                                                        //KONDISI PENGATURAN MASING FILTER
                                                        $query = mysqli_query($Conn, "SELECT DISTINCT kategori_parameter FROM laboratorium_parameter ORDER BY kategori_parameter ASC");
                                                        while ($data = mysqli_fetch_array($query)) {
                                                            $kategori_parameter= $data['kategori_parameter'];
                                                ?>
                                                    <tr tabindex="0" class="table-light">
                                                        <td class="" align="center"><dt><?php echo "$no1";?></dt></td>
                                                        <td colspan="4" align="left"><dt><?php echo "$kategori_parameter";?></dt></td>
                                                    </tr>
                                                    <?php
                                                        $no2=1;
                                                        //Buka List Parameter
                                                        $query2 = mysqli_query($Conn, "SELECT * FROM laboratorium_parameter WHERE kategori_parameter='$kategori_parameter' ORDER BY parameter ASC");
                                                        while ($data2 = mysqli_fetch_array($query2)) {
                                                            $id_laboratorium_parameter= $data2['id_laboratorium_parameter'];
                                                            $parameter= $data2['parameter'];
                                                            //Buka hasil Pemeriksaan
                                                            $QryRincianPemeriksaan = mysqli_query($Conn,"SELECT * FROM laboratorium_rincian WHERE id_permintaan='$id_permintaan' AND id_lab='$id_lab' AND id_laboratorium_sample='$id_laboratorium_sample' AND parameter='$parameter' AND kategori_parameter='$kategori_parameter'")or die(mysqli_error($Conn));
                                                            $DataRincianPemeriksaan = mysqli_fetch_array($QryRincianPemeriksaan);
                                                            if(!empty($DataRincianPemeriksaan['id_rincian_lab'])){
                                                                $id_rincian_lab = $DataRincianPemeriksaan['id_rincian_lab'];
                                                                $hasil = $DataRincianPemeriksaan['hasil'];
                                                                $interpertasi = $DataRincianPemeriksaan['interpertasi'];
                                                                $keterangan = $DataRincianPemeriksaan['keterangan'];
                                                                $satuan= $data2['satuan'];
                                                                $nilai_rujukan= $data2['nilai_rujukan'];
                                                                $nilai_kritis= $data2['nilai_kritis'];
                                                            }else{
                                                                $id_rincian_lab="0";
                                                                $hasil="<span class='text-danger'>None</span>";
                                                                $interpertasi="<span class='text-danger'>None</span>";
                                                                $keterangan="<span class='text-danger'>None</span>";
                                                                $satuan="";
                                                                $nilai_rujukan="";
                                                                $nilai_kritis="";
                                                            }
                                                    ?>
                                                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalTambahHasilPemeriksaan" data-id="<?php echo "$id_laboratorium_sample,$id_laboratorium_parameter";?>" onmousemove="this.style.cursor='pointer'">
                                                            <td class="" align="right"><?php echo "$no1.$no2";?></td>
                                                            <td class="" align="left">
                                                                <?php 
                                                                    echo "$parameter";
                                                                ?>
                                                            </td>
                                                            <td class="" align="left"><?php echo "$hasil $satuan";?></td>
                                                            <td class="" align="left"><?php echo "$interpertasi";?></td>
                                                            <td class="" align="left"><?php echo "$keterangan";?></td>
                                                        </tr>
                                                    <?php $no2++;} ?>
                                                <?php $no1++;}} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-4 col-12">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-12 mb-3 card-title text-center">
                                            <h4 class="text-dark">
                                                <i class="icofont-laboratory"></i> Informasi Spesimen
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if(!empty($waktu_pengambilan)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Tgl/Waktu</dt></div>
                                            <div class="col-6 text-right"><?php echo "$waktu_pengambilan";?></div>
                                        </div>
                                    <?php }if(!empty($sumber)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Sumber</dt></div>
                                            <div class="col-6 text-right"><?php echo "$sumber";?></div>
                                        </div>
                                    <?php }if(!empty($lokasi_pengambilan)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Lokasi</dt></div>
                                            <div class="col-6 text-right"><?php echo "$lokasi_pengambilan";?></div>
                                        </div>
                                    <?php }if(!empty($jumlah_sample)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Jumlah</dt></div>
                                            <div class="col-6 text-right"><?php echo "$jumlah_sample";?></div>
                                        </div>
                                    <?php }if(!empty($volume_sample)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Volume</dt></div>
                                            <div class="col-6 text-right"><?php echo "$volume_sample";?></div>
                                        </div>
                                    <?php }if(!empty($metode)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Metode</dt></div>
                                            <div class="col-6 text-right"><?php echo "$metode";?></div>
                                        </div>
                                    <?php }if(!empty($kondisi)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Kondisi</dt></div>
                                            <div class="col-6 text-right"><?php echo "$kondisi";?></div>
                                        </div>
                                    <?php }if(!empty($waktu_fiksasi)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Fiksasi</dt></div>
                                            <div class="col-6 text-right"><?php echo "$waktu_fiksasi";?></div>
                                        </div>
                                    <?php }if(!empty($cairan_fiksasi)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Cairan Fiksasi</dt></div>
                                            <div class="col-6 text-right"><?php echo "$cairan_fiksasi";?></div>
                                        </div>
                                    <?php }if(!empty($volume_fiksasi)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Volume Fiksasi</dt></div>
                                            <div class="col-6 text-right"><?php echo "$volume_fiksasi";?></div>
                                        </div>
                                    <?php }if(!empty($petugas_sample)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Petugas Spesimen</dt></div>
                                            <div class="col-6 text-right"><?php echo "$petugas_sample";?></div>
                                        </div>
                                    <?php }if(!empty($petugas_pengantar)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Petugas Pengantar</dt></div>
                                            <div class="col-6 text-right"><?php echo "$petugas_pengantar";?></div>
                                        </div>
                                    <?php }if(!empty($petugas_penerima)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Petugas Penerima</dt></div>
                                            <div class="col-6 text-right"><?php echo "$petugas_penerima";?></div>
                                        </div>
                                    <?php }if(!empty($status)){ ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Status</dt></div>
                                            <div class="col-6 text-right"><?php echo "$status";?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php }}} ?>
                </div>
            </div>
        </div>
    </div>
</div>
