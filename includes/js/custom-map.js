jQuery(document).ready(function ($) {
    var map = L.map('maps').setView([51.505, -0.09], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    if (MapsData.markers.length > 0) {
        MapsData.markers.forEach(function (post) {
            if (post.lat && post.lng) {
                L.marker([post.lat, post.lng]).addTo(map)
                    .bindPopup('<a href="' + post.permalink + '">' + post.title + '</a>');
            }
        });
    }
});