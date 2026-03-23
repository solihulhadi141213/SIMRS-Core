<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger mb-3">';
        echo '      ID Kunjungan Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka data Kunjungan
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
        $strtotime=strtotime($tanggal);
        $TanggalFormat=date('d/m/Y H:i',$strtotime);
        //Update Time Format
        $strtotime2=strtotime($updatetime);
        $updatetime_format=date('d/m/Y H:i',$strtotime2);
?>
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="sub-title"><dt>A. Informasi Identitas Pasien</dt></div>
            <ol>
                <li class="mb-2">
                    No.RM : <code class="text-secondary"><?php echo "$id_pasien"; ?></code>
                </li>
                <li class="mb-2">
                    Nama : <code class="text-secondary"><?php echo "$nama"; ?></code>
                </li>
                <li class="mb-2">
                    No.BPJS : <code class="text-secondary"><?php echo "$no_bpjs"; ?></code>
                </li>
                <li class="mb-2">
                    NIK : <code class="text-secondary"><?php echo "$nik"; ?></code>
                </li>
                <li class="mb-2">
                    Alamat :
                    <ul>
                        <li> Provinsi : <code class="text-secondary"><?php echo "$propinsi"; ?></code> </li>
                        <li> Kabupaten : <code class="text-secondary"><?php echo "$kabupaten"; ?></code> </li>
                        <li> Kecamatan : <code class="text-secondary"><?php echo "$kecamatan"; ?></code> </li>
                        <li> Desa : <code class="text-secondary"><?php echo "$desa"; ?></code> </li>
                        <li> Jalan/RT/RW : <code class="text-secondary"><?php echo "$alamat"; ?></code> </li>
                    </ul>
                </li>
            </ol>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="sub-title"><dt>B. Informasi Kunjungan</dt></div>
            <ol>
                <li class="mb-2">
                    ID.Kunjungan : <code class="text-secondary"><?php echo "$id_kunjungan"; ?></code>
                </li>
                <li class="mb-2">
                    No.Antrian : <code class="text-secondary"><?php echo "$no_antrian"; ?></code>
                </li>
                <li class="mb-2">
                    SEP : <code class="text-secondary"><?php echo "$sep"; ?></code>
                </li>
                <li class="mb-2">
                    No.Rujukan : <code class="text-secondary"><?php echo "$noRujukan"; ?></code>
                </li>
                <li class="mb-2">
                    No.SKDP/SPRI : <code class="text-secondary"><?php echo "$skdp"; ?></code>
                </li>
                <li class="mb-2">
                    Tanggal : <code class="text-secondary"><?php echo "$TanggalFormat"; ?></code>
                </li>
                <li class="mb-2">
                    Keluhan : <code class="text-secondary"><?php echo "$keluhan"; ?></code>
                </li>
                <li class="mb-2">
                    Tujuan : <code class="text-secondary"><?php echo "$tujuan"; ?></code>
                </li>
                <li class="mb-2">
                    Pembayaran : <code class="text-secondary"><?php echo "$pembayaran"; ?></code>
                </li>
            </ol>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="sub-title"><dt>C. Informasi Pelayanan</dt></div>
            <ol>
                <li class="mb-2">
                    Dokter : <code class="text-secondary"><?php echo "$dokter"; ?></code>
                </li>
                <li class="mb-2">
                    Poliklinik : <code class="text-secondary"><?php echo "$poliklinik"; ?></code>
                </li>
                <li class="mb-2">
                    Kelas : <code class="text-secondary"><?php echo "$kelas"; ?></code>
                </li>
                <li class="mb-2">
                    Ruangan : <code class="text-secondary"><?php echo "$ruangan"; ?></code>
                </li>
                <li class="mb-2">
                    Status : <code class="text-secondary"><?php echo "$status"; ?></code>
                </li>
                <li class="mb-2">
                    Petugas : <code class="text-secondary"><?php echo "$nama_petugas"; ?></code>
                </li>
            </ol>
        </div>
    </div>
<?php } ?>