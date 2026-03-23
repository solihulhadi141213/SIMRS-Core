<?php
    //Cek apakah antrian tersebut terdaftar pada database SIMRS
    $QryAntrian = mysqli_query($Conn,"SELECT * FROM antrian WHERE kodebooking='$kodebooking' AND tanggal_kunjungan='$tanggal'")or die(mysqli_error($Conn));
    $DataAntrian = mysqli_fetch_array($QryAntrian);
    if(!empty($DataAntrian['id_antrian'])){
        $id_antrian= $DataAntrian['id_antrian'];
        if(!empty($DataAntrian['id_kunjungan'])){
            $id_kunjungan= $DataAntrian['id_kunjungan'];
            $LabelIdKunjungan='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalGetDetailKunjungan2" data-id="'.$id_kunjungan.'">'.$id_kunjungan.' <i class="ti ti-layers"></i></a>';
        }else{
            $id_kunjungan="";
            $LabelIdKunjungan='<span class="text-danger">ID Kunjungan Tidak Ada</span>';
        }
        $LabelIdAntrian='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailAntrian2" data-id="'.$id_antrian.'">'.$id_antrian.' <i class="ti ti-layers"></i></a>';
    }else{
        $id_antrian="";
        $LabelIdAntrian='<span class="text-danger">ID Antrian Tidak Ada</span>';
        $id_kunjungan="";
        $LabelIdKunjungan='<span class="text-danger">ID Kunjungan Tidak Ada</span>';
    }
    if(empty($norekammedis)){
        $LabelNoRm='<a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalBuatRm" data-id="'.$id_antrian.'"><i class="ti ti-plus"></i> Buat RM</a>';
    }else{
        $LabelNoRm='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalGetDetailPasien2" data-id="'.$norekammedis.'">'.$norekammedis.' <i class="ti ti-layers"></i></a>';
    }
    if(empty($nik)){
        $LabelNik='<span class="text-danger">Tidak Ada</span>';
    }else{
        $LabelNik='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailNik2" data-id="'.$nik.'">'.$nik.' <i class="ti ti-layers"></i></a>';
    }
    if(!empty($nokapst)){
        $nomorkartu='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailBpjs2" data-id="'.$nokapst.'">'.$nokapst.' <i class="ti ti-layers"></i></a>';
    }else{
        $nomorkartu='<span class="text-danger">Tidak Diketahui</span>';
    }
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>ID Antrian</dt></div>';
    echo '  <div class="col-md-8">'.$LabelIdAntrian.'</div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Kode Booking</dt></div>';
    echo '  <div class="col-md-8"><span>'.$kodebooking.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.Antrian</dt></div>';
    echo '  <div class="col-md-8"><span id="GetNomorAntrian">'.$noantrean.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>ID Kunjungan</dt></div>';
    echo '  <div class="col-md-8"><span>'.$LabelIdKunjungan.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Tanggal Kunjungan</dt></div>';
    echo '  <div class="col-md-8"><span>'.$tanggal.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Nama Pasien</dt></div>';
    echo '  <div class="col-md-8"><span>'.$LabelNama.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.RM</dt></div>';
    echo '  <div class="col-md-8"><span>'.$LabelNoRm.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>NIK</dt></div>';
    echo '  <div class="col-md-8"><span>'.$LabelNik.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.Kartu BPJS</dt></div>';
    echo '  <div class="col-md-8"><span>'.$nomorkartu.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.HP</dt></div>';
    echo '  <div class="col-md-8"><span>'.$nohp.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Peserta</dt></div>';
    echo '  <div class="col-md-8"><span>'.$LabelPeserta.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Poliklinik</dt></div>';
    echo '  <div class="col-md-8"><span>'.$kodepoli.'-'.$LabelPoli.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Dokter</dt></div>';
    echo '  <div class="col-md-8"><span>'.$kodedokter.'-'.$LabelDokter.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Jam Praktek</dt></div>';
    echo '  <div class="col-md-8"><span>'.$jampraktek.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Estimasi Dilayani</dt></div>';
    echo '  <div class="col-md-8"><span>'.$FormatEstimasiDilayani.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Jenis Kunjungan</dt></div>';
    echo '  <div class="col-md-8"><span>'.$LabelJenisKunjungan.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>No.Referensi</dt></div>';
    echo '  <div class="col-md-8"><span>'.$jeniskunjungan.'-'.$LabelNomorReferensi.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Sumber Data</dt></div>';
    echo '  <div class="col-md-8"><span>'.$sumberdata.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-4"><dt>Status</dt></div>';
    echo '  <div class="col-md-8"><span>'.$status.'</span></div>';
    echo '</div>';
    echo '<div class="row mb-3">';
    echo '  <div class="col-md-12"><dt>Task ID BPJS</dt></div>';
    echo '</div>';
    //Membuka Data Task ID
    $ResponseTaskId=TaskIdByKodeBooking($url_antrol,$consid,$secret_key,$user_key,$KodeBooking);
    $ambil_json =json_decode($ResponseTaskId, true);
    if(empty($ambil_json["response"])){
        $pesan=$ambil_json["metadata"]["message"];
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">Keterangan : '.$pesan.'</div>';
        echo '</div>';
    }else{
        $string=$ambil_json["response"];
        $metadata=$ambil_json["metadata"];
        $code=$metadata["code"];
        $message=$metadata["message"];
        $Terjemahkan=stringDecrypt($key, $string);
        $FileDekompresi=decompress("$Terjemahkan");
        $JsonData =json_decode($FileDekompresi, true);
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
?>