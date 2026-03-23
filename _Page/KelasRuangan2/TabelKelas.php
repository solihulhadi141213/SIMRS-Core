<?php
    //koneksi
    include "../../_Config/Connection.php";
    
    //Inisiasliisasi Variabel
    $JmlHalaman=0;
    $page=0;
    
    //kategori
    if(!empty($_POST['kategori'])){
        $kategori=$_POST['kategori'];
    }else{
        $kategori="kelas";
    }
    //Keyword_by
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
    }else{
        $keyword_by="";
    }
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="DESC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_ruang_rawat";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword_by)){
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='$kategori'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE (kategori='$kategori') AND (kodekelas like '%$keyword%' OR kelas like '%$keyword%' OR ruangan like '%$keyword%' OR bed like '%$keyword%' OR status like '%$keyword%')"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='$kategori'"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE (kategori='$kategori') AND ($keyword_by like '%$keyword%')"));
        }
    }
    //Mengatur Halaman
    $JmlHalaman = ceil($jml_data/$batas); 
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="12" class="text-center">
                    <small class="text-danger">Tidak Ada Data Yang Ditampilkan!</small>
                </td>
            </tr>
        ';
    }else{
        $no = 1+$posisi;
        //KONDISI PENGATURAN MASING FILTER
        if(empty($keyword_by)){
            if(empty($keyword)){
                $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='$kategori' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }else{
                $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE (kategori='$kategori') AND (kodekelas like '%$keyword%' OR kelas like '%$keyword%' OR ruangan like '%$keyword%' OR bed like '%$keyword%' OR status like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }
        }else{
            if(empty($keyword)){
                $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='$kategori' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }else{
                $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE (kategori='$kategori') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }
        }
        while ($data = mysqli_fetch_array($query)) {
            $id_ruang_rawat     = $data['id_ruang_rawat'];
            $kategori           = $data['kategori'];
            $kodekelas          = $data['kodekelas'];
            $kelas              = $data['kelas'];
            $ruangan            = $data['ruangan'];
            $bed                = $data['bed'];
            $pria               = $data['pria'];
            $wanita             = $data['wanita'];
            $bebas              = $data['bebas'];
            $status             = $data['status'];
            $updatetime         = $data['updatetime'];

            if(empty($data['tarif'])){
                $tarif          = 0;
            }else{
                $tarif          = $data['tarif'];
            }

            //Routing Kategori
            if($kategori=="kelas"){
                $label_kategori = '<span class="badge badge-primary">Kelas</span>';
            }else{
                if($kategori=="ruangan"){
                    $label_kategori = '<span class="badge badge-warning">Ruangan</span>';
                }else{
                    if($kategori=="bed"){
                        $label_kategori = '<span class="badge badge-dark">Ded</span>';
                    }else{
                        $label_kategori = '<span class="badge badge-danger">None</span>';
                    }
                }
            }

            //Routing Status
            if($status=="Aktif"){
                $label_status = '<span class="text-success">Aktif</span>';
            }else{
               $label_status = '<span class="text-danger">'.$status.'</span>';
            }

            //Routing Label ruangan
            if($kategori=="kelas"){

                //hitung jumlah ruangan
                $jumlah_ruangan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas'"));
                $label_ruangan = $jumlah_ruangan;
            }else{
                if($kategori=="ruangan"){
                    $label_ruangan = $ruangan;
                }else{
                    if($kategori=="bed"){
                        $label_ruangan = $ruangan;
                    }else{
                        $label_ruangan = '<span class="badge badge-danger">None</span>';
                    }
                }
            }

            //Routing Label bed
            if($kategori=="kelas"){

                //hitung jumlah bed pada kelas
                $bed = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND kelas='$kelas'"));
            }else{
                if($kategori=="ruangan"){

                    //hitung jumlah bed pada ruangan
                    $bed = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND ruangan='$ruangan'"));
                }else{
                    if($kategori=="bed"){
                        $bed = $bed;
                    }else{
                        $bed = '<span class="badge badge-danger">None</span>';
                    }
                }
            }

            //routing label L, P, L & P
            if($kategori=="kelas"){

                //Hitung Jumlah Bed L, P, L&P
                $pria   = 0;
                $wanita = 0;
                $bebas  = 0;
                $query_bed = mysqli_query($Conn, "SELECT pria, wanita, bebas FROM ruang_rawat WHERE kelas='$kelas'");
                while ($data_deb = mysqli_fetch_array($query_bed)) {
                    if(empty($data_deb['pria'])){
                        $pria_list      = 0;
                    }else{
                        $pria_list      = $data_deb['pria'];
                    }
                    if(empty($data_deb['wanita'])){
                        $wanita_list    = 0;
                    }else{
                        $wanita_list    = $data_deb['wanita'];
                    }
                    if(empty($data_deb['bebas'])){
                        $bebas_list    = 0;
                    }else{
                        $bebas_list    = $data_deb['bebas'];
                    }

                    //Akumulasi
                    $pria   = $pria + $pria_list;
                    $wanita = $wanita + $wanita_list;
                    $bebas  = $bebas + $bebas_list;
                }
                
            }else{
                if($kategori=="ruangan"){

                    //Hitung Jumlah Bed L, P, L&P
                    $pria   = 0;
                    $wanita = 0;
                    $bebas  = 0;
                    $query_bed = mysqli_query($Conn, "SELECT pria, wanita, bebas FROM ruang_rawat WHERE ruangan='$ruangan'");
                    while ($data_deb = mysqli_fetch_array($query_bed)) {
                        if(empty($data_deb['pria'])){
                            $pria_list      = 0;
                        }else{
                            $pria_list      = $data_deb['pria'];
                        }
                        if(empty($data_deb['wanita'])){
                            $wanita_list    = 0;
                        }else{
                            $wanita_list    = $data_deb['wanita'];
                        }
                        if(empty($data_deb['bebas'])){
                            $bebas_list    = 0;
                        }else{
                            $bebas_list    = $data_deb['bebas'];
                        }

                        //Akumulasi
                        $pria   = $pria + $pria_list;
                        $wanita = $wanita + $wanita_list;
                        $bebas  = $bebas + $bebas_list;
                    }
                }else{
                    if($kategori=="bed"){
                        $bed = $bed;
                    }else{
                        $bed = '<span class="badge badge-danger">None</span>';
                    }
                }
            }

            $tarif_format = "Rp " . number_format($tarif, 0, ',', '.');

            //Cek Status Terisi
            if($kategori=="kelas"){
                $jumlah_pasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE kelas='$kelas' AND status='Terdaftar'"));
                if(!empty($jumlah_pasien)){
                    $status_terisi  = '<span class="badge badge-warning">'.$jumlah_pasien.'/'.$bed.'</span>';
                }else{
                    $status_terisi  = '<span class="badge badge-success">'.$jumlah_pasien.'/'.$bed.'</span>';
                }
            }else{
                if($kategori=="ruangan"){
                    $jumlah_pasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE ruangan='$ruangan' AND status='Terdaftar'"));
                    if(!empty($jumlah_pasien)){
                        $status_terisi  = '<span class="badge badge-warning">'.$jumlah_pasien.'/'.$bed.'</span>';
                    }else{
                        $status_terisi  = '<span class="badge badge-success">'.$jumlah_pasien.'/'.$bed.'</span>';
                    }
                }else{
                    if($kategori=="bed"){
                        $jumlah_pasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_kasur='$id_ruang_rawat' AND status='Terdaftar'"));
                        if(!empty($jumlah_pasien)){
                            $status_terisi  = '<span class="badge badge-warning">Terisi</span>';
                        }else{
                            $status_terisi  = '<span class="badge badge-success">Kosong</span>';
                        }
                    }else{
                        $jumlah_pasien = 0;
                        $status_terisi  = '<span class="badge badge-success">Kosong</span>';
                    }
                }
            }
            
            
            echo '
                <tr>
                    <td>'.$no.'</td>
                    <td>'.$label_kategori.'</td>
                    <td>'.$kodekelas.'</td>
                    <td>'.$kelas.'</td>
                    <td>'.$label_ruangan.'</td>
                    <td>'.$bed.'</td>
                    <td>'.$pria.'</td>
                    <td>'.$wanita.'</td>
                    <td>'.$bebas.'</td>
                    <td>'.$status_terisi.'</td>
                    <td>'.$label_status.'</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalEdit" data-id="'.$id_ruang_rawat.'">
                                <i class="ti-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalHapus" data-id="'.$id_ruang_rawat.'">
                                <i class="ti ti-close"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            ';
            $no++;
        }
    }
?>
<script>
    //Creat Javascript Variabel
    var kategori="<?php echo $kategori; ?>";
    var data_count=<?php echo $jml_data; ?>;
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#data_count').html('Count : '+data_count+'');
    $('#page_info').html(''+curent_page+' / '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button').prop('disabled', true);
    }else{
        $('#prev_button').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button').prop('disabled', true);
    }else{
        $('#next_button').prop('disabled', false);
    }

    if(kategori=="kelas"){
        // Hapus kelas aktif dari semua label
        $('.label_kategori')
            .removeClass('label-primary')
            .addClass('label-inverse-info');
        
        // Tambahkan kelas aktif ke label yang diklik
        $('#label_for_kelas')
            .removeClass('label-inverse-info')
            .addClass('label-primary');
    }
    if(kategori=="ruangan"){
        // Hapus kelas aktif dari semua label
        $('.label_kategori')
            .removeClass('label-primary')
            .addClass('label-inverse-info');
        
        // Tambahkan kelas aktif ke label yang diklik
        $('#label_for_ruangan')
            .removeClass('label-inverse-info')
            .addClass('label-primary');
    }
    if(kategori=="bed"){
        // Hapus kelas aktif dari semua label
        $('.label_kategori')
            .removeClass('label-primary')
            .addClass('label-inverse-info');
        
        // Tambahkan kelas aktif ke label yang diklik
        $('#label_for_bed')
            .removeClass('label-inverse-info')
            .addClass('label-primary');
    }
    
</script>