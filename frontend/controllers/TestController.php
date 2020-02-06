<?php
namespace frontend\controllers;

use frontend\models\Categories;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $category = Categories::find()->one();
        if ($category) {
            echo $category->title;
        }
    }
}
