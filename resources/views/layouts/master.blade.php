<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK6sWy2ZLqhjSPPyrb7W9eYEwj8SFs5tE">
    </script>

    <script type="text/javascript" href="{{asset('js/map.js')}}"></script>
</head>
<body>
<h3>Tweets on Map</h3>
<div id="map"></div>

<script>
    function initMap(){
        var myLatLng = {
            lat: 43.6222102,
            lng: -79.6694881
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
        });
    }
    google.maps.event.addDomListener(window, 'load', initMap);

</script>

</body>
</html>