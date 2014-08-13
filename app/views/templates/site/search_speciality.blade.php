@extends(Helper::layout())



@section('content')

<main class="wrapper-full wrapper-pad">
<div class="wrapper">
<div class="bread">
    <span class="crumb"><a href="/" class="us-link">Главная</a></span>
            <span class="crumb">
                <a href="{{ URL::action($CLASS.'@getSearchSpecialityMore', array(), false) }}" class="us-link">Поиск по направлениям</a>
                <span class="crumb-sub">
                    {{ trans_choice(':count направление|:count направления|:count направлений', $specialities_count, array(), 'ru') }}
                </span>
            </span>
            <span class="crumb">Результаты поиска</a>
</div>

<div class="dir-search-left">

    {{ Form::open(array('action' => $CLASS.'@getSearchSpeciality', 'method' => 'GET')) }}

    <div class="your-search">
        <div class="normal-title">Вы искали</div>
        <div class="normal-text">Направления:</div>
        <ul class="search-items unstyled-list">
            <li class="item">Экономика<a href="#" class="cross">&#10005;</a></li>
            <li class="item">Фотоника<a href="#" class="cross">&#10005;</a></li>
            <li class="item">Менеджмент<a href="#" class="cross">&#10005;</a></li>
            <li class="plus"><i class="fa fa-plus"></i></li>
        </ul>
        <div class="dblock-check">
            {{ Form::checkbox('military_faculty', '1', Input::get('military_faculty')) }} только вузы с военной кафедрой
        </div>
        <div class="dblock-check">
            {{ Form::checkbox('only_state', '1', Input::get('only_state')) }} только государственные вузы
        </div>
        <div class="dblock-check">
            {{ Form::checkbox('only_hostels', '1', Input::get('only_hostels')) }} только с общежитием
        </div>
        <div class="clearfix">
            <button class="us-btn fl-r">Изменить</button>
        </div>
    </div>

    <div class="search-types">
        <div class="normal-title">Критерии</div>

        <div class="type-title">Статус вуза:</div>
        @foreach ( Dictionary::whereSlugValues('university_status')->lists('name', 'id') as $id => $name )
        <div class="dblock-check">
            {{ Form::checkbox('university_status[]', $id, @is_int(array_search($id, Input::get('university_status')))) }}{{ $name }}
        </div>
        @endforeach

        <div class="type-title">Степень при окончании:</div>
        @foreach ( Dictionary::whereSlugValues('speciality_degree') as $value )
        <div class="dblock-check">
            {{ Form::checkbox('degree[]', $value->id, @is_int(array_search($value->id, @Input::get('degree')))) }}{{ $value->name }}
        </div>
        @endforeach

        <div class="type-title">Стоимость обучения:</div>
        <div class="dblock-inp clearfix">
            @foreach (Dictionary::whereSlugValues('tuition_prices') as $value)
            <div class="dblock-check double-block_">
                {{ Form::checkbox('price[]', $value->id, @is_int(array_search($value->id, @Input::get('price')))) }} {{ $value->name }}
            </div>
            @endforeach
        </div>

        <div class="type-title">Вступительные экзамены:</div>
        <div class="dblock-inp clearfix">
            @foreach (Dictionary::whereSlugValues('entrance_exams') as $value)
            <div class="dblock-check double-block pull-left">
                {{ Form::checkbox('entrance_exams[]', $value->id, @is_int(array_search($value->id, @Input::get('entrance_exams')))) }} {{ $value->name }}
            </div>
            @endforeach
        </div>


        <div class="dblock-full padding-r0">
            <div class="type-title">
                Фильтр:
            </div>
            <div>
            {{ Form::checkbox('ignore_rating', '1', Input::get('ignore_rating'), array('id' => 'ignore_rating')) }}
            {{ Form::label('ignore_rating', 'не учитывать оценку при поиске') }}
            </div>
            <div class="grades">

                <div class="grade-item clearfix">
                    <div class="grade-text">Тех. оснащение:</div>
                    <div class="grade-panel grade-panel-search-results">
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

                <div class="grade-item clearfix">
                    <div class="grade-text">Преподавание:</div>
                    <div class="grade-panel grade-panel-search-results">
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

                <div class="grade-item clearfix">
                    <div class="grade-text">Расположение:</div>
                    <div class="grade-panel grade-panel-search-results">
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

                <div class="grade-item clearfix">
                    <div class="grade-text">Спорт:</div>
                    <div class="grade-panel grade-panel-search-results">
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

                <div class="grade-item clearfix">
                    <div class="grade-text">Творчество:</div>
                    <div class="grade-panel grade-panel-search-results">
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

