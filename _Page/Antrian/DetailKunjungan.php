<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <span class="text-danger">ID Kunjungan Tidak Boleh Kosong!!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_kunjungan =getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_kunjungan');
        if(empty($id_kunjungan)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <span class="text-danger">ID Kunjungan Tidak Valid Atau Tidak Ditemukan Pada Database!</span>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');
            $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
            $no_antrian=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'no_antrian');
            $nik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nik');
            $no_bpjs=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'no_bpjs');
            $sep=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'sep');
            $noRujukan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'noRujukan');
            $skdp=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'skdp');
            $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
            $tanggal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal');
            $propinsi=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'propinsi');
            $kabupaten=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kabupaten');
            $kecamatan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kecamatan');
            $desa=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'desa');
            $alamat=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'alamat');
            $keluhan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'keluhan');
            $tujuan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tujuan');
            $id_dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_dokter');
            $dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'dokter');
            $id_poliklinik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_poliklinik');
            $poliklinik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'poliklinik');
            $kelas=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kelas');
            $ruangan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'ruangan');
            $id_kasur=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_kasur');
            $DiagAwal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'DiagAwal');
            $rujukan_dari=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_dari');
            $rujukan_ke=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_ke');
            $pembayaran=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'pembayaran');
            $cara_keluar=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'cara_keluar');
            $tanggal_keluar=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal_keluar');
            $status=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'status');
            $id_akses=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_akses');
            $nama_petugas=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama_petugas');
            $updatetime=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'updatetime');
             //Membuka daya approval
            $id_approval=getDataDetail($Conn,"approval",'noKartu',$no_bpjs,'id_approval');
            //Menghitung data rencana kontrol
            $JumlahRencanaKontrol = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rencana_kontrol WHERE kategori='Rencana Kontrol' AND noSEP='$sep'"));
            //Menghitung data SPRI
            $JumlahSPRI = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rencana_kontrol WHERE kategori='SPRI' AND noSEP='$sep'"));
            //Membuka rencana_kontrol
            if(!empty($sep)){
                $QryRencanaKontrol = mysqli_query($Conn,"SELECT * FROM rencana_kontrol WHERE kategori='Rencana Kontrol' AND noSEP='$sep'")or die(mysqli_error($Conn));
                $DataRencanaKontrol = mysqli_fetch_array($QryRencanaKontrol);
                if(!empty($DataRencanaKontrol['id_rencana_kontrol'])){
                    $id_rencana_kontrol= $DataRencanaKontrol['id_rencana_kontrol'];
                    $noSuratKontrol= $DataRencanaKontrol['noSuratKontrol'];
                    $tglRencanaKontrol= $DataRencanaKontrol['tglRencanaKontrol'];
                    $namaDokter= $DataRencanaKontrol['namaDokter'];
                }else{
                    $id_rencana_kontrol="";
                    $noSuratKontrol="";
                    $tglRencanaKontrol="";
                    $namaDokter="";
                }
            }else{
                $id_rencana_kontrol="";
                $noSuratKontrol="";
                $tglRencanaKontrol="";
                $namaDokter="";
            }
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y H:i',$strtotime);
            //Update Time Format
            $strtotime2=strtotime($updatetime);
            $updatetime_format=date('d/m/Y H:i',$strtotime2);
?>
    <div class="row mb-3">
        <div class="col-md-4"><dt>ID Kunjungan</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($id_kunjungan)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$id_kunjungan</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>ID Encounter</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($id_encounter)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo '<small>'.$id_encounter.'</small>'; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Nama Pasien</dt></div>
        <div class="col-md-8">
            <?php 
                if(empty($nama)){
                    echo '<small class="text-danger">Tidak Ada</small>';
                }else{
                    echo "<small>$nama</small>"; 
                }
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>No.RM</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($id_pasien)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo '<small>'.$id_pasien.'</small>'; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Alamat Pasien</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($alamat)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$alamat</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Desa</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($desa)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$desa</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Kecamatan</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($kecamatan)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$kecamatan</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Kabupaten</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($kabupaten)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$kabupaten</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Provinsi</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($propinsi)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$propinsi</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>NIK</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($nik)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$nik</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Nomor BPJS</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($no_bpjs)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$no_bpjs</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Tanggal Kunjungan</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($tanggal)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$TanggalFormat</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Nomor SEP</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($sep)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$sep</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Nomor Rujukan</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($noRujukan)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$noRujukan</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Tujuan</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($tujuan)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$tujuan</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Dokter</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($dokter)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$dokter</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Poliklinik</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($poliklinik)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$poliklinik</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Kelas/Ruangan</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($kelas)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$kelas-$ruangan</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Pembayaran</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($pembayaran)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$pembayaran</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Diagnosa Awal</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($DiagAwal)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$DiagAwal</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Rujukan Dari</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($rujukan_dari)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$rujukan_dari</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Dirujuk Ke</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($rujukan_ke)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$rujukan_ke</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Cara Keluar</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($cara_keluar)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$cara_keluar</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Tanggal Keluar</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($tanggal_keluar)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$tanggal_keluar</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Status</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($status)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$status</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Updatetime</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($updatetime_format)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$updatetime_format</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Petugas</dt></div>
        <div class="col-md-8">
            <span>
                <?php 
                    if(empty($nama_petugas)){
                        echo '<small class="text-danger">Tidak Ada</small>';
                    }else{
                        echo "<small>$nama_petugas</small>"; 
                    }
                ?>
            </span>
        </div>
    </div>
<?php }} ?>