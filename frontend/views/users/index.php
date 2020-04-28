<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \Htmlacademy\logic\PluralForms;
use \Htmlacademy\logic\TimeCounter;
use yii\widgets\LinkPager;

?>
<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item <?php if (isset($listStyle['rating'])): echo $listStyle['rating']; endif; ?>">
                <a href="<?php echo Url::toRoute(['users/index', 'sort' => 'rating', 'page' => 1]); ?>" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item <?php if (isset($listStyle['order_count'])): echo $listStyle['order_count']; endif; ?>">
                <a href="<?php echo Url::toRoute(['users/index', 'sort' => 'order_count', 'page' => 1]); ?>" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item <?php if (isset($listStyle['view_count'])): echo $listStyle['view_count']; endif; ?>">
                <a href="<?php echo Url::toRoute(['users/index', 'sort' => 'view_count', 'page' => 1]); ?>" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <?php foreach ($users as $user): ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="<?php echo Url::toRoute(['users/view', 'id' => $user->id]); ?>"><img src="<?php echo $user->avatar_path ?: '/img/man-glasses.jpg'; ?>" width="65" height="65"></a>
                    <?php
                    $tasks = $tasksCount[$user->id] ?: 0;
                    $reviews = $reviewsCount[$user->id] ?: 0;
                    ?>
                    <span><?php echo $tasks . ' ' . PluralForms::pluralNouns(intval($tasks), 'задание', 'задания','заданий'); ?></span>
                    <span><?php echo $reviews . ' ' . PluralForms::pluralNouns(intval($reviews), 'отзыв','отзыва','отзывов'); ?></span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="<?php echo Url::toRoute(['users/view', 'id' => $user->id]); ?>" class="link-regular"><?php echo $user->name ?: ''; ?></a></p>
                    <?php
                    $stars = intval(ceil($ratings[$user->id] ?: 0));
                    if ($stars > 0) {
                        for ($i = 0; $i < $stars; $i++) {
                            echo '<span></span>';
                        }
                    }
                    $rest = 5 - $stars;
                    if ($rest > 0) {
                        for ($i = 0; $i < $rest; $i++) {
                            echo '<span class="star-disabled"></span>';
                        }
                    }
                    ?>
                    <b>
                        <?php echo $ratings[$user->id] ?: 0; ?>
                    </b>
                    <p class="user__search-content">
                        <?php echo $user->bio ?: ''; ?>
                    </p>
                </div>
                <?php
                $counter = new TimeCounter($user->dt_last_visit);
                $timeString = $counter->countTimePassed();
                ?>
                <span class="new-task__time"><?php echo 'Был(a) на сайте ' . $timeString . ' назад'; ?></span>
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
    <div class="new-task__pagination">
        <?php
        echo LinkPager::widget([
            'pagination' => $pagination,
            'activePageCssClass' => 'pagination__item--current',
            'options' => ['class' => 'new-task__pagination-list'],
            'linkContainerOptions' => ['class' => 'pagination__item'],
            'nextPageLabel' => '&nbsp;',
            'prevPageLabel' => '&nbsp;'
        ]);
        ?>
    </div>
</section>
<section  class="search-task">
    <div class="search-task__wrapper">
        <?php
        $form = ActiveForm::begin([
            'method' => 'get',
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
