<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_bantuan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Bantuan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_bantuan=$_POST['id_bantuan'];
        $judul=getDataDetail($Conn,'bantuan','id_bantuan',$id_bantuan,'judul');
        $tanggal=getDataDetail($Conn,'bantuan','id_bantuan',$id_bantuan,'tanggal');
        $kategori=getDataDetail($Conn,'bantuan','id_bantuan',$id_bantuan,'kategori');
        $isi=getDataDetail($Conn,'bantuan','id_bantuan',$id_bantuan,'isi');
        $status=getDataDetail($Conn,'bantuan','id_bantuan',$id_bantuan,'status');
        //Format Tanggal
        $strtotime = strtotime($tanggal);
        $TanggalFormat=date('d/m/Y H:i',$strtotime);
        //Routing Status
        if(!empty($data['status'])){
            $status= $data['status'];
            if($status=="Terbit"){
                $LabelStatus='<span class="text-success"><i class="ti ti-check"></i> Terbit</span>';
            }else{
                if($status=="Draft"){
                    $LabelStatus='<span class="text-warning"><i class="ti ti-notepad"></i> Draft</span>';
                }else{
                    $LabelStatus='<span class="text-secondary">Tidak Diketahui</span>';
                }
            }
        }else{
            $LabelStatus='<span class="text-secondary">Tidak Diketahui</span>';
        }
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <dt>'.$judul.'</dt>';
        echo '      <small class="text-secondary"><i class="ti ti-calendar"></i> '.$TanggalFormat.'</small><br>';
        echo '      <small class="text-secondary"><i class="icofont-tag"></i> '.$kategori.'</small>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      '.$isi.'';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      Status : '.$LabelStatus.'';
        echo '  </div>';
        echo '</div>';
    }
?>