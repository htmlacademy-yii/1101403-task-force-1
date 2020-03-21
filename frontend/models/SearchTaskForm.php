<?php
namespace frontend\models;

use phpDocumentor\Reflection\Types\Boolean;
use Yii;
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
        'month' => 'За месяц'
    ];

    public $title;

    public function rules()
    {
        return [
            ['isRepliesExist', 'boolean'],
            ['categories', 'safe'],
            ['remoteWorking', 'boolean'],
            ['period', 'safe'],
            ['title', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'isRepliesExist' => 'Без исполнителя',
            'remoteWorking' => 'Удаленная работа',
            'period' => 'Период',
            'title' => 'Поиск по названию'
        ];
    }
}
