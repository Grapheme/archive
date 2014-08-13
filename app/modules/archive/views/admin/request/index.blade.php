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
                        <th class="text-center" style="width:100%">Запрос</th>
                        <th class="text-center" style="width:100px">Статус</th>
						<th class="text-center">Действия</th>
					</tr>
				</thead>
				<tbody>
				@foreach($elements as $e => $element)
					<tr>
						<td class="text-center">
						    {{ $e+1 }}
						</td>
						<td>
						    {{ Helper::preview($element->content) }}
						</td>
                        <td class="text-center">
                            {{ $element->status->name }}
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
@stop

