@extends('layouts.master')
@section('content')
    <div id="map"></div>

    <form class="form-inline ">
        <div class="form-group tweets_on_maps clearfix">
        <input type="text" class="form-control" id="location">
            <button type="button" id="search" class="btn btn-primary">Search</button>
            <button type="button" id="history" class="btn btn-primary">History</button>
        </div>
    </form>

    <script>

        var markers = [],
            infoWindowContent = []
        function initMap(){
            var BangkokLatLng = {
                lat: 13.7563309,
                lng: 100.50176510000006
            };



            var bounds = new google.maps.LatLngBounds();

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: BangkokLatLng
            });


            var infoWindow = new google.maps.InfoWindow(),
                marker, i;
                console.log(markers);

            for (i = 0; i < markers.length; i++) {
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    icon: markers[i][3],
                    title: markers[i][0]
                });


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



        $('#search').on('click',function () {
            var location = $("#location").val();
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

        function getTweetsByLatLng(location,lat,lng) {
            $.ajax({
               url:"{{route('ajax.tweets')}}",
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
                    } else {
                        var markerTweet = ['Tweets in your city', lat,lng];
                        markers.push(markerTweet);

                        var infoTweet = ['<div class="info_content"><p>No tweets found, try again</p></div>'];
                        infoWindowContent.push(infoTweet);
                        $('#location').val(location);
                    }

                    initMap();
                }
            });
        }

    </script>
    @endsection