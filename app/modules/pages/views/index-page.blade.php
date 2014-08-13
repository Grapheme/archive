@extends(Helper::layout())


@section('style')
@stop

@section('content')
<?

session_start();
if (Input::get('manifest') == '1') {

    setcookie('manifest', '1', time()+60*60*24*30*12, "/");
    $set = Setting::where('name', 'manifest_count')->first();
    if (is_object($set)) {
        $set->value = $set->value+1;
        $set->save();
    } else {
        Setting::create(array('name' => 'manifest_count', 'value' => 1));
    }

} else {

    if (@$_COOKIE['manifest'] != '1')
        Redirect('/?'.$_SERVER['QUERY_STRING']);

}

/*
$user_photo = UserPhoto::where('approved', 1)->orderBy('updated_at', 'DESC')->first();
if (is_object($user_photo))
    $user_photo->toArray();
*/

$user_photos = UserPhoto::where('approved', 1)->orderBy(DB::raw('RAND()'))->take(Config::get('site.limit_moderated_photos_mainpage'))->get();
#Helper::dd($user_photos);

$instagram = Instagram::where('status', 1)->orderBy(DB::raw('RAND()'))->take(50)->get();

?>
            <main data-bg="1">
                <div class="wrapper" data-arrow="1">
                    <div class="top clearfix">
                        <section class="app app-left">
                            <div id="app" class="app-head fotorama" data-auto="false">
                                @foreach ($instagram as $insta)
                                    <?
                                    $data = json_decode($insta->full, 1); 
                                    ?>
                                    <div>
                                    <a href="{{ $insta->link }}"><img src="{{ $insta->image }}" /></a>
                                    <img class="app-bg" src="{{ $insta->image }}" alt="">
                                    <header><span>{{ $data['user']['full_name'] }}</span></header>
                                    <div class="app-tag"><span>#часстрасти</span></div>
                                    </div>
                                @endforeach
                            </div>                    
                            <footer class="app-footer">
                                <?php
                                $link = 'http://www.mamba.ru/promo/extreme.phtml';
                                if (@$_GET['r'] === 'mail') {
                                    $link = 'http://love.mail.ru/promo/extreme.phtml';
                                } elseif (@$_GET['r'] === 'rambler') {
                                    $link = 'http://love.rambler.ru/promo/extreme.phtml';
                                }
                                ?>
                                <a id="photo__popup" target="_blank" href="<?=$link?>">Приложение</a>
                            </footer>
                        </section>
                        <div class="ice-cream-slider">
                            <h2 class="ice-logo">Extreme</h2>
                            <div class="slide slide-1">
                                <div class="left-splash"></div>
                                <div class="ice-cream"></div>
                                <div class="right-splash"></div>
                            </div>
                            <div class="slide slide-2">
                                <div class="left-splash"></div>
                                <div class="ice-cream"></div>
                                <div class="right-splash"></div>
                            </div>
                            <div class="slide slide-3">
                                <div class="left-splash"></div>
                                <div class="ice-cream"></div>
                                <div class="right-splash"></div>
                            </div>
                            <div class="slide slide-4">
                                <div class="left-splash"></div>
                                <div class="ice-cream"></div>
                                <div class="right-splash"></div>
                            </div>
                            <div class="slide slide-5">
                                <div class="left-splash"></div>
                                <div class="ice-cream"></div>
                                <div class="right-splash"></div>
                            </div>
                            <div class="slide slide-6">
                                <div class="left-splash"></div>
                                <div class="ice-cream"></div>
                                <div class="right-splash"></div>
                            </div>
                            <div class="arrow arrow-left">
                                <span class="icon icon-left-dir"></span>
                            </div>
                            <div class="arrow arrow-right">
                                <span class="icon icon-right-dir"></span>
                            </div>
                            <div class="ice-cream-desc">
                                <div class="desc-slide" data-slide="slide-1">
                                    <div class="ice-cream-head">Клубника</div>
                                    <div class="ice-cream-body">
                                        – клубничные страсти для ярких и темпераментных
                                    </div>
                                </div>
                                <div class="desc-slide" data-slide="slide-2">
                                    <div class="ice-cream-head">Фисташка</div>
                                    <div class="ice-cream-body">
                                        – дразнящая страсть для любителей запретных желаний
                                    </div>
                                </div>
                                <div class="desc-slide" data-slide="slide-3">
                                    <div class="ice-cream-head">Тропик</div>
                                    <div class="ice-cream-body">
                                        – тропические фантазии для тех, кто просыпается вместе
                                    </div>
                                </div>
                                <div class="desc-slide" data-slide="slide-4">
                                    <div class="ice-cream-head">Ямбери</div>
                                    <div class="ice-cream-body">
                                        – страстная экзотика для искателей новых ощущений
                                    </div>
                                </div>
                                <div class="desc-slide" data-slide="slide-5">
                                    <div class="ice-cream-head">Два Шоколада</div>
                                    <div class="ice-cream-body">
                                        – нежная страсть для ценителей традиций
                                    </div>
                                </div>
                                <div class="desc-slide" data-slide="slide-6">
                                    <div class="ice-cream-head">Пломбирно-Ягодный</div>
                                    <div class="ice-cream-body">
                                        – утончённые идеи для элегантных и страстных
                                    </div>
                                </div>
                            </div>                            
                        </div>

                        {{-- LAST MODERATED PHOTO --}}

                        <section class="app app-right">

                            <div class="app-head" id="advices">
                                <section>
                                    <header>Доведите градус своей<br/>страсти до максимума...</header>
                                    <a href="#"></a>
                                    <footer class="app-tag">extreme советы</footer>
                                </section>                              
                            </div>

                            <footer class="app-footer">
                                <a href="/application" target="_blank" onclick="_gaq.push(['_trackEvent', 'app_index_click']);">Приложение</a>
                            </footer>
                        </section>

                        {{-- /LAST MODERATED PHOTO --}}

                    </div>
                    <ul class="bot-links">
                        <li class="bot-link bot-link_m advices">
                            <div id="app2" class="app-head fotorama" data-auto="false">
                                @foreach($user_photos as $photo)
                                    <div class="app-bg" style="background: url({{ Config::get('site.tmp_public_dir') }}/{{ str_replace(" ", "%20", $photo->image) }}) no-repeat center center / cover;">
                                        <!-- <header>{{-- Анна<br>Межиковская --}}</header> -->
                                        <footer class="app-tag">на нашем сайте</footer>
                                    </div>
                                @endforeach                             
                            </div>
                        <li id="bloggers" class="bot-link bot-link_b bloggers">
                            <section>
                                <header>{{ ExtremBloggerAdvice::first()->author }}</header>
                                <a href="#"></a>
                                <footer>extreme блоггеры</footer>
                            </section>
                        <li id="events" class="bot-link bot-link_m events">
                            <section>
                                <header>Ваши твиты с хэштегом #часстрасти</header>
                                <a href="#"></a>
                                <footer>события</footer>
                            </section>
                        
                    </ul>
                    <a style="opacity: 1.0;" class="dropzone select-image" href="javascript:void(0);"><span class="drop-text" onclick="_gaq.push(['_trackEvent', 'upload_index_click']);">Загрузите вашу фотографию</span></a>
                    <footer class="main-footer">
                        <div class="hot-line">
                            <span>горячая линия</span>
                            <a href="tel:+78003470200">8-800-347 02 00</a>
                        </div>

                        <?php if (@$_GET['r'] !== 'mail' && @$_GET['r'] !== 'rambler') : ?>
                        <div class="extreme-vk">
                            <a href="http://vk.com/extremenestle" target="_blank"><span class="icon icon-vkontakte-rect"></span> vk.com/extremenestle</a>
                        </div>
                        <?php endif; ?>

                        <div class="feedback">
                            <a href="mailto:hourofpassion@gmail.com">обратная связь</a>
                        </div>
                    </footer>
                </div>
            </main>
            <div class="help-overlay hidden">
                <div class="popup help-popup hidden" data-popup="7">
                    <div class="popup-head">
                        <div class="mini-logo"></div>
                        <div class="popup-close"></div>
                    </div>
                    <div class="popup-body">
                        <div class="help-screen">
                            
                        </div>
                    </div>
                </div>
            </div>
@stop


@section('scripts')
@stop