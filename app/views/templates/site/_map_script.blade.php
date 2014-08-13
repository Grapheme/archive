
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA4Q5VgK-858jgeSbJKHbclop_XIJs3lXs&sensor=true">
</script>
<script type="text/javascript">

    <?
    $building_types = Dictionary::whereSlugValues('building_types')->lists('slug', 'id');
    ?>

    function initialize() {

        var map_center = [59.939095, 30.315868];
        var map_objects = [];
        var main_obj_exist = false;

        // Get info about buildings
        @if (@count($objects))
            @if (@isset($center))
                var map_center = [{{ $center['lat'] }}, {{ $center['lng'] }}];
                var main_obj_exist = true;
            @endif
            @foreach ($objects as $building)

                {{ Helper::dd_($building) }}

                @if (@$building['main'])
                if (!main_obj_exist) {
                    main_obj_exist = true;
                    map_center = [{{ $building['lat'] }}, {{ $building['lng'] }}];
                }
                @endif
                map_objects.push({name: '{{ $building['name'] }}', lat: {{ $building['lat'] }}, lng: {{ $building['lng'] }}, type: '{{ @isset($building['people_per_room']) ? 'hostel' : @$building_types[$building['type']] }}'});
            @endforeach
        @endif

        // Center
        var map_lat = map_center[0];
        var map_lng = map_center[1];
        var myLatlng = new google.maps.LatLng(map_lat, map_lng);

        // Init map
        var mapOptions = {
            center: myLatlng,
            zoom: {{ @count($objects) ? '17' : '12' }},
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        };
        var map = new google.maps.Map(document.getElementById('{{ $map_id}}'), mapOptions);

        // http://blog.shamess.info/2009/09/29/zoom-to-fit-all-markers-on-google-maps-api-v3/
        // Make an array of the LatLng's of the markers you want to show
        var LatLngList = [];

        // Set markers
        if (map_objects.length) {
            map_objects.forEach(function(object, index) {

                LatLngList.push(new google.maps.LatLng(object.lat, object.lng));

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(object.lat, object.lng),
                    icon: '/img/map/' + object.type + '.png',
                    map: map
                });
            });
        }

        // Create a new viewpoint bound
        var bounds = new google.maps.LatLngBounds();
        if (LatLngList.length) {
            // Go through each...
            for (var i = 0, LtLgLen = LatLngList.length; i < LtLgLen; i++) {
                //  And increase the bounds to take this point
                bounds.extend(LatLngList[i]);
            }
            //  Fit these bounds to the map
            map.fitBounds(bounds);
        }

        // Возвращаем центр карты на основной объект
        if (main_obj_exist)
            map.panTo(myLatlng);
    }

    var map = google.maps.event.addDomListener(window, 'load', initialize);

</script>