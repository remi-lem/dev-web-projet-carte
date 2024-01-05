let map = L.map('map', {minZoom: 5}).setView([46.603354, 1.8883335], 6);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);


let boundingBoxString = '[42.261049,-4.855957,51.041394,8.525391]'; //via http://bboxfinder.com

let boundingBox = JSON.parse(boundingBoxString);
let coord1 = L.latLng(boundingBox[0], boundingBox[1]);
let coord2 = L.latLng(boundingBox[2], boundingBox[3]);
let bounds = L.latLngBounds(coord1, coord2);

map.fitBounds(bounds);

const trainIcon = L.icon({
    iconUrl: 'images/marqueurs/train.png',
    iconSize: [26, 32],
    iconAnchor: [13, 32],
    popupAnchor: [0, -29]
});

const houseIcon = L.icon({
    iconUrl: 'images/marqueurs/house.png',
    iconSize: [26, 38],
    iconAnchor: [13, 38],
    popupAnchor: [0, -34]
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
                    "<a href='user_account.php?addFavId=" + feature.properties.code_uic + "'>Marquer comme favori</a>" + '<br>' +
                    `<a class='calculItineraire' onclick='calculateRoute(${feature.properties.c_geo.lat}, ${feature.properties.c_geo.lon})'>Calculer l'itinéraire</a>`
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


let route = L.Routing.control({
    createMarker: function() { return null; },
    draggableWaypoints: false,
    addWaypoints: false,
    language: 'fr',
    show : false
}).addTo(map);

//---------------JQUERY-UI---------------
$( function() {
    $( ".draggable" ).draggable({ revert: true });
} );

$( function() {
    $( ".draggable" ).draggable();
    $( ".droppable" ).droppable({
        drop: function( event, ui ) {
            $.ajax({
                url: "https://nominatim.openstreetmap.org/search?format=json&q=" + ui.helper.text(),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        const latitude = data[0].lat;
                        const longitude = data[0].lon;
                        $('.coordonnees p').text("[" + latitude + " ; " + longitude + "]");
                        map.setView([latitude, longitude], 13);
                    }
                }
            });
        }
    });
} );
//---------------END-JQUERY-UI---------------
