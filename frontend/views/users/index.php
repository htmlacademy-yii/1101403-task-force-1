<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item user__search-item--current">
                <a href="users/rating" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item">
                <a href="users/order_count" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item">
                <a href="users/view_count" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <?php foreach ($users as $user): ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="#"><img src="./img/man-glasses.jpg" width="65" height="65"></a>
                    <span><?php echo $user->exTasksCount . ' ' . \Htmlacademy\logic\PluralForms::pluralNouns($user->exTasksCount, 'задание', 'задания','заданий'); ?></span>
                    <span><?php echo $user->exReviewsCount . ' ' . \Htmlacademy\logic\PluralForms::pluralNouns($user->exReviewsCount, 'отзыв','отзыва','отзывов'); ?></span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="#" class="link-regular"><?php echo $user->name; ?></a></p>
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b>
                        <?php
                        if ($user->rating) {
                            echo $user->rating;
                        }
                        ?>
                    </b>
                    <p class="user__search-content">
                        <?php echo $user->bio; ?>
                    </p>
                </div>
                <?php
                $counter = new \Htmlacademy\logic\TimeCounter($user->dt_last_visit);
                $timeString = $counter->countTimePassed();
                ?>
                <span class="new-task__time"><?php echo 'Был(a) на сайте ' . $timeString; ?></span>
            </div>
            <div class="link-specialization user__search-link--bottom">
                <?php if ($user->usersSpecialisations) {
                    foreach ($user->usersSpecialisations as $specialisation) {
                        echo yii\helpers\Html::a($specialisation->title, '#', ['class' => 'link-regular']);
                    }
                }
                ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>
<section  class="search-task">
    <div class="search-task__wrapper">
        <?php

        use yii\helpers\Html;
        use yii\widgets\ActiveForm;
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
            ->field($model, 'freeNow', ['options' => ['tag' => false], 'template' => '{input}{label}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
        ?>
        <?php echo $form
            ->field($model, 'online', ['options' => ['tag' => false], 'template' => '{input}{label}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
        ?>
        <?php echo $form
            ->field($model, 'hasReplies', ['options' => ['tag' => false], 'template' => '{input}{label}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
        ?>
        <?php echo $form
            ->field($model, 'inFavorites', ['options' => ['tag' => false], 'template' => '{input}{label}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false);
        ?>
        <?php echo Html::endTag('fieldset'); ?>
        <?php echo $form
            ->field($model, 'name', [
                'options' => ['tag' => false],
                'template' => '{label}{input}',
                'labelOptions' => ['class' => 'search-task__name'],
                'inputOptions' => ['type' => 'search', 'class' => 'input-middle input'],
            ]);
        ?>
        <?php echo Html::submitButton('Искать', ['class' => 'button']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>
