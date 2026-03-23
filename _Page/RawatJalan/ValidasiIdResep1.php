<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    if(!empty($_POST['id_resep'])){
        $GetIdResep=$_POST['id_resep'];
        //Buka Detail Resep
        $id_resep=getDataDetail($Conn,"resep",'id_resep',$GetIdResep,'id_resep');
        if(empty($id_resep)){
            echo '  <div class="row mb-3">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Resep Tidak Valid!';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_dokter=getDataDetail($Conn,"resep",'id_resep',$GetIdResep,'id_dokter');
?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_system1">B.1.1.Identifier System (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="identifier_system1" id="identifier_system1" class="form-control" value="http://sys-ids.kemkes.go.id/prescription/<?php echo $organization_id;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_use1">B.1.2.Identifier Use (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="identifier_use1" id="identifier_use1" class="form-control" value="official">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="identifier_value1">B.1.3.Identifier Value (1)</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="identifier_value1" id="identifier_value1" class="form-control" value="<?php echo $id_resep;?>">
                    </div>
                </div>
<?php
        }
    }
?>