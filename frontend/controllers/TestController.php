<?php
namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Users;
use yii\helpers\VarDumper;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $client = Users::findOne(11);

        if ($client) {
            VarDumper::dump($client->clientsFavoritesExecutors);
        }
    }
}
