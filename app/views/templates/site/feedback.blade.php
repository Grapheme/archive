@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

        <section class="normal-page">
            <div class="wrapper">
                <h1>Задать вопрос</h1>
                <div class="apply-form">
                    <div class="desc">
                        Ответ придет на Ваш email. Все поля обязательны для заполнения.
                    </div>

                    <p class="response"></p>
                    {{ Form::open(array('url' => URL::route('ajax-send-feedback'), 'class' => '', 'id' => 'feedbackForm', 'role' => 'form', 'method' => 'POST', 'files' => false)) }}

                        <table class="apply-table">
                            <tr>
                                <td>Ф.И.О.</td>
                                <td>
                                    {{ Form::text('name', null, array('class' => 'apply-input')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>
                                    {{ Form::text('email', null, array('class' => 'apply-input')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Текст сообщения</td>
                                <td>
                                    {{ Form::textarea('message', null, array('class' => 'apply-textarea')) }}
                                </td>
                            </tr>
                        </table>
                        <div class="form-container">
                            <button class="us-btn invert">Отправить</button>
                        </div>

                    {{ Form::close() }}

                </div>
            </div>
        </section>


@stop


@section('scripts')
@stop