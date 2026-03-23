<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_obat_medication
    if(empty($_POST['id_obat_medication'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Medication Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_medication=$_POST['id_obat_medication'];
?>
        <div class="row mb-3">
            <div class="col-md-12">
                Untuk melakukan perubahan/edit data medication, anda akan diarahkan pada form edit medication.<br>
                Apakah anda yakin ingin menuju ke halaman form edit medication?
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col-md-12 text-center">
                <a href="index.php?Page=Medication&Sub=EditMedication&id_obat_medication=<?php echo $id_obat_medication; ?>" class="btn btn-block btn-sm btn-primary">
                    <i class="ti ti-check"></i> Ya, Ke Halaman Edit 
                </a>
            </div>
        </div>
<?php 
    } 
?>