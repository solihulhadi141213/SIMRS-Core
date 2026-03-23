<?php
    // Tangkap ID Rincian
    if(empty($_POST['id_laboratorium_rincian'])){
        echo '
            <div class="row">
                <div class="col-12 text-center text-danger">Tidak Ada Data Rincian Yang Dipilih!</div>
            </div>
        ';
        exit;
    }

    // Tangkap ID Rincian
    if(empty($_POST['id_laboratorium'])){
        echo '
            <div class="row">
                <div class="col-12 text-center text-danger">Tidak Ada Data ID Laboratorium Yang Dipilih!</div>
            </div>
        ';
        exit;
    }
    $id_laboratorium_rincian = $_POST['id_laboratorium_rincian'];
    $id_laboratorium = $_POST['id_laboratorium'];
    echo '
        <input type="hidden" name="id_laboratorium_rincian" value="'.$id_laboratorium_rincian.'">
        <input type="hidden" name="id_laboratorium" value="'.$id_laboratorium.'">
        <div class="row">
            <div class="col-12 text-center text-dark">
                Apakah anda yakin akan menghapus rincian <dt>'.$id_laboratorium_rincian.'</dt> tersebut? 
            </div>
        </div>
    ';
    exit;
?>