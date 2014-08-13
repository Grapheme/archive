@extends(Helper::layout())



@section('content')

<main class="wrapper-full wrapper-pad">
    <div class="wrapper">
        <div class="bread">
            <span class="crumb"><a href="/" class="us-link">Главная</a></span>
            @if (is_object($city))
            <span class="crumb">
                <a href="#" class="us-link">
                    {{ $city->name }}
                </a>
                <span class="crumb-sub">
                    {{ trans_choice(':count вуз|:count вуза|:count вузов', $city_university_count, array(), 'ru') }}
                </span>
            </span>
            @endif
            @if (is_object($university))
            <span class="crumb">
                <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $university->id)) }}" class="us-link">
                    {{ $university->name }}
                </a>
                <span class="crumb-sub">
                    {{ trans_choice(':count направление|:count направления|:count направлений', $university->specialities->count(), array(), 'ru') }}
                </span>
            </span>
            @endif
            @if (is_object($speciality))
            <span class="crumb">
                <a href="{{ URL::action($CLASS."@getSpeciality", array('speciality_id' => $speciality->id)) }}" class="us-link">{{ $speciality->name }}</a>
            </span>
            @endif
            <span class="crumb">Мероприятия</a>
        </div>

        <div class="dir-search-left">

            <div class="gray-block not_ready">
                <div class="normal-title">Популярные вузы</div>
                <ul class="relative-dirs unstyled-list">
                    <li class="margin-t15">
                        <div class="dir-left">
                            <div class="title">
                                <a href="#" class="us-link">Математика и экономика</a>
                            </div>
                            <div class="desc">
                                Санкт-Петербургский государственный университет экономики и финансов
                            </div>
                        </div>
                        <div class="rating fl-r">4,5</div>
                    </li>
                    <li class="margin-t15">
                        <div class="dir-left">
                            <div class="title">
                                <a href="#" class="us-link">Математика и экономика</a>
                            </div>
                            <div class="desc">
                                Санкт-Петербургский государственный университет экономики и финансов
                            </div>
                        </div>
                        <div class="rating fl-r">4,5</div>
                    </li>
                    <li class="margin-t15">
                        <div class="dir-left">
                            <div class="title">
                                <a href="#" class="us-link">Математика и экономика</a>
                            </div>
                            <div class="desc">
                                Санкт-Петербургский государственный университет экономики и финансов
                            </div>
                        </div>
                        <div class="rating fl-r">4,5</div>
                    </li>
                </ul>
            </div>

            <div class="dir-map min-map">
                <div class="title not_ready">Поиск по карте</div>
                <div id="dir-map"></div>
                <div class="dir-hints">
                    <span><i class="fa fa-map-marker h-univ"></i>Вуз</span>
                    <span><i class="fa fa-map-marker h-dir"></i>Направление</span>
                    <span><i class="fa fa-map-marker h-camp"></i>Общежитие</span>
                </div>
            </div>

            @include(Helper::layout('_history'))

        </div>

        <div class="dir-search-right">

            @if (!@count($events))
            <div class="dir-title">Нет мероприятий</div>
            <div class="dir-amount">Попробуйте изменить условия поиска</div>
            @else
            <div class="dir-title">Все мероприятия</div>
            <div class="dir-amount">
                Найдено
                {{ trans_choice(':count мероприятие|:count мероприятия|:count мероприятий', $count, array(), 'ru') }}
                @if (is_object($speciality))
                в &laquo;{{ $speciality->name }}&raquo;
                @elseif (is_object($university))
                в {{ $university->name }}
                @elseif (is_object($city))
                в г.{{ $city->name }}
                @endif
            </div>
            <div class="search-navbar not_ready">
                <span>Сортировать по:</span>
                <ul class="sort-type unstyled-list">
                    <li>Типу события<i class="fa fa-caret-right fa-rotate-90"></i></li>
                    <li>Дате события<i class="fa fa-caret-right fa-rotate-90"></i></li>
                    <li>Направлению<i class="fa fa-caret-right fa-rotate-90"></i></li>
                </ul>
                <span class="fl-r">
                    <a href="#" class="show-type active"><i class="fa fa-list"></i></a><a href="#" class="show-type"><i class="fa fa-th"></i></a>
                </span>
            </div>
            @endif

            @if (@count($events))
            <ul class="events-ul events-list unstyled-list">

                @foreach ($events as $event)
                <li class="event-li">
                    <div class="event-photo" style="background-image: url({{ $event->get_photo()->thumb() }})"></div>
                    <div class="event-desc">
                        {{ $event->name }}
                        в
                        @if (is_object($event->speciality))
                        <a href="{{ URL::action($CLASS."@getSpeciality", array('speciality_id' => $event->speciality->id)) }}" class="us-link">{{ $event->speciality->name }}</a>
                        @else
                        <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $event->university->id)) }}" class="us-link">{{ $event->university->name }}</a>
                        @endif
                    </div>
                    <div class="event-date">
                        <b>{{ Helper::rdate('j M', $event->date) }}</b>
                    </div>
                    <div class="event-date">
                        <b>
                            {{ Helper::rdate('H:i', $event->time_start) }}
                            @if ($event->time_stop)
                            - {{ Helper::rdate('H:i', $event->time_stop) }}
                            @endif
                        </b>
                    </div>
                    {{--
                    <div class="event-date">
                        <a href="#" class="us-link">ул. ак. Павлова 16</a>
                    </div>
                    --}}
                    <button href="#" class="event-btn not_ready">Записаться</button>
                </li>
                @endforeach

            </ul>
            @endif

        </div>
    </div>
    <div class="clearfix"></div>
    <div class="wrapper">
        <div class="dir-search-left">
            &nbsp;
        </div>
        <div class="dir-search-right">
            <div class="pag-block">
                <div>
                    <span>
                        Найдено
                        {{ trans_choice(':count мероприятие|:count мероприятия|:count мероприятий', $count, array(), 'ru') }}
                        @if (is_object($speciality))
                        в &laquo;{{ $speciality->name }}&raquo;
                                @elseif (is_object($university))
                        в {{ $university->name }}
                        @elseif (is_object($city))
                        в г.{{ $city->name }}
                        @endif
                    </span>
                    <span class="text-sub">
                        Показано {{ $view_first }} — {{ $view_last }}.
                    </span>
                </div>

                {{ $events->links() }}

                <div class="find-out fl-r">
                    <span>Не то, что вы искали?</span> <a href="{{ URL::action($CLASS.'@getEvents') }}">Попробуйте еще раз</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</main>

@stop


@section('scripts')
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA4Q5VgK-858jgeSbJKHbclop_XIJs3lXs&sensor=true">
        </script>
        <script type="text/javascript">

          function initialize() {

            var myLatlng = new google.maps.LatLng(47.2248231, 39.7273844);

            var mapOptions = {
              center: myLatlng,
              zoom: 17,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
            };
            var map = new google.maps.Map(document.getElementById("dir-map"), mapOptions);

            var marker = new google.maps.Marker({
                position: myLatlng,
                icon: 'img/mark-univ.png',
                map: map
            });

          }
          var map = google.maps.event.addDomListener(window, 'load', initialize);

        var univ_fotorama = (function(){
         $('.univ-fotorama').fotorama({
            width: '100%',
            height: '200px',
            nav: 'false',
            fit: 'cover',
            arrows: 'always'
         });
        })();

        </script>
@stop