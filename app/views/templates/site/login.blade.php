@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

        <section class="normal-page">
            <div class="wrapper">
                <h1>Узнать статус запроса</h1>
                <div class="apply-form">
                    <div class="desc">
                        <p>
                            Чтобы узнать статус, введите ваш email и пароль, который вы получали при отправке запроса.
                        </p>
                    </div>

                    {{-- Hash::check('69b4196b', Hash::make('69b4196b')) --}}

                    {{ Form::open(array('url' => URL::route('login'), 'class' => '', 'id' => 'loginForm', 'role' => 'form', 'method' => 'POST', 'files' => false)) }}

                        <table class="apply-table">
                            <tr>
                                <td>Email</td>
                                <td>
                                    {{ Form::text('email', '', array('class' => 'apply-input')) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Пароль</td>
                                <td>
                                    {{ Form::password('password', array('class' => 'apply-input')) }}
                                </td>
                            </tr>
                        </table>
                        <div class="form-container">
                            <p class="error" style="color:red"></p>
                            <button class="us-btn invert">Войти</button>
                        </div>

                    {{ Form::close() }}

                </div>
            </div>
        </section>

@stop


@section('scripts')
@stop