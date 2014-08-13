@extends(Helper::layout())



@section('style')
    <link rel="stylesheet" href="/css/jquery.custom-scrollbar.css">
@stop



@section('content')

        <main class="wrapper-full wrapper-pad">
            <div class="wrapper">

                <div class="bread">
                    <span class="crumb"><a href="/" class="us-link">Главная</a></span>
                    <span class="crumb">Расширенный поиск направлений в вузах</a>
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

                {{ Form::open(array('action' => $CLASS.'@getSearchSpeciality', 'method' => 'GET')) }}

                <div class="dir-search-right">
                    <div class="dir-title">Расширенный поиск направлений в вузах</div>
                    <div class="dir-amount">
                        {{ trans_choice('по :count вузу|по :count вузам|по :count вузам', $universities_count, array(), 'ru') }}
                    </div>
                    <div class="dir-block">
                        <div class="dblock">
                            <div class="dblock-inp">
                                <div class="dblock-text">Город:</div>
                                {{ Form::select('city', array('без разницы') + Dictionary::whereSlugValues('cities')->lists('name', 'id'), null, array('class' => 'main-select w70')) }}
                            </div>
                            <div class="dblock-inp">
                                <div class="dblock-text">Статус вуза:</div>
                                {{ Form::select('university_status', array('без разницы') + Dictionary::whereSlugValues('university_status')->lists('name', 'id'), null, array('class' => 'main-select w70')) }}
                            </div>
                            <div class="dblock-inp">
                                <div class="dblock-text">Форма обучения:</div>
                                {{ Form::select('learning_form', array('без разницы') + Dictionary::whereSlugValues('learning_forms')->lists('name', 'id'), null, array('class' => 'main-select w70')) }}
                            </div>

                            <div class="dblock-inp">
                                <div class="dblock-check">
                                    {{ Form::checkbox('military_faculty', '1') }} только вузы с военной кафедрой
                                </div>
                                <div class="dblock-check">
                                    {{ Form::checkbox('only_state', '1') }} только государственные вузы
                                </div>
                                <div class="dblock-check">
                                    {{ Form::checkbox('only_hostels', '1') }} только с общежитием
                                </div>
                            </div>

                            <div class="dblock-hr"></div>

                            <div class="">
                                <div class="dblock-inp">
                                    <div class="dblock-text">Оплата обучения:</div>
                                    {{ Form::select('tuition', array('бесплатное', 'pay' => 'платное'), null, array('class' => 'main-select w70 price_select')) }}
                                </div>
                                <div class="dblock-inp pay_block display_none">
                                    @foreach (Dictionary::whereSlugValues('tuition_prices') as $price)
                                    <div class="dblock-check double-block">
                                        {{ Form::checkbox('price[]', $price->id) }} {{ $price->name }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="dblock-hr"></div>

                            <div class="dblock-inp">
                                <div class="dblock-text">Степень при окончании:</div>
                                {{ Form::select('degree', array('не имеет значения') + Dictionary::whereSlugValues('speciality_degree')->lists('name', 'id'), null, array('class' => 'main-select w70')) }}
                            </div>

                            <div class="dblock-hr"></div>

                            <div class="dblock-inp">
                                <div class="dblock-text">Дополнительные критерии:</div>
                                <div class="dblock-check">
                                    {{ Form::checkbox('target_places', '1') }}
                                    только с наличием целевых мест
                                </div>
                                <div class="dblock-check">
                                    {{ Form::checkbox('accepted_olympics', '1') }}
                                    только с возможностью поступления по олимпиадам
                                </div>
                            </div>

                        </div>

                        <div class="dblock">
                            <div class="dblock-inp">

                                <div class="dblock-text w500">Направления</div>
                                <div class="dblock-check margin-b20">
                                    {{ Form::checkbox('only_accredited', '1') }}
                                    искать только в аккредитованных направления
                                </div>

                                <ul class="checks-block unstyled-list">

                                    @foreach ($specialities as $cat_name => $spec_cat)
                                    <li class="check-parent s-check">
                                        <div class="check-main">
                                            <input type="checkbox"><i class="fa fa-caret-right"></i>{{ $cat_name }}
                                        </div>
                                        <ul class="checks-in unstyled-list">
                                        @foreach ($spec_cat as $id => $name)
                                            <li class="check-item s-check">
                                                {{ Form::checkbox('spec[]', $id) }}
                                                {{ $name }}
                                            </li>
                                        @endforeach
                                        </ul>
                                    </li>
                                    @endforeach

                                    @if (0)
                                    <li class="check-parent s-check">
                                        <div class="check-main">
                                            <input type="checkbox"><i class="fa fa-caret-right"></i>информационная безопасность
                                        </div>
                                        <ul class="checks-in unstyled-list">
                                            <li class="check-item s-check">
                                                <input type="checkbox">криптография
                                            </li>
                                            <li class="check-item s-check">
                                                <input type="checkbox">компьютерная безопасность
                                            </li>
                                            <li class="check-item s-check">
                                                <input type="checkbox">информационная безопасность
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="check-parent s-check">
                                        <div class="check-main">
                                            <input type="checkbox"><i class="fa fa-caret-right"></i>сервис
                                        </div>
                                        <ul class="checks-in unstyled-list">
                                            <li class="check-item s-check">
                                                <input type="checkbox">сервис
                                            </li>
                                            <li class="check-item s-check">
                                                <input type="checkbox">социально-культурный сервис
                                            </li>
                                            <li class="check-item s-check">
                                                <input type="checkbox">туризм
                                            </li>
                                        </ul>
                                    </li>
                                    @endif

                                </ul>

                            </div>
                        </div>

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

                    </div>
                </div>

                {{ Form::close() }}

            </div>
            <div class="clearfix">
        </main>

@stop



@section('scripts')
        <script src="/js/vendor/jquery.custom-scrollbar.js"></script>

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

          $('.checks-block').customScrollbar();

          $('.price_select').change(function(){
            if ($(this).val() == 'pay')
                $('.pay_block').slideDown();
            else
                $('.pay_block').slideUp();
        });

        </script>
@stop