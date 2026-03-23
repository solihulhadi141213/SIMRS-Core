<?php
    if(!empty($_POST['GetTahunForm'])){
        $GetTahunForm=$_POST['GetTahunForm'];
    }else{
        $GetTahunForm="";
    }
    if(!empty($_POST['GetBulanForm'])){
        $GetBulanForm=$_POST['GetBulanForm'];
    }else{
        $GetBulanForm="";
    }
    if(!empty($_POST['GetWaktu'])){
        $GetWaktu=$_POST['GetWaktu'];
    }else{
        $GetWaktu="";
    }
    if(empty($_POST['PeriodeDataExport'])){
        echo '  <div class="col-md-12">';
        echo '      <label for="KeywordWaktu"><dt>Isi Tanggal</dt></label>';
        echo '      <input type="date" class="form-control" id="KeywordWaktu" name="KeywordWaktu" value="'.$GetWaktu.'">';
        echo '  </div>';
    }else{
        $PeriodeDataExport=$_POST['PeriodeDataExport'];
        if($PeriodeDataExport=="Tahunan"){
            echo '  <div class="col-md-12">';
            echo '      <label for="TahunData"><dt>Pilih Tahun</dt></label>';
            echo '      <select class="form-control" id="TahunData" name="TahunData">';
            for ( $i=2010; $i<=date('Y'); $i++ ){
                if(empty($_POST['GetTahunForm'])){
                    if($i==date('Y')){
                        echo '<option selected value="'.$i.'">'.$i.'</option>';
                    }else{
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }else{
                    if($i==$GetTahunForm){
                        echo '<option selected value="'.$i.'">'.$i.'</option>';
                    }else{
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
            }
            echo '      </select>';
            echo '  </div>';
        }else{
            if($PeriodeDataExport=="Bulanan"){
                echo '  <div class="col-md-6">';
                echo '      <label for="BulanData"><dt>Pilih Bulan</dt></label>';
                echo '      <select class="form-control" id="BulanData" name="BulanData">';
                for ( $i=1; $i<=12; $i++ ){
                    //Zero Padding
                    if($i==1){
                        $NamaBulan="Januari";
                    }else{
                        if($i==2){
                            $NamaBulan="Februari";
                        }else{
                            if($i==3){
                                $NamaBulan="Maret";
                            }else{
                                if($i==4){
                                    $NamaBulan="April";
                                }else{
                                    if($i==5){
                                        $NamaBulan="Mei";
                                    }else{
                                        if($i==6){
                                            $NamaBulan="Juni";
                                        }else{
                                            if($i==7){
                                                $NamaBulan="Juli";
                                            }else{
                                                if($i==8){
                                                    $NamaBulan="Agustus";
                                                }else{
                                                    if($i==9){
                                                        $NamaBulan="September";
                                                    }else{
                                                        if($i==10){
                                                            $NamaBulan="Oktober";
                                                        }else{
                                                            if($i==11){
                                                                $NamaBulan="November";
                                                            }else{
                                                                if($i==12){
                                                                    $NamaBulan="Desember";
                                                                }else{
                                                                    $NamaBulan="$i";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $i== sprintf("%02d", $i);
                    if($i==$GetBulanForm){
                        echo '<option selected value="'.$i.'">'.$NamaBulan.'</option>';
                    }else{
                        echo '<option value="'.$i.'">'.$NamaBulan.'</option>';
                    }
                }
                echo '      </select>';
                echo '  </div>';
                echo '  <div class="col-md-6">';
                echo '      <label for="TahunData"><dt>Pilih Tahun</dt></label>';
                echo '      <select class="form-control" id="TahunData" name="TahunData">';
                if(empty($_POST['GetTahunForm'])){
                    for ( $i=2010; $i<=date('Y'); $i++ ){
                        if($i==date('Y')){
                            echo '<option selected value="'.$i.'">'.$i.'</option>';
                        }else{
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                }else{
                    for ( $i=2010; $i<=date('Y'); $i++ ){
                        if($i==$GetTahunForm){
                            echo '<option selected value="'.$i.'">'.$i.'</option>';
                        }else{
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                }
                echo '      </select>';
                echo '  </div>';
            }else{
                echo '  <div class="col-md-12">';
                echo '      <label for="KeywordWaktu"><dt>Isi Tanggal</dt></label>';
                echo '      <input type="date" class="form-control" id="KeywordWaktu" name="KeywordWaktu" value="'.$GetWaktu.'">';
                echo '  </div>';
            }
        }
    }
?>