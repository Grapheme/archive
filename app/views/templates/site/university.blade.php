@extends(Helper::layout())


@section('style')

<!-- VK LIKE BUTTON -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?113"></script>

<script type="text/javascript">
    VK.init({apiId: 2661341, onlyWidgets: true});
</script>
<!--  -->

@stop


@section('content')

<main class="wrapper-full wrapper-pad">
<div class="wrapper">
<div class="bread">
    <span class="crumb"><a href="/" class="us-link">Главная</a></span>
    <span class="crumb">
        <a href="{{ URL::action($CLASS.'@getSearchUniversity', null, false) }}" class="us-link">{{ DicVal::whereId($university->city)->name }}</a>
        <span class="crumb-sub">
            <?
            $city_university_count = University::where('city', $university->city)->count();
            ?>
            {{ $city_university_count }}
            {{ trans_choice('[1,1] вуз|[2,4] вуза|[5,Inf] вузов', $city_university_count) }}
        </span>
    </span>
    <span class="crumb">{{ $university->name }}</span>
</div>
<div class="dir-search-left">

    @if (@count($relative_universities))
    <div class="gray-block">
        <div class="normal-title">Похожие вузы</div>
        <ul class="relative-dirs unstyled-list">
            @foreach ($relative_universities as $relative)
            <li class="margin-t15">
                <div class="dir-left">
                    <div class="title">
                        <a href="{{ URL::action($CLASS.'@getUniversity', array('university_id' => $relative->id)) }}" class="us-link">{{ $relative->name }}</a>
                    </div>
                    <div class="desc">
                        {{ Helper::preview($relative->fullname, 10) }}
                    </div>
                </div>
                <div class="rating fl-r not_ready">0,0</div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    @include(Helper::layout('_map_block'))

    @include(Helper::layout('_history'))

</div>
<div class="dir-search-right">
<div class="about-univ">
<div class="direction">
    <div class="univ-header" style="background-image: url({{ $university->get_photo()->full() }});">
        <div class="liked">
            <span class="text not_ready"><b>0</b> пользователей заинтересовались этим вузом</span>
            <!--<div id="vk_like"></div>-->
        </div>
    </div>
    <div class="dir-photo">
        <div class="dir-photo-in">
            <img src="{{ $university->get_emblem()->thumb() }}">
        </div>
        <span class="">{{ DicVal::whereId($university->city)->name }}</span>
    </div>
    <div class="direction-in">
        <div class="title">
            <span class="text">
               {{ $university->fullname }}
            </span>
            <div class="btn-cont not_ready">
                <a href="#" class="us-btn">Сохранить</a>
            </div>
        </div>
        <div>
            <div class="dirb-left">
                <div class="direction-info">
                    <div class="dir-row">
                        <span>Форма организации:</span><span><a href="#" class="us-link">
                                {{ DicVal::whereId($university->organization_form)->name }}
                        </a></span>
                    </div>
                    <div class="dir-row">
                        <span>Тип:</span><span><a href="#" class="us-link">
                                {{ DicVal::whereId($university->type)->name }}
                        </a></span>
                    </div>
                    <div class="dir-row">
                        <span>Профиль:</span><span><a href="#" class="us-link">
                                {{ DicVal::whereId($university->profile)->name }}
                        </a></span>
                    </div>
                    <div class="dir-row">
                        <span>Наличие военной кафедры:</span><span>{{ $university->military_faculty ? 'да' : 'нет' }}</span>
                    </div>
                    <div class="dir-row">
                        <span>Год основания:</span><span>{{ $university->foundation_year }}</span>
                    </div>
                </div>
                <div class="direction-sub university-short-desc">
                    {{ Helper::preview($university->desc, 12) }} <a href="#" class="us-link view-full-desc">Прочитать полностью</a>
                </div>
                <div class="direction-sub university-full-desc" style="display:none;">
                    {{ Helper::nl2br($university->desc) }}
                </div>
            </div>
            @if (is_object($event))
            <div class="dirb-right fl-r">
                <b>{{ Helper::rdate('j M', $event->date) }}</b><br>
                {{ $event->name }}
                <a href="#" class="apply-btn not_ready">Записаться</a>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="dblock-hr"></div>
