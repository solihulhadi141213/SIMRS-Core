<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['TanggalRekapitulasi'])){
        echo '<tr>';
        echo '  <td colspan="8" class="text-danger text-center">';
        echo '      Tanggal Tidak Boleh Kosong!';
        echo '  </td>';
        echo '</tr>';
    }else{
        $tanggal=$_POST['TanggalRekapitulasi'];
        //Hitung Jumlah Setiap Kategori nakes
        $co_ass = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Co Ass'"));
        $co_ass_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Co Ass' AND status='Sembuh'"));
        $co_ass_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Co Ass' AND status='Isoman'"));
        $co_ass_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Co Ass' AND status='Dirawat'"));
        $co_ass_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Co Ass' AND status='Meninggal'"));

        $residen = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Residen'"));
        $residen_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Residen' AND status='Sembuh'"));
        $residen_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Residen' AND status='Isoman'"));
        $residen_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Residen' AND status='Dirawat'"));
        $residen_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Residen' AND status='Meninggal'"));

        $intership = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Intership'"));
        $intership_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Intership' AND status='Sembuh'"));
        $intership_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Intership' AND status='Isoman'"));
        $intership_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Intership' AND status='Dirawat'"));
        $intership_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Intership' AND status='Meninggal'"));

        $dokter_spesialis = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Dokter Spesialis'"));
        $dokter_spesialis_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Spesialis' AND status='Sembuh'"));
        $dokter_spesialis_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Spesialis' AND status='Isoman'"));
        $dokter_spesialis_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Spesialis' AND status='Dirawat'"));
        $dokter_spesialis_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Spesialis' AND status='Meninggal'"));

        $dokter_umum = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Dokter Umum'"));
        $dokter_umum_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Umum' AND status='Sembuh'"));
        $dokter_umum_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Umum' AND status='Isoman'"));
        $dokter_umum_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Umum' AND status='Dirawat'"));
        $dokter_umum_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Umum' AND status='Meninggal'"));

        $dokter_gigi = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Dokter Gigi'"));
        $dokter_gigi_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Gigi' AND status='Sembuh'"));
        $dokter_gigi_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Gigi' AND status='Isoman'"));
        $dokter_gigi_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Gigi' AND status='Dirawat'"));
        $dokter_gigi_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Dokter Gigi' AND status='Meninggal'"));


        $perawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Perawat'"));
        $perawat_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Perawat' AND status='Sembuh'"));
        $perawat_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Perawat' AND status='Isoman'"));
        $perawat_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Perawat' AND status='Dirawat'"));
        $perawat_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Perawat' AND status='Meninggal'"));

        $bidan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Bidan'"));
        $bidan_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Bidan' AND status='Sembuh'"));
        $bidan_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Bidan' AND status='Isoman'"));
        $bidan_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Bidan' AND status='Dirawat'"));
        $bidan_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Bidan' AND status='Meninggal'"));

        $apoteker = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Apoteker'"));
        $apoteker_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Apoteker' AND status='Sembuh'"));
        $apoteker_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Apoteker' AND status='Isoman'"));
        $apoteker_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Apoteker' AND status='Dirawat'"));
        $apoteker_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Apoteker' AND status='Meninggal'"));

        $radiografer = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Radiografer'"));
        $radiografer_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Radiografer' AND status='Sembuh'"));
        $radiografer_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Radiografer' AND status='Isoman'"));
        $radiografer_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Radiografer' AND status='Dirawat'"));
        $radiografer_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Radiografer' AND status='Meninggal'"));

        $analis_lab = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Analis Lab'"));
        $analis_lab_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Analis Lab' AND status='Sembuh'"));
        $analis_lab_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Analis Lab' AND status='Isoman'"));
        $analis_lab_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Analis Lab' AND status='Dirawat'"));
        $analis_lab_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Analis Lab' AND status='Meninggal'"));

        $nakes_lainnya = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kategori='Nakes Lainnya'"));
        $nakes_lainnya_sembuh = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Nakes Lainnya' AND status='Sembuh'"));
        $nakes_lainnya_isoman = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Nakes Lainnya' AND status='Isoman'"));
        $nakes_lainnya_dirawat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Nakes Lainnya' AND status='Dirawat'"));
        $nakes_lainnya_meninggal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_terinfeksi WHERE tanggal='$tanggal' AND kategori='Nakes Lainnya' AND status='Meninggal'"));
?>
    <input type="hidden" name="tanggal" class="form-control" value="<?php echo $tanggal;?>">
    <tr>
        <td class="text-center">1</td>
        <td class="text-left">Co Ass</td>
        <td class="text-center"><input type="number" min="0" name="co_ass" class="form-control" value="<?php echo $co_ass;?>"></td>
        <td class="text-center"><input type="number" min="0" name="co_ass_sembuh" class="form-control" value="<?php echo $co_ass_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="co_ass_isoman" class="form-control" value="<?php echo $co_ass_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="co_ass_dirawat" class="form-control" value="<?php echo $co_ass_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="co_ass_meninggal" class="form-control" value="<?php echo $co_ass_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">2</td>
        <td class="text-left">Residen</td>
        <td class="text-center"><input type="number" min="0" name="residen" class="form-control" value="<?php echo $residen;?>"></td>
        <td class="text-center"><input type="number" min="0" name="residen_sembuh" class="form-control" value="<?php echo $residen_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="residen_isoman" class="form-control" value="<?php echo $residen_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="residen_dirawat" class="form-control" value="<?php echo $residen_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="residen_meninggal" class="form-control" value="<?php echo $residen_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">3</td>
        <td class="text-left">Intership</td>
        <td class="text-center"><input type="number" min="0" name="intership" class="form-control" value="<?php echo $intership;?>"></td>
        <td class="text-center"><input type="number" min="0" name="intership_sembuh" class="form-control" value="<?php echo $intership_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="intership_isoman" class="form-control" value="<?php echo $intership_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="intership_dirawat" class="form-control" value="<?php echo $intership_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="intership_meninggal" class="form-control" value="<?php echo $intership_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">4</td>
        <td class="text-left">Dokter Spesialis</td>
        <td class="text-center"><input type="number" min="0" name="dokter_spesialis" class="form-control" value="<?php echo $dokter_spesialis;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_spesialis_sembuh" class="form-control" value="<?php echo $dokter_spesialis_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_spesialis_isoman" class="form-control" value="<?php echo $dokter_spesialis_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_spesialis_dirawat" class="form-control" value="<?php echo $dokter_spesialis_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_spesialis_meninggal" class="form-control" value="<?php echo $dokter_spesialis_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">5</td>
        <td class="text-left">Dokter Umum</td>
        <td class="text-center"><input type="number" min="0" name="dokter_umum" class="form-control" value="<?php echo $dokter_umum;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_umum_sembuh" class="form-control" value="<?php echo $dokter_umum_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_umum_isoman" class="form-control" value="<?php echo $dokter_umum_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_umum_dirawat" class="form-control" value="<?php echo $dokter_umum_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_umum_meninggal" class="form-control" value="<?php echo $dokter_umum_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">6</td>
        <td class="text-left">Dokter Gigi</td>
        <td class="text-center"><input type="number" min="0" name="dokter_gigi" class="form-control" value="<?php echo $dokter_gigi;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_gigi_sembuh" class="form-control" value="<?php echo $dokter_gigi_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_gigi_isoman" class="form-control" value="<?php echo $dokter_gigi_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_gigi_dirawat" class="form-control" value="<?php echo $dokter_gigi_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="dokter_gigi_meninggal" class="form-control" value="<?php echo $dokter_gigi_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">7</td>
        <td class="text-left">Perawat</td>
        <td class="text-center"><input type="number" min="0" name="perawat" class="form-control" value="<?php echo $perawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="perawat_sembuh" class="form-control" value="<?php echo $perawat_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="perawat_isoman" class="form-control" value="<?php echo $perawat_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="perawat_dirawat" class="form-control" value="<?php echo $perawat_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="perawat_meninggal" class="form-control" value="<?php echo $perawat_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">8</td>
        <td class="text-left">Bidan</td>
        <td class="text-center"><input type="number" min="0" name="bidan" class="form-control" value="<?php echo $bidan;?>"></td>
        <td class="text-center"><input type="number" min="0" name="bidan_sembuh" class="form-control" value="<?php echo $bidan_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="bidan_isoman" class="form-control" value="<?php echo $bidan_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="bidan_dirawat" class="form-control" value="<?php echo $bidan_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="bidan_meninggal" class="form-control" value="<?php echo $bidan_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">9</td>
        <td class="text-left">Apoteker</td>
        <td class="text-center"><input type="number" min="0" name="apoteker" class="form-control" value="<?php echo $apoteker;?>"></td>
        <td class="text-center"><input type="number" min="0" name="apoteker_sembuh" class="form-control" value="<?php echo $apoteker_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="apoteker_isoman" class="form-control" value="<?php echo $apoteker_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="apoteker_dirawat" class="form-control" value="<?php echo $apoteker_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="apoteker_meninggal" class="form-control" value="<?php echo $apoteker_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">9</td>
        <td class="text-left">Radiografer</td>
        <td class="text-center"><input type="number" min="0" name="radiografer" class="form-control" value="<?php echo $radiografer;?>"></td>
        <td class="text-center"><input type="number" min="0" name="radiografer_sembuh" class="form-control" value="<?php echo $radiografer_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="radiografer_isoman" class="form-control" value="<?php echo $radiografer_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="radiografer_dirawat" class="form-control" value="<?php echo $radiografer_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="radiografer_meninggal" class="form-control" value="<?php echo $radiografer_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">9</td>
        <td class="text-left">Analis Lab</td>
        <td class="text-center"><input type="number" min="0" name="analis_lab" class="form-control" value="<?php echo $analis_lab;?>"></td>
        <td class="text-center"><input type="number" min="0" name="analis_lab_sembuh" class="form-control" value="<?php echo $analis_lab_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="analis_lab_isoman" class="form-control" value="<?php echo $analis_lab_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="analis_lab_dirawat" class="form-control" value="<?php echo $analis_lab_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="analis_lab_meninggal" class="form-control" value="<?php echo $analis_lab_meninggal;?>"></td>
    </tr>
    <tr>
        <td class="text-center">9</td>
        <td class="text-left">Nakes Lainnya</td>
        <td class="text-center"><input type="number" min="0" name="nakes_lainnya" class="form-control" value="<?php echo $nakes_lainnya;?>"></td>
        <td class="text-center"><input type="number" min="0" name="nakes_lainnya_sembuh" class="form-control" value="<?php echo $nakes_lainnya_sembuh;?>"></td>
        <td class="text-center"><input type="number" min="0" name="nakes_lainnya_isoman" class="form-control" value="<?php echo $nakes_lainnya_isoman;?>"></td>
        <td class="text-center"><input type="number" min="0" name="nakes_lainnya_dirawat" class="form-control" value="<?php echo $nakes_lainnya_dirawat;?>"></td>
        <td class="text-center"><input type="number" min="0" name="nakes_lainnya_meninggal" class="form-control" value="<?php echo $nakes_lainnya_meninggal;?>"></td>
    </tr>
<?php } ?>