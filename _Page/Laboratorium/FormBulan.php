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
<div class="row">
    <div class="col-6 mb-3">
        <label for="bulan"><dt>Bulan</dt></label>
    </div>
    <div class="col-6 mb-3">
        <select name="bulan" id="bulan" class="form-control">
            <?php
                $bulan = array(
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                );
                
                foreach ($bulan as $index => $nama_bulan) {
                    $nomor_bulan = str_pad($index + 1, 2, "0", STR_PAD_LEFT);
                    if($nomor_bulan==date('m')){
                        echo '<option selected value="'.$nomor_bulan.'">'.$nama_bulan.'</option>';
                    }else{
                        echo '<option value="'.$nomor_bulan.'">'.$nama_bulan.'</option>';
                    }
                }
            ?>
        </select>
    </div>
</div>