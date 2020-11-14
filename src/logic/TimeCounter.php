<?php

namespace Htmlacademy\Logic;


/**
 * Класс считает, сколько времени прошло с момента создания какой-либо сущности и переводит это время в
 * человекопонятную строку «минут/часов/дней» с округлением в меньшую сторону
 */
class TimeCounter
{
    /**
     * @var - время формата unixtime в прошлом, когда было создано задание/аккаунт или др. сущность
     */
    protected $dtCreate;

    /**
     * @var false|int временной промежуток в секундах с даты создания сущности
     */
    protected $timeDiff;

    /**
     * TimeCounter constructor.
     * 10800 секунд - это GMT+03:00
     * @param $dtCreate
     */
    public function __construct($dtCreate)
    {
        $this->dtCreate = strtotime($dtCreate);
        $this->timeDiff = time() - $this->dtCreate + 10800;
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
