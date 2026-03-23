<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_permintaan
    if(empty($_POST['id_permintaan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          ID Permintaan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_permintaan=$_POST['id_permintaan'];
        $id_permintaan=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'id_permintaan');
        if(empty($id_permintaan)){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger text-center">';
            echo '          ID Permintaan Tidak Valid!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '              <i class="ti-close"></i> Tutup';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            //Detail Permintaan Laboratorium
            $id_permintaan=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'id_permintaan');
            $id_pasien=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'id_pasien');
            $id_kunjungan=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'id_kunjungan');
            $id_dokter=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'id_dokter');
            $tujuan=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'tujuan');
            $nama_pasien=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'nama_pasien');
            $nama_dokter=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'nama_dokter');
            $tanggal=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'tanggal');
            $faskes=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'faskes');
            $unit=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'unit');
            $prioritas=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'prioritas');
            $diagnosis=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'diagnosis');
            $keterangan_permintaan=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'keterangan_permintaan');
            $nama_signature=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'nama_signature');
            $status=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'status');
            $keterangan_status=getDataDetail($Conn,"laboratorium_permintaan",'id_permintaan',$id_permintaan,'keterangan_status');
            //Buka Informasi Pemeriksaan
            $id_lab=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'id_lab');
            if(!empty($id_lab)){
                $LabelPemeriksaan='<span class="text-success"><i class="ti ti-check"></i> Tersedia</span>';
            }else{
                $LabelPemeriksaan='<span class="text-danger"><i class="ti ti-close"></i> Belum Ada</span>';
            }
            //Uraian Pemeriksaan
            $id_rincian_lab=getDataDetail($Conn,"laboratorium_rincian",'id_permintaan',$id_permintaan,'id_rincian_lab');
            if(!empty($id_rincian_lab)){
                $LabelRincian='<span class="text-success"><i class="ti ti-check"></i> Tersedia</span>';
            }else{
                $LabelRincian='<span class="text-danger"><i class="ti ti-close"></i> Belum Ada</span>';
            }
            //Format Tanggal
            $strtotime1=strtotime($tanggal);
            $TanggalPermintaan=date('d/m/Y H:i T',$strtotime1);
?>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-12 sub-title">
                    Detail Permintaan
                    <?php
                        echo '<ol class="mt-3">';
                        echo '  <li class="mb-2">Tgl/Jam Permintaan : <code class="text-secondary">'.$TanggalPermintaan.'</code></li>';
                        echo '  <li class="mb-2">Faskes : <code class="text-secondary">'.$faskes.'</code></li>';
                        echo '  <li class="mb-2">Unit : <code class="text-secondary">'.$unit.'</code></li>';
                        echo '  <li class="mb-2">Dokter : <code class="text-secondary">'.$nama_dokter.'</code></li>';
                        echo '  <li class="mb-2">Tujuan : <code class="text-secondary">'.$tujuan.'</code></li>';
                        echo '  <li class="mb-2">Prioritas : <code class="text-secondary">'.$prioritas.'</code></li>';
                        echo '  <li class="mb-2">Diagnosis : <code class="text-secondary">'.$diagnosis.'</code></li>';
                        echo '  <li class="mb-2">Keterangan Permintaan : <code class="text-secondary">'.$keterangan_permintaan.'</code></li>';
                        echo '  <li class="mb-2">Status : <code class="text-secondary">('.$status.') '.$keterangan_status.'</code></li>';
                        echo '  <li class="mb-2">Informasi Pemeriksaan : <code class="text-secondary">'.$LabelPemeriksaan.'</code></li>';
                        echo '  <li class="mb-2">Rincian Pemeriksaan : <code class="text-secondary">'.$LabelRincian.'</code></li>';
                        echo '</ol>';
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 sub-title">
                    Informasi Pemeriksaan
                    <?php
                        $waktu_pendaftaran=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'waktu_pendaftaran');
                        $pengambilan_sample=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'pengambilan_sample');
                        $pemeriksaan_sample=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'pemeriksaan_sample');
                        $keluar_hasil=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'keluar_hasil');
                        $hasil_diserahkan=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'hasil_diserahkan');
                        $metode_penyerahan=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'metode_penyerahan');
                        $interpertasi_hasil=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'interpertasi_hasil');
                        $dokter_interpertasi=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'dokter_interpertasi');
                        $dokter_validator=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'dokter_validator');
                        $petugas_analis=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'petugas_analis');
                        echo '<ol class="mt-3">';
                        echo '  <li class="mb-2">Waktu Pendaftaran : <code class="text-secondary">'.$waktu_pendaftaran.'</code></li>';
                        echo '  <li class="mb-2">Pengambilan Sample : <code class="text-secondary">'.$pengambilan_sample.'</code></li>';
                        echo '  <li class="mb-2">Pemeriksaan Sample : <code class="text-secondary">'.$pemeriksaan_sample.'</code></li>';
                        echo '  <li class="mb-2">Keluar Hasil : <code class="text-secondary">'.$keluar_hasil.'</code></li>';
                        echo '  <li class="mb-2">Hasil Diserahkan : <code class="text-secondary">'.$hasil_diserahkan.'</code></li>';
                        echo '  <li class="mb-2">Metode Penyerahan : <code class="text-secondary">'.$metode_penyerahan.'</code></li>';
                        echo '  <li class="mb-2">Interpertasi Hasil : <code class="text-secondary">'.$interpertasi_hasil.'</code></li>';
                        echo '  <li class="mb-2">Dokter Interpertasi : <code class="text-secondary">'.$dokter_interpertasi.'</code></li>';
                        echo '  <li class="mb-2">Validator : <code class="text-secondary">'.$dokter_validator.'</code></li>';
                        echo '  <li class="mb-2">Petugas Analisis : <code class="text-secondary">'.$petugas_analis.'</code></li>';
                        echo '</ol>';
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    Hasil Pemeriksaan
                    <?php
                        echo '<ol class="mt-3">';
                        $no = 1;
                        $query = mysqli_query($Conn, "SELECT * FROM laboratorium_rincian WHERE id_permintaan='$id_permintaan' ORDER BY id_rincian_lab ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_rincian_lab=$data['id_rincian_lab'];
                            $parameter=$data['parameter'];
                            $kategori_parameter=$data['kategori_parameter'];
                            $hasil=$data['hasil'];
                            $interpertasi=$data['interpertasi'];
                            $keterangan=$data['keterangan'];
                            echo '<li class="mb-2">';
                            echo '  Parameter Pemeriksaan : <code class="text-secondary">'.$parameter.'</code>';
                            echo '  <ol>';
                            echo '      <li>Kategori : <code class="text-secondary">'.$kategori_parameter.'</code></li>';
                            echo '      <li>Hasil : <code class="text-secondary">'.$hasil.'</code></li>';
                            echo '      <li>Interpertasi : <code class="text-secondary">'.$interpertasi.'</code></li>';
                            echo '      <li>Keterangan : <code class="text-secondary">'.$keterangan.'</code></li>';
                            echo '  </ol>';
                            echo '</li>';
                        }
                        echo '</ol>';
                    ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="index.php?Page=Laboratorium&Sub=DetailPermintaanLab&id=<?php echo "$id_permintaan"; ?>" class="btn btn-sm btn-primary mr-2">
                <i class="ti ti-more"></i> Lihat Detail Selengkapnya
            </a>
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
<?php }} ?>