<?php
namespace frontend\controllers;

use frontend\models\SignupForm;
use frontend\models\Users;
use Yii;
use yii\web\Controller;

class SignupController extends Controller
{
    public function actionIndex()
    {
        $model = new SignupForm();
        $errors = [];
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
               $user = new Users();
               $user->name = $model->username;
               $user->email = $model->email;
               $user->password = password_hash($model->password, PASSWORD_DEFAULT);
               $user->city_id = !empty($model->chosenCity) ? $model->chosenCity : '';
               $user->role = 'client';
               $user->save();
               //TO DO поменять роут на главную страницу
               header('Location:/users');
               exit();
            }
            $errors = $model->getErrors();
        }

        return $this->render('index', [
            'model' => $model,
            'errors' => $errors
        ]);
    }

}
