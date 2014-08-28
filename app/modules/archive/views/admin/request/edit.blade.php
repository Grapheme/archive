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

                    <section>
                        <label class="label">Тип</label>
                        <label class="input input-select2">
                            {{ Form::select('type', array('Выберите...')+Dictionary::whereSlugValues('request_types')->lists('name', 'id')) }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Текст запроса</label>
                        <label class="textarea">
                            {{ Form::textarea('content', null, array('disabled' => $element->content && 0 ? 'disabled' : NULL)) }}
                        </label>
                    </section>

                    <section class="clearfix">
                    @if ($element->file_passport)
                        <a href="{{ URL::to($element->file_passport) }}" class="btn btn-primary" target="_blank">
                            <i class="fa fa-save"></i>
                            Копия паспорта
                        </a>
                    @endif

                    @if ($element->file_workbook)
                        <a href="{{ URL::to($element->file_workbook) }}" class="btn btn-primary" target="_blank">
                            <i class="fa fa-save"></i>
                            Копия трудовой книжки
                        </a>
                    @endif

                    @if ($element->file)
                        <a href="{{ URL::to($element->file) }}" class="btn btn-primary" target="_blank">
                            <i class="fa fa-save"></i>
                            Прикрепленный файл
                        </a>
                    @endif
                    </section>

                    @if ($element->postal)
                    <section class="clearfix">
                        <label class="label">Почтовый адрес</label>
                        <label class="label"><strong>{{ $element->postal }}</strong></label>
                    </section>
                    @endif

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
        <!-- /Form -->

        @if ($element->id)
        <section class="col col-6">
            <div class="well">
                <header>История статусов</header>
                <fieldset>

                    <table class="table table-bordered margin-bottom-10">
                        <thead>
                        <th>Статус</th>
                        <th>Дата</th>
                        </thead>
                        <tbody>
                        @foreach ($element->statuses as $s => $status)
                        <tr{{ !$s ? ' class="success"' : '' }}>
                            <td>
                                {{ $status->status->name }}
                            </td>
                            <td>{{ $status->created_at->format('H:i d.m.Y') }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </fieldset>

                <fieldset class="margin-bottom-10">
                    <label class="label">Изменить статус</label>
                    <label class="input input-select2 margin-bottom-10">
                        {{ Form::select('status_id', Dictionary::whereSlugValues('request_statuses')->lists('name', 'id'), @$element->statuses[0]->status_id) }}
                    </label>

                    <div class="alert alert-info fade in padding-10 margin-bottom-10">
                        <i class="fa-fw fa fa-info"></i>
                        <strong>Внимение!</strong><br/>
                        Пользователь получит сообщение об изменении статуса.
                    </div>

                </fieldset>

                @if ($element->content)
                <fieldset>

                    <section>
                        <label class="label">Коментарий к запросу</label>
                        <label class="input textarea">
                            {{ Form::textarea('comment', null, array('rows' => 4)) }}
                        </label>
                    </section>

                </fieldset>
                @endif

            </div>
        </section>
        @endif

   	</div>

    @if (!$element->id)
    {{ Form::hidden('redirect', URL::route($module['entity'].'.index', array(), null)) }}
    @endif

    {{ Form::close() }}

@stop


@section('scripts')
    <script>
    var essence = '{{ $module['entity'] }}';
    var essence_name = '{{ $module['entity_name'] }}';
	var validation_rules = {
		type:              { required: true, min: 1 },
		content:           { required: true },
	};
	var validation_messages = {
		type:              { required: "Укажите тип", min: "Укажите тип" },
		content:           { required: "Укажите текст запроса" },
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

    {{ HTML::script('js/modules/gallery.js') }}

@stop