<div class="dir-title">
    Найдено
    {{ trans_choice(':count направление|:count направления|:count направлений', count($specialities), array(), 'ru') }}
    в
    {{ trans_choice(':count вузе|:count вузах|:count вузах', $count_search_universities, array(), 'ru') }}
</div>
<div class="dir-amount">Показано {{ $view_first }} - {{ $view_last }}</div>

<div class="search-navbar not_ready">
    <span>Сортировать по:</span>
    <ul class="sort-type unstyled-list">
        <li>Вступительным баллам<i class="fa fa-caret-right fa-rotate-90"></i></li>
        <li>Стоимость обучения<i class="fa fa-caret-right fa-rotate-90"></i></li>
        <li>Рейтингу<i class="fa fa-caret-right fa-rotate-90"></i>
            <ul class="sort-menu unstyled-list">
                <li>
                    <a href="#" class="sort-link">Общая оценка</a>
                <li>
                    <a href="#" class="sort-link">Техническое обеспечение</a>
                <li>
                    <a href="#" class="sort-link">Качество преподавания</a>
            </ul>
        </li>
    </ul>
    <span class="fl-r">
        <a href="#" class="show-type"><i class="fa fa-list"></i></a><a href="#" class="show-type active"><i class="fa fa-th"></i></a>
    </span>
</div>

<ul class="univ-carts unstyled-list">
@foreach ($specialities as $speciality)
<?
if (!is_object($speciality->university))
    continue;
?>
<li class="univ-cart">
    <div class="univ-photo">
        <div class="univ-fotorama">
            @if (is_object($speciality->university->emblemval))
            <img src="{{ $speciality->university->emblemval->thumb() }}">
            @endif
            {{--<img src="img/test/univ2.jpg">--}}
        </div>
        <div class="univ-rating not_ready">
            <span class="rating">0,0</span>
            <span class="univ-ratdesc">
                <span class="rating-word">отлично</span><br>
                <span class="rating-people">по мнению <a href="#" class="us-link">0 пользователей</a></span>
            </span>
        </div>
    </div>
    <div class="univ-info js-tab-parent">
        <div class="univ-spec"><a href="{{ URL::action($CLASS.'@getSpeciality', array('speciality_id' => $speciality->id)) }}">{{ $speciality->name }}</a></div>
        <div class="univ-name"><a href="{{ URL::action($CLASS.'@getUniversity', array('unversity_id' => $speciality->university->id)) }}">{{ $speciality->university->name }}</a></div>
        @if ($speciality->learning_forms)
        <div class="educ-types"><!--
            @foreach ($speciality->learning_forms as $v => $value)
            --><a href="#" class="js-tab" data-block="{{ $v+1 }}">{{ $value->name->name }}</a><!--
            @endforeach
            -->
        </div>
        @endif
        <div class="not_ready">
            <div class="js-tab-window" data-block="1">
                <div class="info-row">
                    <div class="info-type">Экзамены:</div>
                    <div class="info-text">русский язык<br>математика<br>обществознание</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Проходной балл:</div>
                    <div class="info-text">223 - бюджет<br>116-контракт</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Стоимость:</div>
                    <div class="info-text">118 тыс. руб. в год</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Срок обучения:</div>
                    <div class="info-text">4 год</div>
                </div>
            </div>
            <div class="js-tab-window" data-block="2">
                <div class="info-row">
                    <div class="info-type">Экзамены:</div>
                    <div class="info-text">французский язык<br>русский язык<br>обществознание</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Проходной балл:</div>
                    <div class="info-text">550 - бюджет<br>351-контракт</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Стоимость:</div>
                    <div class="info-text">118 тыс. руб. в год</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Срок обучения:</div>
                    <div class="info-text">4 год</div>
                </div>
            </div>
            <div class="js-tab-window" data-block="3">
                <div class="info-row">
                    <div class="info-type">Экзамены:</div>
                    <div class="info-text">русский язык<br>математика<br>обществознание</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Проходной балл:</div>
                    <div class="info-text">223 - бюджет<br>116-контракт</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Стоимость:</div>
                    <div class="info-text">118 тыс. руб. в год</div>
                </div>
                <div class="info-row">
                    <div class="info-type">Срок обучения:</div>
                    <div class="info-text">4 год</div>
                </div>
            </div>
        </div>
        <button class="us-btn not_ready">Сохранить</button>
    </div>
