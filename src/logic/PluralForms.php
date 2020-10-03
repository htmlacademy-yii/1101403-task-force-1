<?php
namespace Htmlacademy\Logic;


class PluralForms
{
    /**
     * Метод возвращает правильную форму множественного числа в зависимости от количества сущностей.
     * @param int $number количество сущностей
     * @param string $singular единственное число (напр. 'яблоко')
     * @param string $double 2, 3 или 4 предмета (напр. 'яблока')
     * @param string $plural множественное число (напр. 'яблок')
     * @return string правильную форму множественного числа
     */
    public static function pluralNouns(int $number, string $singular, string $double, string $plural): string
    {
        $mod10 = $number % 10;
        $mod100 = $number % 100;
        switch (true) {
            case ($mod100 >= 11 && $mod100 <= 19):
                return $plural;
            case ($mod10 === 1):
                return $singular;
            case ($mod10 >= 2 && $mod10 <= 4):
                return $double;

            default:
                return $plural;
        }
    }
}
