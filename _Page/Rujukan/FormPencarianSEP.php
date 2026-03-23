<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="25";
    }
?>
<div class="table-responsive pre-scrollable">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th class="text-center"><dt>No</dt></th>
                <th class="text-center"><dt>No.REG</dt></th>
                <th class="text-center"><dt>No.SEP</dt></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE sep!='' ORDER BY id_kunjungan DESC LIMIT $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE (sep!='') AND (id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%'  OR sep like '%$keyword%' OR nama like '%$keyword%' OR tanggal like '%$keyword%') ORDER BY id_kunjungan DESC LIMIT $batas");
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_kunjungan = $data['id_kunjungan'];
                    $id_pasien= $data['id_pasien'];
                    $nik= $data['nik'];
                    $no_bpjs= $data['no_bpjs'];
                    $nama= $data['nama'];
                    $sep= $data['sep'];
                    $tanggal= $data['tanggal'];
                    $tujuan= $data['tujuan'];
                ?>
                    <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalPilihSep" data-id="<?php echo "$sep";?>" onmousemove="this.style.cursor='pointer'">
                    <td class="" align="center"><?php echo "$no";?></td>
                    <td class="" align="left">
                        <?php echo "<dt>$id_kunjungan</dt>";?>
                        <small>RM: <?php echo "$id_pasien";?></small><br>
                        <small>NIK: <?php echo "$nik";?></small><br>
                        <small>BPJS: <?php echo "$no_bpjs";?></small><br>
                    </td>
                    <td class="" align="left">
                        <?php echo "<dt>$sep</dt>";?>
                        <small>Tanggal: <?php echo "$tanggal";?></small><br>
                        <small>Pasien: <?php echo "$nama";?></small><br>
                        <small>Tujuan: <?php echo "$tujuan";?></small><br>
                    </td>
                </tr>
            <?php
                $no++; }
            ?>
        </tbody>
    </table>
    
</div>