</li>
@endforeach

@if (0)
<li class="univ-cart">
    <div class="univ-photo">
        <div class="univ-fotorama">
            <img src="img/test/univ1.jpg">
            <img src="img/test/univ2.jpg">
        </div>
        <div class="univ-rating">
            <span class="rating">8,3</span>
                                    <span class="univ-ratdesc">
                                        <span class="rating-word">отлично</span><br>
                                        <span class="rating-people">по мнению <a href="#" class="us-link">69
                                                пользователей</a></span>
                                    </span>
        </div>
    </div>
    <div class="univ-info js-tab-parent">
        <div class="univ-spec">Маркетинг и пиар</div>
        <div class="univ-name">СПбГУ</div>
        <div class="educ-types">
            <a href="#" class="js-tab" data-block="1">Очное</a><!--
                                 --><a href="#" class="js-tab" data-block="2">Заочное</a><!--
                                 --><a href="#" class="js-tab" data-block="3">Вечернее</a>
        </div>
        <div class="js-tab-window" data-block="1">
            <div class="info-row">
                <div class="info-type">Экзамены:</div>
                <div class="info-text">русский язык<br>математика<br>обществознание</div>
            </div>
            <div class="info-row">
                <div class="info-type">Проходной балл:</div>
                <div class="info-text">223 - бюджет<br>116-контракт</div>
            </div>
            <div class="info-row">
                <div class="info-type">Стоимость:</div>
                <div class="info-text">118 тыс. руб. в год</div>
            </div>
            <div class="info-row">
                <div class="info-type">Срок обучения:</div>
                <div class="info-text">4 год</div>
            </div>
        </div>
        <div class="js-tab-window" data-block="2">
            <div class="info-row">
                <div class="info-type">Экзамены:</div>
                <div class="info-text">армянский язык<br>русский язык<br>обществознание</div>
            </div>
            <div class="info-row">
                <div class="info-type">Проходной балл:</div>
                <div class="info-text">550 - бюджет<br>351-контракт</div>
            </div>
            <div class="info-row">
                <div class="info-type">Стоимость:</div>
                <div class="info-text">118 тыс. руб. в год</div>
            </div>
            <div class="info-row">
                <div class="info-type">Срок обучения:</div>
                <div class="info-text">4 год</div>
            </div>
        </div>
        <div class="js-tab-window" data-block="3">
            <div class="info-row">
                <div class="info-type">Экзамены:</div>
                <div class="info-text">русский язык<br>математика<br>обществознание</div>
            </div>
            <div class="info-row">
                <div class="info-type">Проходной балл:</div>
                <div class="info-text">223 - бюджет<br>116-контракт</div>
            </div>
            <div class="info-row">
                <div class="info-type">Стоимость:</div>
                <div class="info-text">118 тыс. руб. в год</div>
            </div>
            <div class="info-row">
                <div class="info-type">Срок обучения:</div>
                <div class="info-text">4 год</div>
            </div>
        </div>
        <button class="us-btn">Сохранить</button>
    </div>
