<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_operasi
    if(empty($_POST['id_operasi'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          Data ID Antrian Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_operasi=$_POST['id_operasi'];
        $id_kunjungan=getDataDetail($Conn,'operasi','id_jadwal_operasi',$id_operasi,'id_kunjungan');
        if(empty($id_kunjungan)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 mb-3 text-center text-danger">';
            echo '         Belum ada laporan operasi untuk jadwal ini.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_jadwal_operasi=getDataDetail($Conn,'operasi','id_jadwal_operasi',$id_operasi,'id_jadwal_operasi');
            $id_kunjungan=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_kunjungan');
            $id_pasien=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_pasien');
            $id_akses=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_akses');
            $tanggal_entry=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'tanggal_entry');
            $tanggal_mulai=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'tanggal_mulai');
            $tanggal_selesai=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'tanggal_selesai');
            $petugas_entry=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'petugas_entry');
            $pelaksana=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'pelaksana');
            $diagnosa_operasi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'diagnosa_operasi');
            $body_site=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'body_site');
            $tindakan_operasi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'tindakan_operasi');
            $instrumen=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'instrumen');
            $keterangan_dokter=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'keterangan_dokter');
            $anastesi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'anastesi');
            $persetujuan=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'persetujuan');
            //Nama
            $nama_pasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
            //Format Tanggal
            $strtotime1=strtotime($tanggal_entry);
            $strtotime2=strtotime($tanggal_mulai);
            $strtotime3=strtotime($tanggal_selesai);
            $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
            $TanggalMulai=date('d/m/Y H:i T',$strtotime2);
            $TanggalSelesai=date('d/m/Y H:i T',$strtotime3);
            $_SESSION['UrlBackOperasi']="index.php?Page=JadwalOperasi&Sub=DetailJadwalOperasi&id=$id_operasi";
?>
    <div class="row"> 
        <div class="col-md-12">
            <?php
                echo '<ol>';
                echo '<li>No.RM : <code class="text-secondary">'.$id_pasien.'</code></li>';
                echo '<li>ID.Kunjungan : <code class="text-secondary" id="PutIdKunjunganOperasi">'.$id_kunjungan.'</code></li>';
                echo '<li>ID.Operasi : <code class="text-secondary">'.$id_operasi.'</code></li>';
                echo '<li>ID.Jadwal Operasi : <code class="text-secondary">'.$id_jadwal_operasi.'</code></li>';
                echo '<li>Nama Pasien : <code class="text-secondary">'.$nama_pasien.'</code></li>';
                echo '<li>Tgl/Jam Entry : <code class="text-secondary">'.$TanggalEntry.'</code></li>';
                echo '<li>Tgl/Jam Mulasi : <code class="text-secondary">'.$TanggalMulai.'</code></li>';
                echo '<li>Tgl/Jam Selesai : <code class="text-secondary">'.$TanggalSelesai.'</code></li>';
                echo '<li>Petugas Entry : <code class="text-secondary">'.$petugas_entry.'</code></li>';
                echo '</ol>';
            ?>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-12">
            Untuk mengelola data laporan operasi dilakukan pada halaman mandiri laporan operasi.
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-12">
            <a href="index.php?Page=RawatJalan&Sub=Operasi&ms_sub=PreviewOperasi&id=<?php echo $id_kunjungan;?>" class="btn btn-sm btn-outline-primary btn-round btn-block">
                <i class="ti ti-more-alt"></i> ke Halaman Operasi 
            </a>
        </div>
    </div>
<?php }} ?>