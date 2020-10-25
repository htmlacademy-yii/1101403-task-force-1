<?php
namespace Htmlacademy\Logic\Actions;

use frontend\models\Tasks;

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
     * @param Tasks $task
     * @return bool
     */
    public static function isPermitted(int $userId, Tasks $task): bool
    {
        if ($task->executive_id === $userId) {
            return true;
        }
        return false;
    }
}
