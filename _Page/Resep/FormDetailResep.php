<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Resep Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_resep=$_POST['id_resep'];
        $id_pasien=getDataDetail($Conn,'resep','id_resep',$id_resep,'id_pasien');
        $id_kunjungan=getDataDetail($Conn,'resep','id_resep',$id_resep,'id_kunjungan');
        $id_akses=getDataDetail($Conn,'resep','id_resep',$id_resep,'id_akses');
        $id_dokter=getDataDetail($Conn,'resep','id_resep',$id_resep,'id_dokter');
        $nama_pasien=getDataDetail($Conn,'resep','id_resep',$id_resep,'nama_pasien');
        $petugas_entry=getDataDetail($Conn,'resep','id_resep',$id_resep,'petugas_entry');
        $nama_dokter=getDataDetail($Conn,'resep','id_resep',$id_resep,'nama_dokter');
        $ttd_dokter=getDataDetail($Conn,'resep','id_resep',$id_resep,'ttd_dokter');
        $kontak_dokter=getDataDetail($Conn,'resep','id_resep',$id_resep,'kontak_dokter');
        $tanggal_entry=getDataDetail($Conn,'resep','id_resep',$id_resep,'tanggal_entry');
        $tanggal_resep=getDataDetail($Conn,'resep','id_resep',$id_resep,'tanggal_resep');
        $obat=getDataDetail($Conn,'resep','id_resep',$id_resep,'obat');
        $catatan=getDataDetail($Conn,'resep','id_resep',$id_resep,'catatan');
        $status=getDataDetail($Conn,'resep','id_resep',$id_resep,'status');
        $pengkajian=getDataDetail($Conn,'resep','id_resep',$id_resep,'pengkajian');
        //Decode pasien
        $Jsonpasien =json_decode($nama_pasien, true);
        $NamaPasien=$Jsonpasien['nama_pasien'];
        //Decode Kontak Dokter
        $JsonKontakDokter =json_decode($kontak_dokter, true);
        //Decode Obat
        $JsonObat =json_decode($obat, true);
        $JumlahItemObat=count($JsonObat);
        //Format Tanggal
        $strtotime= strtotime($tanggal_resep);
        $FormatTanggal= date('d/m/Y',$strtotime);
        //Routing Status
        if($status=="Pending"){
            $LabelStatus='<span class="text-warning">Pending</span>';
        }else{
            $LabelStatus='<span class="text-success">Selesai</span>';
        }
        //Routing Tanda Tangan
        if(empty($ttd_dokter)){
            $LabelTtdDokter='<span class="text-danger">Belum Ada</span>';
        }else{
            $LabelTtdDokter='<span class="text-success">Sudah Ada</span>';
        }
        //Routing Pengkajian
        if(empty($pengkajian)){
            $LabelPengkajian='<span class="text-danger">Belum Ada</span>';
        }else{
            $LabelPengkajian='<span class="text-success">Sudah Ada</span>';
        }
        echo '<div class="row">';
        echo '  <div class="col-md-12 sub-title">';
        echo '  <dt class="">A. Informasi Umum</dt>';
        echo '      <ol>';
        echo '          <li>No.RM : <code class="text-secondary">'.$id_pasien.'</code></li>';
        echo '          <li>No.Reg : <code class="text-secondary">'.$id_kunjungan.'</code></li>';
        echo '          <li>Nama pasien : <code class="text-secondary">'.$NamaPasien.'</code></li>';
        echo '          <li>Tanggal Resep : <code class="text-secondary">'.$FormatTanggal.'</code></li>';
        echo '          <li>Status : <code class="text-secondary">'.$LabelStatus.'</code></li>';
        echo '      </ol>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row">';
        echo '  <div class="col-md-12 sub-title">';
        echo '  <dt class="">B. Informasi Dokter</dt>';
        echo '      <ol>';
        echo '          <li>ID.Dokter : <code class="text-secondary">'.$id_dokter.'</code></li>';
        echo '          <li>Nama Dokter : <code class="text-secondary">'.$nama_dokter.'</code></li>';
        echo '          <li>Kontak : ';
        echo '              <ul>';
                            foreach($JsonKontakDokter as $ListKontakDokter){
                                $KategoriKontak=$ListKontakDokter['kategori_kontak'];
                                $NomorKontak=$ListKontakDokter['nomor_kontak'];
                                echo '<li>- '.$KategoriKontak.' : <code class="text-secondary">'.$NomorKontak.'</code></li>';
                            }
        echo '              </ul>';
        echo '          </li>';
        echo '          <li>Tanda Tangan Dokter : <code class="text-secondary">'.$LabelTtdDokter.'</code></li>';
        echo '          <li>Catatan Dokter : <code class="text-secondary">'.$catatan.'</code></li>';
        echo '      </ol>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row">';
        echo '  <div class="col-md-12 sub-title">';
        echo '      <dt class="">C. Informasi Resep</dt>';
        echo '      <ol>';
        echo '          <li>Item Obat : <code class="text-secondary">'.$JumlahItemObat.' Item</code></li>';
        echo '          <li>Pengkajian : <code class="text-secondary">'.$LabelPengkajian.'</code></li>';
        echo '      </ol>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <a href="index.php?Page=Resep&Sub=DetailResep&id='.$id_resep.'" class="btn btn-sm btn-block btn-round btn-outline-dark">';
        echo '          <i class="ti ti-info-alt"></i> Detail Resep';
        echo '      </a>';
        echo '  </div>';
        echo '</div>';
    }
?>