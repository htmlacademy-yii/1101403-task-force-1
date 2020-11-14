<?php


namespace Htmlacademy\Logic;

/**
 * Class AgeCounter считает возраст юзера
 * @package Htmlacademy\Logic
 */
class AgeCounter
{
    /**
     * @var - дата рождения юзера в формате '2020-02-11 21:05:22' (г-м-д ч:м:с)
     */
    protected $dt_birth;

    /**
     * AgeCounter constructor.
     * @param $dt_birth
     */
    public function __construct($dt_birth)
    {
        $this->dt_birth = $dt_birth;
    }

    public function countAge(): int
    {
        $yr_birth = intval(substr($this->dt_birth, 0, 4));
        $month_birth = intval(substr($this->dt_birth, 5, 2));
        $yr_now = intval(date('Y'));
        $month_now = intval(date('m'));
        if ($month_now > $month_birth) {
           return $yr_now - $yr_birth;
        }
        if ($month_now < $month_birth) {
            return $yr_now - $yr_birth - 1;
        }
        if ($month_now === $month_birth) {
            $day_birth = intval(substr($this->dt_birth, 8, 2));
            $today = intval(date('d'));
            if ($day_birth > $today) {
                return $yr_now - $yr_birth;
            }
            return $yr_now - $yr_birth - 1;
        }
    }

}
