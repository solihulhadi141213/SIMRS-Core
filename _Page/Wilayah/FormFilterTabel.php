<?php
    include "../../_Config/Connection.php";
    //menangkap ColomName
    if(empty($_POST['ColomName'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          Nama Kolom tidak bisa ditangkap';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-primary">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          <button type="reset" class="btn btn-md btn-light ml-2" data-dismiss="modal" aria-label="Close">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $ColomName=$_POST['ColomName'];
        //Menampilkan form search
        echo '<form action="javascript:void(0);" id="ProsesFilterTabel" autocomplete="off">';
        echo '  <input type="hidden" readonly class="form-control" name="keyword_by" id="keyword_by" value="'.$ColomName.'" required>';
        echo '  <div class="modal-body">';
        echo '      <div class="row">';
        echo '          <div class="col-md-12 mt-2 mb-2">';
        echo '              <label>Keyword</label>';
        echo '              <input type="text" class="form-control" name="keyword_short" id="keyword_short" autofocus list="DatalistKeyword" required>';
        echo '              <datalist id="DatalistKeyword">';
                                //membuat array
                                $Qry = mysqli_query($Conn, "SELECT DISTINCT $ColomName FROM wilayah ORDER BY $ColomName ASC");
                                while ($Data = mysqli_fetch_array($Qry)) {
                                    $DataOption= $Data[$ColomName];
                                    echo '<option value="'.$DataOption.'">';
                                }
        echo '              </datalist>';
        echo '          </div>';
        echo '      </div>';
        echo '      <div class="row">';
        echo '          <div class="col-md-12 mt-2 mb-2">';
        echo '              <label>Mode Shorting</label>';
        echo '              <select name="ShortBy" id="ShortBy" class="form-control">';
        echo '                  <option value="ASC">A to Z</option>';
        echo '                  <option value="DESC">Z to A</option>';
        echo '              </select>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '  <div class="modal-footer">';
        echo '      <div class="row">';
        echo '          <div class="col-md-12 text-danger text-center">';
        echo '              <button type="submit" class="btn btn-md btn-inverse ml-2 mt-2">';
        echo '                  <i class="ti-search"></i> Cari';
        echo '              </button>';
        echo '              <button type="reset" class="btn btn-md btn-info ml-2 mt-2" data-dismiss="modal" aria-label="Close">';
        echo '                  <i class="ti-close"></i> Tutup';
        echo '              </button>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</form>';
    }

?>