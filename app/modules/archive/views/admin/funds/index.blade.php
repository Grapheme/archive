@extends(Helper::acclayout())


@section('content')

    @include($module['tpl'].'/menu')

	@if($count = @$elements->count())
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<table class="table table-striped table-bordered min-table">
				<thead>
					<tr>
						<th class="text-center" style="width:40px">#</th>
                        <th class="text-center" style="width:100%">Организация</th>
                        <th class="text-center" style="width:150px">Фонд</th>
						<th class="text-center">Действия</th>
					</tr>
				</thead>
				<tbody>
				@foreach($elements as $e => $element)
                    {{ Helper::dd_($element) }}
					<tr class="{{ $element->parsed || ($element->date_start > 0 || $element->date_stop > 0) ? '' : 'warning' }}">
						<td class="text-center">
						    {{ $e+1 }}
						</td>
						<td>
						    {{ Helper::preview($element->name) }}
                            <br/>
                            <span style="color:#aaa; font-size:small">
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
                            </span>
						</td>
                        <td class="text-center">
                            {{ $element->fund_number }}
                        </td>
						<td class="text-center" style="white-space:nowrap">

        					@if(Allow::action($module['group'], $module['entity'].'_edit'))

                            <div class="btn-group margin-right-10">
                                <a href="{{ URL::route($module['entity'].'.edit', array('id' => $element->id)) }}" class="btn btn-success">
                                    Изменить
                                </a>
                            </div>

							<form method="POST" action="{{ URL::route($module['entity'].'.destroy', array('id' => $element->id)) }}" style="display:inline-block">
								<button type="submit" class="btn btn-danger remove-{{ $module['entity'] }}">
									Удалить
								</button>
							</form>

                    		@endif

						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

    {{ $elements->links() }}

	@else
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="ajax-notifications custom">
				<div class="alert alert-transparent">
					<h4>Список пуст</h4>
				</div>
			</div>
		</div>
	</div>
	@endif
@stop


@section('scripts')
    <script>
    var essence = '{{ $module['entity'] }}';
    var essence_name = '{{ $module['entity_name'] }}';
	var validation_rules = {
		name: { required: true }
	};
	var validation_messages = {
		name: { required: 'Укажите название' }
	};
    </script>

	{{ HTML::script('js/modules/standard.js') }}

	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}", runFormValidation);
		}else{
			loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}");
		}
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

        $(document).ready(function(){
            $('[name=date_start]').monthpicker(options);
            $('[name=date_stop]').monthpicker(options);
        });
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

@stop

