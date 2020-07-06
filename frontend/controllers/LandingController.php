<?php


namespace frontend\controllers;


use frontend\models\LoginForm;
use frontend\models\Tasks;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class LandingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['tasks/']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ]
            ]
        ];
    }

    public $layout = 'landing';

    public function actionLogin()
    {
        $tasks = Tasks::find()
            ->where(['status' => 'new'])
            ->with(['category','city'])
            ->orderBy(['tasks.dt_create' => SORT_DESC])
            ->limit(4)
            ->all();
        $model = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
           $model->load(Yii::$app->request->post());
           if ($model->validate()) {
               $user = $model->getUser();
               Yii::$app->user->login($user);
               // TO DO: поменять адрес редиректа на страницу пользователя
               return $this->redirect(['users/']);
           }
           return $this->goHome();
        }

        return $this->render('login', [
            'tasks' => $tasks,
            'model' => $model,
            'title' => 'Главная страница'
        ]);
    }

}
