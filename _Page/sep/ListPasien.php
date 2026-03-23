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
        $batas="10";
    }
    $no = 1;
    if(empty($keyword)){
        $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY id_pasien DESC LIMIT $batas");
    }else{
        $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien like '%$keyword%' OR nik like '%$keyword%' OR no_bpjs like '%$keyword%' OR nama like '%$keyword%' ORDER BY id_pasien DESC LIMIT $batas");
    }
    while ($data = mysqli_fetch_array($query)) {
        if(empty($data['id_pasien'])){
            $id_pasien='<span class="text-danger">None</span>';
        }else{
            $id_pasien= $data['id_pasien'];
        }
        if(empty($data['nik'])){
            $nik='<span class="text-danger">None</span>';
        }else{
            $nik= $data['nik'];
        }
        if(empty($data['no_bpjs'])){
            $no_bpjs='<span class="text-danger">None</span>';
        }else{
            $no_bpjs= $data['no_bpjs'];
        }
        if(empty($data['no_bpjs'])){
            $no_bpjs='<span class="text-danger">None</span>';
        }else{
            $no_bpjs= $data['no_bpjs'];
        }
        if(empty($data['nama'])){
            $nama='<span class="text-danger">None</span>';
        }else{
            $nama= $data['nama'];
        }
        if(empty($data['gender'])){
            $gender='<span class="text-danger">None</span>';
        }else{
            $gender= $data['gender'];
        }
    ?>
        <li class="list-group-item" tabindex="0" data-toggle="modal" data-target="#ModalPilihKunjungan" data-id="<?php echo "$id_pasien";?>" onmousemove="this.style.cursor='pointer'">
            <?php 
                echo '<dt class="text-primary">'.$nama.'</dt>';
                echo 'No.RM : <code class="text-secondary">'.$id_pasien.'</code><br>';
                echo 'No.KTP : <code class="text-secondary">'.$nik.'</code><br>';
                echo 'No.BPJS : <code class="text-secondary">'.$no_bpjs.'</code><br>';
                echo 'Gender : <code class="text-secondary">'.$gender.'</code><br>';
            ?>
        </li>
<?php
    $no++; }
?>