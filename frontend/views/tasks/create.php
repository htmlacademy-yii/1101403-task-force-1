<?php

/* @var $model CreateTaskForm */
/* @var $errors array */

use frontend\models\CreateTaskForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<section class="create__task">
    <h1>Публикация нового задания</h1>
    <div class="create__task-main">
        <?php
        $form = ActiveForm::begin([
            'method' => 'post',
            'options' => ['class' => 'create__task-form form-create', 'enctype' => 'multipart/form-data'],
            'action' => Url::toRoute('tasks/create'),
            'enableClientScript' => false
        ]);

        echo $form
            ->field($model, 'title', [
                'options' => ['tag' => false],
                'hintOptions' => ['tag' => 'span'],
                'labelOptions' => ['class' => isset($errors['title']) ? 'input-danger' : ''],
                'template' => "{label}\n{input}\n{hint}"
            ])
            ->textarea([
                'class' => 'input textarea',
                'rows' => 1,
                'placeholder' => 'Повесить полку'
            ])
            ->hint(isset($errors['title']) ? $errors['title'][0] :'Кратко опишите суть работы');

        echo $form
            ->field($model, 'description', [
                'options' => ['tag' => false],
                'hintOptions' => ['tag' => 'span'],
                'labelOptions' => ['class' => isset($errors['description']) ? 'input-danger' : ''],
                'template' => "{label}\n{input}\n{hint}"
            ])
            ->textarea([
                'class' => 'input textarea',
                'rows' => 7,
                'placeholder' => 'Возле дубовой рощи развелись трупоеды, ни пройти, ни проехать.'
            ])
            ->hint(isset($errors['description']) ? $errors['description'][0] : 'Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться');

        echo $form
            ->field($model, 'chosenCategory', [
                'options' => ['tag' => false],
                'hintOptions' => ['tag' => 'span'],
                'labelOptions' => ['class' => isset($errors['chosenCategory']) ? 'input-danger' : ''],
                'template' => "{label}\n{input}\n{hint}"
            ])
            ->listBox($model->category, [
                'options' => [$model->chosenCategory => ['selected' => true]],
                'class' => 'multiple-select input multiple-select-big',
                'size' => 1,
                'unselect' => null
            ])
            ->hint(isset($errors['chosenCategory']) ? $errors['chosenCategory'][0] : 'Выберите категорию');

        echo $form
            ->field($model, 'attachments[]', [
                'options' => ['tag' => false],
                'labelOptions' => ['class' => isset($errors['attachments']) ? 'input-danger' : ''],
                'inputOptions' => ['class' => 'dropzone'],
                'hintOptions' => ['tag' => 'span'],
                'template' => "{label}\n{hint}\n<div class='create__file dz-clickable'><span>Добавить новый файл</span>{input}\n</div>",
            ])
            ->fileInput(['multiple' => true, 'accept' => 'image/*'])
            ->hint(isset($errors['attachments']) ? $errors['attachments'][0] : 'Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу');
        ?>
        <div class="create__price-time">
            <?php
            echo $form
                ->field($model, 'budget', [
                    'options' => ['tag' => 'div', 'class' => 'create__price-time--wrapper'],
                    'labelOptions' => ['class' => isset($errors['budget']) ? 'input-danger' : ''],
                    'hintOptions' => ['tag' => 'span'],
                    'template' => "{label}\n{input}\n{hint}"
                ])
                ->textarea([
                    'class' => 'input textarea input-money',
                    'rows' => 1,
                    'placeholder' => '1000'
                ])
                ->hint(isset($errors['budget']) ? $errors['budget'][0] : 'Не заполняйте для оценки исполнителем');
            echo $form
                ->field($model, 'dt_end', [
                    'options' => ['tag' => 'div', 'class' => 'create__price-time--wrapper'],
                    'labelOptions' => ['class' => isset($errors['dt_end']) ? 'input-danger' : ''],
                    'hintOptions' => ['tag' => 'span'],
                    'template' => "{label}\n{input}\n{hint}"
                ])
                ->input('date', [
                    'class' => 'input-middle input input-date'
                ])
                ->hint(isset($errors['dt_end']) ? $errors['dt_end'][0] : 'Укажите крайний срок исполнения');
            ?>
        </div>
        <?php
        $form::end();
        ?>

<!--        <form class="create__task-form form-create" action="/" enctype="multipart/form-data" id="task-form">-->
<!---->
<!--            <label for="10">Мне нужно</label>-->
<!--            <textarea class="input textarea" rows="1" id="10" name="" placeholder="Повесить полку"></textarea>-->
<!--            <span>Кратко опишите суть работы</span>-->
<!---->
<!--            <label for="11">Подробности задания</label>-->
<!--            <textarea class="input textarea" rows="7" id="11" name="" placeholder="Place your text"></textarea>-->
<!--            <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>-->
<!---->
<!--            <label for="12">Категория</label>-->
<!--            <select class="multiple-select input multiple-select-big" id="12"size="1" name="category[]">-->
<!--                <option value="day">Уборка</option>-->
<!--                <option selected value="week">Курьерские услуги</option>-->
<!--                <option value="month">Доставка</option>-->
<!--            </select>-->
<!--            <span>Выберите категорию</span>-->
<!---->
<!--            <label>Файлы</label>-->
<!--            <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>-->
<!--            <div class="create__file">-->
<!--                <span>Добавить новый файл</span>-->
<!--                <input type="file" name="files[]" class="dropzone">-->
<!--            </div>-->
<!---->
<!--            <label for="13">Локация</label>-->
<!--            <input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район">-->
<!--            <span>Укажите адрес исполнения, если задание требует присутствия</span>-->
<!---->
<!--            <div class="create__price-time">-->
<!---->
<!--                <div class="create__price-time--wrapper">-->
<!--                    <label for="14">Бюджет</label>-->
<!--                    <textarea class="input textarea input-money" rows="1" id="14" name="" placeholder="1000"></textarea>-->
<!--                    <span>Не заполняйте для оценки исполнителем</span>-->
<!--                </div>-->
<!---->
<!--                <div class="create__price-time--wrapper">-->
<!--                    <label for="15">Срок исполнения</label>-->
<!--                    <input id="15"  class="input-middle input input-date" type="date" placeholder="10.11, 15:00">-->
<!--                    <span>Укажите крайний срок исполнения</span>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </form>-->

        <div class="create__warnings">
            <div class="warning-item warning-item--advice">
                <h2>Правила хорошего описания</h2>
                <h3>Подробности</h3>
                <p>Друзья, не используйте случайный<br>
                    контент – ни наш, ни чей-либо еще. Заполняйте свои
                    макеты, вайрфреймы, мокапы и прототипы реальным
                    содержимым.</p>
                <h3>Файлы</h3>
                <p>Если загружаете фотографии объекта, то убедитесь,
                    что всё в фокусе, а фото показывает объект со всех
                    ракурсов.</p>
            </div>
            <?php
            $labels = $model->attributeLabels();
            if (!empty($errors)): ?>
                <div class="warning-item warning-item--error">
                    <h2>Ошибки заполнения формы</h2>
                    <?php foreach ($errors as $key => $errorArray): ?>
                        <h3><?php echo $labels[$key]; ?></h3>
                        <?php foreach ($errorArray as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <button form="<?php echo $form->id; ?>" class="button" type="submit">Опубликовать</button>
</section>
