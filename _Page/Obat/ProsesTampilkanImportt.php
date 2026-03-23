<?php
    //Koneksi
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    // phpinfo(); 
    include "../../_Config/Connection.php";
    require "../../vendor/excel_reader/php-excel-reader/excel_reader2.php";
    require "../../vendor/excel_reader/SpreadsheetReader.php";
    //Validasi file
    if(empty(explode(".",$_FILES['file_import']['name']))){
        echo '<tr><td colspan="5" class="text-center"><span class="text-danger">File belum dipilih</span></td></tr>';
    }else{
        $ekstensi = explode(".",$_FILES['file_import']['name']);
        $file_extension = end($ekstensi);
        if($file_extension != 'xls' && $file_extension != 'xlsx'){
            echo '<tr><td colspan="5" class="text-center"><span class="text-danger">File yang diperbolehkan hanya file Excel</span></td></tr>';
        }else{
            $uploadFilePath = 'import/'.basename($_FILES['file_import']['name']);
            move_uploaded_file($_FILES['file_import']['tmp_name'], $uploadFilePath);
            $Reader = new SpreadsheetReader($uploadFilePath);
            $totalSheet = count($Reader->sheets());
            for ($i=0; $i<=$totalSheet; $i++){
                $i=$i+1;
                $Reader->ChangeSheet($i);
                $no=0;
                foreach ($Reader as $Row){
                    $nomor_baris=isset($Row[0]) ? $Row[0] : '';
                    $kode=isset($Row[1]) ? $Row[1] : '';
                    $nama_obat=isset($Row[2]) ? $Row[2] : '';
                    $kategori=isset($Row[3]) ? $Row[3] : '';
                    $satuan=isset($Row[4]) ? $Row[4] : '';
                    $isi=isset($Row[5]) ? $Row[5] : '';
                    $stok=isset($Row[6]) ? $Row[6] : '';
                    $harga_1=isset($Row[7]) ? $Row[7] : '';
                    $harga_2=isset($Row[8]) ? $Row[8] : '';
                    $harga_3=isset($Row[9]) ? $Row[9] : '';
                    $harga_4=isset($Row[10]) ? $Row[10] : '';
                    $min=isset($Row[1]) ? $Row[11] : '';
                    //Validasi kode
                    $ValidasiKode=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kode='$kode'"));
                    if(!empty($ValidasiKode)){
                        $Status='<span class="text-danger">Duplikat</span>';
                    }else{
                        $Status='<span class="text-primary">Ready</span>';
                    }
                    //Apabila kontak tidak diawali 62
                    if($no==0){
                        echo '<tr><td colspan="5" class="text-center"><span class="text-success">File Berhasil Dibaca</span></td></tr>';
                    }else{
                        echo '<tr>';
                        echo '  <td class="text-center">';
                        // echo '      <input type="checkbox" name="ImportItem[]" value="'.$no.'">';
                        echo '      '.$no.'';
                        echo '  </td>';
                        echo '  <td class="text-left">';
                        echo '      <small>';
                        echo '          <dt>'.$nama_obat.'</dt>';
                        echo '          Kode: '.$kode.'<br>';
                        echo '          Kategori:'.$kategori.'<br>';
                        echo '      </small>';
                        echo '  </td>';
                        echo '  <td class="text-left">';
                        echo '      <small>';
                        echo '          <dt>'.$satuan.'</dt>';
                        echo '          Isi: '.$isi.'<br>';
                        echo '          Stok:'.$stok.' '.$satuan.'<br>';
                        echo '          Min:'.$min.' '.$satuan.'<br>';
                        echo '      </small>';
                        echo '  </td>';
                        echo '  <td class="text-left">';
                        echo '      <small>';
                        echo '          Harga 1: '.$harga_1.'<br>';
                        echo '          Harga 2:'.$harga_2.'<br>';
                        echo '          Harga 3:'.$harga_3.'<br>';
                        echo '          Harga 4:'.$harga_4.'<br>';
                        echo '      </small>';
                        echo '  </td>';
                        echo '  <td class="text-left">';
                        echo '      '.$Status.'';
                        echo '  </td>';
                        echo '</tr>';
                    } 
                    $no++;    
                } 
            }
            echo '</table>';
        }
    }
?>