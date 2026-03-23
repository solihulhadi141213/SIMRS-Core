<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_medication_dis
    if(empty($_POST['id_medication_dis'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger mb-3">';
        echo '      ID Medication Dispense Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_medication_dis=$_POST['id_medication_dis'];
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
                    $response=MedicationDispenseById($baseurl_satusehat,$Token,$id_medication_dis);
                    $data_array =json_decode($response, true);
                    $authorizingPrescription=$data_array['authorizingPrescription'];
                    $category=$data_array['category'];
                    $context=$data_array['context'];
                    $daysSupply=$data_array['daysSupply'];
                    $dosageInstruction=$data_array['dosageInstruction'];
                    $id=$data_array['id'];
                    $identifier=$data_array['identifier'];
                    $location=$data_array['location'];
                    $medicationReference=$data_array['medicationReference'];
                    $meta=$data_array['meta'];
                    $performer=$data_array['performer'];
                    $quantity=$data_array['quantity'];
                    $resourceType=$data_array['resourceType'];
                    $status=$data_array['status'];
                    $subject=$data_array['subject'];
                    $whenHandedOver=$data_array['whenHandedOver'];
                    $whenPrepared=$data_array['whenPrepared'];
                    //Prety
                    $newJsonString = json_encode($data_array, JSON_PRETTY_PRINT);
?>
                    <div class="row mb-3 ml-2">
                        <div class="col-md-12">
                            <ul>
                                <li class="mb-3">
                                    B.1 Resource Type : 
                                    <code class="text-secondary"><?php echo "$resourceType"; ?></code>
                                </li>
                                <li class="mb-3">
                                    B.2 Identifier
                                    <ol class="mt-3">
                                        <li class="mb-3">
                                            Identifier 1
                                            <ol>
                                                <li>System : <code class="text-secondary"><?php echo $identifier['0']['system']; ?></code></li>
                                                <li>Use : <code class="text-secondary"><?php echo $identifier['0']['use']; ?></code></li>
                                                <li>Value : <code class="text-secondary"><?php echo $identifier['0']['value']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li class="mb-3">
                                            Identifier 2
                                            <ol>
                                                <li>System : <code class="text-secondary"><?php echo $identifier['1']['system']; ?></code></li>
                                                <li>Use : <code class="text-secondary"><?php echo $identifier['1']['use']; ?></code></li>
                                                <li>Value : <code class="text-secondary"><?php echo $identifier['1']['value']; ?></code></li>
                                            </ol>
                                        </li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.3 Status : 
                                    <code class="text-secondary"><?php echo "$status"; ?></code>
                                </li>
                                <li class="mb-3">
                                    B.4 Category : 
                                    <ol>
                                        <li>System : <code class="text-secondary"><?php echo $category['coding']['0']['system']; ?></code></li>
                                        <li>Code : <code class="text-secondary"><?php echo $category['coding']['0']['code']; ?></code></li>
                                        <li>Display : <code class="text-secondary"><?php echo $category['coding']['0']['display']; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.5 Medication Reference : 
                                    <ol>
                                        <li>Referense : <code class="text-secondary"><?php echo $medicationReference['reference']; ?></code></li>
                                        <li>Display : <code class="text-secondary"><?php echo $medicationReference['display']; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.6 Subject : 
                                    <ol>
                                        <li>Referense : <code class="text-secondary"><?php echo $subject['reference']; ?></code></li>
                                        <li>Display : <code class="text-secondary"><?php echo $subject['display']; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.7 Context : 
                                    <code class="text-secondary"><?php echo $context['reference']; ?></code>
                                </li>
                                <li class="mb-3">
                                    B.8 Performer : 
                                    <ol>
                                        <li>Referense : <code class="text-secondary"><?php echo $performer['0']['actor']['reference']; ?></code></li>
                                        <li>Display : <code class="text-secondary"><?php echo $performer['0']['actor']['display']; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.9 Location : 
                                    <ol>
                                        <li>Referense : <code class="text-secondary"><?php echo $location['reference']; ?></code></li>
                                        <li>Display : <code class="text-secondary"><?php echo $location['display']; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.10 Authorizing Prescription : 
                                    <ol>
                                        <li>Referense : <code class="text-secondary"><?php echo $authorizingPrescription['0']['reference']; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.11 Quantity : 
                                    <ol>
                                        <li>System : <code class="text-secondary"><?php echo $quantity['system']; ?></code></li>
                                        <li>Code : <code class="text-secondary"><?php echo $quantity['code']; ?></code></li>
                                        <li>Value : <code class="text-secondary"><?php echo $quantity['value']; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.12 Days Supply : 
                                    <ol>
                                        <li>Value : <code class="text-secondary"><?php echo $daysSupply['value']; ?></code></li>
                                        <li>Unit : <code class="text-secondary"><?php echo $daysSupply['unit']; ?></code></li>
                                        <li>System : <code class="text-secondary"><?php echo $daysSupply['system']; ?></code></li>
                                        <li>Code : <code class="text-secondary"><?php echo $daysSupply['code']; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.13 When Prepared & Handed Over: 
                                    <ol>
                                        <li>When Prepared : <code class="text-secondary"><?php echo $whenPrepared; ?></code></li>
                                        <li>When Handed Over : <code class="text-secondary"><?php echo $whenHandedOver; ?></code></li>
                                    </ol>
                                </li>
                                <li class="mb-3">
                                    B.14 Dosage Instruction : 
                                    <ol>
                                        <li>Sequence : <code class="text-secondary"><?php echo $dosageInstruction['0']['sequence']; ?></code></li>
                                        <li>Text : <code class="text-secondary"><?php echo $dosageInstruction['0']['text']; ?></code></li>
                                        <li>
                                            Timing Repeat : 
                                            <ol>
                                                <li>Frequency : <code class="text-secondary"><?php echo $dosageInstruction['0']['timing']['repeat']['frequency']; ?></code></li>
                                                <li>Period : <code class="text-secondary"><?php echo $dosageInstruction['0']['timing']['repeat']['period']; ?></code></li>
                                                <li>Period Unit : <code class="text-secondary"><?php echo $dosageInstruction['0']['timing']['repeat']['periodUnit']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li>
                                            Dose And Rate : 
                                            <ol>
                                                <li>System : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['system']; ?></code></li>
                                                <li>Code : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['code']; ?></code></li>
                                                <li>Display : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['type']['coding']['0']['display']; ?></code></li>
                                            </ol>
                                        </li>
                                        <li>
                                            Dose Quantity : 
                                            <ol>
                                                <li>Value : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['value']; ?></code></li>
                                                <li>Unit : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['unit']; ?></code></li>
                                                <li>System : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['system']; ?></code></li>
                                                <li>Code : <code class="text-secondary"><?php echo $dosageInstruction['0']['doseAndRate']['0']['doseQuantity']['code']; ?></code></li>
                                            </ol>
                                        </li>
                                    </ol>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-3 ml-2">
                        <div class="col-md-12">
                            <label for="RawDataMedicationDispenseSatuSehat">Raw Data</label>
                            <textarea name="RawDataMedicationDispenseSatuSehat" id="RawDataMedicationDispenseSatuSehat" class="form-control"><?php echo "$newJsonString"; ?></textarea>
                        </div>
                    </div>
<?php
                }
            }
        }
    }
?>