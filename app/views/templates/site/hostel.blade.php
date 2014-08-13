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
                        <a href="#" class="us-link">{{ DicVal::whereId($university->city)->name }}</a>
                        <span class="crumb-sub">
                            <?
                            $city_university_count = University::where('city', $university->city)->count();
                            ?>
                            {{ $city_university_count }}
                            {{ trans_choice('[1,1] вуз|[2,4] вуза|[5,Inf] вузов', $city_university_count) }}</span>
                    </span>
                    <span class="crumb">
                        <a href="{{ URL::action($CLASS.'@getUniversity', array($university->id), false) }}" class="us-link">{{ $university->name }}</a>
                        <span class="crumb-sub">
                            {{ trans_choice(':count направление|:count направления|:count направлений', $university->specialities->count(), array(), 'ru') }}
                        </span>
                    </span>
                    <span class="crumb">{{ $hostel->name }}</a>
                </div>


                <div class="dir-search-left">


                    @include(Helper::layout('_history'))

                    @include(Helper::layout('_map_block'))

                </div>


                <div class="dir-search-right">
                    <div class="dir-univ">
                        <div class="dir-univ-top js-alldirs" data-block="dir-univ-bottom" data-active="dir-univ">
                            <div class="univ-photo"><img src="{{ $university->get_emblem()->thumb() }}" alt=""></div>
                            <div class="univ-info">
                                <div class="title"><a href="{{ URL::action($CLASS.'@getUniversity', array($university->id), false) }}" class="title-link us-link">{{ $university->name }}</a> (<a href="#" class="us-link not_ready">посмотреть на карте</a>)</div>
                                <div class="desc">{{ $university->fullname }}</div>
                            </div>
                            <div class="univ-dirs-link js-open-allow js-alldirs">
                                <a href="#" class="us-link js-open-allow js-alldirs">Другие общежития в этом вузе <i class="fa fa-caret-right fa-rotate-90"></i></a>
                            </div>
                        </div>
                        <div class="dir-univ-bottom">
                            <div class="univ-dirs">
                                <div class="title-block">
                                    <h2 class="us-title">Общежития в {{ $university->name }}</h2>
                                </div>
                                <ul class="univ-dirs-carts unstyled-list">
                                    @if (count($university->hostels) > 1 || 1)
                                    @foreach ($university->hostels as $host)
                                    <li class="univ-dir-item">
                                        <div class="univ-photo" style="background-image: url({{ $host->get_emblem()->thumb() }})"></div>
                                        <div class="univ-dir-info">
                                            <div class="title"><a href="{{ URL::action($CLASS.'@getHostel', array($host->id)) }}" class="us-link">{{ $host->name }}</a></div>
                                            {{--<div class="desc">Формы обучения: очное, заочное, вечернее</div>--}}

                                            <div class="univ-rating">
                                                <span class="rating">8,3</span>
                                                <span class="univ-ratdesc">
                                                    <span class="rating-word">отлично</span><br>
                                                    <span class="rating-people">по мнению <a href="#" class="us-link">69 пользователей</a></span>
                                                </span>
                                            </div>

                                            <a href="#" class="us-btn">Сохранить</a>
                                        </div>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="about-univ about-campus margin-t150">
                        <div class="direction">
                            <div class="univ-header" style="background-image: url({{ $hostel->get_photo()->full() }});">
                                <div class="liked">
                                    <span class="text not_ready"><b>0</b> пользователей заинтересовались этим общежитием</span>
                                    <!--<div id="vk_like"></div>-->
                                </div>
                            </div>
                            <div class="dir-photo">
                                <div class="dir-photo-in">
                                    <img src="{{ $hostel->get_emblem()->thumb() }}">
                                </div>
                                <span>{{ $university->get_city() }}</span>
                            </div>
                            <div class="direction-in">
                                <div class="title">
                                    <span class="text">
                                        {{ $hostel->name }}
                                        <span class="medium-text">(<a href="#" class="us-link">{{ $hostel->address }}</a>)</span>
                                    </span>
                                    <div class="btn-cont">
                                        <a href="#" class="us-btn not_ready">Сохранить</a>
                                    </div>
                                </div>
                                <div>
                                    <div class="dirb-left">
                                        <div class="direction-info">
                                            <div class="dir-row">
                                                <span>Тип:</span><span>{{ DicVal::whereId($hostel->type)->name }}</span>
                                            </div>
                                            @if ($hostel->metro)
                                            <div class="dir-row">
                                                <span>Метро:</span><span><a href="#" class="us-link">{{ DicVal::whereId($hostel->metro)->name }}</a></span>
                                            </div>
                                            @endif
                                            @if ($hostel->metro_distance)
                                            <div class="dir-row">
                                                <span>Расстояние от метро:</span><span>{{ $hostel->metro_distance }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="direction-sub">
                                            {{ $hostel->desc }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dblock-hr"></div>
                        <div>
                            <div class="four-block">
                                <div class="margin-b5">Стоимость:</div>
                                <ul class="unstyled-list">
                                    <li>бюджет — {{ $hostel->budget_price }} руб. в месяц
                                    <li>контракт — {{ $hostel->contract_price }} руб. в месяц
                                </ul>
                            </div><!--
                            @if ($hostel->people_per_room != '' || $hostel->people_reside != '')
                         --><div class="four-block">
                                <div class="margin-b5">Проживание:</div>
                                <ul class="unstyled-list">
                                    @if ($hostel->people_per_room != '')
                                    <li>человек в комнате — {{ $hostel->people_per_room }}
                                    @endif
                                    @if ($hostel->people_reside != '')
                                    <li>проживают — {{ $hostel->people_reside }}
                                    @endif
                                </ul>
                            </div><!--
                            @endif
                            @if ($hostel->building_access != '')
                         --><div class="four-block">
                                <div class="margin-b5">Доступ в общежитие:</div>
                                    {{ Helper::nl2br($hostel->building_access) }}
                            </div><!--
                            @endif
                            @if ($hostel->building_info != '')
                         --><div class="four-block">
                                <div class="margin-b5">Здание:</div>
                                    {{ Helper::nl2br($hostel->building_info) }}
                            </div>
                            @endif
                        </div>

                        <div class="dblock-hr"></div>

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
                                            <span class="title-text">Студент <a href="#" class="us-link js-user-tooltip">Иван Петров</a> написал сегодня:</span>
                                        </div>
                                        <div class="desc">
                                            Механическая система, как следует из системы уравнений, вращает установившийся режим, составляя уравнения Эйлера для этой системы координат. Прецессионная теория различна.
                                        </div>
                                        <div class="bottom-block">
                                            <a href="#" class="us-link fl-l">Все отзывы</a>
                                            <a href="#" class="us-link fl-l">Добавить отзыв</a>
                                            <span class="fl-r">
                                                <a href="#" class="feed-like us-link js-like" data-thumbs="down" data-likes="120">
                                                    Не нравится <i class="fa fa-thumbs-down"></i>120
                                                </a>
                                                <a href="#" class="feed-like us-link js-like" data-thumbs="up" data-likes="14">
                                                    Нравится <i class="fa fa-thumbs-up"></i>14
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dblock-hr"></div>


                        @include(Helper::layout('_media_block'), array('mediafiles' => $hostel->mediafiles, 'link' => '#'))


                        <div class="dblock-hr"></div>

                        <div class="padding-20 not_ready">
                            <table class="educ-table">
                                <thead>
                                    <th>Направления</th>
                                    <th>Корпус</th>
                                    <th>Адрес</th>
                                    <th>Транспорт</th>
                                    <th>Время в пути</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Экономика</td>
                                        <td>1</td>
                                        <td><a href="#" class="us-link">ул. Куйбышева, 1</a></td>
                                        <td>метро, трамвай</td>
                                        <td>1 час 15 мин.</td>
                                    </tr>
                                    <tr>
                                        <td>Экономика</td>
                                        <td>1</td>
                                        <td><a href="#" class="us-link">ул. Куйбышева, 1</a></td>
                                        <td>метро, трамвай</td>
                                        <td>1 час 15 мин.</td>
                                    </tr>
                                    <tr>
                                        <td>Экономика</td>
                                        <td>1</td>
                                        <td><a href="#" class="us-link">ул. Куйбышева, 1</a></td>
                                        <td>метро, трамвай</td>
                                        <td>1 час 15 мин.</td>
                                    </tr>
                                    <tr>
                                        <td>Экономика</td>
                                        <td>1</td>
                                        <td><a href="#" class="us-link">ул. Куйбышева, 1</a></td>
                                        <td>метро, трамвай</td>
                                        <td>1 час 15 мин.</td>
                                    </tr>
                                    <tr>
                                        <td>Экономика</td>
                                        <td>1</td>
                                        <td><a href="#" class="us-link">ул. Куйбышева, 1</a></td>
                                        <td>метро, трамвай</td>
                                        <td>1 час 15 мин.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </main>

@stop



@section('overlays')

<div class="overlay">

    <div class="pop-prof pop-window closed" data-popup="training_profiles">
        <div class="pop-title">
            Возможные профили обучения:
            <i class="pop-close js-pop-close"></i>
        </div>
        <div class="double-block">
            <div class="pop-text"></div>
            <ul class="unstyled-list">
                @foreach (array() as $l => $lst)
                <li>{{ $lst }}
                @endforeach
            </ul>
        </div>
    </div>

    @include(Helper::layout('_media_popup'), array('mediafiles' => $hostel->mediafiles))

</div>
@stop



@section('scripts')

    @include(Helper::layout('_map_script'), array('objects' => $map_objects, 'map_id' => 'dir-map', 'center' => array('lat' => $hostel->lat, 'lng' => $hostel->lng)))

@stop