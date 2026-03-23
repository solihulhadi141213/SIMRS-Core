<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_radiologi_file
    if(empty($_POST['id_laboratorium_parameter'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Parameter Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_laboratorium_parameter=$_POST['id_laboratorium_parameter'];
        $parameter=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'parameter');
        $kategori_parameter=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'kategori_parameter');
        $tipe_data=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'tipe_data');
        $alternatif=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'alternatif');
        $nilai_rujukan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'nilai_rujukan');
        $nilai_kritis=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'nilai_kritis');
        $satuan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'satuan');
        $keterangan=getDataDetail($Conn,'laboratorium_parameter','id_laboratorium_parameter',$id_laboratorium_parameter,'keterangan');
?>
    <div class="row">
        <div class="col-md-12 mb-4  table table-responsive">
            <table  class="table table-hover">
                <tbody>
                    <tr>
                        <td><dt>Parameter</dt></td>
                        <td><dt>:</dt></td>
                        <td><?php echo $parameter;?></td>
                    </tr>
                    <tr>
                        <td><dt>Kategori</dt></td>
                        <td><dt>:</dt></td>
                        <td><?php echo $kategori_parameter;?></td>
                    </tr>
                    <tr>
                        <td><dt>Tipe Data</dt></td>
                        <td><dt>:</dt></td>
                        <td><?php echo $tipe_data;?></td>
                    </tr>
                    <tr>
                        <td><dt>Nilai Rujukan</dt></td>
                        <td><dt>:</dt></td>
                        <td><?php echo $nilai_rujukan;?></td>
                    </tr>
                    <tr>
                        <td><dt>Nilai Kritis</dt></td>
                        <td><dt>:</dt></td>
                        <td><?php echo $nilai_kritis;?></td>
                    </tr>
                    <tr>
                        <td><dt>Satuan Ukur</dt></td>
                        <td><dt>:</dt></td>
                        <td><?php echo $satuan;?></td>
                    </tr>
                    <tr>
                        <td><dt>Keterangan</dt></td>
                        <td><dt>:</dt></td>
                        <td><?php echo $keterangan;?></td>
                    </tr>
                    <tr>
                        <td><dt>Alternatif</dt></td>
                        <td><dt>:</dt></td>
                        <td>
                            <?php 
                                if(!empty($alternatif)){
                                    $ambil_json =json_decode($alternatif, true);
                                    $string=count($ambil_json);
                                    $no=1;
                                    for($i=0; $i<$string; $i++){
                                        $ListAlternatif=$ambil_json[$i]['alternatif'];
                                        echo "$no. $ListAlternatif<br>";
                                        $no++;
                                    }
                                    
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>