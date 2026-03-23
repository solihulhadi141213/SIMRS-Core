<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_rad
    if(empty($_POST['id_rad'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Radiologi Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_rad=$_POST['id_rad'];
        if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_pasien'))){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center mb-3">';
            echo '         ID Pasien Tidak Ditemukan Pada Data Pendaftaran Radiologi.';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_pasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_pasien');
            $id_kunjungan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_kunjungan');
            $NamaPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'nama');
            $WaktuRadiologi=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'waktu');
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman'))){
                $AsalKiriman='<small class="text-muted">Tidak Ada</small>';
            }else{
                $AsalKiriman=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman');
            }
            
            $PermintaanPemeriksaan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'permintaan_pemeriksaan');
            $AlatPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'alat_pemeriksa');
            $StatusPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'status_pemeriksaan');
            $JenisPembayaran=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'jenis_pembayaran');
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim'))){
                $DokterPengirim='<small class="text-muted">Tidak Ada</small>';
            }else{
                $DokterPengirim=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim');
            }
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima'))){
                $DokterPenerima='<small class="text-muted">Tidak Ada</small>';
            }else{
                $DokterPenerima=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima');
            }
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer'))){
                $RadioGrafer='<small class="text-muted">Belum Memperoleh Verifikasi</small>';
            }else{
                $RadioGrafer=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer');
            }
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan'))){
                $Kesan='<small class="text-muted">Tidak Ada</small>';
            }else{
                $Kesan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan');
            }
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis'))){
                $KlinisPasien='<small class="text-muted">Tidak Ada</small>';
            }else{
                $KlinisPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis');
            }
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai'))){
                $WaktuSelesai='<small class="text-muted">Belum Diatur</small>';
            }else{
                $WaktuSelesai=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai');
            }
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv'))){
                $kv='<small class="text-muted">None</small>';
            }else{
                $kv=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv');
            }
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma'))){
                $ma='<small class="text-muted">None</small>';
            }else{
                $ma=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma');
            }
            if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec'))){
                $sec='<small class="text-muted">None</small>';
            }else{
                $sec=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec');
            }
            //BUKA DATA PASIEN
            if(!empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'id_pasien'))){
                
            }else{

            }
