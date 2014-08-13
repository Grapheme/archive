@extends(Helper::layout())


@section('content')

<main class="wrapper-full wrapper-pad">
<div class="wrapper">

<div class="bread">
    <span class="crumb"><a href="/" class="us-link">Главная</a></span>
    <span class="crumb">
        <a href="{{ URL::action($CLASS.'@getSearchUniversity', null, false) }}" class="us-link">{{ DicVal::whereId($speciality->university->city)->name }}</a>
        <span class="crumb-sub">
            <?
            $city_university_count = University::where('city', $speciality->university->city)->count();
            ?>
            {{ $city_university_count }}
            {{ trans_choice('[1,1] вуз|[2,4] вуза|[5,Inf] вузов', $city_university_count) }}
        </span>
    </span>
    <span class="crumb">
        <a href="{{ URL::action($CLASS.'@getUniversity', array($speciality->university->id), false) }}" class="us-link">{{ $speciality->university->name }}</a>
        <span class="crumb-sub">
            {{ trans_choice(':count направление|:count направления|:count направлений', $speciality->university->specialities->count(), array(), 'ru') }}
        </span>
    </span>
    <span class="crumb">{{ $speciality->name }}</a>
</div>


<div class="dir-search-left">

    <div class="gray-block not_ready">
        <div class="normal-title">Похожие направления</div>
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

    @include(Helper::layout('_map_block'))

    @include(Helper::layout('_history'))

</div>


<div class="dir-search-right">
<div class="dir-univ">
    <div class="dir-univ-top js-alldirs">
        <div class="univ-photo"><img src="{{ $speciality->university->get_emblem()->thumb() }}" alt=""></div>
        <div class="univ-info">
            <div class="title"><a href="{{ URL::action($CLASS.'@getUniversity', array($speciality->university->id), false) }}" class="title-link us-link">{{ $speciality->university->name }}</a> (<a href="#" class="us-link not_ready">посмотреть на карте</a>)</div>
            <div class="desc">{{ $speciality->university->fullname }}</div>
        </div>
        @if ($specialities != false && count($specialities))
        <div class="univ-dirs-link js-open-allow js-alldirs">
            <a href="#" class="us-link js-open-allow js-alldirs" data-block="dir-univ-bottom" data-active="dir-univ">Все направления в этом вузе <i class="fa fa-caret-right fa-rotate-90"></i></a>
        </div>
        @endif
    </div>
    @if ($specialities != false && count($specialities))
    <div class="dir-univ-bottom">
        <div class="univ-dirs">
            <div class="title-block">
                <h2 class="us-title">Направления и специальности в {{ $speciality->university->name }}</h2>
            </div>
            <ul class="univ-dirs-carts unstyled-list">
                @foreach ($specialities as $spec)
                <li class="univ-dir-item">
                    <div class="univ-photo" style="background-image: url({{ $spec->get_emblem()->thumb() }})"></div>
                    <div class="univ-dir-info">
                        <div class="title"><a href="{{ URL::action($CLASS.'@getSpeciality', array('speciality_id' => $spec->id)) }}" class="us-link">{{ $spec->name }}</a></div>
                        <?
                        $learning_forms = array();
                        if (count($spec->learning_forms)) {
                            foreach ($spec->learning_forms as $lf) {
                                $learning_forms[] = mb_strtolower($lf['name']);
                            }
                            $learning_forms = implode(', ', $learning_forms);
                        }
                        ?>
                        @if ($learning_forms)
                        <div class="desc">Формы обучения: {{ $learning_forms }}</div>
                        @endif

                        <div class="univ-rating not_ready">
                            <span class="rating">8,3</span>
                            <span class="univ-ratdesc">
                                <span class="rating-word">отлично</span><br>
                                <span class="rating-people">по мнению <a href="#" class="us-link">69 пользователей</a></span>
                            </span>
                        </div>

                        <a href="#" class="us-btn not_ready">Сохранить</a>
                    </div>

                @endforeach

            </ul>
        </div>
    </div>
    @endif

