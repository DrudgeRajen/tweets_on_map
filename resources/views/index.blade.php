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
        function initMap(){
            var BangkokLatLng = {
                lat: 13.7563309,
                lng: 100.50176510000006
            };

            var markers = [],
                infoWindowContent = []

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: BangkokLatLng
            });

            var marker = new google.maps.Marker({
                position: BangkokLatLng,
                map: map,
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
                            getTweetsByLatLng(lat,lng);
                    }
                }
            )
        });

        function getTweetsByLatLng(lat,lng) {
            $.ajax({
               url:"{{route('ajax.tweets')}}",
                type:"get",
                dataType:"json",
                data:"lat="+lat + "&lng=" + lng,
               success:function (response) {
                   console.log(response);
               }
            });
        }

    </script>
    @endsection