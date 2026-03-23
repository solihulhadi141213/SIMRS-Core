<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_item_resep
    if(empty($_POST['id_item_resep'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger mb-3">';
        echo '      ID Kunjungan Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_item_resep=$_POST['id_item_resep'];
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $Token=GenerateTokenSatuSehat($Conn);
        $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-danger text-center">';
            echo '      Tidak Ada Setting Satu Sehat Yang Aktif!';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-danger text-center">';
                echo '      Gagal Melakukan Generate Token!';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($baseurl_satusehat)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-danger text-center">';
                    echo '      Tidak Ada Base URL Satu Sehat!';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $response=MedicationRequestById($baseurl_satusehat,$Token,$id_item_resep);
                    $data_array =json_decode($response, true);
                    $resourceType=$data_array['resourceType'];
                    $identifier=$data_array['identifier'];
                    //identifier1
                    $identifier_system1=$identifier['0']['system'];
                    $identifier_use1=$identifier['0']['use'];
                    $identifier_value1=$identifier['0']['value'];
                    //identifier2
                    $identifier_system2=$identifier['1']['system'];
                    $identifier_use2=$identifier['1']['use'];
                    $identifier_value2=$identifier['1']['value'];
                    //Status & Intent
                    $status=$data_array['status'];
                    $intent=$data_array['intent'];
                    //Category
                    $category=$data_array['category'];
                    $category_coding=$category['0']['coding'];
                    $category_coding_system=$category_coding['0']['system'];
                    $category_coding_code=$category_coding['0']['code'];
                    $category_coding_display=$category_coding['0']['display'];
                    //priority
                    $priority=$data_array['priority'];
                    //medicationReference
                    $medicationReference=$data_array['medicationReference'];
                    $medicationReference_reference=$medicationReference['reference'];
                    $medicationReference_display=$medicationReference['display'];
                    //Subject
                    $subject=$data_array['subject'];
                    $subject_reference=$subject['reference'];
                    $subject_display=$subject['display'];
                    //Encounter
                    $encounter=$data_array['encounter'];
                    $encounter_reference=$encounter['reference'];
                    //authoredOn
                    $authoredOn=$data_array['authoredOn'];
                    //requester
                    $requester=$data_array['requester'];
                    $requester_reference=$requester['reference'];
                    $requester_display=$requester['display'];
                    //reasonCode
                    $reasonCode=$data_array['reasonCode'];
                    $reasonCode_coding=$reasonCode['0']['coding'];
                    $reasonCode_coding_system=$reasonCode_coding['0']['system'];
                    $reasonCode_coding_code=$reasonCode_coding['0']['code'];
                    $reasonCode_coding_display=$reasonCode_coding['0']['display'];
                    //course Of Therapy Type
                    $courseOfTherapyType=$data_array['courseOfTherapyType'];
                    $courseOfTherapyType_coding=$courseOfTherapyType['coding'];
                    $courseOfTherapyType_coding_system=$courseOfTherapyType_coding['0']['system'];
                    $courseOfTherapyType_coding_code=$courseOfTherapyType_coding['0']['code'];
                    $courseOfTherapyType_coding_display=$courseOfTherapyType_coding['0']['display'];
                    //Dosage Instruction
                    $dosageInstruction=$data_array['dosageInstruction'];
                    $dosageInstruction_sequence=$dosageInstruction['0']['sequence'];
                    $dosageInstruction_text=$dosageInstruction['0']['text'];
                    $additionalInstruction=$dosageInstruction['0']['additionalInstruction'];
                    $additionalInstruction_text=$additionalInstruction['0']['text'];
                    $patientInstruction=$dosageInstruction['0']['patientInstruction'];
                    $timing=$dosageInstruction['0']['timing'];
                    $repeat=$timing['repeat'];
                    $frequency=$repeat['frequency'];
                    $period=$repeat['period'];
                    $periodUnit=$repeat['periodUnit'];
                    $route=$dosageInstruction['0']['route'];
                    //route_coding
                    $route_coding=$route['coding'];
                    $route_coding_system=$route_coding['0']['system'];
                    $route_coding_code=$route_coding['0']['code'];
                    $route_coding_display=$route_coding['0']['display'];
                    //doseAndRate
                    $doseAndRate=$dosageInstruction['0']['doseAndRate'];
                    $doseAndRate_type=$doseAndRate['0']['type'];
                    $doseAndRate_type_coding=$doseAndRate_type['coding'];
                    $doseAndRate_type_coding_system=$doseAndRate_type_coding['0']['system'];
                    $doseAndRate_type_coding_code=$doseAndRate_type_coding['0']['code'];
                    $doseAndRate_type_coding_display=$doseAndRate_type_coding['0']['display'];
                    //doseQuantity
                    $doseQuantity=$doseAndRate['0']['doseQuantity'];
                    $doseQuantity_value=$doseQuantity['value'];
                    $doseQuantity_unit=$doseQuantity['unit'];
                    $doseQuantity_system=$doseQuantity['system'];
                    $doseQuantity_code=$doseQuantity['code'];
                    $dosageInstruction_patientInstruction=$dosageInstruction['0']['patientInstruction'];
                    //dispenseRequest
                    $dispenseRequest=$data_array['dispenseRequest'];
                    $dispenseInterval=$dispenseRequest['dispenseInterval'];
                    $validityPeriod=$dispenseRequest['validityPeriod'];
                    $numberOfRepeatsAllowed=$dispenseRequest['numberOfRepeatsAllowed'];
                    $quantity=$dispenseRequest['quantity'];
                    $expectedSupplyDuration=$dispenseRequest['expectedSupplyDuration'];
                    $performer=$dispenseRequest['performer'];
                    //dispenseInterval
                    $dispenseInterval_value=$dispenseInterval['value'];
                    $dispenseInterval_unit=$dispenseInterval['unit'];
                    $dispenseInterval_system=$dispenseInterval['system'];
                    $dispenseInterval_code=$dispenseInterval['code'];
                    //validityPeriod
                    $validityPeriod_start=$validityPeriod['start'];
                    $validityPeriod_end=$validityPeriod['end'];
                    //quantity
                    $quantity_value=$quantity['value'];
                    $quantity_unit=$quantity['unit'];
                    $quantity_system=$quantity['system'];
                    $quantity_code=$quantity['code'];
                    //expectedSupplyDuration
                    $expectedSupplyDuration_value=$expectedSupplyDuration['value'];
                    $expectedSupplyDuration_unit=$expectedSupplyDuration['unit'];
                    $expectedSupplyDuration_system=$expectedSupplyDuration['system'];
                    $expectedSupplyDuration_code=$expectedSupplyDuration['code'];
                    //performer
                    $performer_reference=$performer['reference'];
?>
<div class="row mb-3">
    <div class="col-md-12">
        <ol>
            <li class="mb-3">
                Identifier-1
                <ul>
                    <li>System : <code class="text-secondary"><?php echo "$identifier_system2"; ?></code></li>
                    <li>Use : <code class="text-secondary"><?php echo "$identifier_use2"; ?></code></li>
                    <li>Value : <code class="text-secondary"><?php echo "$identifier_value2"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Identifier-2
                <ul>
                    <li>System : <code class="text-secondary"><?php echo "$identifier_system2"; ?></code></li>
                    <li>Use : <code class="text-secondary"><?php echo "$identifier_use2"; ?></code></li>
                    <li>Value : <code class="text-secondary"><?php echo "$identifier_value2"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Status : 
                <code class="text-secondary">
                    <?php 
                        if(empty($status)){
                            echo '<span class="text-danger">Tidak Ada</small>';
                        }else{
                            echo "<span>$status</small>"; 
                        }
                    ?>
                </code>
            </li>
            <li class="mb-3">
                Intent : 
                <code class="text-secondary">
                    <?php 
                        if(empty($intent)){
                            echo '<span class="text-danger">Tidak Ada</small>';
                        }else{
                            echo "<span>$intent</small>"; 
                        }
                    ?>
                </code>
            </li>
            <li class="mb-3">
                Category : 
                <ul>
                    <li>System : <code class="text-secondary"><?php echo "$category_coding_system"; ?></code></li>
                    <li>Use : <code class="text-secondary"><?php echo "$category_coding_code"; ?></code></li>
                    <li>Value : <code class="text-secondary"><?php echo "$category_coding_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Category : 
                <ul>
                    <li>System : <code class="text-secondary"><?php echo "$category_coding_system"; ?></code></li>
                    <li>Use : <code class="text-secondary"><?php echo "$category_coding_code"; ?></code></li>
                    <li>Value : <code class="text-secondary"><?php echo "$category_coding_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Priority : 
                <code class="text-secondary">
                    <?php 
                        if(empty($priority)){
                            echo '<span class="text-danger">Tidak Ada</small>';
                        }else{
                            echo "<span>$priority</small>"; 
                        }
                    ?>
                </code>
            </li>
            <li class="mb-3">
                Medication Reference : 
                <ul>
                    <li>Reference : <code class="text-secondary"><?php echo "$medicationReference_reference"; ?></code></li>
                    <li>Display : <code class="text-secondary"><?php echo "$medicationReference_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Subject : 
                <ul>
                    <li>Reference : <code class="text-secondary"><?php echo "$subject_reference"; ?></code></li>
                    <li>Display : <code class="text-secondary"><?php echo "$subject_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Encounter : 
                <code class="text-secondary">
                    <?php 
                        if(empty($encounter_reference)){
                            echo '<span class="text-danger">Tidak Ada</small>';
                        }else{
                            echo "<span>$encounter_reference</small>"; 
                        }
                    ?>
                </code>
            </li>
            <li class="mb-3">
                Authored On : 
                <code class="text-secondary">
                    <?php 
                        if(empty($authoredOn)){
                            echo '<span class="text-danger">Tidak Ada</small>';
                        }else{
                            echo "<span>$authoredOn</small>"; 
                        }
                    ?>
                </code>
            </li>
            <li class="mb-3">
                Requester : 
                <ul>
                    <li>Reference : <code class="text-secondary"><?php echo "$requester_reference"; ?></code></li>
                    <li>Display : <code class="text-secondary"><?php echo "$requester_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Reason Code : 
                <ul>
                    <li>System : <code class="text-secondary"><?php echo "$reasonCode_coding_system"; ?></code></li>
                    <li>Code : <code class="text-secondary"><?php echo "$reasonCode_coding_code"; ?></code></li>
                    <li>Display : <code class="text-secondary"><?php echo "$reasonCode_coding_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Course Of Therapy : 
                <ul>
                    <li>System : <code class="text-secondary"><?php echo "$courseOfTherapyType_coding_system"; ?></code></li>
                    <li>Code : <code class="text-secondary"><?php echo "$courseOfTherapyType_coding_code"; ?></code></li>
                    <li>Display : <code class="text-secondary"><?php echo "$courseOfTherapyType_coding_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Dosage Instruction : 
                <ul>
                    <li>Sequenc : <code class="text-secondary"><?php echo "$dosageInstruction_sequence"; ?></code></li>
                    <li>Text : <code class="text-secondary"><?php echo "$dosageInstruction_text"; ?></code></li>
                    <li>Additional Instruction : <code class="text-secondary"><?php echo "$additionalInstruction_text"; ?></code></li>
                    <li>Patient Instruction : <code class="text-secondary"><?php echo "$patientInstruction"; ?></code></li>
                    <li>Frequency : <code class="text-secondary"><?php echo "$frequency"; ?></code></li>
                    <li>Period : <code class="text-secondary"><?php echo "$period"; ?></code></li>
                    <li>Unit : <code class="text-secondary"><?php echo "$periodUnit"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Route : 
                <ul>
                    <li>System : <code class="text-secondary"><?php echo "$route_coding_system"; ?></code></li>
                    <li>Code : <code class="text-secondary"><?php echo "$route_coding_code"; ?></code></li>
                    <li>Display : <code class="text-secondary"><?php echo "$route_coding_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Dosage And Rate : 
                <ul>
                    <li>System : <code class="text-secondary"><?php echo "$doseAndRate_type_coding_system"; ?></code></li>
                    <li>Code : <code class="text-secondary"><?php echo "$doseAndRate_type_coding_code"; ?></code></li>
                    <li>Display : <code class="text-secondary"><?php echo "$doseAndRate_type_coding_display"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Dosage Quantity : 
                <ul>
                    <li>Value : <code class="text-secondary"><?php echo "$doseQuantity_value"; ?></code></li>
                    <li>Unit : <code class="text-secondary"><?php echo "$doseQuantity_unit"; ?></code></li>
                    <li>System : <code class="text-secondary"><?php echo "$doseQuantity_system"; ?></code></li>
                    <li>Code : <code class="text-secondary"><?php echo "$doseQuantity_code"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Dispense Interval : 
                <ul>
                    <li>Value : <code class="text-secondary"><?php echo "$doseQuantity_value"; ?></code></li>
                    <li>Unit : <code class="text-secondary"><?php echo "$doseQuantity_unit"; ?></code></li>
                    <li>System : <code class="text-secondary"><?php echo "$doseQuantity_system"; ?></code></li>
                    <li>Code : <code class="text-secondary"><?php echo "$doseQuantity_code"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Validity Period : 
                <ul>
                    <li>Start : <code class="text-secondary"><?php echo "$validityPeriod_start"; ?></code></li>
                    <li>End : <code class="text-secondary"><?php echo "$validityPeriod_end"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Number Of Repeats Allowed : 
                <code class="text-secondary">
                    <?php 
                        if(empty($numberOfRepeatsAllowed)){
                            echo '<span class="text-danger">Tidak Ada</small>';
                        }else{
                            echo "<span>$numberOfRepeatsAllowed</small>"; 
                        }
                    ?>
                </code>
            </li>
            <li class="mb-3">
                Quantity : 
                <ul>
                    <li>Value : <code class="text-secondary"><?php echo "$quantity_value"; ?></code></li>
                    <li>Unit : <code class="text-secondary"><?php echo "$quantity_unit"; ?></code></li>
                    <li>System : <code class="text-secondary"><?php echo "$quantity_system"; ?></code></li>
                    <li>Code : <code class="text-secondary"><?php echo "$quantity_code"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Expected Supply Duration : 
                <ul>
                    <li>Value : <code class="text-secondary"><?php echo "$expectedSupplyDuration_value"; ?></code></li>
                    <li>Unit : <code class="text-secondary"><?php echo "$expectedSupplyDuration_unit"; ?></code></li>
                    <li>System : <code class="text-secondary"><?php echo "$expectedSupplyDuration_system"; ?></code></li>
                    <li>Code : <code class="text-secondary"><?php echo "$expectedSupplyDuration_code"; ?></code></li>
                </ul>
            </li>
            <li class="mb-3">
                Performer : 
                <code class="text-secondary">
                    <?php 
                        if(empty($performer_reference)){
                            echo '<span class="text-danger">Tidak Ada</small>';
                        }else{
                            echo "<span>$performer_reference</small>"; 
                        }
                    ?>
                </code>
            </li>
        </ol>
    </div>
</div>
<?php
                }
            }
        }
    }
?>