<div class="row">
    <div class="col-6 mb-3">
        <label for="tahun"><dt>Tahun</dt></label>
    </div>
    <div class="col-6 mb-3">
        <select name="tahun" id="tahun" class="form-control">
            <?php
                for ($tahun_list = 2010; $tahun_list <= date('Y'); $tahun_list++) {
                    if($tahun_list==date('Y')){
                        echo '<option selected value="'.$tahun_list.'">'.$tahun_list.'</option>';
                    }else{
                        echo '<option selected value="'.$tahun_list.'">'.$tahun_list.'</option>';
                    }
                }
            ?>
        </select>
    </div>
</div>