<?php
    if(!empty($kodebooking)){
        $labelkodebooking='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailKodeBooking" data-id="'.$kodebooking.'">'.$kodebooking.' <i class="ti ti-layers"></i></a>';
    }else{
        $labelkodebooking='<span class="text-danger">Tidak Ada</span>';
    }
    if(!empty($id_kunjungan)){
        $id_kunjungan='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalGetDetailKunjungan2" data-id="'.$kodebooking.'">'.$kodebooking.' <i class="ti ti-layers"></i></a>';
    }else{
        $id_kunjungan='<a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalTambahKeKunjungan" data-id="'.$id_antrian.'"><i class="ti ti-plus"></i> Tambah Kunjungan</a>';
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
    if(!empty($id_pasien)){
        $id_pasien='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalGetDetailPasien2" data-id="'.$id_pasien.'">'.$id_pasien.' <i class="ti ti-layers"></i></a>';
    }else{
        $id_pasien='<a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalBuatRm" data-id="'.$id_antrian.'"><i class="ti ti-plus"></i> Buat RM</a>';
    }
    if(!empty($nik)){
        $nik='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailNik2" data-id="'.$nik.'">'.$nik.' <i class="ti ti-layers"></i></a>';
    }else{
        $nik='<span class="text-danger">Tidak Diketahui</span>';
    }
    if(!empty($nomorkartu)){
        $nomorkartu='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailBpjs2" data-id="'.$nomorkartu.'">'.$nomorkartu.' <i class="ti ti-layers"></i></a>';
    }else{
        $nomorkartu='<span class="text-danger">Tidak Diketahui</span>';
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
    if(!empty($nomorreferensi)){
        $LabelNomorReferensi='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailReferensi" data-id="'.$jenisreferensi.','.$nomorreferensi.'">'.$nomorreferensi.' <i class="ti ti-layers"></i></a>';
    }else{
        $LabelNomorReferensi='<span class="text-danger">Tidak Ada</span>';
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
    echo '  <div class="col-md-4"><dt>ID Antrian</dt></div>';
    echo '  <div class="col-md-8">'.$id_antrian.'</div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Kode Booking</dt></div>';
    echo '  <div class="col-md-8"><span>'.$labelkodebooking.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.Antrian</dt></div>';
    echo '  <div class="col-md-8"><span id="GetNomorAntrian">A-'.$no_antrian.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>ID Kunjungan</dt></div>';
    echo '  <div class="col-md-8"><span>'.$id_kunjungan.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Tanggal Kunjungan</dt></div>';
    echo '  <div class="col-md-8"><span>'.$tanggal_kunjungan.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Nama Pasien</dt></div>';
    echo '  <div class="col-md-8"><span>'.$nama_pasien.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.RM</dt></div>';
    echo '  <div class="col-md-8"><span>'.$id_pasien.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>NIK</dt></div>';
    echo '  <div class="col-md-8"><span>'.$nik.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.Kartu BPJS</dt></div>';
    echo '  <div class="col-md-8"><span>'.$nomorkartu.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.HP</dt></div>';
    echo '  <div class="col-md-8"><span>'.$notelp.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Peserta</dt></div>';
    echo '  <div class="col-md-8"><span>'.$pembayaran.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Poliklinik</dt></div>';
    echo '  <div class="col-md-8"><span>'.$kodepoli.'-'.$namapoli.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Dokter</dt></div>';
    echo '  <div class="col-md-8"><span>'.$kode_dokter.'-'.$nama_dokter.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Jam Praktek</dt></div>';
    echo '  <div class="col-md-8"><span>'.$jam_kunjungan.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Jenis Kunjungan</dt></div>';
    echo '  <div class="col-md-8"><span>'.$labeljenisreferensi.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.Referensi</dt></div>';
    echo '  <div class="col-md-8"><span>'.$LabelNomorReferensi.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Sumber Data</dt></div>';
    echo '  <div class="col-md-8"><span>'.$sumber_antrian.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Status</dt></div>';
    echo '  <div class="col-md-8"><span>'.$status.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>WS BPJS</dt></div>';
    echo '  <div class="col-md-8"><span>'.$ws_bpjs.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-12"><dt>Task ID BPJS</dt></div>';
    echo '</div>';
    //Membuka Data Task ID
    $ResponseTaskId=TaskIdByKodeBooking($url_antrol,$consid,$secret_key,$user_key,$kodebooking);
    $ambil_json =json_decode($ResponseTaskId, true);
    if(empty($ambil_json["response"])){
        $pesan=$ambil_json["metadata"]["message"];
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">Keterangan : '.$pesan.'</div>';
        echo '</div>';
    }else{
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        $key="$consid$secret_key$timestamp";
        $string=$ambil_json["response"];
        $metadata=$ambil_json["metadata"];
        $code=$metadata["code"];
        $message=$metadata["message"];
        $Terjemahkan=stringDecrypt($key, $string);
        $FileDekompresi=decompress("$Terjemahkan");
        $JsonData =json_decode($FileDekompresi, true);
        if(empty($JsonData)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">Data Tidak Bisa Ditampilkan!</div>';
            echo '</div>';
        }else{
            if(empty(count($JsonData))){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">Data Tidak Bisa Ditampilkan!</div>';
                echo '</div>';
            }else{
                $JumlahTaskID=count($JsonData);
                //menampilkan Data
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12 table table-responsive">';
                echo '      <table class="table table-hover table-bordered">';
                echo '          <thead">';
                echo "              <tr>";
                echo '                  <th class="text-center" align="center"><dt>No</dt></th>';
                echo '                  <th class="text-center" align="center"><dt>Task ID</dt></th>';
                echo '                  <th class="text-center" align="center"><dt>Waktu RS</dt></th>';
                echo '                  <th class="text-center" align="center"><dt>Waktu BPJS</dt></th>';
                echo "              </tr>";
                echo '          </thead">';
                echo '          <tbody">';
                $no=1;
                for($a=0; $a<$JumlahTaskID; $a++){
                    $wakturs=$JsonData[$a]['wakturs'];
                    $waktu=$JsonData[$a]['waktu'];
                    $taskname=$JsonData[$a]['taskname'];
                    $taskid=$JsonData[$a]['taskid'];
                    $kodebooking=$JsonData[$a]['kodebooking'];
                    //Explode WaktuRs
                    $Explode1 = explode(" " , $wakturs);
                    $TanggalRs=$Explode1[0];
                    $JamRs=$Explode1[1];
                    $WibRs=$Explode1[2];
                    $StrtotimeTanggalRs=strtotime($TanggalRs);
                    $StrtotimeJamRs=strtotime($JamRs);
                    $FormatTanggalRs=date('d/m/Y',$StrtotimeTanggalRs);
                    $FormatJamRs=date('H:i:s',$StrtotimeJamRs);
                    //Explode WaktuBpjs
                    $Explode2 = explode(" " , $waktu);
                    $TanggalBpjs=$Explode2[0];
                    $JamBpjs=$Explode2[1];
                    $WibBpjs=$Explode2[2];
                    $StrtotimeTanggalBpjs=strtotime($TanggalBpjs);
                    $StrtotimeJamBpjs=strtotime($JamBpjs);
                    $FormatTanggalBpjs=date('d/m/Y',$StrtotimeTanggalBpjs);
                    $FormatJamBpjs=date('H:i:s',$StrtotimeJamBpjs);
                    //cek keberadaan data pada database lokal
                    $QryTaskId = mysqli_query($Conn,"SELECT * FROM antrian_task_id WHERE kodebooking='$kodebooking' AND wakturs='$wakturs' AND taskid='$taskid'")or die(mysqli_error($Conn));
                    $DataTaskId = mysqli_fetch_array($QryTaskId);
                    if(empty($DataTaskId['taskid'])){
                        //Apabila Data Task ID Belum Ada maka lakukan Insert Data
                        $EntryTaskId="INSERT INTO antrian_task_id (
                            taskid,
                            taskname,
                            kodebooking,
                            wakturs,
                            waktu,
                            keterangan
                        ) VALUES (
                            '$taskid',
                            '$taskname',
                            '$kodebooking',
                            '$wakturs',
                            '$waktu',
                            ''
                        )";
                        $InputTaskId=mysqli_query($Conn, $EntryTaskId);
                        if($InputTaskId){
                            $LabelStatusProses='<label class="text-success">Insert Berhasil</label>';
                        }else{
                            $LabelStatusProses='<label class="text-danger">Insert Gagal</label>';
                        }
                    }else{
                        //Apabila Data Task ID Sudah Ada maka lakukan Update Data
                        $UpdateTaskId = mysqli_query($Conn,"UPDATE antrian_task_id SET 
                            taskid='$taskid',
                            taskname='$taskname',
                            kodebooking='$kodebooking',
                            wakturs='$wakturs',
                            waktu='$waktu'
                        WHERE kodebooking='$kodebooking' AND taskid='$taskid'") or die(mysqli_error($Conn)); 
                        if($UpdateTaskId){
                            $LabelStatusProses='<label class="text-success">Update Berhasil</label>';
                        }else{
                            $LabelStatusProses='<label class="text-danger">Update Gagal</label>';
                        }
                    }
                    echo "<tr>";
                    echo '  <td class="text-center">'.$taskid.'</td>';
                    echo '  <td class="text-left">'.$taskname.'<br><small>'.$LabelStatusProses.'</small></td>';
                    echo '  <td class="text-left">'.$FormatTanggalRs.'<br><small>'.$FormatJamRs.' '.$WibRs.'</small></td>';
                    echo '  <td class="text-left">'.$FormatTanggalBpjs.'<br><small>'.$FormatJamBpjs.' '.$WibBpjs.'</small></td>';
                    echo "</tr>";
                    $no++;
                }
                echo '          </tbody">';
                echo '      </table>';
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>