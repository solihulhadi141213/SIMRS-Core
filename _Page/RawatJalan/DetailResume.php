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
        $id_resume=getDataDetail($Conn,"resume",'id_kunjungan',$id_kunjungan,'id_resume');
        echo '<div class="row">';
        echo '  <div class="col col-md-12">';
        echo '      <button type="button" class="btn btn-block btn-sm btn-round btn-outline-primary mb-2" title="Buat Resume" data-toggle="modal" data-target="#ModalKonfirmasiBuatResume" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-layers"></i> Kelola Resume';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        if(empty($id_resume)){
            echo '<div class="row">';
            echo '  <div class="col col-md-12 text-center text-dange">';
            echo '       Belum ada Resume untuk kunjungan ini';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuka Data Resume
            $tanggal_entry=getDataDetail($Conn,"resume",'id_resume',$id_resume,'tanggal_entry');
            $tanggal_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'tanggal_pulang');
            $petugas=getDataDetail($Conn,"resume",'id_resume',$id_resume,'petugas');
            $dokter=getDataDetail($Conn,"resume",'id_resume',$id_resume,'dokter');
            $resume=getDataDetail($Conn,"resume",'id_resume',$id_resume,'resume');
            $pasca_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'pasca_pulang');
            $nasehat=getDataDetail($Conn,"resume",'id_resume',$id_resume,'nasehat');
            $evaluasi=getDataDetail($Conn,"resume",'id_resume',$id_resume,'evaluasi');
            $terapi_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'terapi_pulang');
            $rencana_kontrol=getDataDetail($Conn,"resume",'id_resume',$id_resume,'rencana_kontrol');
            $meninggal=getDataDetail($Conn,"resume",'id_resume',$id_resume,'meninggal');
            $pengaturan_lampiran=getDataDetail($Conn,"resume",'id_resume',$id_resume,'pengaturan_lampiran');
            //Format Tanggal
            $strtotime1=strtotime($tanggal_entry);
            $strtotime2=strtotime($tanggal_pulang);
            $TanggalEntry=date('d/m/Y H:i',$strtotime1);
            $TanggalPulang=date('d/m/Y H:i',$strtotime2);
            //Petugas
            if(!empty($petugas)){
                $JsonPetugas=json_decode($petugas, true);
                $NamaPetugas=$JsonPetugas['nama'];
                $KategoriPetugas=$JsonPetugas['kategori'];
                $KontakPetugas=$JsonPetugas['kontak'];
                $KategoriIdentitasPetugas=$JsonPetugas['kategori_identitas'];
                $NomorIdentitasPetugas=$JsonPetugas['no_identitas'];
                $TtdPetugas=$JsonPetugas['ttd'];
                if(empty($TtdPetugas)){
                    $LabelTtdPetugas='<span class="text-danger">Belum Ada <i class="ti ti-close"></i></span></>';
                }else{
                    $LabelTtdPetugas='<br><img src="data:image/gif;base64,'. $TtdPetugas .'" width="150px">';
                }
            }else{
                $NamaPetugas='<span class="text-danger">Tidak Ada</span>';
                $KategoriPetugas='<span class="text-danger">Tidak Ada</span>';
                $KontakPetugas='<span class="text-danger">Tidak Ada</span>';
                $KategoriIdentitasPetugas='<span class="text-danger">Tidak Ada</span>';
                $NomorIdentitasPetugas='<span class="text-danger">Tidak Ada</span>';
                $TtdPetugas='<span class="text-danger">Tidak Ada</span>';
                $LabelTtdPetugas='<span class="text-danger">Tidak Ada</span>';
            }
            //Dokter
            if(!empty($dokter)){
                $JsonDokter =json_decode($dokter, true);
                $NamaDokter=$JsonDokter['nama'];
                $SipDokter=$JsonDokter['SIP'];
                $KontakDokter=$JsonDokter['kontak'];
                $KategoriIdentitasDokter=$JsonDokter['kategori_identitas'];
                $NomorIdentitasDokter=$JsonDokter['no_identitas'];
                $TtdDokter=$JsonDokter['ttd'];
                if(empty($TtdDokter)){
                    $LabelTtdDokter='<span class="text-danger">Belum Ada <i class="ti ti-close"></i></span></>';
                }else{
                    $LabelTtdDokter='<br><img src="data:image/gif;base64,'. $TtdDokter .'" width="150px">';
                }
            }else{
                $NamaDokter='<span class="text-danger">Tidak Ada</span>';
                $SipDokter='<span class="text-danger">Tidak Ada</span>';
                $KontakDokter='<span class="text-danger">Tidak Ada</span>';
                $KategoriIdentitasDokter='<span class="text-danger">Tidak Ada</span>';
                $NomorIdentitasDokter='<span class="text-danger">Tidak Ada</span>';
                $TtdDokter='<span class="text-danger">Tidak Ada</span>';
                $LabelTtdDokter='<span class="text-danger">Tidak Ada</span>';
            }
            //Menampilkan Data
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <ol>';
            echo '          <li class="mb-2">ID.Kunjungan : <code class="text-secondary">'.$id_kunjungan.'</code></li>';
            echo '          <li class="mb-2">ID.Resume : <code class="text-secondary">'.$id_resume.'</code></li>';
            echo '          <li class="mb-2">Tgl/Jam Entry : <code class="text-secondary">'.$TanggalPulang.'</code></li>';
            echo '          <li class="mb-2">Tgl/Jam Pulang : <code class="text-secondary">'.$TanggalPulang.'</code></li>';
            echo '          <li class="mb-2">Nasehat : <code class="text-secondary">'.$nasehat.'</code></li>';
            echo '          <li class="mb-2">Evaluasi : <code class="text-secondary">'.$evaluasi.'</code></li>';
            echo '          <li class="mb-2">Terapi Pulang : <code class="text-secondary">'.$terapi_pulang.'</code></li>';
            echo '          <li class="mb-2">Resume : <code class="text-secondary">'.$resume.'</code></li>';
            echo '          <li class="mb-2">Pasca Pulang : <code class="text-secondary">'.$pasca_pulang.'</code></li>';
                            if(!empty($rencana_kontrol)){
                                $JsonRencanaKontrol =json_decode($rencana_kontrol, true);
                                $no_surat=$JsonRencanaKontrol['no_surat'];
                                $tanggal=$JsonRencanaKontrol['tanggal'];
                                $nama_poli=$JsonRencanaKontrol['nama_poli'];
                                $nama_dokter=$JsonRencanaKontrol['nama_dokter'];
                                $strtotime3=strtotime($tanggal);
                                $TanggalKontrol=date('d/m/Y',$strtotime3);
                                echo '<li class="mb-2">';
                                echo '  Rencana Kontrol';
                                echo '  <ul>';
                                echo '      <li>- No.Surat : <code class="text-secondary">'.$no_surat.'</code></li>';
                                echo '      <li>- Tgl.Kontrol : <code class="text-secondary">'.$TanggalKontrol.'</code></li>';
                                echo '      <li>- Nama Poli Tujuan : <code class="text-secondary">'.$nama_poli.'</code></li>';
                                echo '      <li>- Nama Dokter : <code class="text-secondary">'.$nama_dokter.'</code></li>';
                                echo '  </ul>';
                                echo '</li>';
                            }
                            if(!empty($meninggal)){
                                $JsonMeninggal =json_decode($meninggal, true);
                                $no_surat_meninggal=$JsonMeninggal['no_surat_meninggal'];
                                $tanggal_meninggal=$JsonMeninggal['tanggal_meninggal'];
                                $strtotime4=strtotime($tanggal_meninggal);
                                $tanggal_meninggal=date('d/m/Y H:i T',$strtotime4);
                                echo '<li class="mb-2">';
                                echo '  Keterangan Meninggal';
                                echo '  <ul>';
                                echo '      <li>- No.Surat : <code class="text-secondary">'.$no_surat_meninggal.'</code></li>';
                                echo '      <li>- Tgl/Jam.Meninggal : <code class="text-secondary">'.$tanggal_meninggal.'</code></li>';
                                echo '  </ul>';
                                echo '</li>';
                            }
                            if(!empty($pengaturan_lampiran)){
                                $JsonPengaturanLampiran =json_decode($pengaturan_lampiran, true);
                                echo '<li class="mb-2">';
                                echo '  Lampiran';
                                echo '  <ul>';
                                foreach($JsonPengaturanLampiran as $ListPengaturanLampiran){
                                    $Lampiran=$ListPengaturanLampiran['lampiran'];
                                    echo '<li>- <code class="text-secondary">'.$Lampiran.'</code></li>';
                                }
                                echo '  </ul>';
                                echo '</li>';
                            }
            echo '          <li class="mb-2">';
            echo '              Petugas Entry';
            echo '              <ul>';
            echo '                  <li>- Nama : <code class="text-secondary">'.$NamaPetugas.'</code></li>';
            echo '                  <li>- Kategori Petugas : <code class="text-secondary">'.$KategoriPetugas.'</code></li>';
            echo '                  <li>- Kontak : <code class="text-secondary">'.$KontakPetugas.'</code></li>';
            echo '                  <li>- Kategori Identitas : <code class="text-secondary">'.$KategoriIdentitasPetugas.'</code></li>';
            echo '                  <li>- Nomor Identitas : <code class="text-secondary">'.$NomorIdentitasPetugas.'</code></li>';
            echo '                  <li>- TTD : <code class="text-secondary">'.$LabelTtdPetugas.'</code></li>';
            echo '              </ul>';
            echo '          </li>';
            echo '          <li class="mb-2">';
            echo '              Dokter DPJP';
            echo '              <ul>';
            echo '                  <li>- Nama : <code class="text-secondary">'.$NamaDokter.'</code></li>';
            echo '                  <li>- SIP : <code class="text-secondary">'.$SipDokter.'</code></li>';
            echo '                  <li>- Kontak : <code class="text-secondary">'.$KontakDokter.'</code></li>';
            echo '                  <li>- Kategori Identitas : <code class="text-secondary">'.$KategoriIdentitasDokter.'</code></li>';
            echo '                  <li>- Nomor Identitas : <code class="text-secondary">'.$NomorIdentitasDokter.'</code></li>';
            echo '                  <li>- TTD : <code class="text-secondary">'.$LabelTtdDokter.'</code></li>';
            echo '              </ul>';
            echo '          </li>';
            echo '      </ol>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>

