<?php
    //panggil dari database
    $Qry = mysqli_query($Conn,"SELECT * FROM setting_profile WHERE status='Active'")or die(mysqli_error($Conn));
    $Data = mysqli_fetch_array($Qry);
    //rincian profile user
    if(empty($Data['id_profile'])){
        $KodeFaskes="";
        $NamaFaskes="";
        $AlamatFaskes="";
        $KontakFaskes="";
        $EmailFaskes="";
        $LinkWebsiteFaskes="";
        $BaseUrl="";
        $TahunBerdiriFaskes="";
        $DirekturFaskes="";
        $VisiFaskes="";
        $MisiFaskes="";
        $judul_tab="";
        $judul_halaman="";
        $warna="";
        $favicon="";
        $logo="";
    }else{
        $KodeFaskes= $Data['kode_faskes'];
        $NamaFaskes= $Data['nama_faskes'];
        $AlamatFaskes= $Data['alamat_faskes'];
        $KontakFaskes= $Data['kontak_faskes'];
        $EmailFaskes= $Data['email_faskes'];
        $LinkWebsiteFaskes= $Data['link_website'];
        $BaseUrl= $Data['base_url'];
        $TahunBerdiriFaskes= $Data['tahun_berdiri'];
        $DirekturFaskes= $Data['direktur_faskes'];
        $VisiFaskes= $Data['visi_faskes'];
        $MisiFaskes= $Data['misi_faskes'];
        $judul_tab= $Data['judul_tab'];
        $judul_halaman= $Data['judul_halaman'];
        $warna= $Data['warna'];
        $favicon= $Data['favicon'];
        $logo= $Data['logo'];
    }
?>