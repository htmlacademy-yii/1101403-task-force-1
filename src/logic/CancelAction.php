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
        return 'Отменить';
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
