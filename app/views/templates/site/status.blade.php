@extends(Helper::layout())


@section('style')
@stop


@section('footer-class') white-footer @stop


@section('content')

        <section class="normal-page">
            <div class="wrapper">

                <h1>Запросы</h1>

                {{ Form::open(array('url' => URL::route('log-out'), 'class' => 'clearfix', 'id' => 'logoutForm', 'role' => 'form', 'method' => 'POST', 'files' => false)) }}
                <button class="us-btn invert pull-right">Завершить сессию</button>
                {{ Form::close() }}

                @if ($requests->count())

                <ul class="status">

                    @foreach ($requests as $request)
                    {{ Helper::ta_($request) }}
                    <li>
                        <div class="row">
                            <div class="left-td">
                                Статус
                            </div>
                            <div class="right-td status-title">
                                <span class="status-type{{ $request->status->slug ? ' status-type-'.$request->status->slug : '' }}">{{ $request->status->name }}</span>
                                <span class="status-desc">
                                    @if ($request->status->slug == 'new')
                                    ваш запрос будет обработан в сроки обозначенные регламентом,<br>
                                    ожидайте уведомления по электронной почте
                                    @else
                                    {{ $request->comment }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="left-td">
                                Дата
                            </div>
                            <div class="right-td status-date">
                                {{ Helper::rdate('j M Y', $request->created_at) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="left-td">
                                Запрос
                            </div>
                            <div class="right-td statud-text">
                               {{ $request->content }}
                            </div>
                        </div>
                    @endforeach

                </ul>

                @else

                <p>У Вас пока нет отправленных запросов.</p>

                @endif

            </div>
        </section>

@stop


@section('scripts')
@stop