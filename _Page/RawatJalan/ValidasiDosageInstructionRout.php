<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(!empty($_POST['PilihDosageInstructionRout'])){
        $PilihDosageInstructionRout=$_POST['PilihDosageInstructionRout'];
        $rout_file="../../assets/referensi_json/dosageInstruction_route.json";
        $jsonContent = file_get_contents($rout_file);
        $data = json_decode($jsonContent, true);
        if(!empty(count($data['list']))){
            $rout_list=$data['list'];
            foreach($rout_list as $show_rout){
                if($PilihDosageInstructionRout==$show_rout['code']){
                    $rout_system=$show_rout['system'];
                    $rout_code=$show_rout['code'];
                    $rout_display=$show_rout['display'];
?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="DosageInstructionRoutSystem">L.2.Route System</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="DosageInstructionRoutSystem" id="DosageInstructionRoutSystem" class="form-control" value="<?php echo $rout_system;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="DosageInstructionRoutCode">L.3.Route Code</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="DosageInstructionRoutCode" id="DosageInstructionRoutCode" class="form-control" value="<?php echo $rout_code;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="DosageInstructionRoutDisplay">L.4.Route Display</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="DosageInstructionRoutDisplay" id="DosageInstructionRoutDisplay" class="form-control" value="<?php echo $rout_display;?>">
                    </div>
                </div>
<?php
                }
            }
        }
    }
?>