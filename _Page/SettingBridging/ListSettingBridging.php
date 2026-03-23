<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menghitung jumlah data setting
    $JumlahProfile = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bridging"));
    //Menghitung Jumlah Data Profile Setting Yang Aktif
    $JumlahProfileAktiv = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bridging WHERE status='Aktiv'"));
    //Kondisi apabila tidak ada data setting profile
    if(empty($JumlahProfile)){
        echo '<div class="col-md-4">';
        echo '  <div class="card bg-danger">';
        echo '      <div class="card-body text-center text-white">';
        echo '          <dt><i class="icofont-warning-alt icofont-5x"></i></dt>';
        echo '          <dt>Maaf!!</dt>';
        echo '          Belum ada data profile setting bridging, silahkan buat dulu!!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($JumlahProfileAktiv)){
            echo '<div class="col-md-4">';
            echo '  <div class="card bg-danger">';
            echo '      <div class="card-body text-center text-white">';
            echo '          <dt><i class="icofont-warning-alt icofont-5x"></i></dt>';
            echo '          <dt>Perhatian!!</dt>';
            echo '          Tolong aktifkan salah satu profil setting bridging agar tidak error!!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM bridging ORDER BY id_bridging DESC");
            while ($data = mysqli_fetch_array($query)) {
                $id_bridging= $data['id_bridging'];
                $nama_bridging= $data['nama_bridging'];
                $consid= $data['consid'];
                $user_key= $data['user_key'];
                $secret_key= $data['secret_key'];
                $kode_ppk= $data['kode_ppk'];
                $url_vclaim= $data['url_vclaim'];
                $url_aplicare= $data['url_aplicare'];
                $url_faskes= $data['url_faskes'];
                $status= $data['status'];
?>
    <div class="col-md-4">
        <div class="card <?php if($status=="Aktiv"){echo "bg-primary";}else{echo "bg-info";} ?>">
            <div class="card-body">
                <dt><?php echo "$no. $nama_bridging"; ?></dt>
                Status : <?php echo "$status"; ?>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-sm btn-inverse btn-round mt-1 mr-1" data-toggle="modal" data-target="#ModalConsol" data-id="<?php echo "$id_bridging"; ?>">
                    <i class="icofont-console"></i> Consol
                </button>
                <button type="button" class="btn btn-sm btn-light btn-round mt-1 mr-1" data-toggle="modal" data-target="#ModalEditBridging" data-id="<?php echo "$id_bridging"; ?>">
                    <i class="icofont-edit"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-round mt-1 mr-1" data-toggle="modal" data-target="#ModalHapusBridging" data-id="<?php echo "$id_bridging"; ?>">
                    <i class="icofont-bin"></i> Hapus
                </button>
            </div>
        </div>
    </div>
<?php $no++;}} ?>