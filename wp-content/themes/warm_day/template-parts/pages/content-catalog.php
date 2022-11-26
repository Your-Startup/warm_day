<?php 
global $current_city; 

$gifts = [];
$categories = [];

if ($current_city) {
    $gifts      = getGifts(['city' => $current_city->ID]);
    $categories = getAllCategories();
}
?>

<section id="catalog">
    <div class="container">
        <h1>Каталог подарков</h1>
        <form class="filters">
            <input type="hidden" name="page" value="1">
            <input type="hidden" name="city" value="<?= $current_city->ID ?>">
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
            <?php if ($categories) : ?>
                <div class="filters-col">
                    <div class="select">
                        <div class="select-header">
                            <svg width="16" height="7" viewBox="0 0 16 7" class="select-arrow"  fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 0.75L8.09821 6L15 0.75" stroke="#4A4A4A" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Категории получателей
                        </div>
                        <div class="select-list">
                            <?php foreach ($categories as $key => $category) : ?>
                                <input type="checkbox" name="gift-categories[]" id="name_category_<?= $category->term_id ?>" value="<?= $category->slug ?>">
                                <label for="name_category_<?= $category->term_id ?>"><?= $category->name ?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <div class="filters-col">
                <button type="submit" class="js-drop-filters" disabled>
                    Сбросить фильтры
                </button>
                <button type="submit">
                    Применить фильтры
                </button>
            </div>
        </form>
        <div class="gift-container<?= !$current_city ? ' preload' : '' ?>">
            <div class="gift-content">
                <?php if ($gifts) {
                    include_once(get_template_directory().'/template-parts/components/gifts.php');
                } ?>
            </div>
            <div class="gift-preloader">
                <div class="lds-dual-ring"></div>
            </div>
        </div>
    </div>
</section>