<?php
    if(empty($_POST['ColomName'])){
        echo "<span class='text-danger'>Nama Kolom Tidak Ditangkap!!</span>";
    }else{
        if(empty($_POST['batas'])){
            echo "<span class='text-danger'>Batas Jumlah Data Tidak Ditangkap!!</span>";
        }else{
            $ColomName=$_POST['ColomName'];
            $batas=$_POST['batas'];
            if($ColomName=="harga_4"){
                $LabelKolom="Harga Medis";
            }else{
                if($ColomName=="harga_3"){
                    $LabelKolom="Harga Grosir";
                }else{
                    if($ColomName=="harga_2"){
                        $LabelKolom="Harga Eceran";
                    }else{
                        if($ColomName=="harga_1"){
                            $LabelKolom="Harga Beli";
                        }else{
                            if($ColomName=="nama_obat"){
                                $LabelKolom="Nama Obat";
                            }else{
                                if($ColomName=="kode"){
                                    $LabelKolom="Kode Obat";
                                }else{
                                    if($ColomName=="satuan"){
                                        $LabelKolom="Satuan";
                                    }else{
                                        if($ColomName=="isi"){
                                            $LabelKolom="Konversi/Isi";
                                        }else{
                                            if($ColomName=="stok"){
                                                $LabelKolom="Stok Obat";
                                            }else{
                                                if($ColomName=="updatetime"){
                                                    $LabelKolom="Last Update";
                                                }else{
                                                    if($ColomName=="kategori"){
                                                        $LabelKolom="Kategori";
                                                    }else{
                                                        $LabelKolom=$ColomName;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
?>
    <input type="hidden" name="batas" value="<?php echo "$batas"; ?>">
    <input type="hidden" name="OrderBy" value="<?php echo "$ColomName"; ?>">
    <input type="hidden" name="keyword_by" value="<?php echo "$ColomName"; ?>">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="FilterBy">Filter By</label>
            <input type="text" readonly class="form-control" value="<?php echo "$LabelKolom"; ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="ShortBy">Short By</label>
            <select name="ShortBy" id="" class="form-control">
                <option value="ASC">A to Z</option>
                <option value="DESC">Z To A</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="keyword">Keyword</label>
            <input type="text" name="keyword" <?php if($ColomName=="satuan"||$ColomName=="kategori"){echo 'list="ListKeyword"';} ?> class="form-control">
            <?php
                include "../../_Config/Connection.php";
                if($ColomName=="satuan"||$ColomName=="kategori"){
                    echo '<datalist id="ListKeyword">';
                        $QryKeywordList = mysqli_query($Conn, "SELECT DISTINCT $ColomName FROM obat");
                        while ($DataKeywordList = mysqli_fetch_array($QryKeywordList)) {
                            $List_Keyword= $DataKeywordList[$ColomName];
                            echo '<option value="'.$List_Keyword.'">';
                        }
                    echo '</datalist>';
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="NotifikasiFilterObat">
            <span class="text-primary">Apakah anda yakin akan melakukan filter data obat?</span>
        </div>
    </div>
<?php }} ?>