</div>
<div class="about-dir">
<div class="direction">
    <div class="dir-photo">
        <div class="dir-photo-in">
            <img src="{{ $speciality->get_emblem()->thumb() }}">
        </div>
        <span>{{ DicVal::whereId($speciality->university->city)->name }}</span>
    </div>
    <div class="direction-in">
        <div class="title">
            <span class="text">
                Направление «{{ $speciality->name }}»
            </span>
            <div class="btn-cont not_ready">
                <a href="#" class="us-btn">Сохранить</a>
            </div>
        </div>
        <div class="liked">
            <span class="text not_ready"><b>0</b> пользователей заинтересовались этим направлением</span>
            <!--<div id="vk_like"></div>-->
        </div>
        <div>
            <div class="dirb-left">
                <div class="direction-info">
                    <div class="dir-row">
                        {{--<span>Факультет:</span><span><a href="#" class="us-link">{{ $speciality->faculty->name }}</a></span>--}}
                        <span>Факультет:</span><span>{{ $speciality->faculty->name }}</span>
                    </div>
                    <div class="dir-row">
                        <span>Степень:</span><span><a href="#" class="us-link">{{ DicVal::whereId($speciality->degree)->name }}</a></span>
                    </div>
                    <div class="dir-row">
                        <span>Квалификация:</span><span><a href="#" class="us-link">{{ DicVal::whereId($speciality->qualification)->name }}</a></span>
                    </div>
                    <div class="dir-row">
                        <span>Срок обучения:</span><span>{{ $speciality->duration_of_study }} {{ trans_choice('[1,1] год|[2,Inf] года', $speciality->duration_of_study) }}</span>
                    </div>
                </div>
                <div class="direction-sub university-short-desc">
                    {{ Helper::preview($speciality->desc, 12) }} <a href="#" class="us-link view-full-desc">Прочитать полностью</a>
                </div>
                <div class="direction-sub university-full-desc" style="display:none;">
                    {{ Helper::nl2br($speciality->desc) }}
                </div>
            </div>
            <div class="dirb-right fl-r not_ready">
                Хотите посетить направление?<br>
                <a href="#" class="apply-btn">Подать заявку</a>
            </div>
        </div>
    </div>
</div>

<div class="dblock-hr"></div>

@if (count($speciality->learning_forms))
<div class="dir-educ-types js-tab-parent">

    <div class="educ-types">
        @foreach ($speciality->learning_forms as $l => $learning_form)
            <a href="#" class="js-tab{{ ($l==0) ? ' active' : '' }}" data-block="{{ $l+1 }}">{{ $learning_form->name->name }}</a>
        @endforeach
    </div>

    <div class="clearfix"></div>

    @foreach ($speciality->learning_forms as $l => $learning_form)
    <div class="js-tab-window" data-block="{{ $l+1 }}" style="display: none;">
        <ul class="dir-educ-type unstyled-list">
            @if (count($learning_form->entrance_exams))
            <li class="dir-row">
                <span>Вступительные экзамены:</span>
                <span>
                    @foreach ($learning_form->entrance_exams as $exam)
                        {{ mb_strtolower($exam->name) }}<br/>
                    @endforeach
                </span>
            @endif
            @if (count($learning_form->accepted_olympics))
            <li class="dir-row">
                <span>Принимаемые олимпиады вуза:</span>
                <span>
                    @foreach ($learning_form->accepted_olympics as $olymp)
                        {{ mb_strtolower($olymp->name) }}<br/>
                    @endforeach
                </span>
            @endif
            @if ($learning_form->olympics_conditions)
            <li class="dir-row">
                <span>&nbsp;</span>
                <span><a href="#" class="us-link js-pop-show" data-popup="olympics_conditions">Как поступить по олимпиаде?</a></span>
            @endif
        </ul><!--
        --><ul class="dir-educ-type unstyled-list">
            <li>
                <ul class="dir-rows unstyled-list">
                    @if ($learning_form->budget_score)
                    <li class="dir-row">
                        <span>Проходной балл на бюджет:</span>
                        <span>{{ $learning_form->budget_score }}</span>
                    @endif
                    @if ($learning_form->budget_competition)
                    <li class="dir-row">
                        <span>Конкурс на бюджет:</span>
                        <span>{{ $learning_form->budget_competition }} чел. на место</span>
                    @endif
                    @if ($learning_form->budget_places)
                    <li class="dir-row">
                        <span>Кол-во бюджетных мест:</span>
                        <span>{{ $learning_form->budget_places }}</span>
                    @endif
                </ul>
            </li>

            <li>
                <ul class="dir-rows unstyled-list">
                    @if ($learning_form->contract_score)
                    <li class="dir-row">
                        <span>Проходной балл на контракт:</span>
                        <span>{{ $learning_form->contract_score }}</span>
                    @endif
                    @if ($learning_form->contract_competition)
                    <li class="dir-row">
                        <span>Конкурс на контракт:</span>
                        <span>{{ $learning_form->contract_competition }} чел. на место</span>
                    @endif
                    @if ($learning_form->contract_places)
                    <li class="dir-row">
                        <span>Кол-во контрактных мест:</span>
                        <span>{{ $learning_form->contract_places }}</span>
                    @endif
                    @if ($learning_form->contract_price)
                    <li class="dir-row">
                        <span>Цена обучения:</span>
                        <span>от {{ $learning_form->contract_price }}р.</span>
                    @endif
                </ul>
            </li>

            <li>
                <ul class="dir-rows unstyled-list">
                    @if ($learning_form->target_places)
                    <li class="dir-row">
                        <span>Кол-во целевых мест:</span>
                        <span>{{ $learning_form->target_places }}</span>
                    @endif
                </ul>
            </li>
        </ul>
    </div>
    @endforeach

