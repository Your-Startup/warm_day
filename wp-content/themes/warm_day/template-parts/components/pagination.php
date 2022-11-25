<?php 
/**
 * @var $pagination
 */

$count_show_pages = 5;
$count_show_lr_pages = 2;
?>
<?php if (!empty($pagination) && $pagination['pages'] > 1) : ?>
    <div class="gift-pagination">
        <?php if ($pagination['page'] > 1) : ?>
            <div class="pagination-page js-pagination-prev">
                предыдущая
            </div>
        <?php endif;?>

        <?php if ($pagination['page'] > $count_show_pages - 1) : ?>
            <div class="pagination-page js-pagination" data-page="1">
                1
            </div>
            . . .
        <?php endif;?>

        <?php for ($i = 1; $i <= $pagination['pages']; $i++) : ?>
            <?php if ($i >= $pagination['page'] - $count_show_lr_pages && $i <= $pagination['page'] + $count_show_lr_pages) : ?>
                <div class="pagination-page js-pagination<?= $i == $pagination['page'] ? ' current' : '' ?>" data-page="1"><?= $i ?></div>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($pagination['pages'] - $pagination['page'] > $count_show_pages - 1) : ?>
            . . .
            <div class="pagination-page js-pagination" data-page="<?= $pagination['pages'] ?>">
                <?= $pagination['pages'] ?>
            </div>
        <?php endif;?>

        <?php if ($pagination['page'] < $pagination['pages']) : ?>
            <div class="pagination-page js-pagination-next">
                следующая
            </div>
        <?php endif;?>
    </div>
<?php endif; ?>