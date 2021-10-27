function initMap() {
    // Directions variables
    let directionsService = new google.maps.DirectionsService;
    let directionsDisplay = new google.maps.DirectionsRenderer;
    
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

    const schoolMarker = new google.maps.Marker({
        position: {lat: 51.789916, lng: 19.414885},
        map: map,
        title: 'Szkoła Podstawowa nr 56'
    });


    directionsDisplay.setMap(map);

    // Add function to calculate route when button is clicked
    let sended = false;
    const submitButton = document.getElementById('findSubmitButton');
    submitButton.addEventListener('click', function() {
        calculateAndDisplayRoute(directionsService, directionsDisplay);
        sended = true;
    });

    // Add function to calulate route when ENTER is pressed on startPointAddres input
    document.getElementById('startPointAddress').addEventListener('keydown', function(e) {
        if(e.keyCode == 13) {
            e.preventDefault();
            calculateAndDisplayRoute(directionsService, directionsDisplay);
        }
    });

    // Initialize change handler function
    const onChangeHandler = function() {
        if(sended && document.getElementById('startPointAddress').value != '') {
            calculateAndDisplayRoute(directionsService, directionsDisplay);
        }
    }

    // Add function to calculate route when endPointAddres or transportMode has changed
    document.getElementById('endPointAddress').addEventListener('change', onChangeHandler);
    document.getElementById('transportMode').addEventListener('change', onChangeHandler);
}


function calculateAndDisplayRoute(directionsService, directionsDisplay) {
    let startPoint = document.getElementById('startPointAddress').value;
    let endPoint = document.getElementById('endPointAddress').value;
    let selectedMode = document.getElementById('transportMode').value;

    const request = {
        origin: startPoint,
        destination: endPoint,
        travelMode: google.maps.TravelMode[selectedMode]
    }

    directionsService.route(request, function(response, status) {
        if(status == 'OK') {
            directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}