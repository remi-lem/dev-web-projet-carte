
let map = L.map('map').setView([46.980, 3.779], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

fetch("data/gares-tgv.geojson")
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        L.geoJSON(data, {
            onEachFeature: function (feature, layer) {
                layer.bindPopup(feature.properties.Nom_Gare);
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
