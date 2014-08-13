@extends(Helper::layout())


@section('style')
@stop


@section('content')

    <main class="wrapper-full">
    <div class="main-block">
        <div class="main-block-in">
            <div class="wrapper">
                <div class="main-forms">

                    <div class="main-form">

                        {{ Form::open(array('action' => $CLASS.'@getSearchUniversity', 'method' => 'GET', 'id' => 'university-form')) }}

                            <div class="title">Определились с вузом?</div>
                            <div class="desc">Узнайте о нем больше</div>
                            <div class="select-title">Название вуза:</div>
                            {{--
                            <select class="main-select">
                                <option>СПбГУКИ</option>
                            </select>
                            --}}
                            {{ Form::select('university', array('Все ВУЗы') + $universities->lists('name', 'id'), null, array('class' => 'main-select university-select')) }}
                            <div class="select-title">Направление:</div>
                            <select name="speciality" class="main-select speciality-select" data-placeholder="Все направления">
                                <option selected="selected" value="0">Все направления</option>
                            </select>
                            <div class="select-desc">Например <a href="#" class="select-link">экономика</a></div>
                            <div class="btn-cont">
                                <a href="{{ URL::action($CLASS.'@getSearchUniversityMore') }}" class="search-link">Расширенный поиск</a>
                                <button type="submit" class="us-btn">Найти</button>
                            </div>

                        {{ Form::close() }}

                    </div>

                    <div class="main-form">

                        {{ Form::open(array('action' => $CLASS.'@getSearchSpeciality', 'method' => 'GET', 'id' => 'speciality-form')) }}

                            <div class="title">Поиск по направлениям</div>
                            <div class="desc">Среди 86 вузов Санкт-Петербурга.</div>
                            <div class="select-title">Направление:</div>
                            {{--
                            <select class="main-select">
                                <option>Например, экономика</option>
                            </select>
                            --}}
                            {{ Form::select('speciality', array('Все направления') + $specialities->lists('name', 'id'), null, array('class' => 'main-select speciality-select-2')) }}
                            <div class="text">
                                <input type="checkbox" name="conditions[]" value="caf" class="speciality-checkbox" id="caf"> <label for="caf">только вузы с военной кафедрой</label>
                            </div>
                            <div class="text">
                                <input type="checkbox" name="conditions[]" value="gov" class="speciality-checkbox" id="gov"> <label for="gov">только государственные вузы</label>
                            </div>
                            <div class="text">
                                <input type="checkbox" name="conditions[]" value="ap" class="speciality-checkbox" id="ap"> <label for="ap">только с общежитием</label>
                            </div>
                            <div class="btn-cont">
                                <a href="{{ URL::action($CLASS.'@getSearchSpecialityMore') }}" class="search-link">Расширенный поиск</a>
                                <button class="us-btn">Найти</button>
                            </div>

                        {{ Form::close() }}

                    </div>

                    <div class="main-form">

                        {{ Form::open(array('action' => $CLASS.'@getCalculator', 'method' => 'GET', 'id' => 'calculator-form')) }}

                            <div class="title">Калькулятор ЕГЭ</div>
                            <div class="desc">Узнайте вуз, в котором вы можете учиться.</div>
                            <ul class="main-subjs unstyled-list">
                                <li class="subj">
                                    <div class="subj-title">Рус. яз.:</div>
                                    <div class="subj-input">
                                        <input type="text" name="rus" value="" maxlength="3">
                                    </div>
                                </li>
                                <li class="subj">
                                    <div class="subj-title">Математика:</div>
                                    <div class="subj-input">
                                        <input type="text" name="mat" value="" maxlength="3">
                                    </div>
                                </li>
                                <li class="subj">
                                    <div class="subj-title">Обществоз.:</div>
                                    <div class="subj-input">
                                        <input type="text" name="soc" value="" maxlength="3">
                                    </div>
                                </li>
                            </ul>
                            <div class="text">
                                <input type="checkbox" id="free"> <label for="free">только бюджетные места</label>
                            </div>
                            <div class="btn-cont">
                                <a href="{{ URL::action($CLASS.'@getCalculatorMore') }}" class="search-link">Полный калькулятор ЕГЭ</a>
                                <button class="us-btn">Найти</button>
                            </div>

                        {{ Form::close() }}

                    </div>

                </div>


                <div class="main-anots">
                    <div class="main-anot">
                        <div class="title">Ищите среди 150 вузов</div>
                        <div class="desc">
                            У нас вы найдете 2000 факультетов, 400 специальностей и 800 профилей обучения.
                        </div>
                    </div>
                    <div class="main-anot">
                        <div class="title">Сравните вузы и специальности</div>
                        <div class="desc">
                            Регистрируйтесь и сравнивайте обучение в разных вузах в своем личном кабинете.
                        </div>
                    </div>
                    <div class="main-anot">
                        <div class="title">Читайте объективные отзывы </div>
                        <div class="desc">
                            Свое мнение о вузах и специальностях оставляют студенты, абитуриенты и преподаватели.
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <div class="wrapper">

        @if (isset($popular) && is_array($popular) && @count($popular))
        <div class="half-block <?=@$history ? 'half-left' : ''?>"<?if(!@$history){echo ' style="width:100%"';}?>">
            <div class="title-block">
                <h2 class="us-title">Популярные вузы и направления</h2>
            </div>
            <ul class="pop-univs unstyled-list">
                @foreach ($popular as $obj)
                <? #Helper::dd($obj->get_emblem()->thumb); ?>
                <li class="pop-univ">
                    <div class="pop-univ-img">
                        <img src="{{ $obj->get_emblem()->thumb() }}" alt="">
                    </div>
                    <div class="name">
                        @if (@$obj->university)
                        «<a href="{{ URL::action($CLASS."@getSpeciality", array('speciality_id' => $obj->id)) }}" class="us-link">{{ $obj->name }}</a>»<br/>
                        в <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $obj->university->id)) }}" class="us-link">{{ $obj->university->name }}</a>
                        @else
                        <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $obj->id)) }}" class="us-link">{{ $obj->name }}</a>
                        @endif
                    </div>
                </li>
                @endforeach
                {{--
                <li class="pop-univ">
                    <div class="pop-univ-img">
                        <img src="img/univs/1.png" alt="">
                    </div>
                    <div class="name">
                        «<a href="#" class="us-link">Менеджмент недвижимости на транспорте</a>»<br>
                        в <a href="#" class="us-link">СПбГУСЭ</a>
                    </div>
                </li>
                --}}
            </ul>
        </div>
        @endif

        @if (isset($history) && is_array($history) && @count($history))
        <div class="half-block <?=@$popular ? 'half-right' : ''?>"<?if(!@$popular){echo ' style="width:100%"';}?>">
            <div class="title-block">
                <h2 class="us-title">Ранее вы смотрели</h2><span class="fl-r">Рейтинг</span>
            </div>
            <ul class="watch-list unstyled-list">
                @foreach ($history as $timestamp => $obj)
                <?
                $obj = (object)$obj;
                if (isset($obj->university))
                    $obj->university = (object)$obj->university;
                #Helper::dd($obj);
                ?>
                <li class="watch">
                    <span class="name"><!--
                        @if (@$obj->university)
                            --><a href="{{ URL::action($CLASS."@getSpeciality", array('speciality_id' => $obj->id)) }}" class="us-link">{{ $obj->name }}</a> - <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $obj->university->id)) }}" class="us-link">{{ $obj->university->name }}</a><!--
                        @else
                            -->
                            <a href="{{ URL::action($CLASS."@getUniversity", array('university_id' => $obj->id)) }}" class="us-link">{{ $obj->fullname }}</a><!--
                        @endif
                    --></span><span class="rating not_ready">0,0</span>
                </li>
                @endforeach
                {{--
                <li class="watch">
                    <span class="name"><a href="#" class="us-link">Санкт-Петербургский государственный университет экономики и финансов (СПбГУЭиФ, ФинЭк)</a></span><span class="rating">4,5</span>
                </li>
                --}}
            </ul>
        </div>
        @endif

        <div class="clearfix"></div>

        @if (isset($reviews) && is_array($reviews) && @count($reviews))
        <div class="not_ready half-block<?=@count($events) ? ' half-left' : ''?>"<?if(!@count($events)){echo ' style="width:100%"';}?>>
            <div class="title-block">
                <h2 class="us-title">Последние отзывы</h2><a href="{{ URL::action($CLASS.'@getReviews') }}" class="us-link">Все отзывы</a><span class="fl-r">Рейтинг</span>
            </div>
            <ul class="main-feedback unstyled-list hidden">
                <li class="item">
                    <div class="title-img">
                        <div class="title-img-cont">
                            <img src="img/feedbackface.png" alt="">
                        </div>
                    </div>
                    <div class="item-cont">
                        <div class="title">
                            <span class="title-text">Студент <a href="#" class="us-link js-user-tooltip">Иван Петров</a> написал сегодня про <a href="#" class="us-link">СПбГУЭиФ</a>.</span>
                        </div>
                        <div class="desc">
                            Механическая система, как следует из системы уравнений, вращает установившийся режим, составляя уравнения Эйлера для этой системы координат. Прецессионная теория различна.
                        </div>
                        <div class="bottom-block">
                            <a href="#" class="us-link fl-l">Все отзывы об СПбГУЭиФ</a>
                            <a href="#" class="feed-like us-link js-like fl-r" data-thumbs="up">Нравится <i class="fa fa-thumbs-up"></i>14</a>
                        </div>
                    </div>
                    <div class="rating">
                        <span>4,5</span>
                    </div>
                </li>
                <li class="item">
                    <div class="title-img">
                        <div class="title-img-cont">
                            <img src="img/feedbackface.png" alt="">
                        </div>
                    </div>
                    <div class="item-cont">
                        <div class="title">
                            <span class="title-text">Студент <a href="#" class="us-link js-user-tooltip">Иван Петров</a> написал сегодня про <a href="#" class="us-link">СПбГУЭиФ</a>.</span>
                        </div>
                        <div class="desc">
                            Механическая система, как следует из системы уравнений, вращает установившийся режим, составляя уравнения Эйлера для этой системы координат. Прецессионная теория различна.
                        </div>
                        <div class="bottom-block">
                            <a href="#" class="us-link fl-l">Все отзывы об СПбГУЭиФ</a>
                            <a href="#" class="feed-like us-link js-like fl-r" data-thumbs="up">Нравится <i class="fa fa-thumbs-up"></i>14</a>
                        </div>
                    </div>
                    <div class="rating">
                        <span>4,5</span>
                    </div>
                </li>
            </ul>
        </div>
        @endif

        @if (isset($events) && (is_array($events) || is_object($events)) && @count($events))
        <div class="half-block <?=@$reviews ? 'half-right' : ''?>"<?if(!@$reviews){echo ' style="width:100%"';}?>>
            <div class="title-block">
                <h2 class="us-title">Ближайшие мероприятия</h2><a href="{{ URL::action($CLASS.'@getEvents') }}" class="us-link">Все мероприятия</a>
            </div>
            <ul class="events unstyled-list">
                @foreach ($events as $event)
                <li class="event">
                    <div class="event-img" style="background-image: url({{ $event->get_photo()->thumb() }})">
                        {{--<img src="{{ $event->get_photo()->thumb() }}">--}}
                    </div>
                    <div class="event-date">{{ Helper::rdate('j M', $event->date) }}</div>
                    <div class="event-desc">
                        {{ $event->name }} в <a href="{{ URL::action($CLASS.'@getUniversity', array('university_id' => $event->university->id)) }}" class="us-link">{{ $event->university->name }}</a>
                    </div>
                    <a href="#" class="main-event-btn">Записаться</a>
                </li>
                @endforeach
                {{--
                <li class="event">
                    <div class="event-img"><img src="img/event.jpg"></div>
                    <div class="event-date">25 октября</div>
                    <div class="event-desc">
                        День открытых дверей в <a href="#" class="us-link">СПбГУКИ</a>
                    </div>
                    <a href="#" class="main-event-btn">Записаться</a>
                </li>
                --}}
            </ul>
        </div>
        @endif

    </div>
    <div class="clearfix"></div>
    </main>

@stop


@section('scripts')

@stop