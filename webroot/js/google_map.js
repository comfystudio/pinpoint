/**
 * Created by Juggernaught-Bitch on 20/10/2015.
 */
$( document ).ready(function() {
    function initMap() {
        var mapOptions = {
            zoom: 8,
            center: {lat: 54.6, lng: -5.92},
            //disableDefaultUI: true
        }

        var lastMarker;  //lastmarker is needed to remove previous markers

        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        map.addListener('click', function(e) {
            console.log(e.latLng);
            updateLatLng(e.latLng, map);
        });

        $( "#StoryLat" ).change(function() {
            var lat = $("#StoryLat").val();
            var long = $("#StoryLong").val();
            var latLng = new google.maps.LatLng(lat, long);
            updateLatLng(latLng, map);
        });

        $( "#StoryLong" ).change(function() {
            var lat = $("#StoryLat").val();
            var long = $("#StoryLong").val();
            var latLng = new google.maps.LatLng(lat, long);
            updateLatLng(latLng, map);
        });
    }


    function updateLatLng(latLng, map){
        var marker = new google.maps.Marker({
            position: latLng,
            map: map
        });

        if (typeof lastMarker !== 'undefined') {
            lastMarker.setMap(null);
        }

        lastMarker = marker;
        map.panTo(latLng);

        var myLatLng = latLng;
        var lat = myLatLng.lat();
        var lng = myLatLng.lng();
        $("#StoryLat").val(lat);
        $("#StoryLong").val(lng);
    }

    initMap();
});