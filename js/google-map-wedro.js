function initMap() {
    
    // Draw the map
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
		scrollwheel: false,
        center: {lat: 51.786950, lng: 19.417350} , // scoutBaseAdress
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
            mapTypeIds: [
                google.maps.MapTypeId.ROADMAP,
                google.maps.MapTypeId.HYBRID
            ]
        },
        fullscreenControl: true
    });

    // Add markers
    const scoutBaseMarker = new google.maps.Marker({
        position: {lat: 51.786950, lng: 19.417350},
        map: map,
        title: 'Harcówka'
    });
}