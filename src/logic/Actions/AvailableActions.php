<?php
namespace Htmlacademy\Logic\Actions;


use frontend\models\TaskReplies;
use frontend\models\Tasks;
use frontend\models\Users;
use Htmlacademy\MyExceptions\RoleInvalid;
use Htmlacademy\MyExceptions\ActionInvalid;
use Yii;

class AvailableActions
{
    /**
     * Константы возможных действий
     */
    const ACTION_RESPONSE = ResponseAction::class;
    const ACTION_COMPLETE = CompleteAction::class;
    const ACTION_CANCEL = CancelAction::class;
    const ACTION_REFUSE = RefuseAction::class;
    const ACTION_SUBMIT = SubmitAction::class;

    /**
     * Константы возможных статусов
     */
    const STATUS_NEW = 'new';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';
    const STATUS_IN_PROGRESS = 'in progress';

    /**
     * Константы возможных ролей
     */
    const ROLE_CLIENT = 'client';
    const ROLE_EXECUTIVE = 'executive';


    /**
     * Возвращает список действий
     *
     * @return array $actions
     */
    public static function getActions(): array
    {
        return [self::ACTION_RESPONSE, self::ACTION_COMPLETE, self::ACTION_CANCEL, self::ACTION_REFUSE, self::ACTION_SUBMIT];
    }

    /**
     * Возвращает список статусов
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [self::STATUS_NEW, self::STATUS_COMPLETED, self::STATUS_CANCELLED, self::STATUS_FAILED, self::STATUS_IN_PROGRESS];
    }

    /**
     * Возвращает список ролей
     *
     * @return array
     */
    public static function getRoles(): array
    {
        return [self::ROLE_CLIENT, self::ROLE_EXECUTIVE];
    }

    /**
     * Возвращает статус, в который перейдет задача для указанного действия
     *
     * @param Tasks $task - объект класса Task
     * @param string $actionClassName - название класса действия
     * @return string $statusNew
     * @throws ActionInvalid
     */
    public static function ifAction(Tasks $task, string $actionClassName): string
    {
        if (!in_array($actionClassName, self::getActions())) {
            throw new ActionInvalid();
        }
        $connections = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETED,
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_REFUSE => self::STATUS_FAILED,
            self::ACTION_SUBMIT => self::STATUS_IN_PROGRESS,
            self::ACTION_RESPONSE => $task->status
        ];
        $statusNew = null;
        if (array_key_exists($actionClassName, $connections)) {
            $statusNew = $connections[$actionClassName];
        }
        return $statusNew;
    }

    /**
     *
     * @param Tasks $task - объект задачи
     * @param Users $user
     * @return array $openActions список из названий доступных классов действий
     * @throws RoleInvalid
     */
    public static function getOpenActions(Tasks $task, Users $user): array
    {
        $role = $user->role;
        $userId = $user->id;
        if (!in_array($role, self::getRoles())) {
            throw new RoleInvalid();
        }
        $openActions = [];

        foreach (self::getActions() as $action) {
            if ($action::isPermitted($userId, $task)) {
                $actions[] = $action;
            }
        }

        return $openActions;
    }

    /**
     * @param Tasks $task
     * @param TaskReplies $reply
     * @return bool
     */
    public static function isHiddenSubmitForm(Tasks $task, TaskReplies $reply): bool
    {
        if ($task->client_id === Yii::$app->user->getId() && $reply->status === 'new' && $task->status === 'new') {
            return true;
        }
        return false;

    }
}


