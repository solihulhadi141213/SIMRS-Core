<?php
    //Koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['keyword'])){
        $keyword="";
    }else{
        $keyword=$_POST['keyword'];
    }
?>
<div class="modal-body">
    <div class="table table-responsive pre-scrollable">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><dt>No</dt></th>
                    <th class="text-center"><dt>Tanggal</dt></th>
                    <th class="text-center"><dt>No.BPJS</dt></th>
                    <th class="text-center"><dt>Nama</dt></th>
                    <th class="text-center"><dt>No.SEP</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no=1;
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama ORDER BY id_kunjungan DESC LIMIT 20");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE (id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR sep like '%$keyword%' OR nama like '%$keyword%' OR tanggal like '%$keyword%') ORDER BY id_kunjungan DESC LIMIT 20");
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_kunjungan= $data['id_kunjungan'];
                        $id_pasien= $data['id_pasien'];
                        $no_antrian= $data['no_antrian'];
                        $nik= $data['nik'];
                        $no_bpjs= $data['no_bpjs'];
                        $sep= $data['sep'];
                        $noRujukan= $data['noRujukan'];
                        $skdp= $data['skdp'];
                        $nama= $data['nama'];
                        $tanggal= $data['tanggal'];
                        $tujuan= $data['tujuan'];
                        echo '<tr>';
                        echo '  <td class="text-center">'.$no.'</td>';
                        echo '  <td class="text-left"><small><dt>'.$tujuan.'</dt>'.$tanggal.'</small></td>';
                        echo '  <td class="text-left"><small><a href="javascript:void(0);" data-toggle="modal" data-target="#ModalKonfirmasiPilihBpjs" data-id="'.$no_bpjs.'"">'.$no_bpjs.'</a></small></td>';
                        echo '  <td class="text-left"><small><dt>'.$nama.'</dt>RM: '.$id_pasien.'</small></td>';
                        echo '  <td class="text-left"><small><a href="javascript:void(0);" data-toggle="modal" data-target="#ModalKonfirmasiPilihSep" data-id="'.$sep.'"">'.$sep.'</a></small></td>';
                        echo '</tr>';
                    $no++;}
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer bg-primary">
    <div class="row">
        <div class="col-md-12 mb-3">
            <button type="button" class="btn btn-md btn-light btn-round mt-2 mr-2" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
    </div>
</div>