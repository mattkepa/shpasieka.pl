function initMap() {
    
    // Draw the map
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
		scrollwheel: false,
        center: {lat: 49.1753626, lng: 22.60085170000002} , // scoutBaseAdress
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
        position: {lat: 49.1753626, lng: 22.60085170000002},
        map: map,
        title: 'HBO Nasiczne'
    });
}