</li>
<li class="univ-cart">
    <div class="univ-photo">
        <div class="univ-fotorama">
            <img src="img/test/univ1.jpg">
            <img src="img/test/univ2.jpg">
        </div>
        <div class="univ-rating">
            <span class="rating">8,3</span>
                                    <span class="univ-ratdesc">
                                        <span class="rating-word">отлично</span><br>
                                        <span class="rating-people">по мнению <a href="#" class="us-link">69
                                                пользователей</a></span>
                                    </span>
        </div>
    </div>
    <div class="univ-info js-tab-parent">
        <div class="univ-spec">Маркетинг и пиар</div>
        <div class="univ-name">СПбГУ</div>
        <div class="educ-types">
            <a href="#" class="js-tab" data-block="1">Очное</a><!--
                                 --><a href="#" class="js-tab" data-block="2">Заочное</a><!--
                                 --><a href="#" class="js-tab" data-block="3">Вечернее</a>
        </div>
        <div class="js-tab-window" data-block="1">
            <div class="info-row">
                <div class="info-type">Экзамены:</div>
                <div class="info-text">русский язык<br>математика<br>обществознание</div>
            </div>
            <div class="info-row">
                <div class="info-type">Проходной балл:</div>
                <div class="info-text">223 - бюджет<br>116-контракт</div>
            </div>
            <div class="info-row">
                <div class="info-type">Стоимость:</div>
                <div class="info-text">118 тыс. руб. в год</div>
            </div>
            <div class="info-row">
                <div class="info-type">Срок обучения:</div>
                <div class="info-text">4 год</div>
            </div>
        </div>
        <div class="js-tab-window" data-block="2">
            <div class="info-row">
                <div class="info-type">Экзамены:</div>
                <div class="info-text">армянский язык<br>русский язык<br>обществознание</div>
            </div>
            <div class="info-row">
                <div class="info-type">Проходной балл:</div>
                <div class="info-text">550 - бюджет<br>351-контракт</div>
            </div>
            <div class="info-row">
                <div class="info-type">Стоимость:</div>
                <div class="info-text">118 тыс. руб. в год</div>
            </div>
            <div class="info-row">
                <div class="info-type">Срок обучения:</div>
                <div class="info-text">4 год</div>
            </div>
        </div>
        <div class="js-tab-window" data-block="3">
            <div class="info-row">
                <div class="info-type">Экзамены:</div>
                <div class="info-text">русский язык<br>математика<br>обществознание</div>
            </div>
            <div class="info-row">
                <div class="info-type">Проходной балл:</div>
                <div class="info-text">223 - бюджет<br>116-контракт</div>
            </div>
            <div class="info-row">
                <div class="info-type">Стоимость:</div>
                <div class="info-text">118 тыс. руб. в год</div>
            </div>
            <div class="info-row">
                <div class="info-type">Срок обучения:</div>
                <div class="info-text">4 год</div>
            </div>
        </div>
        <button class="us-btn">Сохранить</button>
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
                <span>Всего найдено 48 направлений в Санкт-Петербурге.</span> <span
                    class="text-sub">Показано 1 — 20.</span>
            </div>
            <ul class="pagination unstyled-list">
                <li><a href="#">«</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">»</a></li>
            </ul>
            <div class="find-out fl-r">
                <span>Не то, что вы искали?</span> <a href="#">Попробуйте еще раз</a>
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
                  var map = new google.maps.Map(document.getElementById("dir-map"),
                      mapOptions);



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