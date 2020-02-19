<?php
namespace frontend\controllers;

use frontend\models\Users;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = Users::find()
            ->select(['users.*', 'AVG(r.rate) AS rating', 'COUNT(t.id) AS exTasksCount', 'COUNT(r.id) AS exReviewsCount'])
            ->where(['role' => 'executive'])
            ->joinWith(['executivesTasks AS t', 'reviewsByExecutive AS r'])
            ->groupBy('users.id')
            ->orderBy(['dt_reg' => SORT_DESC])->all();
        return $this->render('index', ['users' => $users]);
    }
}
