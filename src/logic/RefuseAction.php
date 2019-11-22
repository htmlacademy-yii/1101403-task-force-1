<?php
namespace Htmlacademy\Logic;

class RefuseAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    static function getTitle()
    {
        return 'Отказаться';
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    static function getInnerName()
    {
        return 'refuse';
    }

    /**
     * Проверяет, разрешено ли действие
     * @return bool
     */
    static function isPermitted()
    {
        if ($role === 'executive' && $status === 'in progress') {
            return true;
        }
        return false;
    }
}