<div class="university_info">
    <div class="four-block">
        <ul class="unstyled-list">
            <li>
                <span>Студентов:</span><span>{{ $university->count_students }}</span>
            <li>
                <span>Преподавателей:</span><span>{{ $university->count_teachers }}</span>
        </ul>
    </div><!--
    --><div class="four-block">
        <ul class="unstyled-list">
            <li>
                <span>Направлений:</span><span>{{ $university->count_specialities }}</span>
            <li>
                <span>Профилей:</span><span>{{ $university->count_profiles }}</span>
            <li>
                <span>Факультетов:</span><span>{{ $university->count_faculties }}</span>
        </ul>
    </div><!--
    --><div class="four-block">
        <ul class="unstyled-list">
            <li>
                <span>Корпусов:</span><span>{{ $university->count_buildings }}</span>
            <li>
                <span>Общежитий:</span><span>{{ $university->count_dormitories }}</span>
        </ul>
    </div><!--
    --><div class="four-block">
        <ul class="unstyled-list">
            <li>
                <span>Целевые места:</span><span>{{ $university->target_places ? 'есть' : 'нет' }}</span>
            <li>
                <span>Олимпиады:</span><span>{{ $university->olympics_admission ? 'есть' : 'нет' }}</span>
            <li>
                <span>Повышенная стипендия:</span><span>{{ $university->increased_scholarship }}</span>
        </ul>
    </div>
</div>
<div class="dblock-hr"></div>
<div class="last-review not_ready">
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
    </div><!--
    --><div class="dir-message">
        <div class="feed-message">
            <div class="title-img">
                <div class="title-img-cont">
                    <img src="/img/feedbackface.png" alt="">
                </div>
            </div>
            <div class="item-cont">
                <div class="title">
                    <span class="title-text">Студент <a href="#" class="us-link js-user-tooltip">Иван Петров</a> написал сегодня:</span>
                </div>
                <div class="desc">
                    Механическая система, как следует из системы уравнений, вращает установившийся режим, составляя
                    уравнения Эйлера для этой системы координат. Прецессионная теория различна.
                </div>
                <div class="bottom-block">
                    <a href="#" class="us-link fl-l">Все отзывы</a>
                    <a href="#" class="us-link fl-l">Добавить отзыв</a>
                    <span class="fl-r">
                        <a href="#" class="feed-like us-link js-like" data-thumbs="down"
                           data-likes="120">
                            Не нравится <i class="fa fa-thumbs-down"></i>120
                        </a>
                        <a href="#" class="feed-like us-link js-like" data-thumbs="up"
                           data-likes="14">
                            Нравится <i class="fa fa-thumbs-up"></i>14
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dblock-hr"></div>


@include(Helper::layout('_faces_block'))


<div class="dblock-hr"></div>

<ul class="dir-list-blocks unstyled-list">

    @if (@count($university->faculty))
    <?
    $limit = Config::get('site.limit_university_page_base');
    $faculties = $university->faculty->toArray();
    if (count($university->faculty) > $limit) {
        shuffle($faculties);
        $faculties = array_slice($faculties, 0, $limit);
    }
    ?>
    <li>
        <div class="title">Факультеты:</div>
        <ul class="unstyled-list">
            @foreach ($faculties as $faculty)
            <li>{{ $faculty['name'] }}
            @endforeach
        </ul>
        @if (count($university->faculty) > $limit)
            <a href="#" class="us-link-dash js-pop-show" data-popup="faculty">еще {{ count($university->faculty)-$limit }}</a>
        @endif
    @endif

    @if (@count($university->faculty))
    <?
    $limit = Config::get('site.limit_university_page_base');
    $specialities = $university->specialities->toArray();
    if (count($specialities) > $limit) {
        shuffle($specialities);
        $specialities = array_slice($specialities, 0, $limit);
    }
    ?>
    <li>
        <div class="title">Направления и специальности:</div>
        <ul class="unstyled-list">
            @foreach ($specialities as $speciality)
            <li><a href="{{ URL::action($CLASS."@getSpeciality", array('speciality_id' => $speciality['id'])) }}" class="us-link">{{ $speciality['name'] }}</a>
            @endforeach
        </ul>
        @if (count($university->specialities) > $limit)
        <a href="#" class="us-link-dash js-pop-show" data-popup="speciality">еще {{ count($university->specialities)-$limit }}</a>
        @endif
    @endif

    <?
    $limit = Config::get('site.limit_university_page_base');
    $students_life = explode("\n", $university->students_life);
    foreach ($students_life as $sl => $org) {
        $org = trim($org);
        if ($org != '')
            $students_life[$sl] = $org;
        else
            unset($students_life[$sl]);
    }
    $students_life_cut = $students_life;
    if (count($students_life) > $limit) {
        shuffle($students_life_cut);
        $students_life_cut = array_slice($students_life_cut, 0, $limit);
    }
    ?>
    @if (count($students_life))
    <li class="">
        <div class="title">Студенческая жизнь:</div>
        <ul class="unstyled-list">
            @foreach ($students_life_cut as $sl => $org)
            <li>{{ $org }}
            @endforeach
        </ul>
        @if (count($students_life) > $limit)
        <a href="#" class="us-link-dash js-pop-show" data-popup="students_life">еще {{ count($students_life)-$limit }}</a>
        @endif
    @endif

