<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '<div class="row">';
        echo '  <div class="col col-md-6 text-center text-danger">';
        echo '      ID Resep Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id'])){
            echo '<div class="row">';
            echo '  <div class="col col-md-6 text-center text-danger">';
            echo '      ID List Obat Tidak Boleh Kosong!';
            echo '  </div>';
            echo '</div>';
        }else{
            $GetIdResep=$_POST['id_resep'];
            $GetId=$_POST['id'];
            $obat=getDataDetail($Conn,"resep",'id_resep',$GetIdResep,'obat');
            //Json Decode
            $JsonObat=json_decode($obat, true);
            if(empty($JsonObat)){
                echo '<div class="row">';
                echo '  <div class="col col-md-6 text-center text-danger">';
                echo '      Detail Resep Obat Tidak Ada!';
                echo '  </div>';
                echo '</div>';
            }else{
                $JumlahObat=count($JsonObat);
                for($i=0; $i<$JumlahObat; $i++){
                    if($GetId==$JsonObat[$i]['id']){
                        $id=$JsonObat[$i]['id'];
                        $id_obat=$JsonObat[$i]['id_obat'];
                        $nama_obat=$JsonObat[$i]['nama_obat'];
                        $bentuk_sediaan=$JsonObat[$i]['bentuk_sediaan'];
                        $jumlah_obat=$JsonObat[$i]['jumlah_obat'];
                        $metode=$JsonObat[$i]['metode'];
                        $dosis=$JsonObat[$i]['dosis'];
                        $unit=$JsonObat[$i]['unit'];
                        $frekuensi=$JsonObat[$i]['frekuensi'];
                        $aturan_tambahan=$JsonObat[$i]['aturan_tambahan'];
                    }
                }
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">ID</div>';
                echo '  <div class="col col-md-6">'.$id.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">ID.Obat</div>';
                echo '  <div class="col col-md-6">'.$id_obat.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">Nama Obat</div>';
                echo '  <div class="col col-md-6">'.$nama_obat.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">Bentuk Sediaan</div>';
                echo '  <div class="col col-md-6">'.$bentuk_sediaan.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">Jumlah Obat</div>';
                echo '  <div class="col col-md-6">'.$jumlah_obat.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">Metode</div>';
                echo '  <div class="col col-md-6">'.$metode.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">Dosis</div>';
                echo '  <div class="col col-md-6">'.$dosis.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">Unit</div>';
                echo '  <div class="col col-md-6">'.$unit.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">Frekuensi</div>';
                echo '  <div class="col col-md-6">'.$frekuensi.'</div>';
                echo '</div>';
                echo '<div class="row mb-2">';
                echo '  <div class="col col-md-6">Aturan Tambahan</div>';
                echo '  <div class="col col-md-6">'.$aturan_tambahan.'</div>';
                echo '</div>';
            }
        }
    }
?>