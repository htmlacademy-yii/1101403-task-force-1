<?php
namespace Htmlacademy\Logic;

class CompleteAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    static function getTitle()
    {
        return 'Завершить';
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    static function getInnerName()
    {
        return 'complete';
    }

    /**
     * Проверяет, разрешено ли действие
     * @return bool
     */
    static function isPermitted()
    {
        if ($role === 'client' && $status === 'in progress') {
            return true;
        }
        return false;
    }
}
