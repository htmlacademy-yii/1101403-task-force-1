<?php


namespace frontend\models;


use yii\base\Model;

class ResponseForm extends Model
{
    public $price;

    public $comment;

    public function rules()
    {
        return [
            [['price', 'comment'], 'required'],
            ['price', 'integer', 'min' => 1, 'tooSmall' => 'Ваша цена не может быть меньше 1'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'price' => 'Ваша цена',
            'comment' => 'Комментарий'
        ];
    }

}
