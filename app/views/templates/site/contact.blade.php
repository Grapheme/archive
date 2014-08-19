@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

    <section class="normal-page">
        <div class="wrapper">
            <h1>Контакты</h1>

            <div class="contacts">

                {{ $page->block('contacts') }}
    
                <div class="btn-cont">
                    <a href="{{ URL::route('page', array('request')) }}" class="us-btn invert">Задать вопрос</a>
                </div>
                <div class="contact-hr"></div>
    
                {{ $page->block('spec') }}

            </div>

        </div>
    </section>

@stop


@section('scripts')
@stop