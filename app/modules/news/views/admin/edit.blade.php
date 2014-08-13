@extends(Helper::acclayout())


@section('style')
<link rel="stylesheet" href="{{ link::path('css/redactor.css') }}" />
@stop


@section('content')

    <?
    #$create_title = "Редактировать " . $module['entity_name'] . ":";
    #$edit_title   = "Добавить " . $module['entity_name'] . ":";
    $create_title = "Изменить новость:";
    $edit_title   = "Новая новость:";

    $url        = @$element->id ? action($module['entity'].'.update', array('id' => $element->id)) : URL::route($module['entity'].'.store', array());
    $method     = @$element->id ? 'PUT' : 'POST';
    $form_title = @$element->id ? $create_title : $edit_title;
    ?>

    @include($module['tpl'].'menu')

	{{ Form::model($element, array('url' => $url, 'class' => 'smart-form', 'id' => $module['entity'].'-form', 'role' => 'form', 'method' => $method)) }}

    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">

                <header>{{ $form_title }}</header>

                <fieldset>

                    <section>
                        <label class="label">
                            Идентификатор новости
                        </label>
                        {{--
                        <label class="note">
                            Может содержать <strong>только</strong> английские буквы в нижнем регистре, цифры, знаки подчеркивания и тире
                        </label>
                        --}}
                        <label class="input">
                            <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('slug') }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Шаблон</label>
                        <label class="input select input-select2">
                            {{ Form::select('template', array('Выберите...')+$templates) }}
                        </label>
                    </section>

                    <section class="col-3 clearfix">
                        <label class="label">Дата публикации:</label>
                        <label class="input">
                            {{ Form::text('published_at', ($element->published_at ? date("d.m.Y", strtotime($element->published_at)) : date("d.m.Y", time())), array('class' => 'datepicker text-center')) }}
                        </label>
                    </section>

                    <section>
                        <div class="widget-body">
                            <ul id="myTab1" class="nav nav-tabs bordered">
                                <? $i = 0; ?>
                                @foreach ($locales as $locale_sign => $locale_name)
                                <li class="{{ !$i++ ? 'active' : '' }}">
                                    <a href="#locale_{{ $locale_sign }}" data-toggle="tab">
                                        {{ $locale_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <div id="myTabContent1" class="tab-content padding-10">
                                <? $i = 0; ?>
                                @foreach ($locales as $locale_sign => $locale_name)
                                <div class="tab-pane fade {{ !$i++ ? 'active in' : '' }}" id="locale_{{ $locale_sign }}">

                                    @include($module['tpl'].'_news_meta', compact('locale_sign', 'locale_name', 'templates', 'element'))

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                </fieldset>

                <footer>
                	<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
                		<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
                	</a>
                	<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
                		<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
                	</button>
                </footer>

            </div>
        </section>
    </div>

    {{ Form::close() }}
@stop


@section('scripts')

    <script>
        var essence = '{{ $module['entity'] }}';
        var essence_name = '{{ $module['entity_name'] }}';
        var validation_rules = {
            //name:              { required: true, maxlength: 100 },
            //photo:             { required: true, minlength: 1 },
            //date:              { required: true, minlength: 10, maxlength: 10 },
        };
        var validation_messages = {
            //name:              { required: "Укажите название", maxlength: "Слишком длинное название" },
            //photo:             { required: "Загрузите фотографию", minlength: "Загрузите фотографию" },
            //date:              { required: "Выберите дату", minlength: "Выберите дату", maxlength: "Выберите дату" },
        };
        //var onsuccess_function = 'update_blocks()';
    </script>

	{{ HTML::script('js/modules/standard.js') }}

	<script src="{{ link::path('js/vendor/jquery.ui.datepicker-ru.js') }}"></script>
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}",runFormValidation);
		}else{
			loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}");
		}
	</script>

    {{ HTML::script('js/plugin/select2/select2.min.js') }}

    {{ HTML::script('js/vendor/redactor.min.js') }}
    {{ HTML::script('js/system/redactor-config.js') }}


@stop