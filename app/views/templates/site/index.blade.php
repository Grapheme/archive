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