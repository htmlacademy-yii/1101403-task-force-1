<?php
namespace Htmlacademy\Logic;

class CancelAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    static function getTitle()
    {
        return CancelAction::class;
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    static function getInnerName()
    {
        return 'cancel';
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
