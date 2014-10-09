@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

    {{ Helper::ta_($page) }}

    <section class="normal-page">
        <div class="wrapper">

            <h1>{{ $page->name }}</h1>

            <div class="margin">
            {{ $page->block('content') }}
            </div>
        </div>
    </section>
@stop


@section('scripts')
	
@stop