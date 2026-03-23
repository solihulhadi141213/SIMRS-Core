<html>
    <head>
        <title>Data Log</title>
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
            table.kostum tr td {
                border:none;
                color:#333;
                border-spacing: 0px;
                padding: 2px;
                border-collapse: collapse;
                font-size:12px;
            }
            table.data tr td {
                border: 1px solid #666;
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
                <td align="center" colspan="3">
                    <h3><b><?php echo "$NamaFaskes";?></b></h3>
                    <?php echo "$AlamatFaskes";?><br>
                    <?php echo "No.Kontak : $KontakFaskes";?><br>
                    <?php echo "Email : $EmailFaskes";?><br>
                    <b><?php echo "DATA LOG AKTIVITAS USER PERIODE $periode1 s/d $periode2";?></b>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table class="data" width="100%">
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>Nama User</b></td>
                <td align="center"><b>Waktu</b></td>
                <td align="center"><b>Kategori</b></td>
                <td align="center"><b>Nama Log</b></td>
            </tr>
            <?php
                $no = 1;
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE waktu>='$periode1' AND waktu<='$periode2'"));
                if(empty($jml_data)){
                    echo '<tr tabindex="0" class="table-light">';
                    echo '  <td class="text-center" colspan="12">Belum Ada Data Untuk Periode Ini</td>';
                    echo '</tr>';
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM log WHERE waktu>='$periode1' AND waktu<='$periode2' ORDER BY id_log ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_log= $data['id_log'];
                        $waktu= $data['waktu'];
                        $nama_log= $data['nama_log'];
                        $kategori= $data['kategori'];
                        $id_akses= $data['id_akses'];
                        //Buka data user
                        $Qry= mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
                        $Data= mysqli_fetch_array($Qry);
                        $id_akses = $Data['id_akses'];
                        $NamaUser = $Data['nama'];
                ?>
                    <tr>
                        <td align="center"><?php echo "$no";?></td>
                        <td align="left"><?php echo "$NamaUser";?></td>
                        <td align="left"><?php echo "$waktu";?></td>
                        <td align="left"><?php echo "$kategori";?></td>
                        <td align="left"><?php echo "$nama_log";?></td>
                    </tr>
            <?php $no++; }} ?>
        </table>
        <br><br>
        Mengetahui,<br>
        Petugas/Pejabat Yang Melakukan Cetak Data<br>
        <br><br>
        <?php echo "$SessionNama";?>
    </body>
</html>