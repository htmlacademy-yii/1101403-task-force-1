<?php
namespace Htmlacademy\Logic\Actions;

class ReplyAction extends AbstractAction
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
     * @param int $executiveId
     * @return bool
     */
    public static function isPermitted(int $userId, int $executiveId)
    {
        if ($executiveId === $userId) {
            return true;
        }
        return false;
    }
}
