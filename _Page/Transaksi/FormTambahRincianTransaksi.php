<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['IdData'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Tidak Ada Data Yang Dipilih';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['ObatAtauTindakan'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak Ada Kategori Data Yang Dipilih';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_POST['KodeTransaksi'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Pilih Transaksi Terlebih Dulu';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($_POST['transaksi'])){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      Jenis Transaksi Tidak Boleh Kosong!';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($_POST['id_kunjungan'])){
                        $id_kunjungan="";
                        $Klaim="";
                    }else{
                        $id_kunjungan=$_POST['id_kunjungan'];
                        $Klaim=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'pembayaran');
                    }
                    $transaksi=$_POST['transaksi'];
                    $IdData=$_POST['IdData'];
                    $ObatAtauTindakan=$_POST['ObatAtauTindakan'];
                    $KodeTransaksi=$_POST['KodeTransaksi'];
                    //Buka Nama Rincian
                    if($ObatAtauTindakan=="Obat"){
                        $NamaRincian=getDataDetail($Conn,'obat','id_obat',$IdData,'nama');
                        $HargaTarif=getDataDetail($Conn,'obat','id_obat',$IdData,'harga');
                        $SatuanRincian=getDataDetail($Conn,'obat','id_obat',$IdData,'satuan');
                    }else{
                        $NamaRincian=getDataDetail($Conn,'tarif','id_tarif',$IdData,'nama');
                        $HargaTarif=getDataDetail($Conn,'tarif','id_tarif',$IdData,'tarif');
                        $SatuanRincian="";
                    }
