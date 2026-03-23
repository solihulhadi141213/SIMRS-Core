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
        $id_psikosos=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_psikosos');
        if(empty($id_psikosos)){
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahPsikosos" data-id="'.$id_kunjungan.'">';
            echo '          <i class="ti ti-plus"></i> Tambah Psikosos';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi Psikologi, Ekonomi dan Sosial untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuka Detail Triase Dan IGD
            $id_pasien=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_pasien');
            $id_akses=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_akses');
            $tanggal=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal');
            $nama_pasien=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'nama_pasien');
            $nama_petugas=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'nama_petugas');
            $tanggal_entry=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal_entry');
            $tanggal_wawancara=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal_wawancara');
            $psikologi=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'psikologi');
            $sosial=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'sosial');
            $spiritual=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'spiritual');
            //Decode JSON
            $JsonNamaPetugas =json_decode($nama_petugas, true);
            $JsonPsikologi =json_decode($psikologi, true);
            $JsonSosial =json_decode($sosial, true);
            $JsonSpiritual =json_decode($spiritual, true);
            //Format Tanggal
            $strtotime=strtotime($tanggal_entry);
            $FormatTanggal=date('d/m/Y H:i', $strtotime);
            $strtotime2=strtotime($tanggal_wawancara);
            $FormatTanggal_wawancara=date('d/m/Y H:i', $strtotime2);
            //Buka Petugas Entry
            if(!empty($JsonNamaPetugas['petugas_entry'])){
                $PetugasEntry=$JsonNamaPetugas['petugas_entry'];
            }else{
                $PetugasEntry="Tidak Ada";
            }
            //Buka penanya
            if(!empty($JsonNamaPetugas['penanya'])){
                $Penanya=$JsonNamaPetugas['penanya'];
            }else{
                $Penanya="Tidak Ada";
            }
            //Buka objek
            if(!empty($JsonNamaPetugas['objek'])){
                $objek=$JsonNamaPetugas['objek'];
            }else{
                $objek="Tidak Ada";
            }
            //Buka psikologi
            if(!empty($psikologi)){
                $status_psikologi=$JsonPsikologi['status_psikologi'];
                $keterangan_psikologi=$JsonPsikologi['keterangan_psikologi'];
            }else{
                $status_psikologi="Tidak Ada";
                $keterangan_psikologi="Tidak Ada";
            }
            //Buka sosial
            if(!empty($sosial)){
                $pendidikan=$JsonSosial['pendidikan'];
                $profesi=$JsonSosial['profesi'];
                $tempat_kerja=$JsonSosial['tempat_kerja'];
                $penghasilan=$JsonSosial['penghasilan'];
                $suku=$JsonSosial['suku'];
                $bahasa=$JsonSosial['bahasa'];
            }else{
                $pendidikan="Tidak Ada";
                $profesi="Tidak Ada";
                $tempat_kerja="Tidak Ada";
                $penghasilan="Tidak Ada";
                $suku="Tidak Ada";
                $bahasa="Tidak Ada";
            }
             //Buka spiritual
            if(!empty($spiritual)){
                $agama=$JsonSpiritual['agama'];
                $nilai=$JsonSpiritual['nilai'];
            }else{
                $agama="Tidak Ada";
                $nilai="Tidak Ada";
            }
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditPsikosos" data-id="'.$id_kunjungan.'" title="Ubah Anamnesis">';
            echo '          <i class="ti ti-pencil-alt"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusPsikosos" data-id="'.$id_kunjungan.'" title="Hapus Anamnesis">';
            echo '          <i class="ti ti-trash"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakPsikosos" data-id="'.$id_kunjungan.'" title="Cetak Lembar Anamnesis">';
            echo '          <i class="ti ti-printer"></i>';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body">';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">a. ID.Psikosos</div>';
            echo '          <div class="col col-md-6">'.$id_psikosos.'</div>';
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
            echo '          <div class="col col-md-6">'.$FormatTanggal.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">e. Tanggal/Waktu Wawancara</div>';
            echo '          <div class="col col-md-6">'.$FormatTanggal_wawancara.'</div>';
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
            echo '                  <div class="col col-md-5 text-muted">g.2. Penannya</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$Penanya.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.3. Objek</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$objek.'</div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">f. Psikologi</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">f.1. Status Psikologi</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$status_psikologi.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">f.2. Keterangan Psikologi</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$keterangan_psikologi.'</div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">g. Sosial</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.1. Pendidikan</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$pendidikan.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.2. Profesi</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$profesi.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.3. Tempat Bekerja</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$tempat_kerja.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.4. Penghasilan Keluarga</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$penghasilan.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.5. Suku</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$suku.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.6. Bahasa</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$bahasa.'</div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">h. Spiritual</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">h.1. Agama</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$agama.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">h.2. Spiritual</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$nilai.'</div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>