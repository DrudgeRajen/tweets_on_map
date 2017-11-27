<!DOCTYPE html>
<html>
<head>
    <title> Tweets on Map </title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK6sWy2ZLqhjSPPyrb7W9eYEwj8SFs5tE&libraries=places">
    </script>
    {{--<script type="text/javascript"--}}
            {{--src="https://maps.googleapis.com/maps/api/js?v=3&libraries=places">--}}
    {{--</script>--}}

    <script type="text/javascript" href="{{asset('js/map.js')}}"></script>
</head>
<body>
@yield('content')

</body>
<script type="text/javascript" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>