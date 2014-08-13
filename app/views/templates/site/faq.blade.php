@extends(Helper::layout())


@section('content')

<main class="wrapper-full">
    <div class="faq-top">
        <div class="wrapper">
            <div class="faq-top-in">
                <div class="faq-top-text">Здесь вы можете узнать ответы на вопросы о сайте</div>
                <div class="faq-icons">
                    <i class="fa fa-camera"></i>
                    <i class="fa fa-plus"></i>
                    <i class="fa fa-user"></i>
                    <i class="fa fa-cog"></i>
                    <i class="fa fa-pencil-square-o"></i>
                    <i class="chat-icon"></i>
                    <i class="fa fa-check"></i>
                    <i class="fa fa-envelope"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">

        <div class="block-left">
            <div class="title-block">
                <h3 class="us-title">Задать вопрос о техподдержке:</h3>
            </div>
            <form action="{{ URL::action($CLASS.'@postAjaxSendMessage') }}" method="POST" class="faq-form">

                <div class="input-title">Тема сообщения</div>
                <select class="faq-select" name="subject">
                    <option value="">Выберите</option>
                    <option value="review">Отзыв о сайте</option>
                    <option value="question">Вопрос</option>
                    <option value="other">Другое</option>
                </select>
                <span class="error error-subject hidden">Выберите тему сообщения</span>

                <div class="input-title">Ваша электронная почта для связи:</div>
                <input type="text" name="email" class="faq-input" value="{{ Helper::cookie_get('email') }}" placeholder="mail@gmail.com">
                <span class="error error-email hidden">Введите корректный адрес электронной почты</span>

                <div class="input-title">Ваш текст:</div>
                <textarea class="faq-textarea" name="message" placeholder="Все направления"></textarea>
                <span class="error error-message hidden">Введите сообщение</span>

                <button class="us-btn fl-r faq-submit"><i class="fa fa-gear fa-spin"></i> Отправить</button>
            </form>
            <div class="send-result hidden">
                <span class="success bold">Сообщение успешно отправлено.</span>
                <span class="error bold">Ошибка при отправке сообщения. Попробуйте повторить позднее.</span>
            </div>
        </div>

        <div class="block-right">
            <div class="title-block">
                <h3 class="us-title">Найти ответ самостоятельно</h3>
            </div>
            @if (count($faq))
            @foreach ($faq as $category)
            <div class="faq-block">
                <div class="faq-title">{{ $category->name }}</div>
                <ul class="faq-quests unstyled-list">
                    @if (count($category->questions))
                    @foreach ($category->questions as $question)
                    <li class="faq-quest">
                        <a href="#" class="us-link faq-link">{{ $question->name }}</a>
                        <div class="faq-answer" style="display: none">
                            {{ $question->answer }}
                        </div>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            @endforeach
            @endif
        </div>

    </div>
    <div class="clearfix">
</main>

@stop



@section('scripts')

@stop