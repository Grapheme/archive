@extends(Helper::acclayout())


@section('style')
@stop


@section('content')

    <?
    $create_title = "Редактировать " . $module['entity_name'] . ":";
    $edit_title   = "Добавить " . $module['entity_name'] . ":";

    $url        = @$element->id ? URL::route($module['entity'].'.update', array('id' => $element->id)) : URL::route($module['entity'].'.store');
    $method     = @$element->id ? 'PUT' : 'POST';
    $form_title = @$element->id ? $create_title : $edit_title;
    ?>

    @include($module['tpl'].'/menu')

    {{ Form::model($element, array('url'=>$url, 'class'=>'smart-form', 'id'=>$module['entity'].'-form', 'role'=>'form', 'method'=>$method)) }}

    <!-- Fields -->
	<div class="row margin-top-10">

        <!-- Form -->
        <section class="col col-6">
            <div class="well">
                <header>{{ $form_title }}</header>
                <fieldset>

                    {{ Helper::ta_($element) }}

                    <div class="clearfix">

                        <section class="col-3 pull-left">
                            <label class="label">Номер фонда</label>
                            <label class="input">
                                {{ Form::text('fund_number') }}
                            </label>
                        </section>

                        <section class="col-8 pull-right">
                            <label class="label">Тип фонда</label>
                            <label class="input input-select2">
                                {{ Form::select('type_id', array('Выберите...')+Dictionary::whereSlugValues('funds_types')->lists('name', 'id')) }}
                            </label>
                        </section>

                    </div>

                    <section>
                        <label class="label">Название организации</label>
                        <label class="input">
                            {{ Form::text('name') }}
                        </label>
                    </section>

                    <div class="clearfix">

                        <section class="col-5 pull-left">
                            <label class="label">Первая крайняя дата</label>
                            <label class="input">
                                {{ Form::text('date_start', $element->date_start ? DateTime::createFromFormat('Y-m-d', $element->date_start)->format('m.Y') : '') }}
                            </label>
                        </section>

                        <section class="col-5 pull-right">
                            <label class="label">Вторая крайняя дата</label>
                            <label class="input">
                                {{ Form::text('date_stop', $element->date_stop ? DateTime::createFromFormat('Y-m-d', $element->date_stop)->format('m.Y') : '') }}
                            </label>
                        </section>

                    </div>

                    <div class="clearfix">

                        <section class="col-lg-9 pull-left">
                            <label class="label">Нынешнее название (необязательно)</label>
                            <label class="input">
                                {{ Form::hidden('current_company_id', null, array('class' => 'select2-old-name', 'data-name' => is_object($element->current) ? $element->current->name : '')) }}
                            </label>
                        </section>

                        <section class="col-lg-3 pull-right">
                            <label class="label">&nbsp;</label>
                            <label class="input">
                                <input type="button" class="btn btn-primary" id="drop_company_name" value="Сбросить"/>
                            </label>
                        </section>

                    </div>

                </fieldset>

                <footer>
                    <a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{ link::previous() }}">
                        <i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
                    </a>
                    <button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
                        <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
                    </button>
                </footer>

            </div>
        </section>

        @if (isset($element->olds) && is_object($element->olds) && $element->olds->count())
        <section class="col col-6">
            <div class="well">
                <header>Старые названия</header>
                <fieldset>

                    <table class="table table-bordered margin-bottom-10">
                    @foreach ($element->olds as $old)
                    <tr>
                        <td>
                            <a href="{{ action($module['entity'].'.edit', $old->id) }}">{{ $old->name }}</a>
                        </td>
                        <td>
                            @if ($element->date_start > 0)
                            {{ DateTime::createFromFormat('Y-m-d', $element->date_start)->format('m.Y') }}
                            @else
                            ???
                            @endif
                            -
                            @if ($element->date_stop > 0)
                            {{ DateTime::createFromFormat('Y-m-d', $element->date_stop)->format('m.Y') }}
                            @else
                            ???
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </table>

                </fieldset>

            </div>
        </section>
        @endif
        <!-- /Form -->

   	</div>

    @if (!$element->id && 0)
    {{ Form::hidden('redirect', URL::route($module['entity'].'.index', array(), null)) }}
    @endif

    {{ Form::close() }}

@stop


@section('scripts')
    <script>
    var essence = '{{ $module['entity'] }}';
    var essence_name = '{{ $module['entity_name'] }}';
	var validation_rules = {
		fund_number:       { required: true, minlength: 1 },
		name:              { required: true },
	};
	var validation_messages = {
        fund_number:       { required: "Укажите номер фонда", min: "Укажите номер фонда" },
		name:              { required: "Укажите название организации" },
	};
    </script>

	{{ HTML::script('js/modules/standard.js') }}

	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function') {
			loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}", runFormValidation);
		} else {
			loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}");
		}        
	</script>

    {{ HTML::script('js/plugin/select2/select2.min.js') }}
    <script>
    //$(".input-select2 select").css('width', '100%').select2();

        $.when(
            $(".input-select2 select").each(function(i) {
                $(this).css('width', '100%').html(
                    '<option></option>' + $(this).html()
                )
            })
            //.prepend( $('<option></option>') )
        ).then(function(){
            $(".input-select2 select").select2({
                placeholder: "Выберите..."
            });
        });

    </script>

    {{ HTML::script('js/plugin/monthpicker/jquery.mtz.monthpicker.js') }}

    <script>
        options = {
            pattern: 'mm.yyyy', // Default is 'mm/yyyy' and separator char is not mandatory
            selectedYear: {{ date('Y') }},
            startYear: 1900,
            finalYear: {{ date('Y') }},
            monthNames: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек']
        };

        $('[name=date_start]').monthpicker(options);
        $('[name=date_stop]').monthpicker(options);
    </script>
    <style>
        .ui-state-default.mtz-monthpicker.mtz-monthpicker-month {
            color: #aaa;
        }
        .ui-state-default.mtz-monthpicker.mtz-monthpicker-month:hover {
            color: #000;
            cursor: hand;
        }
    </style>
    <script>

        var format = function(bond) {
            return '<option value="' + bond.id + '">' + bond.name + '</option>';
        }

        var select2old = $(".select2-old-name").select2({
            placeholder: "Выберите...",
            minimumInputLength: 3,
            multiple: false,
            width: '100%',
            quietMillis: 100,
            ajax: {
                url: "{{ URL::route('ajax-get-funds-data', array('admin' => 1)) }}",
                dataType: 'json',
                type: 'POST',
                quietMillis: 500,
                data: function (term, page) {
                    //console.log(term);
                    return {
                        filter: term
                    };
                },
                results: function (data, page) { // parse the results into the format expected by Select2.
                    //console.log( jQuery.parseJSON(data.funds) );
                    return { results: jQuery.parseJSON(data.funds) };
                }
            },
            initSelection: function(element, callback) {
                // the input tag has a value attribute preloaded that points to a preselected movie's id
                // this function resolves that id attribute to an object that select2 can render
                // using its formatResult renderer - that way the movie name is shown preselected
                var id = $(element).val();
                if (id !== '') {
                    //alert(id);
                    var obj = {'name': $(element).data('name')}
                    callback(obj);
                }
            },
            formatResult: format,
            formatSelection: format
        });

        $("#drop_company_name").click(function () { $(select2old).select2("val", ""); });

    </script>
@stop