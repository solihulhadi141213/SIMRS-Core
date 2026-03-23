<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat'])){
        echo '<div class="row">';
        echo '  <div class="col col-md-12 text-center text-danger">';
        echo '      ID Obat Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        $id_obat=getDataDetail($Conn,'obat','id_obat',$id_obat,'id_obat');
        //Buka data obat
        if(empty($id_obat)){
            echo '<div class="row">';
            echo '  <div class="col col-md-12 text-center text-danger">';
            echo '      ID Obat Yang Anda Pilih Tidak Valid!';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
            $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
            $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
            $kelompok=getDataDetail($Conn,'obat','id_obat',$id_obat,'kelompok');
            $kategori=getDataDetail($Conn,'obat','id_obat',$id_obat,'kategori');
            $satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
            $isi=getDataDetail($Conn,'obat','id_obat',$id_obat,'isi');
            $stok=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
            $harga=getDataDetail($Conn,'obat','id_obat',$id_obat,'harga');
            $stok_min=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok_min');
            $keterangan=getDataDetail($Conn,'obat','id_obat',$id_obat,'keterangan');
            $tanggal=getDataDetail($Conn,'obat','id_obat',$id_obat,'tanggal');
            $updatetime=getDataDetail($Conn,'obat','id_obat',$id_obat,'updatetime');
            //Format Harga Beli
            $harga=number_format($harga,0,',','.');
            //Format Tanggal
            $strtotime1=strtotime($tanggal);
            $strtotime2=strtotime($updatetime);
            $TanggalInput=date('d/m/Y H:i',$strtotime1);
            $UpdateTime=date('d/m/Y H:i',$strtotime2);
        }
    }
?>