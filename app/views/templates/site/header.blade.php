<?
$route = Route::currentRouteName();
#Helper::dd($page);
?>

        <header class="main-header">
            <div class="wrapper">
                <div class="header-logo">
                    <a href="{{ URL::to('') }}" class="logo"></a>
                    <a href="{{ URL::to('') }}" class="text">
                        ГКУ РО «Архив документов личного состава по Ростовской Области»
                    </a>
                </div>
                <div class="header-block">
                    <div class="apply-div clearfix">
                        <a href="{{ URL::route('log-in') }}">Проверить статус запроса</a>
                    </div>
                    <div class="header-menu">

                        {{ Form::open(array('url' => URL::route('page', 'search'), 'class' => '', 'id' => 'searchForm', 'role' => 'form', 'method' => 'GET', 'files' => false)) }}

                            <div class="nav-block">
                                <nav class="main-nav">
                                    <ul>
                                    	<li{{ $route == 'page' && $page->slug == 'requests' ? ' class="active"' : '' }}><a href="{{ URL::route('page', array('')) }}">Главная</a>
                                        <li{{ $route == 'page' && $page->slug == 'requests' ? ' class="active"' : '' }}><a href="{{ URL::route('page', array('requests')) }}">Запросы</a>
                                        <li{{ $route == 'page' && $page->slug == 'fonds' ? ' class="active"' : '' }}><a href="{{ URL::route('page', array('fonds')) }}">Фонды</a>
                                        {{--
                                        <li><a href="#">НСА</a>
                                        <li><a href="#">Комплектация</a>
                                        --}}
                                        <li{{ $route == 'news' ? ' class="active"' : '' }}><a href="{{ URL::route('news') }}">Новости</a>
                                        <li{{ $route == 'page' && $page->slug == 'about' ? ' class="active"' : '' }}><a href="{{ URL::route('page', array('about')) }}">Об архиве</a>
                                        <li{{ $route == 'page' && $page->slug == 'contact' ? ' class="active"' : '' }}><a href="{{ URL::route('page', array('contact')) }}">Контакты</a>
                                    </ul>
                                </nav>
                                <div class="search-anim">
                                    <div class="search-cont">
                                        <div class="header-search">
                                            <input type="text" class="header-input" name="s" placeholder="Введите ваш запрос">
                                            <a href="#" class="menu-icon"><span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <button type="submit" class="search-icon"><i class="fa fa-search"></i></button>

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </header>
