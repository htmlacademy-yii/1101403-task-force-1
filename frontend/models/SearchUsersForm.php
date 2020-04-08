<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Class SearchUsers Form
 */
class SearchUsersForm extends Model
{
    public $categories;

    public $freeNow;

    public $online;

    public $hasReplies;

    public $inFavorites;

    public $name;

    public function rules() {
        return [
            [['freeNow', 'online', 'hasReplies', 'inFavorites'], 'boolean'],
            [['categories', 'name'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'freeNow' => 'Сейчас свободен',
            'online' => 'Сейчас онлайн',
            'hasReplies' => 'Есть отзывы',
            'inFavorites' => 'В избранном',
            'name' => 'Поиск по имени'
        ];
    }
}
