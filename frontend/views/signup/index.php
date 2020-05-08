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
            'action' => Url::toRoute('signup/index')
        ]);
        ?>
        <?php echo $form
            ->field($model, 'email', ['options' => ['tag' => false], 'errorOptions' => ['tag' => 'span']])
            ->textarea(['class' => 'input textarea', 'rows' => 1, 'placeholder' => 'kumarm@mail.ru']);
        ?>
        <?php echo $form
            ->field($model, 'username', ['options' => ['tag' => false], 'errorOptions' => ['tag' => 'span']])
            ->textarea(['class' => 'input textarea', 'rows' => 1, 'placeholder' => 'Мамедов Кумар']);
        ?>
        <?php echo $form
            ->field($model, 'city', ['options' => ['tag' => false], 'errorOptions' => ['tag' => 'span']])
            ->listBox($model->city, [
                'options' => [$model->chosenCity => ['selected' => true]],
                'class' => 'multiple-select input town-select registration-town',
                'size' => 1,
                'unselect' => null
            ]);
        ?>
        <?php echo $form
            ->field($model, 'password', ['options' => ['tag' => false], 'errorOptions' => ['tag' => 'span']])
            ->input('password', ['class' => 'input textarea']);
        ?>
        <?php echo Html::submitButton('Cоздать аккаунт', [
            'class' => 'button button__registration',
            'type' => 'submit'
        ]);
        ?>
        <?php $form->end(); ?>
    </div>
</section>

<!--        <form class="registration__user-form form-create">-->

<!--            <label for="16">Электронная почта</label>-->
<!--            <textarea class="input textarea" rows="1" id="16" name="" placeholder="kumarm@mail.ru"></textarea>-->
<!--            <span>Введите валидный адрес электронной почты</span>-->

<!--            <label for="17">Ваше имя</label>-->
<!--            <textarea class="input textarea" rows="1" id="17" name="" placeholder="Мамедов Кумар"></textarea>-->
<!--            <span>Введите ваше имя и фамилию</span>-->

<!--            <label for="18">Город проживания</label>-->
<!--            <select id="18" class="multiple-select input town-select registration-town" size="1" name="town[]">-->
<!--                <option value="Moscow">Москва</option>-->
<!--                <option selected value="SPB">Санкт-Петербург</option>-->
<!--                <option value="Krasnodar">Краснодар</option>-->
<!--                <option value="Irkutsk">Иркутск</option>-->
<!--                <option value="Bladivostok">Владивосток</option>-->
<!--            </select>-->
<!--            <span>Укажите город, чтобы находить подходящие задачи</span>-->

<!--            <label class="input-danger" for="19">Пароль</label>-->
<!--            <input class="input textarea " type="password" id="19" name="">-->
<!--            <span>Длина пароля от 8 символов</span>-->

<!--            <button class="button button__registration" type="submit">Cоздать аккаунт</button>-->
<!--        </form>-->

<form id="w0" class="registration__user-form form-create" action="/signup" method="post">
    <input type="hidden" name="_csrf-frontend" value="3qo9LAzBGWjAzzumiqG1nH4wxR1vSClrFBil4YJ7uNG44FFZaIJYIIeibtPP-5jzO2ORbTgsGCBCNeuzukyM4g==">

    <label class="control-label" for="signupform-email">Электронная почта</label>
    <textarea id="signupform-email" class="input textarea" name="SignupForm[email]" rows="1" placeholder="kumarm@mail.ru" aria-required="true" aria-invalid="true"></textarea>
    <span></span>

    <label class="control-label" for="signupform-username">Ваше имя</label>
    <textarea id="signupform-username" class="input textarea" name="SignupForm[username]" rows="1" placeholder="Мамедов Кумар" aria-required="true" aria-invalid="true"></textarea>
    <span></span>

    <label class="control-label" for="signupform-city">Город проживания</label>
    <select id="signupform-city" class="multiple-select input town-select registration-town" name="SignupForm[city]" size="1">
        <option value="1109">Москва</option>
        <option value="1110">Санкт-Петербург</option>
        <option value="465">Краснодар</option>
        <option value="344">Иркутск</option>
        <option value="165">Владивосток</option>
    </select>
    <span></span>

    <label class="control-label" for="signupform-password">Пароль</label>
    <input type="password" id="signupform-password" class="input textarea" name="SignupForm[password]" aria-required="true" aria-invalid="true">
    <span></span>

    <button type="submit" class="button button__registration">Cоздать аккаунт</button>
</form>

