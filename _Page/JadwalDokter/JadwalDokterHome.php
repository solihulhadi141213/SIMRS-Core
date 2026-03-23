<?php
    date_default_timezone_set('Asia/Jakarta');
    //melakukan update jadwal, nama dokter dan poliklinik
    //--Arraykan seluruh jadwal
    $QryList = mysqli_query($Conn, "SELECT*FROM jadwal_dokter");
    while ($DataList = mysqli_fetch_array($QryList)) {
        $IdJadwal= $DataList['id_jadwal'];
        $IdDokter= $DataList['id_dokter'];
        $IdPoli= $DataList['id_poliklinik'];
        $NamaDokter= $DataList['dokter'];
        $NamaPoli= $DataList['poliklinik'];
        
        //validasi IdDokter, apabila data tidak valid segera hapus dan apabila tidak sama lakukan update
        $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$IdDokter'")or die(mysqli_error($Conn));
        $DataDokter = mysqli_fetch_array($QryDokter);
        $NamaDokter2 = $DataDokter['nama'];
        if(empty($DataDokter['nama'])){
            //Hapus data jadwal karena data dokter tidak ada
            $HapusDokterDiJadwal = mysqli_query($Conn, "DELETE FROM jadwal_dokter WHERE id_dokter='$IdDokter'") or die(mysqli_error($Conn));
        }else{
            //Validasi nama dokter, apabila tidak sama lakukan update
            if($NamaDokter2!==$NamaDokter){
                $UdateNamaDokterDiJadwal = mysqli_query($Conn, "UPDATE jadwal_dokter SET 
                    dokter='$NamaDokter2'
                WHERE id_dokter='$IdDokter'") or die(mysqli_error($Conn));
            }
        }
        
        // //validasi IdPoli, apabila data tidak valid segera hapus dan apabila tidak sama lakukan update
        $QryPoli = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$IdPoli'")or die(mysqli_error($Conn));
        $DataPoli = mysqli_fetch_array($QryPoli);
        $NamaPoli2 = $DataPoli['nama'];
        if(empty($NamaPoli2)){
            //Hapus data poli karena data dokter tidak ada
            $HapusDataPoli = mysqli_query($Conn, "DELETE FROM jadwal_dokter WHERE id_poliklinik='$IdPoli'") or die(mysqli_error($Conn));
        }else{
            //Validasi nama dokter, apabila tidak sama lakukan update
            if($NamaPoli2!==$NamaPoli){
                $UpdateNamaPoliDijadwal = mysqli_query($Conn, "UPDATE jadwal_dokter SET 
                    poliklinik='$NamaPoli2'
                WHERE id_poliklinik='$IdPoli'") or die(mysqli_error($Conn));
            }
        }
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=JadwalDokter" class="h5">
                            <i class="icofont-ui-calendar"></i> Jadwal Dokter
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola Jadwal Praktek Dokter</p>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-md btn-inverse mr-2 mt-2" data-toggle="modal" data-target="#ModalTambahJadwal">
                    <i class="ti-plus text-white"></i> Tambah Jadwal
                </button>
                <button class="btn btn-md btn-info mr-2 mt-2" data-toggle="modal" data-target="#ModalDataHfis">
                    <i class="ti ti-new-window text-white"></i> HFIS
                </button>
                <button class="btn btn-md btn-info mr-2 mt-2" data-toggle="modal" data-target="#Modal">
                    <i class="ti-printer text-white"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <div class="row">
                                    <div class="col col-md-12">
                                        <button type="button" class="btn btn-sm btn-primary mt-2 mr-2" id="ClickSenin">
                                            Senin
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info mt-2 mr-2" id="ClickSelasa">
                                            Selasa
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info mt-2 mr-2" id="ClickRabu">
                                            Rabu
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info mt-2 mr-2" id="ClickKamis">
                                            Kamis
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info mt-2 mr-2" id="ClickJumat">
                                            Jumat
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info mt-2 mr-2" id="ClickSabtu">
                                            Sabtu
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info mt-2 mr-2" id="ClickMinggu">
                                            Minggu
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary mt-2 mr-2" data-toggle="modal" data-target="#ModalUpdateToHfis">
                                            <i class="ti ti-reload"></i> Update Ke HFIS
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="MenampilkanTabelJadwal">
                                <!--  menampilkan data Siswa disini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>