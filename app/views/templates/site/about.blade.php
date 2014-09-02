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
            	<div class="nav-line"></div>
            </div>

            <ul class="js-tabs list-unstyled">
                <li data-tab="history">{{ $page->block('history') }}
                <li data-tab="structure">{{ $page->block('structure') }}
                <li data-tab="ustav">{{ $page->block('ustav') }}
                <li data-tab="reglament">{{ $page->block('reglament') }}
                <li data-tab="uslugi">{{ $page->block('uslugi') }}
            </ul>

        </div>
    </section>
@stop


@section('scripts')
	<script>$(window).on('load', page_nav.init);</script>
@stop