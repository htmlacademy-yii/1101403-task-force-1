<?php
namespace Htmlacademy\Logic\Actions;


class CompleteAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    public static function getTitle()
    {
        return 'Завершить';
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    public static function getInnerName()
    {
        return 'complete';
    }

    /**
     * Проверяет, разрешено ли действие
     *
     * @param int $userId
     * @param int $clientId
     * @return bool
     */
    public static function isPermitted(int $userId, int $clientId)
    {
        if ($clientId === $userId) {
            return true;
        }
        return false;
    }
}