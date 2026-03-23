<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['tanggal'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Tanggal Stok Opename Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_obat_storage'])){
            $id_obat_storage="0";
        }else{
            $id_obat_storage=$_POST['id_obat_storage'];
        }
        $tanggal=$_POST['tanggal'];
        $strtotime=strtotime($tanggal);
        $Tanggal=date('d/m/Y H:i:s T',$strtotime);
?>
    <input type="hidden" name="id_obat_storage" value="<?php echo "$id_obat_storage"; ?>">
    <input type="hidden" name="tanggal" id="tanggal" value="<?php echo "$tanggal"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">
            Penyimpanan
        </div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php
                    if(empty($_POST['id_obat_storage'])){
                        $id_obat_storage="0";
                        echo '<i class="ti ti-info-alt"></i> Penyimpanan Utama';
                    }else{
                        $id_obat_storage=$_POST['id_obat_storage'];
                        $QryStorage = mysqli_query($Conn,"SELECT * FROM obat_storage WHERE id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
                        $DataStorage = mysqli_fetch_array($QryStorage);
                        if(empty($DataStorage['nama_penyimpanan'])){
                            echo '<span class="text-danger">Tidak Diketahui</span>';
                        }else{
                            $nama_penyimpanan= $DataStorage['nama_penyimpanan'];
                            echo '<i class="ti ti-info-alt"></i> '.$nama_penyimpanan.'';
                        }
                    }
                ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            Tanggal Sesi
        </div>
        <div class="col col-md-8">
            <code class="text-secondary"><?php echo "$Tanggal"; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            Pilih Format Data 
        </div>
        <div class="col col-md-8">
            <ol>
                <li>
                    <input type="radio" checked name="format" id="FormatHtml" value="HTML"> 
                    <label for="FormatHtml">HTML</label>
                </li>
                <li>
                    <input type="radio" name="format" id="FormatPDF" value="PDF"> 
                    <label for="FormatPDF">PDF</label>
                </li>
                <li>
                    <input type="radio" name="format" id="FormatExcel" value="Excel"> 
                    <label for="FormatExcel">Excel</label>
                </li>
            </ol>
        </div>
    </div>
<?php } ?>