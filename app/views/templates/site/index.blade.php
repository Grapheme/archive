@extends(Helper::layout())


@section('style')
@stop


@section('content')


    <section class="index-block">
        <div class="wrapper">

            {{ $page->block('first') }}

            <div class="btns">
                <a href="{{ URL::route('page', 'request') }}" class="us-btn">Подать запрос</a>
            </div>
        </div>
    </section>


    <section class="index-info">
        <div class="wrapper">
            <div class="left-block">
                <a href="{{ URL::to('about#uslugi') }}" class="title">Государственные услуги</a>

                {{ $page->block('second') }}

            </div><!--
         --><div class="right-block">
                <a href="{{ URL::to('news') }}" class="title">Новости</a>

                {{ $page->block('last_news') }}

            </div>
        </div>
    </section>


@stop


@section('scripts')

@stop