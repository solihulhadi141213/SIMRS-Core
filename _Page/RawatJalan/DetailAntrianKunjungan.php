<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka Data Antrian Berdasarkan Kunjungan
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_antrian=getDataDetail($Conn,"antrian",'id_kunjungan',$id_kunjungan,'id_antrian');
        if(empty($id_antrian)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      <dt>Kunjungan Ini Tidak Memiliki Data Antrian!</dt>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <ol class="col-md-12">';
            echo '          <li>Apabila kunjungan ini sudah memiliki data antrian sebelumnya dan ingin menghubungkan kedua data tersebut silahkan ubah data kunjungan ini, kemudian isikan nomor antrian dan Id antrian.</li>';
            echo '          <li>Apabila sebelumnya belum dibuatkan data antrian sama sekali, silahkan buat data antrian melalui tautan <a href="index.php?Page=Antrian&Sub=TambahAntrian&id='.$id_pasien.'&id_kunjungan='.$id_kunjungan.'" class="text-primary">berikut ini <i class="ti ti-layers"></i></a>.</li>';
            echo '      </ol>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_kunjungan');
            $no_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_antrian');
            $kodebooking=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodebooking');
            $id_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_pasien');
            $nama_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_pasien');
            $nomorkartu=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nomorkartu');
            $nik=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nik');
            $notelp=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'notelp');
            $nomorreferensi=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nomorreferensi');
            $jenisreferensi=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jenisreferensi');
            $jenisrequest=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jenisrequest');
            $polieksekutif=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'polieksekutif');
            $tanggal_daftar=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_daftar');
            $tanggal_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_kunjungan');
            $jam_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_kunjungan');
            $jam_checkin=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_checkin');
            $kode_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kode_dokter');
            $nama_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_dokter');
            $kodepoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodepoli');
            $namapoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'namapoli');
            $kelas=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kelas');
            $keluhan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'keluhan');
            $pembayaran=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'pembayaran');
            $no_rujukan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_rujukan');
            $status=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'status');
            $sumber_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'sumber_antrian');
            $ws_bpjs=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'ws_bpjs');
            $ValidasiKelengkapanData="Valid";
            if(!empty($kodebooking)){
                $labelkodebooking='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailKodeBooking" data-id="'.$kodebooking.'">'.$id_kunjungan.' <i class="ti ti-layers"></i></a>';
            }else{
                $labelkodebooking='<span class="text-danger">Tidak Ada</span>';
            }
            if(empty($id_kunjungan)){
                $id_kunjungan='<span class="text-danger">Tidak Ada</span>';
            }
            if(!empty($tanggal_kunjungan)){
                $tanggal_kunjungan="$tanggal_kunjungan";
            }else{
                $tanggal_kunjungan='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($nama_pasien)){
                $nama_pasien="$nama_pasien";
            }else{
                $nama_pasien='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(empty($id_pasien)){
                $id_pasien='<span class="text-danger">Tidak Ada</span>';
            }
            if(empty($nik)){
                $nik='<span class="text-danger">Tidak Ada</span>';
            }
            if(empty($nomorkartu)){
                $nomorkartu='<span class="text-danger">Tidak Ada</span>';
            }
            if(!empty($notelp)){
                $notelp="$notelp";
            }else{
                $notelp='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($pembayaran)){
                $pembayaran="$pembayaran";
            }else{
                $pembayaran='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($namapoli)){
                $namapoli="$namapoli";
            }else{
                $namapoli='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($kodepoli)){
                $kodepoli="$kodepoli";
            }else{
                $kodepoli='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($nama_dokter)){
                $nama_dokter="$nama_dokter";
            }else{
                $nama_dokter='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($kode_dokter)){
                $kode_dokter="$kode_dokter";
            }else{
                $kode_dokter='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($jam_kunjungan)){
                $jam_kunjungan="$jam_kunjungan";
            }else{
                $jam_kunjungan='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($jenisreferensi)){
                if($jenisreferensi==1){
                    $labeljenisreferensi='<span class="text-dark">1. Rujukan FKTP</span>';
                }else{
                    if($jenisreferensi==2){
                        $labeljenisreferensi='<span class="text-dark">2. Rujukan Internal</span>';
                    }else{
                        if($jenisreferensi==3){
                            $labeljenisreferensi='<span class="text-dark">3. Kontrol</span>';
                        }else{
                            if($jenisreferensi==4){
                                $labeljenisreferensi='<span class="text-dark">4. Rujukan Antar RS</span>';
                            }else{
                                $labeljenisreferensi='<span class="text-danger">Tidak Diketahui</span>';
                            }
                        }
                    }
                }
                $jenisreferensi="$jenisreferensi";
            }else{
                $labeljenisreferensi='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(empty($nomorreferensi)){
                $LabelNomorReferensi='<span class="text-danger">Tidak Ada</span>';
            }else{
                $LabelNomorReferensi=$nomorreferensi;
            }
            if(!empty($sumber_antrian)){
                $sumber_antrian="$sumber_antrian";
            }else{
                $sumber_antrian='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($status)){
                $status="$status";
            }else{
                $status='<span class="text-danger">Tidak Diketahui</span>';
            }
            if(!empty($ws_bpjs)){
                if($ws_bpjs==1){
                    $ws_bpjs='<span class="text-success">Terdaftar</span>';
                }else{
                    $ws_bpjs='<span class="text-dark">Tidak Terdaftar</span>';
                }
                $ws_bpjs="$ws_bpjs";
            }else{
                $ws_bpjs='<span class="text-danger">Tidak Diketahui</span>';
            }
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>a. ID Antrian</span></div>';
            echo '  <div class="col-md-8">'.$id_antrian.'</div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>b. Kode Booking</span></div>';
            echo '  <div class="col-md-8"><span>'.$labelkodebooking.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>c. No.Antrian</span></div>';
            echo '  <div class="col-md-8"><span id="GetNomorAntrian">A-'.$no_antrian.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>d. ID Kunjungan</span></div>';
            echo '  <div class="col-md-8"><span>'.$id_kunjungan.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>e. Tanggal Kunjungan</span></div>';
            echo '  <div class="col-md-8"><span>'.$tanggal_kunjungan.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>f. Nama Pasien</span></div>';
            echo '  <div class="col-md-8"><span>'.$nama_pasien.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>g. No.RM</span></div>';
            echo '  <div class="col-md-8"><span>'.$id_pasien.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>h. NIK</span></div>';
            echo '  <div class="col-md-8"><span>'.$nik.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>i. No.Kartu BPJS</span></div>';
            echo '  <div class="col-md-8"><span>'.$nomorkartu.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>j. No.HP</span></div>';
            echo '  <div class="col-md-8"><span>'.$notelp.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>k. Peserta</span></div>';
            echo '  <div class="col-md-8"><span>'.$pembayaran.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>l. Poliklinik</span></div>';
            echo '  <div class="col-md-8"><span>'.$kodepoli.'-'.$namapoli.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>m. Dokter</span></div>';
            echo '  <div class="col-md-8"><span>'.$kode_dokter.'-'.$nama_dokter.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>n. Jam Praktek</span></div>';
            echo '  <div class="col-md-8"><span>'.$jam_kunjungan.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>o. Jenis Kunjungan</span></div>';
            echo '  <div class="col-md-8"><span>'.$labeljenisreferensi.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>p. No.Referensi</span></div>';
            echo '  <div class="col-md-8"><span>'.$LabelNomorReferensi.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>q. Sumber Data</span></div>';
            echo '  <div class="col-md-8"><span>'.$sumber_antrian.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>r. Status</span></div>';
            echo '  <div class="col-md-8"><span>'.$status.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-4"><span>s. WS BPJS</span></div>';
            echo '  <div class="col-md-8"><span>'.$ws_bpjs.'</span></div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <a href="index.php?Page=Antrian&Sub=DetailAntrian&id='.$id_antrian.'" class="btn btn-sm btn-block btn-outline-dark">';
            echo '          Selengkapnya <i class="ti ti-more"></i>';
            echo '      </a>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>