</div>

<div class="dblock-hr"></div>

@endif

<div class="not_ready">
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
                    <img src="img/feedbackface.png" alt="">
                </div>
            </div>
            <div class="item-cont">
                <div class="title">
                    <span class="title-text">Студент <a href="#" class="us-link">Иван Петров</a> написал сегодня:</span>
                </div>
                <div class="desc">
                    Механическая система, как следует из системы уравнений, вращает установившийся режим, составляя уравнения Эйлера для этой системы координат. Прецессионная теория различна.
                </div>
                <div class="bottom-block">
                    <a href="#" class="us-link fl-l">Все отзывы</a>
                    <a href="#" class="us-link fl-l">Добавить отзыв</a>
                        <span class="fl-r">
                            <a href="#" class="feed-like us-link">
                                Не нравится <i class="fa fa-thumbs-down"></i>120
                            </a>
                            <a href="#" class="feed-like us-link">
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

    <?
    $limit = Config::get('site.limit_university_page_base');
    ?>

    <?
    $field = 'training_profiles';
    $field_title = 'Возможные профили обучения:';
    $list = explode("\n", $speciality->$field);
    foreach ($list as $l => $lst) {
        $lst = trim($lst);
        if ($lst != '')
            $list[$l] = $lst;
        else
            unset($list[$l]);
    }
    $$field = $list_cut = $list;
    if (count($list) > $limit) {
        shuffle($list_cut);
        $list_cut = array_slice($list_cut, 0, $limit);
    }
    ?>
    @if (count($list_cut))
    <li class="">
        <div class="title">{{ $field_title }}</div>
        <ul class="unstyled-list">
            @foreach ($list_cut as $l => $lst)
            <li>{{ $lst }}
            @endforeach
        </ul>
        @if (count($list) > $limit)
        <a href="#" class="us-link-dash js-pop-show" data-popup="{{ $field }}">еще {{ count($list)-$limit }}</a>
        @endif
    @endif


    <?
    $field = 'basic_disciplines';
    $field_title = 'Базовые дисциплины:';
    $list = explode("\n", $speciality->$field);
    foreach ($list as $l => $lst) {
        $lst = trim($lst);
        if ($lst != '')
            $list[$l] = $lst;
        else
            unset($list[$l]);
    }
    $$field = $list_cut = $list;
    if (count($list) > $limit) {
        shuffle($list_cut);
        $list_cut = array_slice($list_cut, 0, $limit);
    }
    ?>
    @if (count($list_cut))
    <li class="">
        <div class="title">{{ $field_title }}</div>
        <ul class="unstyled-list">
            @foreach ($list_cut as $l => $lst)
            <li>{{ $lst }}
                @endforeach
        </ul>
        @if (count($list) > $limit)
        <a href="#" class="us-link-dash js-pop-show" data-popup="{{ $field }}">еще {{ count($list)-$limit }}</a>
        @endif
    @endif


    <?
    $field = 'professions';
    $field_title = 'После окончания сможете работать:';
    $list = explode("\n", $speciality->$field);
    foreach ($list as $l => $lst) {
        $lst = trim($lst);
        if ($lst != '')
            $list[$l] = $lst;
        else
            unset($list[$l]);
    }
    $$field = $list_cut = $list;
    if (count($list) > $limit) {
        shuffle($list_cut);
        $list_cut = array_slice($list_cut, 0, $limit);
    }
    ?>
    @if (count($list_cut))
    <li class="">
        <div class="title">{{ $field_title }}</div>
        <ul class="unstyled-list">
            @foreach ($list_cut as $l => $lst)
            <li>{{ $lst }}
                @endforeach
        </ul>
        @if (count($list) > $limit)
        <a href="#" class="us-link-dash js-pop-show" data-popup="{{ $field }}">еще {{ count($list)-$limit }}</a>
        @endif
    @endif

