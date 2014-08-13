@extends(Helper::layout())


@section('style')

@stop


@section('content')

<main class="wrapper-full wrapper-pad">
    <div class="wrapper">

        <div class="bread">
            <span class="crumb"><a href="/" class="us-link">Главная</a></span>
            <span class="crumb">Расширенный поиск ВУЗа</a>
        </div>

        <div class="dir-search-left">
            <div class="dir-map">
                <div class="title not_ready">Поиск по карте</div>
                <div id="dir-map"></div>
                <div class="dir-hints">
                    <span><i class="fa fa-map-marker h-univ"></i>Вуз</span>
                    <span><i class="fa fa-map-marker h-dir"></i>Направление</span>
                    <span><i class="fa fa-map-marker h-camp"></i>Общежитие</span>
                </div>
            </div>
        </div>

        <div class="dir-search-right">

            <div class="dir-title">Расширенный поиск вуза</div>

            <div class="dir-amount">
                среди {{ $universities_count }}
                {{ trans_choice('[1,1] вуза|[2,Inf] вузов', $universities_count) }}
            </div>
            <div class="dir-block">

                {{ Form::open(array('action' => $CLASS.'@getSearchUniversity', 'method' => 'GET')) }}

                <div class="dblock three-block padding-b15">
                    <div class="dblock-inp">
                        <div class="dblock-text">Город:</div>
                        {{ Form::select('city', array('без разницы') + Dictionary::whereSlugValues('cities')->lists('name', 'id'), null, array('class' => 'main-select w100')) }}
                    </div>
                    <div class="dblock-inp">
                        <div class="dblock-text">Тип вуза:</div>
                        {{ Form::select('type', array('без разницы') + Dictionary::whereSlugValues('university_type')->lists('name', 'id'), null, array('class' => 'main-select w100')) }}
                    </div>
                    <div class="dblock-inp">
                        <div class="dblock-text">Статус вуза:</div>
                        {{ Form::select('status', array('без разницы') + Dictionary::whereSlugValues('university_status')->lists('name', 'id'), null, array('class' => 'main-select w100')) }}
                    </div>
                </div><!--

                --><div class="dblock three-block padding-b15">
                    <div class="dblock-inp">
                        <div class="dblock-text w500">Дополнительные критерии:</div>

                        <div class="dblock-check">
                            {{ Form::checkbox('military_faculty', '1') }} наличие военной кафедры
                        </div>
                        <div class="dblock-check">
                            {{ Form::checkbox('hostel_exists', '1') }} предоставляется общежитие
                        </div>
                        <div class="dblock-check">
                            {{ Form::checkbox('target_places', '1') }} наличие целевых мест
                        </div>
                        <div class="dblock-check">
                            {{ Form::checkbox('olympics_admission', '1') }} поступление по олимпиадам
                        </div>

                    </div>
                </div><!--

                @if (@count($university_profile))
                --><div class="dblock three-block padding-b15">
                    <div class="dblock-inp">
                        <div class="dblock-text w500">Специализация (профиль) вуза:</div>
                        <div class="double-block1">

                            {{--
                            <div class="dblock-check">
                                <input type="checkbox"> все вузы
                            </div>
                            --}}

                            @foreach ($university_profile as $profile)
                            <div class="dblock-check double-block pull-left">
                                {{ Form::checkbox('profiles[]', $profile->id) }} {{ $profile->name }}
                            </div>
                            @endforeach

                            <div class="clearfix"></div>

                        </div>
                    </div>
                </div>
                @endif

                <div class="clearfix"></div>

                <div class="dblock-full padding-r0">
                    <div class="title">
                        Фильтр:
                        {{ Form::checkbox('ignore_rating', '1', null, array('id' => 'ignore_rating')) }}
                        {{ Form::label('ignore_rating', 'не учитывать оценку при поиске') }}
                    </div>
                    <div class="grades">

                        <div class="grade-item">
                            <div class="grade-text">Тех. оснащение:</div>
                            <div class="grade-panel">
                                {{ Form::text('rating1', $slider_default, array(
                                'class' => 'slider slider-primary',
                                'data-slider-min' => "1",
                                'data-slider-max' => "10",
                                'data-slider-value' => $slider_default,
                                'data-slider-selection' => "before",
                                'data-slider-handle' => "round",
                                )) }}
                            </div>
                            <div class="grades">
                                <span class="fl-l">плохо</span>
                                <span class="fl-r">отлично</span>
                            </div>
                        </div>

                        <div class="grade-item">
                            <div class="grade-text">Преподавание:</div>
                            <div class="grade-panel">
                                {{ Form::text('rating2', $slider_default, array(
                                'class' => 'slider slider-primary',
                                'data-slider-min' => "1",
                                'data-slider-max' => "10",
                                'data-slider-value' => $slider_default,
                                'data-slider-selection' => "before",
                                'data-slider-handle' => "round",
                                )) }}
                            </div>
                            <div class="grades">
                                <span class="fl-l">плохо</span>
                                <span class="fl-r">отлично</span>
                            </div>
                        </div>

                        <div class="grade-item">
                            <div class="grade-text">Расположение:</div>
                            <div class="grade-panel">
                                {{ Form::text('rating3', $slider_default, array(
                                'class' => 'slider slider-primary',
                                'data-slider-min' => "1",
                                'data-slider-max' => "10",
                                'data-slider-value' => $slider_default,
                                'data-slider-selection' => "before",
                                'data-slider-handle' => "round",
                                )) }}
                            </div>
                            <div class="grades">
                                <span class="fl-l">плохо</span>
                                <span class="fl-r">отлично</span>
                            </div>
                        </div>

                        <div class="grade-item">
                            <div class="grade-text">Спорт:</div>
                            <div class="grade-panel">
                                {{ Form::text('rating4', $slider_default, array(
                                'class' => 'slider slider-primary',
                                'data-slider-min' => "1",
                                'data-slider-max' => "10",
                                'data-slider-value' => $slider_default,
                                'data-slider-selection' => "before",
                                'data-slider-handle' => "round",
                                )) }}
                            </div>
                            <div class="grades">
                                <span class="fl-l">плохо</span>
                                <span class="fl-r">отлично</span>
                            </div>
                        </div>

                        <div class="grade-item">
                            <div class="grade-text">Творчество:</div>
                            <div class="grade-panel">
                                {{ Form::text('rating5', $slider_default, array(
                                'class' => 'slider slider-primary',
                                'data-slider-min' => "1",
                                'data-slider-max' => "10",
                                'data-slider-value' => $slider_default,
                                'data-slider-selection' => "before",
                                'data-slider-handle' => "round",
                                )) }}
                            </div>
                            <div class="grades">
                                <span class="fl-l">плохо</span>
                                <span class="fl-r">отлично</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="dblock-full">
                    <button class="us-btn fl-r">Найти</button>
                    <div class="clearfix"></div>
                </div>

                {{ Form::close() }}

            </div>
        </div>

    </div>

    <div class="clearfix">

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
        </script>
@stop