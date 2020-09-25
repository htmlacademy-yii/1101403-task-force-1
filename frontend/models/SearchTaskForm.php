<?php
namespace frontend\models;


use yii\base\Model;

/**
 * Class SearchTask Form
 */
class SearchTaskForm extends Model
{
    public $categories;

    public $isRepliesExist = false;

    public $remoteWorking = false;

    public $period = [
        'day' => 'За день',
        'week' => 'За неделю',
        'month' => 'За месяц',
        'all' => 'За все время'
    ];

    public $chosenPeriod = 'all';

    public $title;

    public function rules()
    {
        return [
            [['isRepliesExist', 'remoteWorking'], 'boolean'],
            [['categories', 'chosenPeriod', 'period', 'title'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'isRepliesExist' => 'Без откликов',
            'remoteWorking' => 'Удаленная работа',
            'chosenPeriod' => 'Период',
            'title' => 'Поиск по названию',
        ];
    }
}
