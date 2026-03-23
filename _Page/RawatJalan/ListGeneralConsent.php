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
        $JumlahGeneralConsent=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM general_consent WHERE id_kunjungan='$id_kunjungan'"));
        if(empty($JumlahGeneralConsent)){
            echo '  <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahGeneralConsent" data-id="'.$id_kunjungan.'">';
            echo '      <i class="ti ti-plus"></i> Tambah General Consent';
            echo '  </button>';
        }else{
            //Membuka Detail General Consent
            $id_kunjungan=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_kunjungan');
            $id_pasien=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_pasien');
            $id_akses=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_akses');
            $id_general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_general_consent');
            $tanggal=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'tanggal');
            $nama_pasien=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_pasien');
            $nama_petugas=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_petugas');
            $penanggung_jawab=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'penanggung_jawab');
            $general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'general_consent');
            //Decode JSON
            $JsonPetugas =json_decode($nama_petugas, true);
            $JsonPenanggungJawab =json_decode($penanggung_jawab, true);
            $JsonGeneralConsent =json_decode($general_consent, true);
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $FormatTanggal=date('d/m/Y H:i', $strtotime);
            //Buka Petugas
            $NamaPetugas=$JsonPetugas['nama'];
            $NikPetugas=$JsonPetugas['nik'];
            $KontakPetugas=$JsonPetugas['kontak'];
            $AlamatPetugas=$JsonPetugas['alamat'];
            //Buka Penanggung Jawab
            $NamaPenanggungJawab=$JsonPenanggungJawab['nama'];
            $NikPenanggungJawab=$JsonPenanggungJawab['nik'];
            $KontakPenanggungJawab=$JsonPenanggungJawab['kontak'];
            $AlamatPenanggungJawab=$JsonPenanggungJawab['alamat'];
            if(empty($JsonPenanggungJawab['ttd'])){
                $TtdPenanggungJawab='<i class="text-danger">Belum Ada</i>';
            }else{
                $TtdPenanggungJawab='<i class="text-success">Tervalidasi</i>';
            }
            //Buka General Consent
            $pernyataan_1=$JsonGeneralConsent['pernyataan_1'];
            $pernyataan_2=$JsonGeneralConsent['pernyataan_2'];
            $pernyataan_3=$JsonGeneralConsent['pernyataan_3'];
            $pernyataan_4=$JsonGeneralConsent['pernyataan_4'];
            $pernyataan_5=$JsonGeneralConsent['pernyataan_5'];
            $pernyataan_6=$JsonGeneralConsent['pernyataan_6'];
            $pernyataan_7=$JsonGeneralConsent['pernyataan_7'];
            $pernyataan_8=$JsonGeneralConsent['pernyataan_8'];
            $pernyataan_9=$JsonGeneralConsent['pernyataan_9'];
            $pernyataan_10=$JsonGeneralConsent['pernyataan_10'];
            
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditGeneralConsent" data-id="'.$id_kunjungan.'" title="Ubah Informasi Dasar General Consent">';
            echo '          <i class="ti ti-pencil-alt"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusGeneralConsent" data-id="'.$id_kunjungan.'" title="Hapus Data General Consent">';
            echo '          <i class="ti ti-trash"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakGeneralConsent" data-id="'.$id_kunjungan.'" title="Cetak Lembar General Consent">';
            echo '          <i class="ti ti-printer"></i>';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body">';
            echo '      <div class="row mb-3">';
            echo '          <div class="col col-md-6">a. ID General Consent</div>';
            echo '          <div class="col col-md-6">'.$id_general_consent.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-3">';
            echo '          <div class="col col-md-6">b. ID Kunjungan</div>';
            echo '          <div class="col col-md-6">'.$id_kunjungan.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-3">';
            echo '          <div class="col col-md-6">c. No.RM</div>';
            echo '          <div class="col col-md-6">'.$id_pasien.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-3">';
            echo '          <div class="col col-md-6">d. Nama Pasien</div>';
            echo '          <div class="col col-md-6">'.$nama_pasien.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-3">';
            echo '          <div class="col col-md-6">e. Tanggal</div>';
            echo '          <div class="col col-md-6">'.$FormatTanggal.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-2">';
            echo '          <div class="col col-md-6">f. Penanggung Jawab</div>';
            echo '          <div class="col col-md-6"></div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">f.1. Nama</div>';
            echo '          <div class="col col-md-6 mb-2">'.$NamaPenanggungJawab.'</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">f.2. NIK</div>';
            echo '          <div class="col col-md-6 mb-2">'.$NikPenanggungJawab.'</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">f.3. Kontak</div>';
            echo '          <div class="col col-md-6 mb-2">'.$KontakPenanggungJawab.'</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">f.4. Alamat</div>';
            echo '          <div class="col col-md-6 mb-2">'.$AlamatPenanggungJawab.'</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">f.5. Tanda Tangan</div>';
            echo '          <div class="col col-md-6 mb-2">';
            if(empty($JsonPenanggungJawab['ttd'])){
                echo '          <a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalTandaTanganGeneralConsent" data-id="Penanggung Jawab,'.$id_kunjungan.'">';
                echo '              <i><i class="ti ti-pencil"></i> Tanda Tangan Sekarang</i>';
                echo '          </a>';
            }else{
                echo '          <span class="text-success"><i class="ti ti-check"></i> Sudah Ditandatangan</span>';
            }
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mt-3">';
            echo '          <div class="col col-md-6 mb-2">g. Petugas/Saksi RS</div>';
            echo '          <div class="col col-md-6 mb-2"></div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">g.1. Nama</div>';
            echo '          <div class="col col-md-6 mb-2">'.$NamaPetugas.'</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">g.2. NIK</div>';
            echo '          <div class="col col-md-6 mb-2">'.$NikPetugas.'</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">g.3. Kontak</div>';
            echo '          <div class="col col-md-6 mb-2">'.$KontakPetugas.'</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">g.4. Alamat</div>';
            echo '          <div class="col col-md-6 mb-2">'.$AlamatPetugas.'</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 mb-2">g.5. Tanda Tangan</div>';
            echo '          <div class="col col-md-6 mb-2">';
            if(empty($JsonPetugas['ttd'])){
                echo '          <a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalTandaTanganGeneralConsent" data-id="Petugas,'.$id_kunjungan.'">';
                echo '              <i><i class="ti ti-pencil"></i> Tanda Tangan Sekarang</i>';
                echo '          </a>';
            }else{
                echo '          <span class="text-success"><i class="ti ti-check"></i> Sudah Ditandatangan</span>';
            }
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mt-3">';
            echo '          <div class="col col-md-6 mb-2">h. General Consent</div>';
            echo '          <div class="col col-md-6 mb-2"></div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-12 mb-2">h.1. Pernyataan Penanggung Jawab</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-12 mb-2">';
            echo '              <ol>';
            echo '                  <li>Pernyataan pasien yang menyatakan persetujuan atau tidak atas pelayanan RS ('.$pernyataan_1.')</li>';
            echo '                  <li>Penjelasan dari petugas RS mengenai ketentuan pembayaran pelayanan RS. ('.$pernyataan_2.')</li>';
            echo '                  <li>Penjelasan dari petugas RS mengenai hak dan kewajiban pasien ('.$pernyataan_3.')</li>';
            echo '                  <li>Penjelasan dari petugas RS mengenai tata tertib RS ('.$pernyataan_4.')</li>';
            echo '                  <li>Penjelasan dari petugas RS mengenai kebutuhan akan penterjemah bahasa ('.$pernyataan_5.')</li>';
            echo '                  <li>Penjelasan dari petugas RS mengenai kebutuhan akan rohaniawan ('.$pernyataan_6.')</li>';
            echo '                  <li>Penjelasan dari petugas RS mengenai konsekuensi pelepasan informasi terkait data-data pasien ('.$pernyataan_7.')</li>';
            echo '                  <li>Hasil pembacaan dari hasil pemeriksaan penunjang yang diberikan kepada pihak penjamin ('.$pernyataan_8.')</li>';
            echo '                  <li>Hasil pemeriksaan penunjang yang dapat diinformasikan/diakses kepada peserta didik ('.$pernyataan_9.')</li>';
            echo '                  <li>Persetujuan terkait dengan informasi pasien yang diberikan kepada fasyankes yang akan dituju ('.$pernyataan_10.')</li>';
            echo '              </ol>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-12 mb-2">h.2. Privasi</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-12 mb-2">Menampilkan data pihak keluarga/pengunjung yang diperbolehkan/tidak diperbolehkan menjenguk pasien.</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-12 mb-2">';
            echo '              <a href="javascript:void(0);" class="btn btn-sm btn-block btn-outline-dark" data-toggle="modal" data-target="#ModalTambahPrivasi" data-id="'.$id_kunjungan.'">';
            echo '                  <i class="ti ti-plus"></i> Tambah Data Privasi';
            echo '              </a>';
            echo '          </div>';
            echo '      </div>';
            if(!empty($JsonGeneralConsent['privasi'])){
                $PrivasiList=$JsonGeneralConsent['privasi'];
                echo '  <div class="row mb-3">';
                echo '      <div class="col col-md-12">';
                echo '          <ol>';
                $JumlahPrivasi=count($PrivasiList);
                $no=1;
                foreach ($JsonGeneralConsent['privasi'] as $row){
                    $id_privasi=$row["id_privasi"];
                    $namaPengunjung=$row["nama"];
                    echo '  <li class="mb-3">';
                    echo '      '.$no.'. '.$namaPengunjung.'';
                    echo '      <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalEditPrivasi" data-id="'.$id_privasi.','.$id_kunjungan.'" title="Edit Data Privasi General Consent"><i class="ti ti-pencil"></i></a>';
                    echo '      <a href="javascript:void(0);" class="badge badge-danger" data-toggle="modal" data-target="#ModalHapusPrivasi" data-id="'.$id_privasi.','.$id_kunjungan.'" title="Hapus Data Privasi General Consent"><i class="ti ti-close"></i></a>';
                    echo '      <table>';
                    echo "          <tr>";
                    echo "              <td>ID</td>";
                    echo "              <td>:</td>";
                    echo "              <td>$id_privasi</td>";
                    echo "          </tr>";
                    echo "          <tr>";
                    echo "              <td>Nama</td>";
                    echo "              <td>:</td>";
                    echo "              <td>$namaPengunjung</td>";
                    echo "          </tr>";
                    if(!empty($row["nik"])){
                        $nikPengunjung=$row["nik"];
                        echo "<tr>";
                        echo "  <td>NIK</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$nikPengunjung</td>";
                        echo "</tr>";
                    }
                    if(!empty($row["kontak"])){
                        $kontakPengunjung=$row["kontak"];
                        echo "<tr>";
                        echo "  <td>Kontak</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$kontakPengunjung</td>";
                        echo "</tr>";
                    }
                    if(!empty($row["alamat"])){
                        $alamatPengunjung=$row["alamat"];
                        echo "<tr>";
                        echo "  <td>Alamat</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$alamatPengunjung</td>";
                        echo "</tr>";
                    }
                    if(!empty($row["keterangan"])){
                        $KeteranganPengunjung=$row["keterangan"];
                        echo "<tr>";
                        echo "  <td>Keterangan</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$KeteranganPengunjung</td>";
                        echo "</tr>";
                    }
                    if(!empty($row["status"])){
                        $statusPengunjung=$row["status"];
                        if($statusPengunjung=="Diizinkan"){
                            $LabelStatus='<span class="label label-inverse-success"><i class="ti ti-check-box"></i> Diizinkan</span>';
                        }else{
                            $LabelStatus='<span class="label label-inverse-danger"><i class="ti ti-close"></i> Tidak Diizinkan</span>';
                        }
                        echo "<tr>";
                        echo "  <td>Status</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$LabelStatus</td>";
                        echo "</tr>";
                    }
                    echo '      </table>';
                    echo '  </li>';
                    $no++;
                }
                echo '          </ol>';
                echo '      </div>';
                echo '  </div>';
            }
            echo '      <div class="row">';
            echo '          <div class="col col-md-12 mb-2">h.3. Pihak Lain Yang Berhask Atas Informasi Pasien</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-12 mb-2">Menampilkan data pihak keluarga/pengunjung yang memperoleh ijin mendapatkan akses informasi pasien.</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-12 mb-2">';
            echo '              <a href="javascript:void(0);" class="btn btn-sm btn-block btn-outline-dark" data-toggle="modal" data-target="#ModalTambahPenerimaInformasi" data-id="'.$id_kunjungan.'">';
            echo '                  <i class="ti ti-plus"></i> Tambah Pihak Penerima Informasi';
            echo '              </a>';
            echo '          </div>';
            echo '      </div>';
            if(!empty($JsonGeneralConsent['pihak_lain'])){
                $pihak_lain=$JsonGeneralConsent['pihak_lain'];
                echo '  <div class="row mb-3">';
                echo '      <div class="col col-md-12">';
                echo '          <ol>';
                $JumlahPihakLain=count($pihak_lain);
                $no=1;
                foreach ($JsonGeneralConsent['pihak_lain'] as $row2){
                    $id=$row2["id"];
                    $NamaPihakLain=$row2["nama"];
                    echo '  <li class="mb-3">';
                    echo '      '.$no.'. '.$NamaPihakLain.'';
                    echo '      <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalEditPenerimaInformasi" data-id="'.$id.','.$id_kunjungan.'" title="Edit Data Penerima Informasi Pasien"><i class="ti ti-pencil"></i></a>';
                    echo '      <a href="javascript:void(0);" class="badge badge-danger" data-toggle="modal" data-target="#ModalHapusPenerimaInformasi" data-id="'.$id.','.$id_kunjungan.'" title="Hapus Data Penerima Informasi Pasien"><i class="ti ti-close"></i></a>';
                    echo '      <table>';
                    echo "          <tr>";
                    echo "              <td>ID</td>";
                    echo "              <td>:</td>";
                    echo "              <td>$id</td>";
                    echo "          </tr>";
                    echo "          <tr>";
                    echo "              <td>Nama</td>";
                    echo "              <td>:</td>";
                    echo "              <td>$NamaPihakLain</td>";
                    echo "          </tr>";
                    if(!empty($row2["nik"])){
                        $nikPihakLain=$row2["nik"];
                        echo "<tr>";
                        echo "  <td>NIK</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$nikPihakLain</td>";
                        echo "</tr>";
                    }
                    if(!empty($row2["kontak"])){
                        $kontakPihakLain=$row2["kontak"];
                        echo "<tr>";
                        echo "  <td>Kontak</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$kontakPihakLain</td>";
                        echo "</tr>";
                    }
                    if(!empty($row2["alamat"])){
                        $alamatPihakLain=$row2["alamat"];
                        echo "<tr>";
                        echo "  <td>Alamat</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$alamatPihakLain</td>";
                        echo "</tr>";
                    }
                    if(!empty($row2["keterangan"])){
                        $KeteranganPihakLain=$row2["keterangan"];
                        echo "<tr>";
                        echo "  <td>Keterangan</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$KeteranganPihakLain</td>";
                        echo "</tr>";
                    }
                    if(!empty($row2["hubungan"])){
                        $hubungan=$row2["hubungan"];
                        echo "<tr>";
                        echo "  <td>Hubungan</td>";
                        echo "  <td>:</td>";
                        echo "  <td>$hubungan</td>";
                        echo "</tr>";
                    }
                    echo '      </table>';
                    echo '  </li>';
                    $no++;
                }
                echo '          </ol>';
                echo '      </div>';
                echo '  </div>';
            }
            echo '      <div class="row mt-3">';
            echo '          <div class="col col-md-12 mb-2">i. Tanda Tangan</div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col col-md-6 text-center">';
            echo '              <i>Petugas/Saksi RS</i><br>';
                                if(!empty($JsonPetugas['ttd'])){
                                    $TtdPetugas=$JsonPetugas['ttd'];
                                    $DecodeTtdPetugas=base64_decode($TtdPetugas);
                                    echo '<img src="data:image/gif;base64,'. $TtdPetugas .'" width="100%">';
                                }
            echo '          </div>';
            echo '          <div class="col col-md-6 text-center">';
            echo '              <i>Penanggung Jawab Pasien</i><br>';
                                if(!empty($JsonPenanggungJawab['ttd'])){
                                    $TtdPenanggungJawab=$JsonPenanggungJawab['ttd'];
                                    $DecodeTtdPenanggungJawab=base64_decode($TtdPenanggungJawab);
                                    echo '<img src="data:image/gif;base64,'. $TtdPenanggungJawab .'" width="100%">';
                                }
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>
<script>
    // script di dalam ini akan dijalankan pertama kali saat dokumen dimuat
    document.addEventListener('DOMContentLoaded', function () {
        resizeCanvas();
    })
    //script ini berfungsi untuk menyesuaikan tanda tangan dengan ukuran canvas
    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 5);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }
    var canvas = document.getElementById('anatomi-pad');
    context = canvas.getContext('2d');
    function make_base(){
        base_image = new Image();
        base_image.src = 'https://initu.id/wp-content/uploads/2017/09/Keajaiban-Anatomi-Tubuh-Manusia-Jika-Anda-Mengerti-Maka-Tidak-Layak-Sombong.jpg';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0);
        }
    }
    // warna dasar signaturepad
    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255, 255, 255)',
    });
    //saat tombol clear diklik maka akan menghilangkan seluruh tanda tangan
    document.getElementById('clear').addEventListener('click', function () {
        signaturePad.clear();
    });
    //saat tombol undo diklik maka akan mengembalikan tanda tangan sebelumnya
    document.getElementById('undo').addEventListener('click', function () {
        var data = signaturePad.toData();
        if (data) {
            data.pop(); // remove the last dot or line
            signaturePad.fromData(data);
        }
    });
    //saat tombol change color diklik maka akan merubah warna pena
    document.getElementById('change-color').addEventListener('click', function () {
        //jika warna pena biru maka buat menjadi hitam dan sebaliknya
        if(signaturePad.penColor == "rgba(0, 0, 255, 1)"){
            signaturePad.penColor = "rgba(0, 0, 0, 1)";
        }else{
            signaturePad.penColor = "rgba(0, 0, 255, 1)";
        }
    })
</script>