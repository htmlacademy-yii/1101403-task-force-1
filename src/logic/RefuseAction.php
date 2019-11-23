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
     *
     * @param int $clientId
     * @return bool
     */
    static function isPermitted($executiveId)
    {
        if ($executiveId === $userId) {
            return true;
        }
        return false;
    }
}
