<section id="contacts">
    <div class="container">
        <h2>Контакты и обратная связь</h2>
        <div class="contacts-container">
            <form id="feedback" class="request js-request">
                <input type="hidden" name="action" value="feedback">
                <h3>Форма обратной связи</h3>
                <label for="">
                    Имя
                    <input type="text" name="name" id="feedback_name" required>
                </label>
                <label for="">
                    Телефон
                    <input type="tel" name="phone" id="feedback_phone" required>
                </label>
                <label for="">
                    Почта
                    <input type="email" name="email" id="feedback_email" required>
                </label>
                <button type="submit">
                    Отправить
                    <svg width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 6H23M23 6L18.0714 1M23 6L18.0714 11" stroke="white"/>
                    </svg>
                </button>
                <input type="checkbox" id="feedback_pp" checked required>
                <label for="feedback_pp">Даю согласие на обработку персональных данных</label>
                <div class="form_preloader">
                    <div class="lds-dual-ring"></div>
                </div>
                <div class="form_answer">

                </div>
            </form>
            <div class="acceptance-points-conteiner">
                <div class="acceptance-points">
                    <h3>Пункты приема подарков</h3>
                    <div class="point">
                        <div class="point-img">
                            <img src="<?= get_template_directory_uri() . '/assets/imgs/city.png'?>" alt="">
                        </div>
                        Салехард - МРК «Полярис», (ул. Чубынина, д.17)
                    </div>
                </div>
                <div class="acceptance-points-footer">
                    <a href="#" class="questions">Есть вопрос или предложение?</a>
                    <div class="socials">
                        Мы в соц. сетях:
                        <a href="">
                            <img src="" alt="">
                        </a>
                        <a href="">
                            <img src="" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>