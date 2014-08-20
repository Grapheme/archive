@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

        <section class="normal-page">
            <div class="wrapper">
                <h1>Запросы</h1>
                <div class="applies">

                    <div class="nav-cont">
                        {{ $page->block('menu') }}
                        <div class="nav-line"></div>
                    </div>

                    <ul class="apply-list js-tabs">
                        
                        {{ $page->block('main') }}
                        {{ $page->block('social') }}
                        {{ $page->block('tematic') }}

                    </ul>
                </div><!--
             --><div class="applies-right">
                    <a href="{{ URL::route('page', 'request') }}" class="us-btn invert">Подать запрос</a>
                    <div class="desc">

                        {{ $page->block('desc') }}

                    </div>
                </div>
            </div>
        </section>
@stop


@section('scripts')
    <script>$(window).on('load', page_nav.init);</script>
@stop