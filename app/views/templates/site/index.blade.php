@extends(Helper::layout())


@section('style')
@stop


@section('content')

    {{ $page->block('first') }}


    <section class="index-info">
        <div class="wrapper">
            <div class="left-block">
                <div class="title">Услуги</div>

                {{ $page->block('second') }}

            </div><!--
         --><div class="right-block">
                <div class="title">Новости</div>

                {{ $page->block('last_news') }}

            </div>
        </div>
    </section>


@stop


@section('scripts')

@stop