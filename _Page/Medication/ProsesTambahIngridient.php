<?php
    if(!empty($_POST['PutitemCodeableConcept'])){
        $PutitemCodeableConcept=$_POST['PutitemCodeableConcept'];
        $explode=explode('|',$PutitemCodeableConcept);
        if(!empty($explode[0])){
            $itemCodeableConceptCode=$explode[0];
        }else{
            $itemCodeableConceptCode="";
        }
        if(!empty($explode[1])){
            $itemCodeableConceptDisplay=$explode[1];
        }else{
            $itemCodeableConceptDisplay="";
        }
        if(!empty($_POST['PutisActive'])){
            $PutisActive=$_POST['PutisActive'];
            if(!empty($_POST['PutNumeratorValue'])){
                $PutNumeratorValue=$_POST['PutNumeratorValue'];
            }else{
                $PutNumeratorValue="";
            }
            if(!empty($_POST['PutNumeratorCode'])){
                $PutNumeratorCode=$_POST['PutNumeratorCode'];
            }else{
                $PutNumeratorCode="";
            }
            if(!empty($_POST['PutDenominatorValue'])){
                $PutDenominatorValue=$_POST['PutDenominatorValue'];
            }else{
                $PutDenominatorValue="";
            }
            if(!empty($_POST['PutDenominatorCode'])){
                $PutDenominatorCode=$_POST['PutDenominatorCode'];
            }else{
                $PutDenominatorCode="";
            }
            $IdRow=rand(1000,9999);
?>
        <div class="col-4 mb-3" id="BarisIngridient<?php echo $IdRow; ?>">
            <input type="hidden" name="itemCodeableConceptDisplay[]" value="<?php echo "$itemCodeableConceptDisplay"; ?>">
            <input type="hidden" name="itemCodeableConceptCode[]" value="<?php echo "$itemCodeableConceptCode"; ?>">
            <input type="hidden" name="isActive[]" value="<?php echo "$PutisActive"; ?>">
            <input type="hidden" name="strength_numerator_value[]" value="<?php echo "$PutNumeratorValue"; ?>">
            <input type="hidden" name="strength_numerator_code[]" value="<?php echo "$PutNumeratorCode"; ?>">
            <input type="hidden" name="strength_denominator_value[]" value="<?php echo "$PutDenominatorValue"; ?>">
            <input type="hidden" name="strength_denominator_code[]" value="<?php echo "$PutDenominatorCode"; ?>">
            <small>
                <ul>
                    <li>Name : <code><?php echo "$itemCodeableConceptDisplay"; ?></code></li>
                    <li>Code : <code><?php echo "$itemCodeableConceptCode"; ?></code></li>
                    <li>Is Active : <code><?php echo "$PutisActive"; ?></code></li>
                    <li>Numerator : <code><?php echo "$PutNumeratorValue $PutNumeratorCode"; ?></code></li>
                    <li>Denominator : <code><?php echo "$PutDenominatorValue $PutDenominatorCode"; ?></code></li>
                </ul>
                <a href="javascript:void(0);" id="HapusBarisIngridient<?php echo $IdRow; ?>" class="text-danger" value="<?php echo $IdRow; ?>">
                    <i class="ti ti-close"></i> Hapus
                </a>
            </small>
        </div>
        <script>
            $('#HapusBarisIngridient<?php echo $IdRow; ?>').click(function(){
                $('#BarisIngridient<?php echo $IdRow; ?>').remove();
            });
        </script>
<?php }} ?>