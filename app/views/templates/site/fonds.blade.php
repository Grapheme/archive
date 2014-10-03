@extends(Helper::layout())


@section('style')
    {{ HTML::style('css/jquery-ui.css') }}
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
                                       {{ Form::text('filter', Input::get('s'), array('class' => 'fond-input atleastone', 'placeholder' => 'Введите название организации')) }}
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
                                        {{ Form::text('start', '', array('class' => 'slider-input atleastone', 'id' => 'slider-from', 'maxlength' => 4)) }}
                                    </div>
                                    <div class="slider-inputs">
                                        <span>до</span>
                                        {{ Form::text('stop', '', array('class' => 'slider-input atleastone', 'id' => 'slider-to', 'maxlength' => 4)) }}
                                        <a href="#" class="input-cross"></a>
                                    </div>
                                </div>
                                <div class="slider-cont">
                                    <div id="slider-range"></div>
                                    <div class="fonds-ranges">
                                        <span></span><span class="fl-r"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}

                    </div>

                    <div class="ajaxload clearfix hidden" style="margin: 30px; text-align: center">
                        <i class="fa fa-refresh fa-2x fa-spin" style="color:#005CAD"></i>
                    </div>

                    <div class="fonds-list hidden js-sort-parent" data-sort="org" data-sort-type="asc">
                        <div class="thead">
                                <span class="js-sort" data-sort="number">Номер фонда</span><!--
                                --><span class="js-sort" data-sort="org">Название организации</span><!--
                                --><span>Крайние даты</span>
                        </div>
                        <div class="tbody">
                        @if (0)
                            <tr>
                                <td>Областной земельный отдел</td>
                                <td>1780-1917</td>
                            </tr>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

@stop


@section('scripts')
{{ HTML::script('js/vendor/jquery-ui.min.js') }}
<script>
    //fundsFormSubmit($('#fundsForm'));
    var uislider = (function() {
        var maximum = new Date().getFullYear();
        var minimum = 1900;
        // Минимальное и максимальное значения

        var default_min = {{ Input::get('s') ? 1900 : 1985 }};
        var default_max = {{ Input::get('s') ? date('Y') : 2005 }};
        // Значения которые подставляются при загрузке страницы

        $( "#slider-range" ).slider({
            range: true,
            min: minimum,
            max: maximum,
            values: [ default_min, default_max ],
            slide: function(event, ui) {
                $("#slider-from").val(ui.values[0]);
                $("#slider-to").val(ui.values[1]);
            },
            change: function() {
                $(document).trigger('fonds::change');
            },
            create: function(event, ui) {
                $("#slider-from").val(default_min);
                $("#slider-to").val(default_max);
                $('.fonds-ranges span').eq(0).text(minimum);
                $('.fonds-ranges span').eq(1).text(maximum);
                $('.slider-inputs').parent().find('.input-cross').addClass('active');
                $(document).trigger('fonds::change');
            }
        });

    })();

    var sort_init = (function(){
        $('.js-sort').css('cursor', 'pointer');

        $(document).on('click', function(){
            $(document).trigger('fonds::change');
        });
    })();
</script>
@stop