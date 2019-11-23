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
     *
     * @param int $clientId
     * @return bool
     */
    static function isPermitted($clientId)
    {
        if ($clientId === $userId) {
            return true;
        }
        return false;
    }
}
