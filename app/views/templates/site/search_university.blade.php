@extends(Helper::layout())

@section('content')

        <main class="wrapper-full wrapper-pad">

            <div class="wrapper">

                <div class="bread">
                    <span class="crumb"><a href="/" class="us-link">Главная</a></span>
                    <span class="crumb">Результаты поиска</a>
                </div>


                <div class="dir-search-left">

                    {{ Form::open(array('action' => $CLASS.'@getSearchUniversity', 'method' => 'GET')) }}

                    <div class="your-search">
                        <div class="normal-title">Вы искали вузы</div>

                        <div class="dblock-inp">
                            <div class="dblock-text">Город:</div>
                            {{ Form::select('city', array('без разницы') + Dictionary::whereSlugValues('cities')->lists('name', 'id'), Input::get('city'), array('class' => 'main-select w100')) }}
                        </div>
                        <div class="dblock-inp">
                            <div class="dblock-text">Тип вуза:</div>
                            {{ Form::select('type', array('без разницы') + Dictionary::whereSlugValues('university_type')->lists('name', 'id'), Input::get('type'), array('class' => 'main-select w100')) }}
                        </div>
                        <div class="dblock-inp">
                            <div class="dblock-text">Статус вуза:</div>
                            {{ Form::select('status', array('без разницы') + Dictionary::whereSlugValues('university_status')->lists('name', 'id'), Input::get('status'), array('class' => 'main-select w100')) }}
                        </div>

                        <div class="normal-text">Профиль вуза:</div>
                        <ul class="search-items unstyled-list clearfix" style="white-space:nowrap">
                            @foreach ($university_profile_all as $profile)
                            <div class="dblock-check double-block pull-left">
                                {{ Form::checkbox('profiles[]', $profile->id, in_array($profile->id, $university_profile)) }}{{ $profile->name }}
                            </div>
                            @endforeach
                        </ul>

                        {{--
                        <ul class="search-items unstyled-list">
                            <li class="item">Экономика<a href="#" class="cross">&#10005;</a></li>
                            <li class="item">Фотоника<a href="#" class="cross">&#10005;</a></li>
                            <li class="item">Менеджмент<a href="#" class="cross">&#10005;</a></li>
                            <li class="plus"><i class="fa fa-plus"></i></li>
                        </ul>
                        --}}

                        <div class="dblock-full">
                            <button class="us-btn fl-r">Найти</button>
                            <div class="clearfix"></div>
                        </div>

                    </div>

                    <div class="search-types">
                        <div class="normal-title">Фильтр</div>
                        {{--<div class="type-title">Статус вуза:</div>--}}

                        <div class="dblock-check">
                            {{ Form::checkbox('military_faculty', '1', Input::get('military_faculty')) }} наличие военной кафедры
                        </div>
                        <div class="dblock-check">
                            {{ Form::checkbox('hostel_exists', '1', Input::get('hostel_exists')) }} предоставляется общежитие
                        </div>
                        <div class="dblock-check">
                            {{ Form::checkbox('target_places', '1', Input::get('target_places')) }} наличие целевых мест
                        </div>
                        <div class="dblock-check">
                            {{ Form::checkbox('olympics_admission', '1', Input::get('olympics_admission')) }} поступление по олимпиадам
                        </div>

                        <div class="ratings">

                            <div class="grade-item clearfix">
                                <div class="grade-text">Тех. оснащение:</div>
                                <div class="grade-panel">
                                    {{ Form::text('rating1', $slider_default, array(
                                    'class' => 'slider slider-primary',
                                    'data-slider-min' => "1",
                                    'data-slider-max' => "10",
                                    'data-slider-value' => Input::get('rating1') ? Input::get('rating1') : $slider_default,
                                    'data-slider-selection' => "before",
                                    'data-slider-handle' => "round",
                                    )) }}
                                </div>
                                <div class="grades">
                                    <span class="fl-l">плохо</span>
                                    <span class="fl-r">отлично</span>
                                </div>
                            </div>

                            <div class="grade-item clearfix">
                                <div class="grade-text">Преподавание:</div>
                                <div class="grade-panel">
                                    {{ Form::text('rating2', $slider_default, array(
                                    'class' => 'slider slider-primary',
                                    'data-slider-min' => "1",
                                    'data-slider-max' => "10",
                                    'data-slider-value' => Input::get('rating2') ? Input::get('rating2') : $slider_default,
                                    'data-slider-selection' => "before",
                                    'data-slider-handle' => "round",
                                    )) }}
                                </div>
                                <div class="grades">
                                    <span class="fl-l">плохо</span>
                                    <span class="fl-r">отлично</span>
                                </div>
                            </div>

                            <div class="grade-item clearfix">
                                <div class="grade-text">Расположение:</div>
                                <div class="grade-panel">
                                    {{ Form::text('rating3', $slider_default, array(
                                    'class' => 'slider slider-primary',
                                    'data-slider-min' => "1",
                                    'data-slider-max' => "10",
                                    'data-slider-value' => Input::get('rating3') ? Input::get('rating3') : $slider_default,
                                    'data-slider-selection' => "before",
                                    'data-slider-handle' => "round",
                                    )) }}
                                </div>
                                <div class="grades">
                                    <span class="fl-l">плохо</span>
                                    <span class="fl-r">отлично</span>
                                </div>
                            </div>

                            <div class="grade-item clearfix">
                                <div class="grade-text">Спорт:</div>
                                <div class="grade-panel">
                                    {{ Form::text('rating4', $slider_default, array(
                                    'class' => 'slider slider-primary',
                                    'data-slider-min' => "1",
                                    'data-slider-max' => "10",
                                    'data-slider-value' => Input::get('rating4') ? Input::get('rating4') : $slider_default,
                                    'data-slider-selection' => "before",
                                    'data-slider-handle' => "round",
                                    )) }}
                                </div>
                                <div class="grades">
                                    <span class="fl-l">плохо</span>
                                    <span class="fl-r">отлично</span>
                                </div>
                            </div>

                            <div class="grade-item clearfix">
                                <div class="grade-text">Творчество:</div>
                                <div class="grade-panel">
                                    {{ Form::text('rating5', $slider_default, array(
                                    'class' => 'slider slider-primary',
                                    'data-slider-min' => "1",
                                    'data-slider-max' => "10",
                                    'data-slider-value' => Input::get('rating5') ? Input::get('rating5') : $slider_default,
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

                    {{ Form::close() }}

                    <div class="dir-map min-map">
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

                    @if ($count)
                    <div class="dir-title">
                        {{ trans_choice('Найден :count вуз|Найдено :count вуза|Найдено :count вузов', $count, array(), 'ru') }}
                    </div>
                    <div class="dir-amount">Показано {{ $view_first }} - {{ $view_last }}</div>
                    @else
                    <div class="dir-title">
                        Подходящих вузов не найдено :(
                    </div>
                    <div>
                        Попробуйте изменить условия поиска в левой панели
                    </div>
                    @endif

                    @if ($count)
                    <div class="search-navbar not_ready">
                        <span>Сортировать по:</span>
                        <ul class="sort-type unstyled-list">
                            <li>
                                <span class="sort-btn">
                                    Вступительным баллам<i class="fa fa-caret-right fa-rotate-90"></i>
                                </span>
                            <li>
                                <span class="sort-btn">
                                    Стоимость обучения<i class="fa fa-caret-right fa-rotate-90"></i>
                                </span>
                            <li>
                                <span class="sort-btn">
                                    Рейтингу<i class="fa fa-caret-right fa-rotate-90"></i>
                                </span>
                                <ul class="sort-menu unstyled-list">
                                    <li>
                                        <a href="#" class="sort-link">Общая оценка</a>
                                    <li>
                                        <a href="#" class="sort-link">Техническое обеспечение</a>
                                    <li>
                                        <a href="#" class="sort-link">Качество преподавания</a>
                                </ul>

                        </ul>
                        <span class="fl-r">
                            <a href="#" class="show-type active"><i class="fa fa-list"></i></a><!--
                         --><a href="#" class="show-type"><i class="fa fa-th"></i></a>
                        </span>
                    </div>
                    @endif

                    <ul class="univ-ul unstyled-list">

                        @foreach ($universities as $university)
                        <li class="univ-list">
                            <div class="univ-photo">
                                <div class="univ-img" style="background-image: url({{ $university->get_emblem()->thumb() }});"></div>
                            </div><!--
                            --><div class="univ-info">
                                <div class="title">
                                    <span class="name"><a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $university->id)) }}" class="us-link">{{ $university->name }}</a></span>
                                    (<a href="#" class="us-link not_ready">посмотреть на карте</a>)
                                </div>
                                <div class="desc">
                                    <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $university->id)) }}" class="us-link">{{ $university->fullname }}</a>
                                </div>
                                <div class="univ-prof">
                                    Профиль вуза: {{ DicVal::whereId($university->profile)->name }}
                                </div>

                                <div class="univ-feedb not_ready">
                                    <div>Студент <a href="#" class="us-link js-user-tooltip">Иван Петров</a> написал вчера:</div>
                                    <div class="feedb-text">
                                        Умысел установлен обычаями делового оборота. В специальных нормах, посвященных данному вопросу, указывается...
                                    </div>
                                    <a href="#" class="us-link all-feedb">Все отзывы</a>
                                </div>

                                <div class="univ-stat">
                                    <ul class="univ-statb unstyled-list">
                                        <li class="univ-stat-li">
                                            <span>Студентов:</span><span>{{ $university->count_students }}</span>
                                        <li class="univ-stat-li">
                                            <span>Направлений и профилей:</span><span>{{ $university->count_specialities }}</span>
                                        <li class="univ-stat-li">
                                            <span>Факультетов и корпусов:</span><span>{{ $university->count_faculties }}</span>
                                    </ul><!--
                                    --><ul class="univ-statb unstyled-list">
                                        <li class="univ-stat-li">
                                            <span>Целевые места:</span><span>{{ $university->target_places ? 'есть' : 'нет' }}</span>
                                        <li class="univ-stat-li">
                                            <span>Поступление по олимп.:</span><span>{{ $university->olympics_admission ? 'есть' : 'нет' }}</span>
                                    </ul>
                                </div>
                            </div><!--
                            --><div class="univ-nav not_ready">
                                <div class="dir-rating">
                                    <ul class="unstyled-list rating-ul">
                                        <li><i class="fa fa-star"></i>
                                        <li><i class="fa fa-star"></i>
                                        <li><i class="fa fa-star"></i>
                                        <li><i class="fa fa-star-half-o"></i>
                                        <li><i class="fa fa-star-o"></i>
                                    </ul>
                                    <div class="dir-rat-info">
                                        <span class="rating">0,0</span> <span class="rating-word">отлично</span>
                                        <div class="rating-text">
                                            общая оценка<br>по мнению<br><a href="#" class="us-link">69 пользователей</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="save-block">
                                    <a href="#" class="us-lbtn">Сохранить</a>
                                    <div class="desc">
                                        0 пользователей уже сохранили этот вуз в своем личном кабинете
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach

                        @if (0)
                        <li class="univ-list">
                            <div class="univ-photo">
                                <div class="univ-img" style="background-image: url(img/test/univ1.jpg);"></div>
                            </div><!--
                            --><div class="univ-info">
                                <div class="title">
                                    <span class="name"><a href="#" class="us-link">СПбГУ</a></span>
                                    (<a href="#" class="us-link">посмотреть на карте</a>)
                                </div>
                                <div class="desc">
                                    <a href="#" class="us-link">Санкт-Петербургский государственный университет</a>
                                </div>
                                <div class="univ-prof">
                                    Профиль вуза: технический, военный.
                                </div>
                                <div class="univ-feedb">
                                    <div>Студент <a href="#" class="us-link js-user-tooltip">Иван Петров</a> написал вчера:</div>
                                    <div class="feedb-text">
                                        Умысел установлен обычаями делового оборота. В специальных нормах, посвященных данному вопросу, указывается...
                                    </div>
                                    <a href="#" class="us-link all-feedb">Все отзывы</a>
                                </div>
                                <div class="univ-stat">
                                    <ul class="univ-statb unstyled-list">
                                        <li class="univ-stat-li">
                                            <span>Студентов:</span><span>25 000</span>
                                        <li class="univ-stat-li">
                                            <span>Направлений и профилей:</span><span>72</span>
                                        <li class="univ-stat-li">
                                            <span>Факультетов и корпусов:</span><span>46</span>
                                    </ul><!--
                                 --><ul class="univ-statb unstyled-list">
                                        <li class="univ-stat-li">
                                            <span>Целевые места:</span><span>есть</span>
                                        <li class="univ-stat-li">
                                            <span>Собственные олимпиады:</span><span>есть</span>
                                    </ul>
                                </div>
                            </div><!--
                            --><div class="univ-nav">
                                <div class="dir-rating">
                                    <ul class="unstyled-list rating-ul">
                                        <li><i class="fa fa-star"></i>
                                        <li><i class="fa fa-star"></i>
                                        <li><i class="fa fa-star"></i>
                                        <li><i class="fa fa-star-half-o"></i>
                                        <li><i class="fa fa-star-o"></i>
                                    </ul>
                                    <div class="dir-rat-info">
                                        <span class="rating">8,3</span> <span class="rating-word">отлично</span>
                                        <div class="rating-text">
                                            общая оценка<br>по мнению<br><a href="#" class="us-link">69 пользователей</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="save-block">
                                    <a href="#" class="us-lbtn">Сохранить</a>
                                    <div class="desc">
                                        270 пользователей уже сохранили этот вуз в своем личном кабинете
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif


                    </ul>

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

                            @if ($count)
                            <span>
                                {{ trans_choice('Найден :count вуз|Всего найдено :count вуза|Всего найдено :count вузов', $count, array(), 'ru') }}.
                            </span>
                            <span class="text-sub">Показано {{ $view_first }} - {{ $view_last }}.</span>
                            @endif

                        </div>

                        {{ $universities->links() }}

                        {{--
                        <ul class="pagination unstyled-list">
                            <li><a href="#">«</a></li><li class="active"><a href="#">1</a></li><li><a href="#">2</a></li><li><a href="#">3</a></li><li><a href="#">4</a></li><li><a href="#">»</a></li>
                        </ul>
                        --}}
                        <div class="find-out fl-r">
                            <span>Не то, что вы искали?</span> <a href="{{ URL::action($CLASS.'@getSearchUniversityMore') }}">Попробуйте еще раз</a>
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