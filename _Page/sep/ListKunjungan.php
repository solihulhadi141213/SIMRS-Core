<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['id_pasien'])){
        $id_pasien=$_POST['id_pasien'];
        $no = 1;
        $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$id_pasien' ORDER BY id_kunjungan");
        while ($data = mysqli_fetch_array($query)) {
            if(empty($data['id_kunjungan'])){
                $id_kunjungan='<span class="text-danger">None</span>';
            }else{
                $id_kunjungan= $data['id_kunjungan'];
            }
            if(empty($data['sep'])){
                $sep='<span class="text-danger">None</span>';
            }else{
                $sep= $data['sep'];
            }
            if(empty($data['tanggal'])){
                $tanggal='<span class="text-danger">None</span>';
            }else{
                $tanggal= $data['tanggal'];
            }
            if(empty($data['tujuan'])){
                $tujuan='<span class="text-danger">None</span>';
            }else{
                $tujuan= $data['tujuan'];
            }
            if(empty($data['pembayaran'])){
                $pembayaran='<span class="text-danger">None</span>';
            }else{
                $pembayaran= $data['pembayaran'];
            }
    ?>
        <li class="list-group-item">
            <a href="index.php?Page=sep&Sub=BuatSep&id_kunjungan=<?php echo ''.$id_kunjungan.'';?>">
                <?php 
                    echo '<dt class="text-primary">'.$id_kunjungan.'</dt>';
                    echo 'Tanggal : <code class="text-secondary">'.$tanggal.'</code><br>';
                    echo 'Tujuan : <code class="text-secondary">'.$tujuan.'</code><br>';
                    echo 'Pembayaran : <code class="text-secondary">'.$pembayaran.'</code><br>';
                    echo 'SEP : <code class="text-secondary">'.$sep.'</code><br>';
                ?>
            </a>
        </li>
<?php
            $no++; 
        }
    }
?>