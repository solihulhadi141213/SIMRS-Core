<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $Updatetime=date('Y-m-d H:i:s');
    //Tangkap Data Dari Form
    if(empty($_POST['id_obat_so'])){
        echo '  <span class="text-danger">';
        echo '      ID Stok Opename Item Tidak Boleh Kosong!';
        echo '  </span>';
    }else{
        if(empty($_POST['stok_akhir'])){
            $stok_akhir="0";
        }else{
            $stok_akhir=$_POST['stok_akhir'];
        }
        if(empty($_POST['keterangan'])){
            $keterangan="";
        }else{
            $keterangan=$_POST['keterangan'];
        }
        $id_obat_so=$_POST['id_obat_so'];
        //bUKA sTOK AWAL
        $stok_awal=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'stok_awal');
        //Hitung Selisih
        $Selisih=$stok_akhir-$stok_awal;
        //Update Data Stok Opename Item
        $UpdateSo=mysqli_query($Conn, "UPDATE obat_so SET 
            stok_awal='$stok_awal',
            stok_akhir='$stok_akhir',
            stok_selisih='$Selisih',
            keterangan='$keterangan'
        WHERE id_obat_so='$id_obat_so'");
        if($UpdateSo){
            //Update Ke penyimpanan Masing-masing
            if(empty($id_obat_storage)){
                $UpdateStokObat=mysqli_query($Conn, "UPDATE obat SET stok='$stok_akhir' WHERE id_obat='$id_obat'");
                if($UpdateStokObat){
                    //Simpan Log
                    $JsonUrl="../../_Page/Log/Log.json";
                    $MenyimpanLog=getSaveLog($Conn,$Updatetime,$SessionNama,"eDIT Stok Opename Berhasil","Stok Opename",$SessionIdAkses,$JsonUrl);
                    echo '<span class="text-danger" id="NotifikasiEditStokOpenameItemBerhasil">Success</span>';
                }else{
                    echo '  <span class="text-danger">';
                    echo '      Terjadi kesalahan pada saat melakukan update data obat di penyimpanan utama';
                    echo '  </span>';
                }
            }else{
                $UpdateStokObat=mysqli_query($Conn, "UPDATE obat_posisi SET stok='$stok_akhir' WHERE id_obat='$id_obat' AND id_obat_storage='$id_obat_storage'");
                if($UpdateStokObat){
                    //Simpan Log
                    $JsonUrl="../../_Page/Log/Log.json";
                    $MenyimpanLog=getSaveLog($Conn,$Updatetime,$SessionNama,"eDIT Stok Opename Berhasil","Stok Opename",$SessionIdAkses,$JsonUrl);
                    echo '<span class="text-danger" id="NotifikasiEditStokOpenameItemBerhasil">Success</span>';
                }else{
                    echo '  <span class="text-danger">';
                    echo '      Terjadi kesalahan pada saat melakukan update data obat pada id penyimpanan '.$id_obat_storage.'';
                    echo '  </span>';
                }
            }
        }
    }
?>