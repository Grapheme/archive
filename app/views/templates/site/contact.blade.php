@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

    <section class="normal-page">
        <div class="wrapper">
            <h1>Контакты</h1>

            <div class="contacts">

                {{ $page->block('contacts') }}
    
                <div class="btn-cont">
                    <a href="{{ URL::route('page', array('feedback')) }}" class="us-btn invert">Задать вопрос</a>
                </div>
                <div class="map-cont">
                    <div id="contact-map"></div>
                </div>
                <div class="contact-hr"></div>
    
                {{ $page->block('spec') }}

            </div>

        </div>
    </section>

@stop


@section('scripts')
    <script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA4Q5VgK-858jgeSbJKHbclop_XIJs3lXs&sensor=true">
    </script>
    <script type="text/javascript">

    function initialize() {

        var myLatlng = new google.maps.LatLng(47.218275, 39.721368);

        var mapOptions = {
          center: myLatlng,
          zoom: 17,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("contact-map"),
            mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });

    }

    google.maps.event.addDomListener(window, 'load', initialize);

    </script>
@stop