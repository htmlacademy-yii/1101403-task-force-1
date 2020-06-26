<?php

use frontend\models\LoginForm;
use frontend\models\Tasks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $tasks Tasks */
/* @var $model LoginForm */
/* @var $title string */

$this->params['tasks'] = $tasks;
$this->params['title'] = $title;

?>
<h2>Вход на сайт</h2>
<?php
$form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute('landing/'),
]);
echo $form
    ->field($model, 'email', [
        'labelOptions' => ['class' => 'form-modal-description'],
        'options' => ['tag' => 'p']
    ])
    ->input('email', ['class' => 'enter-form-email input input-middle']);
echo $form
    ->field($model, 'password', [
        'labelOptions' => ['class' => 'form-modal-description'],
        'options' => ['tag' => 'p']
    ])
    ->input('password', ['class' => 'enter-form-email input input-middle']);
echo Html::submitButton('Войти', [
    'class' => 'button',
    'type' => 'submit'
]);
ActiveForm::end();
?>
<button class="form-modal-close" type="button">Закрыть</button>

