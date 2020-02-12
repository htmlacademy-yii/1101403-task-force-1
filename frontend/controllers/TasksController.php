<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Tasks;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Tasks::find()->where(['status' => 'new'])->orderBy(['dt_create' => SORT_DESC])->all();
        return $this->render('index', ['tasks' => $tasks]);
    }
}
