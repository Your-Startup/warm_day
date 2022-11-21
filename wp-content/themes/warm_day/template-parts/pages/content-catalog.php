<section id="catalog">
    <div class="container">
        <h1>Каталог подарков</h1>
        <form class="filters">
            <div class="filters-col">
                <input type="checkbox" name="material" id="material">
                <label for="material">Материальные подарки</label>
                <input type="checkbox" name="no_material" id="no_material">
                <label for="no_material">Нематериальные подарки</label>
            </div>
            <div class="filters-col">
                <input type="checkbox" name="booked" id="booked">
                <label for="booked">Забронированные подарки</label>
                <input type="checkbox" name="free" id="free">
                <label for="free">Свободные подарки</label>
                <input type="checkbox" name="all" id="all">
                <label for="all">Все подарки</label>
            </div>
            <div class="filters-col">
                <div class="select">
                    <div class="select-header">
                        <svg width="16" height="7" viewBox="0 0 16 7" class="select-arrow"  fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 0.75L8.09821 6L15 0.75" stroke="#4A4A4A" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Категории получателей
                    </div>
                    <div class="select-list">
                        <input type="checkbox" name="name_category1" id="name_category1">
                        <label for="name_category1">Категория Категория 1Категория 1</label>
                        <input type="checkbox" name="name_category2" id="name_category2">
                        <label for="name_category2">Категория 2</label>
                        <input type="checkbox" name="name_category3" id="name_category3">
                        <label for="name_category3">Категория 3</label>
                        <input type="checkbox" name="name_category4" id="name_category4">
                        <label for="name_category4">Категория 4</label>
                        <input type="checkbox" name="name_category5" id="name_category5">
                        <label for="name_category5">Категория 5</label>
                        <input type="checkbox" name="name_category6" id="name_category6">
                        <label for="name_category6">Категория 6</label>
                        <input type="checkbox" name="name_category7" id="name_category7">
                        <label for="name_category7">Категория 7</label>
                    </div>
                </div>
            </div>
            <div class="filters-col">
                <button type="submit" class="js-drop-filters" disabled>
                    Сбросить фильтры
                </button>
                <button type="submit">
                    Применить фильтры
                </button>
            </div>
        </form>
        <div class="gift-container">
            <div class="gift-list">

                <div class="gift">
                    <img class="gift-img" src="<?= get_template_directory_uri() . '/assets/imgs/man.png'?>" alt="">
                    <div class="gift-info">
                        <div class="gift-title">
                            Паша, 8 лет<br>
                            город
                        </div>
                        <div class="gift-text">
                            Благотворительная акция «Тёплый день» проводится в каждом муниципальном образовании ЯНАО с 2014 года по инициативе Молодёжного правительства Ямало-Ненецкого автономного округа.
                        </div>
                        <div class="gift-ordered">
                            Подарок забронировал<br>
                            Алексей Игоревич о.
                        </div>
                    </div>
                </div>
                <div class="gift">
                    <img class="gift-img" src="<?= get_template_directory_uri() . '/assets/imgs/man.png'?>" alt="">
                    <div class="gift-info">
                        <div class="gift-title">
                            Паша, 8 лет<br>
                            город
                        </div>
                        <div class="gift-text">
                            Благотворительная акция «Тёплый день» проводится в каждом муниципальном образовании ЯНАО с 2014 года по инициативе Молодёжного правительства Ямало-Ненецкого автономного округа.
                        </div>
                        <div class="gift-ordered">
                            Подарок забронировал<br>
                            Алексей Игоревич о.
                        </div>
                    </div>
                </div>
                <div class="gift">
                    <img class="gift-img" src="<?= get_template_directory_uri() . '/assets/imgs/man.png'?>" alt="">
                    <div class="gift-info">
                        <div class="gift-title">
                            Паша, 8 лет<br>
                            город
                        </div>
                        <div class="gift-text">
                            Благотворительная акция «Тёплый день» проводится в каждом муниципальном образовании ЯНАО с 2014 года по инициативе Молодёжного правительства Ямало-Ненецкого автономного округа.
                        </div>
                        <div class="gift-ordered">
                            Подарок забронировал<br>
                            Алексей Игоревич о.
                        </div>
                    </div>
                </div>
                <div class="gift">
                    <img class="gift-img" src="<?= get_template_directory_uri() . '/assets/imgs/man.png'?>" alt="">
                    <div class="gift-info">
                        <div class="gift-title">
                            Паша, 8 лет<br>
                            город
                        </div>
                        <div class="gift-text">
                            Благотворительная акция «Тёплый день» проводится в каждом муниципальном образовании ЯНАО с 2014 года по инициативе Молодёжного правительства Ямало-Ненецкого автономного округа.
                        </div>
                        <div class="gift-ordered">
                            Подарок забронировал<br>
                            Алексей Игоревич о.
                        </div>
                    </div>
                </div>


            </div>
            <div class="gift-pagination">
                    1
                <a href="#">
                    2
                </a>
                <a href="#">
                    3
                </a>
                <a href="#">
                    следующая
                </a>
            </div>
            <div class="gift-preloader">
                <div class="lds-dual-ring"></div>
            </div>
        </div>
        
    </div>
</section>