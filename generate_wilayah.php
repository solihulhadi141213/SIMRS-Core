<?php
    //Ini adalah halaman untuk melakukan konfigurasi database
    $servername = "localhost";
    $username   = "root";
    $password   = "arunaparasilvanursari";
    $db         = "elsyifa";
    // Create connection
    $Conn = new mysqli($servername, $username, $password, $db);
    // Check connection
    if ($Conn->connect_error) {
        die("Connection failed: " . $Conn->connect_error);
    }

    // Loop Kategori
    $query_kategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM wilayah_mendagri");
    while ($data_kategori = mysqli_fetch_array($query_kategori)) {
        $kategori = $data_kategori['kategori'];

        echo "$kategori <br>";
    }

    // Tangkap Kategori
    if(empty($_GET['kategori_data'])){
        
        // Menampilkan Provinsi
        echo '<table border="1">';
        $no = 1;
        // Loop Provinsi
        $query_province = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Provinsi'");
        while ($data_province = mysqli_fetch_array($query_province)) {
            $kode_province = $data_province['kode'];
            $nama_province = $data_province['nama'];

            echo '
                <tr>
                    <td>'.$no.'</td>
                    <td>'.$kode_province.'</td>
                    <td>'.$nama_province.'</td>
                    <td>
                        <a href="generate_wilayah.php?kategori_data=Kabupaten&kode_province='.$kode_province.'">
                            Lihat Kabupaten
                        </a>
                    </td>
                </tr>
            ';

            $no++;
        }
        echo '</table>';

    }else{
        $kategori_data = $_GET['kategori_data'];
        echo '<table border="1">';
        
        //KABUPATEN
        if($kategori_data=="Kabupaten"){
            if(!empty($_GET['kode_province'])){

                $kode_province = $_GET['kode_province'];
                
                //Buka Data Nama Provinsi
                $Qry = $Conn->prepare("SELECT kode, nama FROM wilayah_mendagri WHERE kode = ?");
                $Qry->bind_param("s", $kode_province);
                $Qry->execute();
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                $Qry->close();
                $nama_province = $Data['nama'];
                
                $no = 1;
                $query_kab = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Kota Kabupaten' AND kode like '$kode_province%'");
                while ($data_kab = mysqli_fetch_array($query_kab)) {
                    $kode_kab = $data_kab['kode'];
                    $nama_kab = $data_kab['nama'];

                    echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$kode_province.'</td>
                            <td>'.$nama_province.'</td>
                            <td>'.$kode_kab.'</td>
                            <td>Kabupaten</td>
                            <td>
                                <a href="generate_wilayah.php?kategori_data=Kelurahan_by_kab&kode_province='.$kode_province.'&kode_kab='.$kode_kab.'">
                                    '.$nama_kab.'
                                </a>
                            </td>
                            <td>
                                <a href="generate_wilayah.php?kategori_data=Kecamatan&kode_province='.$kode_province.'&kode_kab='.$kode_kab.'">
                                    Lihat Kecamatan
                                </a>
                            </td>
                        </tr>
                    ';
                    $no++;
                }


            }
        }

        //kecamatan
        if($kategori_data=="Kecamatan"){
            if(!empty($_GET['kode_province'])){
                if(!empty($_GET['kode_kab'])){
                    $kode_province = $_GET['kode_province'];
                    $kode_kab      = $_GET['kode_kab'];

                    //Buka Data Nama Provinsi
                    $Qry = $Conn->prepare("SELECT kode, nama FROM wilayah_mendagri WHERE kode = ?");
                    $Qry->bind_param("s", $kode_province);
                    $Qry->execute();
                    $Result = $Qry->get_result();
                    $Data = $Result->fetch_assoc();
                    $Qry->close();
                    $nama_province = $Data['nama'];

                    //Buka Data Nama Kabupaten
                    $Qry = $Conn->prepare("SELECT kode, nama FROM wilayah_mendagri WHERE kode = ?");
                    $Qry->bind_param("s", $kode_kab);
                    $Qry->execute();
                    $Result = $Qry->get_result();
                    $Data = $Result->fetch_assoc();
                    $Qry->close();
                    $nama_kab = $Data['nama'];

                     $no = 1;
                    $query_kec = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Kecamatan' AND kode like '$kode_kab%'");
                    while ($data_kec = mysqli_fetch_array($query_kec)) {
                        $kode_kec = $data_kec['kode'];
                        $nama_kec = $data_kec['nama'];

                        echo '
                            <tr>
                                <td>'.$no.'</td>
                                <td>'.$kode_province.'</td>
                                <td>'.$nama_province.'</td>
                                <td>'.$kode_kab.'</td>
                                <td>Kabupaten</td>
                                <td>
                                    <a href="generate_wilayah.php?kategori_data=Kelurahan_by_kab&kode_province='.$kode_province.'&kode_kab='.$kode_kab.'">
                                        '.$nama_kab.'
                                    </a>
                                </td>
                                <td>'.$kode_kec.'</td>
                                <td>'.$nama_kec.'</td>
                                <td>
                                    <a href="generate_wilayah.php?kategori_data=Kelurahan&kode_province='.$kode_province.'&kode_kab='.$kode_kab.'&kode_kec='.$kode_kec.'">
                                        Lihat Desa
                                    </a>
                                </td>
                            </tr>
                        ';
                        $no++;
                    }
                }
            }
        }

        //Desa
        if($kategori_data=="Kelurahan"){
            if(!empty($_GET['kode_province'])){
                if(!empty($_GET['kode_kab'])){
                    if(!empty($_GET['kode_kec'])){
                        $kode_province = $_GET['kode_province'];
                        $kode_kab      = $_GET['kode_kab'];
                        $kode_kec      = $_GET['kode_kec'];

                        //Buka Data Nama Provinsi
                        $Qry = $Conn->prepare("SELECT kode, nama FROM wilayah_mendagri WHERE kode = ?");
                        $Qry->bind_param("s", $kode_province);
                        $Qry->execute();
                        $Result = $Qry->get_result();
                        $Data = $Result->fetch_assoc();
                        $Qry->close();
                        $nama_province = $Data['nama'];

                        //Buka Data Nama Kabupaten
                        $Qry = $Conn->prepare("SELECT kode, nama FROM wilayah_mendagri WHERE kode = ?");
                        $Qry->bind_param("s", $kode_kab);
                        $Qry->execute();
                        $Result = $Qry->get_result();
                        $Data = $Result->fetch_assoc();
                        $Qry->close();
                        $nama_kab = $Data['nama'];

                        //Buka Data Nama Kecamatan
                        $Qry = $Conn->prepare("SELECT kode, nama FROM wilayah_mendagri WHERE kode = ?");
                        $Qry->bind_param("s", $kode_kec);
                        $Qry->execute();
                        $Result = $Qry->get_result();
                        $Data = $Result->fetch_assoc();
                        $Qry->close();
                        $nama_kec = $Data['nama'];

                        $no = 1;
                        $query_desa = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Kelurahan' AND kode like '$kode_kec%'");
                        while ($data_desa = mysqli_fetch_array($query_desa)) {
                            $kode_desa = $data_desa['kode'];
                            $nama_desa = $data_desa['nama'];

                            echo '
                                <tr>
                                    <td>'.$no.'</td>
                                    <td>'.$kode_province.'</td>
                                    <td>'.$nama_province.'</td>
                                    <td>'.$kode_kab.'</td>
                                    <td>Kabupaten</td>
                                    <td>'.$nama_kab.'</td>
                                    <td>'.$kode_kec.'</td>
                                    <td>'.$nama_kec.'</td>
                                    <td>'.$kode_desa.'</td>
                                    <td>Kelurahan</td>
                                    <td>'.$nama_desa.'</td>
                                </tr>
                            ';
                            $no++;
                        }

                    }
                }
            }
        }

        if($kategori_data=="Kelurahan_by_kab"){
            if(!empty($_GET['kode_province'])){
                if(!empty($_GET['kode_kab'])){
                    $kode_province = $_GET['kode_province'];
                    $kode_kab      = $_GET['kode_kab'];

                    //Buka Data Nama Provinsi
                    $Qry = $Conn->prepare("SELECT kode, nama FROM wilayah_mendagri WHERE kode = ?");
                    $Qry->bind_param("s", $kode_province);
                    $Qry->execute();
                    $Result = $Qry->get_result();
                    $Data = $Result->fetch_assoc();
                    $Qry->close();
                    $nama_province = $Data['nama'];

                    //Buka Data Nama Kabupaten
                    $Qry = $Conn->prepare("SELECT kode, nama FROM wilayah_mendagri WHERE kode = ?");
                    $Qry->bind_param("s", $kode_kab);
                    $Qry->execute();
                    $Result = $Qry->get_result();
                    $Data = $Result->fetch_assoc();
                    $Qry->close();
                    $nama_kab = $Data['nama'];

                    $no = 1;
                    $query_kec = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Kecamatan' AND kode like '$kode_kab%'");
                    while ($data_kec = mysqli_fetch_array($query_kec)) {
                        $kode_kec = $data_kec['kode'];
                        $nama_kec = $data_kec['nama'];
                        
                        $query_desa = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Kelurahan' AND kode like '$kode_kec%'");
                        while ($data_desa = mysqli_fetch_array($query_desa)) {
                            $kode_desa = $data_desa['kode'];
                            $nama_desa = $data_desa['nama'];
                            echo '
                                <tr>
                                    <td>'.$no.'</td>
                                    <td>'.$kode_province.'</td>
                                    <td>'.$nama_province.'</td>
                                    <td>'.$kode_kab.'</td>
                                    <td>Kabupaten</td>
                                    <td>'.$nama_kab.'</td>
                                    <td>'.$kode_kec.'</td>
                                    <td>'.$nama_kec.'</td>
                                    <td>'.$kode_desa.'</td>
                                    <td>Kelurahan</td>
                                    <td>'.$nama_desa.'</td>
                                </tr>
                            ';
                            $no++;
                        }
                    }
                }
            }
        }

        echo '</table><br><br><br><br><br><br>';
    }
    

    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_wilayah_mendagri FROM wilayah_mendagri "));
    if(empty($jml_data)){

        // Loop Kategori
        $query_kategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM wilayah_mendagri");
        while ($data_kategori = mysqli_fetch_array($query_kategori)) {
            $kategori = $data_kategori['kategori'];

            echo "$kategori <br>";
        }

        echo '<table border="1">';

        $no = 1;
        // Loop Provinsi
        $query_province = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Provinsi' AND kode='32'");
        while ($data_province = mysqli_fetch_array($query_province)) {
            $kode_province = $data_province['kode'];
            $nama_province = $data_province['nama'];

            // Loop Kabupaten
            $query_kab = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Kota Kabupaten' AND kode like '$kode_province%'");
            while ($data_kab = mysqli_fetch_array($query_kab)) {
                $kode_kab = $data_kab['kode'];
                $nama_kab = $data_kab['nama'];

                // Loop Kecamatan
                $query_kec = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Kecamatan' AND kode like '$kode_kab%'");
                while ($data_kec = mysqli_fetch_array($query_kec)) {
                    $kode_kec = $data_kec['kode'];
                    $nama_kec = $data_kec['nama'];

                    // Loop Desa
                    $query_desac = mysqli_query($Conn, "SELECT DISTINCT kode, nama FROM wilayah_mendagri WHERE kategori='Kelurahan' AND kode like '$kode_kec%'");
                    while ($data_desa = mysqli_fetch_array($query_desac)) {
                        $kode_desa = $data_desa['kode'];
                        $nama_desa = $data_desa['nama'];

                        echo '
                            <tr>
                                <td>'.$no.'</td>
                                <td>'.$kode_province.'</td>
                                <td>'.$nama_province.'</td>
                                <td>'.$kode_kab.'</td>
                                <td>Kabupaten</td>
                                <td>'.$nama_kab.'</td>
                                <td>'.$kode_kec.'</td>
                                <td>'.$nama_kec.'</td>
                                <td>'.$kode_desa.'</td>
                                <td>Kelurahan</td>
                                <td>'.$nama_desa.'</td>
                            </tr>
                        ';

                        $no++;
                    }
                }
            }
        }

        echo '</table>';
    }
?> 