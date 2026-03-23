<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_antrian
    if(empty($_POST['id_antrian'])){
        $id_antrian=$_POST['id_antrian'];
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Antrian Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $GetIdAntrian=$_POST['id_antrian'];
        //Buka data Antrian
        $id_antrian=getDataDetail($Conn,'antrian','id_antrian',$GetIdAntrian,'id_antrian');
        if(empty($id_antrian)){
            echo '  <div class="row">';
            echo '      <div class="col-md-6 mb-3">';
            echo '          ID Antrian Tidak Valid Atau Tidak Ditemukan Pada Database!';
            echo '      </div>';
            echo '  </div>';
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
            //Label
            if(empty($id_kunjungan)){
                $LabelIdKunjungan='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelIdKunjungan='<small class="text-dark">'.$id_kunjungan.'</small>';
            }
            if(empty($no_antrian)){
                $LabelNomorAntrian='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelNomorAntrian='<small class="text-dark">A-'.$no_antrian.'</small>';
            }
            if(empty($kodebooking)){
                $LabelKodeBooking='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelKodeBooking='<small class="text-dark">'.$kodebooking.'</small>';
            }
            if(empty($id_pasien)){
                $LabelIdPasien='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelIdPasien='<small class="text-dark">'.$id_pasien.'</small>';
            }
            if(empty($nama_pasien)){
                $LabelNama='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelNama='<small class="text-dark">'.$nama_pasien.'</small>';
            }
            if(empty($nomorkartu)){
                $LabelNomorKartu='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelNomorKartu='<small class="text-dark">'.$nomorkartu.'</small>';
            }
            if(empty($nik)){
                $Labelnik='<small class="text-danger">Tidak Ada</small>';
            }else{
                $Labelnik='<small class="text-dark">'.$nik.'</small>';
            }
            if(empty($notelp)){
                $Labelnotlp='<small class="text-danger">Tidak Ada</small>';
            }else{
                $Labelnotlp='<small class="text-dark">'.$notelp.'</small>';
            }
            if(empty($nomorreferensi)){
                $LabelReferensi='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelReferensi='<small class="text-dark">'.$nomorreferensi.'</small>';
            }
            if(empty($jenisreferensi)){
                $LabelJenisReferensi='<small class="text-danger">Tidak Ada</small>';
            }else{
                if($jenisreferensi=="1"){
                    $LabelJenisReferensi='<small class="text-dark">Rujukan FKTP</small>';
                }else{
                    if($jenisreferensi=="2"){
                        $LabelJenisReferensi='<small class="text-dark">Rujukan Internal</small>';
                    }else{
                        if($jenisreferensi=="3"){
                            $LabelJenisReferensi='<small class="text-dark">Kontrol</small>';
                        }else{
                            if($jenisreferensi=="4"){
                                $LabelJenisReferensi='<small class="text-dark">Rujukan Antar RS</small>';
                            }else{
                                $LabelJenisReferensi='<small class="text-dark">None</small>';
                            }
                        }
                    }
                }
            }
            if(empty($tanggal_daftar)){
                $LabelTanggalDaftar='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelTanggalDaftar='<small class="text-dark">'.$tanggal_daftar.'</small>';
            }
            if(empty($tanggal_kunjungan)){
                $LabelTanggalKunjungan='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelTanggalKunjungan='<small class="text-dark">'.$tanggal_kunjungan.'</small>';
            }
            if(empty($jam_kunjungan)){
                $LabeltanggalKunjungan='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabeltanggalKunjungan='<small class="text-dark">'.$jam_kunjungan.'</small>';
            }
            if(empty($namapoli)){
                $LabelNamaPoli='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelNamaPoli='<small class="text-dark">'.$namapoli.'</small>';
            }
            if(empty($kodepoli)){
                $LabelKodePoli='<small class="text-danger">None</small>';
            }else{
                $LabelKodePoli='<small class="text-dark">'.$kodepoli.'</small>';
            }
            if(empty($nama_dokter)){
                $LabelDokter='<small class="text-danger">None</small>';
            }else{
                $LabelDokter='<small class="text-dark">'.$nama_dokter.'</small>';
            }
            if(empty($keluhan)){
                $LabelKeluhan='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelKeluhan='<small class="text-dark">'.$keluhan.'</small>';
            }
            if(empty($pembayaran)){
                $LabelPembayaran='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelPembayaran='<small class="text-dark">'.$pembayaran.'</small>';
            }
            if($status=="Terdaftar"){
                $LabelStatus='<span class="text-info">Terdaftar</span>';
            }else{
                if($status=="Checkin"){
                    $LabelStatus='<span class="text-warning">Checkin</span>';
                }else{
                    if($status=="Batal"){
                        $LabelStatus='<span class="text-danger">Batal</span>';
                    }else{
                        if($status=="Selesai"){
                            $LabelStatus='<span class="text-success">Selesai</span>';
                        }else{
                            $LabelStatus='<span class="text-dark">None</span>';
                        }
                    }
                }
            }
            if(empty($sumber_antrian)){
                $LabelSumber='<small class="text-danger">Tidak Ada</small>';
            }else{
                $LabelSumber='<small class="text-dark">'.$sumber_antrian.'</small>';
            }
            if(empty($ws_bpjs)){
                $LabelWsBpjs='<small class="text-danger">Tidak Ada</small>';
            }else{
                if($ws_bpjs==0){
                    $LabelWsBpjs='<small class="text-dark">Tidak</small>';
                }else{
                    $LabelWsBpjs='<small class="text-dark">Ya</small>';
                }
            }
?>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Nomor Antrian</dt></div>
            <div class="col col-md-8"><?php echo "$LabelNomorAntrian"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Kode Booking</dt></div>
            <div class="col col-md-8"><?php echo $LabelKodeBooking; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>No.RM</dt></div>
            <div class="col col-md-8"><?php echo "$LabelIdPasien"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Nama Pasien</dt></div>
            <div class="col col-md-8"><?php echo "$LabelNama"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Nomor Kartu</dt></div>
            <div class="col col-md-8"><?php echo "$LabelNomorKartu"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>NIK</dt></div>
            <div class="col col-md-8"><?php echo "$Labelnik"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>No.HP</dt></div>
            <div class="col col-md-8"><?php echo "$Labelnotlp"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>ID Kunjungan</dt></div>
            <div class="col col-md-8"><?php echo "$LabelIdKunjungan"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Referensi</dt></div>
            <div class="col col-md-8"><?php echo "$LabelJenisReferensi"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>No.Referensi</dt></div>
            <div class="col col-md-8"><?php echo "$LabelReferensi"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Tanggal Daftar</dt></div>
            <div class="col col-md-8"><?php echo "$LabelTanggalDaftar"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Tanggal Kunjungan</dt></div>
            <div class="col col-md-8"><?php echo "$LabelTanggalKunjungan"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Jam Kunjungan</dt></div>
            <div class="col col-md-8"><?php echo "$LabeltanggalKunjungan"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Poliklinik</dt></div>
            <div class="col col-md-8"><?php echo "$LabelNamaPoli ($LabelKodePoli)"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Dokter</dt></div>
            <div class="col col-md-8"><?php echo "$LabelDokter"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Keluhan</dt></div>
            <div class="col col-md-8"><?php echo "$LabelKeluhan"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Pembayaran</dt></div>
            <div class="col col-md-8"><?php echo "$LabelPembayaran"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Status</dt></div>
            <div class="col col-md-8"><?php echo "$LabelStatus"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>Sumber Antrian</dt></div>
            <div class="col col-md-8"><?php echo "$LabelSumber"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4"><dt>WS BPJS</dt></div>
            <div class="col col-md-8"><?php echo "$LabelWsBpjs"; ?></div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-12">
                <a href="index.php?Page=Antrian&Sub=DetailAntrian&id=<?php echo "$id_antrian"; ?>" class="btn btn-sm btn-block btn-outline-dark">
                    Selengkapnya <i class="ti ti-more"></i>
                </a>
            </div>
        </div>
        <!-- <div class="btn-group dropdown-split-inverse">
            <button type="button" class="btn btn-md btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light mt-2 ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                Option
            </button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalTerdaftarAntrian">
                    <i class="ti-pencil"></i> Terdaftar
                </a>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalBatalAntrian">
                    <i class="ti ti-reload"></i> Batal
                </a>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusAntrian">
                    <i class="ti-trash"></i> Hapus
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalCheckinAntrian">
                    1. Checkin
                </a>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalPangglAntrian">
                    2. Panggil Antrian
                </a>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalTungguPoli">
                    3. Tungggu Poli
                </a>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalLayananPoli">
                    4. Layanan Poli
                </a>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalTungguFarmasi">
                    5. Tunggu Farmasi
                </a>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalLayananFarmasi">
                    6. Layanan Farmasi
                </a>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalLayananSelesai">
                    7. Selesai/Pulang
                </a>
                <div class="dropdown-divider"></div>
                <a href="index.php?Page=RawatJalan&Sub=TambahKunjungan&id=<?php echo $id_pasien;?>&antrian=<?php echo $no_antrian;?>&id_antrian=<?php echo $id_antrian;?>" class="dropdown-item waves-effect waves-light" >
                    <i class="icofont-maximize"></i> Daftarkan Kunjungan
                </a>
                <a href="_Page/Pendaftaran/CetakTiketAntrian.php?id_antrian=<?php echo $id_antrian;?>&antrian=<?php echo $no_antrian;?>&id_antrian=<?php echo $id_antrian;?>" class="dropdown-item waves-effect waves-light" target="_blank">
                    <i class="ti ti-printer"></i> Cetak Antrian
                </a>
            </div>
        </div> -->
<?php }} ?>