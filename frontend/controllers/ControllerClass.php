<?php


namespace frontend\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

abstract class ControllerClass extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

}
