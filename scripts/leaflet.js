let map = L.map('map', {minZoom: 5}).setView([46.980, 3.779], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

const trainIcon = L.icon({
    iconUrl: 'images/marqueurs/train.png',
    iconSize: [26, 32],
});

const markers = L.markerClusterGroup();

fetch("data/liste-des-gares.geojson")
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        L.geoJSON(data, {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng, {
                    icon: trainIcon
                });
            },
            onEachFeature: function (feature, layer) {
                layer.bindPopup('<b>' + feature.properties.libelle + '</b><br>' +
                    feature.properties.commune + ", " + feature.properties.departemen + '<br>' +
                    "Fret : " + feature.properties.fret + ", Voyageurs : " + feature.properties.voyageurs + '<br>' +
                    "<a href='user_account.php?addFavId=" + feature.properties.code_uic + "'>Marquer comme favori</a>"
                );
            }
        }).addTo(markers);
    })
    .catch(function (error) {
        console.error('Erreur lors du chargement des données GeoJSON :', error);
    });

map.addLayer(markers);

fetch("data/lignes-lgv-et-par-ecartement.geojson")
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        L.geoJSON(data).addTo(map);
    })
    .catch(function (error) {
        console.error('Erreur lors du chargement des données GeoJSON :', error);
    });
