// Harita oluşturuluyor
var map = L.map('map').setView([39.92077, 32.85411], 6); // Türkiye merkezli başlangıç konumu

// OpenStreetMap katmanını ekle
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// PHP'den verileri alıp haritaya marker ekleyelim
document.querySelectorAll('.data-row').forEach(function(row) {
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
