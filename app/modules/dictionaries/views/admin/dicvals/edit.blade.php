@extends(Helper::acclayout())


@section('style')
@stop


@section('content')

    <?
    $create_title = "Редактировать запись:";
    $edit_title   = "Добавить запись:";

    $url        = 
        @$element->id
        ? action('dicval.update', array('dic_id' => $dic->id, 'id' => $element->id))
        : action('dicval.store', array('dic_id' => $dic->id));
    $method     = @$element->id ? 'PUT' : 'POST';
    $form_title = @$element->id ? $create_title : $edit_title;
    ?>

    @include($module['tpl'].'/menu')

    {{ Form::model($element, array('url'=>$url, 'class'=>'smart-form', 'id'=>$module['entity'].'-form', 'role'=>'form', 'method'=>$method)) }}

    <!-- Fields -->
	<div class="row">

        <!-- Form -->
        <section class="col col-6">
            <div class="well">
                <header>{{ $form_title }}</header>
                <fieldset>

                    <section>
                        <label class="label">Системное имя (необязательно)</label>
                        <label class="input">
                            {{ Form::text('slug', null, array()) }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Название</label>
                        <label class="input">
                            {{ Form::text('name', null, array()) }}
                        </label>
                    </section>

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
   	</div>

    @if(@$element->id)
    @else
    {{ Form::hidden('redirect', action('dicval.index', array('dic_id' => $dic->id))) }}
    @endif

    {{ Form::close() }}

@stop


@section('scripts')
    <script>
    var essence = '{{ $module['entity'] }}';
    var essence_name = '{{ $module['entity_name'] }}';
	var validation_rules = {
		name:              { required: true },
	};
	var validation_messages = {
		name:              { required: "Укажите название" },
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

@stop