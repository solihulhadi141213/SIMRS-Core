<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    if(empty($_POST['id_kebutuhan'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Kebutuhan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kebutuhan=$_POST['id_kebutuhan'];
        $DataAlkes=DataAlkesSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
        if(empty($DataAlkes)){
            echo '<div class="row">';
            echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
            echo '      Tidak ada response dari service SIRS Online!';
            echo '  </div>';
            echo '</div>';
        }else{
            $php_array = json_decode($DataAlkes, true);
            $ListAlkes=$php_array['apd'];
            $JumlahData=count($ListAlkes);
            if(empty($JumlahData)){
                echo '<div class="row">';
                echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
                echo '      Tidak ada data alkes dari service SIRS Online!';
                echo '  </div>';
                echo '</div>';
                echo '<div class="row">';
                echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
                echo '      '.$DataAlkes.'';
                echo '  </div>';
                echo '</div>';
            }else{
                foreach ($ListAlkes as $item) {
                    // Tambahkan setiap elemen ke dalam array PHP
                    if($id_kebutuhan==$item['id_kebutuhan']){
                        $jumlah_diterima= $item['jumlah_diterima'];
                        $kebutuhan= $item['kebutuhan'];
                        $jumlah_eksisting= $item['jumlah_eksisting'];
                        $jumlah= $item['jumlah'];
                        $jumlah_diterima= $item['jumlah_diterima'];
                        $tglupdate= $item['tglupdate'];
?>
    <input type="hidden" name="id_kebutuhan" value="<?php echo "$id_kebutuhan"; ?>">
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            Apakah anda yakin akan menghapus data alkes ini?
        </div>
    </div>
<?php
                        }
                    }
                }
            }
        }
?>