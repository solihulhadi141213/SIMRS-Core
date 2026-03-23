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
    if(empty($_POST['id_ruang_rawat'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Ruang Rawat Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_ruang_rawat=$_POST['id_ruang_rawat'];
        //Buka detail pengaturan
        $kelas=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_ruang_rawat,'kelas');
        $id_ruang_rawat_sirs=getDataDetail($Conn,'ruang_rawat_sirs','id_ruang_rawat',$id_ruang_rawat,'id_ruang_rawat_sirs');
        $id_tt=getDataDetail($Conn,'ruang_rawat_sirs','id_ruang_rawat',$id_ruang_rawat,'id_tt');
        $tt=getDataDetail($Conn,'ruang_rawat_sirs','id_ruang_rawat',$id_ruang_rawat,'tt');
?>
    <input type="hidden" name="id_ruang_rawat_sirs" value="<?php echo $id_ruang_rawat_sirs; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_ruang_rawat">ID Kelas</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_ruang_rawat" id="id_ruang_rawat" class="form-control" value="<?php echo $id_ruang_rawat; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kelas">Kelas</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="kelas" id="kelas" class="form-control" value="<?php echo $kelas; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_tt">ID TT (SIRS Online)</label>
        </div>
        <div class="col-md-8">
            <select name="id_tt" id="id_tt" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $response_referensi=DataTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                    if(!empty($response_referensi)){
                        $php_array = json_decode($response_referensi, true);
                        $ReferensiTt=$php_array['fasyankes'];
                        if(!empty(count($ReferensiTt))){
                            $no=1;
                            foreach ($ReferensiTt as $item) {
                                // Tambahkan setiap elemen ke dalam array PHP
                                $IdTtList= $item['id_tt'];
                                $ListTt= $item['tt'];
                                if($id_tt==$IdTtList){
                                    echo '<option selected value="'.$IdTtList.'.'.$ListTt.'">'.$ListTt.'</option>';
                                }else{
                                    echo '<option value="'.$IdTtList.'.'.$ListTt.'">'.$ListTt.'</option>';
                                }
                            }
                        }
                    }
                ?>
            </select>
        </div>
    </div>
<?php } ?>