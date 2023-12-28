let map = L.map('map', {minZoom: 5}).setView([46.980, 3.779], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

const trainIcon = L.icon({
    iconUrl: 'images/marqueurs/train.png',
    iconSize: [26, 32],
});

const markers = L.markerClusterGroup();

function FretOrVoyageurs(feature) {
    if(feature.properties.fret === 'O' && feature.properties.voyageurs === 'N'){
        return "Fret uniquement";
    }
    else if(feature.properties.fret === 'N' && feature.properties.voyageurs === 'O'){
        return "Voyageurs uniquement";
    }
    else if(feature.properties.fret === 'O' && feature.properties.voyageurs === 'O'){
        return "Fret et Voyageurs";
    }
    else if(feature.properties.fret === 'N' && feature.properties.voyageurs === 'N'){
        console.log("Erreur à la fonction FretOrVoyageurs : gare fantôme")
        return "Ni Fret ni Voyageurs";
    }
    else {
        console.log("Erreur à la fonction FretOrVoyageurs : gare avec des propriétés non renseignées")
        return "";
    }
}

fetch("data/liste-des-gares.geojson")
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        L.geoJSON(data, {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng, {
                    icon: trainIcon,
                    title: feature.properties.libelle
                });
            },
            onEachFeature: function (feature, layer) {
                layer.bindPopup('<b>' + feature.properties.libelle + '</b><br>' +
                    feature.properties.commune + ", " + feature.properties.departemen + '<br>' +
                    FretOrVoyageurs(feature) + '<br>' +
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


let controlSearch = new L.Control.Search({
    position:'topleft',
    layer: markers,
    initial: false,
    marker: false,
    moveToLocation: function (latlng, title, map) {
        map.setView(latlng, 18);
        latlng.layer.openPopup();
    }
});

map.addControl( controlSearch );

/*
//TODO : avancer sur l'automatisation des routes + obliger a passer par les voies de chemin de fer
L.Routing.control({
    waypoints: [
        L.latLng(48.92078365152306, 2.1846347887831916),
        L.latLng(48.88731358907528, 2.1715467466022713)
    ],
    routeWhileDragging: false
}).addTo(map);
*/
