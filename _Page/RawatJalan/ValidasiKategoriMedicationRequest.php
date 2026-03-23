<?php
    if(empty($_POST['category'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center text-danger">';
        echo '      Silahkan Pilih Kategori Resep Terlebih Dulu';
        echo '  </div>';
        echo '</div>';
    }else{
        $category=$_POST['category'];
        if($category=="inpatient"){
            $category_system="http://terminology.hl7.org/CodeSystem/medicationrequest-category";
            $category_code="inpatient";
            $category_display="Inpatient";
            $category_keterangan="Peresepan untuk diadministr asikan atau dikonsumsi saat rawat inap";
        }else{
            if($category=="outpatient"){
                $category_system="http://terminology.hl7.org/CodeSystem/medicationrequest-category";
                $category_code="outpatient";
                $category_display="Outpatient";
                $category_keterangan="Peresepan untuk diadministr asikan atau dikonsumsi saat rawat  jalan (cth. IGD, poliklinik rawat jalan, bedah rawat jalan, dll)";
            }else{
                if($category=="community"){
                    $category_system="http://terminology.hl7.org/CodeSystem/medicationrequest-category";
                    $category_code="community";
                    $category_display="Community";
                    $category_keterangan="Peresepan untuk diadministr asikan atau dikonsumsi di rumah (long term care atau nursing home, atau hospices)";
                }else{
                    if($category=="discharge"){
                        $category_system="http://terminology.hl7.org/CodeSystem/medicationrequest-category";
                        $category_code="discharge";
                        $category_display="Discharge";
                        $category_keterangan="Peresepan obat yang dibuat ketika pasien dipulangkan dari fasilitas kesehatan";
                    }else{
                        $category_system="";
                        $category_code="";
                        $category_display="";
                        $category_keterangan="";
                    }
                }
            }
        }
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-4">';
        echo '      <label for="MedicationRequestCategorySystem">E.1.1 System</label>';
        echo '  </div>';
        echo '  <div class="col-md-8">';
        echo '      <input type="text" name="MedicationRequestCategorySystem" id="MedicationRequestCategorySystem" class="form-control" value="'. $category_system.'">';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-4">';
        echo '      <label for="MedicationRequestCategoryCode">E.1.2 Code</label>';
        echo '  </div>';
        echo '  <div class="col-md-8">';
        echo '      <input type="text" name="MedicationRequestCategoryCode" id="MedicationRequestCategoryCode" class="form-control" value="'. $category_code.'">';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-4">';
        echo '      <label for="MedicationRequestCategoryDisplay">E.1.3 Display</label>';
        echo '  </div>';
        echo '  <div class="col-md-8">';
        echo '      <input type="text" name="MedicationRequestCategoryDisplay" id="MedicationRequestCategoryDisplay" class="form-control" value="'. $category_display.'">';
        echo '      <small>'.$category_keterangan.'</small>';
        echo '  </div>';
        echo '</div>';
    }
?>