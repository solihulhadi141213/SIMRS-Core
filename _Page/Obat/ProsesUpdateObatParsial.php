<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['id_obat'])){
        echo '<tr>';
        echo '  <td colspan="6" class="text-center">';
        echo '      <span class="text-danger">Tidak ada data yang dipilih!</span>';
        echo '  </td>';
        echo '</tr>';
    }else{
        if(empty($_POST['KategoriParsial'])){
            $kategori="";
        }else{
            $kategori=$_POST['KategoriParsial'];
        }
        if(empty($_POST['KelompokParsial'])){
            $kelompok="";
        }else{
            $kelompok=$_POST['KelompokParsial'];
        }
        if(empty($_POST['SatuanParsial'])){
            $satuan="";
        }else{
            $satuan=$_POST['SatuanParsial'];
        }
        if(empty($_POST['stok_minimum'])){
            $stok_minimum="";
        }else{
            $stok_minimum=$_POST['stok_minimum'];
        }
        $id_obat=$_POST['id_obat'];
        $JumlahIdObat=count($id_obat);
        $no=1;
        for($x=0; $x<$JumlahIdObat; $x++){
            $IdObat=$id_obat[$x];
            //Proses Update
            if(!empty($kelompok)){
                $UpdateKelompok=mysqli_query($Conn, "UPDATE obat SET kelompok='$kelompok' WHERE id_obat='$IdObat'");
                if($UpdateKelompok){
                    $StatusKelompok='<small class="text-success">Kelompok Berhasil</small><br>';
                }else{
                    $StatusKelompok='<small class="text-danger">Kelompok Gagal</small><br>';
                }
            }else{
                $StatusKelompok="";
            }
            if(!empty($kategori)){
                $UpdateKategoriObat=mysqli_query($Conn, "UPDATE obat SET kategori='$kategori' WHERE id_obat='$IdObat'");
                if($UpdateKategoriObat){
                    $StatusKategori='<small class="text-success">Kategori Berhasil</small><br>';
                }else{
                    $StatusKategori='<small class="text-danger">Kategori Gagal</small><br>';
                }
            }else{
                $StatusKategori="";
            }
            if(!empty($satuan)){
                $UpdatesatuanObat=mysqli_query($Conn, "UPDATE obat SET satuan='$satuan' WHERE id_obat='$IdObat'");
                if($UpdatesatuanObat){
                    $Statussatuan='<small class="text-success">Satuan Berhasil</small><br>';
                }else{
                    $Statussatuan='<small class="text-danger">Satuan Gagal</small><br>';
                }
            }else{
                $Statussatuan="";
            }
            if(!empty($stok_minimum)){
                $UpdateStokObat=mysqli_query($Conn, "UPDATE obat SET stok_min='$stok_minimum' WHERE id_obat='$IdObat'");
                if($UpdateStokObat){
                    $StatusStok='<small class="text-success">Stok Berhasil</small><br>';
                }else{
                    $StatusStok='<small class="text-danger">Stok Gagal</small><br>';
                }
            }else{
                $StatusStok="";
            }
            $status="$StatusKategori $StatusKelompok $Statussatuan $StatusStok";
            $QryObat = mysqli_query($Conn,"SELECT * FROM obat WHERE id_obat='$IdObat'")or die(mysqli_error($Conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $kode=$DataObat['kode'];
            $nama_obat=$DataObat['nama'];
            $kategori_list=$DataObat['kategori'];
            $kelompok_list=$DataObat['kelompok'];
            $satuan_list=$DataObat['satuan'];
            $stok_min=$DataObat['stok_min'];
            echo '<input type="hidden" name="id_obat[]" value="'.$IdObat.'">';
            echo '<tr>';
            echo '  <td class="text-center">'.$no.'</td>';
            echo '  <td class="text-left"><dt>'.$kode.'</dt> '.$nama_obat.'</td>';
            echo '  <td class="text-left">'.$kelompok_list.'</td>';
            echo '  <td class="text-left">'.$kategori_list.'</td>';
            echo '  <td class="text-left">'.$stok_min.' '.$satuan_list.'</td>';
            echo '  <td class="text-center">'.$status.'</td>';
            echo '</tr>';
            $no++;
        }
    }
?>