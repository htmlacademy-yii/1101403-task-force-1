<?php

use Htmlacademy\logic\TimeCounter;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\LinkPager;
?>
<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?php foreach ($tasks as $task): ?>
        <div class="new-task__card">
            <div class="new-task__title">
                <a href="#" class="link-regular"><h2><?php echo $task->title; ?></h2></a>
                <a  class="new-task__type link-regular" href="#"><p><?php echo $task->category->title; ?></p></a>
            </div>
            <div class="new-task__icon new-task__icon--<?php echo $task->category->icon; ?>"></div>
            <p class="new-task_description">
                <?php echo $task->description; ?>
            </p>
            <b class="new-task__price new-task__price--<?php echo $task->category->icon; ?>"><?php echo $task->budget;?><b> ₽</b></b>
            <p class="new-task__place"><?php echo $task->city ? $task->city->title . ',': ''; ?> Центральный район</p>
            <?php
            $counter = new TimeCounter($task->dt_create);
            $timeString = $counter->countTimePassed();
            ?>
            <span class="new-task__time"><?php echo $timeString; ?></span>
        </div>
        <?php endforeach; ?>
    </div>
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
            'options' => ['class' => 'search-task__form', 'name' => 'test'],
        ]);
        ?>
        <?php echo Html::beginTag('fieldset', ['class' => 'search-task__categories']); ?>
        <?php echo Html::tag('legend', 'Категории'); ?>
        <?php echo $form
            ->field($model, 'categories', ['options' => ['tag' => null]])
            ->label(false)
            ->CheckboxList($categories, [
                'unselect' => null,
                'tag' => false,
                'item' => static function ($index, $label, $name, $checked, $value) {
                    $checked = $checked === true ? 'checked' : '';
                    return "<input class =\"visually-hidden checkbox__input\" id=$index type=\"checkbox\" name=$name value=$value $checked>" .
                    "<label for=$index>$label</label>";
                }
            ]);
        ?>
        <?php echo Html::endTag('fieldset'); ?>
        <?php echo Html::beginTag('fieldset', ['class' => 'search-task__categories']); ?>
        <?php echo Html::tag('legend', 'Дополнительно'); ?>
        <?php echo $form
            ->field($model, 'isRepliesExist', ['options' => ['tag' => false], 'template' => '{input}{label}{error}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false); ?>
        <?php echo $form
            ->field($model, 'remoteWorking', ['options' => ['tag' => false], 'template' => '{input}{label}{error}'])
            ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false); ?>
        <?php echo Html::endTag('fieldset'); ?>
        <?php echo $form
            ->field($model, 'chosenPeriod', ['options' => ['tag' => false], 'template' => '{label}{input}{error}', 'labelOptions' => ['class' => 'search-task__name']])
            ->listBox($model->period, [
                'options' => [$model->chosenPeriod => ['selected' => true]],
                'unselect' => null,
                'tag' => false,
                'class' => 'multiple-select input',
                'size' => 1
            ]);
        ?>
        <?php echo $form
            ->field($model, 'title', [
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

