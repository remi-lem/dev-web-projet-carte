
//TODO : rassembler les marqueurs quand on dezoome

let map = L.map('map').setView([46.980, 3.779], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

var trainIcon = L.icon({
    iconUrl: 'images/marqueurs/train.png',
    iconSize:     [26, 32],
    //iconAnchor:   [22, 94],
    //popupAnchor:  [-5, -87]
});



fetch("data/gares-tgv.geojson")
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
                layer.bindPopup('<b>' + feature.properties.Nom_Gare + '</b><br>' + " plus d'infos ici");//TODO
            }
        }).addTo(map);
    })
    .catch(function (error) {
        console.error('Erreur lors du chargement des données GeoJSON :', error);
    });
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
