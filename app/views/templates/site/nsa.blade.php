@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

    <section class="normal-page">
        <div class="wrapper">
            {{ $page->block('content') }}
        </div>
    </section>
@stop


@section('scripts')
	
@stop