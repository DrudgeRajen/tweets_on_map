<!DOCTYPE html>
<html>
<head>
    <title> Map Based Search Application </title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="{{asset('assets/home/css/style.css')}}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK6sWy2ZLqhjSPPyrb7W9eYEwj8SFs5tE&libraries=places">
    </script>

</head>
<body>
@yield('content')

</body>
<script type="text/javascript" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    var APP_URL = {!! json_encode(url('/')) !!}
</script>
<script type="text/javascript" src="{{asset('assets/home/js/map.js')}}"></script>
</html>