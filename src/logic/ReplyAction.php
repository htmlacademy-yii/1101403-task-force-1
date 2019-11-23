<?php
namespace Htmlacademy\Logic;

class ReplyAction extends AbstractAction
{
    /**
     * Возвращает название класса
     * @return string
     */
    static function getTitle()
    {
        return 'Откликнуться';
    }

    /**
     * Возвращает внутреннее имя класса
     * @return string
     */
    static function getInnerName()
    {
        return 'reply';
    }

    /**
     * Проверяет, разрешено ли действие
     *
     * @param int $executiveId
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
