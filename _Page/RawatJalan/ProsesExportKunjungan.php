<html>
    <head>
        <title>Data Pasien</title>
        <style type="text/css">
            @page {
                margin-top: 1cm;
                margin-bottom: 1cm;
                margin-left: 1cm;
                margin-right: 1cm;
            }
            body {
                background-color: #FFF;
                font-family: arial;
            }
            table{
                border-collapse: collapse;
                margin-top:10px;
            }
            table.data tr td {
                border: 0.5px solid #666;
                color:#333;
                border-spacing: 0px;
                padding: 10px;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <?php
            date_default_timezone_set('Asia/Jakarta');
            include "../../_Config/Connection.php";
            include "../../_Config/SimrsFunction.php";
            
            if(empty($_POST['tahun'])){
                echo "Periode Tahun tidak boleh kosong!";
            }else{
                if(empty($_POST['bulan'])){
                    echo "Periode Bulan tidak boleh kosong!";
                }else{
                    $tahun=$_POST['tahun'];
                    $bulan=$_POST['bulan'];
                    if(empty($_POST['tujuan'])){
                        $tujuan="";
                    }else{
                        $tujuan=$_POST['tujuan'];
                    }
                    //Bentuk Keyword
                    $keyword="$tahun-$bulan";

                    //Jumlah Data
                    if(empty($tujuan)){
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE tanggal like '%$keyword%'"));
                    }else{
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE tanggal like '%$keyword%' AND tujuan='$tujuan'"));
                    }
                    if(empty($jml_data)){
                        echo "Data Tidak Ditemukan!";
                    }else{
                        header("Content-type: application/vnd-ms-excel");
                        header("Content-Disposition: attachment; filename=kunjungan_pasien.xls");

                        echo '<table class="data" width="100%" celspacing="0">';
                        echo '   
                            <tr>
                                <td><b>No</b></td>
                                <td><b>ID.REG</b></td>
                                <td><b>No.RM</b></td>
                                <td><b>NIK</b></td>
                                <td><b>BPJS</b></td>
                                <td><b>SEP</b></td>
                                <td><b>Nama</b></td>
                                <td><b>Tanggal</b></td>
                                <td><b>Prov</b></td>
                                <td><b>Kab</b></td>
                                <td><b>Kec</b></td>
                                <td><b>Desa</b></td>
                                <td><b>Alamat</b></td>
                                <td><b>Gender</b></td>
                                <td><b>Keluhan</b></td>
                                <td><b>Tujuan</b></td>
                                <td><b>Dokter</b></td>
                                <td><b>Poli</b></td>
                                <td><b>Kelas</b></td>
                                <td><b>Ruangan</b></td>
                                <td><b>Diag.Awal</b></td>
                                <td><b>Pembayaran</b></td>
                                <td><b>Cara Keluar</b></td>
                                <td><b>Tgl Keluar</b></td>
                                <td><b>Status</b></td>
                                <td><b>Petugas</b></td>
                                <td><b>Update</b></td>
                                <td><b>Baru/Lama</b></td>
                            </tr>
                        ';
                        $no = 1;
                        if(empty($tujuan)){
                            $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE tanggal like '%$keyword%' ORDER BY id_kunjungan ASC");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE tanggal like '%$keyword%' AND tujuan='$tujuan' ORDER BY id_kunjungan ASC");
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_kunjungan= $data['id_kunjungan'];
                            $id_pasien= $data['id_pasien'];
                            // Added single apostrophe to NIK and BPJS to force text format in Excel
                            $nik = !empty($data['nik']) ? "'" . $data['nik'] : '-';
                            $no_bpjs = !empty($data['no_bpjs']) ? "'" . $data['no_bpjs'] : '-';
                            $sep = !empty($data['sep']) ? $data['sep'] : '-';
                            $nama = !empty($data['nama']) ? $data['nama'] : '-';
                            $tanggal = !empty($data['tanggal']) ? $data['tanggal'] : '-';
                            
                            $propinsi = !empty($data['propinsi']) ? $data['propinsi'] : '-';
                            $kabupaten = !empty($data['kabupaten']) ? $data['kabupaten'] : '-';
                            $kecamatan = !empty($data['kecamatan']) ? $data['kecamatan'] : '-';
                            $desa = !empty($data['desa']) ? $data['desa'] : '-';
                            $alamat = !empty($data['alamat']) ? $data['alamat'] : '-';
                            $keluhan = !empty($data['keluhan']) ? $data['keluhan'] : '-';
                            $tujuan = !empty($data['tujuan']) ? $data['tujuan'] : '-';
                            $dokter = !empty($data['dokter']) ? $data['dokter'] : '-';
                            $poliklinik = !empty($data['poliklinik']) ? $data['poliklinik'] : '-';
                            $kelas = !empty($data['kelas']) ? $data['kelas'] : '-';
                            $ruangan = !empty($data['ruangan']) ? $data['ruangan'] : '-';
                            $DiagAwal = !empty($data['DiagAwal']) ? $data['DiagAwal'] : '-';
                            $pembayaran = !empty($data['pembayaran']) ? $data['pembayaran'] : '-';
                            $cara_keluar = !empty($data['cara_keluar']) ? $data['cara_keluar'] : '-';
                            $tanggal_keluar = !empty($data['tanggal_keluar']) ? $data['tanggal_keluar'] : '-';
                            $status = !empty($data['status']) ? $data['status'] : '-';
                            $updatetime = !empty($data['updatetime']) ? $data['updatetime'] : '-';

                            $nama_petugas = !empty($data['nama_petugas']) ? $data['nama_petugas'] : '-';
                            //Buka data pasien
                            $tanggal_daftar=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_daftar');
                            //ubah ke milisecon
                            $tanggal_kunjungan_ms=date('Y-m-d',strtotime($tanggal));
                            $tanggal_daftar_ms=date('Y-m-d',strtotime($tanggal_daftar));
                            if ($tanggal_kunjungan_ms <= $tanggal_daftar_ms) {
                                $baru_lama = "Baru";
                            } else {
                                $baru_lama = "Lama"; // Misal, jika tanggal_kunjungan lebih besar dari tanggal_daftar
                            }

                            //gENDER
                            $gender=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gender');
                            echo '
                                <tr>
                                    <td>'.$no.'</td>
                                    <td>'.$id_kunjungan.'</td>
                                    <td>'.$id_pasien.'</td>
                                    <td>'.$nik.'</td>
                                    <td>'.$no_bpjs.'</td>
                                    <td>'.$sep.'</td>
                                    <td>'.$nama.'</td>
                                    <td>'.$tanggal.'</td>
                                    <td>'.$propinsi.'</td>
                                    <td>'.$kabupaten.'</td>
                                    <td>'.$kecamatan.'</td>
                                    <td>'.$desa.'</td>
                                    <td>'.$alamat.'</td>
                                    <td>'.$gender.'</td>
                                    <td>'.$keluhan.'</td>
                                    <td>'.$tujuan.'</td>
                                    <td>'.$dokter.'</td>
                                    <td>'.$poliklinik.'</td>
                                    <td>'.$kelas.'</td>
                                    <td>'.$ruangan.'</td>
                                    <td>'.$DiagAwal.'</td>
                                    <td>'.$pembayaran.'</td>
                                    <td>'.$cara_keluar.'</td>
                                    <td>'.$tanggal_keluar.'</td>
                                    <td>'.$status.'</td>
                                    <td>'.$nama_petugas.'</td>
                                    <td>'.$updatetime.'</td>
                                    <td>'.$baru_lama.'</td>
                                </tr>
                            ';
                            $no++;
                        }
                        echo '</table>';
                    }
                }
            }
        ?>
    </body>
</html>