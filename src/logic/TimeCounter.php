<?php

namespace Htmlacademy\logic;

use Htmlacademy\logic\PluralForms;

/**
 * Класс считает, сколько времени прошло с момента создания какой-либо сущности и переводит это время в
 * человекопонятную строку «минут/часов/дней» с округлением в меньшую сторону
 */
class TimeCounter
{
    /**
     * @var - время формата '2020-02-11 21:05:22' в прошлом, когда было создано задание/аккаунт или др. сущность
     */
    protected $dtCreate;

    /**
     * @var false|int временной промежуток в секундах с даты создания сущности
     */
    protected $timeDiff;

    /**
     * TimeCounter constructor.
     * @param $dtCreate
     */
    public function __construct($dtCreate)
    {
        $this->dtCreate = $dtCreate;
        $this->timeDiff = time() - strtotime($this->dtCreate);
    }

    /**
     * Метод возвращает строку с информацией, сколько времени прошло с момента создания сущности
     * @return string
     */
    public function countTimePassed()
    {
        $timeInMinutes = $this->timeDiff/60;
        if ($timeInMinutes > 1440) {
            $timePassed = floor($timeInMinutes/1440);
            return $timePassed . ' ' . PluralForms::pluralNouns($timePassed, 'день','дня','дней');
        } elseif ($timeInMinutes > 60 && $timeInMinutes < 1440) {
            $timePassed = floor($timeInMinutes/60);
            return $timePassed . ' ' . PluralForms::pluralNouns($timePassed, 'час','часа','часов');
        } elseif ($timeInMinutes < 60) {
            return floor($timeInMinutes) . ' ' . PluralForms::pluralNouns($timeInMinutes, 'минута','минуты','минут');
        }
    }

}
