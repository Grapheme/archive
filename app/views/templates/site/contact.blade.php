@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

    <section class="normal-page">
        <div class="wrapper">
            <h1>Контакты</h1>

            {{ $page->block('content') }}

        </div>
    </section>

@stop


@section('scripts')
@stop