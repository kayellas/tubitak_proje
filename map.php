<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Using MySQL and PHP with Google Maps</title>
    <style>
        #map {
            height: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(-33.863276, 151.207977),
                zoom: 12
            });
            var infoWindow = new google.maps.InfoWindow;

            // Fetch data from PHP script
            fetch('http://localhost/maps/xml.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(marker => {
                        var point = new google.maps.LatLng(
                            parseFloat(marker.lat),
                            parseFloat(marker.lng)
                        );

                        var infowincontent = document.createElement('div');
                        var strong = document.createElement('strong');
                        strong.textContent = marker.name;
                        infowincontent.appendChild(strong);
                        infowincontent.appendChild(document.createElement('br'));

                        var text = document.createElement('text');
                        text.textContent = marker.address;
                        infowincontent.appendChild(text);

                        var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                            label: marker.type
                        });

                        marker.addListener('click', function() {
                            infoWindow.setContent(infowincontent);
                            infoWindow.open(map, marker);
                        });
                    });
                });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"
        defer
    ></script>
</body>
</html>


<?php
        $locations=array(); 
        $uname="root";
        $pass="";
        $servername="localhost";
        $dbname="kds";
        $db=new mysqli($servername,$uname,$pass,$dbname);
        $query =  $db->query("SELECT * FROM location");
        //$number_of_rows = mysql_num_rows($db);  
        //echo $number_of_rows;

        while ($row = $query->fetch_assoc()) {
            $firma_ad = $row['firma_ad'];
            $longitude = $row['lng'];  // Boylam
            $latitude = $row['lat'];   // Enlem
            $arac_sayisi = $row['arac_sayisi'];
            
            /* Her bir satır yeni bir dizi olarak ekleniyor */
            $locations[] = array(
                'name' => $firma_ad, 
                'lat' => $latitude, 
                'lng' => $longitude, 
                'vehicle_count' => $arac_sayisi,  // Araç sayısı,
                'type' => 'R' // You can customize this based on your needs,
            );
        }
        

        //echo $locations[0]['name'].": In stock: ".$locations[0]['lat'].", sold: ".$locations[0]['lng'].".<br>";
        //echo $locations[1]['name'].": In stock: ".$locations[1]['lat'].", sold: ".$locations[1]['lng'].".<br>";
    ?>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=Your-Google-Map-API-Key"></script> 
    <script type="text/javascript">
    var map;
    var Markers = {};
    var infowindow;
    var locations = [
        <?php for($i=0;$i<sizeof($locations);$i++){ $j=$i+1;?>
        [
            'AMC Service',
            '<p><a href="<?php echo $locations[0]['lnk'];?>">Book this Person Now</a></p>',
            <?php echo $locations[$i]['lat'];?>,
            <?php echo $locations[$i]['lng'];?>,
            0
        ]<?php if($j!=sizeof($locations))echo ","; }?>
    ];
    var origin = new google.maps.LatLng(locations[0][2], locations[0][3]);

    function initialize() {
      var mapOptions = {
        zoom: 9,
        center: origin
      };

      map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        infowindow = new google.maps.InfoWindow();

        for(i=0; i<locations.length; i++) {
            var position = new google.maps.LatLng(locations[i][2], locations[i][3]);
            var marker = new google.maps.Marker({
                position: position,
                map: map,
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][1]);
                    infowindow.setOptions({maxWidth: 200});
                    infowindow.open(map, marker);
                }
            }) (marker, i));
            Markers[locations[i][4]] = marker;
        }

        locate(0);

    }

    function locate(marker_id) {
        var myMarker = Markers[marker_id];
        var markerPosition = myMarker.getPosition();
        map.setCenter(markerPosition);
        google.maps.event.trigger(myMarker, 'click');
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <body id="map-canvas">



