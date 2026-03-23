<?php
    if(empty($_POST['resikoi_jatuh_mfs1'])){
        $mfs1=0;
    }else{
        $mfs1=$_POST['resikoi_jatuh_mfs1'];
    }
    if(empty($_POST['resikoi_jatuh_mfs2'])){
        $mfs2=0;
    }else{
        $mfs2=$_POST['resikoi_jatuh_mfs2'];
    }
    if(empty($_POST['resikoi_jatuh_mfs3'])){
        $mfs3=0;
    }else{
        $mfs3=$_POST['resikoi_jatuh_mfs3'];
    }
    if(empty($_POST['resikoi_jatuh_mfs4'])){
        $mfs4=0;
    }else{
        $mfs4=$_POST['resikoi_jatuh_mfs4'];
    }
    if(empty($_POST['resikoi_jatuh_mfs5'])){
        $mfs5=0;
    }else{
        $mfs5=$_POST['resikoi_jatuh_mfs5'];
    }
    if(empty($_POST['resikoi_jatuh_mfs6'])){
        $mfs6=0;
    }else{
        $mfs6=$_POST['resikoi_jatuh_mfs6'];
    }
    $JumlahTotal=$mfs1+$mfs2+$mfs3+$mfs4+$mfs5+$mfs6;
    if($JumlahTotal<=24){
        $Kategori="Resiko Rendah";
    }else{
        if($JumlahTotal<=44){
            $Kategori="Resiko Sedang";
        }else{
            if($JumlahTotal>=45){
                $Kategori="Resiko Tinggi";
            }else{
                $Kategori="Tidak Diketahui";
            }
        }
    }
    echo "Skor $JumlahTotal ($Kategori)";
?>