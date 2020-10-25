<?php
namespace Htmlacademy\Logic\Actions;

use frontend\models\Tasks;

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
     * @param Tasks $task
     * @return bool
     */
    public static function isPermitted(int $userId, Tasks $task): bool
    {
        if ($task->client_id === $userId) {
            return true;
        }
        return false;
    }
}
