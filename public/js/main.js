$(document).ready(function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                $("#longitude").val(longitude);
                $("#latitude").val(latitude);
            },
            function (error) {
                alert(`Error: ${error.message}`);
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});

  // leaflet

  
