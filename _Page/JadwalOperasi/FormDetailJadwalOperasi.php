<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_operasi
    if(empty($_POST['id_operasi'])){
        $id_operasi=$_POST['id_operasi'];
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          Data ID Antrian Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_operasi=$_POST['id_operasi'];
        $id_pasien=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'id_pasien');
        $nama=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'nama');
        $nopeserta=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'nopeserta');
        $tanggal_daftar=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'tanggal_daftar');
        $jam_daftar=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jam_daftar');
        $tanggaloperasi=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'tanggaloperasi');
        $jamoperasi=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jamoperasi');
        $jenistindakan=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jenistindakan');
        $kodepoli=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'kodepoli');
        $namapoli=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'namapoli');
        $keterangan=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'keterangan');
        $terlaksana=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'terlaksana');
        $kodebooking=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'kodebooking');
        $lastupdate=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'lastupdate');
        //Format Waktu
        $TanggalWaktuDaftar="$tanggal_daftar $jam_daftar";
        $TanggalWaktuOperasi="$tanggaloperasi $jamoperasi";
        //Strtotime
        $strtotime1=strtotime($TanggalWaktuDaftar);
        $strtotime2=strtotime($TanggalWaktuOperasi);
        $strtotime3=strtotime($lastupdate);
        $TanggalWaktuDaftar=date('d/m/Y',$strtotime1);
        $TanggalWaktuOperasi=date('d/m/Y',$strtotime2);
        $LastUpdate=date('d/m/Y H:i',$strtotime3);
        //Routing Terlaksana
        if($terlaksana==1){
            $label_terlaksana='<code class="text-success">Terlaksana</code>';
        }else{
            $label_terlaksana='<code class="text-danger">Belum/Tidak Terlaksana</code>';
        }
        //Buka Data Lampiran
        $IdRincianLaporanOperasi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_operasi');
        if(empty($IdRincianLaporanOperasi)){
            $LabelRincianOperasi='<code class="text-danger">Laporan Tidak Tersedia</code>';
        }else{
            $LabelRincianOperasi='<code class="text-success">Laporan Tersedia</code>';
        }
?>
    <div class="row"> 
        <div class="col-md-12">
            <ol>
                <li class="mb-3">ID.Operasi : <code class="text-dark"><?php echo "$id_operasi"; ?></code></li>
                <li class="mb-3">Kode Booking : <code class="text-dark"><?php echo "$kodebooking"; ?></code></li>
                <li class="mb-3">No.RM : <code class="text-dark"><?php echo "$id_pasien"; ?></code></li>
                <li class="mb-3">Nama Pasien : <code class="text-dark"><?php echo "$nama"; ?></code></li>
                <li class="mb-3">No.BPJS : <code class="text-dark"><?php echo "$nopeserta"; ?></code></li>
                <li class="mb-3">Tgl.Daftar : <code class="text-dark"><?php echo "$TanggalWaktuDaftar"; ?></code></li>
                <li class="mb-3">Tgl.Operasi : <code class="text-dark"><?php echo "$TanggalWaktuOperasi"; ?></code></li>
                <li class="mb-3">Updatetime : <code class="text-dark"><?php echo "$LastUpdate"; ?></code></li>
                <li class="mb-3">Jenis Tindakan : <code class="text-dark"><?php echo "$jenistindakan"; ?></code></li>
                <li class="mb-3">Kode Poli : <code class="text-dark"><?php echo "$kodepoli"; ?></code></li>
                <li class="mb-3">Nama Poli : <code class="text-dark"><?php echo "$namapoli"; ?></code></li>
                <li class="mb-3">Keterangan : <code class="text-dark"><?php echo "$keterangan"; ?></code></li>
                <li class="mb-3">Terlaksana : <?php echo "$label_terlaksana"; ?></li>
                <li class="mb-3">Laporan : <?php echo "$LabelRincianOperasi"; ?></li>
            </ol>
        </div>
    </div>
    <div class="row mb-2"> 
        <div class="col-md-12">
            <a href="index.php?Page=JadwalOperasi&Sub=DetailJadwalOperasi&id=<?php echo $id_operasi;?>" class="btn btn-sm btn-outline-primary btn-round btn-block">
                <i class="ti ti-more-alt"></i> Selengkapnya 
            </a>
        </div>
    </div>
<?php } ?>