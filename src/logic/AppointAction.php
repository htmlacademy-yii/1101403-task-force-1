<?php
namespace Htmlacademy\Logic;

class AppointAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    static function getTitle()
    {
        return AppointAction::class;
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    static function getInnerName()
    {
        return 'appoint';
    }

    /**
     * Проверяет, разрешено ли действие
     * @return bool
     */
    static function isPermitted()
    {
        if ($role === 'client' && $status === 'new') {
            return true;
        }
        return false;
    }
}
