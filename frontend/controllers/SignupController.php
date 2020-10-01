<?php
namespace frontend\controllers;

use frontend\models\SignupForm;
use frontend\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SignupController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ]

            ]
        ];
    }

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
                //TODO поменять роут на главную страницу
                return $this->redirect(['/users']);
            }
            $errors = $model->getErrors();
        }

        return $this->render('index', [
            'model' => $model,
            'errors' => $errors
        ]);
    }

}
