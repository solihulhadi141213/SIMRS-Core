<?php
    if(empty($_POST['MedicationDismpenseCategory'])){
        $category_system="http://terminology.hl7.org/CodeSystem/medicationrequest-category";
        $category_code="";
        $category_display="";
        $category_keterangan="";
    }else{
        $category=$_POST['MedicationDismpenseCategory'];
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
    }
    //Membuat json
    $data = array(
        "category_system" => $category_system,
        "category_code" => $category_code,
        "category_display" => $category_display,
        "category_keterangan" => $category_keterangan,
    );
    $jsonString = json_encode($data);
    echo $jsonString;
?>