</ul>

    <div class="dblock-hr"></div>


    @include(Helper::layout('_media_block'), array('mediafiles' => $university->mediafiles, 'link' => '#'))


    <div class="dblock-hr"></div>

<div>
    <div class="dir-contact">

        <div class="title">Контакты:</div>
        <div class="contact-item">
            <div>
                тел.: <a href="tel:{{ $university->phone }}" class="us-link">{{ $university->phone }}</a><br/>
                эл. почта: <a href="mailto:{{ $university->email }}" class="us-link">{{ $university->email }}</a>
            </div>
        </div>

    </div><!--
    @if (@count($university->hostels))
    <?
    $limit = Config::get('site.limit_university_page_base');
    $hostels = $university->hostels->toArray();
    if (count($hostels) > $limit) {
        shuffle($hostels);
        $hostels = array_slice($hostels, 0, $limit);
    }
    ?>
    --><div class="dir-contact">
        <div class="title">Общежития:</div>
        @foreach ($hostels as $hostel)
        <div class="contact-item">
            <div>{{ $hostel['name'] }}:</div>
            <div><a href="{{ URL::action($CLASS.'@getHostel', array($hostel['id'])) }}" class="us-link">{{ DicVal::whereId($university->city)->name }}, {{ $hostel['address'] }}</a></div>
        </div>
        @endforeach
    </div>
    @else
    -->
    @endif

</div>
</div>
</div>
</div>
<div class="clearfix"></div>
</main>

@stop


@section('overlays')

<div class="overlay">

    <div class="pop-prof pop-window closed" data-popup="students_life">
        <div class="pop-title">
            Студенческая жизнь
            <i class="pop-close js-pop-close"></i>
        </div>
        <div class="double-block">
            <div class="pop-text">Наши студенческие организации:</div>
            <ul class="unstyled-list">
                @foreach ($students_life as $sl => $org)
                <li>{{ $org }}
                @endforeach
            </ul>
        </div>
    </div>

    <div class="pop-prof pop-window closed" data-popup="proffesions">
    <div class="pop-title">
        Профессии
        <i class="pop-close js-pop-close"></i>
    </div>
    <div class="double-block">
        <div class="pop-text">Возможные профессии:</div>
        <ul class="unstyled-list">
            <li>Прикладная информатика
            <li>Математические технологии
            <li>Общих теорий
            <li>Математики в экономике
            <li>Информационные технологии
            <li>Прикладная информатика
            <li>Математические технологии
            <li>Общих теорий
            <li>Математики в экономике
            <li>Информационные технологии
            <li>Прикладная информатика
            <li>Математические технологии
            <li>Общих теорий
            <li>Математики в экономике
            <li>Информационные технологии
        </ul>
    </div><!--
             --><div class="double-block">
        <div class="pop-text">Сферы деятельности:</div>
        <ul class="unstyled-list">
            <li>Математические технологии
            <li>Общих теорий
            <li>Математики в экономике
            <li>Информационные технологии
            <li>Прикладная информатика
            <li>Математические технологии
            <li>Общих теорий
            <li>Математики в экономике
            <li>Информационные технологии
        </ul>
    </div>
