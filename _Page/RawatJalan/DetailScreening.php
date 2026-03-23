<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="card">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_screening=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'id_screening');
        if(empty($id_screening)){
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahScreening" data-id="'.$id_kunjungan.'">';
            echo '          <i class="ti ti-plus"></i> Tambah Screening';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi Screening untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuka Detail Triase Dan IGD
            $id_pasien=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'id_pasien');
            $id_akses=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'id_akses');
            $nama_pasien=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'nama_pasien');
            $nama_petugas=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'nama_petugas');
            $tanggal_entry=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'tanggal_entry');
            $tanggal_periksa=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'tanggal_periksa');
            $decubitus=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'decubitus');
            $batuk=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'batuk');
            $gizi=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'gizi');
            //Decode JSON
            $JsonPetugas =json_decode($nama_petugas, true);
            $JsonDecubitus =json_decode($decubitus, true);
            $JsonBatuk =json_decode($batuk, true);
            $JsonGizi =json_decode($gizi, true);
            //Format Tanggal
            $strtotime=strtotime($tanggal_entry);
            $FormatTanggalEntry=date('d/m/Y H:i', $strtotime);
            $strtotime2=strtotime($tanggal_periksa);
            $FormatTanggalPeriksa=date('d/m/Y H:i', $strtotime2);
            //Buka Petugas Entry
            if(!empty($JsonPetugas['petugas_entry'])){
                $PetugasEntry=$JsonPetugas['petugas_entry'];
            }else{
                $PetugasEntry="Tidak Ada";
            }
            //Buka Pemeriksa
            if(!empty($JsonPetugas['pemeriksa'])){
                $pemeriksa=$JsonPetugas['pemeriksa'];
            }else{
                $pemeriksa="Tidak Ada";
            }
            //Buka dokter
            if(!empty($JsonPetugas['dokter'])){
                $dokter=$JsonPetugas['dokter'];
            }else{
                $dokter="Tidak Ada";
            }
            
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditScreening" data-id="'.$id_kunjungan.'" title="Ubah Anamnesis">';
            echo '          <i class="ti ti-pencil-alt"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusScreening" data-id="'.$id_kunjungan.'" title="Hapus Anamnesis">';
            echo '          <i class="ti ti-trash"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakScreening" data-id="'.$id_kunjungan.'" title="Cetak Lembar Anamnesis">';
            echo '          <i class="ti ti-printer"></i>';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body">';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">a. ID.Screening</div>';
            echo '          <div class="col col-md-6">'.$id_screening.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">b. ID Kunjungan</div>';
            echo '          <div class="col col-md-6">'.$id_kunjungan.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">c. No.RM</div>';
            echo '          <div class="col col-md-6">'.$id_pasien.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">d. Nama Pasien</div>';
            echo '          <div class="col col-md-6">'.$nama_pasien.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">e. Tanggal/Waktu Entry</div>';
            echo '          <div class="col col-md-6">'.$FormatTanggalEntry.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">e. Tanggal/Waktu Periksa</div>';
            echo '          <div class="col col-md-6">'.$FormatTanggalPeriksa.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">g. Petugas</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.1. Petugas Entry</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$PetugasEntry.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.2. Pemeriksa</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$pemeriksa.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.3. Dokter</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$dokter.'</div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">h. Risiko Luka Decubitus</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">h.1. Status</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$JsonDecubitus['status_decubitus'].'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">h.2. Keterangan</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$JsonDecubitus['keterangan_decubitus'].'</div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">i. Batuk</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <ol class="text-muted">';
            echo '                  <li>Riwayat demam ('.$JsonBatuk['batuk1'].')</li>';
            echo '                  <li>Berkeringat pada malam hari tanpa aktivitas ('.$JsonBatuk['batuk2'].')</li>';
            echo '                  <li>Riwayat berpergian dari daerah wabah ('.$JsonBatuk['batuk3'].')</li>';
            echo '                  <li>Riwayat pemakaian obat jangka panjang ('.$JsonBatuk['batuk4'].')</li>';
            echo '                  <li>Riwayat BB turun tanpa sebab yang diketahui ('.$JsonBatuk['batuk5'].')</li>';
            echo '              </ol>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">j. Gizi</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <ol class="text-muted">';
            echo '                  <li class="mb-3">'.$JsonGizi['gizi1']['label'].' ('.$JsonGizi['gizi1']['value'].')<br><small>Keterangan: '.$JsonGizi['gizi1']['keterangan'].' Kg</small></li>';
            echo '                  <li class="mb-3">'.$JsonGizi['gizi2']['label'].' ('.$JsonGizi['gizi2']['value'].')<br><small>Keterangan: '.$JsonGizi['gizi2']['keterangan'].'</small></li>';
            echo '                  <li class="mb-3">'.$JsonGizi['gizi3']['label'].' ('.$JsonGizi['gizi3']['value'].')<br><small>Keterangan: '.$JsonGizi['gizi3']['keterangan'].'</small></li>';
            echo '                  <li class="mb-3">'.$JsonGizi['gizi4']['label'].' ('.$JsonGizi['gizi4']['value'].')<br><small>Keterangan: '.$JsonGizi['gizi4']['keterangan'].'</small></li>';
            echo '                  <li class="mb-3">'.$JsonGizi['gizi5']['label'].' ('.$JsonGizi['gizi5']['value'].')<br><small>Keterangan: '.$JsonGizi['gizi5']['keterangan'].'</small></li>';
            echo '              </ol>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>