<?php
    include "_Config/SettingCetakKartuPasien.php";
    include "_Config/SettingCetakLabel.php";
?>
<div class="col-md-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <dt><i class="fa fa-id-card"></i> Kartu Pasien</dt>
        </div>
        <div class="card-body text-center">
            <?php
                if(empty($IdSettingKartuPasien)){
                    echo '<span class="text-danger"><i class="icofont-ui-v-card icofont-5x"></i></span><br>';
                    echo '<span class="text-danger">Belum ada pengaturan</span>';
                }else{
                    echo '<span class="text-primary"><i class="icofont-ui-v-card icofont-5x"></i></span><br>';
                    echo 'Pengaturan : '.$TanggalSettingKartuPasien.'';
                }
            ?>
        </div>
        <div class="card-footer bg-primary text-center">
            <a href="index.php?Page=SettingPercetakan&Subpage=KartuPasien" class="btn btn-secondary">
                <i class="fa fa-cog"></i> Setting
            </a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <dt><i class="fa fa-sticky-note"></i> Lembar Antrian</dt>
        </div>
        <div class="card-body text-center">
            <?php
                if(empty($IdSettingKartuPasien)){
                    echo '<span class="text-danger"><i class="icofont-ui-v-card icofont-5x"></i></span><br>';
                    echo '<span class="text-danger">Belum ada pengaturan</span>';
                }else{
                    echo '<span class="text-primary"><i class="icofont-ui-v-card icofont-5x"></i></span><br>';
                    echo 'Pengaturan : '.$TanggalSettingKartuPasien.'';
                }
            ?>
        </div>
        <div class="card-footer bg-primary text-center">
            <a href="" class="btn btn-secondary">
                <i class="fa fa-cog"></i> Setting
            </a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <dt><i class="ti ti-notepad"></i> Nota Transaksi</dt>
        </div>
        <div class="card-body text-center">
            <?php
                if(empty($IdSettingKartuPasien)){
                    echo '<span class="text-danger"><i class="icofont-ui-v-card icofont-5x"></i></span><br>';
                    echo '<span class="text-danger">Belum ada pengaturan</span>';
                }else{
                    echo '<span class="text-primary"><i class="icofont-ui-v-card icofont-5x"></i></span><br>';
                    echo 'Pengaturan : '.$TanggalSettingKartuPasien.'';
                }
            ?>
        </div>
        <div class="card-footer bg-primary text-center">
            <a href="" class="btn btn-secondary">
                <i class="fa fa-cog"></i> Setting
            </a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <dt><i class="icofont-label"></i> Label Obat</dt>
        </div>
        <div class="card-body text-center">
            <?php
                if(empty($IdSettingCetakLabel)){
                    echo '<span class="text-danger"><i class="icofont-label icofont-5x"></i></span><br>';
                    echo '<span class="text-danger">Belum ada pengaturan</span>';
                }else{
                    echo '<span class="text-primary"><i class="icofont-label icofont-5x"></i></span><br>';
                    echo 'Pengaturan : '.$TanggalSettingLabel.'';
                }
            ?>
        </div>
        <div class="card-footer bg-primary text-center">
            <a href="index.php?Page=SettingPercetakan&Subpage=LabelObat" class="btn btn-secondary">
                <i class="fa fa-cog"></i> Setting
            </a>
        </div>
    </div>
</div>