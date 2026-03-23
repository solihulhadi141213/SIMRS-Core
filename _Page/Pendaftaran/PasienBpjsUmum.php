<?php
    if(empty($_GET['kategori'])){
        $kategori="baru";
    }else{
        $kategori=$_GET['kategori'];
    }
?>
<div class="card card-body">
    <div class="row">
        <?php
            if($kategori=="baru"){
                echo "<div class='col-md-12 bg-info'>";
                echo "  <small>";
                echo '      <p class="text-muted">';
                echo "          <h3>Pendaftaran Pasien Baru</h3>";
                echo "          <ul>";
                echo "              <li>1. Untuk Pasien BPJS pastikan anda memiliki Nomor Kartu BPJS atau KTP (NIK) untuk syarat pendaftaran</li>";
                echo "              <li>2. Untuk Pasien Umum pastikan anda memiliki KTP (NIK) untuk syarat pendaftaran</li>";
                echo "          </ul>";
                echo "      </p>";
                echo "  </small>";
                echo "</div>";
            }else{
                echo "<div class='col-md-12 bg-success'>";
                echo "  <small>";
                echo '      <p class="text-muted">';
                echo "          <h3>Pendaftaran Pasien Lama</h3>";
                echo "          <ul>";
                echo "              <li>1. Untuk Pasien BPJS pastikan anda memiliki nomor RM atau NIK dan nomor Kartu BPJS untuk pencarian data anda</li>";
                echo "              <li>2. Untuk Pasien Umum pastikan anda memiliki nomor RM atau NIK untuk pencarian data anda</li>";
                echo "          </ul>";
                echo "      </p>";
                echo "  </small>";
                echo "</div>";
            }
        ?>
    </div>
</div>
<div class="card card-body">
    <div class="row">
        <div class="col-md-6 mt-1 bordered text-center">
            <dt>PASIEN UMUM</dt><br>
            <b>
                Apabila anda ingin mendaftar sebagai pasien umum, 
                silahkan pilih tombol dibawah ini untuk melanjutkan proses.
            </b>
            <p class="mt-2">
                <a href="Pendaftaran.php?page=PendaftaranUmum&kategori=<?php echo $kategori;?>" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                    Pendaftaran Pasien Umum
                </a>
            </p>
            
        </div>
        <div class="col-md-6 mt-1 bordered text-center">
            <dt>PASIEN BPJS</dt><br>
            <b>
                Apabila anda ingin mendaftar sebagai pasien BPJS, 
                silahkan pilih tombol dibawah ini untuk melanjutkan proses.
            </b>
            <p class="mt-2">
                <a href="Pendaftaran.php?page=PendaftaranBpjs&kategori=<?php echo $kategori;?>" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                    Pendaftaran Pasien BPJS
                </a>
            </p>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-1 text-center">
            <a href="Pendaftaran.php?page=pendaftaran" class="btn btn-default btn-md waves-effect waves-light text-center m-b-20">
                <i class="ti ti-arrow-circle-left"></i> Kembali
            </a>
        </div>
    </div>
</div>