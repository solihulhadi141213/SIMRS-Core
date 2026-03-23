<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['keyword_poli'])){
        $keyword=$_POST['keyword_poli'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="5";
    }
?>
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th class="text-center"><dt>Kode</dt></th>
                <th class="text-center"><dt>Poliklinik</dt></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM poliklinik ORDER BY id_poliklinik DESC LIMIT $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM poliklinik WHERE nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY id_poliklinik DESC LIMIT $batas");
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_poliklinik= $data['id_poliklinik'];
                    $nama= $data['nama'];
                    $kode= $data['kode'];
                ?>
                    <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalKonfirmasiPoli" data-id="<?php echo "$id_poliklinik";?>" onmousemove="this.style.cursor='pointer'">
                    <td class="" align="center"><?php echo "$kode";?></td>
                    <td class="" align="left"><?php echo "$nama";?></td>
                </tr>
            <?php
                $no++; }
            ?>
        </tbody>
    </table>
</div>