$( ".draggable" ).draggable({ revert: true });

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