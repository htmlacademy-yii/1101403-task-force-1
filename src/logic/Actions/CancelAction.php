<?php
namespace Htmlacademy\Logic\Actions;

class CancelAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    public static function getTitle()
    {
        return 'Отменить';
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    public static function getInnerName()
    {
        return 'cancel';
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