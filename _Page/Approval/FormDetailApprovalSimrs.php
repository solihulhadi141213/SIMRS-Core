<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['id_approval'])){
        echo '<span class="text-danger">ID Approval Tidak Boleh Kosong!</span>';
    }else{
        $id_approval=$_POST['id_approval'];
        //Buka Approval
        $id_akses=getDataDetail($Conn,'approval',"id_approval",$id_approval,'id_akses');
        $noKartu=getDataDetail($Conn,'approval',"id_approval",$id_approval,'noKartu');
        $tglSep=getDataDetail($Conn,'approval',"id_approval",$id_approval,'tglSep');
        $jnsPelayanan=getDataDetail($Conn,'approval',"id_approval",$id_approval,'jnsPelayanan');
        $jnsPengajuan=getDataDetail($Conn,'approval',"id_approval",$id_approval,'jnsPengajuan');
        $keterangan=getDataDetail($Conn,'approval',"id_approval",$id_approval,'keterangan');
        $user=getDataDetail($Conn,'approval',"id_approval",$id_approval,'user');
        $status=getDataDetail($Conn,'approval',"id_approval",$id_approval,'status');
        //Format Tanggal
        $strtotime=strtotime($tglSep);
        $TanggalFormat=date('d/m/Y',$strtotime);
        //Cari Data Pasien
        $id_pasien=getDataDetail($Conn,'pasien','no_bpjs',$noKartu,'id_pasien');
        if(empty($id_pasien)){
            $nama='<span class="text-danger">Pasien Tidak Terdaftar SIMRS</span>';
        }else{
            $nama=getDataDetail($Conn,'pasien','no_bpjs',$noKartu,'nama');
        }
        //Routing Jenis Pelayanan
        if($jnsPelayanan=="1"){
            $LabelPelayanan="Rawat Inap";
        }else{
            $LabelPelayanan="Rawat Jalan";
        }
        //Routing Status
        if($status=="Pengajuan"){
            $LabelStatus='<span class="badge badge-info">Pengajuan</span>';
        }else{
            if($status=="Pengajuan"){
                $LabelStatus='<span class="badge badge-info">Pengajuan</span>';
            }else{
                $LabelStatus='<span class="badge badge-success">Approval</span>';
            }
        }
        //Routing Jenis Pengajuan
        if($jnsPengajuan=="1"){
            $LabelPengajuan='<span class="text-primary">Pengajuan Backdate</span>';
        }else{
            $LabelPengajuan='<span class="text-success">Pengajuan finger print</span>';
        }
        echo '<ol>';
        echo '  <li>ID Approval : <code class="info-info">'.$id_approval.'</code></li>';
        echo '  <li>No.Kartu : <code class="text-info">'.$noKartu.'</code></li>';
        echo '  <li>Tgl.SEP : <code class="text-info">'.$TanggalFormat.'</code></li>';
        echo '  <li>Tgl Pelayanan : <code class="text-info">'.$LabelPelayanan.'</code></li>';
        echo '  <li>Jenis Pengajuan : <code class="text-info">'.$LabelPengajuan.'</code></li>';
        echo '  <li>Keterangan : <code class="text-info">'.$keterangan.'</code></li>';
        echo '  <li>Status : <code class="text-info">'.$LabelStatus.'</code></li>';
        echo '</ol>';
    }
?>