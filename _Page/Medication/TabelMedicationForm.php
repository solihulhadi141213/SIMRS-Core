<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Url File referensi medication form
    $file_json="../../assets/referensi_json/MedicalForm.json";
    if(!file_exists($file_json)){
        echo '<div class="row">';
        echo '  <div class="col col-md-12 text-center text-danger">';
        echo '      File Referensi Tidak Ditemukan di Directory '.$file_json.'';
        echo '  </div>';
        echo '</div>';
    }else{
        $data = file_get_contents($file_json);
        $raw_data = json_decode($data, true);
        $raw_data = $raw_data['list'];
        $total_items = count($raw_data);
        if(empty($total_items)){
            echo '<div class="row">';
            echo '  <div class="col col-md-12 text-center text-danger">';
            echo '      Tidak ada data yang ditemukan';
            echo '  </div>';
            echo '</div>';
        }else{
            $limit = 25;
            if(empty($_POST['page'])){
                $page=1;
                $posisi = 0;
            }else{
                $page=$_POST['page'];
                $posisi = ( $page - 1 ) * $limit;
            }
            $offset = ($page - 1) * $limit;
            $total_pages = ceil($total_items / $limit);
            $final = array_splice($raw_data, $offset, $limit); // splice them according to offset and limit
?>
        <div class="row mb-3 sub-title">
            <div class="col-md-12 text-center">
                <div class="btn btn-group">
                    <?php
                        for($x = 1; $x <= $total_pages; $x++){
                            if($page==$x){
                                echo '<button type="button" class="btn btn-sm btn-secondary ClickPage" value="'.$x.'">';
                                echo '  '.$x.'';
                                echo '</button>';
                            }else{
                                echo '<button type="button" class="btn btn-sm btn-outline-secondary ClickPage" value="'.$x.'">';
                                echo '  '.$x.'';
                                echo '</button>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php 
            $no=1+$posisi;
            foreach($final as $list){
                $code=$list['code'];
                $display=$list['display'];
                $system=$list['system'];
                echo '<div class="row mb-3 sub-title">';
                echo '  <div class="col col-md-12">';
                echo '      <a href="javascript:void(0);" class="text-primary PilihMedicationForm" value="'.$code.'">'.$no.'. '.$display.'</a>';
                echo '      <ul class="ml-3">';
                echo '          <li>Display : <code class="text-secondary" id="GetMedicationFormDisplay'.$code.'">'.$display.'</code></li>';
                echo '          <li>Code : <code class="text-secondary" id="GetMedicationFormCode'.$code.'">'.$code.'</code></li>';
                echo '      </ul>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        ?>
        <script>
            $(".ClickPage").click(function() {
                var page = $(this).attr('value');
                $('#HasilPencarianMedicationForm').html('<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Medication/TabelMedicationForm.php',
                    data 	    :  {page: page},
                    success     : function(data){
                        $('#HasilPencarianMedicationForm').html(data);
                    }
                });
            });
            $(".PilihMedicationForm").click(function() {
                var code = $(this).attr('value');
                var GetMedicationFormDisplay =$('#GetMedicationFormDisplay'+code+'').html();
                var GetMedicationFormCode =$('#GetMedicationFormCode'+code+'').html();
                //Put Data
                $('#form_coding_code').val(GetMedicationFormCode);
                $('#form_coding_display').val(GetMedicationFormDisplay);
                //Tutup Modal
                $('#ModalCariMedicationForm').modal('hide');
            });
        </script>
<?php
        } 
    }
?>