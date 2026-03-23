<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Validasi code
    if(empty($_FILES['file_import']['name'])) {
        echo '<span class="text-danger">File Tidak Boleh Kosong</span>';
    }else{
        //get the csv file 
        $file = $_FILES['file_import']['tmp_name']; 
        $handle = fopen($file, "r");
        $i = 0;
        while (($data=fgetcsv($handle, 1000, ";"))!== FALSE) {
            if ($i > 0) {
                $code_baru=$data[0];
                //Cek apakah ada code yang sama
                $id_referensi_alergi=getDataDetail($Conn,'referensi_alergi','code',$code_baru,'id_referensi_alergi');
                if(!empty($id_referensi_alergi)){
                    //Apabila ada update
                    $UpdateAlergi = mysqli_query($Conn,"UPDATE referensi_alergi SET 
                        code='$data[0]',
                        display='$data[1]',
                        sumber='$data[2]'
                    WHERE id_referensi_alergi='$id_referensi_alergi'") or die(mysqli_error($Conn)); 
                    if($UpdateAlergi){
                        echo ''.$i.'. Update Berhasil<br>';
                    }else{
                        echo ''.$i.'. Update Gagal<br>';
                    }
                }else{
                    $entry="INSERT INTO referensi_alergi (
                        code,
                        display,
                        sumber
                    ) VALUES (
                        '$data[0]',
                        '$data[1]',
                        '$data[2]'
                    )";
                    $Input=mysqli_query($Conn, $entry);
                    if($Input){
                        echo ''.$i.'. Insert Berhasil<br>';
                    }else{
                        echo ''.$i.'. Insert Gagal '.$data[0].'|'.$data[1].'|'.$data[2].'<br>';
                    }
                }
            }
            $i++;
        }
        fclose($handle);
        echo '<span class="text-success" id="NotifikasiImportAlergiBerhasil">Success</span>';
    }
?>