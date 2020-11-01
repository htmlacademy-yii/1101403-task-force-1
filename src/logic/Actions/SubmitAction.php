<?php
namespace Htmlacademy\Logic\Actions;


class SubmitAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    public static function getTitle()
    {
        return 'Назначить';
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    public static function getInnerName()
    {
        return 'submit';
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
        if ($clientId === $userId) {
            return true;
        }
        return false;
    }
}
