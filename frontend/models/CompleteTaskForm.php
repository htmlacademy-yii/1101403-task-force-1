<?php


namespace frontend\models;


use yii\base\Model;

class CompleteTaskForm extends Model
{
    public $completion = [
        'yes' => 'Да',
        'difficult' => 'Возникли проблемы'
    ];

    public $chosenCompletion;

    public $comment;

    public $rating;

    public function rules()
    {
        return [
            [['chosenCompletion', 'comment', 'rating'], 'required'],
            ['completion', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий',
            'chosenCompletion' => 'Задание выполнено?'
        ];
    }





}
