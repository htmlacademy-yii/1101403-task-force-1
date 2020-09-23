<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Class SignupForm
 * @package frontend\models
 */
class SignupForm extends Model
{
    public $email;

    public $username;

    public $city = [
        '1109' => 'Москва',
        '1110' => 'Санкт-Петербург',
        '465' => 'Краснодар',
        '344' => 'Иркутск',
        '165' => 'Владивосток'
    ];

    public $password;

    public $chosenCity = '';

    public function rules()
    {
        return [
            [['email', 'username', 'password'], 'required'],
            [['email', 'username'], 'trim'],
            ['email', 'email', 'message' => 'Введите валидный адрес электронной почты'],
            ['email', 'string', 'max' => 64],
            ['email', 'unique', 'targetClass' => Users::classname(), 'message' => 'Данный адрес почты занят'],

            [
                'password', 'string', 'min' => 8, 'max' => 64,
                'tooShort' => 'Пароль должен быть не короче 8 символов.', 'tooLong' => 'Пароль должен быть не длиннее 64 символов'
            ],

            ['username', 'string', 'min' => 2, 'max' => 50],
            ['username', 'unique', 'targetClass' => Users::classname(), 'message' => 'Данное имя пользователя занято', 'targetAttribute' => ['username' => 'name']],

            ['chosenCity', 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['chosenCity' => 'id']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'username' => 'Ваше имя',
            'password' => 'Пароль',
            'chosenCity' => 'Город проживания'
        ];
    }
}