</div>

    <div class="pop-edplan pop-window closed" data-popup="education-plan">
    <div class="pop-title">
        Учебный план
        <i class="pop-close js-pop-close"></i>
    </div>
    <table class="educ-table">
        <thead>
        <th>Курс</th>
        <th>Дисциплина</th>
        <th>Уч. часов</th>
        <th>Форма контроля</th>
        </thead>
        <tbody>
        <tr>
            <td class="spec-td">1 курс</td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>

        <tr>
            <td class="spec-td">2 курс</td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>

        <tr>
            <td class="spec-td">3 курс</td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>

        <tr>
            <td class="spec-td">4 курс</td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>

        <tr>
            <td class="spec-td">5 курс</td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        <tr>
            <td></td>
            <td>История</td>
            <td>306</td>
            <td>экзамен</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="pop-studlife pop-window closed" data-popup="students-life">
    <div class="pop-title">
        Студенческая жизнь в СПбГУ
        <i class="pop-close js-pop-close"></i>
    </div>
    <div class="studl-window js-tab-parent">
        <ul class="unstyled-list studl-nav">
            <li class="studl-option"><a href="#" class="js-tab" data-block="1">Профсоюз</a>
            <li class="studl-option"><a href="#" class="js-tab" data-block="2">Газета Uni.com</a>
            <li class="studl-option"><a href="#" class="js-tab" data-block="3">Спорт</a>
            <li class="studl-option"><a href="#" class="js-tab" data-block="4">Творчество</a>
            <li class="studl-option"><a href="#" class="js-tab" data-block="5">Радио "Мегабайт"</a>
        </ul><!--
                 --><div class="studl-info">
            <div class="js-tab-window" data-block="1">
                <div class="title">Профсоюз студентов СпбГУКТ</div>
                <p class="text">
                    <b>Деятельность</b><br>
                    Общество потребления, конечно, программирует конструктивный мониторинг активности, повышая конкуренцию. Косвенная реклама без оглядки на авторитеты традиционно тормозит системный анализ, опираясь на опыт западных коллег. Рекламная кампания позиционирует из ряда вон выходящий рекламный макет, оптимизируя бюджеты. Тем не менее, эволюция мерчандайзинга ускоряет традиционный канал, расширяя долю рынка.
                </p>
                <p class="text">
                    <b>Чему можно научиться</b><br>
                    Нишевый проект, на первый взгляд, охватывает рейтинг, не считаясь с затратами. Повторный контакт обоснован необходимостью. Стимулирование коммьюнити масштабирует комплексный процесс стратегического планирования, отвоевывая свою долю рынка. К тому же VIP-мероприятие оправдывает медиамикс, оптимизируя бюджеты. Conversion rate, пренебрегая деталями, ригиден. Медийная связь, как принято считать, синхронизирует побочный PR-эффект, осознав маркетинг как часть производства. Медиавес, осознавая социальную ответственность бизнеса. Стимулирование коммьюнити концентрирует креативный процесс стратегического планирования, опираясь на опыт западных коллег.
                </p>
                <ul class="media-block unstyled-list">
                    <li class="media-item media-video">
                        <a href="#" style="background-image: url(/img/test/univ1.jpg);"></a>
                    <li class="media-item media-video">
                        <a href="#" style="background-image: url(/img/test/univ1.jpg);"></a>
                    <li class="media-item">
                        <a href="#" style="background-image: url(/img/test/univ1.jpg);"></a>
                    <li class="media-item">
                        <a href="#" style="background-image: url(/img/test/univ1.jpg);"></a>
                </ul>
            </div>
            <div class="js-tab-window" data-block="2">
                2
            </div>
            <div class="js-tab-window" data-block="3">
                3
            </div>
            <div class="js-tab-window" data-block="4">
                4
            </div>
            <div class="js-tab-window" data-block="5">
                5
            </div>
        </div>
    </div>
</div>


    @include(Helper::layout('_media_popup'), array('mediafiles' => $university->mediafiles))


    @include(Helper::layout('_faces_popup'))


<div class="pop-faculties pop-window closed" data-popup="faculty">
    <div class="pop-title">
        Факультеты
        <i class="pop-close js-pop-close"></i>
    </div>
    <ul class="margin-t10 unstyled-list clearfix">
        @foreach ($university->faculty as $faculty)
        <li style="float:left; width:50%">{{ $faculty['name'] }}
        @endforeach
    </ul>
</div>

    <div class="pop-profiles pop-window closed" data-popup="speciality">
    <div class="pop-title">
        Направления и специальности
        <i class="pop-close js-pop-close"></i>
    </div>
    <div class="margin-t20">В этом вузе готовят специалистов<br>по {{ $university->specialities->count() }} профилям:</div>
    <ul class="margin-t10 unstyled-list clearfix">
        @foreach ($university->specialities as $spec)
        <li>{{ $spec['name'] }}
        @endforeach
    </ul>
