@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

    <section class="normal-page">
        <div class="wrapper">
            <h1>Об архиве</h1>

            <div class="nav-cont">
            	{{ $page->block('menu') }}
            </div>

            {{ $page->block('history') }}
            {{ $page->block('ustav') }}

        </div>
    </section>
@stop


@section('scripts')
	<script>page_nav.init();</script>
@stop