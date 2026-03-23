<?php
    if(empty($_POST['id_web_menu'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Sitemap Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_web_menu=$_POST['id_web_menu'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=urlService('Detail Footer Menu');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_menu' => $id_web_menu
        );
        $Metode="POST";
        $Response=GetResponseApis($url,$KirimData,$Metode);
        if(empty($Response)){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <span class="text-danger">Koneksi Dengan Web Bermasalah</span>';
            echo '  </div>';
            echo '</div>';
        }else{
            if(!empty($Response['metadata']['massage'])){
                $massage=$Response['metadata']['massage'];
            }else{
                $massage="";
            }
            if(!empty($Response['metadata']['code'])){
                $code=$Response['metadata']['code'];
            }else{
                $code="";
            }
            if($code!==200){
                echo '<div class="row">';
                echo '  <div class="col-md-12">';
                echo '      <span class="text-danger">'.$massage.'</span>';
                echo '  </div>';
                echo '</div>';
            }else{
                $kategori=$Response['response']['kategori'];
                $label=$Response['response']['label'];
                $GetUrl=$Response['response']['url'];
?>
    <input type="hidden" name="id_web_menu" id="id_web_menu" value="<?php echo $id_web_menu;?>">
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori" list="ListKategori" class="form-control" value="<?php echo $kategori;?>">
            <datalist id="ListKategori">
                <?php
                    $url=urlService('List Kategori');
                    $KirimData = array(
                        'api_key' => $api_key
                    );
                    $Response=GetResponseApis($url,$KirimData,$Metode);
                    if(!empty($Response)){
                        $JsonData =$Response;
                        if(!empty($JsonData['metadata']['massage'])){
                            $massage=$JsonData['metadata']['massage'];
                        }else{
                            $massage="";
                        }
                        if(!empty($JsonData['metadata']['code'])){
                            $code=$JsonData['metadata']['code'];
                        }else{
                            $code="";
                        }
                        if($code==200){
                            $List=count($JsonData['response']['list']);
                            if(!empty($List)){
                                $GetListKategori=$JsonData['response']['list'];
                                foreach ($GetListKategori as $value){
                                    $Kategori=$value['kategori'];
                                    echo '<option value="'.$Kategori.'">';
                                }
                            }
                        }
                    }
                ?>
            </datalist>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="label">Label</label>
            <input type="text" name="label" id="label" class="form-control" value="<?php echo $label;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="url">URL/Link</label>
            <input type="text" name="url" id="url" class="form-control" value="<?php echo $GetUrl;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3" id="NotifikasiEditFooterMenu">
            <span class="text-primary">
                Pastikan data Medsos sudah benar.
            </span>
        </div>
    </div>
<?php }}}?>