function initMap() {
    
    // Draw the map
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
		scrollwheel: false,
        center: {lat: 53.788601, lng: 17.478206} , // scoutBaseAdress
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
        position: {lat: 53.788601, lng: 17.478206},
        map: map,
        title: 'Kopernica'
    });
}