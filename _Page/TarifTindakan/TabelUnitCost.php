<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_tarif'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Tarif Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_tarif=$_POST['id_tarif'];
        $GetIdTarif=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'id_tarif');
        if(empty($GetIdTarif)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      ID Tarif Tidak Valid Atau Tidak Ditemukan Pada Database!';
            echo '  </div>';
            echo '</div>';
        }else{
            //Jumlah Data Unit Cost
            $JumlahDataCost = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM tarif_cost WHERE id_tarif='$id_tarif'"));
            if(empty($JumlahDataCost)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Tidak Ada Data Unit Cost Untuk Tarif Tindakan Ini';
                echo '  </div>';
                echo '</div>';
            }else{
                $no=1;
                $JumlahCost=0;
                $query = mysqli_query($Conn, "SELECT*FROM tarif_cost WHERE id_tarif='$id_tarif'");
                while ($data = mysqli_fetch_array($query)) {
                    $id_cost= $data['id_cost'];
                    $nama= $data['nama'];
                    $cost= $data['cost'];
                    $JumlahCost=$JumlahCost+$cost;
                    $CostRp=number_format($cost,0,',','.');
?>
                    <div class="row sub-title">
                        <div class="col-md-6 mb-2">
                            <dt></dt>
                            <?php echo "$no. $nama"; ?>
                        </div>
                        <div class="col-md-3 text-left mb-2">
                            <?php echo "$CostRp"; ?>
                        </div>
                        <div class="col-md-3 text-left mb-2">
                            <div class="icon-btn">
                                <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalEditUnitCost" data-id="<?php echo "$id_cost";?>" title="Edit Unit Cost">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalHapusUnitCost" data-id="<?php echo "$id_cost";?>" title="Delete Unit Cost">
                                    <i class="ti ti-close"></i>
                                </button>
                            </div>
                        </div>
                    </div>
<?php
                    $no++;
                }
                $JumlahCostRp=number_format($JumlahCost,0,',','.');
                echo '<div class="row sub-title">';
                echo '  <div class="col-md-6 mb-2"><dt>JUMLAH COST</dt></div>';
                echo '  <div class="col-md-3 text-left mb-2">'.$JumlahCostRp.'</div>';
                echo '</div>';
            }
        }
    }
?>