</ul>

    <div class="dblock-hr"></div>


    @include(Helper::layout('_media_block'), array('mediafiles' => $speciality->mediafiles, 'link' => '#'))


    <div class="dblock-hr"></div>

<div class="">

    <div class="dir-contact">

        <div class="title">Контакты {{ $speciality->university->name }}:</div>
        <div class="contact-item">
            <div>
                тел.: <a href="tel:{{ $speciality->university->phone }}" class="us-link">{{ $speciality->university->phone }}</a><br/>
                эл. почта: <a href="mailto:{{ $speciality->university->email }}" class="us-link">{{ $speciality->university->email }}</a>
            </div>
        </div>

    </div><!--
    @if (@count($speciality->university->hostels))
    <?
    $hostels = @is_object($speciality->university->hostels) ? $speciality->university->hostels->toArray() : array();
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
            <div><a href="{{ URL::action($CLASS.'@getHostel', array($hostel['id'])) }}" class="us-link">{{ DicVal::whereId($speciality->university->city)->name }}, {{ $hostel['address'] }}</a></div>
        </div>
        @endforeach
    </div><!--
    @endif
    -->

</div>
</div>
</div>
</div>
<div class="clearfix"></div>
</main>


@stop


@section('overlays')

<div class="overlay">

    <div class="pop-prof pop-window closed" data-popup="olympics_conditions">
        <div class="pop-title">
            Условия поступления по олимпиаде:
            <i class="pop-close js-pop-close"></i>
        </div>
        <div class="single-block">
            <div class="pop-text"></div>
            {{ $speciality->olympics_conditions }}
        </div>
    </div>

    <div class="pop-prof pop-window closed" data-popup="training_profiles">
        <div class="pop-title">
            Возможные профили обучения:
            <i class="pop-close js-pop-close"></i>
        </div>
        <div class="double-block">
            <div class="pop-text"></div>
            <ul class="unstyled-list">
                @foreach ($training_profiles as $l => $lst)
                <li>{{ $lst }}
                    @endforeach
            </ul>
        </div>
    </div>

    <div class="pop-prof pop-window closed" data-popup="basic_disciplines">
        <div class="pop-title">
            Базовые дисциплины:
            <i class="pop-close js-pop-close"></i>
        </div>
        <div class="double-block">
            <div class="pop-text"></div>
            <ul class="unstyled-list">
                @foreach ($basic_disciplines as $l => $lst)
                <li>{{ $lst }}
                    @endforeach
            </ul>
        </div>
    </div>

    <div class="pop-prof pop-window closed" data-popup="professions">
        <div class="pop-title">
            После окончания сможете работать:
            <i class="pop-close js-pop-close"></i>
        </div>
        <div class="double-block">
            <div class="pop-text"></div>
            <ul class="unstyled-list">
                @foreach ($professions as $l => $lst)
                <li>{{ $lst }}
                    @endforeach
            </ul>
        </div>
    </div>

    @include(Helper::layout('_media_popup'), array('mediafiles' => $speciality->mediafiles))

    @include(Helper::layout('_faces_popup'))

</div>
@stop


@section('scripts')

    @include(Helper::layout('_map_script'), array('objects' => $map_objects, 'map_id' => 'dir-map'))

@stop