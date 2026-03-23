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
        <table class="Kop" width="100%">
            <tr>
                <td align="center" colspan="11">
                    <h3><b><?php echo "$nama_faskes";?></b></h3>
                    <?php echo "$alamat";?><br>
                    <?php echo "No.Kontak : $kontak";?><br>
                    <?php echo "Email : $email";?><br>
                    <b><?php echo "DATA PASIEN";?></b>
                </td>
            </tr>
        </table>
        <br>
        <table class="data" width="100%" celspacing="0">
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>Tgl</b></td>
                <td align="center"><b>Nama</b></td>
                <td align="center"><b>No.RM</b></td>
                <td align="center"><b>NIK</b></td>
                <td align="center"><b>Bpjs</b></td>
                <td align="center"><b>Gender</b></td>
                <td align="center"><b>TTL</b></td>
                <td align="center"><b>Alamat</b></td>
                <td align="center"><b>Kontak</b></td>
                <td align="center"><b>Status</b></td>
            </tr>
            <?php
                $no=1;
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM pasien ORDER BY $Order $Short");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE $Order like '%$keyword%' ORDER BY $Order $Short");
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_pasien= $data['id_pasien'];
                    $noRm=sprintf("%07d", $id_pasien);
                    $tanggal_daftar= $data['tanggal_daftar'];
                    $nik= $data['nik'];
                    $no_bpjs= $data['no_bpjs'];
                    $nama= $data['nama'];
                    $gender= $data['gender'];
                    $tempat_lahir= $data['tempat_lahir'];
                    $tanggal_lahir= $data['tanggal_lahir'];
                    $propinsi= $data['propinsi'];
                    $kabupaten= $data['kabupaten'];
                    $kecamatan= $data['kecamatan'];
                    $desa= $data['desa'];
                    $alamat= $data['alamat'];
                    $status= $data['status'];
                    $gambar= $data['gambar'];
                    echo '  <tr>';
                    echo '      <td>'.$no.'</td>';
                    echo '      <td>'.$tanggal_daftar.'</td>';
                    echo '      <td>'.$nama.'</td>';
                    echo '      <td>'.$id_pasien.'</td>';
                    echo '      <td>'.$nik.'</td>';
                    echo '      <td>'.$no_bpjs.'</td>';
                    echo '      <td>'.$gender.'</td>';
                    echo '      <td>'.$tempat_lahir.', '.$tanggal_lahir.'</td>';
                    echo '      <td>'.$alamat.' '.$desa.' '.$kecamatan.' '.$kabupaten.' '.$propinsi.'</td>';
                    echo '      <td>'.$kontak.'</td>';
                    echo '      <td>'.$status.'</td>';
                    echo '  </tr>';
                    $no++;
                }
            ?>
        </table>
    </body>
</html>