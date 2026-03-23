<?php
    if(empty($_GET['Judul'])){
        include "_Page/Bantuan/NotifikasiBantuanTidakAda.php";
    }else{
        $Judul=$_GET['Judul'];
        if($Judul=="Bantuan1"){
            include "_Page/Bantuan/ListBantuan/SpesifikasiAplikasi.php";
        }else{
            if($Judul=="Bantuan2"){
                include "_Page/Bantuan/ListBantuan/MenggunakanAplikasi.php";
            }else{
                if($Judul=="Bantuan3"){
                    include "_Page/Bantuan/ListBantuan/KelolaAkses.php";
                }else{
                    if($Judul=="Bantuan4"){
                        include "_Page/Bantuan/ListBantuan/MenambahDataGuru.php";
                    }else{
                        if($Judul=="Bantuan5"){
                            include "_Page/Bantuan/ListBantuan/MenambahDataSiswa.php";
                        }else{
                            include "_Page/Bantuan/NotifikasiBantuanTidakAda.php";
                        }
                    }
                }
            }
        }
    }

?>