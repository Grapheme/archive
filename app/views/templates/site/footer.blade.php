
    <footer>
        <div class="wrapper">
            <div class="fl-l"><a href="#" class="us-link">Достоверность информации</a></div>
            <div class="fl-r">
                <a href="#" class="soc-vk"><i class="fa fa-vk"></i></a>
                <a href="#" class="soc-tw"><i class="fa fa-twitter"></i></a>
            </div>
            <div class="ftr-center">
                <div>© «Гид по вузам». Все права защищены.</div>
                <div>
                    <a href="#" class="us-link">О проекте</a>,
                    <a href="{{ URL::action($CLASS.'@getFaq') }}" class="us-link">Часто задаваемые вопросы</a>,
                    <a href="#" class="us-link">Служба поддержки клиентов</a>.
                </div>
            </div>
        </div>
    </footer>

    <div class="overlay">
        <div class="pop-feedback pop-window closed" data-popup="feedback">
            <div class="pop-title">
                Ваш отзыв о сайте
                <i class="pop-close js-pop-close"></i>
            </div>
            <form>
                <input type="hidden" class="rating-input" name="rating">
                <input type="hidden" class="subject-input" name="subject">
                <div class="pop-text">Все ли нравится вам на этой странице?</div>
                <div class="rating-block">
                    <div class="feed-rating">
                        <i class="rating-num">1</i>
                        <i class="rating-num">2</i>
                        <i class="rating-num">3</i>
                        <i class="rating-num">4</i>
                        <i class="rating-num">5</i>
                    </div>
                </div>
                <div class="pop-text">Выберите тему вашего обращения:</div>
                <div class="quest-block">
                    <span class="quest-type" data-value="search-navigation">Поиск и навигация</span>
                    <span class="quest-type" data-value="univ-information">Информация о вузе</span>
                    <span class="quest-type" data-value="technical">Технический вопрос</span>
                    <span class="quest-type active">Другое</span>
                </div>
                <textarea class="feedback-area" placeholder="Ваше сообщение" name="message"></textarea>
                <div class="btns-block fl-r">
                    <button class="us-btn btn-cancel js-pop-close">Отмена</button>
                    <button class="us-btn">Отправить</button>
                </div>
            </form>
        </div>
    </div>