?>
    <div class="row">
        <div class="col-md-12 table table-responsive pre-scrollable">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="4">
                            <dt>A. INFORMASI RADIOLOGI</dt>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>ID.PASIEN</td>
                        <td>:</td>
                        <td><?php echo "$id_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>ID.REG</td>
                        <td>:</td>
                        <td><?php echo "$id_kunjungan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>NAMA</td>
                        <td>:</td>
                        <td><?php echo "$NamaPasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>TANGGAL</td>
                        <td>:</td>
                        <td><?php echo "$WaktuRadiologi"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>PEMERIKSAAN</td>
                        <td>:</td>
                        <td><?php echo "$PermintaanPemeriksaan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>ALAT</td>
                        <td>:</td>
                        <td><?php echo "$AlatPemeriksa"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>STATUS</td>
                        <td>:</td>
                        <td><?php echo "$StatusPemeriksa"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>PEMBAYARAN</td>
                        <td>:</td>
                        <td><?php echo "$JenisPembayaran"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>DOKTER PENGIRIM</td>
                        <td>:</td>
                        <td><?php echo "$DokterPengirim"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>DOKTER PEMIRIKSA</td>
                        <td>:</td>
                        <td><?php echo "$DokterPenerima"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>RADIOGRAFER</td>
                        <td>:</td>
                        <td><?php echo "$RadioGrafer"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>KESAN</td>
                        <td>:</td>
                        <td><?php echo "$Kesan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>KLINIS</td>
                        <td>:</td>
                        <td><?php echo "$KlinisPasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>WAKTU SELESAI</td>
                        <td>:</td>
                        <td><?php echo "$WaktuSelesai"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>KV/MA/SEC</td>
                        <td>:</td>
                        <td><?php echo "$kv/$ma/$sec"; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <dt>B. INFORMASI PASIEN</dt>
                        </td>
                    </tr>
                    <?php
                        //KONDISI KETIKA ID PASIEN TIDAK DITEMUKAN
                        if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'id_pasien'))){
                            echo '<tr>';
                            echo '  <td colspan="4" class="text-danger">';
                            echo '      ID Pasien Tidak Ditemukan Pada Data RM';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $TanggalDaftar=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_daftar');
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nik'))){
                                $NikPasien="<span class=''>Tidak Ada</span>";
                            }else{
                                $NikPasien=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nik');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'no_bpjs'))){
                                $NomorBpjs="<span class=''>Tidak Ada</span>";
                            }else{
                                $NomorBpjs=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'no_bpjs');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nama'))){
                                $NamaPasien="<span class=''>Tidak Ada</span>";
                            }else{
                                $NamaPasien=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nama');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gender'))){
                                $Gender="<span class=''>Tidak Ada</span>";
                            }else{
                                $Gender=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gender');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tempat_lahir'))){
                                $TempatLahir="<span class=''>Tidak Ada</span>";
                            }else{
                                $TempatLahir=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tempat_lahir');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_lahir'))){
                                $TanggalLahir="<span class=''>Tidak Ada</span>";
                            }else{
                                $TanggalLahir=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_lahir');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'propinsi'))){
                                $propinsi="<span class=''>Tidak Ada</span>";
                            }else{
                                $propinsi=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'propinsi');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kabupaten'))){
                                $kabupaten="<span class=''>Tidak Ada</span>";
                            }else{
                                $kabupaten=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kabupaten');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kecamatan'))){
                                $kecamatan="<span class=''>Tidak Ada</span>";
                            }else{
                                $kecamatan=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kecamatan');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'desa'))){
                                $desa="<span class=''>Tidak Ada</span>";
                            }else{
                                $desa=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'desa');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'alamat'))){
                                $alamat="<span class=''>Tidak Ada</span>";
                            }else{
                                $alamat=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'alamat');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kontak'))){
                                $kontak="<span class=''>Tidak Ada</span>";
                            }else{
                                $kontak=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kontak');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kontak_darurat'))){
                                $kontak_darurat="<span class=''>Tidak Ada</span>";
                            }else{
                                $kontak_darurat=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kontak_darurat');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'penanggungjawab'))){
                                $penanggungjawab="<span class=''>Tidak Ada</span>";
                            }else{
                                $penanggungjawab=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'penanggungjawab');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'golongan_darah'))){
                                $golongan_darah="<span class=''>Tidak Ada</span>";
                            }else{
                                $golongan_darah=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'golongan_darah');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'perkawinan'))){
                                $perkawinan="<span class=''>Tidak Ada</span>";
                            }else{
                                $perkawinan=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'perkawinan');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gambar'))){
                                $gambar="<span class=''>Tidak Ada</span>";
                            }else{
                                $gambar=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gambar');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'pekerjaan'))){
                                $pekerjaan="<span class=''>Tidak Ada</span>";
                            }else{
                                $pekerjaan=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'pekerjaan');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'status'))){
                                $status="<span class=''>Tidak Ada</span>";
                            }else{
                                $status=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'status');
                            }
                            if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'updatetime'))){
                                $updatetime="<span class=''>Tidak Ada</span>";
                            }else{
                                $updatetime=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'updatetime');
                            }
                    ?>
                        <tr>
                            <td></td>
                            <td>TANGGAL DAFTAR</td>
                            <td>:</td>
                            <td><?php echo "$TanggalDaftar"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NIK</td>
                            <td>:</td>
                            <td><?php echo "$NikPasien"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NO.BPJS</td>
                            <td>:</td>
                            <td><?php echo "$NomorBpjs"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NAMA PASIEN</td>
                            <td>:</td>
                            <td><?php echo "$NamaPasien"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>GENDER</td>
                            <td>:</td>
                            <td><?php echo "$Gender"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TTL</td>
                            <td>:</td>
                            <td><?php echo "$TempatLahir, $TanggalLahir"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>PROVINSI</td>
                            <td>:</td>
                            <td><?php echo "$propinsi"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>KABUPATEN</td>
                            <td>:</td>
                            <td><?php echo "$kabupaten"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>KECAMATAN</td>
                            <td>:</td>
                            <td><?php echo "$kecamatan"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>DESA</td>
                            <td>:</td>
                            <td><?php echo "$desa"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>ALAMAT SELENGKAPNYA</td>
                            <td>:</td>
                            <td><?php echo "$alamat"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>KONTAK</td>
                            <td>:</td>
                            <td><?php echo "$kontak"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>KONTAK DARURAT</td>
                            <td>:</td>
                            <td><?php echo "$kontak_darurat"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>PENANGGUNG JAWAB</td>
                            <td>:</td>
                            <td><?php echo "$penanggungjawab"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>GOLONGAN DARAH</td>
                            <td>:</td>
                            <td><?php echo "$golongan_darah"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>PERKAWINAN</td>
                            <td>:</td>
                            <td><?php echo "$perkawinan"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>PEKERJAAN</td>
                            <td>:</td>
                            <td><?php echo "$pekerjaan"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>STATUS</td>
                            <td>:</td>
                            <td><?php echo "$status"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>UPDATE TERAKHIR</td>
                            <td>:</td>
                            <td><?php echo "$updatetime"; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4">
                            <dt>C. INFORMASI KUNJUNGAN</dt>
                        </td>
                    </tr>
                    <?php
                        //KONDISI KETIKA KUNJUNGAN TIDAK DITEMUKAN
                        if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_kunjungan'))){
                            echo '<tr>';
                            echo '  <td colspan="4" class="text-danger">';
                            echo '      ID Pasien Tidak Ditemukan Pada Data RM';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $id_kunjungan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_kunjungan');
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'no_antrian'))){
                                $no_antrian="<span class=''>Tidak Ada</span>";
                            }else{
                                $no_antrian=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'no_antrian');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'sep'))){
                                $sep="<span class=''>Tidak Ada</span>";
                            }else{
                                $sep=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'sep');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'noRujukan'))){
                                $noRujukan="<span class=''>Tidak Ada</span>";
                            }else{
                                $noRujukan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'noRujukan');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'skdp'))){
                                $skdp="<span class=''>Tidak Ada</span>";
                            }else{
                                $skdp=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'skdp');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal'))){
                                $tanggal="<span class=''>Tidak Ada</span>";
                            }else{
                                $tanggal=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'keluhan'))){
                                $keluhan="<span class=''>Tidak Ada</span>";
                            }else{
                                $keluhan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'keluhan');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tujuan'))){
                                $tujuan="<span class=''>Tidak Ada</span>";
                            }else{
                                $tujuan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tujuan');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_dokter'))){
                                $id_dokter="<span class=''>Tidak Ada</span>";
                            }else{
                                $id_dokter=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_dokter');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'dokter'))){
                                $dokter="<span class=''>Tidak Ada</span>";
                            }else{
                                $dokter=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'dokter');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_poliklinik'))){
                                $id_poliklinik="<span class=''>Tidak Ada</span>";
                            }else{
                                $id_poliklinik=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_poliklinik');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'poliklinik'))){
                                $poliklinik="<span class=''>Tidak Ada</span>";
                            }else{
                                $poliklinik=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'poliklinik');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'kelas'))){
                                $kelas="<span class=''>Tidak Ada</span>";
                            }else{
                                $kelas=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'kelas');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'ruangan'))){
                                $ruangan="<span class=''>Tidak Ada</span>";
                            }else{
                                $ruangan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'ruangan');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_kasur'))){
                                $id_kasur="<span class=''>Tidak Ada</span>";
                            }else{
                                $id_kasur=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_kasur');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'DiagAwal'))){
                                $DiagAwal="<span class=''>Tidak Ada</span>";
                            }else{
                                $DiagAwal=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'DiagAwal');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'rujukan_dari'))){
                                $rujukan_dari="<span class=''>Tidak Ada</span>";
                            }else{
                                $rujukan_dari=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'rujukan_dari');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'rujukan_ke'))){
                                $rujukan_ke="<span class=''>Tidak Ada</span>";
                            }else{
                                $rujukan_ke=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'rujukan_ke');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'pembayaran'))){
                                $pembayaran="<span class=''>Tidak Ada</span>";
                            }else{
                                $pembayaran=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'pembayaran');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'cara_keluar'))){
                                $cara_keluar="<span class=''>Tidak Ada</span>";
                            }else{
                                $cara_keluar=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'cara_keluar');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal_keluar'))){
                                $tanggal_keluar="<span class=''>Tidak Ada</span>";
                            }else{
                                $tanggal_keluar=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal_keluar');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'status'))){
                                $status="<span class=''>Tidak Ada</span>";
                            }else{
                                $status=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'status');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_akses'))){
                                $id_akses="<span class=''>Tidak Ada</span>";
                            }else{
                                $id_akses=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_akses');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'nama_petugas'))){
                                $nama_petugas="<span class=''>Tidak Ada</span>";
                            }else{
                                $nama_petugas=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'nama_petugas');
                            }
                            if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'updatetime'))){
                                $updatetime="<span class=''>Tidak Ada</span>";
                            }else{
                                $updatetime=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'updatetime');
                            }
                    ?>
                        <tr>
                            <td></td>
                            <td>NO.REG</td>
                            <td>:</td>
                            <td><?php echo "$id_kunjungan"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NO.ANTRIAN</td>
                            <td>:</td>
                            <td><?php echo "$no_antrian"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>SEP</td>
                            <td>:</td>
                            <td><?php echo "$sep"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NO.RUJUKAN</td>
                            <td>:</td>
                            <td><?php echo "$noRujukan"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>SKDP</td>
                            <td>:</td>
                            <td><?php echo "$skdp"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TANGGAL</td>
                            <td>:</td>
                            <td><?php echo "$tanggal"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>KELUHAN</td>
                            <td>:</td>
                            <td><?php echo "$keluhan"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TUJUAN</td>
                            <td>:</td>
                            <td><?php echo "$tujuan"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>DOKTER</td>
                            <td>:</td>
                            <td><?php echo "$dokter"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>POLIKLINIK</td>
                            <td>:</td>
                            <td><?php echo "$poliklinik"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>KELAS</td>
                            <td>:</td>
                            <td><?php echo "$kelas"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>RUANGAN</td>
                            <td>:</td>
                            <td><?php echo "$ruangan"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>BED/TT</td>
                            <td>:</td>
                            <td><?php echo "$id_kasur"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>DIAGNOSA AWAL</td>
                            <td>:</td>
                            <td><?php echo "$DiagAwal"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>ASAL RUJUKAN</td>
                            <td>:</td>
                            <td><?php echo "$rujukan_dari"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TUJUAN RUJUKAN</td>
                            <td>:</td>
                            <td><?php echo "$rujukan_ke"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>PEMBAYARAN</td>
                            <td>:</td>
                            <td><?php echo "$pembayaran"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>CARA KELUAR</td>
                            <td>:</td>
                            <td><?php echo "$cara_keluar"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TGL.KELUAR</td>
                            <td>:</td>
                            <td><?php echo "$tanggal_keluar"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>STATUS</td>
                            <td>:</td>
                            <td><?php echo "$status"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>PETUGAS</td>
                            <td>:</td>
                            <td><?php echo "$id_akses.$nama_petugas"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>UPDATETIME</td>
                            <td>:</td>
                            <td><?php echo "$updatetime"; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <?php
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer'))){
                    echo '<div class="alert alert-danger role="alert">';
                    echo '  <h4>Memerlukan Verifikasi Petugas Radiografer!</h4> Silahkan Lihat Detail Data Selengkapnya.';
                    echo '</div>';
                }else{
                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer'))){
                        echo '<div class="alert alert-danger role="alert">';
                        echo '  Memerlukan Verifikasi Petugas Radiografer! Silahkan Lihat Detail Data Selengkapnya.';
                        echo '</div>';
                    }else{
    
                    }
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <a href="index.php?Page=Radiologi&Sub=DetailRadiologi&id=<?php echo "$id_rad"; ?>" class="btn btn-md btn-primary btn-block">
                Lihat Selengkapnya <i class="ti ti-more"></i>
            </a>
        </div>
    </div>
<?php }} ?>