</div>

    <div class="pop-dirs pop-window closed" data-popup="directions">
    <div class="pop-title">
        Направления и специальности
        <i class="pop-close js-pop-close"></i>
    </div>
    <ul class="univ-dirs-carts unstyled-list">
        <li class="univ-dir-item">
            <div class="univ-photo" style="background-image: url(/img/test/univ1.jpg)"></div>
            <div class="univ-dir-info">
                <div class="title"><a href="#" class="us-link">Маркетинг и пиар</a></div>
                <div class="desc">Формы обучения: очное, заочное, вечернее</div>

                <div class="univ-rating">
                    <span class="rating">8,3</span>
                                <span class="univ-ratdesc">
                                    <span class="rating-word">отлично</span><br>
                                    <span class="rating-people">по мнению <a href="#" class="us-link">69 пользователей</a></span>
                                </span>
                </div>

                <a href="#" class="us-btn">Сохранить</a>
            </div>

        <li class="univ-dir-item">
            <div class="univ-photo" style="background-image: url(/img/test/univ1.jpg)"></div>
            <div class="univ-dir-info">
                <div class="title"><a href="#" class="us-link">Маркетинг и пиар</a></div>
                <div class="desc">Формы обучения: очное, заочное, вечернее</div>

                <div class="univ-rating">
                    <span class="rating">8,3</span>
                                <span class="univ-ratdesc">
                                    <span class="rating-word">отлично</span><br>
                                    <span class="rating-people">по мнению <a href="#" class="us-link">69 пользователей</a></span>
                                </span>
                </div>

                <a href="#" class="us-btn">Сохранить</a>
            </div>

        <li class="univ-dir-item">
            <div class="univ-photo" style="background-image: url(/img/test/univ1.jpg)"></div>
            <div class="univ-dir-info">
                <div class="title"><a href="#" class="us-link">Маркетинг и пиар</a></div>
                <div class="desc">Формы обучения: очное, заочное, вечернее</div>

                <div class="univ-rating">
                    <span class="rating">8,3</span>
                                <span class="univ-ratdesc">
                                    <span class="rating-word">отлично</span><br>
                                    <span class="rating-people">по мнению <a href="#" class="us-link">69 пользователей</a></span>
                                </span>
                </div>

                <a href="#" class="us-btn">Сохранить</a>
            </div>

        <li class="univ-dir-item">
            <div class="univ-photo" style="background-image: url(/img/test/univ1.jpg)"></div>
            <div class="univ-dir-info">
                <div class="title"><a href="#" class="us-link">Маркетинг и пиар</a></div>
                <div class="desc">Формы обучения: очное, заочное, вечернее</div>

                <div class="univ-rating">
                    <span class="rating">8,3</span>
                                <span class="univ-ratdesc">
                                    <span class="rating-word">отлично</span><br>
                                    <span class="rating-people">по мнению <a href="#" class="us-link">69 пользователей</a></span>
                                </span>
                </div>

                <a href="#" class="us-btn">Сохранить</a>
            </div>

        <li class="univ-dir-item">
            <div class="univ-photo" style="background-image: url(/img/test/univ1.jpg)"></div>
            <div class="univ-dir-info">
                <div class="title"><a href="#" class="us-link">Маркетинг и пиар</a></div>
                <div class="desc">Формы обучения: очное, заочное, вечернее</div>

                <div class="univ-rating">
                    <span class="rating">8,3</span>
                                <span class="univ-ratdesc">
                                    <span class="rating-word">отлично</span><br>
                                    <span class="rating-people">по мнению <a href="#" class="us-link">69 пользователей</a></span>
                                </span>
                </div>

                <a href="#" class="us-btn">Сохранить</a>
            </div>

        <li class="univ-dir-item">
            <div class="univ-photo" style="background-image: url(/img/test/univ1.jpg)"></div>
            <div class="univ-dir-info">
                <div class="title"><a href="#" class="us-link">Маркетинг и пиар</a></div>
                <div class="desc">Формы обучения: очное, заочное, вечернее</div>

                <div class="univ-rating">
                    <span class="rating">8,3</span>
                                <span class="univ-ratdesc">
                                    <span class="rating-word">отлично</span><br>
                                    <span class="rating-people">по мнению <a href="#" class="us-link">69 пользователей</a></span>
                                </span>
                </div>

                <a href="#" class="us-btn">Сохранить</a>
            </div>
    </ul>
</div>

</div>

@stop


@section('scripts')

    @include(Helper::layout('_map_script'), array('objects' => $map_objects, 'map_id' => 'dir-map'))

@stop