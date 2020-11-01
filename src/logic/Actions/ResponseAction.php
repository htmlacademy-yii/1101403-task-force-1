<?php
namespace Htmlacademy\Logic\Actions;


class ResponseAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    public static function getTitle()
    {
        return 'Откликнуться';
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    public static function getInnerName()
    {
        return 'response';
    }

    /**
     * Проверяет, разрешено ли действие
     *
     * @param int $userId
     * @param int $clientId
     * @param int $executiveId
     * @return bool
     */
    public static function isPermitted(int $userId, int $clientId, int $executiveId): bool
    {
        if ($executiveId === $userId) {
            return true;
        }
        return false;
    }
}
