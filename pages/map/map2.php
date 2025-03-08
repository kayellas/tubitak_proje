<?php include("header.php")?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- CSS Bağlantıları -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="map.css">

    <style>
        .top-container {
            display: flex;
            width: 100%;
            height: 60vh;
        }

        #map {
            flex: 1;
            height: 100%;
        }

        #data-container {
            width: 40%;
            height: 100%;
            overflow-y: auto;
            background-color: #f4f4f4;
            padding: 10px;
        }

        .bottom-container {
            width: 100%;
            height: 40vh;
            padding: 10px;
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index.php" class="brand-link">
                <span class="brand-text font-weight-light">Tedarik Zinciri Yönetimi</span>
            </a>
            <div class="sidebar">
                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="urunekle.html" class="nav-link active">
                                <i class="nav-icon fas fa-box"></i>
                                <p>Ürün Ekle</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Üst Kısım (Harita ve Firma Bilgileri) -->
        <div class="top-container">
            <div id="map"></div>

            <div id="data-container">
                <h3>Firma Bilgileri</h3>
                <table id="location-table">
                    <thead>
                        <tr>
                            <th>Firma Adı</th>
                            <th>Adres</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Veritabanı Bağlantısı
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "kds";
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error) {
                                die("Bağlantı hatası: " . $conn->connect_error);
                            }

                            $sql = "SELECT firma_ad, il_ad, lat, lng FROM location";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr class='data-row' data-lat='{$row['lat']}' data-lng='{$row['lng']}'>";
                                    echo "<td>" . $row['firma_ad'] . "</td>";
                                    echo "<td>" . $row['il_ad'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>Veri bulunamadı.</td></tr>";
                            }

                            $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Alt Kısım (Boş Stok Tablosu) -->
        <div class="bottom-container">
            <table id="stok-table">
                <thead>
                    <tr>
                        <th>Ürün Adı</th>
                        <th>Mevcut Stok</th>
                        <th>Maksimum Stok</th>
                        <th>Stok Farkı</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ürün 1</td>
                        <td>0</td>
                        <td>5000</td>
                        <td>5000</td>
                    </tr>
                    <tr>
                        <td>Ürün 2</td>
                        <td>0</td>
                        <td>5000</td>
                        <td>5000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="map.js"></script>
    </div>
</body>
</html>



           <!-- Alt Kısım (Stok Tablosu) -->
           <div class="bottom-container">
            <h3>Firma Stok Durumu</h3>
            <table id="stok-table">
                <thead>
                    <tr>
                        <th>Firma Adı</th>
                        <th>İl</th>
                        <th>Kategori</th>
                        <th>Ürün Sayısı</th>
                        <th>Toplam Stok</th>
                        <th>Stok Farkı</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Veritabanı Bağlantısı
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "kds";
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Bağlantı hatası: " . $conn->connect_error);
                        }

                        // Stok bilgilerini getiren SQL sorgusu
                        $sql = "SELECT 
                                    l.firma_ad, 
                                    l.il_ad,  
                                    k.kategori_ad,
                                    COUNT(u.urun_id) AS urun_sayisi, 
                                    SUM(u.urun_miktar) AS toplam_stok, 
                                    SUM(u.max_urun_miktar - u.urun_miktar) AS toplam_stok_farki
                                FROM location l
                                JOIN urun u ON l.kategori_id = u.kategori_id
                                JOIN kategori k ON l.kategori_id = k.kategori_id
                                GROUP BY l.firma_ad, l.il_ad, l.kategori_id, k.kategori_ad";
                        
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['firma_ad'] . "</td>";
                                echo "<td>" . $row['il_ad'] . "</td>";
                                echo "<td>" . $row['kategori_ad'] . "</td>";
                                echo "<td>" . $row['urun_sayisi'] . "</td>";
                                echo "<td>" . $row['toplam_stok'] . "</td>";
                                echo "<td>" . $row['toplam_stok_farki'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Stok bilgisi bulunamadı.</td></tr>";
                        }

                        $conn->close();
                    ?>
                </tbody>
            </table>
        </div>