<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_diagnosis_pasien'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      ID Kunjungan Tidak Boleh Kosong!';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_kunjungan=$_POST['id_kunjungan'];
            $id_diagnosis_pasien=$_POST['id_diagnosis_pasien'];
            //Buka Detail Diagnosa
            $id_diagnosis_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'id_diagnosis_pasien');
            $id_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'id_pasien');
            $nama_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'nama_pasien');
            $tanggal=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'tanggal');
            $petugas_entry=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'petugas_entry');
            $kategori=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'kategori');
            $kode=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'kode');
            $diagnosis=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'diagnosis');
            $referensi=getDataDetail($Conn,"diagnosis_pasien",'id_diagnosis_pasien',$id_diagnosis_pasien,'referensi');
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $FormatTanggal=date('d/m/Y H:i T',$strtotime);
?>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">ID Diagnosa</div>
        <div class="col-md-8 mb-2"><?php echo "$id_diagnosis_pasien"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">No.RM</div>
        <div class="col-md-8 mb-2"><?php echo "$id_pasien"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">Nama</div>
        <div class="col-md-8 mb-2"><?php echo "$nama_pasien"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">Tanggal Entry</div>
        <div class="col-md-8 mb-2"><?php echo "$FormatTanggal"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">Petugas Entry</div>
        <div class="col-md-8 mb-2"><?php echo "$petugas_entry"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">Kategori</div>
        <div class="col-md-8 mb-2"><?php echo "$kategori"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">Kode</div>
        <div class="col-md-8 mb-2"><?php echo "$kode"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">Diagnosis</div>
        <div class="col-md-8 mb-2"><?php echo "$diagnosis"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-2">Referensi</div>
        <div class="col-md-8 mb-2"><?php echo "$referensi"; ?></div>
    </div>
<?php }} ?>