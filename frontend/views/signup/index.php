<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">
        <?php
        $form = ActiveForm::begin([
            'method' => 'post',
            'options' => ['class' => 'registration__user-form form-create'],
            'action' => Url::toRoute('signup/index'),
            'enableClientScript' => false
        ]);
        echo $form
            ->field($model, 'email', [
                'options' => ['tag' => false],
                'errorOptions' => ['tag' => 'span'],
                'labelOptions' => ['class' => isset($errors['email']) ? 'input-danger' : '']
            ])
            ->textarea(['class' => 'input textarea', 'rows' => 1, 'placeholder' => 'kumarm@mail.ru']);

        echo $form
            ->field($model, 'username', [
                'options' => ['tag' => false], 'errorOptions' => ['tag' => 'span'],
                'labelOptions' => ['class' => isset($errors['username']) ? 'input-danger' : '']
            ])
            ->textarea(['class' => 'input textarea', 'rows' => 1, 'placeholder' => 'Мамедов Кумар']);
        echo $form
            ->field($model, 'city', [
                'options' => ['tag' => false], 'errorOptions' => ['tag' => 'span'],
                'labelOptions' => ['class' => isset($errors['city']) ? 'input-danger' : '']
            ])
            ->listBox($model->city, [
                'options' => [$model->chosenCity => ['selected' => true]],
                'class' => 'multiple-select input town-select registration-town',
                'size' => 1,
                'unselect' => null
            ]);
        echo $form
            ->field($model, 'password', [
                'options' => ['tag' => false], 'errorOptions' => ['tag' => 'span'],
                'labelOptions' => ['class' => isset($errors['password']) ? 'input-danger' : '']
            ])
            ->input('password', ['class' => 'input textarea']);
        echo Html::submitButton('Cоздать аккаунт', [
            'class' => 'button button__registration',
            'type' => 'submit'
        ]);
        ActiveForm::end(); ?>
    </div>
</section>



