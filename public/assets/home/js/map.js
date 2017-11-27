var markers = [],
    infoWindowContent = []
var autocomplete;

/**
 * Initialize Map
 *
 */
function initMap(){

    // Initalize Autocomplete Places
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('autocomplete'),
        { types: ['geocode'] }
    );
    var BangkokLatLng = {
        lat: 13.7563309,
        lng: 100.50176510000006
    };



    var bounds = new google.maps.LatLngBounds();

    //Initialize and display map with lat and lng of bangkok as default
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: BangkokLatLng
    });


    var infoWindow = new google.maps.InfoWindow(),
        marker, i;

    // Loop the markers(as they are multiple profile image of tweets in different location)
    for (i = 0; i < markers.length; i++) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: markers[i][3],
            title: markers[i][0]
        });


        //show the content in the info window on click of marker
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));


        map.fitBounds(bounds);
    }


    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(10);
        google.maps.event.removeListener(boundsListener);
    });
}
google.maps.event.addDomListener(window, 'load', initMap);

getTweetsByLatLng('Bangkok',13.7563309,100.50176510000006);

/**
 *  Submit a from
 *
 */
$('#searchTweets').submit(function (e) {
    e.preventDefault();
    $('.ajax-loader').show();
    var location = $("#searchTweets").serialize();
    console.log(location);
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
            'address':location,
        },
        function (results,status) {
            if (status == 'OK')
            {
                var lat =results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();
                getTweetsByLatLng(location,lat,lng);
            }
        }
    )
});

/**
 * Get Tweets by latitude and longitude
 *
 * @param location
 * @param lat
 * @param lng
 */
function getTweetsByLatLng(location,lat,lng) {
    console.log(lat);
    console.log(lng);
    $.ajax({
        url: APP_URL + "/ajaxGetTweetsByLatLng",
        type:"get",
        dataType:"json",
        data:"lat="+lat + "&lng=" + lng,
        success: function(response) {
            console.log(response);
            markers = [];
            infoWindowContent = [];
            if (response.length) {
                for (var i = 0; i < response.length; i++) {
                    var markerTweet = [response[i].screen_name, response[i].lat, response[i].lng, response[i].profile_img];
                    markers.push(markerTweet);

                    var infoTweet = ['<div class="info_content"><p>' + response[i].text + ' <a href="' + response[i].url + '" target="_blank">more..</a></p></div>'];
                    infoWindowContent.push(infoTweet);
                    $('#location').val(location);
                }
                $('.ajax-loader').hide();
            } else {
                var markerTweet = ['Tweets in your city', lat,lng];
                markers.push(markerTweet);

                var infoTweet = ['<div class="info_content"><p>No tweets found, Please try again !!</p></div>'];
                infoWindowContent.push(infoTweet);
                console.log('here');
                $('#location').val(location);
                $('.ajax-loader').hide();
            }

            initMap();
        }
    });
}

