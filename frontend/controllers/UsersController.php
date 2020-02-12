<?php
namespace frontend\controllers;

use frontend\models\Users;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = Users::find()->where(['role' => 'executive'])->orderBy(['dt_reg' => SORT_DESC])->all();
        return $this->render('index', ['users' => $users]);
    }
}
