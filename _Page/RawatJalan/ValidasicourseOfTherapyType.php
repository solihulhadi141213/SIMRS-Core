<?php
    if(!empty($_POST['MedicationRequestCourseOfTherapyType'])){
        $type=$_POST['MedicationRequestCourseOfTherapyType'];
        if($type=="continuous"){
            $system="http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy";
            $code="continuous";
            $display="Continuing long term therapy";
            $keterangan="Pengobatan yang diharapkan berlanjut hingga permintaan selanjutnya dan pasien harus diasumsikan mengonsums inya kecuali jika dihentikan secara eksplisit";
        }else{
            if($type=="acute"){
                $system="http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy";
                $code="acute";
                $display="Short course (acute) therapy";
                $keterangan="Pengobatan pasien yang diharapkan dikonsumsi pada durasi pemberian tertentu dan tidak diberikan lagi";
            }else{
                if($type=="seasonal"){
                    $system="http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy";
                    $code="seasonal";
                    $display="Seasonal";
                    $keterangan="Pengobatan yang diharapkan digunakan pada waktu tertentu pada waktu yang telah dijadwalkan dalam setahun";
                }else{
                    $system="http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy";
                    $code="";
                    $display="";
                    $keterangan="";
                }
            }
        }
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-4">';
        echo '      <label for="courseOfTherapyType_system">I.2.System</label>';
        echo '  </div>';
        echo '  <div class="col-md-8">';
        echo '      <input type="text" name="courseOfTherapyType_system" id="courseOfTherapyType_system" class="form-control" value="'. $system.'">';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-4">';
        echo '      <label for="courseOfTherapyType_code">I.3.Code</label>';
        echo '  </div>';
        echo '  <div class="col-md-8">';
        echo '      <input type="text" name="courseOfTherapyType_code" id="courseOfTherapyType_code" class="form-control" value="'. $code.'">';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-4">';
        echo '      <label for="courseOfTherapyType_display">I.4.Display</label>';
        echo '  </div>';
        echo '  <div class="col-md-8">';
        echo '      <input type="text" name="courseOfTherapyType_display" id="courseOfTherapyType_display" class="form-control" value="'. $display.'">';
        echo '      <small>'.$keterangan.'</small>';
        echo '  </div>';
        echo '</div>';
    }
?>