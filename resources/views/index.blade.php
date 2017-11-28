@extends('layouts.master')
@section('content')
    <div id="map"></div>
    <div class="ajax-loader" style="display: none;">
    </div>
    <form class="form-inline" id="searchTweets">
        <div class="form-group tweets_on_maps clearfix">
        <input type="text" class="form-control" id="autocomplete" name="location" value="Bangkok" required>
            <button type="submit" class="btn btn-primary">Search</button>
            <button type="button" id="history" class="btn btn-primary">History</button>
        </div>
    </form>
@endsection