?>
                <script>
                    $( '#QtyRincian' ).mask('000.000.000.000.000', {reverse: true});
                    $( '#HargaRincian' ).mask('000.000.000.000.000', {reverse: true});
                    $( '#PpnRincian' ).mask('000.000.000.000.000', {reverse: true});
                    $( '#DiskonRincian' ).mask('000.000.000.000.000', {reverse: true});
                    $( '#JumlahRincian' ).mask('000.000.000.000.000', {reverse: true});
                    //Ketika Muti Satuan Diubah
                    $('#MultiSatuanRincian').change(function(){
                        var MultiSatuanRincian =$('#MultiSatuanRincian').val();
                        var GetIdData =$('#GetIdData').val();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Transaksi/MultiSatuanRincian.php',
                            data 	    :  {MultiSatuanRincian: MultiSatuanRincian, GetIdData: GetIdData},
                            success     : function(data){
                                var SatuanRincian = data.replace(/\s/g, '');
                                $('#SatuanRincian').val(SatuanRincian);
                            }
                        });
                    });
                    //ketika Muti Harga Diubah
                    $('#MultiHargaRincian').change(function(){
                        var MultiHargaRincian =$('#MultiHargaRincian').val();
                        var GetIdData =$('#GetIdData').val();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Transaksi/MultiHargaRincian.php',
                            data 	    :  {MultiHargaRincian: MultiHargaRincian, GetIdData: GetIdData},
                            success     : function(data){
                                var HargaRincian = data.replace(/\s/g, '');
                                $('#HargaRincian').val(HargaRincian);
                                $('#JumlahRincian').val(HargaRincian);
                                $('#QtyRincian').val("1");
                            }
                        });
                    });
                    //Ketika Harga Tarif Diubah
                    $('#HargaRincian').keyup(function(){
                        var ProsesTambahRincianTransaksi =$('#ProsesTambahRincianTransaksi').serialize();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Transaksi/HitungJumlah.php',
                            data 	    :  ProsesTambahRincianTransaksi,
                            success     : function(data){
                                $('#JumlahRincian').val(data);
                            }
                        });
                    });
                    //Ketika QTY Diubah
                    $('#QtyRincian').keyup(function(){
                        var ProsesTambahRincianTransaksi =$('#ProsesTambahRincianTransaksi').serialize();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Transaksi/HitungJumlah.php',
                            data 	    :  ProsesTambahRincianTransaksi,
                            success     : function(data){
                                $('#JumlahRincian').val(data);
                            }
                        });
                    });
                    //Ketika PpnRincian Diubah
                    $('#PpnRincian').keyup(function(){
                        var ProsesTambahRincianTransaksi =$('#ProsesTambahRincianTransaksi').serialize();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Transaksi/HitungJumlah.php',
                            data 	    :  ProsesTambahRincianTransaksi,
                            success     : function(data){
                                $('#JumlahRincian').val(data);
                            }
                        });
                    });
                    //Ketika PpnRincian Persen Diubah
                    $('#PpnRincianPersen').keyup(function(){
                        //Tangkap Harga Dan QTY
                        var PpnRincianPersen =$('#PpnRincianPersen').val();
                        var HargaRincian =$('#HargaRincian').val();
                        var QtyRincian =$('#QtyRincian').val();
                        //Menampilkan rupiah PPN
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Transaksi/HitungPpnRupiah.php',
                            data 	    :  {PpnPersen: PpnRincianPersen, Harga: HargaRincian, Qty: QtyRincian},
                            success     : function(data){
                                $('#PpnRincian').val(data);
                                //Hitung Jumlah Rincian
                                var ProsesTambahRincianTransaksi =$('#ProsesTambahRincianTransaksi').serialize();
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/Transaksi/HitungJumlah.php',
                                    data 	    :  ProsesTambahRincianTransaksi,
                                    success     : function(data){
                                        $('#JumlahRincian').val(data);
                                    }
                                });
                            }
                        });
                    });
                    //Ketika DiskonRincian Diubah
                    $('#DiskonRincian').keyup(function(){
                        var ProsesTambahRincianTransaksi =$('#ProsesTambahRincianTransaksi').serialize();
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Transaksi/HitungJumlah.php',
                            data 	    :  ProsesTambahRincianTransaksi,
                            success     : function(data){
                                $('#JumlahRincian').val(data);
                            }
                        });
                    });
                    //Ketika DiskonRincian Persen Diubah
                    $('#DiskonRincianPersen').keyup(function(){
                        //Tangkap Harga Dan QTY
                        var DiskonRincianPersen =$('#DiskonRincianPersen').val();
                        var HargaRincian =$('#HargaRincian').val();
                        var QtyRincian =$('#QtyRincian').val();
                        //Menampilkan rupiah Diskon
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/Transaksi/HitungDiskonRupiah.php',
                            data 	    :  {DiskonPersen: DiskonRincianPersen, Harga: HargaRincian, Qty: QtyRincian},
                            success     : function(data){
                                $('#DiskonRincian').val(data);
                                var ProsesTambahRincianTransaksi =$('#ProsesTambahRincianTransaksi').serialize();
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/Transaksi/HitungJumlah.php',
                                    data 	    :  ProsesTambahRincianTransaksi,
                                    success     : function(data){
                                        $('#JumlahRincian').val(data);
                                    }
                                });
                            }
                        });
                    });
                </script>
                <input type="hidden" name="transaksi" value="<?php echo "$transaksi"; ?>">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="IdData">Id Rincian</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" readonly name="IdData" id="GetIdData" value="<?php echo "$IdData"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="KategoriRincian">Kategori Rincian</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" readonly name="KategoriRincian" value="<?php echo "$ObatAtauTindakan"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="KodeTransaksi">Kode Transaksi</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" readonly name="KodeTransaksi" value="<?php echo "$KodeTransaksi"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="NamaRincian">Nama Rincian</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="NamaRincian" value="<?php echo "$NamaRincian"; ?>">
                    </div>
                </div>
                <?php if($ObatAtauTindakan=="Obat"){ ?>
                    <!-- Apabila Data yang terpilih adalah OBAT maka sistem akan menampilkan form tambahan ini -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="PenyimpananRincian">Penyimpanan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="PenyimpananRincian" id="PenyimpananRincian" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //Menampilkan tempat penyimpanan
                                    $QryTempatPenyimpanan = mysqli_query($Conn, "SELECT*FROM obat_storage ORDER BY nama_penyimpanan ASC");
                                    while ($DataTempatPenyimpanan = mysqli_fetch_array($QryTempatPenyimpanan)) {
                                        $id_obat_storage= $DataTempatPenyimpanan['id_obat_storage'];
                                        $nama_penyimpanan= $DataTempatPenyimpanan['nama_penyimpanan'];
                                        //Lihat Posisi
                                        $QryPosisi = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat='$IdData' AND id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
                                        $DataPosisi = mysqli_fetch_array($QryPosisi);
                                        if(empty($DataPosisi['stok'])){
                                            $StokPosisi=0;
                                        }else{
                                            $StokPosisi=$DataPosisi['stok'];
                                        }
                                        echo '<option value="'.$id_obat_storage.'">'.$nama_penyimpanan.' ('.$StokPosisi.')</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="MultiSatuanRincian">Multi Satuan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="MultiSatuanRincian" id="MultiSatuanRincian" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $QrySatuan = mysqli_query($Conn, "SELECT*FROM obat_satuan WHERE id_obat='$IdData' ORDER BY id_obat_multi ASC");
                                    while ($DataSatuan = mysqli_fetch_array($QrySatuan)) {
                                        $id_obat_multi= $DataSatuan['id_obat_multi'];
                                        $SatuanMulti= $DataSatuan['satuan'];
                                        echo '<option value="'.$id_obat_multi.'">'.$SatuanMulti.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="MultiHargaRincian">Multi Harga</label>
                        </div>
                        <div class="col-md-8">
                            <select name="MultiHargaRincian" id="MultiHargaRincian" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $query = mysqli_query($Conn, "SELECT*FROM obat_kategori_harga ORDER BY kategori_harga ASC");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_kategori_harga= $data['id_kategori_harga'];
                                        $kategori_harga= $data['kategori_harga'];
                                        //Buka Harga Multi
                                        $QryView = mysqli_query($Conn,"SELECT * FROM obat_harga WHERE id_kategori_harga='$id_kategori_harga' AND id_obat='$IdData'")or die(mysqli_error($Conn));
                                        $DataView = mysqli_fetch_array($QryView);
                                        if(!empty($DataView['harga'])){
                                            $id_obat_harga = $DataView['id_obat_harga'];
                                            $harga_multi = $DataView['harga'];
                                            $harga_multi=number_format($harga_multi,0,',','.');
                                        }else{
                                            $id_obat_harga ="0";
                                            $harga_multi ="None";
                                        }
                                        echo '<option value="'.$id_obat_harga.'">'.$kategori_harga.' ('.$harga_multi.')</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="HargaRincian">Harga/Tarif</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="HargaRincian" id="HargaRincian" value="<?php echo "$HargaTarif"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="QtyRincian">QTY</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="QtyRincian" id="QtyRincian" value="1">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="SatuanRincian">Satuan</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="SatuanRincian" id="SatuanRincian" value="<?php echo "$SatuanRincian"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="PpnRincian">PPN</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="PpnRincianPersen" id="PpnRincianPersen" placeholder="%">
                            <input type="text" class="form-control" name="PpnRincian" id="PpnRincian"  placeholder="Rp">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="DiskonRincian">Diskon</label>
                    </div>
                    <div class="col-md-8">
                        
                        <div class="input-group">
                            <input type="text" class="form-control" name="DiskonRincianPersen" id="DiskonRincianPersen"  placeholder="%">
                            <input type="text" class="form-control" name="DiskonRincian" id="DiskonRincian" placeholder="Rp">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="JumlahRincian">Jumlah</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="JumlahRincian" id="JumlahRincian" value="<?php echo "$HargaTarif"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="KlaimRincian">Klaim</label>
                    </div>
                    <div class="col-md-8">
                        <select name="KlaimRincian" id="KlaimRincian" class="form-control">
                            <option <?php if($Klaim==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($Klaim!=="UMUM"){echo "selected";} ?> value="BPJS">BPJS</option>
                            <option <?php if($Klaim=="UMUM"){echo "selected";} ?> value="UMUM">UMUM</option>
                        </select>
                    </div>
                </div>
<?php
                }
            }
        }
    }
?>