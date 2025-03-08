<!DOCTYPE html>
<html lang="tr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harita ve Veri Tablosu</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* Genel sayfa düzeni */
        body {
            display: flex;
            flex-wrap: wrap;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Üst kısım alanları (Harita ve Tablo) */
        .top-container {
            display: flex;
            width: 100%;  /* Üst kısmın tüm genişliği */
            height: 50%;  /* Yüksekliği 50% olacak şekilde ayarlandı */
        }

        /* Sol taraf (Harita) */
        #map {
            width: 50%; /* Harita kısmı genişliği */
            height: 100%;
        }

        /* Sağ taraf (Tablo) */
        #data-container {
            width: 50%; /* Tablo kısmı genişliği */
            height: 100%;
            padding: 20px;
            overflow-y: auto;
            background-color: #f4f4f4;
        }

        /* Tablo düzeni */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .data-row:hover {
            background-color: #e0e0e0;
        }

        /* Alt kısım boş alan */
        .bottom-container {
            display: flex;
            width: 100%;
            height: 50%; /* Alt kısmın yüksekliği */
        }

        .bottom-container div {
            flex: 1;  /* Her iki alt alan eşit genişlikte olacak */
            border: 1px solid #ddd;
            margin: 5px;
        }

    </style>
</head>
<body>

    <!-- Üst Kısım -->
    <div class="top-container">
        <!-- Sol Alan: Harita -->
        <div id="map"></div>

        <!-- Sağ Alan: Tablo -->
        <div id="data-container">
            <h3>Konumlar</h3>
            <table id="location-table">
                <thead>
                    <tr>
                        <th>Firma Adı</th>
                        <th>Adres</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Veriler PHP'den gelecek -->
                    <?php
                        // Veritabanı bağlantısı
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "kds";

                        // Veritabanı bağlantısı oluşturuluyor
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Bağlantı hatası kontrolü
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Konumları veritabanından çekme
                        $sql = "SELECT firma_ad, il_ad, lat, lng FROM location";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Veritabanındaki her bir konum için satır oluştur
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

    <!-- Alt Kısım: Boş Alan -->
    <div class="bottom-container">
        <div></div>
        <div></div>
    </div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Harita oluşturuluyor
        var map = L.map('map').setView([39.92077, 32.85411], 6); // Türkiye merkezli başlangıç konumu

        // OpenStreetMap katmanını ekle
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // PHP'den verileri alıp haritaya marker ekleyelim
        document.querySelectorAll('.data-row').forEach(function(row) {
            // Veritabanından alınan her satır için ilgili bilgileri al
            var name = row.cells[0].innerText;
            var address = row.cells[1].innerText;
            var lat = parseFloat(row.getAttribute('data-lat'));
            var lng = parseFloat(row.getAttribute('data-lng'));
            var point = [lat, lng]; // Konum bilgileri

            // Haritaya marker ekle
            var popupContent = `<strong>${name}</strong><br>${address}`;
            var marker = L.marker(point).addTo(map).bindPopup(popupContent);

            // Tablo satırına tıklandığında haritada o konumu göster
            row.addEventListener('click', function() {
                map.setView([lat, lng], 10); // Harita konumunu ayarla
                marker.openPopup(); // Popup'ı aç
            });
        });
    </script>
</body>
</html>
