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
        $id_rad=getDataDetail($Conn,"radiologi",'id_kunjungan',$id_kunjungan,'id_rad');
        echo '<div class="row">';
        echo '  <div class="col col-md-12">';
        echo '      <button type="button" class="btn btn-block btn-sm btn-round btn-outline-primary mb-2" title="Kelola Radiologi" data-toggle="modal" data-target="#ModalPemeriksaanRadiologi" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-plus"></i> Pemeriksaan Radiologi';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        if(empty($id_rad)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Belum Ada Data Pemeriksaan Radiologi Untuk Kunjungan Ini';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT * FROM radiologi WHERE id_kunjungan='$id_kunjungan' ORDER BY id_rad ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_rad=$data['id_rad'];
                $waktu=$data['waktu'];
                $asal_kiriman=$data['asal_kiriman'];
                $permintaan_pemeriksaan=$data['permintaan_pemeriksaan'];
                $alat_pemeriksa=$data['alat_pemeriksa'];
                $status_pemeriksaan=$data['status_pemeriksaan'];
                $jenis_pembayaran=$data['jenis_pembayaran'];
                $dokter_pengirim=$data['dokter_pengirim'];
                $dokter_penerima=$data['dokter_penerima'];
                $radiografer=$data['radiografer'];
                $kesan=$data['kesan'];
                $klinis=$data['klinis'];
                $selesai=$data['selesai'];
                $kv=$data['kv'];
                $ma=$data['ma'];
                $sec=$data['sec'];
                //Format Tanggal
                $strtotime1=strtotime($waktu);
                $strtotime2=strtotime($selesai);
                $FormatTanggal=date('d/m/Y H:i T',$strtotime1);
                $FormatTanggalSelesai=date('d/m/Y H:i T',$strtotime2);
                //Apabila Radiografer kosong
                if(empty($radiografer)){
                    $radiografer='<span class="text-danger">Belum memperoleh verifikasi radiografer</span>';
                }else{
                    $radiografer=$data['radiografer'];
                }
                if(empty($kesan)){
                    $kesan='<span class="text-danger">Belum Ada</span>';
                }else{
                    $kesan=$data['kesan'];
                }
                if(empty($klinis)){
                    $klinis='<span class="text-danger">Belum Ada</span>';
                }else{
                    $klinis=$data['klinis'];
                }
                echo '<div class="row mt-2 mb-2">';
                echo '  <div class="col-md-12 sub-title">';
                echo '      Informasi Pendaftaran';
                echo '      <a href="javascript:void(0);" class="badge badge-primary" title="Informasi Lengkap Pemeriksaan Radiologi" data-toggle="modal" data-target="#ModalDetailPemeriksaanRadiologi" data-id="'.$id_rad.'">';
                echo '          <i class="ti ti-search"></i> Selengkapnya';
                echo '      </a>';
                echo '      <ol>';
                echo '          <li class="mb-2">ID.Rad : <code class="text-secondary">'.$id_rad.'</code></li>';
                echo '          <li class="mb-2">Tgl/Jam Mulai : <code class="text-secondary">'.$FormatTanggal.'</code></li>';
                echo '          <li class="mb-2">Tgl/Jam Selesai : <code class="text-secondary">'.$FormatTanggalSelesai.'</code></li>';
                echo '          <li class="mb-2">Asal Kiriman : <code class="text-secondary">'.$asal_kiriman.'</code></li>';
                echo '          <li class="mb-2">Alat Pemeriksa : <code class="text-secondary">'.$alat_pemeriksa.'</code></li>';
                echo '          <li class="mb-2">Metode Pembayaran : <code class="text-secondary">'.$jenis_pembayaran.'</code></li>';
                echo '          <li class="mb-2">Dokter Yang Mengirim : <code class="text-secondary">'.$dokter_pengirim.'</code></li>';
                echo '          <li class="mb-2">Permintaan Pemeriksaan : <code class="text-secondary">'.$permintaan_pemeriksaan.'</code></li>';
                echo '          <li class="mb-2">Dokter Yang Menerima : <code class="text-secondary">'.$dokter_penerima.'</code></li>';
                echo '          <li class="mb-2">Radiografer : <code class="text-secondary">'.$radiografer.'</code></li>';
                echo '          <li class="mb-2">Kesan : <code class="text-secondary">'.$kesan.'</code></li>';
                echo '          <li class="mb-2">Klinis : <code class="text-secondary">'.$klinis.'</code></li>';
                echo '          <li class="mb-2">KV : <code class="text-secondary">'.$kv.'</code></li>';
                echo '          <li class="mb-2">MA : <code class="text-secondary">'.$ma.'</code></li>';
                echo '          <li class="mb-2">SEC : <code class="text-secondary">'.$sec.'</code></li>';
                echo '          <li class="mb-2">Status : <code class="text-secondary">'.$status_pemeriksaan.'</code></li>';
                echo '      </ol>';
                echo '      Uraian Pemeriksaan';
                echo '      <ol>';
                            $IdRadiologi=getDataDetail($Conn,"radiologi_rincian",'id_rad',$id_rad,'id_rincian');
                            if(!empty($IdRadiologi)){
                                $query2 = mysqli_query($Conn, "SELECT * FROM radiologi_rincian WHERE id_rad='$id_rad' ORDER BY id_rincian ASC");
                                while ($data2 = mysqli_fetch_array($query2)) {
                                    $id_rincian=$data2['id_rincian'];
                                    $KategoriPemeriksaan=$data2['kategori'];
                                    $pemeriksaan=$data2['pemeriksaan'];
                                    $hasil=$data2['hasil'];
                                    $keterangan=$data2['keterangan'];
                                    echo '<li>';
                                    echo '  Pemeriksaan : <code class="text-secondary">'.$pemeriksaan.'</code>';
                                    echo '  <ol>';
                                    echo '      <li>ID Rincian: <code class="text-secondary">'.$id_rincian.'</code></li>';
                                    echo '      <li>Kategori: <code class="text-secondary">'.$KategoriPemeriksaan.'</code></li>';
                                    echo '      <li>Pemeriksaan: <code class="text-secondary">'.$pemeriksaan.'</code></li>';
                                    echo '      <li>Hasil: <code class="text-secondary">'.$hasil.'</code></li>';
                                    echo '      <li>Keterangan: <code class="text-secondary">'.$keterangan.'</code></li>';
                                    echo '  </ol>';
                                    echo '</li>';
                                }
                            }
                echo '      </ol>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>

