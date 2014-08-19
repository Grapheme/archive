@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

        <section class="normal-page">
            <div class="wrapper">
                <h1>Фонды</h1>
                <div class="fonds">
                    <div class="fonds-blocks">
                        <div class="left-block">
                            <div class="search-block">
                                <div class="title">Быстрый поиск</div>
                                <div class="search-body">
                                    <div class="search-cont">
                                        <input type="text" class="fond-input" placeholder="Введите название организации">
                                        <a href="#" class="input-cross"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="search-amount hidden">
                                Всего: <span><span class='founded_count'>7</span> фондов</span>
                            </div>
                        </div><!--
                     --><div class="right-block">
                            <div class="search-block">
                                <div class="title">Временной диапазон</div>
                                <div class="search-body">
                                    <div class="slider-inputs">
                                        <span>от</span>
                                        <input type="text" class="slider-input">
                                    </div>
                                    <div class="slider-inputs">
                                        <span>до</span>
                                        <input type="text" class="slider-input">
                                        <a href="#" class="input-cross"></a>
                                    </div>
                                    <!-- <div class="js-slider-bar">
                                        <div class="js-slider-inbar"></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="fonds-list hidden">
                        <thead>
                            <tr>
                                <td>Название организации</td>
                                <td>Крайние даты</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Областной земельный отдел</td>
                                <td>1780-1917</td>
                            </tr>
                            <tr>
                                <td>Областной земельный отдел</td>
                                <td>1780-1917</td>
                            </tr>
                            <tr>
                                <td>Областной земельный отдел</td>
                                <td>1780-1917</td>
                            </tr>
                            <tr>
                                <td>Областной земельный отдел</td>
                                <td>1780-1917</td>
                            </tr>
                            <tr>
                                <td>Областной земельный отдел</td>
                                <td>1780-1917</td>
                            </tr>
                            <tr>
                                <td>Областной земельный отдел</td>
                                <td>1780-1917</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

@stop


@section('scripts')
@stop