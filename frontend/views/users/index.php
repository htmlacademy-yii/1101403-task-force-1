<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \Htmlacademy\logic\PluralForms;
use \Htmlacademy\logic\TimeCounter;
?>
<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item <?php if (isset($listStyle['rating'])): echo $listStyle['rating']; endif; ?>">
                <a href="/users/rating/1" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item <?php if (isset($listStyle['order_count'])): echo $listStyle['order_count']; endif; ?>">
                <a href="/users/order_count/1" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item <?php if (isset($listStyle['view_count'])): echo $listStyle['view_count']; endif; ?>">
                <a href="/users/view_count/1" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <?php foreach ($users as $user): ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="#"><img src="<?php echo $user->avatar_path ?: '/img/man-glasses.jpg'; ?>" width="65" height="65"></a>
                    <?php
                    $tasks = $usersInfo[$user->id]['tasks'] ?: 0;
                    $reviews = $usersInfo[$user->id]['reviews'] ?: 0;
                    ?>
                    <span><?php echo $tasks . ' ' . PluralForms::pluralNouns(intval($tasks), 'задание', 'задания','заданий'); ?></span>
                    <span><?php echo $reviews . ' ' . PluralForms::pluralNouns(intval($reviews), 'отзыв','отзыва','отзывов'); ?></span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="#" class="link-regular"><?php echo $user->name ?: ''; ?></a></p>
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b>
                        <?php echo $usersInfo[$user->id]['rating'] ?: 0; ?>
                    </b>
                    <p class="user__search-content">
                        <?php echo $user->bio ?: ''; ?>
                    </p>
                </div>
                <?php
                $counter = new TimeCounter($user->dt_last_visit);
                $timeString = $counter->countTimePassed();
                ?>
                <span class="new-task__time"><?php echo 'Был(a) на сайте ' . $timeString; ?></span>
            </div>
            <div class="link-specialization user__search-link--bottom">
                <?php if ($user->usersSpecialisations) {
                    foreach ($user->usersSpecialisations as $specialisation) {
                        echo Html::a($specialisation->title, '#', ['class' => 'link-regular']);
                    }
                }
                ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ($pages > 1): ?>
        <div class="new-task__pagination">
            <ul class="new-task__pagination-list">
                <li class="pagination__item">
                    <?php $p = $curPage - 1; ?>
                    <a href="/users/<?php echo $sort . '/' . (($p > 0) ? $p : 1); ?>">&nbsp;</a>
                </li>
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <li class="pagination__item<?php if (intval($curPage) === $i): echo ' pagination__item--current'; endif; ?>">
                        <a href="/users/<?php echo $sort . '/' . $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="pagination__item">
                    <?php $p = $curPage + 1; ?>
                    <a href="/users/<?php echo $sort . '/' . (($p <= $pages) ? $p : $pages); ?>">&nbsp;</a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</section>
<section  class="search-task">
    <div class="search-task__wrapper">
        <?php
        $form = ActiveForm::begin([
            'method' => 'post',
            'options' => ['class' => 'search-task__form']
        ]);
        ?>
        <?php echo Html::beginTag('fieldset', ['class' => 'search-task__categories']); ?>
        <?php echo Html::tag('legend', 'Категории'); ?>
        <?php echo $form
            ->field($model, 'categories', ['options' => ['tag' => null]])
            ->label(false)
            ->CheckboxList($categories,[
                'tag' => false,
                'unselect' => null,
                'item' => static function ($index, $label, $name, $checked, $value) {
                    $checked = $checked === true ? 'checked' : '';
                    return "<input class =\"visually-hidden checkbox__input\" id=$index type=\"checkbox\" name=$name value=$value $checked>" .
                        "<label for=$index>$label</label>";
                }
            ]); ?>
        <?php echo Html::endTag('fieldset'); ?>
        <?php echo Html::beginTag('fieldset', ['class' => 'search-task__categories']); ?>
        <?php echo Html::tag('legend', 'Дополнительно'); ?>
        <?php echo $form
            ->field($model, 'freeNow', ['options' => ['tag' => false], 'template' => '{input}{label}{error}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
        ?>
        <?php echo $form
            ->field($model, 'online', ['options' => ['tag' => false], 'template' => '{input}{label}{error}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
        ?>
        <?php echo $form
            ->field($model, 'hasReplies', ['options' => ['tag' => false], 'template' => '{input}{label}{error}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
        ?>
        <?php echo $form
            ->field($model, 'inFavorites', ['options' => ['tag' => false], 'template' => '{input}{label}{error}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
        ?>
        <?php echo Html::endTag('fieldset'); ?>
        <?php echo $form
            ->field($model, 'name', [
                'options' => ['tag' => false],
                'template' => '{label}{input}{error}',
                'labelOptions' => ['class' => 'search-task__name'],
                'inputOptions' => ['type' => 'search', 'class' => 'input-middle input'],
            ]);
        ?>
        <?php echo Html::submitButton('Искать', ['class' => 'button']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>
