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

                        {{ Form::open(array('url' => URL::route('ajax-get-funds-data'), 'class' => '', 'id' => 'fundsForm', 'role' => 'form', 'method' => 'POST', 'files' => true)) }}

                        <div class="left-block">
                            <div class="search-block">
                                <div class="title">Быстрый поиск</div>
                                <div class="search-body">
                                    <div class="search-cont">
                                       {{ Form::text('filter', '', array('class' => 'fond-input atleastone', 'placeholder' => 'Введите название организации')) }}
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
                                        {{ Form::text('start', '', array('class' => 'slider-input atleastone', 'maxlength' => 4)) }}
                                    </div>
                                    <div class="slider-inputs">
                                        <span>до</span>
                                        {{ Form::text('stop', '', array('class' => 'slider-input atleastone', 'maxlength' => 4)) }}
                                        <a href="#" class="input-cross"></a>
                                    </div>
                                    <!-- <div class="js-slider-bar">
                                        <div class="js-slider-inbar"></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}

                    </div>

                    <div class="ajaxload clearfix hidden" style="margin: 30px; text-align: center">
                        <i class="fa fa-cog fa-5x fa-spin"></i>
                    </div>

                    <table class="fonds-list hidden">
                        <thead>
                            <tr>
                                <td nowrap>Название организации</td>
                                <td nowrap>Крайние даты</td>
                            </tr>
                        </thead>
                        <tbody>
                        @if (0)
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
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

@stop


@section('scripts')
@stop